	<table>
		<tr>
			<td>Create a New Lens for</td>
			<td><select id="exhibit-lenses-edit-class" class="alltypebox"></select></td>
		</tr>
	</table>
<div style="height: 150px;" id='lenscontainer'>
	<textarea id='exhibit-lenses-edit-html' class='' style="height: 150px; width: 80%;" ></textarea>
</div>

<table width="100%">
	<tr>
		<td><p align="left">Available Properties: <select id="lense-prop-possibilities" class="allpropbox"></select><a href="#" onClick="appendToLens('{{.' + jQuery('#lense-prop-possibilities').val() + '}}'); return false;">Insert Property</a></p></td>
		<td><p align="right"><a href="#" class="addlink" onclick="submit_lens(); return false">Add Lens</a></p></td>
	</tr>
</table>

</div>

<script>
	jQuery(document).ready(function(){
		// <![CDATA[
		// var win = window.dialogArguments || opener || parent || top;
		// var lens_editor = window.tinyMCE.execCommand('mceAddControl', false, 'lens-text');
		// ]]>
	});
</script>

<script type="text/javascript">
function submit_lens() {
		// var win = window.dialogArguments || opener || parent || top;
        var klass = jQuery('#exhibit-lenses-edit-class').val();
        var html = jQuery('#exhibit-lenses-edit-html').val(); // win.tinyMCE.getInstanceById('lens-text').getContent(); // 
        var kind = 'lens';
        
        editinfo = {
            editable: true,
            tabid: "exhibit-lenses-edit"
        };
        
        addExhibitElementLink(
                "lens-list", 
                "Lens for " + klass, 
                'lens',
                {
                        kind: kind,
                        'class': klass,
                        html: html 
                },
                editinfo);        
}
</script>
