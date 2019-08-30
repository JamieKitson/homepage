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

mkdir -p cache

for value in flickrMine flickrFavs flickrOwnFavs flickrMe instagramOwn
do
    php flickr/$value.php > cache/$value.html
done

for value in twitter blog youtube
do
    php $value.php > cache/$value.html
done

php index.php > index.html

php flickr/index.php > flickr/index.html

