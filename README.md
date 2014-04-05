ShapeJS
=======

Sample Application for ShapeJS.

ShapeJS is a 3D graphics library that can help you generate printable 3D models. For more information, go to http://shapejs.shapeways.com/.

The following application will allow users to upload a 2D image and have a 3D model generated from that image.  
The 2D image must be greyscale. The lighter the grey, the thinner that part of the model will be. 'ring-pattern-star.png'
in the demo images folder is a perfect example of this. The 3D model can then be uploaded to shapeways.com for purchase
or to put up for sale on the Shapeways marketplace.

The data set by the user is sent to the ShapeJS server with the ShapeJS script. The ShapeJS server will return the
location of an AOPT file, which is used for previewing, and a model file, which can be uploaded to shapeways.com for 
printing.

The ShapeJS script itself is in the 'shapeJsScripts' folder. All ShapeJS scripts use the extension '.sjs' though this is 
only for clarity. You may give your files any extension you want so long as you can load the text into JS.

There are settings in demoSettings.php for API keys and the host name of your server. The demo will work with 'localhost' 
by default.

This app is meant to jumpstart you in building applications using ShapeJS and the Shapeways API. Feel free to use as much
or as little of it as you wish.

The current requirements to run the demo are:
- PHP 5.3
- Curl extension for PHP
- PECL Oauth for PHP (should be installed by default on windows binaries)
- Apache 2.2 (point your document root at the main ShapeJS Demo directory)
- A browser that supports WebGL such as Chrome or Firefox (for previews).

demoSettings.php contains a number of settings for running the sample application. There are settings for API Oauth access and consumer keys and secrets. SHAPE_JS_PIPELINE contains the url for the ShapeJS server to use.  APP_HOST_NAME is the hostname of the server that your app is running on.

Please note that ShapeJS is still in BETA.

Basic Troubleshooting:
- Sometimes the demo will fail to generate a file correctly.  Refresh and try again.
- Sending a model that is too large may result in a model with a number of polygons too large for the ShapeJS server to process.  This can be resolved by creating a smaller model, a simpler model, or increasing decimation by adding "meshErrorFactor=1;" to your code.
- Most browsers will track network requests which you can use to debug.  

Things left to do:
- The API upload assumes hard coded access tokens.  That flow needs to be completed.
- More ShapeJS examples.
