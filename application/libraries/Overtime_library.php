<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Overtime_library {

	/**
	 * Reference to CodeIgniter
	 *
	 * @var object
	 */
    protected $CI;

    public function __construct()
    {
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        $this->CI->config->load('notifications');
        $this->CI->load->library('cfpslack_library');
    }

	/**
	 * Creates a new overtime request and sends a request to the Slack service
	 *
	 * @param int 		$userId 		User Id
	 * @param int 		$workorderId 	Workorder Id
	 * @param int 		$startHour 		Timecard start hour
	 * @param int 		$startMin 		Timecard start minute
	 * @param string 	$startPmAm 		Start time PM/AM
	 * @param date 		$timecardDate 	Timecard date
	 * @param string	$username 		User name
	 * @param string	$reason 		Overtime reason
	 *
	 * @return bool
	 */
	public function createRequest($userId, $workorderId, $startHour, $startMin, $startPmAm, $timecardDate, $username, $reason)
	{
		$this->CI->load->model('overtime_model', '', TRUE);
		$this->CI->load->model('user_model');
		$this->CI->load->model('managers_sms_model');

		$id = $this->CI->overtime_model->create(
			$userId,
			$workorderId,
			$startHour,
			$startMin,
			$startPmAm,
			$timecardDate,
			$reason
		);

		$managerNotified = $this->CI->cfpslack_library->request_overtime($id, $workorderId, $username, $reason);

		if ($managerNotified) {
            log_message(
                'debug',
                'OVERTIME_REQUEST > Manager notified successully'
            );

            // Also send an SMS to the managers
			$sms = $this->CI->config->item('overtime_request_manager_sms');
			$sms = sprintf(
				$sms,
				$this->CI->user_model->get_name($userId),
				$workorderId
			);

			$this->CI->managers_sms_model->add_job($sms);

			return true;
		}

        log_message(
            'debug',
            'OVERTIME_REQUEST > Failed to notify manager'
        );

		$this->CI->overtime_model->remove($id);
		return false;
	}

	/**
	 * Process response to workorder approval request
	 *
	 * The latest request for the specified workorder
	 * is the one that will be considered
	 *
	 * @param int 		$request_id 	Overtime request Id
	 * @param string 	$decision 		Manager's decision 	Workorder Id
	 * @param int 		$hours 			Hours manager has set for the overtime
	 *
	 * @return void
	 */
	public function process_response($request_id, $decision, $hours)
	{
		$this->CI->load->model('overtime_model', '', TRUE);
		$this->CI->load->model('timecard_model', '', TRUE);

		//Fetch overtime card
		$overtimeRequest = $this->CI->overtime_model->find($request_id);

		//Ignore update if workorder doesn't exist
		if (!$overtimeRequest) return;

		//Delete request
		$this->CI->overtime_model->remove($overtimeRequest->id);

		if ($decision === 'reject') {
			$this->notify_denial(
				$overtimeRequest->user_id,
				$overtimeRequest->workorder_id
			);
			return;
		}

		//Create timecard entry
		$this->CI->timecard_model->timecard_create(
			$overtimeRequest->workorder_id,
			$overtimeRequest->start_hour,
			$overtimeRequest->start_min,
			$overtimeRequest->start_pmam,
			$overtimeRequest->timecard_date,
			$overtimeRequest->user_id,
			$overtimeRequest->reason,
			$hours
		);

		//Notify user & manager
		$this->notify_approval(
			$overtimeRequest->user_id,
			$overtimeRequest->workorder_id,
			$hours
		);
	}

	/**
	 * Notifies $userId that their overtime request has been denied
	 * Will also update the Overtime request message on Slack
	 *
	 * @param int    $userId 	   User Id
	 * @param int    $workorderId  Workorder Id
	 *
	 * @return void
	 */
	public function notify_denial($userId, $workorderId)
	{
		$this->CI->load->library('sms_library');
		$this->CI->load->model('managers_sms_model', '', TRUE);
		$this->CI->load->model('user_model');

		$sms = $this->CI->config->item('overtime_denial_sms');
		$sms = sprintf($sms, $workorderId);

		$this->CI->sms_library->send(
			$userId,
			$sms,
			$workorderId
		);

        // Also send an SMS to the managers
		$managerSMS = $this->CI->config->item('overtime_denial_manager_sms');
		$managerSMS = sprintf(
			$managerSMS,
			$this->CI->user_model->get_name($userId),
			$workorderId
		);

		$this->CI->managers_sms_model->add_job($managerSMS);
	}

	/**
	 * Notifies $userId that their overtime request has been denied
	 * Will also update the Overtime request message on Slack
	 *
	 * @param int    $userId 	   User Id
	 * @param int    $workorderId  Workorder Id
	 * @param int    $hours  	   Hours the manager has allocated 
	 *
	 * @return void
	 */
	public function notify_approval($userId, $workorderId, $hours)
	{
		$this->CI->load->library('sms_library');
		$this->CI->load->library('cfpslack_library');
		$this->CI->load->model('managers_sms_model', '', TRUE);
		$this->CI->load->model('user_model');

		$sms = $this->CI->config->item('overtime_approval_sms');
		$sms = sprintf($sms, $hours, $workorderId);

		$this->CI->sms_library->send(
			$userId,
			$sms,
			$workorderId
		);

        // Also send an SMS to the managers
		$managerSMS = $this->CI->config->item('overtime_approval_manager_sms');
		$managerSMS = sprintf(
			$managerSMS,
			$this->CI->user_model->get_name($userId),
			$hours
		);

		$this->CI->managers_sms_model->add_job($managerSMS);
	}

	/**
	 * Check if the user has not worked over 8 hours already today
	 *
	 * @param int $userId User Id
	 *
	 * @return bool
	 */
	public function has_worked_over_eight_hours($userId)
	{
		$this->CI->load->model('timecard_model');
		$this->CI->load->library('clockout_library');

		$timesheets = $this->CI->timecard_model->todays_timecards($userId);

		// Total hours in the prior timesheets that have been closed
		$hoursInClosedTimesheets = $this->CI->clockout_library->hours_in_closed_timesheets($timesheets);

		// Time worked so far in the open timecard
		$hoursInCurrentSprint = $this->CI->clockout_library->hours_in_open_timesheets($timesheets);

		// Sum of $hoursInClosedTimesheets + $currentSprint
		$totalWorked = $hoursInClosedTimesheets + $hoursInCurrentSprint;

		return ($totalWorked >= 8);
	}

}
