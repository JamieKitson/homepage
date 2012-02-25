<?PHP

error_reporting(E_ALL);
ini_set('display_errors', '1');


	$url = "https://gdata.youtube.com/feeds/api/users/jamiekitson/uploads";

	$a = file_get_contents($url);

$p = xml_parser_create();
xml_parse_into_struct($p, $a, $vals, $index);
xml_parser_free($p);

foreach($vals as $item)
{
	switch($item['tag']) {
		
		case "TITLE": 
			$title = $item["value"]; 
			$thumb = false; 
			$link = false; 
			break;
		case "LINK": 
			if (!$link) 
			{
				// print '<a href="'.$item["attributes"]["HREF"]."\">$img$title</a><br>\n"; 
				$link = $item["attributes"]["HREF"];
			}
			break;
		case "MEDIA:THUMBNAIL": 
			if (!$thumb && ($item["attributes"]["HEIGHT"] == 90))
			{ 
				$thumb = '<img src="'.$item["attributes"]["URL"].'">';
				print '<a href="'.$link."\">$thumb$title</a><br>\n"; 
			} 
			break;
	}
}


echo "Index array\n";
print_r($index);
echo "\nVals array\n";
print_r($vals);

/*

print_r($a);

$xml = simplexml_load_string($a);

foreach($xml->entry as $e)
{
	print $e->title;
	print "<br>\n";
	print_r($e->$link);
	print "<br>\n";
}


print_r($xml);


//	print_r($a);

*/

?>
