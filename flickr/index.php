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

<h2><a href="http://flickr.com/jamiekitson">My Photos</a></h2>

<?php

include '../cache.php';

// echo flickrSearch(array('user_id' => '77788903@N00'));
cachedHTML('flickr/flickrMine.php');

echo '<h2><a href="http://flickr.com/photos/tags/jamiekitson">Photos Of Me Me Me</a></h2>';

// echo flickrSearch(array('tags' => 'jamiekitson'));
cachedHTML('flickr/flickrMe.php');

echo '<h2><a href="http://flickr.com/photos/jamiekitson/tags/myfavs/">my own favs</a></h2>';

// echo flickrSearch(array('user_id' => '77788903@N00', 'tags' => 'myfavs'));
cachedHTML('flickr/flickrOwnFavs.php');

echo '<h2><a href="http://flickr.com/photos/jamiekitson/favorites/">my favs</a></h2>';

// echo flickrCall(array('user_id' => '77788903@N00', 'method' => 'flickr.favorites.getPublicList'));
cachedHTML('flickr/flickrFavs.php');

echo '<h2>recent activity</h2>';

$url = 'http://api.flickr.com/services/feeds/activity/all?user_id=77788903@N00&secret=1KwROhmNUwDBruPOF%2BPavr8RMEk%3D&lang=en-us&format=rss_200';

// echo file_get_contents($url);

        $xml = simplexml_load_file($url);
        foreach($xml->channel->item as $i)
        {
		echo '<div class="flickrcomment">'.$i->description.'</div>';
	}

?>
</div>
</body>
</html>
