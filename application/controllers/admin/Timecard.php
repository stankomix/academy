<?PHP 
defined('BASEPATH') OR exit('No direct script access allowed');

use Carbon\Carbon;

class Timecard extends MY_Controller {

	/**
	 * The minimum number of BlueFolder comments expected on
	 * a work order when a timecard is first created
	 *
	 * @var int
	 */
	const BF_COMMENTS_CREATE_TIMECARD = 1;

	/**
	 * The minimum number of BlueFolder comments expected on
	 * a work order when a timecard is clocked out.
	 *
	 * If you modify this, modify also in the Clockout library
	 *
	 * @var int
	 */
	const BF_COMMENTS_CLOSE_TIMECARD = 2;

	public function _remap($method, $params = [])
    {
		// check if user has access to controller
    	$this->load->library('admin_library');
    	$this->admin_library->checkAccess('timecards');

        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }

        show_404();

    }

	public function index($iPageNo = 0)
	{
		$this->load->model('user_model');
		$this->load->model('admin_model');
		$users = $this->user_model->all();
		$user_tiles = $this->admin_model->user_tiles($this->session->user_id);

		$this->arViewData['users'] = $this->user_model->all();
		$this->arViewData['admin_overtime'] = in_array('overtime', $user_tiles);
		$this->_layout('admin/tc/index');
	}

	//when a timecard is missed
	//there's 2 misses, one with start time, then end time if too much time elapsed
	//an employee could go home ill or other situation that would cause them to not update their timecard
	public function missed_timecard(){
		$this->load->model('timecard_model', '', TRUE);

		//get most recent timecard's date for user
		$recent_timecard = $this->timecard_model->get_RecentTimecardByUser($this->session->tc_user_id);

		$data = array();
		$this->load->helper('form');
		$js = 'class="missed_tc_reason"';

		$reasons = array(
			'Vacation' => 'Vacation'
			,'Holiday' => 'Holiday'
			,'Sick' => 'Sick'
			,'PaidTimeOff' => 'Paid Time Off'
			,'NoWorkAssigned' => 'No Work Assigned'
			,'Weekend' => 'Weekend'
		);

        $data['select_reason'] = form_dropdown('missed_tc_reason',$reasons,'1', $js);

        $data['select_reason_submit'] = form_submit(
        	'missed_tc_reason_button',
        	'Submit',
        	array(
        		'class' => 'rnk sae bbsae',
        		'onClick' => 'submitReason();'
        	)
        );

		$this->load->view('missed_timecard', $data);
	}

	//loads the add new time view
	public function add_timecard($missed_reason = NULL){
		$this->load->model('timecard_model', '', TRUE);
		$this->load->model('admin_model');

		$data = array(
			'start' => true,
			'missed_reason' => $missed_reason,
			'is_admin_timecard' => TRUE,
			'user_tiles' => $this->admin_model->user_tiles($this->session->user_id)
		);
		$this->load->view('admin/tc/add', $data);
	}

	//when editing a timecard, entering end time
	//and call update view
	public function update_timecard($timecard_id = NULL){
		if ( $timecard_id == NULL )
		{
			log_message('debug', '---------------------> update_timecard FALSE' );
			header('Content-Type: application/json');
			echo json_encode( array('error' => 'Random error occurred. Please contact Support.') );
			exit;
		}

		$this->load->model('timecard_model', '', TRUE);

		//lookup timecard date
		$timecard = $this->timecard_model->get_timecard($timecard_id);

		//make sure no more than 2 timecards per WO
		//and can not edit if end time submitted
		if ( $this->timecard_model->timecard_stoptime_exist( $timecard_id ) || 
			! $this->timecard_model->check_timecard( $timecard_id, $timecard->date, $this->session->tc_user_id ) )
		{
			log_message('debug', '---------------------> check_timecard FALSE' );
			$this->notify_user('Work order can not be edited.');
			exit;
		}

		//if user is attempting to update end time and more than 8 hours, needs manager approval
		//if user is adding new WO time for same date and more than 1 hour between
		//if user clocks out, and does not clock in after 1 hour - we need ALERT/NOTIFICATION



		if (Carbon::createFromFormat('Y-m-d H:i:s', $timecard->submit_time)->lt(Carbon::now()->subHours(8))) {
			log_message('debug', '---------------------> update, timecard date is over 18 hours old' );
			$data = array('error' => 'Date can not be in the past. Manager approval required to update timecard over 8 hours.');
			$this->load->view('error_date', $data);
			return true;
		}

		$workorder_date = strtotime($timecard->date);
		$data = array(
			'start' => false
			,'wo_id' => $timecard->workorder_id
			,'date' => $timecard->date
			,'tc_month' => date('F',$workorder_date)
			,'tc_date' => date('d', $workorder_date)
			,'tc_year' => date('Y', $workorder_date)
			,'tc_start_hour' => $timecard->start_hour
			,'tc_start_min' => $timecard->start_min
			,'tc_start_pmam' => $timecard->start_pmam
			,'tcid' => $timecard_id
			,'is_admin_timecard' => TRUE
		);

		$this->load->view('update_timecard', $data);
		return true;
	}

/****************************
/****************************
/*******these methods update model
/****************************
/****************************/

// when can a user enter time
// not just for service techs
// if they work late, approved for overtime
// they'd have to either add a 3rd WO with the time stamps
// 
// what would be the case for late warehouse work or walks?
// alerts via email/slack. sms for techs to their cell?

	/**
	 * Construct a Carbon representation of the user's local time
	 * saved in the timecard time fields
	 *
	 * @return Carbon
	 */
	private function user_local_request_time()
	{
		$formatted = sprintf(
			'%s-%s-%s %s:%s %s',
			date('Y', $_SERVER['REQUEST_TIME']),
			date('m', $_SERVER['REQUEST_TIME']),
			date('d', $_SERVER['REQUEST_TIME']),
			$this->input->post('timecard_hour'),
			$this->input->post('timecard_min'),
			$this->input->post('timecard_pmam')
		);

		return Carbon::createFromFormat('Y-m-d h:i A', $formatted);
	}

	//create timecard (inserts) - ajax type method
	public function create_timecard()
	{	
		// set vars
		$date = $this->input->post('date');
		$stop_hour = $this->input->post('stop_hour');
		$stop_min = $this->input->post('stop_hour');
		$submit_time = $date.' '.$stop_hour.':'.$stop_min.date(':s');

		$fields = [
			'workorder_id'		=> $this->input->post('workorder_id'),
			'user_id'			=> $this->input->post('user_id'),
			'date'				=> $date,
			'start_hour'		=> $this->input->post('start_hour'),
			'start_min'			=> $this->input->post('start_min'),
			'start_pmam'		=> $this->input->post('start_pmam'),
			'stop_hour'			=> $stop_hour,
			'stop_min' 			=> $stop_min,
			'stop_pmam' 		=> $this->input->post('stop_pmam'),
			'submit_time' 		=> $submit_time
		];

		$overtime = $this->input->post('overtime');

		if($overtime){
			$overtime_reason = $this->input->post('overtime_reason');
			$hours_limit = $this->input->post('hours_limit');
		} else {
			$overtime_reason = null;
			$hours_limit = null;
		}

		$this->load->model('timecard_request_model', '', TRUE);

		$this->timecard_request_model->create(
			$this->input->post('workorder_id'),
			$this->input->post('user_id'),
			$date,
			$this->input->post('start_hour'),
			$this->input->post('start_min'),
			$this->input->post('start_pmam'),
			$stop_hour,
			$stop_min,
			$this->input->post('stop_pmam'),
			$submit_time,
			$overtime_reason,
			$hours_limit
		);
	}

	//save the update to timecard
	public function save_update_timecard()
	{
		$this->load->model('timecard_model', '', TRUE);
		$user_request_time = $this->user_local_request_time();

		$timecard = $this->timecard_model->get_timecard($this->input->post('tcid'));

		if ( ! $timecard ){
			log_message('debug', '---------------------> save_update_timecard FALSE' );

			$this->json_response(['error' => 'Error no timecard found']);
		}

		$this->load->library('cfpslack_library');

		//Check if a note has been made for this WO
		try {

			$hasNotes = $this->cfpslack_library->check_wo_notes(
				$timecard->workorder_id,
				self::BF_COMMENTS_CLOSE_TIMECARD
			);

			if ($hasNotes) {

				//call update timesheets table
				$this->timecard_model->timecard_update(
					$timecard->id,
					$user_request_time->format('h'),
					$user_request_time->format('i'),
					$user_request_time->format('A'),
					$this->session->tc_user_id
				);

				return;
			}

			$bluefolderUrl = 'https://cfp.bluefolder.com/classic/service/sr.aspx?srid=' . $timecard->workorder_id;
			$error = 'You must update your Blue Folder <a target="_blank" href="'.$bluefolderUrl.'">Work Order</a>';
			$error .= ' and leave a note before you clock out.';

			$this->json_response([ 'error' => $error ]);


		} catch (Exception $e) {

			log_message('debug', '---------------------> save_update_timecard WO note check request failed' );
			$this->json_response([
				'error' => 'Request failed. Please try again, and contact support if the challenge persists.'
			]);

		}
	}

	/**
	 * Creates a request for overtime
	 * Code is identical to create_timecard()'s
	 *
	 * @return void
	 */
	public function create_overtime_request()
	{
		$this->load->library('overtime_library');
		$this->load->model('timecard_model', '', TRUE);
		$this->load->model('overtime_model', '', TRUE);

		$user_request_time = $this->user_local_request_time();

		//assemble time
		$timecard_date = date('Y', $_SERVER['REQUEST_TIME'])
				.'-'. date('m', $_SERVER['REQUEST_TIME'])
				.'-'. date('d', $_SERVER['REQUEST_TIME']);

		//this just helps ensure the date is accurate, even though should never be touched by user
		//and can probably be removed
		$this->load->helper('date');
		if ( ! validateDate($timecard_date, 'Y-m-d') )
		{
			$this->json_error_response('Date is invalid. Please contact support');
		}

		//Check if we aleady haven't submitted a request for this user and workorder today
		$submitted = $this->overtime_model->requested_already(
			$this->session->tc_user_id,
			$this->input->post('workorder_id'),
			$timecard_date
		);

		if ($submitted) {
			$this->json_error_response('You have already submitted an overtime request for this work order');
		}

		//want to include Username (so manager knows who's requesting without having to click the WO link)
		$requestSent = $this->overtime_library->createRequest(
			$this->session->tc_user_id,
			$this->input->post('workorder_id'),
			$user_request_time->format('h'),
			$user_request_time->format('i'),
			$user_request_time->format('A'),
			$timecard_date,
			$this->session->tc_cfpfullname,
			$this->input->post('overtime_reason')
		);

		if (!$requestSent) {
			$this->json_error_response('There was an error submitting your request. Please try again');
		}
	}

	public function create_overtime_card()
	{
		$this->load->model('timecard_model', '', TRUE);

		//assemble time
		$user_request_time = $this->user_local_request_time();

		$timecard_date = date('Y', $_SERVER['REQUEST_TIME'])
				.'-'. date('m', $_SERVER['REQUEST_TIME'])
				.'-'. date('d', $_SERVER['REQUEST_TIME']);
		//warning, this is creating data in the db without much security or constraint.
		$this->timecard_model->timecard_create(
			$this->input->post('workorder_id'),
			$user_request_time->format('h'),
			$user_request_time->format('i'),
			$user_request_time->format('A'),
			$timecard_date,
			$this->session->tc_user_id,
			$this->input->post('overtime_reason'),
			4
		);
		
	}

	/**
	 * Returns the submission form
	 *
	 * @return void
	 */
	public function submission_form()
	{
		$this->load->library('submission_library');
		$this->load->model('timecard_submission_model', '', TRUE);

		$this->load->view('timecard_submission', array('is_admin_timecard' => TRUE));
	}

	/**
	 * POST handler for timecard submissions
	 *
	 * @return void
	 */
	public function turnin()
	{
		$this->load->library('submission_library');
		$this->load->library('cfpslack_library');
		$this->load->model('timecard_model', '', TRUE);
		$this->load->model('timecard_submission_model', '', TRUE);
		$this->load->model('user_model', '', TRUE);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('signature', 'Signature', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$this->output->set_status_header(422, 'Please sign with your full name');
			return;
		}
	
		$this->submission_library->handle_turn_in(
			$this->session->tc_user_id,
			$this->input->post('signature')
		);
	}

	/**
	 * Posts reason why employee didn't have a time card entry 'yesterday' to Slack
	 *
	 * @return void
	 */
	public function submit_reason_missed()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->form_validation->set_rules('reason', 'Reason', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$this->output->set_status_header(422, form_error('reason'));
			return;
		}

		$this->load->library('cfpslack_library');
		$this->load->model('user_model', '', TRUE);
		$name = $this->user_model->get_name($this->session->tc_user_id);

		$message = $name . ' did not submit a timecard yesterday because: ' . $this->input->post('reason');

		// @todo Ask if user should retry if this fails
		$this->cfpslack_library->post('/cfpslack/notify', [
		 	'message' => $message
		]);
	}

	/**
	 * Closes any open timecards for the user
	 *
	 * @return void
	 */
	public function close_open_timecard()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->form_validation->set_rules('workorder_id', 'Work Order', 'required|integer');
		$this->form_validation->set_rules('took_lunch_break', 'Lunch break', 'required|in_list[true,false]');
		$this->form_validation->set_rules('timecard_hour', 'Stop hour', 'required');
		$this->form_validation->set_rules('timecard_min', 'Stop minute', 'required');
		$this->form_validation->set_rules('timecard_pmam', 'Stop AM/PM', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$this->output->set_status_header(422, 'Action failed. Please try again.');
			return;
		}

		$this->load->model('timecard_model', '', TRUE);
		$this->load->library('cfpslack_library');

		$user_request_time = $this->user_local_request_time();

		// Fetch the open timecard
		$open_timecard = $this->timecard_model->get_open_timecard($this->session->tc_user_id);

		if (!$open_timecard) return;

		//Check if a note has been made for this WO
		try {

			$hasNotes = $this->cfpslack_library->check_wo_notes(
				$open_timecard->workorder_id,
				self::BF_COMMENTS_CLOSE_TIMECARD
			);


			if (!$hasNotes) {

				$bluefolderUrl = 'https://cfp.bluefolder.com/classic/service/sr.aspx?srid=' . $open_timecard->workorder_id;
				$error = 'You must update your Blue Folder <a target="_blank" href="'.$bluefolderUrl.'">Work Order</a>';
				$error .= ' and leave a note before you can clock out.';

				$this->json_error_response($error);

			}

		} catch (Exception $e) {

			log_message('debug', '---------------------> save_update_timecard WO note check request failed' );
			$this->json_error_response(
				'Request failed. Please try again, and contact support if the challenge persists.'
			);

		}

		$took_lunch_break = ($this->input->post('took_lunch_break') === 'true');

		$started = Carbon::createFromFormat(
			'Y-m-d h:i A',
			$open_timecard->date . ' ' .
			$open_timecard->start_hour . ':' .
			$open_timecard->start_min . ' ' .
			$open_timecard->start_pmam
		);

		$stopTime = Carbon::createFromFormat(
			'Y-m-d h:i A',
			$open_timecard->date . ' ' .
			$user_request_time->format('h') . ':' .
			$user_request_time->format('i') . ' ' .
			$user_request_time->format('A')
		);

		if ($started->diffInMinutes($stopTime) <= 30) $took_lunch_break = false;

		if ($took_lunch_break) {
			$lunch = $stopTime->copy()->subMinutes(30);
			$stopTime->subMinutes(30);
		}

		if ($took_lunch_break) {

			// Create a timecard for the lunch time taken
			$this->timecard_model->add_lunch_time(
				$open_timecard->user_id,
				$open_timecard->workorder_id,
				$open_timecard->date,
				$lunch->format('h'),
				$lunch->format('i'),
				$lunch->format('A'),
				$user_request_time->format('h'),
				$user_request_time->format('i'),
				$user_request_time->format('A')
			);

		}

		// Update timecard
		$this->timecard_model->timecard_update(
			$open_timecard->id,
			$stopTime->format('h'),
			$stopTime->format('i'),
			$stopTime->format('A'),
			$this->session->tc_user_id
		);
	}

	/**
	 * Force submit timecards on a specific day
	 * Code based on submission_library::handle_turn_in()
	 *
	 * @return void
	 */
	public function force_submit_timecards()
	{return;
		$this->load->model('user_model', '', TRUE);
		$this->load->library('submission_library');
		$this->load->model('timecard_model');
		$this->load->model('timecard_submission_model');

		// Set below to be the "Monday" when these submissions are supposed to have been made
        $submission_date = Carbon::create(2017, 1, 2);

        $submission_period = $this->submission_library->submission_period($submission_date);

        $start = $submission_period->start->toDateString();
        $end = $submission_period->end->toDateString();

	    $pay_period_number = $this->submission_library->pay_period_number($submission_date);

	    // Fetch users

		$db_result = $this->db->get_where('users', ['status' => 1]);

        foreach ($db_result->result() as $user) {

	        //Find all the completed but not turned-in timecards for this period
	        $timecardIds = $this->timecard_model->unsubmittedForPeriod(
	            $user->id,
	            $start,
	            $end
	        );

	        if (!$timecardIds) continue;

	        //Create timecard_submission entry
	        $submissionId = $this->timecard_submission_model->create($user->id, $user->name_surname, $pay_period_number);

	        //Update all the timecards
	        $this->timecard_model->set_submission_id($submissionId, $timecardIds);

        }
	}


}
