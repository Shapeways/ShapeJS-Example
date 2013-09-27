<?php
require_once '../demoSettings.php';

/**
 * Takes an AOPT file and generated an x3d scene for the 3D model
 */

/**
 * All the aopt paths assume local storage of the binaries.  We need to replace those with a url.
 * 
 * @param string $x3dFile
 * @param string $urlPrefix
 * @param bool $raw
 * @param string $secretKey
 * @return string
 */
function fixUpX3DFile($x3dFile, $urlPrefix, $raw, $secretKey) {
  $x3dFile = str_replace("index='./", "index='" . $urlPrefix, $x3dFile);
  $x3dFile = str_replace("coord='./", "coord='" . $urlPrefix, $x3dFile);
  $x3dFile = str_replace("color='./", "color='" . $urlPrefix, $x3dFile);
  $x3dFile = str_replace("normal='./", "normal='" . $urlPrefix, $x3dFile);
  $x3dFile = str_replace("texCoord='./", "texCoord='" . $urlPrefix, $x3dFile);
  $x3dFile = str_replace("url='./", "normal='" . $urlPrefix, $x3dFile);

  $matches = array();
  preg_match_all("/url=\'(.+?)\'/", $x3dFile, $matches);
  
  if(!$raw) {
    $dom = new DomDocument();
    $dom->loadXML( $x3dFile );
    $x3dFile = $dom->saveXML(null, LIBXML_NOEMPTYTAG);
  }

  return $x3dFile;
}

$aoptFilePath = isset($_GET['aoptFilePath']) ? $_GET['aoptFilePath'] : NULL;
$width = isset($_GET['width']) ? intval($_GET['width']) : 482;
$height = isset($_GET['height']) ? intval($_GET['height']) : 357;

$x3dFile = file_get_contents($aoptFilePath);

if($x3dFile) {
  $lastSlash = strrpos($aoptFilePath, '/');
  $urlPrefix = '/proxies/fileProxy.php?fileToProxy=' . substr($aoptFilePath, 0, $lastSlash + 1);

  // proxy all the binaries for the aopt binaries
  $x3dFile = fixUpX3DFile($x3dFile, $urlPrefix, FALSE, NULL);

  // change this to not be time() if you care about caching
  $scriptTag = time();
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="imagetoolbar" content="no">
  <title>Shapeways | 3D View</title>

  <script type="text/javascript" src="http://<?php echo DemoSettings::APP_HOST_NAME;?>/x3dom.js?tag=<?php echo $scriptTag;?>"></script>
  <script type="text/javascript" src="http://<?php echo DemoSettings::APP_HOST_NAME;?>/jquery-1.7.2.min.js?tag=<?php echo $scriptTag;?>"></script>

  <script type='text/javascript'>
    jQuery(document).ready(function () {
      var x3dElem = jQuery('#x3dElement x3d');
      if(x3dElem.length > 0) {
        //note: must use .attr not .height/.width
        x3dElem.attr('height','<?=$height?>px');
        x3dElem.attr('width','<?=$width?>px');

        var scene = x3dElem.children('Scene')[0];

        //add a nice background color
        node = document.createElement('Background');
        node.setAttribute('skyColor', '1 1 1');
        node.setAttribute('DEF', 'bgnd');
        scene.appendChild(node);

        vp = document.getElementsByTagName("Viewpoint")[0];
        vp.setAttribute("set_bind", "true");

        //for debugging
        /*        x3dom.debug['isActive'] = true;
         x3dom.debug['isFirebugAvailable'] = true;
         x3dElem.attr('showLog','true');
         x3dElem.attr('showStat','true');*/

        x3dom.reload();

        x3dElem[0].runtime.showAll();
      }
    });
  </script>

</head>

<body style='margin:0'>
<style type="text/css">
  .x3dom-canvas {
    cursor: move;
  }
</style>

<div id='x3dElement'>
  <?=$x3dFile?>
</div>
</body>

</html>
<?php
}
else {
  echo "ERROR: NO X3D file";
}
?>
