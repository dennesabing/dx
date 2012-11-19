<?php
/**
 * Cache
 *
 * @author Dennes B Abing <dennes.b.abing@gmail.com>
 * @package Dx
 * @subpackage Cache
 * @link http://labs.madayaw.com
 */

namespace Dx;

class Cache
{
	/**
	 * Generate a name based on a given key
	 * @param string|array $key 
	 * 
	 * @return string
	 */
	public static function name($key)
	{
		if(is_array($key))
		{
			$key = \Dx\StringManager::arrayToString($key);
		}
		return md5($key);
	}
}
