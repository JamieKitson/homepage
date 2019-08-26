<?php

function cachedHTML($runFile)
{
    $basedir = "/home/jamie/homepage/";

	$p = pathinfo($runFile);
	$cacheFile = $basedir."cache/".$p['filename'].".html";
	$runFile = $basedir.$runFile;

//	$t = microtime(true);

//	echo "\n<!-- getting cache -->\n";
	echo file_get_contents($cacheFile);

/*
	if (!isCached($cacheFile))
	{
        	echo "\n<!-- updating cache -->\n";
	        exec("/usr/bin/php ".$basedir."updateCache.php $runFile $cacheFile > /dev/null &");
	        // exec("/usr/bin/php $runFile > $cacheFile &");
	}
	printf("<!-- %01.2f -->\n", microtime(true) - $t);
*/
}

function isCached($f)
{
	return file_exists($f) && (filemtime($f) > strtotime('-1 hour'));
	return false;
}

?>
