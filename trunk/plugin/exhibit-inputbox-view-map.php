<p><b>A <b>Map</b> displays location-based data on a Google Map.</b></p>
<form id="add-view-map-form">
	<table>
		<tr>
			<td><i>What do you want to call this map?</i></td>
			<td><input id="view-map-label" type="text" size="30" /></td>
		</tr>
		<tr>
			<td><i>What field contains the location?</i></td>
			<td><select id="view-map-field" class="allpropbox"></select> contains a 
				<select id="view-map-field-type">
					<option selected value="latlng">Latitude,Longitude</select>
				</select>
			</td>
		</tr>	
		<tr>
			<td><i>Popup Size</i><br /><b>(Optional)</b></td>
			<td>Width: <input id="view-map-bw" value="200" style="width: 40px;" />px, Height: <input style="width: 40px;" id="view-map-bh" value="200" />px</td>
		</tr>
		<tr>
			<td><i>Marker Size</i><br /><b>(Optional)</b></td>
			<td>Width: <input id="view-map-mw" value="60" style="width: 40px;" />px, Height: <input style="width: 40px;" id="view-map-mh" value="60" />px</td>
		</tr>
		<tr>
			<td><i>Icon</i><br /><b>(Optional)</b></td>
			<td><select id="view-map-icon" class="allpropbox"></select></td>
		</tr>
		<tr>
			<td><i>Extra Attributes</i><br /><b>(Optional, Advanced)</b></td>
			<td> <input id="view-map-extra-attributes" type="text" size="30" /></td>
		</tr>	
	</table>
<!--	
<p><i>What field (if any) varies the size of the marker?</i><br /><select id="view-map-coderfield" class="allpropbox"></select></p> 
NOTE: Currently disabled. You have to put the coder definition OUTSIDE the view panel for it to work. Then we can add this back in.
-->
	<br />
	<p><a href="#" class="addlink" onclick="submit_view_map_facet(); return false">Add Map</a></p>
</form>

<script type="text/JavaScript">

function submit_view_map_facet() {
	var label = jQuery('#view-map-label').val();
	var kind = 'view-map';
	var field = jQuery('#view-map-field').val();
	var coderfield = jQuery('#view-map-coderfield').val();
	var locationtype = jQuery('#view-map-field-type').val();
	var extra_attributes = jQuery('#view-map-extra-attributes').val();
	var icon = jQuery('#view-map-icon').val();
	var bw = jQuery('#view-map-bw').val();
	var bh = jQuery('#view-map-bh').val();
	var mw = jQuery('#view-map-mw').val();
	var mh = jQuery('#view-map-mh').val();
	
	var params = {
		kind: kind,
		field: field,
		label: label,
		bubblewidth: bw,
		bubbleheight: bh,		
		markerwidth: mw,
		markerheight: mh,		
		coderfield: coderfield,
		locationtype: locationtype
	};
	
	if (extra_attributes != null) {
		params['extra_attributes'] = extra_attributes;
	}
	if (icon != null) {
		params['icon'] = icon;
	}
	
	addExhibitElementLink("views-list", "Map: " + label, 'view', params);
}
</script>

