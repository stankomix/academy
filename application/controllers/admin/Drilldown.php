<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Carbon\Carbon;

class Drilldown extends MY_Controller {

    /**
     * We'll use this to authenticate calls
     *
     * @see http://www.codeigniter.com/userguide3/general/controllers.html#remapping-method-calls
     *
     * @param string    $method  Method name
     * @param string[]  $params  Extra URL segements
     *
     * @return void
     */
    public function _remap($method, $params = array())
    {
        if (!$this->session->is_admin) {
            //$this->output->set_status_header(403);
            //return;
            show_403();
        }

        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }

        show_404();
    }

    public function index()
    {
        header('Location: /admin/drilldown/all');
    }

    public function all($page_number = 0)
    {
        $this->load->model('user_model', '', TRUE);
		$this->load->library('pagination');

        $sort = $this->input->get('sort') ?: 'name_surname';
        $ascending = ($this->input->get('direction') === 'descending') ? false: true;

		$this->arViewData['employees'] = $this->user_model->all_active($page_number, $sort, $ascending);
		$number_of_employees = $this->user_model->all_active_count();

		$this->pagination->initialize([
			'base_url' => $this->config->item('base_url') . 'admin/drilldown/all/',
			'reuse_query_string' => TRUE,
			'uri_segment' => 4,
			'total_rows' => $number_of_employees,
			'per_page' => 6,
			'num_links' => $number_of_employees/6,
		]);

        $this->arViewData['pagination'] = $this->pagination->create_links();
        $this->arViewData['ascending'] = $ascending;
		$this->arViewData['sort'] = $sort;

        $this->_layout('drilldown/index');
    }

    public function timecards($user, $page_number = 0)
    {
        $this->load->model('user_model', '', TRUE);
		$this->load->model('timecard_submission_model');
		$this->load->model('timecard_model');
		$this->load->library('pagination');
		$this->load->library('clockout_library');
		$this->load->library('submission_library');
		$this->load->helper('time_helper');

        $sort = $this->input->get('sort') ?: 'submit_time';
        $ascending = ($this->input->get('direction') === 'descending') ? false: true;

		$this->arViewData['hoursWorkedThisPayperiod'] = $this->submission_library->hours_worked_this_payperiod(
			$user
		);

        $this->arViewData['user'] = $user;
        $this->arViewData['employee'] = $this->user_model->get_name($user);

		$submissionIds = $this->timecard_submission_model->for_user($user);

        if ($submissionIds) {

    		$this->arViewData['timesheets'] = $this->timecard_model->for_submission(
                $submissionIds,
                $user,
                $page_number,
                $sort,
                $ascending
            );

    		$number_of_timecards = $this->timecard_model->count_for_submission($submissionIds, $user);

        } else {
            $this->arViewData['timesheets'] = [];
            $number_of_timecards = 0;
        }

        $base_url = $this->config->item('base_url') . 'admin/drilldown/timecards/' . $user . '/';

		$this->pagination->initialize([
			'base_url' => $base_url,
			'reuse_query_string' => TRUE,
			'uri_segment' => 5,
			'total_rows' => $number_of_timecards,
			'per_page' => 6,
			'num_links' => $number_of_timecards/6,
		]);

		$this->arViewData['pagination'] = $this->pagination->create_links();
        $this->arViewData['base_url'] = $base_url;
        $this->arViewData['ascending'] = $ascending;
        $this->arViewData['sort'] = $sort;

        $this->_layout('drilldown/timesheet');
    }

}
