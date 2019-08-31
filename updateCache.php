<?php

$t = microtime(true);

ob_start();

$base = $argv[1];

include($base.'.php');

$s = ob_get_clean();

if (substr_compare($base, 'index', -5) > 0)
{
    $s = "\n<!-- cache -->\n$s";
    $s = $s.sprintf("\n<!-- %01.2f -->\n", microtime(true) - $t);
}
file_put_contents($base.'.html', $s);

?>
