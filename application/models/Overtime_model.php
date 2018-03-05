<?php

Class Overtime_model extends CI_Model{

	public function __construct() {
		parent::__construct();
	}

	/**
	 * Creates and saves a new overtime request. Returns row id
	 *
	 * @param int 		$userId 		User Id
	 * @param int 		$workorderId 	Workorder Id
	 * @param int 		$startHour 		Timecard start hour
	 * @param int 		$startMin 		Timecard start minute
	 * @param string 	$startPmAm 		Start time PM/AM
	 * @param date 		$timecardDate 	Timecard date
	 * @param string	$reason 		Overtime reason
	 *
	 * @return int
	 */
	public function create($userId, $workorderId, $startHour, $startMin, $startPmAm, $timecardDate, $reason)
	{
		$this->db->set('user_id', $userId);
		$this->db->set('workorder_id', $workorderId);
		$this->db->set('start_hour', $startHour);
		$this->db->set('start_min', $startMin);
		$this->db->set('start_pmam', $startPmAm);
		$this->db->set('timecard_date', $timecardDate);
		$this->db->set('reason', $reason);

		$this->db->insert('overtimes');

		return $this->db->insert_id();
	}

	/**
	 * Checks if an overtime request has not already been submitted today
	 * for the user
	 *
	 * @param int 		$userId 		User Id
	 * @param int 		$workorderId 	Workorder Id
	 * @param date 		$timecardDate 	Timecard date
	 *
	 * @return bool 
	 */
	public function requested_already($userId, $workorderId, $timecardDate)
	{
		//select and count
		$db_result = $this->db->get_where('overtimes', array(
			'user_id' 		=> $userId,
			'workorder_id' 	=> $workorderId,
			'timecard_date' => $timecardDate
		));

		return ($db_result->num_rows() > 0 );
	}

	/**
	 * Finds and returns the overtime request with id $id
	 *
	 * @param int $id  Id
	 *
	 * @return object
	 */
	public function find($id)
	{
		$db_result = $this->db->get_where(
			'overtimes',
			[
				'id' => $id
			],
			1
		);

		if (!$db_result->num_rows()) return false;

		return $db_result->row();
	}

	/**
	 * Deletes overtime request with id $id
	 *
	 * @param int $id Id
	 *
	 * @return void
	 */
	public function remove($id)
	{
		$this->db->where('id', $id)->delete('overtimes');
	}

}
