<?php

function instagram($url)
{
	$f = file(dirname(__FILE__).'/instagramToken.php');
	$token = trim($f[1]);

	$url.='?count=20&fields=caption,id,thumbnail_url,media_url,username,permalink&access_token='.$token;

	$rsp = @file_get_contents($url);

//	print_r($rsp);

	$j = json_decode($rsp, true);

//	print_r($j);

    for($i = 0; $i < 20; $i++)
    {
        $a = $j['data'][$i];
        $src = $a['media_url'];
        $id = $a['id'];
        $contents = file_get_contents($src);
        $file = __DIR__.DIRECTORY_SEPARATOR.$id.'.jpg';
        file_put_contents($file, $contents);
        $image = imagecreatefromjpeg($file);
        $imgResized = imagescale($image, 75, 75);
        imagedestroy($image);
        imagejpeg($imgResized, $file);
        imagedestroy($imgResized);
        $title = htmlentities($a['caption'].' by '.$a['username']);
        echo '<a href="'.$a['permalink'].'">';
        echo '<img width=75 height=75 src="flickr/'.$id.'.jpg" alt="'.$title.'" title="'.$title.'"></a>'."\n";
    }
}

?>
