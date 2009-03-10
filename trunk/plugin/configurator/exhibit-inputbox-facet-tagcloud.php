<?php
if (!$guessurl = site_url())
	$guessurl = wp_guess_url();
$baseuri = $guessurl;
$exhibituri = $baseuri . '/wp-content/plugins/datapress';
?>
<p><b>A <i>Tag Cloud Facet</i> lets you browse through buckets of items in you
Exhibit data, displaying those buckets as a cloud of words.</b></p>
<form id="facet-search-form">
<table>
<tr><td><i>Facet Title</i></td><td><input id="tagcloud-facet-label" type="text" size="30" /></td></tr>
<tr><td><i>Use field</i></td><td><select id="tagcloud-facet-field" class="allpropbox"></select></td></tr>
</table>

<p align="right"><a href="#" class="addlink" onclick="submit_tagcloud_facet(); return false">Add Tag Cloud Facet</a></p>

</form>			

<script type="text/JavaScript">
function submit_tagcloud_facet() {
	var label = jQuery('#tagcloud-facet-label').val();
	var kind = 'tagcloud';
	var field = jQuery('#tagcloud-facet-field').val();
	
	addExhibitElementLink(
		"facet-list", 
		"Tag Cloud Facet (" + field + ")", 
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
