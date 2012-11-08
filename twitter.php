<?php

        include_once 'twitterLink.php';

        $url = 'http://api.twitter.com/1/statuses/user_timeline.xml?screen_name=jamiekitson&count=10&include_rts=1&include_entities=1';

        $xml = simplexml_load_string(@file_get_contents($url));
        foreach($xml->status as $i)
        {
		$date = strtotime($i->created_at);
		$id = $i->id;
		$status = "";
		if ($i->retweeted_status)
		{
			$i = $i->retweeted_status;
			$status = "RT @".$i->user->screen_name.": ";
		}
                echo '<div class="twitterpost">';
		$status .= $i->text;
		expandURLs($i->entities->urls->url, $status);
		if ($i->entities->media)
			expandURLs($i->entities->media->creative, $status);
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

