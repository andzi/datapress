<p><b>A <b>Scatter Plot</b> displays data as an graph of data points.</b></p>

<form id="add-view-scatter-form">

	<table>
		<tr>
			<td><i>Visualization Title</i></td>
			<td><input id="view-scatter-label" type="text" size="30" /></td>
			<td></td>
		</tr>
		<tr>
			<td><i>X Axis</i></td>
			<td><select id="view-scatter-x" class="allpropbox"></select></td>
			<td></td>
		</tr>
		<tr>
			<td><i>X Axis Label</i></td>
			<td><input id="view-scatter-xLabel" /></td>
			<td></td>
		</tr>
		<tr>
			<td><i>Y Axis</i></td>
			<td><select id="view-scatter-y" class="allpropbox"></select></td>
			<td></td>
		</tr>
		<tr>
			<td><i>Y Axis Label</i></td>
			<td><input id="view-scatter-yLabel" /></td>
			<td></td>
		</tr>
		<tr>
			<td><i>Scale</i></td>
			<td><select id="view-scatter-xScale"><option value="linear">Linear</option><option value="log">Log</option></select></td>
			<td></td>
		</tr>
		<tr>
			<td><i>Extra Attributes</i></td>
			<td><input id="view-scatter-extra-attributes" type="text" /></td><td>(Optional)</td>
		</tr>	
	</table>
	<br />
	<p align="right"><a href="#" class="addlink" onclick="submit_view_scatter_facet(); return false">Add Scatter Plot</a></p>
</form>			

<script type="text/JavaScript">

function submit_view_scatter_facet() {
	var kind = 'view-scatter';
	var label = jQuery('#view-scatter-label').val();
	var xField = jQuery('#view-scatter-x').val();
	var yField = jQuery('#view-scatter-y').val();
	var xLabel = jQuery('#view-scatter-xLabel').val();
	var yLabel = jQuery('#view-scatter-yLabel').val();
	var xScale = jQuery('#view-scatter-xScale').val();
	var extra_attributes = jQuery('#view-scatter-extra-attributes').val();
	
	var params = {
		kind: kind,
		xField: xField,
		yField: yField,
		xLabel: xLabel,
		yLabel: yLabel,
		xScale: xScale,
		label: label
	};
	
	if (extra_attributes != null) {
		params['extra_attributes'] = extra_attributes;
	}	
	
	addExhibitElementLink("views-list", "Scatter Plot: " + label, 'view', params);
}
</script>

