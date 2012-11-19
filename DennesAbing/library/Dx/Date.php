<?php

/**
 * Date Manipulations
 *
 * @author Dennes B Abing <dennes.b.abing@gmail.com>
 * @package Dx
 * @subpackage Date
 * @link http://labs.madayaw.com
 */

namespace Dx;

class Date
{

	/**
	 * Return Dates within a given range
	 * If $interval == day, will return all days between $start and $end
	 * $interval = P1D, P1W, P1M, P1Y
	 * @param string|object $start A Readable date string or DateTime object. If string: 2010-10-01, Y-m-d
	 * @param string|object $end A Readable date string or DateTime object. If string: 2010-10-01, Y-m-d
	 * @param string $interval day, week, month, year
	 * 
	 * @return array 
	 */
	public static function range($start, $end, $interval = 'P1D')
	{
		if (!is_object($interval))
		{
			$interval = new \DateInterval($interval); //P1M, P1Y, P1W
		}
		if (!is_object($start))
		{
			$start = new \DateTime($start);
		}
		if (!is_object($end))
		{
			$end = new \DateTime($end);
		}
		$dates = new \DatePeriod($start, $interval, $end);
		$arr = array();
		foreach ($dates as $date)
		{
			$arr[] = $date;
		}
		return $arr;
	}

}
