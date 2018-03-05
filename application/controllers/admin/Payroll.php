<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Carbon\Carbon;

class Payroll extends MY_Controller {

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
    public function _remap($method, $params = [])
    {
        // check if user has access to controller
        $this->load->library('admin_library');
        $this->admin_library->checkAccess('payroll');

        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }

        show_404();

    }

    public function index($pay_period_number = null)
    {
        $this->load->library('payroll_library');
        $this->load->model('timecard_submission_model', '', TRUE);

        $currentPayperiod = $this->timecard_submission_model->most_recent_pay_period();

        if (is_null($pay_period_number)) $pay_period_number = $currentPayperiod;

        $employees = $this->payroll_library->employees($pay_period_number);
        $this->arViewData['employees'] = $employees;

        if (count($employees) > 0){

            ## generate pagination links
            // prev button
            if ($pay_period_number != $currentPayperiod) {

                $prevPage = $pay_period_number + 1;
                $pagination .= "<a href='/admin/payroll/".$prevPage."'><</a>\n";
            }

            // page numbers
            for ($i = $currentPayperiod; $i > 0; $i--) {

                // link numbers
                if ($i == $pay_period_number) {
                    
                    $pagination .= "<strong>".$i."</strong>\n";

                } else {

                    $pagination .= "<a href='/admin/payroll/".$i."'>".$i."</a>\n";
                }

            }

            // next button
            if ($pay_period_number > 1) {

                $nextPage = $pay_period_number - 1;
                $pagination .= "<a href='/admin/payroll/".$nextPage."'>></a>\n";
            }

            ##
            $this->arViewData['hasPayrolls'] = TRUE;
            $this->arViewData['pay_period_number'] = $pay_period_number;
            $this->arViewData['pagination'] = $pagination;
        }

        $this->_layout('payroll/index');
    }

    public function export($pay_period_number = null)
	{
        $this->load->library('payroll_library');

        header("Content-type: text/plain");
        header("Content-Disposition: attachment; filename='pay_period_number_".$pay_period_number.".csv'");

        echo $this->payroll_library->export($pay_period_number);

        exit();
    }

    public function export_timecards($pay_period_number = null)
    {
        $this->load->library('payroll_library');

        header("Content-type: text/plain");
        header("Content-Disposition: attachment; filename='pay_period_number_".$pay_period_number.".timecards.csv'");

        echo $this->payroll_library->export_timecards($pay_period_number);

        exit();
    }
}
