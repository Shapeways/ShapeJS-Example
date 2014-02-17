/* @license
 * jQuery ShapeJS Plugin
 * version: 2.1.0-2014.02.04
 * Requires jQuery v1.5 or later
 * Copyright (c) 2014 Shapeways
 * Examples and documentation at: http://shapejs.shapeways.com
 * Project repository: https://github.com/Shapeways/ShapeJs
 * License: MIT
 */
var executeShapeJs = function(script, params, success, failure){
    failure = failure || function(){};
    var defaultParams = {
        persistent: false,
        pipeline: "VolumeSculptorProcessing",
        action: "preview",
        accuracy: "VISUAL",
        previewQuality: "LOW",
        regions: "ONE",
        visRemovedRegions: false,
        optimizeX3D: true,
        script: script,
        generateImage: false,
    };
    var processData = true;
    if(params instanceof FormData){
        processData = false;
        for(var i in defaultParams){
            params.append(i, defaultParams[i]);
        }
    } else{
        jQuery.extend(params, defaultParams);
    }

    var options = {
        method: "POST",
        timeout: 180000,
        data: params,
        dataType: "JSON",
        processData: processData,
        success: function(data){
            if(!data || !data.state){
                return failure("invalid response from server");
            }

            var state = data.state;
            var results = {};
            for(var key in state){
                if(key.indexOf("VolumeSculptor.") === 0){
                    results[key.substring(15)] = state[key];
                } else if(key == "Aopt.output"){
                    for(var i in state["Aopt.output"]){
                        var next = state["Aopt.output"][i];
                        if(~next.indexOf(".x3d")){
                            results.modelPreviewUrl = next;
                            break;
                        }
                    }
                }
            }

            if(results.output){
                results.modelUrl = results.output;
                delete results.output;
            }

            if(parseInt(results.exitCode) === 0){
                return success(results);
            } else{
                return failure(results);
            }
        },
        error: function(data){
            failure(data);
        },
    };

    currentCall = jQuery.ajax("http://www.shapeways.com/creator/exec_pipeline_proxy", options);
};

var loadShapeJsPreview = function(targetSelector, modelUrl, width, height){
    width = width || 300;
    height = height || 300;
    var src = "https://images.shapeways.com/3dviewer/aopt-file?aoptFilePath=";
    src += modelUrl + "&width=" + width + "&height=" + height;

    var element = jQuery(targetSelector);
    if(element.children("#shapejs-preview").length){
        element.children("#shapejs-preview").attr("src", src);
    } else{
        element.append('<iframe id="shapejs-preview" src="' + src + '" height="100%" width="100%"></iframe>');
    }
};

(function($){
    var currentCall = null;

    $.fn.executeShapeJs = function(params, success, failure, abortInProgress){
        abortInProgress = (abortInProgress === undefined)? true : abortInProgress;
        if(abortInProgress && currentCall){
            currentCall.abort();
        }
        var script = JSON.stringify($(this).val());
        currentCall = executeShapeJs(script, params, success, failure);
    };

    $.fn.loadShapeJsPreview = function(modelUrl, width, height){
        var target = $(this);
        loadShapeJsPreview(target, modelUrl, width, height);
    };
})(jQuery);
