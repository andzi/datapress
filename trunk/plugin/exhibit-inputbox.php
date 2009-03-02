<script type="text/javascript">
jQuery(document).ready(function(){
	var category_tabs = jQuery("#exhibit-input-container > ul").tabs();
});

remove_callbacks = new Array();

function addExhibitElementLink(listId, caption, prefix, fields, field_display) {
	var next_id = jQuery('#' + listId + ' > li').size();
	var liid = listId + "_" + next_id;
	var liid_remove = liid + "_remove";
	var opStr = "";
	opStr = opStr + "<li id='" + liid + "'>" + caption + " ";
	jQuery.each(fields, function(key, value) {
	    field_name = prefix + "_" + next_id + "_" + key;
	    if (field_display && (key in field_display)) {
	        opStr = opStr + field_display[key](key, value, field_name);
	    } else {
    		var field = "<input type='hidden' name='" + field_name + "' value='" + value + "' />";
	    	opStr = opStr + field;
	    }
	});
	opStr = opStr + "[ <a href='#' onclick='removeExhibitElementLink(\"" + liid + "\",\"" + liid_remove + "\"); return false;'>remove</a> ]";
	opStr = opStr + "</li>";
	jQuery('#' + listId).append(opStr);
	return liid_remove;
}

function removeExhibitElementLink(liid, liid_remove) {
    jQuery("#" + liid).remove();
    jQuery("#" + liid_remove).remove();
    ex_load_links();
}

function appendToPost(myValue) {
window.tinyMCE.execInstanceCommand("content", "mceInsertContent",true,myValue);
}
function appendToLens(myValue) {
window.tinyMCE.execInstanceCommand("lens-text", "mceInsertContent",true,myValue);
}
</script>

<div id="exhibit-input" class="postbox closed">
	<h3>DataPress</h3>
	<div class="inside">

	  <div id="exhibit-input-container">
		<p>Use the tabs below to configure your data exhibit.</p>
		<ul id="ex-tabs" class="outer-tabs">
			<li class="ui-tabs-selected"><a href="#exhibit-data">Data</a></li>
			<li class="wp-no-js-hidden"><a href="#exhibit-views">Views</a></li>
			<li class="wp-no-js-hidden"><a href="#exhibit-lenses">Lenses</a></li>
			<li class="wp-no-js-hidden"><a href="#exhibit-facets" >Facets</a></li>
    		<li class="wp-no-js-hidden"><a href="#exhibit-display" >Display</a></li>
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
		<a href="#" class="addlink" onClick="appendToPost('{{Exhibit}}'); return false;">Insert Exhibit into Post</a>&nbsp;&nbsp;&nbsp;
		<a href="#" class="addlink"  onClick="appendToPost('{{Footnotes}}'); return false;">Insert Data Footnotes into Post</a>
	  </p>

	</div>
</div>
<script type="text/javascript">
	ex_load_links();
</script>
