<form id="create-edit-form">
	<p>Edit: 
		<select>
			<option value="NEW">New Datasource (fill in details below)</option>
<?php
//	$ex_next_datasource = new WpExhibitDatasource();		
//	$ds_arr = WpExhibitModel::loadManyFromDatabase($ex_next_datasource, 'data_location', "'remote'");
//	foreach ($ds_arr as $ds) {
//		echo "<option value=\"" . $ds->getId() . "\">" . $ds->get('sourcename') . "</option>";
//	}
?>
		</select>
	</p>
	<p>Dataset Name: <input value="sourcename">
	<select>
		<option value="application/json">JSON</option>
	</select>		
	</p>
	<textarea name="data" style="position: relative; width: 90%" cols="50" rows="4"></textarea>
	<p><a href="#" class="addlink" >Save</a></p>
</form>			
