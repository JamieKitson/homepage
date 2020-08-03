<?php

function resize($src, $file, $newheight = 150)
{
    $file = $file.".jpg";
    $contents = file_get_contents($src);
    file_put_contents($file, $contents);
    list($width, $height, $imgType, $attr) = getimagesize($file);
    switch($imgType)
    {
        case IMAGETYPE_JPEG: 
            $image = imagecreatefromjpeg($file); 
            break;
        case IMAGETYPE_PNG: 
            $temp = imagecreatefrompng($file);
            $image = imagecreatetruecolor($width, $height);
            imagefill($image, 0, 0, imagecolorallocate($image, 255, 255, 255));
            imagealphablending($image, TRUE);
            imagecopy($image, $temp, 0, 0, 0, 0, imagesx($temp), imagesy($temp));
            imagedestroy($temp);
            break;
        default: 
            throw new Exception("Unknown image type: ".$imgType);
    }
    $newwidth = $newheight * $width / $height;
    $imgResized = imagescale($image, $newwidth);
    imagedestroy($image);
    imagejpeg($imgResized, $file);
    imagedestroy($imgResized);
    return $file;
}

?>
