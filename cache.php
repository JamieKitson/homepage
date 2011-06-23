<?php

function cachedHTML($runFile)
{
	$p = pathinfo($runFile);
	$cacheFile = "/srv/www/jamiek.it/cache/".$p['filename'];
	$runFile = "/srv/www/jamiek.it/$runFile";

	$t = microtime(true);

	echo "\n<!-- getting cache -->\n";
	echo file_get_contents($cacheFile);

	if (!isCached($cacheFile))
	{
        	echo "\n<!-- updating cache -->\n";
	        exec("/usr/bin/php /srv/www/jamiek.it/updateCache.php $runFile $cacheFile > /dev/null &");
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
