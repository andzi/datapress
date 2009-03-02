<p><b>A <b>List</b> displays an intelligent list of data items.</b></p>

<form id="add-view-list-form">

<table>
	<tr>
		<td><i>What do you want to call this list?</i></td>
		<td><br /><input id="view-list-label" type="text" size="30" /></td>
	</tr>
	<tr>
		<td><i>Default sort by field</i><br /><b>(Optional)</b></td>
		<td><select id="view-list-sortby" class="allpropbox"></select></td>
	</tr>
	<tr>
		<td><i>Extra Attributes</i><br /><b>(Optional, Advanced)</b></td>
		<td><input id="view-list-extra-attributes" type="text" size="30" /></td>
	</tr>
</table>
<br />
<p><a href="#" class="addlink" onclick="submit_view_list_facet(); return false">Add List</a></p>
</form>			

<script type="text/JavaScript">

function submit_view_list_facet() {
	var label = jQuery('#view-list-label').val();
	var kind = 'view-tile';
	var sortby = jQuery('#view-list-sortby').val();
	var extra_attributes = jQuery('#view-list-extra-attributes').val();
	
	var params = 	{
			kind: kind,
			label: label
	};
	
	if (sortby != null) {
		params['sortby'] = sortby;
	}
	if (extra_attributes != null) {
		params['extra_attributes'] = extra_attributes;
	}
	
	addExhibitElementLink("views-list", "List: " + label, 'view', params);
}
</script>

