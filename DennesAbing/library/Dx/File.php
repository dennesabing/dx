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
}
