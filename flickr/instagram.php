<?php

include('resize.php');

function UR_exists($url) {
   $headers = get_headers($url);
   return stripos($headers[0], "200 OK") ? true : false;
}

function instagram($url)
{
    $f = file(dirname(__FILE__).'/instaloaderUrl.php');
	$urlbase = trim($f[1]);

    $filelist = file_get_contents($urlbase."filelist.cgi");

    $files = preg_split("/\R/", $filelist, -1, PREG_SPLIT_NO_EMPTY);

    foreach (array_slice($files, 0, 20) as $jsonfile) {
        $jsonContent = file_get_contents($urlbase.$jsonfile);

        //echo $jsonContent;
        $data = json_decode($jsonContent, true);
        //print $data;
        $shortcode = $data['node']['shortcode'];
        $title = $data['node']['caption'];

        $extensions = ['.jpg', '_1.jpg', '.webp', '_1.webp'];

        foreach ($extensions as $ext) {
            $jpgFile = str_replace('.json', $ext, $jsonfile);
            if (UR_exists($urlbase.$jpgFile)) {
                break;
            }
        }

        if (!UR_exists($urlbase.$jpgFile) && !UR_exists($urlbase.($jpgFile = str_replace('.jpg', '_1.jpg', $jpgFile))))
        {
            throw new Exception("Unable to find file $urlbase$jpgFile");
        }

        $output = resize($urlbase.$jpgFile, __DIR__."/instagram/".str_replace($ext, '', $jpgFile), 150, 150);

        echo '<a href="https://www.instagram.com/p/'.$shortcode.'/">';
        echo '<img width=75 height=75 src="/flickr/instagram/'.basename($output).'" alt="'.$title.'" title="'.$title.'"></a>'."\n";

    }

}

?>
