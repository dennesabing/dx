<?php

/**
 * Setup autoloading based from composer
 */
$pathToAppVendor = '../../../../gettingStarted/public/dxapp/vendor/';
if (file_exists($pathToAppVendor . 'autoload.php'))
{
	include_once $pathToAppVendor . 'autoload.php';
}

// if composer autoloader is missing, explicitly add the ZF library path
require_once $pathToAppVendor . '/zendframework/zendframework/library/Zend/Loader/StandardAutoloader.php';
$loader = new Zend\Loader\StandardAutoloader(
				array(
					Zend\Loader\StandardAutoloader::LOAD_NS => array(
						'Dx' => __DIR__ . '/../library/Dx',
					),
		));
$loader->register();
