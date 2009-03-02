<?php
if (!$guessurl = site_url())
	$guessurl = wp_guess_url();
$baseuri = $guessurl;
$exhibituri = $baseuri . '/wp-content/plugins/wp-exhibit';
?>

<p><b>Link to data on the web.</b><br/>Any remote changes in that data will be reflected in your Exhibit.</p>
<p>You can upload your own data to link to using the build-in WordPress media uploader.</p>

<form id="google-doc-form">
	<p>URL: <input id="data-link-link" type="text" size="30" /><select id="data-link-type"><option  value="exhibit">Exhibit</option><option value="google-spreadsheet">Google Spreadsheet</option><option value="application/json">JSON</option></select></p>
    <p>Name: <input id="data-link-sourcename" type="text" size="30" /></p>
	<p><a href="#" class="addlink" onclick="submit_google_doc(); return false">Link</a></p>
</form>

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
		});
		ex_add_head_link(uri, kind, remove_id);
		$.post("<?php bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php",
		       { action: "insert_parrotable_url",
		         url: uri },
               function(data){
                 setTimeout("ex_load_links()", 1000);
               });
  }

  function submit_google_doc() {
	var uri = jQuery('#data-link-link').val();
	var kind = jQuery('#data-link-type').val();
    var sourcename = jQuery('#data-link-sourcename').val();

	if (kind == 'exhibit') {
		// Use batch link
		jQuery(function() {
			jQuery.getJSON("<?php echo $exhibituri ?>" + "/proxy/link_scrape.php?url=" + uri, function(json) {
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
