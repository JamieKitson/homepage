<?php

    include dirname(__FILE__)."/facebooktoken.php";
    include "resize.php";

    $url = 'https://graph.facebook.com/10164155946480341/feed?fields=created_time,id,permalink_url,message,reactions,comments,caption,description,full_picture,icon,link,name,type&access_token='.$token;

    $rsp = file_get_contents($url);

//  print_r($rsp);

    $j = json_decode($rsp, true);

//  print_r($j);

    for($i = 0; $i < count($j['data']); $i++)
    {
        $a = $j['data'][$i];
		$i += procLink($a);
    }

function procLink($l)
{

// print_r($l);

    if (ignorePost($l))
        return 0;

    echo '<div class="facebooklink">';
    $title = "";
    if (array_key_exists('name', $l))
        $title = myEncode($l['name']);
    if (array_key_exists('link', $l))
    {
        $href = $l['link'];
    }
    else
    {
        $href = $l['permalink_url'];
    }
    if (array_key_exists('full_picture', $l))
    {
        $file = __dir__.DIRECTORY_SEPARATOR.$l['id'];
        $file = resize($l['full_picture'], $file);
        echo '<a class="facebooklink" href="'.myEncode($href).'">';
        echo '<img class="facebooklink" src="/facebook/'.basename($file).'" alt="'.$title.'">';
        echo '</a>';
    }
    if (array_key_exists('message', $l))
        echo '<div class="facebooklinkcomment">'.myEncode($l['message']).'</div>';
    if ($title != "")
        echo '<div><a class="facebooklink" href="'.myEncode($href).'">'.$title.'</a></div>';
    if (array_key_exists('description', $l))
        echo '<div class="facebooklinkdesc">'.myEncode($l['description']).'</div>';
    if (array_key_exists('caption', $l))
        echo '<div class="facebooklinksite">'.myEncode($l['caption']).'</div>';
    faceDate($l);
    echo "</div>\n";
    return 1;
}

function myEncode($s)
{
    return htmlentities($s, ENT_QUOTES, 'UTF-8');
}

function faceDate($l)
{
    echo '<div class="facebookdate"><a href="'.myEncode($l['permalink_url']).'">';
    if (array_key_exists('icon', $l))
    echo '<img src="'.$l['icon'].'">';
    echo date('D j M \a\t H:i', strtotime($l['created_time'])).'</a></div>';
    echo '<div class="clear"></div>'; // for float: left images
}

function ignorePost($p)
{
    $ignore = Array('Flickr', 'Twitter', 'Yahoo!', 'Instagram Photos');
    if (array_key_exists('name', $p) && in_array($p['name'], $ignore) && (strlen($p['message']) < 50))
        return true;
    return false;
}

?>
