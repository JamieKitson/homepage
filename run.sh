#!/bin/bash

#cd ~/homepage

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

cd ..

#git commit index.html flickr/index.html cache/* -m "update cache"

#git push
