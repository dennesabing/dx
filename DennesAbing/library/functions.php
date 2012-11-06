<?php
function dump($variable, $caption = NULL)
{
	if(APP_ENV == 'development' || APP_ENV == 'staging')
	{
		require_once('Dx/Dump.php');
		Dx\Dump::dump($variable, $caption);
	}
}