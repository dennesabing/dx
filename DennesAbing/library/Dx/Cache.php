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
	 * The filecache object
	 * @var object
	 */
	protected $fileCache = NULL;
	
	/**
	 * The memcache Object
	 * @var object
	 */
	protected $memCache = NULL;
	
	public function __construct($fileCache, $memCache)
	{
		$this->fileCache = $fileCache;
		$this->memCache = $memCache;
	}
	
	/**
	 * Return the File Cache object
	 * @return object
	 */
	public function getFileCache()
	{
		return $this->fileCache;
	}
	
	/**
	 * Return the Memory Cache Object
	 * @return object
	 */
	public function getMemoryCache()
	{
		return $this->memCache;
	}
	
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
