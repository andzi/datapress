<?php
ob_start();
$root = dirname(dirname(dirname(dirname(__FILE__))));
  if (file_exists($root.'/wp-load.php')) {
      // WP 2.6
      require_once($root.'/wp-load.php');
  } else {
      // Before 2.6
      require_once($root.'/wp-config.php');
  }
ob_end_clean(); //Ensure we don't have output from other plugins.
header("Content-type: text/javascript");

if (!$guessurl = site_url())
	$guessurl = wp_guess_url();
$baseuri = $guessurl;
$exhibituri = $baseuri . '/wp-content/plugins/datapress';

print <<<EOF

function set_post_exhibit(exhibit_id) {
	var datapress_link = jQuery('#load_datapress_config_link');
	datapress_link[0].href = '$baseuri/wp-admin/admin-ajax.php?action=datapress_configurator&exhibitid=' + exhibit_id + '&TB_iframe=true';	
	var exhibit_id_element = jQuery('#exhibitid');
	exhibit_id_element[0].value = exhibit_id;
}

EOF
?>