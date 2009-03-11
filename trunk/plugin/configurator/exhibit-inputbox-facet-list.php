<?php
if (!$guessurl = site_url())
	$guessurl = wp_guess_url();
$baseuri = $guessurl;
$exhibituri = $baseuri . '/wp-content/plugins/datapress';
?>
<p><b>A <i>List Facet</i> lets you browse through buckets of items in you Exhibit data.</b></p>
<table>
	<tr><td><i>Facet Title</i></td><td><input id="list-facet-label" type="text" size="30" /></td></tr>
	<tr><td><i>Use Field</i></td><td><select id="list-facet-field" class="allpropbox"></select></td></tr>
</table>
<p align="right"><a href="#" class="addlink" onclick="submit_list_facet(); return false">Add List Facet</a></p>

<script type="text/JavaScript">
function submit_list_facet() {
	var label = jQuery('#list-facet-label').val();
	var kind = 'browse';
	var field = jQuery('#list-facet-field').val();
	
	addExhibitElementLink(
		"facet-list", 
		"List Facet (" + field + ")", 
		'facet',
		{
			kind: kind,
			label: label,
			field: field,
			location: "left"
	    },
        <?php echo(WpExhibitFacet::addFieldDisplay()); ?>
	);	
}
</script>
