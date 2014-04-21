<?php

include(dirname(__DIR__) . '/apps/library/Image.php');

$file = $_GET['file'];
$width = (int)$_GET['width'];
$height = (int)$_GET['height'];

$height = $height ? $height : $width;
$file = getcwd() . '/' . $file;

if( $width ){
    
    $img = new Image();
    $img->dstWidth  = $width;
    $img->dstHeight = $height;
    
    $img->showThumb($file);
}else{

	Image::showImg( $file );
}
