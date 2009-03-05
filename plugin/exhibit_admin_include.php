<?php
if (!$guessurl = site_url())
	$guessurl = wp_guess_url();
$baseuri = $guessurl;
$exhibituri = $baseuri . '/wp-content/plugins/datapress';
?>

    	<script src="<?php echo $exhibituri ?>/js/jquery-1.2.6.min.js" type="text/javascript"></script>
        <script src="<?php echo $exhibituri ?>/js/jquery.fancybox-1.0.0.js" type="text/javascript"></script> 
        <link rel="stylesheet" href="<?php echo $exhibituri ?>/css/fancy.css" type="text/css" media="screen"/>
    
  		<script type="text/javascript">
        $(document).ready(function() { 
        	$('a.exhibit_link').fancybox({ 'frameWidth': $('body').width(), 'frameHeight': $('body').height() });
		});
        </script>



<script type='text/javascript' src='<?php echo $baseuri ?>/wp-includes/js/jquery/ui.tabs.js?ver=1.5.1'></script>
<script type='text/javascript' src='<?php echo $exhibituri ?>/sheet/jquery.sheet.calc.js'></script>
<script type='text/javascript' src='<?php echo $exhibituri ?>/sheet/jquery.sheet.js'></script>

<script src="http://static.simile.mit.edu/exhibit/api-2.0/exhibit-api.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $exhibituri ?>/css/wpexhibit.css"></link>

<script type='text/javascript'>

// This is the database for adding items
db = Exhibit.Database.create();

function ex_data_types_changed(e, arr) {
	// Get all types
	var types = db._types;
	var props = db._properties;
	var type_choice = "";
	var prop_choice = "<option selected value=''> - </option>";
	
	for (var key in types) {
		var id = types[key].getID();
		var label = types[key].getLabel();		
		type_choice = type_choice + "<option value='" + id + "'>" + label + "</option>";
	}	
	for (var key in props) {
		prop_choice = prop_choice + "<option value='" + key + "'>" + key + "</option>";
	}	

	SimileAjax.jQuery('.alltypebox').html(type_choice);		
	SimileAjax.jQuery('.allpropbox').html(prop_choice);
}

function ex_add_head_link(uri, kind, remove_id) {
	var link = "";
	if (kind == "google-spreadsheet") {
		var link = SimileAjax.jQuery('<link id = "' + remove_id + '" rel="exhibit/data" type="application/jsonp" href="' + uri + '" ex:converter="googleSpreadsheets" />');
	}
	else if (kind == "application/json") {
		var link = SimileAjax.jQuery('<link id = "' + remove_id + '" rel="exhibit/data" type="application/json" href="<?php echo $exhibituri ?>/proxy/parrot.php?url=' + uri + '" />');
	}
	
	SimileAjax.jQuery('head').append(link);
}

function ex_load_links() {
    db = Exhibit.Database.create();
	db.loadDataLinks(ex_data_types_changed);		
}

</script>
