<?php
require_once '../demoSettings.php';

/**
 * Uploads the provided model file to the Shapeways API.
 */

$modelFilePath = isset($_POST['modelFilePath']) ? $_POST['modelFilePath'] : NULL;
$modelFileName = isset($_POST['modelFileName']) ? $_POST['modelFileName'] : NULL;

if(!$modelFilePath || !$modelFileName) {
  echo "ERROR: no model file provided";
  exit(1);
}

try {
  $oauth = new Oauth(DemoSettings::CONSUMER_KEY, DemoSettings::CONSUMER_SECRET, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_AUTHORIZATION);
  $oauth->enableDebug();
  $oauth->setToken(DemoSettings::ACCESS_TOKEN, DemoSettings::ACCESS_SECRET);
} catch(OAuthException $exception) {
  echo "ERROR: Failed to set up Oauth session: " . $exception->getMessage();
}

try {  
  $file = file_get_contents($modelFilePath);
  $data = array("fileName" => $modelFileName,
                "file" => rawurlencode(base64_encode($file)),
                "hasRightsToModel" => 1,
                "acceptTermsAndConditions" => 1,
                );
  $dataString = json_encode($data);
  
  $oauth->fetch(DemoSettings::API_URL ."/models/v1", $dataString, OAUTH_HTTP_METHOD_POST);
  
  $response = $oauth->getLastResponse();
  echo $response;
} catch(OAuthException $exception) {
  echo "ERROR: Call to API failed: " . $exception->getMessage();
}