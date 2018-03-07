<?php


/**
 * Tests Controller class file.
 *
 * @author 		Zeeshan 
 * @copyright 	(c) 2018, Techopia
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Test_questions extends MY_Controller {

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

	public function index($id)
	{
		$test_id = $id;
		$this->load->model('test_questions_model', '', TRUE);

		
			$this->arViewData['tests'] = $this->test_questions_model->get($test_id);
			$this->arViewData['test_id'] = $test_id;
			$this->_layout('admin/add/test_questions');	
		
		
	}

	public function add($id)
	{
		$posts = $this->input->post();
		$posts["test_id"] = $id;
		$this->load->model('test_questions_model', '', TRUE);
		$this->test_questions_model->add($posts);
		$this->session->set_flashdata('message', 'Question added successfully');
		redirect('admin/questions/add/'.$id);
	}
	
	//Get the question row to edit
	public function update($id)
	{
		$posts = $this->input->post();

		$this->load->model('test_questions_model', '', TRUE);
		$this->test_questions_model->update($id, $posts);
		$this->session->set_flashdata('message', 'Question updated successfully');
		redirect('admin/questions/add/'.$posts['test_id']);
	}
	
	//Get The question row to edit
	public function edit($id){
		$questionRowid = $id;
		$this->load->model('test_questions_model', '', TRUE);
		
		if($this->test_questions_model->edit($questionRowid)){
			$this->arViewData['test'] = $this->test_questions_model->edit($questionRowid);
			$this->_layout('admin/edit/test_questions');
		}else{
			redirect($_SERVER['HTTP_REFERER']);
		}

	}
	

	public function remove($id)
	{
		$this->load->model('test_questions_model', '', TRUE);
		$this->test_questions_model->delete($id);
		$this->session->set_flashdata('message', 'Question removed successfully!');
		redirect($_SERVER['HTTP_REFERER']);
	}

}
