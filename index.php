<!DOCTYPE html>
<html>
<head>
<link rel="openid.server" href="http://www.myopenid.com/server" />
<link rel="openid.delegate" href="http://jamiekitson.myopenid.com/" />
<link rel="openid2.local_id" href="http://jamiekitson.myopenid.com" />
<link rel="openid2.provider" href="http://www.myopenid.com/server" />
<!-- meta http-equiv="X-XRDS-Location" content="http://www.myopenid.com/xrds?username=jamiekitson.myopenid.com" / -->
<title>Jamie Kitson</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<script src="http://code.jquery.com/jquery-1.5.2.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript">

var id = 0;

function updateText()
{
	var l = document.getElementById('flickrmorelink');
       	switch(id) {
               	case 1: l.innerHTML = '[+]Even more from flickr...'; break;
                case 2: l.innerHTML = '[+]More more more from flickr...'; break;
       	        case 3: l.style.display = 'none';
        }
}

function get()
{
	id += 1;
	var params = document.getElementById('flickrmore' + id + 'params').innerHTML;
	// alert('/flickr/flickrSearch.php?' + unescape(params));
	$.ajax({
		url: '/flickr/flickrSearch.php?f=flickr' + params,
		success: showPics,
		error: 
				function (xhr, textStatus, thrownError) 
				{ 
					alert("An error occured contacting " + url + " status " + xhr.status + " error message: \n" + xhr.responseText); 
				}
	});
	return false;
}

function showPics(pics)
{
	// alert(pics);
	$('#flickrmore' + id + 'params').html(pics);
     	$('#flickrmore' + id).slideDown('slow', updateText);
}

function toggle(e)
{
	e.parent().next().slideToggle("slow");
	if (e.text() == '[-] ')
	{
		e.text('[+] ');
	}
	else
	{
		e.text('[-] ');
	}
}

$(document).ready(function() 
{
	$('#flickrmorelink').click(get);
	$('h2').prepend('<span class="control">[-] </span>');
	$('h2 a').css('position', 'absolute');
	$('.control').click( function() { toggle($(this)); } );
});

</script>
</head>
<body>

<div class="top" id="top">
<a href="http://www.flickr.com/photos/jamiekitson/139027024/">
	<img src="http://farm5.static.flickr.com/4069/4274051526_071936111b_t.jpg" id="profilepic" alt="Jamie Kitson">
</a>
<h1>The Jamie Kitson Portal</h1>
<a href="&#109;a&#105;&#X6c;&#X0074;&#X6f;&#0058;&#X6a;&#0097;&#0109;&#0105;&#0101;&#00064;k&#X00069;&#116;&#X0074;&#00101;&#0110;&#00045;&#120;&#X2e;&#99;&#111;m">&#X6a;&#0097;&#0109;&#0105;&#0101;&#00064;k&#X00069;&#116;&#X0074;&#00101;&#0110;&#00045;&#120;&#X2e;&#99;&#111;m</a>
<a href="http://jamiekitson.com">cv</a>
<br>
Mongol Rally: <a href="http://geekout.org.uk">Team Geekout</a> 
</div>

<div class="content" id="flickr">
<h2><a href="http://www.flickr.com/photos/jamiekitson">flickr</a></h2>
<div id="flickrcontainer" class="container">
<h3><a href="http://www.flickr.com/photos/jamiekitson">my photos</a></h3>

<?php

include_once 'cache.php';

cachedHTML('flickr/flickrMine.php');

?>
<div id="flickrmore1" class="flickrmore"><div id="flickrmore1inner" class="flickrmoreinner">
<h3><a href="http://www.flickr.com/photos/tags/jamiekitson">photos of me me me</a></h3>
<div id="flickrmore1params">Me</div></div></div>

<div id="flickrmore2" class="flickrmore"><div id="flickrmore2inner" class="flickrmoreinner">
<h3><a href="http://www.flickr.com/photos/jamiekitson/tags/myfavs/">my own favs</a></h3>
<div id="flickrmore2params">OwnFavs</div></div></div>

<div id="flickrmore3" class="flickrmore"><div id="flickrmore3inner" class="flickrmoreinner">
</div>
<h3><a href="http://www.flickr.com/photos/jamiekitson/favorites/">my favs</a></h3>
<div id="flickrmore3params">Favs</div></div>

<div id="flickrlink">
<a href="flickr" id="flickrmorelink">[+]More from flickr...</a>
</div>
</div>
</div>

<!-- div class="content" id="geekout">
<h2><a href="http://geekout.org.uk">Team Geekout</a></h2>
<div id="geekoutcontainer" class="container"><div id="">
<?php

// cachedHTML('geekout.php');

?>
</div></div>
</div -->

<div class="content" id="twitter">
<h2><a href="http://twitter.com/jamiekitson">twitter</a></h2>
<div id="twittercontainer" class="container">
<?php

cachedHTML('twitter.php');

?>
</div>
</div>

<div class="content" id="youtube">
<h2><a href="http://youtube.com/jamiekitson">YouTube</a></h2>
<div id="ytcontainer" class="container">
<?php

cachedHTML('youtube.php');

?>
</div>
</div>

<div class="content" id="blog">
<h2><a href="http://blog.jamiek.it">blog</a></h2>
<div id="blogouter" class="container"><div id="bloginner">
<?php

cachedHTML('blog.php');

?>
</div></div>
</div>

<div class="content" id="facebook">
<h2><a href="http://www.facebook.com/mardybumhead">facebook</a></h2>
<div id="facebookcontainer" class="container">
<?php 

cachedHTML('facebook/facebook.php');

?>
</div>
</div>

</body>
</html>
