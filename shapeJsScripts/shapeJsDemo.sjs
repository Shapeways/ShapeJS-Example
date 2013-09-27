var voxelSize = 0.1*MM;

// controls the level of decimation.  The higher this is, the more decimation is used.
meshErrorFactor=1;

function makePart(path, width, height, thickness){

    var img = new ImageBitmap(path, width, height, thickness);
    img.setBaseThickness(0.0);
    img.setVoxelSize(voxelSize);
    img.setBlurWidth(2*voxelSize);
    img.setImagePlace(ImageBitmap.IMAGE_PLACE_TOP);

    return img;
}

function main(args) {
    var image = args[3];

    var th = args[0]*MM;
    var height = args[1]*MM;
    var width = args[2]*MM;

    var xGrid = width/2;
    var yGrid = height/2;
    dest = createGrid(-xGrid,xGrid,-yGrid,yGrid,0,th ,voxelSize);

    var img = makePart(image, width, height, th);
    var maker = new GridMaker();
    maker.setSource(img);

    maker.makeGrid(dest);
    return dest;

}
