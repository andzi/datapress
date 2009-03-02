<div class="outer-tabs-panel-header">
<p style="font-size: 1.2em;"><b>A <i>facet</i> lets users sort through your data.</b></p>
<p><b>Current Facets</b></p>
<div class="current">
<ul id="facet-list">
</ul>
<?php
	$postID = $_GET['post'];
	if ($postID != NULL) {
		// See if we know about any data sources associated with this item.
		$ex_exhibit = new WpPostExhibit();
		$ex_success = DbMethods::loadFromDatabase($ex_exhibit, $postID, 'postid');
		if ($ex_success == true) {
			echo '<script type="text/javascript">';
	        $facets = $ex_exhibit->get('facets');
	        foreach ($facets as $facet) {
				echo $facet->getAddLink('facet-list');
	        }
			echo '</script>';				
		}
	}
?>
</div>
</div>
<div id="exhibit-facet-tabs">
	<ul id="ex-facet-tabs-list" class="inner-tabs">
		<li class="ui-tabs-selected"><a href="#exhibit-facet-search">Search Box</a></li>
		<li class="wp-no-js-hidden"><a href="#exhibit-facet-list" >List Browser</a></li>
    	<li class="wp-no-js-hidden"><a href="#exhibit-facet-tagcloud" >Tag Cloud</a></li>
	</ul>
	<div id="exhibit-facet-search" class="inner-tabs-panel"><?php include("exhibit-inputbox-facet-search.php") ?></div>
	<div id="exhibit-facet-list" class="inner-tabs-panel" style="display: none;"><?php include("exhibit-inputbox-facet-list.php") ?></div>
	<div id="exhibit-facet-tagcloud" class="inner-tabs-panel" style="display: none;"><?php include("exhibit-inputbox-facet-tagcloud.php") ?></div>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	var datasource_tabs = jQuery("#exhibit-facet-tabs > ul").tabs();
});
</script>
