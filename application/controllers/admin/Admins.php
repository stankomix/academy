<?php

/**
 * Bulletin Board Admin Controller class file.
 *
 * @author      Sam Takunda <sam.takunda@gmail.com>
 * @author      Alex Semhiles <semhiles@gmail.com>
 * @copyright   (c) 2016, Commercial Fire Protection
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Admins extends MY_Controller {

    public function _remap($method, $params = array())
    {
        // check if user has access to controller
        $this->load->library('admin_library');
        $this->admin_library->checkAccess('admins');

        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }

        show_404();

    }

    public function index()
    {
        $this->load->model('admin_model');
        $privileges = [
            'admins', 'timecards', 'overtime', 'users', 'bb', 'files', 'tests', 'payroll'
        ];

        $this->arViewData['privileges'] = $privileges;
        $this->arViewData['admins'] = $this->admin_model->all();
        $this->_layout('admin/users/admin_list');
    }

    public function add($id)
    {
        $this->load->model('admin_model');
        $admin = $this->admin_model->get($id);
        
        if (is_null($admin) ){
            $this->admin_model->add($id);
        
            $newId = $this->admin_model->newId;
            $newAdmin = $this->admin_model->get_id($newId);

            redirect('/admin/admins/'.$newAdmin->user_id.'/edit');

        } else {
            
            redirect('/admin/admins/'.$admin->user_id.'/edit');
        }
    }

    public function edit($id)
    {
        $fields = $this->input->post();
        $status = $this->input->post('status');
        unset($fields['status']);

        $this->load->model('admin_model');
        $this->admin_model->update($id, $fields, $status);
        redirect('/admin/admins');
    }

    public function delete($id)
    {
        $this->load->model('admin_model');
        $this->admin_model->delete($id);
        redirect('/admin/admins');
    }

}