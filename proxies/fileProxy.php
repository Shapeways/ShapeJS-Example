<?php

/**
 * A barebones file proxy for retrieving aopt binaries.
 */

$proxyFile = (isset($_REQUEST['fileToProxy'])? $_REQUEST['fileToProxy'] : null);

if ( isset($proxyFile)){
  // the files sent to us aren't properly url encoded
  $proxyFile = str_replace(' ', '+', $proxyFile);

  $content = file_get_contents($proxyFile);

  print($content);
}
else {
  echo "ERROR: no file to proxy";
}
?>
