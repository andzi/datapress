<?php
require_once('config.php');

if (!$handle = fopen($logfile, 'r')) {
  echo "Cannot open file ($logfile)";
  exit;
}

while (!feof($handle)) {
  $buffer = fgets($handle, 4096);
  $kvs = split(",", $buffer);
  echo "New Entry:\n";
  foreach ($kvs as $kv) {
    $splitkv = split(":", $kv);
    $key = $splitkv[0];
    $val = base64_decode($splitkv[1]);
    if ($key == 'time') {
      $val = date("m-d-Y h:i:s", $val);
    }
    echo "$key $val\n";
  }
  echo "\n";
}

fclose($handle);
?>
