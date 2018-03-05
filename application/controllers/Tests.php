<?php

/**
 * Tests Controller class file.
 *
 * @author 		Sam Takunda <sam.takunda@gmail.com>
 * @copyright 	(c) 2016, Commercial Fire Protection
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Tests extends MY_Controller {

	public function index()
	{
		$this->load->model('test_model', '', TRUE);

		$this->arViewData['progress'] = $this->test_model->progress($this->session->user_id);

		$this->_layout('tests/index');
	}

}
