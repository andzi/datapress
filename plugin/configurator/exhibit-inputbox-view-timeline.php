<p><b>A <b>Timeline</b> plots time-based information on an interactive timeline.</b></p>

	<table>
		<tr>
			<td><i>Visualization Title</i></td>
			<td><input id="view-timeline-label" type="text" size="30" /></td>
			<td></td>
		</tr>
		<tr>
			<td><i>Event Start</i></td>
			<td><select id="view-timeline-start" class="allpropbox"></select></td>
			<td></td>
		</tr>
		<tr>
			<td><i>Event End</i></td>
			<td><select id="view-timeline-end" class="allpropbox"></select></td>
			<td>(Optional)</td>
		</tr>
		<tr>
			<td><i>Color objects by</i></td>
			<td><select id="view-timeline-color" class="allpropbox"></select></td>
			<td>(Optional)</td>
		</tr>
		<tr>
			<td><i>Proxy (advanced)</i></td>
			<td><select id="view-timeline-proxy" class="allpropbox"></select></td>
			<td>(Optional)</td>
		</tr>
		<tr>
			<td><i>Extra Attributes</i></td>
			<td><input id="view-timeline-extra-attributes" type="text" /></td>
			<td>(Optional)</td>
		</tr>
	</table>
<br />
<p align="right"><a href="#" class="addlink" onclick="submit_view_timeline_facet(); return false">Add Timeline</a></p>

<script type="text/JavaScript">

function submit_view_timeline_facet() {
	var label = jQuery('#view-timeline-label').val();
	var kind = 'view-timeline';

	var start = jQuery('#view-timeline-start').val();
	var end = jQuery('#view-timeline-end').val();
	var color = jQuery('#view-timeline-color').val();
	var proxy = jQuery('#view-timeline-proxy').val();
	
	var extra_attributes = jQuery('#view-timeline-extra-attributes').val();
	
	var params = {
		kind: kind,
		label: label,
		field : start
	};
	
	if (end != null) {
		params['end'] = end;
	}
	if (color != null) {
		params['color'] = color;
	}
	if (extra_attributes != null) {
		params['extra_attributes'] = extra_attributes;
	}	
	if (proxy != null) {
		params['proxy'] = proxy;		
	}
	
	addExhibitElementLink("views-list", "Timeline: " + label, 'view', params);
}
</script>

