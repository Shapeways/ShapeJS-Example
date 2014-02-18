ShapeJs
=======

ShapeJS is a 3D graphics library that can help you generate printable 3D models.
For more information, go to http://shapejs.shapeways.com/.

## Installing
### With Bower
```bash
bower install shapejs
```

## API
See `examples` directory for example usage.

### `$.fn.executeShapeJs(params, success, [failure])`
Take the `.val()` of the selected element, `JSON.stringify` it and pass
to `execureShapeJs`.

```javascript
$("#shapejs-script").executeShapeJs({}, function(result){ ... }, function(error){ ... });
```

`params` can be either an object or [FormData](https://developer.mozilla.org/en-US/docs/Web/API/FormData).
`success` is a callback to handle the successful result.
`failure` is a callback to handle any exceptions.

### `$.fn.loadShapeJsPreview(previewUrl, width, height)`
Load a ShapeJs model preview into an iframe in the selected element.

The following are the same:
```javascript
loadShapeJsPreview("#preview", previewUrl, width, height);

$("#preview").loadShapeJsPreview(previewUrl, width, height);
```

`previewUrl` this is the `modelPreviewUrl` from the result.
`width` the width in pixels that the preview should be.
`height` the height in pixels that the preview should be.

### `executeShapeJs(script, params, success, [failure])`
Execute a ShapeJs script.

```javascript
var script = 'function main(args){ ... }';
executeShapejs(script, {}, function(result){ ... }, function(error){ ... });
```

`script` a ShapeJs script, this must be `JSON.stringify`'d.
`params` can be either an object or [FormData](https://developer.mozilla.org/en-US/docs/Web/API/FormData).
`success` is a callback to handle the successful result.
`failure` is a callback to handle any exceptions.

### `loadShapeJsPreview(selector, previewUrl, width, height)`
Load a ShapeJs model preview into an iframe in the given `selector`

```javascript
loadShapeJsPreview("#preview", previewUrl, width, height);

$("#preview").loadShapeJsPreview(previewUrl, width, height);
```

`selector` a jQuery selector for the element to load the preview into (should be a div).
`previewUrl` this is the `modelPreviewUrl` from the result.
`width` the width in pixels that the preview should be.
`height` the height in pixels that the preview should be.

## License
```
The MIT License (MIT) Copyright (c) 2014 Shapeways <api@shapeways.com> (http://developers.shapeways.com)

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A
PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF
CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE
OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
```
