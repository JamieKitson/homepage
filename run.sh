#!/bin/bash

for value in flickrMine flickrFavs flickrOwnFavs flickrMe instagramOwn
do
    php updateCache.php flickr/$value.php cache/$value.html
done

for value in twitter blog youtube
do
    php updateCache.php $value.php cache/$value.html
done

