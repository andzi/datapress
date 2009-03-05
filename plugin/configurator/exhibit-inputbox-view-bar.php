<p><b>A <b>Bar Chart</b> displays numeric data as set of bars.</b></p>

<form id="add-view-bar-form">
	<p><i>What do you want to call the bar chart?</i><br /><input id="view-bar-label" type="text" size="30" /></p>

	<table>
		<tr><td><i>X Axis Value</i></td><td>X Axis Label</td></tr>
		<tr><td><select id="view-bar-x" class="allpropbox"></select></td><td><input id="view-bar-xLabel" /></td></tr>
		<tr><td><i>Y Axis Value</i></td><td>Y Axis Label</td></tr>
		<tr><td><select id="view-bar-y" class="allpropbox"></select></td></tr>
		<tr><td><i>Scale</i></td><td><select id="view-bar-xScale"><option value="linear">Linear</option><option value="log">Log</option></select></td></tr>
		<tr><td><i>Extra Attributes</i><br /><b>(Optional, Advanced)</b></td><td><input id="view-bar-extra-attributes" type="text" size="30" /></td></tr>
	</table>
	<br />
	<p><a href="#" class="addlink" onclick="submit_view_bar_facet(); return false">Add Bar Chart</a></p>
</form>			

<script type="text/JavaScript">

function submit_view_bar_facet() {
		var kind = 'view-bar';
		var label = jQuery('#view-bar-label').val();
		var xField = jQuery('#view-bar-x').val();
		var yField = jQuery('#view-bar-y').val();
		var xLabel = jQuery('#view-bar-xLabel').val();
		var yLabel = jQuery('#view-bar-yLabel').val();
		var xScale = jQuery('#view-bar-xScale').val();
		var extra_attributes = jQuery('#view-bar-extra-attributes').val();

		var params = 	{
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
				
		addExhibitElementLink("views-list", "Bar Chart: " + label, 'view',params);
	}
</script>

