<?php

/**
 * Payroll Library
 *
 * @author Alex Semhiles <semhiles@gmail.com>
 * @copyright (c) 2016, CFP.
 * 
 */

defined('BASEPATH') OR exit('No direct script access allowed');

Class Admin_library {

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
        $this->output = $this->CI->output;
        $this->session = $this->CI->session;
        $this->CI->load->model('user_model', '', TRUE);
        $this->CI->load->model('admin_model');
        $this->user_model = $this->CI->user_model;
        $this->user_tiles = $this->CI->admin_model->user_tiles($this->session->user_id);
    }

    public function checkAccess($controller)
    {
        // check if the user is admin
        $this->isAdmin();

        //check if the user has access to the class
        $this->hasAccess($controller);
    }

    public function set_user_timecard($id)
    {
        $user = $this->user_model->get($id);

        $this->session->tc_user_id = $user->id;
        $this->session->tc_cfpfullname = $user->name_surname;
        $this->session->tc_user_job = $user->job;
    }

    public function isAdmin()
    {
        if (!$this->session->is_admin){

            $this->show403();
            exit();
        }
    }

    public function hasAccess($controller)
    {
        if (!in_array($controller, $this->user_tiles) ){

            $this->show403();
            exit();
        }
    }

    public function show403()
    {
        $this->output->set_status_header(403);
        return;
    }

}
