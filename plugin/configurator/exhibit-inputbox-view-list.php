<p><b>A <b>List</b> displays an intelligent list of data items.</b></p>


<table>
	<tr>
		<td><i>Visualization Title</i></td>
		<td><br /><input id="exhibit-views-list-label" type="text" size="30" /></td>
		<td></td>
	</tr>
	<tr>
		<td><i>Only show items of type</i></td>
		<td><select id="view-list-klass" class="alltypebox"></select></td>
		<td>(Optional)</td>
	</tr>
	<tr>
		<td><i>Default sort by field</i></td>
		<td><select id="exhibit-views-list-sortby" class="allpropbox"></select></td>
		<td>(Optional)</td>
	</tr>
</table>
<br />
<p align="right"><a href="#" class="addlink" onclick="submit_view_list_facet(); return false">Add List</a></p>

<script type="text/JavaScript">

function submit_view_list_facet() {
	var label = jQuery('#exhibit-views-list-label').val();
	var kind = 'view-tile';
	var sortby = jQuery('#exhibit-views-list-sortby').val();
	var klass = jQuery('#view-list-klass').val();
	// var extra_attributes = jQuery('#view-list-extra-attributes').val();
	
	var params = 	{
			kind: kind,
			label: label
	};
	
	if (sortby != null) {
		params['sortby'] = sortby;
	}
	if (klass != null) {
		params['klass'] = klass;
	}

	// if (extra_attributes != null) {
	// 	params['extra_attributes'] = extra_attributes;
	// }
	
	editinfo = {
            editable: true,
            tabid: "exhibit-views-list"
    };
	
	addExhibitElementLink("views-list", "List: " + label, 'view', params, null, editinfo);
}
</script>

