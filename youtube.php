<?PHP

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

include 'youtubetoken.php';

    $url = "https://www.googleapis.com/youtube/v3/playlistItems?part=contentDetails&playlistId=UUFZ1-GCGxmvGvORjxsFEG5w&key=$apikey";

	$a = file_get_contents($url);
    $vals = json_decode($a);

foreach($vals->items as $item)
{
    $ids[] = $item->contentDetails->videoId;
}

$sids = implode(",", $ids);

$url = "https://www.googleapis.com/youtube/v3/videos?part=snippet%2Cstatistics&id=".urlencode($sids)."&key=$apikey";

$a = file_get_contents($url);
$vals = json_decode($a);

foreach($vals->items as $item)
{

    $snippet = $item->snippet;
    $published = $snippet->publishedAt;
    $title = htmlentities($snippet->title);
    $link = "https://www.youtube.com/watch?v=".$item->id;
    $thumb = '<img src="'.$snippet->thumbnails->medium->url.'" class="ytthumb rel" alt="'.$title.'">';
    $desc = $snippet->description;
    $views = $item->statistics->viewCount;

    print '<a href="'.htmlentities($link).'" class="youtube">'.$thumb;
    print '<div class="yttext rel"><span class="yttitle">'.$title.'</span><br>';
    print '<span class="ytdesc">jamiekitson '."$views views<br>$desc</span>";
    print "</div></a>\n";

}

?>
