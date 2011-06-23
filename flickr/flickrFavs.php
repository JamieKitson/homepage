<?php

include('flickr.php');

flickrCall(array('user_id' => '77788903@N00', 'method' => 'flickr.favorites.getPublicList'), false);

?>
