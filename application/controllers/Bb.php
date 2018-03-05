<?php

/**
 * Bulletin Board Controller class file.
 *
 * @author 		Sam Takunda <sam.takunda@gmail.com>
 * @copyright 	(c) 2016, Commercial Fire Protection
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Bb extends MY_Controller {

	public function index()
	{
		$this->load->model('bulletinboard_model', '', TRUE);
		$this->load->model('file_model');

		$this->arViewData['categoryNames'] = [
			'1' => 'News',
			'2' => 'New Hires',
			'3' => 'Birthday',
			'4' => 'Event',
		];

		$this->arViewData['bulletins'] = $this->bulletinboard_model->all();
		$this->_layout('bb/index');
	}

	public function details($id)
	{
		$this->load->model('bulletinboard_model', '', TRUE);
		$this->load->model('bbphotos_model');

		$this->arViewData['categoryNames'] = [
			'1' => 'News',
			'2' => 'New Hires',
			'3' => 'Birthday',
			'4' => 'Event',
		];

		$this->arViewData['bb_id'] = $id;
		$this->arViewData['bulletins'] = $this->bulletinboard_model->recent($id);
		$this->arViewData['bulletin'] = $this->bulletinboard_model->find_or_fail($id);
		$this->arViewData['bulletin_photos'] = $this->bbphotos_model->bulletin($id);
		$this->_layout('bb/show');
	}

}
