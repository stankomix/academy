<?php

/**
 * Bonus Library
 *
 * Handles calculations based on CFP payroll formulas
 * 
 */

defined('BASEPATH') OR exit('No direct script access allowed');

use Carbon\Carbon;

class Bonus_library {

	/**
	 * Reference to CodeIgniter
	 *
	 * @var object
	 */
	protected $CI;

	public function __construct()
	{
		// Assign the CodeIgniter super-object
		$this->CI =& get_instance();
		$this->CI->load->model('timecard_model', '', TRUE);
		$this->CI->load->model('bonus_model', '', TRUE);

		//will be needed
		$weekdays = Carbon::now()->startOfMonth()->diffInWeekdays(Carbon::now()->endOfMonth());
                log_message('debug', '------------------------------------> weekdays ' . print_r($weekdays, TRUE));

	}

	public function bonus_progress($user_id, $month = 0)
	{
		//$b = $this->CI->bonus_model->get_monthly_billed_closed_wo($user_id, $month);
           //log_message('debug', '------------------------> libraries bonus lib :' . print_r($b, TRUE));
		//return $b;

		return $this->CI->bonus_model->get_monthly_billed_closed_wo($user_id, $month);
	}

	//sharing engine
	//processes WO's to find out if they are shared based on .timecard table
	//if shared get hours for each, sort and calulate the percentage of the WO per user_id
	private function calc_shared_wo($wo_id)
	{
	}

	//returns total billed for the month per user
	private function get_total_current_monthly_billed($user_id)
	{

	}

	//returns average billed per day for current month from total
	private function calc_average_daily_gross_current_month($amount)
	{

	}


}
