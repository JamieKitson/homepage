<?

//	$url = 'https://api.instagram.com/v1/users/self/feed?access_token=34072014.0cc56bb.f86b7ce69b2c4773afdc8ad5aaaf9ba9';
	$url='https://api.instagram.com/v1/users/34072014/media/recent/?access_token=34072014.0cc56bb.f86b7ce69b2c4773afdc8ad5aaaf9ba9';

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
