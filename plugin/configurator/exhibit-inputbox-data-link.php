<?php
if (!$guessurl = site_url())
	$guessurl = wp_guess_url();
$baseuri = $guessurl;
$exhibituri = $baseuri . '/wp-content/plugins/datapress';
?>

<table>
	<tr>
		<td>Data URL</td>
		<td><input id="exhibit-datasource-link-uri" type="text" size="30" /></td>
	</tr>
	<tr>
		<td>Data Type</td>
		<td><select id="exhibit-datasource-link-kind"><option  value="exhibit">Exhibit (web page)</option><option value="google-spreadsheet">Google Spreadsheet (JSONP)</option><option value="application/json">JSON</option></select></td>
	</tr>
	<tr>
    	<td>Datasource Name</td>
		<td><input id="exhibit-datasource-link-sourcename" type="text" size="30" /></td>
	</tr>
</table>
<p align="right"><a href="#" class="addlink" onclick="submit_data_link(); return false">Add Data Link</a></p>

<script type="text/JavaScript">
  function kind_for(kind) {
  	if (kind == "google-spreadsheet") {
		return "Google Spreadsheet";
	}
	if (kind == "application/json") {
		return "JSON File";
	}
	return "Unknown Type";
  }

  function add_datasource_link(kind, uri, sourcename, where) {
		var remove_id = addExhibitElementLink(
			"data-source-list",
			kind_for(kind) + ": " + sourcename + " (<a href='" + uri + "'>view data</a>)",
			'data', 
			{
				kind: kind, 
				uri: uri,
				sourcename: sourcename,
				data_location: where
		    },
            {
                editable: true,
                tabid: "exhibit-datasource-link"
            });
		ex_add_head_link(uri, kind, remove_id);
		$.post("<?php bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php",
		       { action: "insert_parrotable_url",
		         url: encodeURIComponent(uri) },
               function(data){
                 setTimeout("ex_load_links()", 1000);
               });
  }

  function submit_data_link() {
	var uri = jQuery('#exhibit-datasource-link-uri').val();
	var kind = jQuery('#exhibit-datasource-link-kind').val();
    var sourcename = jQuery('#exhibit-datasource-link-sourcename').val();

	if (kind == 'exhibit') {
		// Use batch link
		jQuery(function() {
			jQuery.getJSON("<?php echo $exhibituri ?>" + "/proxy/link_scrape.php?url=" + encodeURIComponent(uri), function(json) {
				for(var i=0; i<json.links.length; i++) {
					var link_kind = json.links[i].kind;
					var link_uri = json.links[i].href;
					var link_sourcename = json.links[i].alt;
					add_datasource_link(link_kind, link_uri, link_sourcename, 'remote');					
				}
			});	
		});
		
	}
	else {
		add_datasource_link(kind, uri, sourcename, 'remote');
	}
  }

</script>
