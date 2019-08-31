<?php

// Usage: /usr/bin/php updateCache.php RunFile OutFile
// RunFile: PHP file to run
// OutFile: File to write output to

    $t = microtime(true);

    ob_start();

    include($argv[1]);

    $s = ob_get_clean();

	$s = "\n<!-- cache -->\n$s";
	$s = $s.sprintf("\n<!-- %01.2f -->\n", microtime(true) - $t);
	file_put_contents($argv[2], $s);

?>
