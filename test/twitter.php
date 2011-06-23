<?php

ini_set('user_agent', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');

for ($i = 0; $i < 10; $i++)
{

	echo $i;
	try
	{
		if (!@($s = file_get_contents('http://twitter.com/statuses/user_timeline/14711255.rss')))
			echo 'fail early '.$php_errormsg;
		if ($s == '')
			echo 'fail empty';
	}
	catch (Exception $e)
	{
		echo 'fail caught '.$e->getMessage();
	}

}

?>
