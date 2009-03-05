<?php
	ob_start();
      $root = dirname(dirname(dirname(dirname(__FILE__))));
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
	$exhibitid = $_GET['id']
?>
<?php
	$exhibitid = $_GET['id'];
	$ex_post_exhibit = new WpPostExhibit();
	if (DbMethods::loadFromDatabase($ex_post_exhibit, $exhibitid)) {
		?>
			<html>
			<head>

			<style type="text/css" media="screen" src="exhibit.css"></style>
			<!-- ~~~~~ Begin SIMILE Exhibit Inclusions ~~~~~  -->
			<!--           * Exhibit Javascripts *            -->
			<script src="http://static.simile.mit.edu/exhibit/api-2.0/exhibit-api.js" type="text/javascript"></script>
		    <script src="http://static.simile.mit.edu/exhibit/extensions-2.0/chart/chart-extension.js" type="text/javascript"></script>
			<script src="http://static.simile.mit.edu/exhibit/extensions-2.0/time/time-extension.js" type="text/javascript"></script>
			<script src="<?php echo $exhibituri ?>/js/jquery-1.2.6.min.js" type="text/javascript"></script>

			<? if ($google_map_api_key != null) { ?>
			<script src="http://static.simile.mit.edu/exhibit/extensions-2.0/map/map-extension.js?gmapkey=<?php echo $google_map_api_key ?>"></script>
			<? } ?>
			
			<script type='text/javascript' src='<?php echo $baseuri ?>/wp-includes/js/jquery/ui.tabs.js?ver=1.5.1'></script>
			
			
			<?
			$css = $ex_post_exhibit->get('css');
			if ($css != NULL) {
				?><link rel="stylesheet" href="<?php echo $css ?>" type="text/css" /><?php
			}
			?>
			<?php
			$ex_datasources = $ex_post_exhibit->get('datasources');
			foreach($ex_datasources as $ex_datasource) {
				echo("<!--          * Exhibit Data Source *            -->\n");
	    		echo($ex_datasource->htmlContent() . "\n");
			}
			?>
			</head>
			<body>
			<?php echo(WpExhibitHtmlBuilder::get_exhibit_html($ex_post_exhibit)); ?>
			</body>
			</html>
			<?php
	}
	else {
		echo("<h3>Error: Could not locate Exhibit</h3>");
	}
?>