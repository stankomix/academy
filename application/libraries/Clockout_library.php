<?php

/**
 * Clockout Library
 *
 * Handles checks and actions related to clocking out
 *
 * @author Sam Takunda <sam.takunda@gmail.com>
 * @copyright (c) 2016, CFP.
 * 
 */

defined('BASEPATH') OR exit('No direct script access allowed');

use Carbon\Carbon;

class Clockout_library {

	/**
	 * The minimum number of BlueFolder comments expected on
	 * a work order when a timecard is clocked out
	 *
	 * @var int
	 */
	const BF_COMMENTS_CLOSE_TIMECARD = 2;

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
    }

	public function run_checks()
	{
		$users = $this->CI->timecard_model->legible_for_clockout();

		foreach ($users as $userId => $timesheets) {

			$open_timesheet = $this->get_open_timesheet($timesheets);

			// Get the non-overtime timecards
			$regular_timesheets = array_filter($timesheets, function($t) {
				return is_null($t->overtime_reason);
			});

			// Check 5th hour
			$five_minutes = 5/60;
			if ($this->has_passed_limit($regular_timesheets, (5 + $five_minutes))) {
				if ($this->fifth_hour_clockout($open_timesheet)) continue;
			}

			// Check 8th hour
			if ($this->has_passed_limit($regular_timesheets, 8)) {
				if ($this->eighth_hour_clockout($open_timesheet, 8)) continue;
			}

			// Check 12th hour
			if ($this->has_passed_limit($regular_timesheets, 12)) {
				if ($this->auto_clockout($open_timesheet, 12)) continue;
			}

			// Check if the open timecard is an overtime one
			if (!is_null($open_timesheet->overtime_reason)) {
				$passed = $this->has_passed_limit($open_timesheet, (int)$open_timesheet->hours_limit);

				// This clockout must be specific to the overtime timecard, hence the true flag
				if ($passed) $this->auto_clockout($open_timesheet, $open_timesheet->hours_limit, true);
			}

		}
	}

	/**
	 * Given a set of timecards which has in it an open timecard
	 * the function checks if the work has passed over limit $limit.
	 * If limit was met in a closed timecard and NOT expected to be met
	 * in the current open timecard, function returns false
	 *
	 * @param StdClass[] $timesheets  Timesheets
	 * @param int $limit   Hours to check against
	 * 
	 * @return bool
	 */
	public function has_passed_limit($timesheets, $limit)
	{
		$limit = $limit - (5/60);

		if (!is_array($timesheets)) $timesheets = [$timesheets];

		// Total hours in the prior timesheets that have been closed
		$hoursInClosedTimesheets = $this->hours_in_closed_timesheets($timesheets);

		// Time worked so far in the open timecard
		$hoursInCurrentSprint = $this->hours_in_open_timesheets($timesheets);

		// Sum of $hoursInClosedTimesheets + $currentSprint
		$totalWorked = $hoursInClosedTimesheets + $hoursInCurrentSprint;

		// Was $limit met in the closed cards?
		// If so return true because reminders were probably sent (or user closed in time)
		if ($hoursInClosedTimesheets >= $limit) return false;

		if ($totalWorked > $limit) return true;

		return false;
	}

	/**
	 * Get the total number of hours worked in all closed timesheets in $timesheets
	 *
	 * @param StdClass[]|StdClass $timesheets Timesheets
	 *
	 * @return float
	 */
	public function hours_in_closed_timesheets($timesheets)
	{
		if (!is_array($timesheets)) $timesheets = [$timesheets];

		$hours = 0;
		$start = null;
		$stop = null;

		foreach ($timesheets as $timesheet) {

			// Check if closed
			if (!$timesheet->stop_hour) continue;
			if ($timesheet->lunch_time) continue;

			$start = Carbon::createFromFormat(
				'Y-m-d h:i A',
				$timesheet->date . ' ' . $timesheet->start_hour . ':' .$timesheet->start_min . ' ' . $timesheet->start_pmam
			);

			$stop = Carbon::createFromFormat(
				'Y-m-d h:i A',
				$timesheet->date . ' ' . $timesheet->stop_hour . ':' .$timesheet->stop_min . ' ' . $timesheet->stop_pmam
			);

			$hours += $start->diffInMinutes($stop) / 60;
		}

		return number_format( (float)$hours, 2, '.', '');
	}

	/**
	 * Get the total number of hours worked in all open timesheets in $timesheets
	 *
	 * @param StdClass[]|StdClass $timesheets Timesheets
	 *
	 * @return float
	 */
	public function hours_in_open_timesheets($timesheets)
	{
		if (!is_array($timesheets)) $timesheets = [$timesheets];

		$hours = 0;
		$start = null;

		foreach ($timesheets as $timesheet) {

			// Check if open
			if ($timesheet->stop_hour) continue;

			$start = Carbon::createFromFormat('Y-m-d H:i:s', $timesheet->submit_time);

			$hours += $start->diffInMinutes(Carbon::now()) / 60;
		}

		return $hours;
	}

	/**
	 * Given a set of timesheets, it will return the open timesheet
	 *
	 * @param StdClass[] $timesheets  Timesheets
	 *
	 * @return StdClass
	 */
	public function get_open_timesheet(array $timesheets)
	{
		foreach ($timesheets as $timesheet) {
			if (!$timesheet->stop_hour) {
				return $timesheet;
			}
		}
	}

	/**
	 * Sends a 5th hour clock out reminder for given timesheet
	 *
	 * Returns true if notification was sent for the first tme.
	 *
	 * @param StdClass $timesheet  Timesheet
	 *
	 * @return bool
	 */
	public function fifth_hour_clockout($timesheet)
	{
		$sent_already = $this->CI->clockout_notifications_model->exists(
			$timesheet->user_id,
			'LUNCH'
		);

		if ($sent_already) return false;

		// Check if the user created a lunch timecard themselves
		if ($this->CI->timecard_model->user_took_lunch($timesheet->user_id)) return false;

		// Send notification to managers
		$this->CI->cfpslack_library->notify(
			sprintf(
				$this->CI->config->item('fifth_hour_admin'),
				$this->CI->user_model->get_name($timesheet->user_id),
				$timesheet->workorder_id,
				$timesheet->id
			)
		);

		// SMS the user
		$this->CI->sms_library->send(
			$timesheet->user_id,
			$this->CI->config->item('fifth_hour_sms'),
			$timesheet->workorder_id
		);

		// Mark sending
		$this->CI->clockout_notifications_model->create(
			$timesheet->user_id,
			'LUNCH',
			$timesheet->id
		);

		return true;
	}

	/**
	 * Sends a 8th hour clock out reminder for given timesheet
	 *
	 * Returns true if notification was sent for the first tme.
	 *
	 * @param StdClass $timesheet  Timesheet
	 *
	 * @return bool
	 */
	public function eighth_hour_clockout($timesheet)
	{
		$sent_already = $this->CI->clockout_notifications_model->exists(
			$timesheet->user_id,
			'CLOCKOUT_FIRST_8HOUR_WARNING'
		);

		if ($sent_already) return false;

		// Send notification to managers
		$this->CI->cfpslack_library->notify(
			sprintf(
				$this->CI->config->item('eighth_hour_5min_clockout'),
				$this->CI->user_model->get_name($timesheet->user_id),
				$timesheet->workorder_id,
				$timesheet->id
			)
		);

		// SMS the user
		$this->CI->sms_library->send(
			$timesheet->user_id,
			$this->CI->config->item('eighth_hour_sms'),
			$timesheet->workorder_id
		);

		// Mark sending
		$this->CI->clockout_notifications_model->create(
			$timesheet->user_id,
			'CLOCKOUT_FIRST_8HOUR_WARNING',
			$timesheet->id
		);

		return true;
	}


	/**
	 * Sends 2 warnings before automatically closing given timecard
	 *
	 * Returns true if notification was sent for the first time
	 *
	 * @param StdClass 	$timesheet  			Timesheet
	 * @param int 		$hours 					Hours in question
	 * @param bool 		$specific_to_timesheet 	(Optional) Is the clockout for a specific
	 * 											timecard or it's generic like lunch?
	 *
	 * @return void
	 */
	public function auto_clockout($timesheet, $hours, $specific_to_timesheet = false)
	{
		$specific_timesheet = $specific_to_timesheet ? $timesheet->id : null;

		$closed_already = $this->CI->clockout_notifications_model->exists(
			$timesheet->user_id,
			'CLOCKOUT_TIMESHEET_CLOSED',
			$specific_timesheet
		);

		if ($closed_already) return false;

		list($last_warning_sent_already, $minutesAgo) = $this->CI->clockout_notifications_model->exists(
			$timesheet->user_id,
			'CLOCKOUT_FINAL_WARNING',
			$specific_timesheet
		);

		if ($last_warning_sent_already) {

			// Check if it's been 5 minutes
			if ($minutesAgo < 5) return false;

			// Close timesheet
			$this->close_timesheet($timesheet);

			// Mark sending
			$this->CI->clockout_notifications_model->create(
				$timesheet->user_id,
				'CLOCKOUT_TIMESHEET_CLOSED',
				$specific_timesheet
			);

			// Notify employee
			$this->CI->sms_library->send(
				$timesheet->user_id,
				$this->CI->config->item('clockout_timesheet_closed'),
				$timesheet->workorder_id
			);


			//Check if a note has been made for this WO
			try {

				$hasNotes = $this->CI->cfpslack_library->check_wo_notes(
					$timesheet->workorder_id,
					self::BF_COMMENTS_CLOSE_TIMECARD
				);


				if (!$hasNotes) {

					// Send notification to managers
					$this->CI->cfpslack_library->notify(
						sprintf(
							$this->CI->config->item('clockout_timesheet_closed_admin_no_note'),
							$this->CI->user_model->get_name($timesheet->user_id),
							$timesheet->workorder_id,
							$hours,
							$timesheet->id
						)
					);

				} else {

					// Notify manager
					$this->CI->cfpslack_library->notify(
						sprintf(
							$this->CI->config->item('clockout_timesheet_closed_admin'),
							$this->CI->user_model->get_name($timesheet->user_id),
							$timesheet->workorder_id,
							$hours,
							$timesheet->id
						)
					);

				}

			} catch (Exception $e) {

				log_message('debug', '---------------------> close_timesheet WO note check request failed' );

			}

			return true;
		}

		list($first_warning_sent_already, $minutesAgo) = $this->CI->clockout_notifications_model->exists(
			$timesheet->user_id,
			'CLOCKOUT_FIRST_WARNING',
			$specific_timesheet
		);

		if ($first_warning_sent_already) {

			// If it's been 5 minutes already
			if ($minutesAgo < 5) return false;

			// Mark sending
			$this->CI->clockout_notifications_model->create(
				$timesheet->user_id,
				'CLOCKOUT_FINAL_WARNING',
				$specific_timesheet
			);

			// Notify manager
			$this->CI->cfpslack_library->notify(
				sprintf(
					$this->CI->config->item('clockout_final_warning_admin'),
					$this->CI->user_model->get_name($timesheet->user_id),
					$timesheet->workorder_id,
					$hours,
					$timesheet->id
				)
			);

			// Notify employee
			$this->CI->sms_library->send(
				$timesheet->user_id,
				$this->CI->config->item('clockout_final_warning'),
				$timesheet->workorder_id
			);

			return true;
		}

		// So it's the first warning

		// Mark sending
		$this->CI->clockout_notifications_model->create(
			$timesheet->user_id,
			'CLOCKOUT_FIRST_WARNING',
			$specific_timesheet
		);

		// Manager not notified for the first warning
		$this->CI->cfpslack_library->notify(
			$this->CI->user_model->get_name($timesheet->user_id) .' has been reminded to clock out for '
			. $timesheet->workorder_id .' in the next 5 minutes'
		);

		// Notify employee
		$this->CI->sms_library->send(
			$timesheet->user_id,
			$this->CI->config->item('clockout_first_warning'),
			$timesheet->workorder_id
		);

		return true;
	}

	/**
	 * Clocks out given timesheet
	 *
	 * @param StdClass 	$timesheet  Timesheet
	 *
	 * @return void
	 */
	public function close_timesheet($timesheet)
	{
		$date = Carbon::now();

		$this->CI->timecard_model->timecard_update(
			$timesheet->id,
			$date->format('h'),
			$date->format('i'),
			$date->format('A'),
			$timesheet->user_id
		);
	}

	/**
	 * Check if the user has not taken a lunch break
	 *
	 * @param int     $user_id  			User Id
	 * @param Carbon  $user_request_time 	User's local time at the time of the request
	 *
	 * @return bool
	 */
	public function legible_for_lunch_prompt($user_id, $user_request_time)
	{
		if (!$this->CI->timecard_model->has_any_today($user_id)) return false;

		// if they have taken a lunch return false
		if ($this->CI->timecard_model->user_took_lunch($user_id)) return false;

		// Fetch the most recent timecard for the day
		$timecard = $this->CI->timecard_model->get_RecentTimecardByUser($user_id);

		$closed = Carbon::createFromFormat('Y-m-d H:i:s', $timecard->submit_time);

		// Determine if it's been at least 20 minutes
		return ( $closed->diffInMinutes(Carbon::now()) > 19);
	}

}
