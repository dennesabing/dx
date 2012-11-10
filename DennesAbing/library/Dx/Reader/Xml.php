<?php

/**
 * File Reader
 *
 * @author Dennes B Abing <dennes.b.abing@gmail.com>
 * @package Dx
 * @subpackage Form
 * @link http://labs.madayaw.com
 */

namespace Dx\Reader;

use Dx\Reader;

class Xml extends Reader
{
	/**
	 * Read an XML File and return it as an array
	 * @param string $xml Path to XML File
	 * @return array|boolean 
	 */
	public static function toArray($xmlFile)
	{
		$data = FALSE;
		if(file_exists($xmlFile))
		{
			$reader = new \Zend\Config\Reader\Xml();
			$xml = $reader->fromFile($xmlFile);
			if($xml)
			{
				$cacheObj = self::getCache();
				$data = $xml;
			}
		}
		return $data;
	}
}
