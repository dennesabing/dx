<?php

/**
 * File Manipulations
 *
 * @author Dennes B Abing <dennes.b.abing@gmail.com>
 * @package Dx
 * @subpackage File
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
	 * Check for Folder/Directory existence
	 * @param string $dir The folder to check
	 * @param boolean $create Create folder/directory if TRUE
	 * @param integer $permission The permission when creating the folder/director
	 * @return boolean
	 */
	public static function checkDir($dir, $create = FALSE, $permission = 0755)
	{
		return file_exists(self::fixPath($dir));
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
