<?php

function cachedHTML($runFile)
{
    $basedir = "/srv/www/jamiek.it/";

	$p = pathinfo($runFile);
	$cacheFile = $base."cache/".$p['filename'];
	$runFile = $base.$runFile;

	$t = microtime(true);

	echo "\n<!-- getting cache -->\n";
	echo file_get_contents($cacheFile);

	if (!isCached($cacheFile))
	{
        	echo "\n<!-- updating cache -->\n";
	        exec("/usr/bin/php ".$base."updateCache.php $runFile $cacheFile > /dev/null &");
	        // exec("/usr/bin/php $runFile > $cacheFile &");
	}
	printf("<!-- %01.2f -->\n", microtime(true) - $t);
}

function isCached($f)
{
	return file_exists($f) && (filemtime($f) > strtotime('-1 hour'));
	return false;
}

?>
