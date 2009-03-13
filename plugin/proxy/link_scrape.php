<?php
require_once('web-tools.php');

	$url = $_GET['url'];
	$json = '{ "links" : [ ';
  $contents = WebTools::do_get_request($url);
  $pattern = "/<link[^>]*\/>/";
	preg_match_all($pattern, $contents, $links, PREG_SET_ORDER);
	foreach ($links as $link) {
		$linkval = $link[0];

		$rel_pattern = "/rel=\"([^\"]*)\"/";		
		$href_pattern = "/href=\"([^\"]*)\"/";
		$type_pattern = "/type=\"([^\"]*)\"/";
		$alt_pattern = "/alt=\"([^\"]*)\"/";
		$converter_pattern = "/ex:converter=\"([^\"]*)\"/";

		$rel_matched = preg_match($rel_pattern, $linkval, $relmatch);		
		$href_matched = preg_match($href_pattern, $linkval, $hrefmatch);
		$type_matched = preg_match($type_pattern, $linkval, $typematch);
		$alt_matched = preg_match($alt_pattern, $linkval, $altmatch);
		$converter_matched = preg_match($converter_pattern, $linkval, $convertermatch);
		
		if ($rel_matched && ($relmatch[1] == "exhibit/data")) {
			$href=$hrefmatch[1];
			$type=$typematch[1];
			
			// Fix the converter if it is a Google Spreadsheet
			if ($converter_matched && ($convertermatch[1] = "googleSpreadsheets")) {
				$type="google-spreadsheet";
			}
			
			// Fix the filename if it was a relative path
			if (! (strpos($href, 'http') === 0)) {
				$last_slash = strripos($url, '/');
				$href = substr($url, 0, $last_slash + 1) . $href;
			}

			$alt = "";
			
			if ($alt_matched) {
				$alt=$altmatch[1];				
			}
			else {
				if ($type == "google-spreadsheet") {
					$alt = "UnnamedSpreadsheet";
				}
				else {
					$alt= substr($href, strripos($url, '/') - strlen($alt) + 1);					
				}
			}
			
			$json .= '{ "href": "' . $href . '", "kind": "' . $type  . '", "alt": "' . $alt . '" },';
		}
		
	}
	$json = substr($json, 0, -1); // Remove the trailing comma
	$json .= ']}';	
	echo $json;
?>
