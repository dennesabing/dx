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
	 * @TODO Application configuration can be app.xml in /dxapp/config/app.xml
	 * return mixed array|obj  
	 */
	public static function getAppConfig($resource = NULL)
	{
		if(!empty($resource))
		{
			return self::getAppConfigResource($resource);
		}
		return array();
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
		if($section == 'admin')
		{
			return 'default';
		}
		return 'default';
	}
	
	/**
	 * Get the Section - Application theme folder 
	 */
	public static function getAppSectionTheme()
	{
		return \Dx::getSection() . '/' . self::getAppTheme();  
	}
}
