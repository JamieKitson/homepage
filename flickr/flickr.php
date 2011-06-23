<?php

function flickrCall($params, $sign = true)
{

	$params['api_key']      = '91635246b156193b6ed2a50259d83567';
	$params['format']       = 'php_serial';
	$params['per_page']     =  20;
	$params['extras']	= 'owner_name';
	$params['sort']		= 'date-posted-desc';

	if ($sign)
		$params['auth_token'] = '72157625029776678-525f355ed66e7cfd';

	$encoded_params = array();

	foreach ($params as $k => $v)
	{
        	$encoded_params[] = "$k=$v"; // urlencode($k).'='.urlencode($v);
	}

	sort($encoded_params);
	$p = implode('&', $encoded_params);
	$m = md5("9896da509d80fd2e".str_replace(array("&", "="), "",$p));

	$url = "http://api.flickr.com/services/rest/?$p&api_sig=$m";

	// echo "<!-- $url -->\n";

	$rsp = @file_get_contents($url);

	$p = unserialize($rsp);

	foreach($p['photos']['photo'] as $a)
	{
		if ($a['id'] == '')
			continue;
		// $title = htmlentities($a['title'].' by '.$a['ownername'], ENT_QUOTES, UTF-8);
		$title = $a['title'].' by '.$a['ownername'];
		echo '<a href="http://flickr.com/photos/'.$a['owner'].'/'.$a['id'].'/">';
		$src = 'http://farm'.$a['farm'].'.static.flickr.com/'.$a['server'].'/'.$a['id'].'_'.$a['secret'].'_s.jpg';
		echo '<img width=75 height=75 src="'.$src.'" alt="'.$title.'" title="'.$title.'"></a>'."\n";
	}
}

function flickrSearch($params)
{
	$params['method']        = 'flickr.photos.search';
	$params['privacy_filter']= 1;
	flickrCall($params);
}

function auth()
{
	$params = array( 
    		'method' => 'flickr.auth.getFullToken',
    		'mini_token' => '204-121-649' 
	);
	flickrCall($params);
}

?>
