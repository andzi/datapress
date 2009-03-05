<p><b>A <b>Scatter Plot</b> displays data as an graph of data points.</b></p>

<form id="add-view-scatter-form">
	<p><i>What do you want to call the scatter plot?</i><br /><input id="view-scatter-label" type="text" size="30" /></p>

	<table>
		<tr><td><i>X Axis Value</i></td><td>X Axis Label</td></tr>
		<tr><td><select id="view-scatter-x" class="allpropbox"></select></td><td><input id="view-scatter-xLabel" /></td></tr>
		<tr><td><i>Y Axis Value</i></td><td>Y Axis Label</td></tr>
		<tr><td><select id="view-scatter-y" class="allpropbox"></select></td><td><input id="view-scatter-yLabel" /></td></tr>
		<tr><td><i>Scale</i></td><td><select id="view-scatter-xScale"><option value="linear">Linear</option><option value="log">Log</option></select></td></tr>
		<tr>
			<td><i>Extra Attributes</i><br /><b>(Optional, Advanced)</b></td>
			<td><input id="view-scatter-extra-attributes" type="text" size="40" /></td>
		</tr>	
	</table>
	<br />
	<p><a href="#" class="addlink" onclick="submit_view_scatter_facet(); return false">Add Scatter Plot</a></p>
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

