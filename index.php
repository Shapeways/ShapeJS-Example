<?php
require_once 'demoSettings.php';

// grab the shapejs script
$shapeJsDemoScriptPath = 'shapeJsScripts/shapeJsDemo.sjs';
ob_start();
readfile($shapeJsDemoScriptPath);
$shapeJsDemoScript = json_encode(ob_get_clean());

// change this to not be time() if you care about caching
$scriptTag = time();
?>

<script type="text/javascript" src="sw.shapejs.creator-2.0.js?tag=<?php echo $scriptTag;?>"></script>
<script type="text/javascript" src="jquery-1.7.2.min.js?tag=<?php echo $scriptTag;?>"></script>
<script type="text/javascript" src="jquery.form.js?tag=<?php echo $scriptTag;?>"></script>

<script type="text/javascript">
  var shapeJsDemoCode = '<?php echo $shapeJsDemoScript;?>';
  var modelPath = null;
  
  /**
   *  Success callback for the call to ShapeJS
   */
  function onGenerateModelSuccess(aoptOutput, modelFilePath) {
    // grab the iframe using the path to the aopt file
    aoptOutput = 'http://<?php echo DemoSettings::APP_HOST_NAME;?>/proxies/aoptFileProxy.php?aoptFilePath=' + aoptOutput + "&width=500&height=300";
    $("#x3d-iframe").attr('src',aoptOutput);
    
    // set the model path for uploading later
    modelPath = modelFilePath;
  }
  
  /**
   * Uploads a model with the Shapeways API.
   */
  function uploadModel() {
    $.post('/api/apiUpload.php', 
	   {modelFilePath: modelPath, modelFileName: "ShapeJSDemoModel.x3db"},
	   function(response) {
		 
		 // now that we have a model id, we can create a link to the model on shapeways
		 var decodedResponse = JSON.parse(response);
		 var modelId = decodedResponse.modelId;
		 var modelLink = $('#model-link');
		 modelLink.html('<a href="http://www.shapeways.com/model/upload-and-buy/' + modelId + '">Click here to see your model on shapeways.com!</a>');
		 modelLink.css('display', 'block');
	   }
    );
  }
</script>

<div id="controls" style="float: left">
  <form id="shapejs-demo-form">
    <input type='file' name="file1" >
    <br/>
    Thickness: 
    <input type="text" name='param1' id='param1' value="3">
    <br/>
    Length: 
    <input type="text" name='param2' id='param1' value="20">
    <br/>
    Width: 
    <input type="text" name='param3' id='param1' value="20">
  </form>

  <a href="#" onclick="getShapeJsPreview(shapeJsDemoCode, 'shapejs-demo-form', onGenerateModelSuccess)">Generate Model</a>
  <a href="#" onclick="uploadModel()">Upload Model</a>
  
  <br/>
  
  <div id="model-link" style="display: none">
    
  </div>
</div>

<div id="x3delement" style="float: left; border: 1px solid">
  <iframe id="x3d-iframe" x="0px" y="0px" width="500px" height="300px" frameborder="0" style="overflow:hidden;"
          src="">
  </iframe>
</div>