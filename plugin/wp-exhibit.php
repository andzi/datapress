<?php
/*
Plugin Name: Datapress
Plugin URI: http://projects.csail.mit.edu/datapress
Description: A Wordpress Plugin for the Exhibit Web Framework
Version: 1.0
Author: The Haystack Group @ MIT
Author URI: http://haystack.csail.mit.edu/
*/

include_once('wp-exhibit-debug.php');
include_once('wp-exhibit-config.php');
include_once('wp-exhibit-admin-options.php');
include_once('wp-exhibit-activation-tools.php');
include_once('wp-exhibit-insert-exhibit.php');
include_once('model/wp-exhibit-model.php');
include_once('facet_widget.php');
include_once('proxy/insert-parrotable-url.php');	
include_once('configurator/exhibit-configurator.php');

class WpExhibit {
 	var $wp_version;
   
	function WpExhibit() {
		global $wp_version;
		$this->wp_version = $wp_version;
	}
	
	/*
	 * Only include if the number of posts == 1 and it has an exhibit
	 * on the page. Else just include the other stuff
	 */
	function exhibit_include() {
		global $wp_query;
		if ((sizeof($wp_query->posts) == 1) && ($wp_query->posts[0]->datapress_exhibit != nil)) {
			include('exhibit_include.php');
		}		
		else {
			include('exhibit_include_placeholders.php');			
		}
	}
	
	function exhibit_admin_include() {
		include('exhibit_admin_include.php');		
	}

	function add_options_page() {
		add_options_page('Datapress', 'Datapress', 8, 'exhibitoptions', 'exhibit_options_page');		
	}
	
	function edit_page_inclusions() {
		include('exhibit-inputbox.php');
	}
	
	function save_post() {
		include('wp-exhibit-save-post.php');
	}
		
	function activate_plugin() {
        WpExhibitActivationTools::activate_plugin();
	}
	
	function deactivate_plugin() {
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

  function make_exhibit_button() {
	echo "Datapress <a href='" . wp_guess_url() . "/wp-admin/admin-ajax.php?action=datapress_configurator&TB_iframe=true' id='add_exhibit' class='thickbox' title='Add an Exhibit'><img src='" . wp_guess_url() . "/wp-content/plugins/datapress/images/exhibit-small-RoyalBlue.png' alt='Add an Image' /></a> &nbsp; &nbsp;";
    // echo "Datapress<a href='" . wp_guess_url() . "/wp-content/plugins/datapress/configurator/exhibit-inputbox.php?iframe=true' class='exhibit_link'><img src=''></a>";
 }

	function insert_exhibit($content) {
		global $wp_query;
		if ($wp_query->post->datapress_exhibit != nil) {
			if (sizeof($wp_query->posts) > 1) {
				// Just display a callout about the exhibit.
				return WpExhibitHtmlBuilder::insert_exhibit_lightbox($wp_query->post->datapress_exhibit, $content);			
			}
			else {
				// Display the exhibit
				return WpExhibitHtmlBuilder::insert_exhibit($wp_query->post->datapress_exhibit, $content);			
			}
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
add_action('wp_ajax_datapress_configurator', 'show_datapress_configurator' );

add_action('media_buttons', array($exhibit, 'make_exhibit_button'));

add_filter('save_post', array($exhibit, 'save_post'));
add_filter('the_content', array($exhibit, 'insert_exhibit'));

register_activation_hook(__FILE__, array($exhibit, 'activate_plugin'));
register_deactivation_hook(__FILE__, array($exhibit, 'deactivate_plugin'));


/* ---------------------------------------------------------------------------
 * JavaScript Registration
 * --------------------------------------------------------------------------- */

if (!$guessurl = site_url())
	$guessurl = wp_guess_url();
$baseuri = $guessurl;

wp_register_script( 'exhibit-api', 'http://static.simile.mit.edu/exhibit/api-2.0/exhibit-api.js', array(  ) );
wp_register_script( 'exhibit-chart', 'http://static.simile.mit.edu/exhibit/extensions-2.0/chart/chart-extension.js', array( 'exhibit-api' ) );
wp_register_script( 'exhibit-time', 'http://static.simile.mit.edu/exhibit/extensions-2.0/time/time-extension.js', array( 'exhibit-api' ) );

wp_register_script( 'dp-jquery', "$baseuri/wp-includes/js/jquery/jquery.js?ver=1.2.6", array() );
wp_register_script( 'dp-jquery-ui', "$baseuri/wp-includes/js/jquery/ui.core.js?ver=1.5.2", array('dp-jquery') );
wp_register_script( 'dp-jquery-tabs', "$baseuri/wp-includes/js/jquery/ui.tabs.js?ver=1.5.2", array('dp-jquery-ui') );
wp_register_script( 'dp-tinymce', "$baseuri/wp-includes/js/tinymce/tiny_mce.js?ver=20081129", array() );
wp_register_script( 'dp-tinymce-langs', "$baseuri/wp-includes/js/tinymce/langs/wp-langs-en.js?ver=20081129", array('dp-tinymce') );

wp_register_script( 'configurator', "$baseuri/wp-content/plugins/datapress/configurator/configurator.js");
wp_register_script( 'configurator-loaded', "$baseuri/wp-content/plugins/datapress/configurator/configurator.js", array( 'configurator' ) );


/* ---------------------------------------------------------------------------
 * Stylesheet Registration
 * --------------------------------------------------------------------------- */

wp_register_style( 'dp-configurator', "$baseuri/wp-content/plugins/datapress/css/wpexhibit.css");

?>
