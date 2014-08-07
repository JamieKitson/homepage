<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once dirname(__FILE__).'/../twitterLink.php';
require_once dirname(__FILE__).'/facebook-platform/php/facebook.php';

$appapikey = 'cc9678acde5945726dff52d120a34943';
$f = file(dirname(__FILE__).'/secret.php');
$appsecret = trim($f[1]);
$f = file(dirname(__FILE__).'/key.php');
$sessionkey = trim($f[1]);

$facebook = new Facebook($appapikey, $appsecret);
$facebook->set_user(835135340, $sessionkey.'-835135340', '0' );

fb($facebook);

/*

46 - post
80 - link
237 - flickr, twitter
247 - facebook photos
none - prof pic, note
11 - group
56 - wall post

*/

function fb($facebook)
{

	$facebook->clear_cookie_state();
	$b = $facebook->api_client->stream_get('835135340', '835135340','','', 100, '','');

// echo print_r($b);

	$c = 0;

	for ($i = 0; $c < 10 && $i < count($b['posts']); $i++)
	{
		$p = $b['posts'][$i];
		if ($p['actor_id'] == '835135340')
		{
            // Don't treat tweets as links
//			if ($p['attribution'] == 'Twitter')
//			        $p['type'] = 46;

			switch ($p['type']) 
			{
				case 46: // $c += procPost($p); break;
				case 237: 
				case 247:
				case 80: $c += procLink($p); break;
			}
		}
	}

}

function procComments($p)
{
	if (is_array($p['comments']['comment_list']))
	{
		foreach($p['comments']['comment_list'] as $c)
			echo '<div class="facebookcomment">'.$c['text']."</div>\n";
	}
}

function ignorePost($p)
{
    $ignore = Array('Flickr', 'Twitter', 'Yahoo!');
	if (in_array($p['attribution'], $ignore) && $p['comments']['count'] == 0)
		return true;
    return false;
}

function procPost($p)
{
	if (ignorePost($p))
		return 0;
	echo '<div class="facebookstatus">';
    $status_text = myEncode($p['message']);
	echo linkify_twitter_status($status_text);
	faceDate($p);
	echo "</div>\n";
	return 1;
}

function procLink($l)
{

// print_r($l);

	if (ignorePost($l))
		return 0;

	echo '<div class="facebooklink">';
    if (array_key_exists('name', $l['attachment']))
	    $title = myEncode($l['attachment']['name']);
	if (array_key_exists('href', $l['attachment']))
	{
		$href = $l['attachment']['href'];
		$q = parse_url($href, PHP_URL_QUERY);
		foreach(explode('&', $q) as $u)
		{
			$v = explode('=', $u);
			if ($v[0] == 'u')
			{
				$href = urldecode(urldecode($v[1]));
				break;
			}
		}
	}
	else
	{
		$href = $l['permalink'];
	}
	if (array_key_exists('media', $l['attachment']) && is_array($l['attachment']['media']))
	{
		echo '<a class="facebooklink" href="'.myEncode($href).'">';
		echo '<img class="facebooklink" src="'.myEncode($l['attachment']['media'][0]['src']).'" alt="'.$title.'">';
		echo '</a>';
	}
	echo '<div class="facebooklinkcomment">'.myEncode($l['message']).'</div>';
    if (isset($title))
    	echo '<div><a class="facebooklink" href="'.myEncode($href).'">'.$title.'</a></div>';
    if (array_key_exists('caption', $l['attachment']))
	    echo '<div class="facebooklinksite">'.myEncode($l['attachment']['caption']).'</div>';
    echo '<div class="facebooklinkdesc">'.myEncode($l['attachment']['description']).'</div>';
	faceDate($l);
	echo "</div>\n";
	return 1;
}

function myEncode($s)
{
    return htmlentities($s, ENT_QUOTES, 'UTF-8');
}

function faceDate($l)
{
	echo '<div class="facebookdate"><a href="'.myEncode($l['permalink']).'">';
	echo date('D j M \a\t H:i', $l['created_time']).'</a></div>';
	echo '<div class="clear"></div>'; // for float: left images
	if ($l['comments']['count'] > 0)
	{
		echo '<div class="facebookcomments"><a href="'.myEncode($l['permalink']).'"><span class="view">View ';
		echo $l['comments']['count'].' comments</span></a></div>';
	}
}


?>
