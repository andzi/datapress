<p><b>A <b>Bar Chart</b> displays numeric data as set of bars.</b></p>


	<table>
		<tr><td><i>Visualization Title</i></td><td><input id="view-bar-label" type="text" size="30" /></td><td></td></tr>
		<tr><td><i>X Axis</i></td><td><select id="view-bar-x" class="allpropbox"></select></td><td></td></tr>
		<tr><td><i>X Axis Label</i></td><td><input id="view-bar-xLabel" /></td><td></td></tr>
		<tr><td><i>Y Axis</i></td><td><select id="view-bar-y" class="allpropbox"></select></td><td></td></tr>
		<tr><td><i>Y Axis Label</i></td><td><input id="view-bar-yLabel" /></td><td></td></tr>
		<tr><td><i>Extra Attributes</i></td><td><input id="view-bar-extra-attributes" type="text" /></td><td>(optional)</td></tr>
	</table>
	<br />
	<p align="right"><a href="#" class="addlink" onclick="submit_view_bar_facet(); return false">Add Bar Chart</a></p>

<script type="text/JavaScript">

function submit_view_bar_facet() {
		var kind = 'view-bar';
		var label = jQuery('#view-bar-label').val();
		var xField = jQuery('#view-bar-x').val();
		var yField = jQuery('#view-bar-y').val();
		var xLabel = jQuery('#view-bar-xLabel').val();
		var yLabel = jQuery('#view-bar-yLabel').val();
		var extra_attributes = jQuery('#view-bar-extra-attributes').val();

		var params = 	{
			kind: kind,
			xField: xField,
			yField: yField,
			xLabel: xLabel,
			yLabel: yLabel,
			label: label
		};
		
		if (extra_attributes != null) {
			params['extra_attributes'] = extra_attributes;
		}
				
		addExhibitElementLink("views-list", "Bar Chart: " + label, 'view',params);
	}
</script>

