<?php
if (!$guessurl = site_url())
	$guessurl = wp_guess_url();
$baseuri = $guessurl;
$exhibituri = $baseuri . '/wp-content/plugins/datapress';
?>
<p><b>A <i>Search Facet</i> lets you search across the text content of your Exhibit data.</b></p>

<table>
	<tr><td><i>Facet Title</i></td><td><input id="exhibit-facet-search-label" type="text" size="30" /></td></tr>
</table>
	<p align="right"><a href="#" class="addlink" onclick="submit_search_facet(); return false">Add Search Facet</a></p>

<script type="text/JavaScript">

function submit_search_facet() {
	var label = jQuery('#exhibit-facet-search-label').val();
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
        <?php echo(WpExhibitFacet::addFieldDisplay()); ?>,
        {
            editable: true,
            tabid: "exhibit-facet-search"
        }
	 );	
}

</script>
