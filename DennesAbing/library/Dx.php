<?php

/**
 * Dx
 *
 * Access most Application Configuration
 *
 * @author Dennes <dennes.b.abing@gmail.com>
 */

class Dx
{

	protected static $requestParams = NULL;
	
	public static function setRequestParams($params)
	{
		self::$requestParams = $params;
	}

	/**
	 * Get the absolute path of any base directory
	 * @param mixed array|string $type 
	 */
	public static function getBaseDir($type = NULL)
	{
		if (empty($type))
		{
			return self::getAppRoot();
		}
		return self::getAppRoot() . DS . APP_PREFIX . $type . DS;
	}

	/**
	 * Get the Main Application Folder
	 * @return type 
	 */
	public static function getAppRoot()
	{
//		return $_SERVER['DOCUMENT_ROOT'];
		return APP_ROOT;
	}

	/**
	 * Get the Base URL
	 * @param type $type
	 * @param mixed array|string $type 
	 */
	public static function getBaseUrl($type = NULL)
	{
		$url = '/' . APP_PREFIX . $type . '/';
		return $url;
	}
	
	/**
	 * Get the current section of the site eg. admin or frontend
	 * 
	 * @return string The current section 
	 */
	public static function getSection()
	{
		return APP_SECTION;
	}
	
	/**
	 * Get the current Controller
	 */
	public static function currentController()
	{
		$params = self::$requestParams;
		return isset($params['controller']) ? $params['controller'] : NULL;
	}
	
	/**
	 * Get the Current Action
	 * @return type 
	 */
	public static function currentAction()
	{
		$params = self::$requestParams;
		return isset($params['action']) ? $params['action'] : NULL;
	}
}
