<?php
if (!$guessurl = site_url())
	$guessurl = wp_guess_url();
$baseuri = $guessurl;
$exhibituri = $baseuri . '/wp-content/plugins/datapress';
?>
<p><b>A <i>Tag Cloud Facet</i> lets you browse through buckets of items in you
Exhibit data, displaying those buckets as a cloud of words.</b></p>

<table>
<tr>
    <td><i>Facet Title</i></td>
    <td><input id="exhibit-facet-tagcloud-label" type="text" size="30" /></td>
    <td></td>
</tr>
<tr>
    <td><i>Use field</i></td>
    <td><select id="exhibit-facet-tagcloud-field" class="allpropbox"></select></td>
    <td></td>
</tr>
<tr>
    <td><i>Only filter items of type</i></td>
    <td><select id="exhibit-facet-tagcloud-klass" class="alltypebox"></select></td>
    <td>(Optional)</td>
</tr>
</table>

<p align="right"><a href="#" class="addlink" onclick="submit_tagcloud_facet(); return false">Add Tag Cloud Facet</a></p>

<script type="text/JavaScript">
function submit_tagcloud_facet() {
	var label = jQuery('#exhibit-facet-tagcloud-label').val();
	var kind = 'tagcloud';
	var field = jQuery('#exhibit-facet-tagcloud-field').val();
	var klass = jQuery('#exhibit-facet-tagcloud-klass').val();
	
	var params = 	{
			kind: kind,
			label: label,
			field: field,
			location: "left"
	};
	
	if (klass != null) {
		params['klass'] = klass;
	}
	
	addExhibitElementLink(
		"facet-list", 
		"Tag Cloud Facet (" + field + ")", 
		'facet',
		params,
        <?php echo(WpExhibitFacet::addFieldDisplay()); ?>,
        {
            editable: true,
            tabid: "exhibit-facet-tagcloud"
        }
	);	
}
</script>
