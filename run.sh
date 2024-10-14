#!/bin/bash

function secret_file {
cat > $1 << EOF
<?php
$2
?>
EOF
}

secret_file "youtubetoken.php" "\$apikey = \"$YOUTUBE_TOKEN\";"
secret_file "flickr/token.php" "$FLICKR_TOKEN"
secret_file "flickr/secret.php" "$FLICKR_SECRET"
secret_file "flickr/instagramToken.php" "$INSTAGRAM_TOKEN"
secret_file "twittertoken.php" "\$twittertoken = \"$TWITTER_TOKEN\";"
secret_file "flickr/feedsecret.php" "\$feedsecret = \"$FLICKR_FEED_SECRET\";"
secret_file "facebook/facebooktoken.php" "\$token = \"$FACEBOOK_TOKEN\";"
secret_file "blueskypassword.php" "\$blueskypassword = \"$BLUESKY_PASSWORD\";"
#wget "$TWITTER_URL" -O twitter.html

for value in flickrMine flickrFavs flickrOwnFavs flickrMe instagramOwn index
do
    php updateCache.php flickr/$value
done

for value in bluesky blog youtube facebook/facebook index #twitter
do
    php updateCache.php $value
done

