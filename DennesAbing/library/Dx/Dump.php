<?php

/**
 * Debug/Dump a variable
 * 
 * @author Dennes B Abing <dennes.b.abing@gmail.com>
 * @package Dx
 * @subpackage Dump
 * @link http://labs.madayaw.com
 */

namespace Dx;

class Dump
{

	/**
	 * Dumps information about multiple variables
	 *
	 * @return void
	 */
	public static function dumpMulti()
	{
		// get variables to dump
		$args = func_get_args();

		// loop through all items to output
		foreach ($args as $arg)
		{
			self::dump($arg);
		}
	}

	/**
	 * Dump information about a variable
	 *
	 * @param mixed $variable Variable to dump
	 * @param string $caption Caption of the dump
	 * @return void
	 */
	public static function dump($variable, $caption = null)
	{
		// don't dump anything in non-development environments
		if (APP_ENV !== 'development')
		{
			return;
		}

		// prepare the output string
		$html = '';

		// start the output buffering
		ob_start();

		// generate the output
		var_dump($variable);

		// get the output
		$output = ob_get_clean();

		$maps = array(
			'string' => '/(string\((?P<length>\d+)\)) (?P<value>\"(?<!\\\).*\")/i',
			'array' => '/\[\"(?P<key>.+)\"(?:\:\"(?P<class>[a-z0-9_\\\]+)\")?(?:\:(?P<scope>public|protected|private))?\]=>/Ui',
			'countable' => '/(?P<type>array|int|string)\((?P<count>\d+)\)/',
			'resource' => '/resource\((?P<count>\d+)\) of type \((?P<class>[a-z0-9_\\\]+)\)/',
			'bool' => '/bool\((?P<value>true|false)\)/',
			'float' => '/float\((?P<value>[0-9\.]+)\)/',
			'object' => '/object\((?P<class>[a-z_\\\]+)\)\#(?P<id>\d+) \((?P<count>\d+)\)/i',
		);

		foreach ($maps as $function => $pattern)
		{
			$output = preg_replace_callback($pattern,
								   array('self', '_process' . ucfirst($function)), $output);
		}

		$header = '';
		if (!empty($caption))
		{
			$header = '<h2 style="' . self::_getHeaderCss() . '">' . $caption . '</h2>';
		}

//		if (PHP_SAPI == 'cli')
//		{
//			print $this->strip_tags($header . $output);
//		}
//		else
//		{
			print '<pre style="' . self::_getContainerCss() . '">' . $header . $output . '</pre>';
//		}
	}

	/**
	 * Process strings
	 *
	 * @param array $matches Matches from preg_*
	 * @return string
	 */
	private static function _processString(array $matches)
	{
		$matches['value'] = htmlspecialchars($matches['value']);
		return '<span style="color: #0000FF;">string</span>(<span style="color: #1287DB;">' . $matches['length'] . ')</span> <span style="color: #6B6E6E;">' . $matches['value'] . '</span>';
	}

	/**
	 * Process arrays
	 *
	 * @param array $matches Matches from preg_*
	 * @return string
	 */
	private static function _processArray(array $matches)
	{
		// prepare the key name
		$key = '<span style="color: #008000;">"' . $matches['key'] . '"</span>';
		$class = '';
		$scope = '';

		// prepare the parent class name
		if (isset($matches['class']) && !empty($matches['class']))
		{
			$class = ':<span style="color: #4D5D94;">"' . $matches['class'] . '"</span>';
		}

		// prepare the scope indicator
		if (isset($matches['scope']) && !empty($matches['scope']))
		{
			$scope = ':<span style="color: #666666;">' . $matches['scope'] . '</span>';
		}

		// return the final string
		return '[' . $key . $class . $scope . ']=>';
	}

	/**
	 * Process countables
	 *
	 * @param array $matches Matches from preg_*
	 * @return string
	 */
	private static function _processCountable(array $matches)
	{
		$type = '<span style="color: #0000FF;">' . $matches['type'] . '</span>';
		$count = '(<span style="color: #1287DB;">' . $matches['count'] . '</span>)';

		return $type . $count;
	}

	/**
	 * Process boolean values
	 *
	 * @param array $matches Matches from preg_*
	 * @return string
	 */
	private static function _processBool(array $matches)
	{
		return '<span style="color: #0000FF;">bool</span>(<span style="color: #0000FF;">' . $matches['value'] . '</span>)';
	}

	/**
	 * Process floats
	 *
	 * @param array $matches Matches from preg_*
	 * @return string
	 */
	private static function _processFloat(array $matches)
	{
		return '<span style="color: #0000FF;">float</span>(<span style="color: #1287DB;">' . $matches['value'] . '</span>)';
	}

	/**
	 * Process resources
	 *
	 * @param array $matches Matches from preg_*
	 * @return string
	 */
	private static function _processResource(array $matches)
	{
		return '<span style="color: #0000FF;">resource</span>(<span style="color: #1287DB;">' . $matches['count'] . '</span>) of type (<span style="color: #4D5D94;">' . $matches['class'] . '</span>)';
	}

	/**
	 * Process objects
	 *
	 * @param array $matches Matches from preg_*
	 * @return string
	 */
	private static function _processObject(array $matches)
	{
		return '<span style="color: #0000FF;">object</span>(<span style="color: #4D5D94;">' . $matches['class'] . '</span>)#' . $matches['id'] . ' (<span style="color: #1287DB;">' . $matches['count'] . '</span>)';
	}

	/**
	 * Get the CSS string for the output container
	 *
	 * @return string
	 */
	private static function _getContainerCss()
	{
		return self::_arrayToCss(array(
					'background-color' => '#d6ffef',
					'border' => '1px solid #bbb',
					'border-radius' => '4px',
					'-moz-border-radius' => '4px',
					'-webkit-border-radius' => '4px',
					'font-size' => '12px',
					'line-height' => '1.4em',
					'margin' => '5px',
					'padding' => '7px',
				));
	}

	/**
	 * Get the CSS string for the output header
	 *
	 * @return string
	 */
	private static function _getHeaderCss()
	{

		return self::_arrayToCss(array(
					'border-bottom' => '1px solid #bbb',
					'font-size' => '18px',
					'font-weight' => 'bold',
					'margin' => '0 0 10px 0',
					'padding' => '3px 0 10px 0',
				));
	}

	/**
	 * Convert a key/value pair array into a CSS string
	 *
	 * @param array $rules List of rules to process
	 * @return string
	 */
	private static function _arrayToCss(array $rules)
	{
		$strings = array();

		foreach ($rules as $key => $value)
		{
			$strings[] = $key . ': ' . $value;
		}

		return join('; ', $strings);
	}

	function strip_tags($str, $arrayExemption = array())
	{
		//Notes $arrayExemption holds all string exemptions in form of tags example <a href"http://www.autopartswarehouse.com/search/?searchType=global&N=0&Ntt=A1327630">
		foreach ($arrayExemption as $k => $exemptions)
				$str = str_replace($exemptions, " ", $str);
		$str = preg_replace("/<\/?(!DOCTYPE|a|abbr|acronym|address|applet|area|article|aside|audio|b|base|basefont|bdo|big|blockquote|body|br|button|canvas|caption|center|cite|code|col|colgroup|command|datalist|dd|del|details|dfn|dir|div|dl|dt|em|embed|fieldset|figcaption|figure|font|footer|form|frame|frameset|h\d|head|header|hgroup|hr|html|i|iframe|img|input|ins|keygen|kbd|label|legend|li|link|map|mark|menu|meta|meter|nav|noframes|noscript|object|ol|optgroup|option|output|p|param|pre|progress|q|rp|rt|ruby|s|samp|script|section|select|small|source|span|strike|strong|style|sub|summary|sup|table|tbody|td|textarea|tfoot|th|thead|time|title|tr|tt|u|ul|var|video|wbr|xmp)((\s+\w+(\s*=\s*(?:\".*?\"|'.*?'|[^'\">\s]+))?)+\s*|\s*)\/?>|<!--(.)*-->/i",
					  " ", $str);
		$str = preg_replace('/\s\s+/', ' ', $str);
		$str = preg_replace('/[\.]+/', '.', $str);
		return $str;
	}

}