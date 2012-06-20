<?php

// Usage: /usr/bin/php updateCache.php RunFile OutFile
// RunFile: PHP file to run
// OutFile: File to write output to

$t = microtime(true);
exec("/usr/bin/php ".$argv[1], $out, $ret);
$s = trim(implode("\n", $out));

if ($ret != 0)
{
	file_put_contents($argv[2]."ERROR", $s);
} 
elseif ($s != '')
{
	$s = "\n<!-- cache -->\n$s";
	$s = $s.sprintf("\n<!-- %01.2f -->\n", microtime(true) - $t);
	file_put_contents($argv[2], $s);
}

?>
