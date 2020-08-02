<?php

function resize($src, $file)
{
        $contents = file_get_contents($src);
        file_put_contents($file, $contents);
        try
        {
        $image = @imagecreatefromjpeg($file);
        }
        catch(Exception $ex)
        {
        $image = imagecreatefrompng($file);
        }
        $imgResized = imagescale($image, 150, 150);
        imagedestroy($image);
        imagejpeg($imgResized, $file);
        imagedestroy($imgResized);
}

?>
