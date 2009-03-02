<?php
if (!$guessurl = site_url())
	$guessurl = wp_guess_url();
$baseuri = $guessurl;
$exhibituri = $baseuri . '/wp-content/plugins/wp-exhibit';
?>
<p><b>A <i>List Facet</i> lets you browse through buckets of items in you Exhibit data.</b></p>
<form id="facet-search-form">
<p><i>What do you want to call this facet view?</i><br /><input id="list-facet-label" type="text" size="30" /></p>
<p><i>What field do you want to narrow down items from?</i><br /><select id="list-facet-field" class="allpropbox"></select></p>
<a href="#" class="addlink" onclick="submit_list_facet(); return false">Add List Facet</a>
</form>			

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
