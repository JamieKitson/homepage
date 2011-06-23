<?php

        include_once 'twitterLink.php';

        // $url = 'http://twitter.com/statuses/user_timeline/jamiekitson.rss?count=10';
        // foreach($xml->channel->item as $i)
	// print_r($xml);

	$url = 'http://api.twitter.com/1/statuses/user_timeline.xml?screen_name=jamiekitson&count=10&include_rts=1';

        $xml = simplexml_load_string(@file_get_contents($url));
        foreach($xml->status as $i)
        {
                echo '<div class="twitterpost">';
                // echo substr(linkify_twitter_status($i->text), 12);
                echo linkify_twitter_status($i->text);
                echo '<div class="twitterdate">';
		// <a class="twitterdate" href="'.$i->link.'">'.date('D M d H:i', strtotime($i->created_at))."</a>";
		echo statusLink($i->id, 'jamiekitson', date('D M d H:i', strtotime($i->created_at)));
		if ($i->in_reply_to_status_id != '')
			echo statusLink($i->in_reply_to_status_id, $i->in_reply_to_screen_name, 'In reply to '.$i->in_reply_to_screen_name);
		echo "</div></div>\n";
        }

function statusLink($statusID, $userName, $linkText)
{
	return '<a class="twitterdate" href="http://twitter.com/'.$userName.'/statuses/'.$statusID.'">'.$linkText.'</a> ';
}

?>
