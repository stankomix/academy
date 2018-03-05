<?php

Class Managers_sms_model extends CI_Model {

	/**
	 * Default job title for managers
	 *
	 * @var string MANAGER_JOB_NAME
	 */
	const MANAGER_JOB_NAME = 'Manager';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Queue an sms $sms to be sent to managers with job name $job
	 *
	 * @param string 		$sms 	Message to send
	 * @param string|null 	$job 	Manager job name 
	 *
	 * @return void
	 */
	public function add_job($sms, $job = null)
	{
		$this->db->set('sms', $sms);

		if (!$job) $job = self::MANAGER_JOB_NAME; 

		$this->db->set('job', $job);

		$this->db->insert('managers_sms');
	}

	/**
	 * Get the next sms to be sent
	 *
	 * @return object
	 */
	public function next_job()
	{
		$this->db->where('sent', 0);
		$this->db->order_by('created_at', 'ASC');
		$this->db->limit(1);

		$db_result = $this->db->get('managers_sms');

		if (!$db_result->num_rows()) return false;

		return $db_result->row();
	}

	/**
	 * Mark job id $id as sent
	 *
	 * @todo Maybe just delete the sent jobs?
	 *
	 * @param int $id Job id
	 *
	 * @return void
	 */
	public function mark_sent($id)
	{
		$this->db->where('id', $id);
		$this->db->set('sent', 1);
		$this->db->limit(1);

		$this->db->update('managers_sms');
	}

}
