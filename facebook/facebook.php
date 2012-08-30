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
			if ($p['attribution'] == 'Twitter')
			        $p['type'] = 46;

			switch ($p['type']) 
			{
				case 46: $c += procPost($p); break;
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

function procPost($p)
{
	if (($p['attribution'] == 'Twitter' || $p['attribution'] == 'Yahoo!') && $p['comments']['count'] == 0)
		return 0;
	echo '<div class="facebookstatus">';
	echo linkify_twitter_status($p['message']);
	faceDate($p);
	echo "</div>\n";
	return 1;
}

function procLink($l)
{

// print_r($l);

	if (($l['attribution'] == 'Twitter' || $l['attribution'] == 'Yahoo!') && $l['comments']['count'] == 0)
		return 0;

	echo '<div class="facebooklink">';
	$title = $l['attachment']['name'];
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
	if (is_array($l['attachment']['media']))
	{
		echo '<a class="facebooklink" href="'.htmlspecialchars($href).'">';
		echo '<img class="facebooklink" src="'.htmlentities($l['attachment']['media'][0]['src']).'" alt="'.$title.'">';
		echo '</a>';
	}
	echo '<div class="facebooklinkcomment">'.htmlentities($l['message'], ENT_QUOTES).'</div>';
	echo '<div><a class="facebooklink" href="'.htmlspecialchars($href).'">'.htmlspecialchars($title).'</a></div>';
	echo '<div class="facebooklinksite">'.htmlspecialchars($l['attachment']['caption']).'</div>';
	echo '<div class="facebooklinkdesc">'.htmlspecialchars($l['attachment']['description']).'</div>';
	faceDate($l);
	echo "</div>\n";
	return 1;
}

function faceDate($l)
{
	echo '<div class="facebookdate"><a href="'.htmlentities($l['permalink']).'">';
	echo date('D j M \a\t H:i', $l['created_time'] + 8*60*60).'</a></div>';
	echo '<div class="clear"></div>'; // for float: left images
	if ($l['comments']['count'] > 0)
	{
		echo '<div class="facebookcomments"><a href="'.htmlentities($l['permalink']).'">View ';
		echo $l['comments']['count'].' comments</a></div>';
	}
}


?>
