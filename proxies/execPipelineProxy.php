<?php
require_once '../demoSettings.php';

// give shapejs some time to process
$timeout = 600;
set_time_limit($timeout);

$shapeJsServer = DemoSettings::SHAPE_JS_PIPELINE;
$ch = curl_init();
if(!empty($_POST)) {
  $postFields = $_POST;
  if(!empty($_FILES)) {
    foreach ($_FILES as $key => $fileArray) {
      $tmpFile = $fileArray['tmp_name'] . '.' . pathinfo($fileArray['name'], 4);
      move_uploaded_file($fileArray['tmp_name'], $tmpFile);
      $postFields[$key] = "@{$tmpFile};type={$fileArray["type"]}";
    }
  }
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
}

curl_setopt($ch,CURLOPT_URL, $shapeJsServer);
curl_setopt($ch,CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch,CURLOPT_AUTOREFERER, TRUE);
curl_setopt($ch,CURLOPT_HEADER, FALSE);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, TRUE);

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

$output = curl_exec($ch);

curl_close($ch);

header("Content-type: application/json; charset=utf-8");

echo $output;