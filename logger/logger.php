<?php
require_once('config.php');

$logstr = "";

$ref = base64_encode($_SERVER['HTTP_REFERER']);
$ip = base64_encode($_SERVER['REMOTE_ADDR']);
$time = base64_encode(time());

$logstr = "referer:$ref,ip:$ip,time:$time,";

foreach ($_GET as $key => $value) {
  $value = base64_encode($value);
  $logstr .= "$key:$value,";
}

$logstr = rtrim($logstr, ",");

$logstr .= "\n";

if (!$handle = fopen($logfile, 'a')) {
  echo "Cannot open file ($logfile)";
  exit;
}

fwrite($handle, $logstr);
fclose($handle);
?>
