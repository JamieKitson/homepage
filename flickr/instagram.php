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
        $title = htmlentities($a['caption'].' by '.$a['username']);
        echo '<a href="'.$a['permalink'].'">';
        $src = $a['media_url'];
        echo '<img width=75 height=75 src="'.$src.'" alt="'.$title.'" title="'.$title.'"></a>'."\n";
    }
}

?>
