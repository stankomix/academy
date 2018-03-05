<?php

use Carbon\Carbon;

class Bonus_model extends CI_Model {

	//class props
	//hard coded min billable to reach bonus
	//must reach 24772 for min bonus for non-extinguisher tech
	//must reach 12342 for min bonus for exting tech
	public $tech_level2;
	public $tech_level1;
	public $office_level1;

	public function __construct( ) {
		parent::__construct();

		$this->tech_level1 = 12342;
		$this->tech_level2 = 24772;
		$this->office_level1 = 37000;
		
	}

	//get payrate for user object
	private function get_payrate($user_id) {
		$this->db->select('payrate');
		$db_result = $this->db->get_where( 'users', array ( 'id' => $user_id ) );
		return $db_result->result();
	}

	private function get_monthly_closed_timecards($user_id){
		$this->db->where("date LIKE '" . date('Y-m') . "%'", NULL, FALSE);
		$this->db->where('user_id', $user_id);
		$this->db->where('stop_hour IS NOT NULL', NULL, FALSE);
		$db_result = $this->db->get('timesheets');
		return $db_result->result();
	}

	private function get_quarterly_closed_timecards($user_id){
		$this->db->where("DAY(`date`) = DAY(NOW()) AND ((( MONTH(NOW()) - MONTH(`date`)) mod 3) = 0)", NULL, FALSE);
		$this->db->where('user_id', $user_id);
		$this->db->where('stop_hour IS NOT NULL', NULL, FALSE);
		$db_result = $this->db->get('timesheets');
		return $db_result->result();

/*

- get all timecards for user that:
 - match performance_bonus table (eg: workid)
 - group total amount for the month
 - group total amount for the quarter

//returns year, quarter, jobs (count), user, wo# - grouped by quarter
select YEAR(date) AS year, QUARTER(date) AS quarter, COUNT(workorder_id) AS jobs, name_surname AS user, workorder_id as job
from timesheets t left join users u on t.user_id=u.id
where date > '2017-01-01'
AND stop_hour IS NOT NULL
GROUP BY QUARTER(date), job, user
ORDER BY QUARTER(date), user


select YEAR(date) AS year, QUARTER(date) AS quarter, COUNT(workorder_id) AS jobs, user_id AS user
from timesheets
where date > '2017-01-01'
AND stop_hour IS NOT NULL
GROUP BY QUARTER(date), user
ORDER BY QUARTER(date), user
*/

	}


	//pulls WO's from timesheets for user for given month by default
	public function get_monthly_billed_closed_wo($user_id, $month = 0) {
		//$db_result = $this->get_quarterly_closed_timecards($user_id);
		//$db_result = $this->get_monthly_closed_timecards($user_id);
		
		$billed = new stdClass();
		//get the amount from perbonus
		$this->db->select('sum(billed) as billed');
		$this->db->where('user_id', $user_id);

		if ( $month > 0 )
			$this->db->where("YEAR(jobdate) = YEAR(CURRENT_DATE() - INTERVAL $month MONTH) AND MONTH(jobdate) = MONTH(CURRENT_DATE - INTERVAL $month MONTH)", NULL, FALSE);
		else
			$this->db->where("jobdate LIKE '" . date('Y-m') . "%'", NULL, FALSE);

		$db_pbresult = $this->db->get('performance_bonus');
		//$db_pbresult = $this->db->get_compiled_select('performance_bonus');
		//log_message('debug', '------------------------> db_pbresult :' . print_r($db_pbresult, TRUE));

		$wo_result = $db_pbresult->result();
		//start of month or user has yet to get any closed WO with with billing
		if ( !$wo_result[0]->billed )
			$wo_result[0]->billed = 0;

		$bonus_progress = $wo_result[0]->billed;

		log_message('debug', '------------------------> model - bonus_progress :' . print_r($bonus_progress, TRUE));

		return round($this->percentage_indicator($bonus_progress, $user_id), 2);

/*
//returns past month
//returns 2 months back
SELECT jobdate, sum(billed) as billed FROM `performance_bonus` WHERE `user_id` = '21' AND jobdate BETWEEN (CURRENT_DATE() - INTERVAL 2 MONTH) AND (CURRENT_DATE() - INTERVAL 1 MONTH)

//all from last month
SELECT * FROM performance_bonus
WHERE YEAR(jobdate) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
AND MONTH(jobdate) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)
*/



	}

	//must reach tech level 2 for min bonus for non-extinguisher tech
	//must reach tech level 1 for min bonus for exting tech
	private function percentage_indicator($amount, $user_id){
		//get user level (employee position)
		$level = $this->get_position($user_id);

		//
		//if user position id == 2, level == 1
		if ( (int) $level == 2 )
			return ($amount / $this->tech_level1);

		if ( (int) $level == 1 )
			return ($amount / $this->tech_level2);

	}
	
	private function get_position($user_id)
	{
		$this->db->select('employee_position_id as level');
		$this->db->where('id', $user_id);
		$db_result = $this->db->get('users');
		return  $db_result->result();
	}
}
