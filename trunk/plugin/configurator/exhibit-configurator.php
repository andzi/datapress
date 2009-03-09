<?php
function show_datapress_html() { 
?>
	<form action="<?php echo $exhibituri ?>/save-exhibit.php">
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
	<input type="submit" value="Save Exhibit" />
	</form>

<?php 
}

function show_datapress_configurator() {
	$errors = array();
	$id = 0;
	
	wp_enqueue_script('exhibit-api');
	wp_enqueue_script('exhibit-chart');
	wp_enqueue_script('exhibit-time');
	wp_enqueue_script('dp-jquery');
	wp_enqueue_script('dp-jquery-ui');
	wp_enqueue_script('dp-jquery-tabs');
	wp_enqueue_script('dp-tinymce');
	wp_enqueue_script('dp-tinymce-langs');	
	wp_enqueue_script('configurator');	
	wp_enqueue_script('configurator-loaded');	
	
	wp_enqueue_style( 'global' );
	wp_enqueue_style( 'wp-admin' );
	wp_enqueue_style( 'colors' );
	wp_enqueue_style( 'media' );
	wp_enqueue_style('dp-configurator');
	
	echo wp_iframe( 'show_datapress_html', 'exhibit', $errors, $id );
}
?>