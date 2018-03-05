<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('hours_worked'))
{
	/**
	 * Get hours worked in timesheet
	 *
	 * @param	StdClass  $timesheet
	 * @return	float
	 */
	function hours_worked($timesheet)
	{
		$CI =& get_instance();
		$CI->load->library('clockout_library');
		return $CI->clockout_library->hours_in_closed_timesheets($timesheet);
	}
}
