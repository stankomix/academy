<?php


/**
 * Tests Controller class file.
 *
 * @author 		Sam Takunda <sam.takunda@gmail.com>
 * @author 		Alex Semhiles <semhiles@gmail.com>
 * @copyright 	(c) 2016, Commercial Fire Protection
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Tests extends MY_Controller {

	public $newId;

	public function _remap($method, $params = [])
    {
		
		// check if user has access to controller
    	$this->load->library('admin_library');
    	$this->admin_library->checkAccess('tests');

        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }

        show_404();

    }

	public function index()
	{
		$this->load->model('test_model', '', TRUE);

		$this->arViewData['tests'] = $this->test_model->all();
		$this->_layout('admin/tests/list');
	}

	public function add()
	{
		$posts = $this->input->post();

		$this->load->model('test_model', '', TRUE);
		$this->test_model->add($posts);

		redirect('admin/tests/add');
	}
	

	public function edit($id)
	{
		$posts = $this->input->post();

		$this->load->model('test_model', '', TRUE);
		$this->test_model->update($id, $posts);

		redirect('admin/tests');
	}

	public function delete($id)
	{
		$this->load->model('test_model', '', TRUE);
		$this->test_model->delete($id);

		redirect('admin/tests');
	}

}
