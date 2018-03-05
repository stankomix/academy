<?php

/**
 * timesheet_requests table's model class.
 *
 * @author 		Sam Takunda <sam.takunda@gmail.com>
 * @copyright 	(c) 2017, Commercial Fire Protection
 */

Class Timecard_request_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	/**
	 * Create a new request
	 *
	 * @param string 		$workorder_id  	Work order Id
	 * @param int    		$start_hour    	Start hour
	 * @param int    		$start_min     	Start minute
	 * @param string 		$start_pmam    	Start period
	 * @param int    		$end_hour    	End hour
	 * @param int    		$end_min     	End minute
	 * @param string 		$end_pmam    	End period
	 * @param string 		$date          	Date
	 * @param int    		$user_id       	User Id
	 * @param string  		$overtime_reason  Reason timecard was started (applies to overtime)
	 * @param int 	   		$hours_limit   	Maximum number of hours allowed for this timecard
	 *
	 * @return void
	 */
	public function create(
		$workorder_id,
		$user_id,
		$date,
		$start_hour,
		$start_min,
		$start_pmam,
		$stop_hour,
		$stop_min,
		$stop_pmam,
		$submit_time,
		$overtime_reason = null,
		$hours_limit = null
	)
	{
		$fields = [
			'workorder_id'		=> $workorder_id,
			'user_id'			=> $user_id,
			'date'				=> $date,
			'start_hour'		=> $start_hour,
			'start_min'			=> $start_min,
			'start_pmam'		=> $start_pmam,
			'stop_hour'			=> $stop_hour,
			'stop_min' 			=> $stop_min,
			'stop_pmam' 		=> $stop_pmam,
			'submit_time' 		=> $submit_time
		];

		if ($overtime_reason) {
			$fields['overtime_reason'] = $overtime_reason;
			$fields['hours_limit'] = $hours_limit;
		}

		$this->db->insert('timesheet_requests', $fields);
	}

	/**
	 * Get all timecards the admin created for user with id $user_id
	 *
	 * @param int $user_id  User Id
	 *
	 * @return Object[]
	 */
	public function for_user($user_id)
	{
		$this->db->order_by('submit_time', 'desc');
		$db_result = $this->db->get_where(
			'timesheet_requests',
			[
				'user_id' => $user_id
			]
		);

		return $db_result->result();
	}

	/**
	 * Approve admin timecard
	 *
	 * @param int $id 		Id of timecard
	 * @param int $user_id 	Id of user approving the timecard
	 *
	 * @return void
	 */
	public function approve($id, $approving_user_id)
	{
		$db_result = $this->db->get_where('timesheet_requests', ['id' => $id]);
		$request = $db_result->row();
		if (!$request) return;

		if ((int)$approving_user_id !== (int)$request->user_id) return;

		$this->timecard_model->admin_timecard_create([
			'workorder_id'		=> $request->workorder_id,
			'user_id'			=> $request->user_id,
			'date'				=> $request->date,
			'start_hour'		=> $request->start_hour,
			'start_min'			=> $request->start_min,
			'start_pmam'		=> $request->start_pmam,
			'stop_hour'			=> $request->stop_hour,
			'stop_min' 			=> $request->stop_min,
			'stop_pmam' 		=> $request->stop_pmam,
			'submit_time' 		=> $request->submit_time,
			'overtime_reason' 	=> $request->overtime_reason,
			'hours_limit' 		=> $request->hours_limit,
		]);

		// Delete the request
		$this->db->where('id', $request->id)->delete('timesheet_requests');
	}

}
