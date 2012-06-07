<?php

function atom($url)
{
	$xml = simplexml_load_string(@file_get_contents($url));

	if (empty($xml->entry))
		return;

        foreach($xml->entry as $e)
        {
                echo '<div class="postdate">'.date('l, F j, Y', strtotime($e->published))."</div>";

                echo '<h3>';
                foreach($e->link as $l)
                {
			$rel = $l->attributes()->rel[0];
                        if ($rel == '' || $rel == 'alternate')
                        {
                                $link = '<a href="'.$l->attributes()->href[0].'">';
                                break;
                        }
                }
                echo $link.$e->title."</a></h3>\n";
                echo '<div class="post">'.substr(strip_tags($e->content), 0, 300);
                echo $link."...</a></div>\n";
        }
}

?>
