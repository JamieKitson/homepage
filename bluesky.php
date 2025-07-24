<?php

include 'blueskypassword.php';
include 'twitterLink.php';

/*
$resolveHandle = file_get_contents("https://bsky.social/xrpc/com.atproto.identity.resolveHandle?handle=jamiek.it");

echo $resolveHandle;

$id = json_decode($resolveHandle, true)["did"];

echo $id;
*/
$id = "did:plc:q5yll4tu6fdivtkx7tpitjhg";

$sessionData = Array("identifier" => $id, "password" => $blueskypassword);

$options = array(
  'http' => array(
    'method'  => 'POST',
    'content' => json_encode( $sessionData ),
    'header'=>  "Content-Type: application/json"
    )
);

$context  = stream_context_create( $options );
$result = file_get_contents( "https://bsky.social/xrpc/com.atproto.server.createSession", false, $context );
$response = json_decode( $result, true);

//echo $response["accessJwt"];

$options = array('http' => array(
    'method'  => 'GET',
    'header' => 'Authorization: Bearer '.$response["accessJwt"]
));
$context  = stream_context_create($options);
$response = file_get_contents("https://bsky.social/xrpc/app.bsky.feed.getAuthorFeed?actor=jamiek.it&limit=10", false, $context);

//echo $response;

//$response = json_decode( $result);

// file_put_contents( "bluesky.out", $response );


    $tweets = json_decode($response);

        foreach($tweets->feed as $tweet)
        {
            if (is_array($tweet))
                throw new Exception($response);

        $date = strtotime($tweet->post->record->createdAt);
        $status = $tweet->post->record->text;
        
        // Replace abreviated urls with full urls
        if (property_exists($tweet->post->record, 'facets')) {

            $facets = $tweet->post->record->facets;

            usort($facets, function ($a, $b) {
                return $b['index']['byteStart'] - $a['index']['byteStart'];
            });

            foreach ($facets as $facet) {
                $start = $facet->index->byteStart;
                $end = $facet->index->byteEnd;
                $length = $end - $start;

                // Get URI from first feature
                $uri = $facet->features[0]->uri ?? '';

                // Replace using byte-aware substr_replace
                $status = substr_replace($status, $uri, $start, $length);

            }

        }

        if ($tweet->post->author->handle != "jamiek.it")
        {
//            $tweet = $tweet->retweeted_status;
            $status = "RT @".$tweet->post->author->handle.": ".$status;
        }
                echo '<div class="twitterpost">';
        /*
        expandURLs($tweet->entities->urls, $status);
        if (property_exists($tweet->entities, "media"))
            expandURLs($tweet->entities->media, $status);
            */
        echo linkify_twitter_status($status);
        echo '<div class="twitterdate">';
        echo statusLink($tweet->post->uri, $tweet->post->author->handle, date('D M d H:i', $date));
        if (property_Exists($tweet, "reply"))
        {
                echo statusLink($tweet->reply->parent->uri, $tweet->reply->parent->author->handle, 'In reply to '.$tweet->reply->parent->author->displayName);
        }
        echo "</div></div>\n";
    }

function statusLink($statusID, $userName, $linkText)
{
        $parts = explode('/', $statusID);
        $id = end($parts);
        return sprintf('<a class="twitterdate" href="https://bsky.app/profile/%s/post/%s">%s</a> ',
            $userName, $id, $linkText);
}

function expandURLs($urls, &$stat)
{
    foreach($urls as $url)
    {
        $stat = str_replace($url->url, $url->expanded_url, $stat);
    }
}


?>
