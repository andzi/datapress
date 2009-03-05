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
		include('wp-exhibit-admincss.php');
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
    echo "Datapress<a href='" . wp_guess_url() . "/wp-content/plugins/datapress/exhibit-inputbox.php?' class='exhibit_link'><img src='" . wp_guess_url() . "/wp-content/plugins/datapress/images/exhibit-small-RoyalBlue.png'></a>";
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

add_action('media_buttons', array($exhibit, 'make_exhibit_button'));

add_filter('save_post', array($exhibit, 'save_post'));
add_filter('the_content', array($exhibit, 'insert_exhibit'));

register_activation_hook(__FILE__, array($exhibit, 'activate_plugin'));
register_deactivation_hook(__FILE__, array($exhibit, 'deactivate_plugin'));


?>
