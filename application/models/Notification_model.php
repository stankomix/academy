<?php

Class Notification_model extends CI_Model {

	public function __construct()
	{
		$this->smsEnabled = $this->config->item('enable_sms');

		$this->twilioClient = new Twilio\Rest\Client(
			$this->config->item('twilio_sid'),
			$this->config->item('twilio_token')
		);
	}

	/**
	 * Inserts an entry for $timecard into the notifications table
	 *
	 * @param object $timecard 	Timecard
	 * @param string $type 		Notification type
	 *
	 * @return void
	 */
	public function create_notification($timecard, $type)
	{
		$this->db->set('timesheet_id', $timecard->id);
		$this->db->set('sent', TRUE);
		$this->db->set('notification_type_id', $type);
		$this->db->set('user_id', $timecard->user_id);
		$this->db->set('sent_at', 'NOW()', FALSE);
		$db_result = $this->db->insert('notifications');

		return $db_result;
	}

}
