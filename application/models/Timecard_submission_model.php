<?php

Class Timecard_submission_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	/**
	 * Creates a new entry in the table, returns the row id
	 *
	 * @param int    $user       User Id
	 * @param string $signature  Signature
	 * @param int    $pay_period_number  Pay period number
	 *
	 * @return int
	 */
	public function create($user, $signature, $pay_period_number)
	{
		$this->db->set('user_id', $user);
		$this->db->set('user_signature', $signature);
		$this->db->set('pay_period_number', $pay_period_number);
		$this->db->set('submit_time', 'NOW()', FALSE);
		$this->db->insert('timecard_submissions');

		return $this->db->insert_id();
	}

    /**
     * Get the most recent pay period
     *
     * @return int
     */
    public function most_recent_pay_period()
    {
		$query = "SELECT MAX(pay_period_number) as pay_period_number FROM timecard_submissions WHERE YEAR(submit_time) = YEAR(CURDATE())";

		$db_result = $this->db->query($query);

		return (int) $db_result->row()->pay_period_number;
	}

    /**
     * Get all submissions with Pay Period Number $pay_period_number
     *
     * @param int $pay_period_number  Pay Period Number
     *
     * @return StdClass[]
     */
    public function for_period($pay_period_number)
    {
	/*
		$db_result = $this->db->get_where(
			'timecard_submissions',
			[
				'pay_period_number' => $pay_period_number,
			]
		);
	*/	
		$db_result = $this->db->get_where('timecard_submissions', "pay_period_number = $pay_period_number AND YEAR(submit_time) = YEAR(CURDATE())", FALSE);

		return $db_result->result();
    }

    /**
     * Get all submission ids for user with id $user
     *
     * @param int $user 		User Id
     *
     * @return int[]
     */
    public function for_user($user)
    {
		$this->db->select('id');

		$db_result = $this->db->get_where(
			'timecard_submissions',
			[
				'user_id' => $user,
			]
		);

		$results = [];

		foreach ($db_result->result() as $submission) {
			$results[] = $submission->id;
		}

		return $results;
    }

}
