<p><b>A <b>Timeline</b> plots time-based information on an interactive timeline.</b></p>

<form id="add-view-timeline-form">
	<table>
		<tr>
			<td><i>What do you want to call the Timeline?</i></td>
			<td><input id="view-timeline-label" type="text" size="30" /></td>
		</tr>
		<tr>
			<td><i>What field contains the start of events?</i></td>
			<td><select id="view-timeline-start" class="allpropbox"></select></td>
		</tr>
		<tr>
			<td><i>What field contains the end of events?</i><br /><b>(Optional)</b></td>
			<td><select id="view-timeline-end" class="allpropbox"></select></td>
		</tr>
		<tr>
			<td><i>Color objects according to value stored in:</i><br /><b>(Optional)</b></td>
			<td><select id="view-timeline-color" class="allpropbox"></select></td>
		</tr>
		<tr>
			<td><i>Extra Attributes</i><br />(Optional, Advanced)</td>
			<td><input id="view-timeline-extra-attributes" type="text" size=40" /></td>
		</tr>
	</table>
<br />
<p><a href="#" class="addlink" onclick="submit_view_timeline_facet(); return false">Add Timeline</a></p>
</form>			

<script type="text/JavaScript">

function submit_view_timeline_facet() {
	var label = jQuery('#view-timeline-label').val();
	var kind = 'view-timeline';

	var start = jQuery('#view-timeline-start').val();
	var end = jQuery('#view-timeline-end').val();
	var color = jQuery('#view-timeline-color').val();
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
	
	addExhibitElementLink("views-list", "Timeline: " + label, 'view', params);
}
</script>

