<?PHP 
defined('BASEPATH') OR exit('No direct script access allowed');

use Carbon\Carbon;

class Overtime extends MY_Controller {

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
    	$this->admin_library->checkAccess('overtime');

    	if (!isset($this->session->tc_user_id) ){

			redirect('/admin/timecard');
    	}

        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }

        show_404();

    }

	public function index($iPageNo = 0)
	{
		//load model and pull timesheets pageno which = offset
		$this->load->model('timecard_model', '', TRUE);
		$this->arViewData['timesheets'] = $this->timecard_model->get_timesheets($this->session->tc_user_id, $iPageNo);

		//config from config/pagination
		$this->load->library('pagination');
		$this->load->library('clockout_library');
		$this->load->library('submission_library');
		$this->load->model('employee_positions_model');

		//how many timecards (entries) are we dealing with
		$iTimeCardCount = $this->timecard_model->get_timesheets_count($this->session->tc_user_id);

		//routing to handle timecard/index/#
		$pconfig['base_url'] = $this->config->item('base_url') . 'admin/overtime/';

		$pconfig['total_rows'] = $iTimeCardCount;
		$pconfig['per_page'] = 6;
		$pconfig['num_links'] = $iTimeCardCount/6;
		$this->pagination->initialize($pconfig);

		$job = $this->employee_positions_model->get_title_user($this->session->tc_user_id);
	
		$this->arViewData['pagination'] = $this->pagination->create_links();

		$this->arViewData['missed'] = $this->timecard_model->missed($this->session->tc_user_id);

		$this->arViewData['canTurnInTimecard'] = $this->submission_library->can_turn_in($this->session->tc_user_id);

		$this->arViewData['hoursWorkedThisPayperiod'] = $this->submission_library->hours_worked_this_payperiod(
			$this->session->tc_user_id
		);

		$this->arViewData['is_admin_timecard'] = TRUE;
		$this->arViewData['tc_user_name'] = $this->session->tc_cfpfullname;
		$this->arViewData['tc_user_job'] = $job;
		$this->_layout('admin/tc/timecard');
	}

	public function mark($id)
	{
		$this->load->model('timecard_model', '', TRUE);
		$timecard = $this->timecard_model->get_timecard($id);
		
		$this->arViewData['timecard'] = $timecard;

		if (!is_null($timecard->overtime_reason) ){
			
			$this->_layout('admin/tc/mark_fail');
		
		} else {

			$this->_layout('admin/tc/mark_timecard');
		}

	}

	public function mark_overtime($id)
	{
		$overtime_reason = $this->input->post('overtime_reason');
		$hours_limit = $this->input->post('hours_limit');

		if (is_null($overtime_reason) || $overtime_reason == '' ){
			$this->session->set_flashdata('msg', 'You did not submit an overtime reason');
			redirect('admin/overtime/mark/'.$id);
		}

		if (is_null($hours_limit) || $hours_limit == '' ){
			$this->session->set_flashdata('msg', 'You did not submit hours limit for timecard');
			redirect('admin/overtime/mark/'.$id);
		}

		$this->load->model('timecard_model', '', TRUE);
		$this->timecard_model->mark_as_overtime($id, $hours_limit, $overtime_reason);

		redirect('/admin/overtime');
	}

}
