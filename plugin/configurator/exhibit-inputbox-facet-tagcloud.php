<?php
if (!$guessurl = site_url())
	$guessurl = wp_guess_url();
$baseuri = $guessurl;
$exhibituri = $baseuri . '/wp-content/plugins/datapress';
?>
<p><b>A <i>Tag Cloud Facet</i> lets you browse through buckets of items in you
Exhibit data, displaying those buckets as a cloud of words.</b></p>
<form id="facet-search-form">
<p><i>What do you want to call this facet view?</i><br /><input id="tagcloud-facet-label" type="text" size="30" /></p>
<p><i>What field do you want to narrow down items from?</i><br /><select id="tagcloud-facet-field" class="allpropbox"></select></p>
<a href="#" class="addlink" onclick="submit_tagcloud_facet(); return false">Add Tag Cloud Facet</a>
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
