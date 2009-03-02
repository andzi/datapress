<div class="outer-tabs-panel-header">
<p style="font-size: 1.2em;"><b>Display parameters control how your exhibit looks</b></p>
<p><b>Display Parameters</b></p>
<div class="current" style="height: 300px;">
<?php
	$postID = $_GET['post'];
    $checked = "checked";
	$css = "";
	$custom_html = "";
	if ($postID != NULL) {
		$ex_exhibit = new WpPostExhibit();
		$ex_success = DbMethods::loadFromDatabase($ex_exhibit, $postID, 'postid');
		if ($ex_success == true) {
		    if ($ex_exhibit->get('lightbox') == false) {
		        $checked = "";
		    }
			if ($ex_exhibit->get('css') != NULL) {
				$css = $ex_exhibit->get('css');
			}
			if ($ex_exhibit->get('custom_html') != NULL) {
				$custom_html = $ex_exhibit->get('custom_html');
			}
			
    	}
	}
?>
<p>
	<table>
		<tr>
			<td><i>Lightbox the exhibit?</i></td> 
			<td><input name="display-configuration-lightbox" id="display-configuration-lightbox" type="checkbox" value="show-lightbox" <?php echo $checked; ?>></td>
		</tr>
		<tr>
			<td><i>Attach custom CSS<br /> (provide URL)</i></td> 
			<td><input style="width: 300px;" name="display-configuration-css" id="display-configuration-css" value="<?php echo $css ?>" /></td>
		</tr>
		<tr>
			<td><i>Attach custom HTML<br /> (advanced)</i></td> 
			<td><textarea style="height: 100px; width: 300px;" name="display-configuration-custom-html" id="display-configuration-custom-html"><?php echo $custom_html ?></textarea></td>
		</tr>
		
	</table>	
</p>
</div>
