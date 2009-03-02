<div class="outer-tabs-panel-header">
<p style="font-size: 1.2em;"><b>A <i>view</i> displays your data.</b></p>
<p><b>Current Views</b></p>
<div class="current">
<ul id="views-list">
</ul>
<?php
	$postID = $_GET['post'];
	if ($postID != NULL) {
		// See if we know about any data sources associated with this item.
		$ex_exhibit = new WpPostExhibit();
		$ex_success = DbMethods::loadFromDatabase($ex_exhibit, $postID, 'postid');
		if ($ex_success == true) {
			echo '<script type="text/javascript">';
	        $views = $ex_exhibit->get('views');
	        foreach ($views as $view) {
				echo $view->getAddLink('views-list');
	        }
			echo '</script>';				
		}
	}
?>
</div>
</div>
<div id="exhibit-views-tabs">
	<ul id="ex-view-tabs-list" class="inner-tabs">
		<li class="ui-tabs-selected"><a href="#exhibit-views-list" >List</a></li>
		<li class="wp-no-js-hidden"><a href="#exhibit-views-table" >Table</a></li>
		<li class="wp-no-js-hidden"><a href="#exhibit-views-maps" >Map</a></li>
		<li class="wp-no-js-hidden"><a href="#exhibit-views-timeline" >Timeline</a></li>
		<li class="wp-no-js-hidden"><a href="#exhibit-views-scatter" >Scatter Plot</a></li>
		<li class="wp-no-js-hidden"><a href="#exhibit-views-bar" >Bar Chart</a></li>
	</ul>
	<div id="exhibit-views-list" class="inner-tabs-panel"><?php include('exhibit-inputbox-view-list.php'); ?></div>
	<div id="exhibit-views-table" class="inner-tabs-panel"><?php include('exhibit-inputbox-view-table.php'); ?></div>
	<div id="exhibit-views-maps" class="inner-tabs-panel" style="display: none;"><?php include('exhibit-inputbox-view-map.php'); ?></div>
	<div id="exhibit-views-timeline" class="inner-tabs-panel" style="display: none;"><?php include('exhibit-inputbox-view-timeline.php'); ?></div>
	<div id="exhibit-views-scatter" class="inner-tabs-panel" style="display: none;"><?php include('exhibit-inputbox-view-scatter.php'); ?></div>
	<div id="exhibit-views-bar" class="inner-tabs-panel" style="display: none;"><?php include('exhibit-inputbox-view-bar.php'); ?></div>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	var datasource_tabs = jQuery("#exhibit-views-tabs > ul").tabs();
});
</script>
