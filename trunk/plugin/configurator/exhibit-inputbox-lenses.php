<div class="outer-tabs-panel-header">
<div class="current">
<ul id="lens-list">
</ul>
<?php
	if ($exhibitConfig != NULL) {
		echo '<script type="text/javascript">';
		$lenses = $exhibitConfig->get('lenses'); 
		foreach ($lenses as $lens) {
			echo $lens->getAddLink('lens-list');
		}
		echo '</script>';				
	}
?>
</div>
</div>

<div class="inner-tabs-panel">
	<table>
		<tr>
			<td>Create a New Lens for</td>
			<td><select id="lensfor" class="alltypebox"></select></td>
		</tr>
	</table>
<div style="height: 150px;" id='lenscontainer'>
	<textarea id="lens-text" class='' style="height: 150px; width: 80%;" name='lens-text'></textarea>
</div>

<table width="100%">
	<tr>
		<td><p align="left">Available Properties: <select id="lense-prop-possibilities" class="allpropbox"></select><a href="#" onClick="appendToLens('{{' + jQuery('#lense-prop-possibilities').val() + '}}'); return false;">Insert Property</a></p></td>
		<td><p align="right"><a href="#" class="addlink" onclick="submit_lens(); return false">Add Lens</a></p></td>
	</tr>
</table>

</div>

<script>
	$(document).ready(function(){
		// <![CDATA[
		// var win = window.dialogArguments || opener || parent || top;
		// var lens_editor = window.tinyMCE.execCommand('mceAddControl', false, 'lens-text');
		// ]]>
	});
</script>

<script type="text/javascript">
function submit_lens() {
		// var win = window.dialogArguments || opener || parent || top;
        var klass = jQuery('#lensfor').val();
        var html = jQuery('#lens-text').val(); // win.tinyMCE.getInstanceById('lens-text').getContent(); // 
        var kind = 'lens';
        
        addExhibitElementLink(
                "lens-list", 
                "Lens for " + klass, 
                'lens',
                {
                        kind: kind,
                        'class': klass,
                        html: html 
        });        
}
</script>
