<?php

function exception_error_handler($severity, $message, $file, $line) 
{
    throw new ErrorException($message, 0, $severity, $file, $line);
}
set_error_handler("exception_error_handler");

try
{

    $t = microtime(true);

    ob_start();

    $base = $argv[1];

    include($base.'.php');

    $s = ob_get_clean();

    if (substr_compare($base, 'index', -5) != 0)
    {
        $s = "\n<!-- cache ".date("c")." -->\n$s";
        $s = $s.sprintf("\n<!-- %01.2f -->\n", microtime(true) - $t);
    }

}
catch (Exception $e)
{
    $s = file_get_contents($base.'.html');
    $s = "\n<!-- ".date(DATE_ATOM)." ".$e->getMessage()." -->\n$s";
}

file_put_contents($base.'.html', $s);

?>
