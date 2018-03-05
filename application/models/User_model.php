<?php

use Carbon\Carbon;

class User_model extends CI_Model {

	public $newId;

	public function __construct( ) {
		parent::__construct();

		//get payrate for user object
	}

	private function get_payrate($user_id) {
		$this->db->select('payrate');
		$db_result = $this->db->get_where( 'users', array ( 'id' => $user_id ) );
		return $db_result->result();
	}

	//returns array of tests table records as db objects
	public function get_mandatory_tests(){
		$this->db->order_by('status', 'asc');
		$db_result = $this->db->get_where( 'tests', array ( 'mandatory' => '1', 'status' => '1' ) );
		return $db_result->result();
	}

	public function login($email, $password){
		$db_result = $this->db->get_where( 'users', array ( 'email' => $email, 'password' => $password, 'status' => '1' ) );

                //log_message('debug', 'arResult ' . print_r($db_result, TRUE));
                log_message('debug', 'POST' . print_r($db_result->result(), TRUE));

                if($db_result->num_rows() == 1)
			return $db_result->row();

		return null;
	}

	public function get_birthdays()
	{
		$this->db->order_by('birthday', 'asc');
		$sql_where = "month(birthday) = month(NOW())";
		$db_result = $this->db->select("name_surname, birthday" , FALSE)
			->where( 'status', 1 )
			->where( $sql_where )
			->get( 'users' );

		return $db_result->result();	
	}

	//does not factor in shared WO
	public function get_bonus_progress($user_id, $month = 0)
	{
		$this->load->library('bonus_library');
		//$d = $this->bonus_library->bonus_progress($user_id, $month);
           //log_message('debug', '------------------------> modelsUser bonus_progress :' . print_r($d, TRUE));
		//return $d;
		return $this->bonus_library->bonus_progress($user_id, $month);
	}

	//user only gets credit for WO bonus if they have a timecard that matches the WO (currently does not need to match WO date with TC+WO+date)
	public function get_bonus_status($user_id)
	{
		$arBilled = [];

$user_id=64;
		/*
		//this returns the WO's that were shared
		$strSQL = "SELECT ts.workorder_id
		FROM timesheets ts
		INNER JOIN timesheets ts2 ON ts.workorder_id = ts2.workorder_id
		WHERE ts.user_id <> ts2.user_id and ts.user_id = $user_id
		GROUP BY workorder_id";
		//returns all WO's, loop and remove any of the shared
		*/
		//$db_result = $this->db->get_where('timesheets', ['user_id' => $user_id]);

/*
		foreach ( $db_result->result() AS $objWO )
		{
			$billed = new stdClass();
            //log_message('debug', '------------------------> workorders :' . print_r($objWO, TRUE));
			//get the amount from perbons
			$this->db->select('billed');
			$db_pbresult = $this->db->get_where('performance_bonus', ['workorder_id' => $objWO->workorder_id ]);
			$wo_result = $db_pbresult->result();
                	log_message('debug', '------------------------> perfbonus :' . print_r($wo_result, TRUE));
			if ( !$wo_result[0]->billed )
				continue;
			$billed->wo = $objWO->workorder_id;
			$billed->amount = $this->bonus_calc($wo_result[0]->billed, $user_id);
			$arBilled[] = $billed;

		}
*/
		//need to loop through, calc the billed>amount and give the percentage accordingly
		return $arBilled;

	}

	//this returns the percentage for the provided amount
	//based on hard coded values (should be moved to config or db for admin to set)
	private function bonus_calc($amount, $user_id)
	{
		//bonus is based value of billable # of WO per day
		//times their monthly salary (current hours worked - this should included NON-BILLED WO!!, times hourly rate)

		$pay_rate = $this->get_payrate($user_id);
		//current total timecards for the month
		//$this->load->model('timecard_model');
		//$timecards = $this->timecard_model->get_monthly_timesheets($user_id);
		//total billed for the month
		//$monthly_hours = $this->get_monthly_billed($user_id);

		//$monthly_hours = $this->timecard_model->get_monthly_hours($user_id);

		//$bonus = $this->bonus_result( );

                //	log_message('debug', '------------------------> bonus_calc :' . print_r($timecards, TRUE));
//die('here');
		$level1 = .035;
		$level2 = .05;
		$level3 = .01;
		if ( $amount > 1125 && $amount <= 1499 )
			return ( $amount * $level1 );
		if ( $amount > 1500 && $amount <= 1800 )
			return ( $amount * $level2 );
		if ( $amount > 1800 )
			return ( $amount * $level3 );
	}

        //calc bonus amount
        public function bonus_result( $percent, $hours, $payrate )
        {
                $gross = $hours * $payrate;
                $bonus = $gross * $percent;
                return $bonus;
        }

	/**
	 * Retrieves the phone number for user with id $id
	 *
	 * @param int $id User Id
	 *
	 * @return string
	 */
	public function get_phone($id)
	{
		$this->db->select('phone');
		$db_result = $this->db->get_where('users', ['id' => $id]);
		return $db_result->row()->phone;
	}

	/**
	 * Returns the name for user with id $id
	 *
	 * @param int $id User Id
	 *
	 * @return string
	 */
	public function get_name($id)
	{
		$this->db->select('name_surname');
		$db_result = $this->db->get_where('users', ['id' => $id]);
		return $db_result->row()->name_surname;
	}

	/**
	 * Get user by email
	 *
	 * @param int $email Email;
	 *
	 * @return StdClass|false
	 */
	public function find_by_email($email)
	{
		$this->db->where('email', $email);
		$this->db->limit(1);

		$db_result = $this->db->get('users');

		if (!$db_result->num_rows()) return false;

		return $db_result->row();
	}

	/**
	 * Get hires from yesterday. Hires from today will show tomorrow
	 *
	 * @return StdClass[]
	 */
	public function new_hires()
	{
		$this->db->where('hire_date =', Carbon::now()->subDay()->toDateString());
		$this->db->where('status', 1);
		$db_result = $this->db->get('users');

		return $db_result->result();
	}

	/**
	 * Get users who have birthdays today
	 *
	 * @return StdClass[]
	 */
	public function users_with_birthdays_today()
	{
		$sql_where = "month(birthday) = month(NOW()) AND day(birthday) = day(NOW())";
		$this->db->where($sql_where);
		$this->db->where('status', 1);

		$db_result = $this->db->get('users');

		return $db_result->result();
	}

	public function get_jobs()
	{
		$query = $this->db->query('SELECT DISTINCT(job) FROM users');

		return $query->result();
	}

	// ADMIN FUNCTIONS

	public function all()
	{
		$this->db->select('users.id, name_surname, email, employee_positions.title, birthday, status');
		$this->db->from('users');
		$this->db->join('employee_positions', 'employee_positions.id = users.employee_position_id');
		$db_result = $this->db->get();

		return $db_result->result();

	}

	public function get($id)
	{
		$this->load->database();
		$this->db->where('id', $id);

		$db_result = $this->db->get('users');

		return $db_result->row();

	}

	public function add($fields)
	{
		$data = [
			'name_surname'	=> $fields['name_surname'],
			'email'			=> $fields['email'],
			'password'		=> $fields['password'],
			'birthday'		=> $fields['birthday'],
			'status'		=> $fields['status'],
			'employee_position_id' => $fields['employee_position_id'],
		];

		$this->load->database();
		$this->db->insert('users', $data);
		$this->newId = $this->db->insert_id();
	}

	public function update($id, $fields)
	{
		$data = [
			'name_surname'	=> $fields['name_surname'],
			'email'			=> $fields['email'],
			'birthday'		=> $fields['birthday'],
			'status'		=> $fields['status'],
			'employee_position_id' => $fields['employee_position_id'],
		];

		if ($fields['password'] != ''){
			$data['password'] = $fields['password'];
		}

		$this->load->database();
		$this->db->where('id', $id);
		$this->db->update('users', $data);
	}

	public function delete($id)
	{
		$this->load->database();
		$this->db->where('id', $id);
		$this->db->delete('users');
	}

	/**
	 * Get all the active user accounts
	 *
	 * @param int 		$page_number 	(Optional) Page number
	 * @param string 	$order_by 		(Optional) Name of column to order by
	 * @param bool 		$ascending 		(Optional) Order ascending
	 *
	 * @return StdClass[]
	 */
	public function all_active($page_number = 0, $order_by = null, $ascending = true)
	{
		$this->db->where('status', 1);

		if ($order_by) {
			$asc = $ascending ? 'asc' : 'desc';
			$this->db->order_by($order_by, $asc);
		}

		$this->db->limit(6, $page_number);
		$db_result = $this->db->get('users');
		return $db_result->result();
	}

	/**
	 * Get the total number of active user accounts
	 *
	 * @return int
	 */
	public function all_active_count()
	{
		$this->db->where('status', 1);
		$db_result = $this->db->from('users');
		return $this->db->count_all_results();
	}

	/**
	 * Get all active users with job $job
	 *
	 * @param string $job  Job
	 *
	 * @return int[]
	 */
	public function users_with_job($job)
	{
		$ids = [];

		$db_result = $this->db->select('id', FALSE)
			->where('status', 1)
			->where('job', $job)
			->get('users');

		foreach ($db_result->result() as $user) $ids[] = $user->id;

		return $ids;
	}

}
