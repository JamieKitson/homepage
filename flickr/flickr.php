<?php

function flickrCall($params, $sign = true)
{

	$params['api_key']      = 'aa86e4774d7520f7373e8615ba5b7e00';
	$params['format']       = 'php_serial';
	$params['per_page']     =  20;
	$params['extras']	= 'owner_name';
	$params['sort']		= 'date-posted-desc';

	$f = file(dirname(__FILE__).'/secret.php');
	$secret = trim($f[1]);

	if ($sign)
	{
		$f = file(dirname(__FILE__).'/token.php');
		$params['auth_token'] = trim($f[1]);
	}

	$encoded_params = array();

	foreach ($params as $k => $v)
	{
        	$encoded_params[] = "$k=$v"; // urlencode($k).'='.urlencode($v);
	}

	sort($encoded_params);
	$p = implode('&', $encoded_params);
	$m = md5($secret.str_replace(array("&", "="), "",$p));

	$url = "http://api.flickr.com/services/rest/?$p&api_sig=$m";

	// echo "<!-- $url -->\n";

	$rsp = @file_get_contents($url);

	$p = unserialize($rsp);

	foreach($p['photos']['photo'] as $a)
	{
		if ($a['id'] == '')
			continue;
		// $title = htmlentities($a['title'].' by '.$a['ownername'], ENT_QUOTES, UTF-8);
		$title = htmlentities($a['title'].' by '.$a['ownername']);
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
    		'mini_token' => trim(file_get_contents('mini-token')) 
	);
	flickrCall($params);
}

?>
