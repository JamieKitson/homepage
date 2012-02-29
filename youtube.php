<?PHP

// error_reporting(E_ALL);
// ini_set('display_errors', '1');


	$url = "https://gdata.youtube.com/feeds/api/users/jamiekitson/uploads?max-results=5";

	$a = file_get_contents($url);

// print_r($a);

$p = xml_parser_create();
xml_parse_into_struct($p, $a, $vals, $index);
xml_parser_free($p);

foreach($vals as $item)
{
	switch($item['tag']) 
	{
		case "PUBLISHED" :
			$published = $item["value"];
			$thumb = false; 
			break;
		case "TITLE": 
			$title = $item["value"]; 
			break;
		case "CONTENT": 
			$desc = $item["value"]; 
			break;
		case "LINK": 
			if ($item["attributes"]["REL"] == "alternate") 
			{
				$link = $item["attributes"]["HREF"];
			}
			break;
		case "MEDIA:THUMBNAIL": 
			if (!$thumb && ($item["attributes"]["HEIGHT"] == 360))
			{ 
				$thumb = '<img src="'.$item["attributes"]["URL"].'" class="ytthumb rel">';
			} 
			break;
		case "YT:STATISTICS" :
			$views = $item["attributes"]["VIEWCOUNT"];
			$favs = $item["attributes"]["FAVORITECOUNT"];
			print '<a href="'.$link.'" class="youtube">'.$thumb;
			print '<div class="yttext rel"><span class="yttitle">'.$title.'</span><br><span class="ytdesc">jamiekitson '."$views views<br>$desc</span>";
			//print "<div class=\"ytdesc\">$desc</div>";
			print "</div></a>\n";
			break;
	}
}

/*

echo "Index array\n";
print_r($index);
echo "\nVals array\n";
print_r($vals);

*/

?>
