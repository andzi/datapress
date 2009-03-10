<?php
	$google_map_api_key = get_option( 'google_map_api_key' );
	global $wp_query;
	$thePostID = $wp_query->post->ID;
	if (!$guessurl = site_url())
    	$guessurl = wp_guess_url();
    $baseuri = $guessurl;
    $exhibituri = $baseuri . '/wp-content/plugins/datapress';

	if (isset($thePostID)) {
		// If a page, this is the page ID.
		// If the main page or a list of posts, this is the TOP post ID.
		// For now we're only concerned with PAGES that contain Exhibits for simplicity.
        include('exhibit_include_placeholders.php');

		$ex_post_exhibit = new WpPostExhibit();
		echo("<!--          * Exhibit Data Source Check *            -->\n");
		if (DbMethods::loadFromDatabase($ex_post_exhibit, $thePostID, 'postid')) {
			if (! $ex_post_exhibit->get('lightbox')) {
				$css = $ex_post_exhibit->get('css');
				if ($css != NULL) {
					?><link rel="stylesheet" href="<?php echo $css ?>" type="text/css" /><?php
				}
				// There is an exhibit for this post
				// Get all the data sources for it
				?>
				<!-- ~~~~~ Begin SIMILE Exhibit Inclusions ~~~~~  -->
				<!--           * Exhibit Javascripts *            -->
				<script src="http://static.simile.mit.edu/exhibit/api-2.0/exhibit-api.js" type="text/javascript"></script>
				<? if ($google_map_api_key != null) { ?>
				<script src="http://static.simile.mit.edu/exhibit/extensions-2.0/map/map-extension.js?gmapkey=<?php echo $google_map_api_key ?>"></script>
				<? } ?>
				<script src="http://static.simile.mit.edu/exhibit/extensions-2.0/time/time-extension.js" type="text/javascript"></script>
			    <script src="http://static.simile.mit.edu/exhibit/extensions-2.0/chart/chart-extension.js" type="text/javascript"></script>
				<?php
				
				echo("<!--          * Exhibit Data Sources *            -->\n");
				$ex_datasources = $ex_post_exhibit->get('datasources');
				foreach($ex_datasources as $ex_datasource) {
					echo("<!--          * Exhibit Data Source *            -->\n");
		    		echo($ex_datasource->htmlContent() . "\n");
				}			
			}
		}
		
	}
?>
<!-- ~~~~~ End SIMILE Exhibit Inclusions  ~~~~~ -->
