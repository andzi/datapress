function addExhibitElementLink(listId, caption, prefix, fields, field_display) {
	var next_id = SimileAjax.jQuery('#' + listId + ' > li').size();
	var liid = listId + "_" + next_id;
	var liid_remove = liid + "_remove";
	var opStr = "";
	opStr = opStr + "<li id='" + liid + "'>" + caption + " ";
	SimileAjax.jQuery.each(fields, function(key, value) {
	    field_name = prefix + "_" + next_id + "_" + key;
	    if (field_display && (key in field_display)) {
	        opStr = opStr + field_display[key](key, value, field_name);
	    } else {
    		var field = "<input type='hidden' name='" + field_name + "' value='" + value + "' />";
	    	opStr = opStr + field;
	    }
	});
	opStr = opStr + "[ <a href='#' onclick='removeExhibitElementLink(\"" + liid + "\",\"" + liid_remove + "\"); return false;'>remove</a> ]";
	opStr = opStr + "</li>";
	SimileAjax.jQuery('#' + listId).append(opStr);
	return liid_remove;
}

function removeExhibitElementLink(liid, liid_remove) {
    SimileAjax.jQuery("#" + liid).remove();
    SimileAjax.jQuery("#" + liid_remove).remove();
    ex_load_links();
}

function send_to_editor(h) {
	if ( typeof tinyMCE != 'undefined' && ( ed = tinyMCE.activeEditor ) && !ed.isHidden() ) {
		ed.focus();
		if (tinymce.isIE)
			ed.selection.moveToBookmark(tinymce.EditorManager.activeEditor.windowManager.bookmark);

		if ( h.indexOf('[caption') === 0 ) {
			if ( ed.plugins.wpeditimage )
				h = ed.plugins.wpeditimage._do_shcode(h);
		} else if ( h.indexOf('[gallery') === 0 ) {
			if ( ed.plugins.wpgallery )
				h = ed.plugins.wpgallery._do_gallery(h);
		}

		ed.execCommand('mceInsertContent', false, h);

	} else if ( typeof edInsertContent == 'function' ) {
		edInsertContent(edCanvas, h);
	} else {
		jQuery( edCanvas ).val( jQuery( edCanvas ).val() + h );
	}

	tb_remove();
}

function appendToPost(myValue) {
	window.tinyMCE.execInstanceCommand("content", "mceInsertContent",true,myValue);
}

function appendToLens(myValue) {
	window.tinyMCE.execInstanceCommand("lens-text", "mceInsertContent",true,myValue);
}

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

function ex_load_links() {
    db = Exhibit.Database.create();
	db.loadDataLinks(ex_data_types_changed);		
}
