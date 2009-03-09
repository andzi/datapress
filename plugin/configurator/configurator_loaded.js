jQuery(document).ready(function(){
	var category_tabs = jQuery("#exhibit-input-container > ul").tabs();
	ex_load_links();
});

remove_callbacks = new Array();
// This is the database for adding items
db = Exhibit.Database.create();
