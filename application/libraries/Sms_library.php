<?php

Class Sms_library {

	/**
	 * Reference to CodeIgniter
	 *
	 * @var object
	 */
    protected $CI;

	/**
	 * Whether sending of SMS' is enabled or not
	 *
	 * @var bool
	 */
    private $smsEnabled;

	/**
	 * Twilio client
	 *
	 * @var Twilio\Rest\Client
	 */
    private $twilioClient;

    public function __construct()
    {
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        $this->CI->config->load('notifications');
        $this->CI->load->model('user_model');
	
		$this->smsEnabled = $this->CI->config->item('enable_sms');

		$this->twilioClient = new Twilio\Rest\Client(
			$this->CI->config->item('twilio_sid'),
			$this->CI->config->item('twilio_token')
		);
	}

	/**
	 * Sends an SMS message to $recipient
	 *
	 * @param int 		$userId 	Id of user to send SMS to
	 * @param string 	$message 	Message to send
	 * @param int    	$workorder 	Workorder Id (Optional)
	 *
	 * @return void
	 */
	public function send($userId, $message, $workorder = null)
	{
		if (!$this->smsEnabled) return;

		$recipient = $this->CI->user_model->get_phone($userId);

		//In case some users do not have phone numbers set yet
		if (!$recipient) return;

        log_message(
            'debug',
            'SMS > ' . $recipient . ':' .$message
        );

		try {
			
			$message = $this->twilioClient->messages->create(
			  $recipient,
			  array(
			    'from' => $this->CI->config->item('twilio_from'),
			    'body' => $message
			  )
			);

		} catch(Exception $e) {

			$this->alertAdminAboutFailure($userId, $workorder);

		}
	}

	/**
	 * Alert admin about the Twilio error
	 *
	 * @param int $userId 		Id of user to send SMS to
	 * @param int $workorder 	Workorder Id (Optional)
	 *
	 * @todo Create generic Slack library
	 *
	 * @return void
	 */
	private function alertAdminAboutFailure($userId, $workorder)
	{
		try {

			Requests::post(
				'https://cfpslack.fireprotected.com/cfpslack/timecard_smsfail/' . $userId . '/' . $workorder,
				[],
				[],
				[
					'verify' => false //Because our SSL is self-signed, so we switch off verification
				]
			);

		} catch (Exception $e) {
			
		}
	}

	/**
	 * Fetches a queued SMS job and sends it
	 *
	 * @return void
	 */
	public function send_queued()
	{
		if (!$this->smsEnabled) return;

		$this->CI->load->model('managers_sms_model', '', TRUE);

		$job = $this->CI->managers_sms_model->next_job();

		if (!$job) return;

		$recipients = $this->CI->user_model->users_with_job($job->job);

		foreach ($recipients as $recipient) {
			$this->send($recipient, $job->sms);
		}

		$this->CI->managers_sms_model->mark_sent($job->id);
	}

}
