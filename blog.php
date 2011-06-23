<?php

        $url = 'http://www.blogger.com/feeds/26970824/posts/default?max-results=5';
	$xml = simplexml_load_string(@file_get_contents($url));

        foreach($xml->entry as $e)
        {
                echo '<div class="blogdate">'.date('l, F j, Y', strtotime($e->published))."</div>";

                echo '<h3>';
                foreach($e->link as $l)
                {
                        if ($l->attributes()->rel[0] == 'alternate')
                        {
                                $link = '<a href="'.$l->attributes()->href[0].'">';
                                break;
                        }
                }
                echo $link.$e->title."</a></h3>\n";
                echo '<div class="blogpost">'.substr(strip_tags($e->content), 0, 300);
                echo $link."...</a></div>\n";
        }

?>
