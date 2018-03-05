<?php

use Carbon\Carbon;

class Clockout_notifications_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Check if a notification exists for today, and how old it is in minutes
	 *
	 * @param int 		$user_id  			User Id
	 * @param string 	$notification_name  Notification name
	 * @param int|null 	$timesheet_id  		(Optional) Timesheet Id
	 *
	 * @return false|mixed
	 */
	public function exists($user_id, $notification_name, $timesheet_id = null)
	{
		$this->db->where('user_id', $user_id);

		if ($timesheet_id) $this->db->where('timesheet_id', $timesheet_id);

		$this->db->where('notification_name', $notification_name);
		$this->db->where('DATE(created_at) = CURRENT_DATE()', NULL, FALSE);

		$db_result = $this->db->get('clockout_notifications');

		if ($db_result->num_rows() === 0) return FALSE;

		// How many minutes ago was it sent?
		$ageInMinutes = Carbon::parse($db_result->row()->created_at)->diffInMinutes(Carbon::now());

		return [true, $ageInMinutes];
	}

	/**
	 * Create a new entry
	 *
	 * @param int 		$user_id  			User Id
	 * @param string 	$notification_name  Notification name
	 * @param int|null 	$timesheet_id  		(Optional) Timesheet Id for this notification
	 *
	 * @return void
	 */
	public function create($user_id, $notification_name, $timesheet_id = null)
	{
		$this->db->set('user_id', $user_id);
		$this->db->set('notification_name', $notification_name);
		$this->db->set('timesheet_id', $timesheet_id);
		$db_result = $this->db->insert('clockout_notifications');

		return $db_result;
	}

}
