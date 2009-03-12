<div class="outer-tabs-panel-header">
<div class="current">
</div>

<?php
    $checked = "checked";
	$css = "";
	$custom_html = "";
	if ($exhibitConfig != NULL) {
 		if ($exhibitConfig->get('lightbox') == false) {
			$checked = "";
		}
		if ($exhibitConfig->get('css') != NULL) {
			$css = $exhibitConfig->get('css');
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
		<td><i>Attach custom CSS<br /> (provide URL)</i></td> 
		<td><input style="width: 300px;" name="display-configuration-css" id="display-configuration-css" value="<?php echo $css ?>" /></td>
	</tr>
</table>	
</div>

