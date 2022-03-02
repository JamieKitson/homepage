<!DOCTYPE html>
<html>
<head>
<title>Jamie Kitson's Flickr Portal</title>
<link rel="stylesheet" type="text/css" href="../style.css" />
</head>
<body>

<div class="top" id="top">
<h1>Jamie Kitson's Flickr Portal</h1>
</div>

<div class="content" id="flickr">

<h2><a href="https://flickr.com/jamiekitson">My Photos</a></h2>

<?php

// echo flickrSearch(array('user_id' => '77788903@N00'));
echo file_get_contents('flickr/flickrMine.html');

echo '<h2><a href="https://flickr.com/photos/tags/jamiekitson">Photos Of Me Me Me</a></h2>';

// echo flickrSearch(array('tags' => 'jamiekitson'));
echo file_get_contents('flickr/flickrMe.html');

echo '<h2><a href="https://flickr.com/photos/jamiekitson/tags/myfavs/">my own favs</a></h2>';

// echo flickrSearch(array('user_id' => '77788903@N00', 'tags' => 'myfavs'));
echo file_get_contents('flickr/flickrOwnFavs.html');

echo '<h2><a href="https://flickr.com/photos/jamiekitson/favorites/">my favs</a></h2>';

// echo flickrCall(array('user_id' => '77788903@N00', 'method' => 'flickr.favorites.getPublicList'));
echo file_get_contents('flickr/flickrFavs.html');

try
{
include('feedsecret.php');

$url = "https://api.flickr.com/services/feeds/activity/all?user_id=77788903@N00&secret=$feedsecret&lang=en-us&format=rss_200";

// echo file_get_contents($url);

        $xml = simplexml_load_file($url);

echo '<h2>recent activity</h2>';

        foreach($xml->channel->item as $i)
        {
		echo '<div class="flickrcomment">'.str_replace('href="/photos', 'href="https://www.flickr.com/photos', $i->description).'</div>';
	}
}
catch (Exception $e)
{
    echo "<!-- error getting flickr activity -->";
}

?>
</div>
</body>
</html>
