<div class="outer-tabs-panel-header">
<p style="font-size: 1.2em;"><b>A <i>lens</i> describes how a particular object should look.</b></p>
<p><b>Current Lenses</b></p>
<div class="current">
<ul id="lens-list">
</ul>
<?php
	$postID = $_GET['post'];
	if ($postID != NULL) {
		// See if we know about any data sources associated with this item.
		$ex_exhibit = new WpPostExhibit();
		$ex_success = DbMethods::loadFromDatabase($ex_exhibit, $postID, 'postid');
		if ($ex_success == true) {
			echo '<script type="text/javascript">';
	        $lenses = $ex_exhibit->get('lenses'); 
	        foreach ($lenses as $lens) {
				echo $lens->getAddLink('lens-list');
	        }
			echo '</script>';				
		}
	}
?>
</div>
</div>

<div style="float: left;"><p style="font-size: 1.1em; margin-top: 0px; margin-bottom: 0; padding-top: 0;"><b>Create a New Lens for</b> <select id="lensfor" class="alltypebox"></select>
	&nbsp;&nbsp;&nbsp;&nbsp;Available Properties: 
	<select id="lense-prop-possibilities" class="allpropbox"></select><a href="#" onClick="appendToLens('{{' + jQuery('#lense-prop-possibilities').val() + '}}'); return false;">Insert Property</a></div><div style="float: right;"><a href="#" class="addlink" onclick="submit_lens(); return false">Add Lens</a></div>
<div class="inner-tabs-panel" style="clear: both;">
<div style="height: 16em;" id='lenscontainer'><textarea id="lens-text" class='' style="height: 25px; width: 150px;" name='lens-text'></textarea></div>
</div>


<script type="text/javascript">
// <![CDATA[
lens_editor = tinyMCE.execCommand('mceAddControl', false, 'lens-text');
// ]]>
</script>        

<script type="text/javascript">
function submit_lens() {
        var klass = jQuery('#lensfor').val();
        var html = tinyMCE.getInstanceById('lens-text').getContent(); // jQuery('#lens-text').val();
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
