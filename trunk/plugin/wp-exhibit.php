<?php
/*
Plugin Name: Datapress
Plugin URI: http://projects.csail.mit.edu/datapress
Description: A Wordpress Plugin for the Exhibit Web Framework
Version: 1.0
Author: The Haystack Group @ MIT
Author URI: http://haystack.csail.mit.edu/
*/

include_once('wp-exhibit-config.php');
include_once('wp-exhibit-admin-options.php');
include_once('wp-exhibit-activation-tools.php');
include_once('wp-exhibit-insert-exhibit.php');
include_once('wp-exhibit-save-post.php');
include_once('save-exhibit.php');
include_once('model/wp-exhibit-model.php');
include_once('proxy/insert-parrotable-url.php');	
include_once('configurator/exhibit-configurator.php');

class WpExhibit {
 	var $wp_version;
	var $exhibit_from_admin_page;
	
	function WpExhibit() {
		global $wp_version;
		$this->wp_version = $wp_version;
	}

	function exhibit_admin_include() {
		include('exhibit_admin_include.php');		
	}
	
	/*
	 * Only include if the number of posts == 1 and it has an exhibit
	 * on the page. Else just include the other stuff
	 */
	function exhibit_include() {
        include('head.php');
	}
	
	function get_current_exhibit_from_admin_page() {
		// Returned cached version of the exhibit, or cached NULL:
		// NULL -> we have yet to check for exhibit
		// 0    -> we checked for exhibit, it wasn't there (this is a cached NULL)
		// else -> we found the exhibit
		
		if (isset($this->exhibit_from_admin_page) && ($this->exhibit_from_admin_page != null) && (! is_int($this->exhibit_from_admin_page)) ) {
			return $this->exhibit_from_admin_page;
		}
		else if (isset($this->exhibit_from_admin_page) && (is_int($this->exhibit_from_admin_page)) ) {
			return NULL; // cached null
		}
		
		$postID = $_GET['post'];
		if ($postID != NULL) {
			// See if we know about any data sources associated with this item.
		    $ex_exhibit = new WpPostExhibit();
		    $ex_success = DbMethods::loadFromDatabase($ex_exhibit, $postID, 'postid');
			if ($ex_success) {
				$this->exhibit_from_admin_page = $ex_exhibit;
				return $ex_exhibit;
			}
		}
		$this->exhibit_from_admin_page = 0;
		return NULL;		
	}

	function add_options_page() {
		add_options_page('Datapress', 'Datapress', 8, 'datapressoptions', 'exhibit_options_page');		
	}
	
	function edit_page_inclusions() {
		$ex = $this->get_current_exhibit_from_admin_page();
		if ($ex == NULL) {
			echo "<input type='hidden' id='exhibitid' name='exhibitid' value='' />";
		}
		else {
			$ex_id = $ex->get('id');
			echo "<input type='hidden' id='exhibitid' name='exhibitid' value='$ex_id' />";
		}
	}
	
	function save_post() {
		SaveExhibitPost::save();
	}
	
	function privacy_notice() {
		if (! get_option('datapress_privacy_notice_shown')) {
 			echo "<div id='datapress-privacy-notice' class='updated fade' style='font-size: bigger; border: 3px solid #FF9999;'><p style='font-size: 1.2em'><strong>Thank you for installing DataPress!</strong></p><p style='font-size: 1.2em'>DataPress collects some basic statistics about its use to aid in a research project analyzing data publishing on the web. To <em>turn off</em> this data collection, simply visit the <a href='options-general.php?page=datapressoptions'>DataPress Settings Page</a>.</p></div>";			
			add_option('datapress_privacy_notice_shown', '1');
		}
	}	
		
	function activate_plugin() {
        WpExhibitActivationTools::activate_plugin();
	}
	
	function deactivate_plugin() {
		delete_option('datapress_privacy_notice_shown');
        WpExhibitActivationTools::deactivate_plugin();
	}
	
	function load_exhibit() {
		global $wp_query;
		foreach ($wp_query->posts as $apost) {
			$apost->datapress_exhibit = WpExhibitHtmlBuilder::get_associated_exhibit($apost->ID);
		}		
	}
	
	function insert_parrotable_url() {
        InsertParrotableUrl::insert_url();
	    die;
	}
	
	function save_exhibit_configuration() {
        SaveExhibitConfiguration::save();
	    die;
	}

  function make_exhibit_button() {
	$ex = $this->get_current_exhibit_from_admin_page();
	if ($ex == NULL) {
		echo "Datapress <a id='load_datapress_config_link' href='" . wp_guess_url() . "/wp-admin/admin-ajax.php?action=datapress_configurator&TB_iframe=true' id='add_exhibit' class='thickbox' title='Add an Exhibit'><img src='" . wp_guess_url() . "/wp-content/plugins/datapress/images/exhibit-small-RoyalBlue.png' alt='Add an Image' /></a> &nbsp; &nbsp;";		
	}
	else {
		$ex_id = $ex->get('id');
		echo "Datapress <a id='load_datapress_config_link' href='" . wp_guess_url() . "/wp-admin/admin-ajax.php?action=datapress_configurator&exhibitid=$ex_id&TB_iframe=true' id='add_exhibit' class='thickbox' title='Add an Exhibit'><img src='" . wp_guess_url() . "/wp-content/plugins/datapress/images/exhibit-small-RoyalBlue.png' alt='Add an Image' /></a> &nbsp; &nbsp;";				
	}
 }

	function insert_exhibit($content) {
		global $wp_query;
		if ($wp_query->post->datapress_exhibit != NULL) {
			if (sizeof($wp_query->posts) > 1) {
				// Just display a callout about the exhibit.
				return WpExhibitHtmlBuilder::insert_exhibit_lightbox($wp_query->post->datapress_exhibit, $content);			
			}
			else {
				// Display the exhibit
				return WpExhibitHtmlBuilder::insert_exhibit($wp_query->post->datapress_exhibit, $content);			
			}
		}
		else {
			return $content;
		}
	}
}

$exhibit = new WpExhibit();

add_action('wp_head', array($exhibit, 'exhibit_include'));
add_action('admin_head', array($exhibit, 'exhibit_admin_include'));
add_action('admin_menu', array($exhibit, 'add_options_page'));

#
# Old lozenge interface.
# add_action('edit_page_form', array($exhibit, 'edit_page_inclusions'));
# add_action('edit_form_advanced', array($exhibit, 'edit_page_inclusions'));
#

add_action('wp', array($exhibit, 'load_exhibit'));
add_action('wp_ajax_insert_parrotable_url', array($exhibit, 'insert_parrotable_url') );
add_action('wp_ajax_save_exhibit_configuration', array($exhibit, 'save_exhibit_configuration') );
add_action('wp_ajax_datapress_configurator', 'show_datapress_configurator' );
add_action('media_buttons', array($exhibit, 'make_exhibit_button'));
add_filter('the_content', array($exhibit, 'insert_exhibit'));
add_action('edit_page_form', array($exhibit, 'edit_page_inclusions'));
add_action('edit_form_advanced', array($exhibit, 'edit_page_inclusions'));
add_action('admin_notices', array($exhibit, 'privacy_notice'));

add_filter('save_post', array($exhibit, 'save_post'));

register_activation_hook(__FILE__, array($exhibit, 'activate_plugin'));
register_deactivation_hook(__FILE__, array($exhibit, 'deactivate_plugin'));



/* ---------------------------------------------------------------------------
 * JavaScript Registration
 * --------------------------------------------------------------------------- */

if (!$guessurl = site_url())
	$guessurl = wp_guess_url();
$baseuri = $guessurl;


wp_register_script( 'exhibit-api', 'http://api.simile-widgets.org/exhibit/2.2.0/exhibit-api.js', array(  ) );
wp_register_script( 'exhibit-chart', 'http://api.simile-widgets.org/exhibit/2.2.0/extensions/chart/chart-extension.js', array( 'exhibit-api' ) );
wp_register_script( 'exhibit-time', 'http://api.simile-widgets.org/exhibit/2.2.0/extensions/time/time-extension.js', array( 'exhibit-api' ) );

wp_register_script( 'dp-jquery', "$baseuri/wp-includes/js/jquery/jquery.js?ver=1.2.6", array() );
wp_register_script( 'dp-jquery-ui', "$baseuri/wp-includes/js/jquery/ui.core.js?ver=1.5.2", array('dp-jquery') );
wp_register_script( 'dp-jquery-tabs', "$baseuri/wp-includes/js/jquery/ui.tabs.js?ver=1.5.2", array('dp-jquery-ui') );
wp_register_script( 'dp-tinymce', "$baseuri/wp-includes/js/tinymce/tiny_mce.js?ver=20081129", array() );
wp_register_script( 'dp-tinymce-langs', "$baseuri/wp-includes/js/tinymce/langs/wp-langs-en.js?ver=20081129", array('dp-tinymce') );
wp_register_script( 'base64', "$baseuri/wp-content/plugins/datapress/js/jquery.base64.js", array() );
wp_register_script( 'configurator', "$baseuri/wp-content/plugins/datapress/configurator/configurator.js.php");


/* ---------------------------------------------------------------------------
 * Stylesheet Registration
 * --------------------------------------------------------------------------- */

wp_register_style( 'dp-configurator', "$baseuri/wp-content/plugins/datapress/css/wpexhibit.css");


include_once('facet_widget.php');

?>
