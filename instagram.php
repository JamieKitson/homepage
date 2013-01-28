<?

	$f = file(dirname(__FILE__).'/instagramToken.php');
	$token = trim($f[1]);

	$url='https://api.instagram.com/v1/users/34072014/media/recent/?access_token='.$token;

	$rsp = @file_get_contents($url);

	$j = json_decode($rsp, true);

//	print_r($j);

        foreach($j['data'] as $a)
        {
                $title = htmlentities($a['caption']['text'].' by '.$a['caption']['from']['full_name']);
                echo '<a href="'.$a['link'].'">';
                $src = $a['images']['thumbnail']['url'];
                echo '<img width=75 height=75 src="'.$src.'" alt="'.$title.'" title="'.$title.'"></a>'."\n";
        }


?>
