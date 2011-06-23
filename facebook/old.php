<script type="text/javascript">

function cl()
{

    Facebook.showPermissionDialog('publish_stream', ondone);

}

function ondone(params)
{
alert(params);
} 

</script>

<?php

echo print_r(parse_url('http://www.facebook.com/l.php?u=http%253A%252F%252Fwww.bbc.co.uk%252Fprogrammes%252Fb00pwn7r&h=96561f6fa941db4ca6f42cf74d8f980e'));



// Copyright 2007 Facebook Corp.  All Rights Reserved. 
// 
// Application: Portal
// File: 'index.php' 
//   This is a sample skeleton for your application. 
// 

require_once 'facebook-platform/php/facebook.php';

$appapikey = 'cc9678acde5945726dff52d120a34943';
$appsecret = '1736ea7084869f7879d3fd4d198a3972';
$facebook = new Facebook($appapikey, $appsecret);
// $user_id = $facebook->require_login();
/*
$q = 'SELECT name, filter_key, type FROM stream_filter WHERE uid = 835135340';
$q = "SELECT post_id, actor_id, target_id, message FROM stream WHERE filter_key in (SELECT filter_key FROM stream_filter WHERE uid = 835135340 AND type = 'newsfeed')";
$q = 'SELECT type FROM stream_filter where uid = 835135340';
$q = $facebook->api_client->fql_query($q);
//echo print_r($q);
*/

// echo '='.$facebook->api_client->session_key.'=';

$user_id = 835135340;
$facebook->set_user(835135340, '4bd01053d967b2613148f3ce-835135340', '0' );  

// the third parameter is the expires 
// $facebook->promoteSession();  // this generates the session secret

// Greet the currently logged-in user!
// echo "<p>Hello, <fb:name uid=\"$user_id\" useyou=\"false\" />!</p>";

// Print out at most 25 of the logged-in user's friends,
// using the friends.get API method
/*
echo "<p>Friends:";
$friends = $facebook->api_client->friends_get();
$friends = array_slice($friends, 0, 25);
foreach ($friends as $friend) {
  echo "<br>$friend";
}
*/

//$a = $facebook->showPermissionDialog('offline_access,read_stream', 'ondone', true);
//echo print_r($a);

/*

46 - post
80 - link
237 - flickr
none - prof pic, note
11 - group
56 - wall post

*/



$a = $facebook->api_client->stream_getFilters(835135340, '4bd01053d967b2613148f3ce');
// echo print_r($a);
$b = $facebook->api_client->stream_get('835135340','835135340','','', 100, '','');
echo print_r($b[posts]);

$t = array(11, 46, 80);

foreach ($b[posts] as $p)
{
//if (!strpos($p[attribution], 'Flickr') && !strpos($p[attribution], 'Twitter') && ($p[actor_id] == 835135340))
if (in_array($p[type], $t) && !strpos($p[attribution], 'Twitter'))
{
if (isset($p[attachment][media]))
{
	echo $p[attachment][name].'a';
//	echo $p[attachment][media][0][href].'c';
}
else
	echo $p[message].'b';
echo "<br>\n";
//	echo print_r($p)."<br>\n";
}
}

function ondone($a)
{
echo 'a'.print_r($a);
}

//echo '->'.$_POST[fb_sig_session_key].'<-';     //provided user had granted offline_access



?>
<br>
<fb:prompt-permission perms="read_stream,offline_access"> Grant permission for status updates </fb:prompt-permission>
<br>

<!--script type="text/javascript">
    FB.Connect.showPermissionDialog('read_stream,offline_access', ondone);
        function ondone(a){ alert(a); } 
	</script-->


<!--div oncliick="cl()">abc</div-->

