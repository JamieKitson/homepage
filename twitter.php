<?php

        include_once 'twitterLink.php';

        $url = 'http://api.twitter.com/1/statuses/user_timeline.xml?screen_name=jamiekitson&count=10&include_rts=1&include_entities=1';

        $xml = simplexml_load_string(@file_get_contents($url));
        foreach($xml->status as $i)
        {
                echo '<div class="twitterpost">';
                $urls = $i->entities->urls;
                $status = str_replace($urls->url->url, $urls->url->expanded_url, $i->text);
                echo linkify_twitter_status($status);
                echo '<div class="twitterdate">';
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

