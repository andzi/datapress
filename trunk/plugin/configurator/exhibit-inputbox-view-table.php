<p><b>A <b>Table</b> displays data in tabular format.</b></p>

	<table>
		<tr><td><i>Visualization Title</i></td><td><input id="view-table-label" type="text" size="30" /></td><td></td></tr>
		<tr><td><i>What is it a table of?</i></td><td><select id="view-table-class" class="alltypebox"></select></td><td></td></tr>
		<tr><td><i>Include Fields</i></td><td><select id="view-table-fields" style="height: 100px; width: 200px;" class="allpropbox" multiple></select></td><td></td></tr>
		<tr><td><i>Field Captions</i><br />(Comma-separated)</td><td><input id="view-table-captions" type="text" size="30" /></td><td>(Optional)</td></tr>
	</table>
	<br />
	<p align="right"><a href="#" class="addlink" onclick="submit_view_table_facet(); return false">Add Table</a></p>


<script type="text/JavaScript">

function submit_view_table_facet() {
	var kind = 'view-table';
	var label = jQuery('#view-table-label').val();
	var klass = jQuery('#view-table-class').val();
	var fields = jQuery('#view-table-fields')[0];
	var caption = jQuery('#view-table-captions').val();
	// var extra_attributes = jQuery('#view-table-extra-attributes').val();

	var field = "";
		
	for (var i=0; i<fields.options.length ;i++) {
		if (fields.options[i].selected) {
			field = field + "." + fields.options[i].value + ",";
		}
	}

	if (field != "") {
		field = field.substring(0,field.length-1);
	}
	
	var params = 	{
			kind: kind,
			klass: klass,
			field: field,
			caption: caption,
			label: label
	};
	
	// if (extra_attributes != null) {
	// 	params['extra_attributes'] = extra_attributes;
	// }
	
	addExhibitElementLink(
		"views-list", 
		"Table: " + label, 
		'view', params
	);
}
</script>

