<?php

/**
 * Payroll Library
 *
 * @author Sam Takunda <sam.takunda@gmail.com>
 * @copyright (c) 2016, CFP.
 * 
 */

defined('BASEPATH') OR exit('No direct script access allowed');

use Carbon\Carbon;

Class Payroll_library {

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

        $this->CI->load->model('timecard_model', '', TRUE);
        $this->CI->load->model('timecard_submission_model');
        $this->CI->load->model('user_model');

        $this->CI->load->library('submission_library');
        $this->CI->load->library('clockout_library');
    }

    /**
     * Get employees payroll for given pay period number
     *
     * @param int $pay_period  Pay Period Number
     *
     * @return StdClass[]
     */
    public function employees($pay_period)
    {
        if (is_null($pay_period)) {
            $pay_period = $this->CI->timecard_submission_model->most_recent_pay_period();
        }

        $employees = [];

        if (!$pay_period) return $employees;

        // Fetch all submissions for the pay period
	//per year
        $submissions = $this->CI->timecard_submission_model->for_period($pay_period);

        foreach ($submissions as $submission) {

            // Fetch timecards for the submission
            $timecards = $this->CI->timecard_model->for_submission($submission->id, $submission->user_id);

            $hours_worked = 0;
            $overtime_hours = 0;

            // Sum up the hours
            foreach ($timecards as $timecard) {

                if ($timecard->lunch_time) continue;

                $hours = $this->CI->clockout_library->hours_in_closed_timesheets($timecard);

                if ($timecard->overtime_reason) {
                    $overtime_hours += $hours;
                } else {
                    $hours_worked += $hours;
                }

            }

            if (!array_key_exists($submission->user_id, $employees)) {

                $employees[$submission->user_id] = (object)[
                    'user_id' => $submission->user_id,
                    'employee' => $this->CI->user_model->get_name($submission->user_id),
                    'hours_worked' => 0,
                    'overtime_hours' => 0,
                    'pay_period_number' => $pay_period,
                ];

            }

            $employees[$submission->user_id]->hours_worked += $hours_worked;
            $employees[$submission->user_id]->overtime_hours += $overtime_hours;

        }

        return $employees;
    }

    /**
     * CSV file contents for the payroll export of given pay period number
     *
     * @param int $pay_period_number  Pay Period Number
     *
     * @return string
     */
    public function export($pay_period_number)
    {
        $employees = $this->employees($pay_period_number);
        $template = "%s,%s,,%s,,,,,\n";
        $export = "";

        // Echo header
        $export .= "Clock,Name,Pay Code,Hours,Amount,Shift Code,Rate Code,Work Department,Override Rate\n";

        foreach ($employees as $employee) {
    
            $export .= sprintf(
                $template,
                $employee->user_id,
                $employee->employee,
                $employee->hours_worked
            );

        }

        return $export;
    }

    /**
     * Get CSV file contents for the timecards export for given pay period number
     *
     * @param int $pay_period_number  Pay Period Number
     *
     * @return string
     */
    public function export_timecards($pay_period_number)
    {
        if (is_null($pay_period_number)) {
            $pay_period_number = $this->CI->timecard_submission_model->most_recent_pay_period();
        }

        $export = '';
        $export .= "employee,work order,start time,end time,description,date\n";
        $template = "%s,%s,%s,%s,%s,%s\n";

        // Fetch all submissions for the pay period
        $submissions = $this->CI->timecard_submission_model->for_period($pay_period_number);

        foreach ($submissions as $submission) {

            // Fetch timecards for the submission
            $timecards = $this->CI->timecard_model->for_submission($submission->id, $submission->user_id);

            foreach ($timecards as $timecard) {

                $start = Carbon::createFromFormat(
                    'Y-m-d h:i A',
                    $timecard->date . ' ' . $timecard->start_hour . ':' .$timecard->start_min . ' ' . $timecard->start_pmam
                );

                $stop = Carbon::createFromFormat(
                    'Y-m-d h:i A',
                    $timecard->date . ' ' . $timecard->stop_hour . ':' .$timecard->stop_min . ' ' . $timecard->stop_pmam
                );

                $date = Carbon::createFromFormat(
                    'Y-m-d',
                    $timecard->date
                );

                $description = '';

                if ($timecard->driving_time) $description = 'driving';
                if ($timecard->lunch_time) $description = 'lunch';

                $export .= sprintf(
                    $template,
                    $this->CI->user_model->get_name($timecard->user_id),
                    $timecard->workorder_id,
                    $start->toTimeString(),
                    $stop->toTimeString(),
                    $description,
                    $date->format('m-d-Y')
                );

            }

        }

        return $export;
    }
}
