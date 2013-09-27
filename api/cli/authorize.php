<?php
require_once '../../demoSettings.php';

/**
 * Use this to generate an access token and secret for your app!
 */

try {
    $oauthClient = new Oauth(DemoSettings::CONSUMER_KEY, DemoSettings::CONSUMER_SECRET, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_AUTHORIZATION);
    $oauthClient->enableDebug();
} catch(OAuthException $exception) {
  echo 'ERROR: failed to create Oauth object.  Exception: ' . $exception->getMessage();
}

$apiUrlBase = DemoSettings::API_URL;

try {
    $info = $oauthClient->getRequestToken("$apiUrlBase/oauth1/request_token/v1", "oob");
    
    if (   array_key_exists('oauth_token_secret', $info) &&
           array_key_exists('authentication_url', $info) &&
         ! array_key_exists('oauth_token', $info)) {
        $urlArray = parse_url($info['authentication_url']);
        $info['authentication_url'] = $urlArray['scheme'] .'://'. $urlArray['host'] . $urlArray['path'];
        parse_str($urlArray['query']);
        $info['oauth_token'] = $oauth_token;
    }
    if ( array_key_exists('oauth_token', $info) &&
         array_key_exists('oauth_token_secret', $info) &&
         array_key_exists('authentication_url', $info) ) {
        echo "Request token        : ".$info['oauth_token']."\n";
        echo "Request token secret : ".$info['oauth_token_secret']."\n";
        echo "Next please authenticate yourself at ".$info['authentication_url']."?oauth_token=".$info['oauth_token']." and collect the PIN for the next step.\n";
        $oauthClient->setToken( $info['oauth_token'] , $info['oauth_token_secret'] );
    } else {
        echo "ERROR: failed to get a request tocken";
    }
} catch(OAuthException $exception){
  echo 'ERROR: failed to get a request tocken.  Exception: ' . $exception->getMessage();
}

// windows
echo 'Pin:';
$pin = stream_get_line(STDIN, 1024, PHP_EOL);

// linux
//$pin = readline("PIN: ");

try {
    $info = $oauthClient->getAccessToken("$apiUrlBase/oauth1/access_token/v1", null, $pin);
    if ( array_key_exists('oauth_token', $info) &&
         array_key_exists('oauth_token_secret', $info) ) {
        echo "Access token        : ".$info['oauth_token']."\n";
        echo "Access token secret : ".$info['oauth_token_secret']."\n";
        echo "\nYou can store these access token values in access_token.php for the other scripts to use.\n";
        $oauthClient->setToken( $info['oauth_token'] , $info['oauth_token_secret'] );
    } else {
        echo "ERROR: failed to get access tocken";
    }
} catch(OAuthException $exception){
  echo 'ERROR: failed to get access tocken.  Exception: ' . $exception->getMessage();
}