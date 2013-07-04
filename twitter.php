<?php

        include_once 'twitterLink.php';
	include 'twittertoken.php';

	$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=jamiekitson&count=10&include_rts=1&include_entities=1';

	$ch = curl_init( $url );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $twittertoken));

	$response = curl_exec( $ch );

	$xml = json_decode($response);

        foreach($xml as $i)
        {
		$date = strtotime($i->created_at);
		$id = $i->id;
		$status = "";
		if (property_exists($i, "retweeted_status"))
		{
			$i = $i->retweeted_status;
			$status = "RT @".$i->user->screen_name.": ";
		}
                echo '<div class="twitterpost">';
		$status .= $i->text;
		expandURLs($i->entities->urls, $status);
		if (property_exists($i->entities, "media"))
			expandURLs($i->entities->media, $status);
                echo linkify_twitter_status($status);
                echo '<div class="twitterdate">';
                echo statusLink($id, 'jamiekitson', date('D M d H:i', $date));
                if ($i->in_reply_to_status_id != '')
                        echo statusLink($i->in_reply_to_status_id, $i->in_reply_to_screen_name, 'In reply to '.$i->in_reply_to_screen_name);
                echo "</div></div>\n";
        }

function statusLink($statusID, $userName, $linkText)
{
        return '<a class="twitterdate" href="http://twitter.com/'.$userName.'/statuses/'.$statusID.'">'.$linkText.'</a> ';
}

function expandURLs($urls, &$stat)
{
	foreach($urls as $url)
	{
		$stat = str_replace($url->url, $url->expanded_url, $stat);
	}
}

?>

