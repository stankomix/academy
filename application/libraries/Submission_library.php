<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Carbon\Carbon;

Class Submission_library {

    /**
     * The days on which we have holidays
     *
     * @var int[]int[]
     */
    private $holidays = [
        // Month is the key. Then the values will just be the days in that month where there's a holiday
        1 => [1],
        2 => [],
        3 => [],
        4 => [],
        5 => [29],
        6 => [],
        7 => [4],
        8 => [],
        9 => [],
        10 => [],
        11 => [23,24],
        12 => [22,25],
    ];

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
        $this->CI->load->model('user_model', '', TRUE);
        $this->CI->load->model('timecard_model');
        $this->CI->load->model('timecard_submission_model');
    }

    /**
     * Check if $date is a holiday
     *
     * @param Carbon $date Date to check
     *
     * @return Carbon
     */
    private function is_holiday($date)
    {
        $holidays = $this->holidays[$date->month];

        if (!$holidays) return false;;

        sort($holidays);
        $holidays = array_reverse($holidays);

        return in_array($date->day, $holidays);
    }

    /**
     * Calculate the submission date
     *
     * @param Carbon $fromDate  (Optional) Calculate submission date from the specified date
     *
     * @return Carbon
     */
    public function submission_date($fromDate = null)
    {
        $today = $fromDate ?: Carbon::now();

        // Submissions are every other Monday from the first Monday of the current year
	$monday = date("Y-m-d", strtotime('first monday of January '. date("Y") ));
        $marker = Carbon::createfromformat('Y-m-d', $monday);
        Carbon::setTestNow($marker);

        // This comment is unprofessional given the gravity of this function, but: Infinite loop evil laugh >:D Muhahaha
        while (true) {

            if ($marker->gte($today)) {
                Carbon::setTestNow();

                // Deadline is 2pm
                $marker->hour = 14;
                $marker->minute = 0;
                $marker->second = 0;

                return $this->adjustDateToBeBeforeHolidays($marker);
            }

            // Add two more weeks
            $marker->addWeeks(2);
        }
    }

    /**
     * Given a submission date, it will return the start and end day for
     * timecards that should be included in the submission
     *
     * @param Carbon $date Submission date
     *
     * @return StdClass
     */
    public function submission_period($date)
    {
        // Go back two weeks
        $threeWeeksAgo = $date->copy()->subWeeks(3);

        // Now find what the next submission date was at that point
        $start = $this->submission_date($threeWeeksAgo);

        return (object)[
            'start' => $start,
            'end' => $date
        ];
    }

    /**
     * Adjusts given date to be before the holiday days (if necessary)
     *
     * @param Carbon $date Date to be checked and adjusted
     *
     * @return Carbon
     */
    private function adjustDateToBeBeforeHolidays($date)
    {
        $holidays = $this->holidays[$date->month];

        if (!$holidays) return $date;

        if (!in_array($date->day, $holidays)) return $date;

        // We get here, it's a holiday
        $date->subDay();

        if ($date->isWeekend()) $date->subDay();

        // Check again. Maybe it's Sunday shifted to Saturday
        if ($date->isWeekend()) $date->subDay();

        // Make another sweep. Maybe the new date is a holiday too
        return $this->adjustDateToBeBeforeHolidays($date);
    }

    /**
     * Determines whether or not timecards may be turned-in today
     *
     * @return bool
     */
    public function can_submit_today()
    {
        // For testing, you can uncomment below to set what day today is globally
        //Carbon::setTestNow(Carbon::create(2018, 1, 15, 10, 18, 00));

        $today = Carbon::now();

        $submission_date = $this->submission_date();

        if ($today->isSameDay($submission_date)) {
            // Check if it's not past the deadline
            //return $today->lte($submission_date);
        }

        // Return quick if the actual submission date is not on a Monday
//        if (!$submission_date->isMonday()) return false;

        // If today is the Friday before a Monday submission date, allow (from 6pm)
        Carbon::setTestNow($submission_date);
        $friday_before_submission = new Carbon('last friday');
        $friday_before_submission->hour = 18;
        $friday_before_submission->minute = 0;
        $friday_before_submission->second = 0;
        Carbon::setTestNow();


        // Check if now is between Friday 6pm and Monday 2pm
        return $today->between($friday_before_submission, $submission_date);
    }

    /**
     * Determines if the user hasn't already/can perform a turn in today
     *
     * @param int $user User Id
     *
     * @return bool
     */
    public function can_turn_in($user)
    {
        if (!$this->can_submit_today()) return false;

        $submission_date = $this->submission_date();


        $submission_period = $this->submission_period($submission_date);

        $start = $submission_period->start->toDateString();
        $end = $submission_period->end->toDateString();

	//make sure use has not submitted
        if ($this->CI->timecard_model->unsubmittedForPeriod($user, $start, $end))
		return true;
		//return false;

        // Maybe there are no timecards to turn-in
        if ($this->CI->timecard_model->unsubmittedForPeriod($user, $start, $end))
		return true;

        return false;
    }

    /**
     * Turns-in all the timecards for the user
     *
     * @param int     $user       User Id
     * @param string  $signature  User's signature
     *
     * @return void
     */
    public function handle_turn_in($user, $signature) 
    {
        if (!$this->can_turn_in($user)) return;

        $submission_date = $this->submission_date();

        $submission_period = $this->submission_period($submission_date);

        $start = $submission_period->start->toDateString();
        $end = $submission_period->end->toDateString();

        //Find all the completed but not turned-in timecards for this period
        $timecardIds = $this->CI->timecard_model->unsubmittedForPeriod(
            $user,
            $start,
            $end
        );

        if (!$timecardIds) return;

/*
        // Check if the name entered matches that in the database
        $expectedSignature = $this->CI->user_model->get_name($user);

        if ($signature !== $expectedSignature) {

            $message = $this->CI->config->item('wrong_turn_in_signature');

            $message = sprintf($message, $expectedSignature, $signature);

            $this->CI->cfpslack_library->notify($message);
        }
*/

        $pay_period_number = $this->pay_period_number($submission_date);

        //Create timecard_submission entry
        $submissionId = $this->CI->timecard_submission_model->create($user, $signature, $pay_period_number);

        //Update all the timecards
        $this->CI->timecard_model->set_submission_id($submissionId, $timecardIds);
    }

    /**
     * Get hours worked this pay period
     *
     * @param int $user  User Id
     *
     * @return float
     */
    public function hours_worked_this_payperiod($user)
    {
        $submission_period = $this->submission_period($this->submission_date());

        $start = $submission_period->start->toDateString();
        $end = Carbon::now()->toDateString();

        $timesheetIds = $this->CI->timecard_model->unsubmittedForPeriod($user, $start, $end);

        if (!$timesheetIds) return 0;

        $timesheets = $this->CI->timecard_model->find($timesheetIds);

        $timesheets = array_filter($timesheets, function ($timesheet) {
            return !$timesheet->lunch_time;
        });

        return $this->CI->clockout_library->hours_in_closed_timesheets($timesheets);
    }


	//check for 3 fridays
	public function countFridays($d)
	{
		$startDate = Carbon::parse($date)->next(Carbon::FRIDAY); // Get the first friday.
		$endDate = new Carbon('last day of this month');
					log_message('debug', '---------------------> startDate ' . print_r($startDate, true) );
					log_message('debug', '---------------------> endDate ' . print_r($endDate, true) );
		for ($date = $startDate; $date->lte($endDate); $date->addWeek()) {
		    $fridays[] = $date->format('Y-m-d');
		}
		return count($fridays);
	}



    /**
     * Get the pay dates for the month $date's in
     *
     * @param Carbon  $d
     *
     * @return StdClass
     */
    public function pay_dates_for_month($d)
    {
        $date = $d->copy();
        $date->day(1);

        $first = null;
        $second = null;
	$third = null;

        if ($date->isFriday()) {
            $first = $date->copy();
        } else {
            Carbon::setTestNow($date);
            $first = new Carbon('next friday');
            Carbon::setTestNow();
        }

        $second = $first->copy()->addWeeks(2);

	//if 3 fridays, get that date
	if ( $this->countFridays($d) == 3 )
		$third = $first-copy()->addWeeks(4);

        return (object)[
            'first' => $first,
            'second' => $second,
            'third' => $third,
        ];
    }

    /**
     * Determine Pay Period Number for the given date (assumed to be a submission date)
     *
     * @param Carbon  $date
     *
     * @return Carbon
     */
    public function pay_period_number($date)
    {
        // https://fireprotected.slack.com/archives/engineering/p1481217169000234
        // Every month has 2 pay periods. Going to mark them by pay date: i.e the first and third friday
	//june2018 will have 3: 1,15,29

        $pay_period_number = 0;

	//year can not be hard coded, why is this here?
        if ($date->year < 2018) return 1;

        // Get the Pay Dates for current month

        $paydates = $this->pay_dates_for_month($date);


        // See which one is after $date

        if ($paydates->first->gte($date)) {

            // If it's in the same week, then it's not the one
            $check = $date->copy()->startOfWeek();
            Carbon::setTestNow($check);
            $friday = new Carbon('next friday');
            Carbon::setTestNow();

            if (!$friday->isSameDay($paydates->first)) {

                //use this one
                $pay_period_number = $paydates->first->month * 2;
                return $pay_period_number - 1;

            }
        }

	//we are not in first period, did we pass up 2nd and there is a 3rd?
        if ($paydates->second->gte($date)) {

			log_message('debug', '---------------------> paydates ' . print_r($paydates, true) );

//what is this code doing?
//the paydate is already a friday based on the code defining first/second/(third)
/*
            // If it's in the same week, then it's not the one
            $check = $date->copy()->startOfWeek();
            Carbon::setTestNow($check);
            $friday = new Carbon('next friday');
            Carbon::setTestNow();

			log_message('debug', '---------------------> paydates check' . print_r($check, true) );
			log_message('debug', '---------------------> paydates next friday' . print_r($friday, true) );
            if ($friday->isSameDay($paydates->second)) {

                //use this one
                $pay_period_number = $paydates->first->month * 2;
                return $pay_period_number;
            }
*/
                $pay_period_number = $paydates->first->month * 2;
                return $pay_period_number;
        }

/*
	//rare, we have a 3rd
        if ( $paydates->third && $paydates->third->gte($date)) {

            // If it's in the same week, then it's not the one
            $check = $date->copy()->startOfWeek();
            Carbon::setTestNow($check);
            $friday = new Carbon('next friday');
            Carbon::setTestNow();

            if (!$friday->isSameDay($paydates->first)) {

                //use this one
                $pay_period_number = $paydates->first->month * 2;
                return $pay_period_number - 1;

            }
        }
*/

        // if after them both, then use the next month's first pay date
        $paydates->second->addMonth();

        $nextMonthPaydates = $this->pay_dates_for_month($paydates->second);
        $pay_period_number = $nextMonthPaydates->first->month * 2;
					log_message('debug', '---------------------> pay_period 3 or next month ' . print_r($pay_period_number, true) );
        return $pay_period_number - 1;
    }

}
