<?php

include('resize.php');

function instagram($url)
{
    $f = file(dirname(__FILE__).'/instagramToken.php');
	$token = trim($f[1]);

	$url.='?count=20&fields=caption,id,thumbnail_url,media_url,username,permalink&access_token='.$token;

	$rsp = file_get_contents($url);

//	print_r($rsp);

	$j = json_decode($rsp, true);

//	print_r($j);

    for($i = 0; $i < 20; $i++)
    {
        $a = $j['data'][$i];
        if (array_key_exists('thumbnail_url', $a))
        {
            $src = $a['thumbnail_url'];
        }
        else
        {
            $src = $a['media_url'];
        }
        $id = $a['id'];
        $file = __DIR__.DIRECTORY_SEPARATOR.$id;
        $file = basename(resize($src, $file, 150, 150));
        $title = htmlentities($a['caption'].' by '.$a['username']);
        echo '<a href="'.$a['permalink'].'">';
        echo '<img width=75 height=75 src="/flickr/'.$file.'" alt="'.$title.'" title="'.$title.'"></a>'."\n";
    }

    $refresh = file_get_contents('https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token='.$token);
    $j = json_decode($refresh, true);
    $days = $j["expires_in"] / (60 * 60 * 24);
    echo "<!-- $days -->";
}

?>
