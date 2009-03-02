<?php
if (!$guessurl = site_url())
	$guessurl = wp_guess_url();
$baseuri = $guessurl;
$exhibituri = $baseuri . '/wp-content/plugins/wp-exhibit';
?>
<p><b>A <i>Search Facet</i> lets you search across the text content of your Exhibit data.</b></p>
<form id="facet-search-form">
	<p><i>What do you want to call this search field?</i><br /><input id="facet-label" type="text" size="30" /></p>
	<a href="#" class="addlink" onclick="submit_search_facet(); return false">Add Search Facet</a>
</form>			

<script type="text/JavaScript">

function submit_search_facet() {
	var label = jQuery('#facet-label').val();
	var kind = 'search';
	
	addExhibitElementLink(
		"facet-list", 
		"Search Facet", 
		'facet',
		{
			kind: kind,
			label: label,
			location: "left"
	    },
        <?php echo(WpExhibitFacet::addFieldDisplay()); ?>
	 );	
}

</script>
