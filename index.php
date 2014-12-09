<!DOCTYPE html>
<html>
<head>

<link rel="openid.server" href="http://pip.verisignlabs.com/server" />
<link rel="openid.delegate" href="http://jamiekitson.pip.verisignlabs.com" />
<link rel="openid2.provider" href="http://pip.verisignlabs.com/server" />
<link rel="openid2.local_id" href="http://jamiekitson.pip.verisignlabs.com" />
<meta http-equiv="X-XRDS-Location" content="http://pip.verisignlabs.com/user/jamiekitson/yadisxrds" />

<!-- 
<link rel="openid.server" href="http://www.myopenid.com/server" />
<link rel="openid.delegate" href="http://jamiekitson.myopenid.com/" />
<link rel="openid2.local_id" href="http://jamiekitson.myopenid.com" />
<link rel="openid2.provider" href="http://www.myopenid.com/server" />
-->
<!-- meta http-equiv="X-XRDS-Location" content="http://www.myopenid.com/xrds?username=jamiekitson.myopenid.com" / -->

<title>Jamie Kitson</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="Description" content="The Jamie Kitson Portal: The latest photos from Flickr and Instagram, posts from Twitter, Facebook and his blog and videos from YouTube.">
<meta name="keywords" content="jamie,kitson,jamie kitson,jamiekitson">
</head>
<body>

<header class="top" id="top">
<a href="http://www.flickr.com/photos/jamiekitson/139027024/">
	<img src="http://farm5.static.flickr.com/4069/4274051526_071936111b_t.jpg" id="profilepic" alt="Jamie Kitson">
</a>
<h1>The Jamie Kitson Portal</h1>
<a href="&#109;a&#105;&#X6c;&#X0074;&#X6f;&#0058;&#X6a;&#0097;&#0109;&#0105;&#0101;&#00064;k&#X00069;&#116;&#X0074;&#00101;&#0110;&#00045;&#120;&#X2e;&#99;&#111;m">&#X6a;&#0097;&#0109;&#0105;&#0101;&#00064;k&#X00069;&#116;&#X0074;&#00101;&#0110;&#00045;&#120;&#X2e;&#99;&#111;m</a>
<a href="http://jamiekitson.com">CV</a>
<br>
Mongol Rally: <a href="http://geekout.org.uk">Team Geekout</a> 
</header>

<section class="content" id="flickr">
<h2><a href="http://www.flickr.com/photos/jamiekitson">Flickr</a></h2>
<div id="flickrcontainer" class="container">
<!-- h3><a href="http://www.flickr.com/photos/jamiekitson">My Photos</a></h3 -->
<?php

include_once 'cache.php';

cachedHTML('flickr/flickrMine.php');

?>
<div id="flickrmore1" class="flickrmore"><div id="flickrmore1inner" class="flickrmoreinner">
<h3><a href="http://www.flickr.com/photos/tags/jamiekitson">Photos of Me Me Me</a></h3>
<div id="flickrmore1params">flickrMe</div></div></div>

<div id="flickrmore2" class="flickrmore"><div id="flickrmore2inner" class="flickrmoreinner">
<h3><a href="http://www.flickr.com/Photos/jamiekitson/tags/myfavs/">My Own Favs</a></h3>
<div id="flickrmore2params">flickrOwnFavs</div></div></div>

<div id="flickrmore3" class="flickrmore"><div id="flickrmore3inner" class="flickrmoreinner">
</div>
<h3><a href="http://www.flickr.com/photos/jamiekitson/favorites/">My Favs</a></h3>
<div id="flickrmore3params">flickrFavs</div></div>

<div id="flickrlink">
<a href="flickr" class="flickrmorelink" id="flickrmorelink">[+]More from flickr...</a>
</div>
</div>
</section>

<section class="content" id="instagram">
<h2><a href="http://instagram.com/jamiekitson/">Instagram</a></h2>
<div id="instagramcontainer" class="container">
<?php

cachedHTML('flickr/instagramOwn.php');

?>

<div id="flickrmore4" class="flickrmore"><div id="flickrmore4inner" class="flickrmoreinner">
<h3>My Favs</h3>
<div id="flickrmore4params">instagramFavs</div></div></div>

<div id="instagramlink">
<a href="#" class="flickrmorelink" id="instagrammorelink">[+]My favourites...</a>
</div>

</div>
</section>

<!-- div class="content" id="geekout">
<h2><a href="http://geekout.org.uk">Team Geekout</a></h2>
<div id="geekoutcontainer" class="container"><div id="">
<?php

// cachedHTML('geekout.php');

?>
</div></div>
</div -->

<section class="content" id="twitter">
<h2><a href="http://twitter.com/jamiekitson">Twitter</a></h2>
<div id="twittercontainer" class="container">
<?php

cachedHTML('twitter.php');

?>
</div>
</section>

<section class="content" id="youtube">
<h2><a href="http://youtube.com/jamiekitson">YouTube</a></h2>
<div id="ytcontainer" class="container">
<?php

cachedHTML('youtube.php');

?>
</div>
</section>

<section class="content" id="blog">
<h2><a href="http://blog.jamiek.it">Blog</a></h2>
<div id="blogouter" class="container"><div id="bloginner">
<?php

cachedHTML('blog.php');

?>
</div></div>
</section>

<section class="content" id="facebook">
<h2><a href="http://www.facebook.com/mardybumhead">Facebook</a></h2>
<div id="facebookcontainer" class="container">
<?php 

cachedHTML('facebook/facebook.php');

?>
</div>
</section>

<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
<script src="pics.js"></script>

</body>
</html>
