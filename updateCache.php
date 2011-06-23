<?php

$t = microtime(true);
$s = exec("/usr/bin/php ".$argv[1], $a);
$s = trim(implode("\n", $a));
if ($s != '')
{
	$s = "\n<!-- cache -->\n$s";
	$s = $s.sprintf("\n<!-- %01.2f -->\n", microtime(true) - $t);
	file_put_contents($argv[2], $s);
}
?>
