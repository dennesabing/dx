<?php

/**
 * Access Sitewide configuration
 *
 * @author Dennes B Abing <dennes.b.abing@gmail.com>
 * @package Dx
 * @subpackage Config
 * @link http://labs.madayaw.com
 */

namespace Dx;

class Config
{
	/**
	 * Get all Application Config
	 * @TODO Application configuration can be app.xml in /dxapp/config/app.xml or the autoload
	 * return mixed array|obj  
	 */
	public static function getAppConfig()
	{
		$resource = array();
		$global = include_once \Dx::getBaseDir('app') . 'config/autoload/global.php';
		if(\Dx\File::check(\Dx::getBaseDir('app') . 'config/autoload/local.php'))
		{
			$local = include_once \Dx::getBaseDir('app') . 'config/autoload/local.php';
			$resource = \Dx\ArrayManager::merge($global, $local);
		}
		return $resource;
	}
	
	/**
	 * Get an Application Configuration Resource
	 * @param mixed array|object|boolean type $resource if Found, FALSE if not
	 */
	public static function getAppConfigResource($resource = NULL)
	{
		$config = self::getAppConfig();
		if(isset($config[$resource]))
		{
			return $config[$resource];
		}
		return FALSE;
	}
	/**
	 * Get the Application Theme
	 * @param string $section The Section name
	 * return string The Application theme name 
	 */
	public static function getAppTheme($section = 'front')
	{
		$siteConfig = self::getAppConfigResource('dxsite');
		$frontend = isset($siteConfig['theme']['frontend']) ? $siteConfig['theme']['frontend'] : 'default';
		$backend = isset($siteConfig['theme']['backend']) ? $siteConfig['theme']['backend'] : 'default';
		if($section == 'admin')
		{
			return $backend;
		}
		return $frontend;
	}
	
	/**
	 * Get the Section - Application theme folder 
	 */
	public static function getAppSectionTheme()
	{
		return \Dx::getSection() . '/' . self::getAppTheme();  
	}
}
