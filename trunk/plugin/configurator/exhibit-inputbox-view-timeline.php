<p><b>A <b>Timeline</b> plots time-based information on an interactive timeline.</b></p>

	<table>
		<tr>
			<td><i>Visualization Title</i></td>
			<td><input id="exhibit-views-timeline-label" type="text" size="30" /></td>
			<td></td>
		</tr>
		<tr>
			<td><i>Event Start</i></td>
			<td><select id="exhibit-views-timeline-field" class="allpropbox"></select></td>
			<td></td>
		</tr>
		<tr>
			<td><i>Event End</i></td>
			<td><select id="exhibit-views-timeline-end" class="allpropbox"></select></td>
			<td>(Optional)</td>
		</tr>
		<tr>
			<td><i>Color objects by</i></td>
			<td><select id="exhibit-views-timeline-color" class="allpropbox"></select></td>
			<td>(Optional)</td>
		</tr>
		<tr>
			<td><i>Proxy (advanced)</i></td>
			<td><select id="exhibit-views-timeline-proxy" class="allpropbox"></select></td>
			<td>(Optional)</td>
		</tr>
		<tr>
			<td><i>Only show items of type</i></td>
			<td><select id="view-timeline-klass" class="alltypebox"></select></td>
			<td>(Optional)</td>
		</tr>
	</table>
<br />
<p align="right"><a href="#" class="addlink" onclick="submit_view_timeline_facet(); return false">Add Timeline</a></p>

<script type="text/JavaScript">

function submit_view_timeline_facet() {
	var label = jQuery('#exhibit-views-timeline-label').val();
	var kind = 'view-timeline';

	var start = jQuery('#exhibit-views-timeline-field').val();
	var end = jQuery('#exhibit-views-timeline-end').val();
	var color = jQuery('#exhibit-views-timeline-color').val();
	var proxy = jQuery('#exhibit-views-timeline-proxy').val();
	var klass = jQuery('#view-timeline-klass').val();
	
	// var extra_attributes = jQuery('#view-timeline-extra-attributes').val();
	
	var params = {
		kind: kind,
		label: label,
		field : start
	};
	
	if (end != null) {
		params['end'] = end;
	}
	if (klass != null) {
		params['klass'] = klass;
	}
	if (color != null) {
		params['color'] = color;
	}
	// if (extra_attributes != null) {
	// 	params['extra_attributes'] = extra_attributes;
	// }	
	if (proxy != null) {
		params['proxy'] = proxy;		
	}
	
	editinfo = {
            editable: true,
            tabid: "exhibit-views-timeline"
    };
	
	addExhibitElementLink("views-list", "Timeline: " + label, 'view', params, null, editinfo);
}
</script>

