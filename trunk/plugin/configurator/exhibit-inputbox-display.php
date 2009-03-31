<div class="outer-tabs-panel-header">
<div class="current">
</div>

<?php
    $checked = "";
	$css = "";
	$custom_html = "";
	$height = 700;
	if ($exhibitConfig != NULL) {
 		if ($exhibitConfig->get('lightbox') == false) {
			$checked = "";
		}
		else {
		    $checked = "checked";
		}
		if ($exhibitConfig->get('css') != NULL) {
			$css = $exhibitConfig->get('css');
		}
		if ($exhibitConfig->get('height', true) != NULL) {
			$height = $exhibitConfig->get('height');
		}
	}
?>

<div id="exhibit-datasource-link" class="inner-tabs-panel">
<table>
	<tr>
		<td><i>Lightbox the exhibit?</i></td> 
		<td><input name="display-configuration-lightbox" id="display-configuration-lightbox" type="checkbox" value="show-lightbox" <?php echo $checked; ?>></td>
	</tr>
	<tr>
		<td><i>Unlightboxed exhibit height</i></td> 
		<td><input name="display-configuration-height" id="display-configuration-height" value="<?php echo $height; ?>"></td>
	</tr>

	<tr>
		<td><i>Attach custom CSS<br /> (provide URL)</i></td> 
		<td><input style="width: 300px;" name="display-configuration-css" id="display-configuration-css" value="<?php echo $css ?>" /></td>
	</tr>
</table>	
</div>

