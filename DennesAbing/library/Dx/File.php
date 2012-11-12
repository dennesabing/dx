<?php

/**
 * File Manipulations
 *
 * @author Dennes B Abing <dennes.b.abing@gmail.com>
 * @package Dx
 * @subpackage Form
 * @link http://labs.madayaw.com
 */

namespace Dx;

class File
{
	/**
	 * Fix a file path
	 * 
	 * @params string $file Path to File
	 * return string
	 */
	public static function fixPath($file)
	{
		return str_replace('/',DS, $file);
	}
	
	/**
	 * Check for file existence
	 * @param string $filename The Filename
	 * @param boolean $create True if to auto create the file
	 * @return boolean
	 */
	public static function check($filename, $create = FALSE)
	{
		return file_exists(self::fixPath($filename));
	}
	
	/**
	 * Check if file is empty
	 * @param string $filename The Filename to check for empty
	 * @return boolean 
	 */
	public static function isEmpty($filename)
	{
		if(self::check($filename) && filesize($filename) > 0)
		{
			return TRUE;
		}
		return FALSE;
	}
	
}
