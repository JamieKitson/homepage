<?php

include('resize.php');

function instagram($url)
{
/*
    $sessionFile = $_SERVER['HOME'].'/.config/instaloader/session-rudolphjoshua2025';
    
    if (file_exists($sessionFile))
    {
        error_log("deleting session file $sessionFile");
        unlink($sessionFile);
    }
    else
        error_log("session file $sessionFile does not exist");
*/

    $f = file(dirname(__FILE__).'/instaloaderUsername.php');
	$username = trim($f[1]);
    $f = file(dirname(__FILE__).'/instaloaderPassword.php');
	$password = trim($f[1]);

    $command = escapeshellcmd(__DIR__."/instaloader.py --no-videos --no-profile-pic -l $username -p \"$password\" --dirname-pattern ".__DIR__.'/instagram -c 20 --no-compress-json jamiekitson');

    error_log($command);

    $output = shell_exec($command);

    error_log($output);

    foreach (glob(__DIR__."/instagram/20*.json") as $filename) {
        // echo "$filename size " . filesize($filename) . "\n";

/*
        $command = "xz -dc " . escapeshellarg($filename);
        $fileHandle = popen($command, 'r');

        //$fileHandle = fopen($filename, 'r');
        //stream_filter_append($fileHandle, 'compress.zlib.decompress');

        $jsonContent = stream_get_contents($fileHandle);

        pclose($fileHandle);
*/
        $jsonContent = file_get_contents($filename);

        //echo $jsonContent;
        $data = json_decode($jsonContent, true);
        //print $data;
        $shortcode = $data['node']['shortcode'];
        $title = $data['node']['caption'];
        $jpgFile = str_replace('.json', '.jpg', $filename);
        if (!file_exists($jpgFile) && !file_exists($jpgFile = str_replace('.jpg', '_1.jpg', $jpgFile)))
        {
            throw new Exception('Unable to find file '.$jpgFile);
        }

        echo '<a href="https://www.instagram.com/p/'.$shortcode.'/">';
        echo '<img width=75 height=75 src="/flickr/instagram/'.basename($jpgFile).'" alt="'.$title.'" title="'.$title.'"></a>'."\n";

    }
/*
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

    try
    {
    $refresh = @file_get_contents('https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token='.$token);
        $j = json_decode($refresh, true);
        $days = $j["expires_in"] / (60 * 60 * 24);
        echo "<!-- $days -->";
    }
    catch (Exception $e)
    {
        echo "<!-- error refreshing instagram token -->";
    }
*/
}

?>
