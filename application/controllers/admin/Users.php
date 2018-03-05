<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Carbon\Carbon;

class Users extends MY_Controller {

	public function _remap($method, $params = [])
    {
    	// check if user has access to controller
    	$this->load->library('admin_library');
    	$this->admin_library->checkAccess('users');

        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }

        show_404();

    }

	public function index($pageNo = 0)
	{
		$this->load->model('user_model', '', TRUE);

		$this->arViewData['users'] = $this->user_model->all();
		$this->_layout('admin/users/list');
	}

	public function add()
	{
		$posts = $this->input->post();
		$this->load->model('user_model');

		$this->user_model->add($posts);
		// redirect to users page where user is
		redirect('admin/users');
	}

	public function edit($id)
	{
		$posts = $this->input->post();
		$this->load->model('user_model');

		$this->user_model->update($id, $posts);
		// redirect to users page
		redirect('admin/users');		
	}

	public function delete($id)
	{
		$this->load->model('user_model');
		//$this->load->database();

		$this->user_model->delete($id);
		// redirect to users page
		redirect('admin/users');
	}

}
