<?php

echo '<link rel="stylesheet" type="text/css" href="style.css" />';

    include "facebooktoken.php";

    $url = 'https://graph.facebook.com/10164155946480341/feed?fields=created_time,id,permalink_url,message,reactions,comments,caption,description,full_picture,icon,link,name,type&access_token='.$token;

//    echo $url;

    $rsp = file_get_contents($url);

//  print_r($rsp);

    $j = json_decode($rsp, true);

//  print_r($j);

    for($i = 0; $i < 10; $i++)
    {
        $a = $j['data'][$i];
        /*
        echo '<div class="facebooklink">';
        echo '<div class="facebooklinkcomment">'.$a['message'].'</div>';
        echo '<div class="facebookdate"><a href="'.$a['permalink_url'].'">';
//        echo date('D j M \a\t H:i', $a['created_time']).'</a></div>';
        echo '<div class="clear"></div>'; // for float: left images
        echo "</div>\n";
*/
		procLink($a);

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
        /*
        $q = parse_url($href, PHP_URL_QUERY);
        foreach(explode('&', $q) as $u)
        {
            $v = explode('=', $u);
            if ($v[0] == 'u')
            {
                $href = urldecode(urldecode($v[1]));
                break;
            }
        }
        */
    }
    else
    {
        $href = $l['permalink_url'];
    }
    if (array_key_exists('full_picture', $l)) // && is_array($l['attachment']['media']))
    {
        echo '<a class="facebooklink" href="'.myEncode($href).'">';
        echo '<img class="facebooklink" src="'.myEncode($l['full_picture']).'" alt="'.$title.'">';
        echo '</a>';
    }
    echo '<div class="facebooklinkcomment">'.myEncode($l['message']).'</div>';
    if ($title != "")
        echo '<div><a class="facebooklink" href="'.myEncode($href).'">'.$title.'</a></div>';
    if (array_key_exists('caption', $l))
        echo '<div class="facebooklinksite">'.myEncode($l['caption']).'</div>';
    if (array_key_exists('description', $l))
    echo '<div class="facebooklinkdesc">'.myEncode($l['description']).'</div>';
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
    echo date('D j M \a\t H:i', strtotime($l['created_time'])).'</a></div>';
    echo '<div class="clear"></div>'; // for float: left images
    /*
    if ($l['comments']['count'] > 0)
    {
        echo '<div class="facebookcomments"><a href="'.myEncode($l['permalink']).'"><span class="view">View ';
        echo $l['comments']['count'].' comments</span></a></div>';
    }
    */
}

function ignorePost($p)
{
    $ignore = Array('Flickr', 'Twitter', 'Yahoo!');
    if (array_key_exists('name', $p) && in_array($p['name'], $ignore)) // && $p['comments']['count'] == 0)
        return true;
    return false;
}

?>
