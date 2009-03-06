
<div class="outer-tabs-panel-header">
<p style="font-size: 1.2em;"><b>Add <i>data sources</i> to fill your Exhibit with content.</b></p>
<p><b>Current Data Sources</b> [ <a href="#" onClick="ex_load_links(); return false;">Refresh Data</a> ]</p>
<div class="current">
<ul id="data-source-list">
	<?php
		if ($exhibitConfig != NULL) {
			$ex_dataSources = $exhibitConfig->get('datasources');
			echo '<script type="text/javascript">';
			foreach ($ex_dataSources as $ex_dataSource) {
				echo 'var remove_id = ' . $ex_dataSource->getAddLink('data-source-list');
				echo("ex_add_head_link('" . $ex_dataSource->get('uri') . "', '" . $ex_dataSource->get('kind') . "', remove_id);");
			}
			echo '</script>';				
		}
	?>		
</ul>
</div>
</div>

<div id="exhibit-datasource-tabs">
	<ul id="ex-datasource-tabs-list" class="inner-tabs">
<!--		<li class="ui-tabs-selected"><a href="#exhibit-datasource-upload" >Import Data</a></li> -->
		<li class="ui-tabs-selected"><a href="#exhibit-datasource-link" >Link to Data</a></li>
<!--		<li class="ui-tabs-selected"><a href="#exhibit-datasource-enter" >Create/Edit Data</a></li> -->
	</ul>
<!--	<div id="exhibit-datasource-upload" class="inner-tabs-panel" style="display: none;"><?php include("exhibit-inputbox-data-upload.php") ?></div> -->
<!--	<div id="exhibit-datasource-enter" class="inner-tabs-panel" style="display: none;"><?php include("exhibit-inputbox-data-enter.php") ?></div> -->
	<div id="exhibit-datasource-link" class="inner-tabs-panel" style="display: none;"><?php include("exhibit-inputbox-data-link.php") ?></div>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	var datasource_tabs = jQuery("#exhibit-datasource-tabs > ul").tabs();
});
</script>
