<?php

use Carbon\Carbon;

class Timecard_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get_timesheets_count($user_id){
		$db_result = $this->db->get_where( 'timesheets', array('user_id' => $user_id) );
		return $db_result->num_rows();
	}

	public function get_timecard_date($id){
		$this->db->select('date');
		$db_result = $this->db->get_where( 'timesheets', array('id' => $id) );
		return $db_result->result()->date;
	}

	public function get_timecard($id){
		$db_result = $this->db->get_where( 'timesheets', array('id' => $id) );
		return $db_result->row();
	}

	public function get_RecentTimecardByUser($user_id){
		$this->db->order_by('submit_time', 'desc');
		$db_result = $this->db->get_where( 'timesheets', array('user_id' => $user_id) );
		return $db_result->row();
	}
	//if stop hour exists
	public function timecard_stoptime_exist($id){
		$this->db->select('stop_hour');
		$db_result = $this->db->get_where( 'timesheets', array( 'id' => $id, 'stop_hour !=' => '' ) );
		if ( $db_result->num_rows() >= 1 )
			return true;
		return false;
	}

	//sheet of timecards (we use 2-3 tc/day so each sheet will have 2-3 dates)
	public function get_timesheets($user_id, $iOffset = 0){
		//hard code to 6 at a time
		$this->db->limit(6, $iOffset);
		//$this->db->order_by('date', 'desc');
		$this->db->order_by('submit_time', 'desc');
		$db_result = $this->db->get_where( 'timesheets', array('user_id' => $user_id) );

		return $db_result->result();
	}


	//returns a months worth of timesheets for user
	public function get_monthly_timesheets($user_id){
		//$this->db->select( 'date', date('Y-m') );
		$this->db->like( 'date', date('Y-m') );
		$db_result = $this->db->get_where( 'timesheets', array('user_id' => $user_id) );

		return $db_result->result();
	}

	//returns a months worth of hours for user from timecards
	public function get_monthly_hours($user_id){
                $hours = 0;

                //get all the timesheets, loop them, convert time to 24 and add up
                $monthly_timesheets = $this->get_monthly_timesheets($user_id);
                foreach( $monthly_timesheets AS $timecard )
                {
                        if ( $timecard->stop_hour )
                        {
                                $start_time = timecard_to_datetime(
                                                        $timecard->date,
                                                        $timecard->start_hour,
                                                        $timecard->start_min,
                                                        $timecard->start_pmam
                                                );

                                $end_time = timecard_to_datetime(
                                                        $timecard->date,
                                                        $timecard->stop_hour,
                                                        $timecard->stop_min,
                                                        $timecard->stop_pmam
                                                );

                                $hoursInterval = $end_time->diff($start_time);

                                $hours += $hoursInterval->format('%h hours');
                                if ( $hours >= 1 )
                                {
                                        log_message('debug', '-----------------> Hours : ' . print_r($hours, TRUE));
                                }
                        }
                }
                return (int) $hours;
	}

	//check if there's more than 1 workorder, with 2 entries for the date
	public function check_timecard($workorder_id, $date, $user_id)
	{
		log_message('debug', '---------------> check_timecard: ' . print_r( $date .' '. $user_id,true)  );

		$db_result = $this->db->get_where(
			'timesheets',
			array(
				'workorder_id' => $workorder_id,
				'date' => $date,
				'user_id' => $user_id,
				'driving_time' => FALSE,
				'lunch_time' => FALSE,
			)
		);

        log_message('debug', 'timecards ' . print_r($db_result->result(), TRUE));

		if ($db_result->num_rows() >= 3) {
   			return false;  
		}

		return true;
	}

	/**
	 * Create a new timecard entry (does not enter end time)
	 *
	 * @param string $workorder_id  Work order Id
	 * @param int    $start_hour    Start hour
	 * @param int    $start_min     Start minute
	 * @param string $start_pmam    Start period
	 * @param string $date          Date
	 * @param int    $user_id       User Id
	 * @param string|null  $reason  Reason timecard was started (applies to overtime)
	 * @param int|null 	   $limit   Maximun number of hours allowed for this timecard
	 *
	 * @return bool
	 */
	public function timecard_create($workorder_id, $start_hour, $start_min, $start_pmam, $date, $user_id, $reason = null, $limit = null, $for = null)
	{
		$this->db->set('workorder_id', $workorder_id);
		$this->db->set('user_id', $user_id);
		$this->db->set('start_hour', $start_hour);
		$this->db->set('start_min', $start_min);
		$this->db->set('start_pmam', $start_pmam);
		$this->db->set('date', $date);
		$this->db->set('submit_time', 'NOW()', FALSE);
		$this->db->set('overtime_reason', $reason);
		$this->db->set('hours_limit', $limit);
		$this->db->set('for', $for);

		return $this->db->insert('timesheets');
	}

	/**
	 * Create a new timecard entry
	 *
	 * @param array $data Associative array of fields name and their values
	 *
	 * @return void
	 */
	public function admin_timecard_create($data)
	{
		$this->db->insert('timesheets', $data);
	}

	/**
	 * Create a new driving time timecard entry
	 *
	 * @param int    $user_id       User Id
	 * @param string $workorder_id  Work order Id
	 * @param string $date          Date
	 * @param int    $start_hour    Start hour
	 * @param int    $start_min     Start minute
	 * @param string $start_pmam    Start period
	 * @param int    $stop_hour     Stop hour
	 * @param int    $stop_min      Stop minute
	 * @param string $stop_pmam     Stop period
	 *
	 * @return bool
	 */
	public function add_driving_time($user_id, $workorder_id, $date, $start_hour, $start_min, $start_pmam, $stop_hour, $stop_min, $stop_pmam)
	{
		$this->db->set('workorder_id', $workorder_id);
		$this->db->set('user_id', $user_id);
		$this->db->set('start_hour', $start_hour);
		$this->db->set('start_min', $start_min);
		$this->db->set('start_pmam', $start_pmam);
		$this->db->set('stop_hour', $stop_hour);
		$this->db->set('stop_min', $stop_min);
		$this->db->set('stop_pmam', $stop_pmam);

		$this->db->set('date', $date);
		$this->db->set('submit_time', 'NOW() - INTERVAL 1 SECOND', FALSE);
		$this->db->set('driving_time', TRUE);

		return $this->db->insert('timesheets');
	}

	/**
	 * Create a new lunch time timecard entry
	 *
	 * @param int    $user_id       User Id
	 * @param string $workorder_id  Work order Id
	 * @param string $date          Date
	 * @param int    $start_hour    Start hour
	 * @param int    $start_min     Start minute
	 * @param string $start_pmam    Start period
	 * @param int    $stop_hour     Stop hour
	 * @param int    $stop_min      Stop minute
	 * @param string $stop_pmam     Stop period
	 *
	 * @return bool
	 */
	public function add_lunch_time($user_id, $workorder_id, $date, $start_hour, $start_min, $start_pmam, $stop_hour, $stop_min, $stop_pmam)
	{
		$this->db->set('workorder_id', $workorder_id);
		$this->db->set('user_id', $user_id);
		$this->db->set('start_hour', $start_hour);
		$this->db->set('start_min', $start_min);
		$this->db->set('start_pmam', $start_pmam);
		$this->db->set('stop_hour', $stop_hour);
		$this->db->set('stop_min', $stop_min);
		$this->db->set('stop_pmam', $stop_pmam);

		$this->db->set('date', $date);
		$this->db->set('submit_time', 'NOW() - INTERVAL 1 SECOND', FALSE);
		$this->db->set('lunch_time', TRUE);

		return $this->db->insert('timesheets');
	}

	//updates timecard to set end time
	public function timecard_update($timecard_id, $stop_hour, $stop_min, $stop_pmam, $user_id){

                log_message('debug', '--------------> timecards update tcid: ' . print_r($timecard_id, TRUE));
		$this->db->set('user_id', $user_id);
		$this->db->set('stop_hour', $stop_hour);
		$this->db->set('stop_min', $stop_min);
		$this->db->set('stop_pmam', $stop_pmam);
		$this->db->set('submit_time', 'NOW()', FALSE);
		$this->db->where('id', $timecard_id);
		$db_result = $this->db->update('timesheets');
		//$strSQL = $this->db->get_compiled_update('timesheets', FALSE);

		//$db_result = $this->db->query($strSQL);
                //log_message('debug', '---> timecards update sql: ' . print_r($strSQL, TRUE));
                log_message('debug', '---------------> timecards update result: ' . print_r($db_result, TRUE));
		return $db_result;	
	}

	/**
	 * Get timecards for users who are legible for auto clockout checks
	 *
	 * @todo Ask if anyone may ever work from 11pm -> 1 am
	 *
	 * @return array
	 */
	public function legible_for_clockout()
	{
		// Fetch all of today's timecards for users who have any timecards open
		$sql = "SELECT * FROM timesheets WHERE user_id IN (
			SELECT
				user_id
			FROM
				timesheets
			WHERE
				date = CURRENT_DATE() AND
				stop_hour IS NULL
		) AND date = CURRENT_DATE() ORDER BY submit_time ASC";

		$query = $this->db->query($sql);

		$users = [];

		//Group timecards per user id
		foreach ($query->result() as $result) {

			if (!array_key_exists($result->user_id, $users)) $users[$result->user_id] = [];
			
			$users[$result->user_id][] = $result;
		}

		return $users;
	}

	/**
	 * For user with id $user, returns the ids of completed timecards in the daysfor the month $month
	 * between $start and $end inclusive which have not been turned in
	 *
	 * @param int $user  User Id
	 * @param string $start  Start date
	 * @param string $end End date
	 *
	 * @return array
	 */
	public function unsubmittedForPeriod($user, $start, $end)
	{
		//http://stackoverflow.com/questions/33076281/value-is-not-null-in-codeigniter
		//http://stackoverflow.com/questions/9941521/using-between-in-where-condition
		//http://stackoverflow.com/questions/9104704/select-mysql-based-only-on-month-and-year
/*
$strSQL = $this->db->select('id')
                        ->where('user_id', $user)
                        ->where('timecard_submission_id', NULL)
                        ->where('stop_hour IS NOT NULL', NULL, FALSE)
                        ->where('stop_min IS NOT NULL', NULL, FALSE)
                        ->where('stop_pmam IS NOT NULL', NULL, FALSE)
                        ->where('date >=', $start)
                        ->where('date <=', $end);
*/
//$strquery = $this->db->get_compiled_select('timesheets',FALSE);
//var_dump($strquery);
		$query = $this->db->select('id')
			->where('user_id', $user)
			->where('timecard_submission_id', NULL)
			->where('stop_hour IS NOT NULL', NULL, FALSE)
			->where('stop_min IS NOT NULL', NULL, FALSE)
			->where('stop_pmam IS NOT NULL', NULL, FALSE)
			->where('date >=', $start)
			->where('date <=', $end)
			->get('timesheets');

		$ids = [];

		foreach($query->result() as $result) {
			$ids[] = $result->id;
		}

		return $ids;
	}

	/**
	 * Given timecard IDs, the method will set their timecard_submission_id columns
	 * to the specificed $id
	 *
	 * @param int        $id           Id to set the timecard_submission_id column to
	 * @param int|array  $timecardIds  Ids of timecards to update
	 *
	 * @return void
	 */
	public function set_submission_id($id, $timecardIds)
	{
		if (!is_array($timecardIds)) $timecardIds = [$timecardIds];

		$this->db->set('timecard_submission_id', $id);
		$this->db->where_in('id', $timecardIds);
		$this->db->update('timesheets');
	}

	/**
	 * Determines if the user did not submit a timecard the previous day
	 *
	 * @param int  $user   User Id
	 *
	 * @return void
	 */
	public function missed($user)
	{
		// check if user has no timecards
		$timecards = $this->timecard_model->get_timesheets_count($this->session->user_id);
		if ($timecards < 1) return false;

		if ($this->has_any_today($user)) return false;

		//for any page, store most recent timecard submit (for comparing later)
		$recent_timecard = $this->get_RecentTimecardByUser($user);

		//reverse this when done testing
		$last_timecard = date('Y-m-d', strtotime($recent_timecard->submit_time) );
		$yesterday = date('Y-m-d', strtotime('-1 day') );
		if ( $last_timecard != $yesterday ) return true;

		return false;
	}

	/**
	 * Checks if the user has created any timecards today
	 *
	 * @param int  $user   User Id
	 *
	 * @return void
	 */
	public function has_any_today($user)
	{
		$db_result = $this->db->get_where(
			'timesheets',
			[
				'date' => Carbon::today()->toDateString(),
				'user_id' => $user
			],
			1
		);

		return ($db_result->num_rows() > 0);
	}

	/**
	 * Get timecard(s) with id $ids
	 *
	 * @param int|array $ids  Id(s_ of timecard(s) to retrieve
	 *
	 * @return void
	 */
	public function find($ids)
	{
		if (!is_array($ids)) $ids = [$ids];

		$this->db->where_in('id', $ids);

		$db_result = $this->db->get('timesheets');

		return $db_result->result();
	}

	/**
	 * Get the most recent open timecard from today for the user
	 *
	 * @param int $user_id  User id
	 *
	 * @return StdClass|false
	 */
	public function get_open_timecard($user_id)
	{
		$this->db->where('date = CURRENT_DATE()', NULL, FALSE);
		$this->db->where('user_id', $user_id);
		$this->db->where('stop_hour IS NULL', NULL, FALSE);
		$this->db->order_by('submit_time', 'desc');
		$this->db->limit(1);

		$db_result = $this->db->get('timesheets');

		if (!$db_result->num_rows()) return false;

		return $db_result->row();
	}

	/**
	 * Check if the user is legible for driving time
	 *
	 * @param string $workorder_id  Work order id
	 * @param int $user_id  User id
	 *
	 * @return false|StdClass
	 */
	public function legible_for_driving_time($workorder_id, $user_id)
	{
		$this->db->where('date = CURRENT_DATE()', NULL, FALSE);
		$this->db->where('user_id', $user_id);
		$this->db->order_by('submit_time', 'desc');
		$this->db->limit(1);

		$db_result = $this->db->get('timesheets');

		if (!$db_result->num_rows()) return false;

		// And check if the WOs are different
		if ($workorder_id === $db_result->row()->workorder_id) return false;

		return $db_result->row();
	}

	/**
	 * Get timecards for user $user_id with timecard_submission_id $submission_id
	 *
	 * @param int|int[] $submission_ids Submission Id(s)
	 * @param int 		$user_id User 	Id
     * @param int 		$page_number 	(Optional) Page number
	 * @param string 	$order_by 		(Optional) Name of column to order by
	 * @param bool 		$ascending 		(Optional) Order ascending
	 *
	 * @return StdClass[]
	 */
	public function for_submission($submission_ids, $user_id, $page_number = 0, $order_by = null, $ascending = true)
	{
		if (!is_array($submission_ids)) $submission_ids = [$submission_ids];

		$this->db->where_in('timecard_submission_id', $submission_ids);
		$this->db->where('user_id', $user_id);

		if ($order_by) {
			$asc = $ascending ? 'asc' : 'desc';
			$this->db->order_by($order_by, $asc);
		} else {
			$this->db->order_by('submit_time', 'asc');
		}

		if ($page_number) $this->db->limit(6, $page_number);

		$db_result = $this->db->get('timesheets');

		return $db_result->result();
	}

	/**
	 * Get all the timesheets that the user has worked on so far today
 	 *
	 * @param int $user_id User Id
	 *
	 * @return StdClass[]
	 */
	public function todays_timecards($user_id)
	{
		$this->db->where('date = CURRENT_DATE()', NULL, FALSE);
		$this->db->where('user_id', $user_id);

		$db_result = $this->db->get('timesheets');

		return $db_result->result();
	}

	/**
	 * Get the number timecards for user $user_id with timecard_submission_id $submission_ids
	 *
	 * @param int|int[] $submission_ids Submission Id(s)
	 * @param int 		$user_id User 	Id
	 *
	 * @return StdClass[]
	 */
	public function count_for_submission($submission_ids, $user_id)
	{
		if (!is_array($submission_ids)) $submission_ids = [$submission_ids];

		$this->db->where_in('timecard_submission_id', $submission_id);
		$this->db->where('user_id', $user_id);
		$this->db->from('timesheets');

		return $this->db->count_all_results();
	}

	/**
	 * Check if the user has any lunch timecard from today
	 *
	 * @param int $user_id  User Id
	 *
	 * @return bool
	 */
	public function user_took_lunch($user_id)
	{
		$db_result = $this->db->get_where(
			'timesheets',
			[
				'date' => Carbon::today()->toDateString(),
				'user_id' => $user_id,
				'lunch_time' => TRUE
			],
			1
		);

		return ($db_result->num_rows() > 0);
	}

	public function user_open_timecard()
	{
		$this->load->database();
		$this->db->where('stop_hour', NULL);
		$db_result = $this->db->get('timesheets');

		$results = $db_result->result();
		
		foreach ($results as $result) {
			$users[] = $result->user_id;
		}

		return $users;

	}

	public function mark_as_overtime($id, $hours_limit, $overtime_reason)
	{
		$this->db->set('overtime_reason', $overtime_reason);
		$this->db->set('hours_limit', $hours_limit);
		$this->db->where('id', $id);
		$this->db->update('timesheets');
	}

}
