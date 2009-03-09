<?php
/* This is the contents of the Exhibit Creation Lightbox.
 *
 * Only one GET variable will ever be passed into this file, and this is the ID
 * of the Exhibit-in-progress to continue editing. If this variable is not present, 
 * then begin a new exhibit. If this variable is present, then load the existing exhibit.
 *
 * TODO:
 *  - Protect so that only admins can load this page
 *  - Load an existing exhibit if ID is present.
 *  - Create save button which posts exhibit, receives the exhibit id, and transmits 
 *      exhibit id back to root page.
 *  - Cancel button, which gets the hell out!
 */


/* -------------------------------------------------
 * Load up Wordpress
 * -------------------------------------------------
 */
	ob_start();
    $root = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
      if (file_exists($root.'/wp-load.php')) {
          // WP 2.6
          require_once($root.'/wp-load.php');
      } else {
          // Before 2.6
          require_once($root.'/wp-config.php');
      }
	ob_end_clean(); //Ensure we don't have output from other plugins.
	header('Content-Type: text/html; charset='.get_option('blog_charset'));
	$google_map_api_key = get_option( 'google_map_api_key' );

	if (!$guessurl = site_url())
		$guessurl = wp_guess_url();
	$baseuri = $guessurl;
	$exhibituri = $baseuri . '/wp-content/plugins/datapress';

/* -------------------------------------------------
 * Load up the exhibit if it exists
 * -------------------------------------------------
 */

$exhibitID = $_GET['exhibitid'];
$exhibitConfig = NULL;
if ($exhibitID != NULL) {
	// See if we know about any data sources associated with this item.
	$exhibitConfig = new WpPostExhibit();
	$ex_success = DbMethods::loadFromDatabase($exhibitConfig, $exhibitID);
	if (! $ex_success) {
		$exhibitConfig = NULL;
	}
}

?>
<html>
	<head>

	<script type='text/javascript' src='<?php echo $baseuri ?>/wp-includes/js/jquery/jquery.js?ver=1.2.6'></script>
	<script type='text/javascript' src='<?php echo $baseuri ?>/wp-includes/js/jquery/ui.core.js?ver=1.5.2'></script>
	<script type='text/javascript' src='<?php echo $baseuri ?>/wp-includes/js/jquery/ui.tabs.js?ver=1.5.2'></script>
	<script type="text/javascript" src="<?php echo $baseuri ?>/wp-includes/js/tinymce/tiny_mce.js?ver=20081129"></script>
	<script type="text/javascript" src="<?php echo $baseuri ?>/wp-includes/js/tinymce/langs/wp-langs-en.js?ver=20081129"></script>

	
	<link rel='stylesheet' href='<?php echo $baseuri ?>/wp-admin/wp-admin.css?ver=20081210' type='text/css' media='all' />
	<link rel='stylesheet' href='<?php echo $baseuri ?>/wp-admin/css/colors-fresh.css?ver=20081210' type='text/css' media='all' />
	<link rel="stylesheet" type="text/css" href="<?php echo $exhibituri ?>/css/wpexhibit.css"></link>

	<script type="text/javascript" src="<?php echo $exhibituri ?>/configurator/configurator.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			var category_tabs = jQuery("#exhibit-input-container > ul").tabs();
			ex_load_links();
		});

		remove_callbacks = new Array();
		// This is the database for adding items
		db = Exhibit.Database.create();
	</script>
	
	<script type="text/javascript">
	    function postExhibit() {
	        jQuery.post("<?php echo $exhibituri ?>/save-exhibit.php", jQuery("#exhibit-config-form").serialize(),
                        function(data) {
                            alert("Data Loaded: " + data);
                        });
        }
	</script>

	<script type="text/javascript">
	function ex_add_head_link(uri, kind, remove_id) {
	    var link = "";
    	if (kind == "google-spreadsheet") {
		var link = SimileAjax.jQuery('<link id = "' + remove_id + '" rel="exhibit/data" type="application/jsonp" href="' + uri + '" ex:converter="googleSpreadsheets" />');
	}
	else if (kind == "application/json") {
		var link = SimileAjax.jQuery('<link id = "' + remove_id + '" rel="exhibit/data" type="application/json" href="<?php echo $exhibituri ?>/proxy/parrot.php?url=' + uri + '" />');
	}

	    SimileAjax.jQuery('head').append(link);
    }
    </script>
</head>
<body>


<form id="exhibit-config-form">
<div id="exhibit-input">
	<div class="inside">
	  <div id="exhibit-input-container">
		
		<ul id="ex-tabs" class="outer-tabs">
			<li class="ui-tabs-selected"><a href="#exhibit-data">Add Data</a></li>
			<li>&gt;</li>
			<li class="wp-no-js-hidden"><a href="#exhibit-views">Add Visualizations</a></li>
			<li>&gt;</li>
			<li class="wp-no-js-hidden"><a href="#exhibit-facets" >Add Facets</a></li>
			<li>&gt;</li>
    		<li class="wp-no-js-hidden"><a href="#exhibit-display" >Configure Display</a></li>
			<li>&gt;</li>
			<li class="wp-no-js-hidden" ><a href="#exhibit-lenses">Lenses (Advanced)</a></li>
		</ul>
		
		<div id="exhibit-data" class="outer-tabs-panel">
			<?php include("exhibit-inputbox-data.php") ?>
		</div>
		<div id="exhibit-views" class="outer-tabs-panel" style="display: none;">
			<?php include("exhibit-inputbox-views.php") ?>
		</div>
		<div id="exhibit-lenses" class="outer-tabs-panel" style="display: none;">
			<?php include("exhibit-inputbox-lenses.php") ?>
		</div>
		<div id="exhibit-facets" class="outer-tabs-panel" style="display: none;">
			<?php include("exhibit-inputbox-facets.php") ?>
		</div>
		<div id="exhibit-display" class="outer-tabs-panel" style="display: none;">
			<?php include("exhibit-inputbox-display.php") ?>
		</div>
	  </div>

	  <p align="right">
		<input type="submit" class="button savebutton" name="save" value="<?php echo attribute_escape( __( 'Save' ) ); ?>" />
		<input type="submit" class="button savebutton" name="save_insert" value="<?php echo attribute_escape( __( 'Save &amp; Insert' ) ); ?>" />
		<input type="submit" class="button savebutton" name="save_insert_footnotes" value="<?php echo attribute_escape( __( 'Save &amp; Insert with Footnotes' ) ); ?>" />
	  </p>
	</div>
</div>
<input type="hidden" value="<?php echo $exhibitID ?>" name="exhibitid" />
<input type="button" value="Save Exhibit" onclick="javascript: postExhibit(); return false;" />
</form>

<script type="text/javascript">
	var saved_exhibit_id = "TEST ID";
	send_to_editor(saved_exhibit_id);
</script>

</html>
