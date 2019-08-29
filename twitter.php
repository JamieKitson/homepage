<?php

	include_once 'twitterLink.php';
	include 'twittertoken.php';

	$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=jamiekitson&count=10&include_rts=1&include_entities=1&tweet_mode=extended';

	$ch = curl_init( $url );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $twittertoken));

	$response = curl_exec( $ch );

	$tweets = json_decode($response);

        foreach($tweets as $tweet)
        {
		$date = strtotime($tweet->created_at);
		$status = "";
		if (property_exists($tweet, "retweeted_status"))
		{
			$tweet = $tweet->retweeted_status;
			$status = "RT @".$tweet->user->screen_name.": ";
		}
                echo '<div class="twitterpost">';
		$status .= $tweet->full_text;
		expandURLs($tweet->entities->urls, $status);
		if (property_exists($tweet->entities, "media"))
			expandURLs($tweet->entities->media, $status);
                echo linkify_twitter_status($status);
                echo '<div class="twitterdate">';
                echo statusLink($tweet->id_str, 'jamiekitson', date('D M d H:i', $date));
                if ($tweet->in_reply_to_status_id != '')
                {
                        echo statusLink($tweet->in_reply_to_status_id_str, $tweet->in_reply_to_screen_name, 'In reply to '.$tweet->in_reply_to_screen_name);
                }
                echo "</div></div>\n";
        }

function statusLink($statusID, $userName, $linkText)
{
        return sprintf('<a class="twitterdate" href="https://twitter.com/%s/statuses/%s">%s</a> ',
            $userName, $statusID, $linkText);
}

function expandURLs($urls, &$stat)
{
	foreach($urls as $url)
	{
		$stat = str_replace($url->url, $url->expanded_url, $stat);
	}
}

?>

