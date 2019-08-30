#!/bin/bash

#cd ~/homepage

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
secret_file "twittertoken.php" "\$twittertoken = \"$TWITTER_TOKEN\";"

for value in flickrMine flickrFavs flickrOwnFavs flickrMe instagramOwn
do
    php updateCache.php flickr/$value.php cache/$value.html
done

for value in twitter blog youtube
do
    php updateCache.php $value.php cache/$value.html
done

php index.php > index.html

cd flickr

php index.php > index.html

#cd ..

#git commit index.html flickr/index.html cache/* -m "update cache"

#git push
