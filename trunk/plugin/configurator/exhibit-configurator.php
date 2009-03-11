<?php
function show_datapress_html() { 
	if (!$guessurl = site_url())
		$guessurl = wp_guess_url();
	$baseuri = $guessurl;
	$exhibituri = $baseuri . '/wp-content/plugins/datapress';
	
	/* -------------------------------------------------
	 * Load up the exhibit if it exists
	 * ------------------------------------------------- */
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
			<input type="hidden" value="<?php echo $exhibitID ?>" name="exhibitid" />
			<input type="hidden" value="save_exhibit_configuration" name="action" />
			<input id="save_btn" type="button" class="button savebutton" name="save" value="<?php echo attribute_escape( __( 'Save' ) ); ?>" />
			<input id="save_insert_btn" type="button" class="button savebutton" name="save_insert" value="<?php echo attribute_escape( __( 'Save &amp; Insert' ) ); ?>" />
			<input id="save_insert_footnotes_btn" type="button" class="button savebutton" name="save_insert_footnotes" value="<?php echo attribute_escape( __( 'Save &amp; Insert with Footnotes' ) ); ?>" />
		  </p>
		EX ID: <?php echo $exhibitID ?>
	EX ID: <?php echo $_SERVER['REQUEST_URI'] ?>

		</div>
	</div>
	</form>
	<script>
		$(document).ready(function(){
			function postExhibit(e) {
				var paste_exhibit = false;
				var paste_footnotes = false;
				
				if (e.target.name == "save_insert") {
					paste_exhibit = true;
				}
				if (e.target.name == "save_insert_footnotes") {
					paste_exhibit = true;
					paste_footnotes = true;
				}
				jQuery.post("<?php bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php",
				            jQuery("#exhibit-config-form").serialize(),
					        function(data) {
								var win = window.dialogArguments || opener || parent || top;

								win.set_post_exhibit(data);
								
								if (paste_exhibit && paste_footnotes) {
									win.send_to_editor("{{Exhibit}}<br />{{Footnotes}}");
								}
								else if (paste_exhibit) {
									win.send_to_editor("{{Exhibit}}");	
								}
								else {
									win.send_to_editor("");	
								}
							});
							
			}
			
			$('#save_btn').bind("click", postExhibit);
			$('#save_insert_btn').bind("click", postExhibit);
			$('#save_insert_footnotes_btn').bind("click", postExhibit);
			
			remove_callbacks = new Array();
			db = Exhibit.Database.create();
			var category_tabs = jQuery("#exhibit-input-container > ul").tabs();
			ex_load_links();
		});
	</script>
<?php 
}

function show_datapress_configurator() {
	wp_enqueue_script('common');

	wp_enqueue_script('exhibit-api');
	wp_enqueue_script('exhibit-chart');
	wp_enqueue_script('exhibit-time');
	wp_enqueue_script('dp-jquery');
	wp_enqueue_script('dp-jquery-ui');
	wp_enqueue_script('dp-jquery-tabs');
	wp_enqueue_script('dp-tinymce');
	wp_enqueue_script('dp-tinymce-langs');	
	wp_enqueue_script('configurator');	
	
	wp_enqueue_style( 'global' );
	wp_enqueue_style( 'wp-admin' );
	wp_enqueue_style( 'colors' );
	wp_enqueue_style( 'media' );
	wp_enqueue_style('dp-configurator');
	
	echo wp_iframe('show_datapress_html');
	die();
}
?>
