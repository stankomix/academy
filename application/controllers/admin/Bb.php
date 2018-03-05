<?php

/**
 * Bulletin Board Admin Controller class file.
 *
 * @author 		Sam Takunda <sam.takunda@gmail.com>
 * @author 		Alex Semhiles <semhiles@gmail.com>
 * @copyright 	(c) 2016, Commercial Fire Protection
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Bb extends MY_Controller {

	public function _remap($method, $params = array())
    {
    	// check if user has access to controller
    	$this->load->library('admin_library');
    	$this->admin_library->checkAccess('bb');

        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }

        show_404();

    }

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

		$this->arViewData['bulletins'] = $this->bulletinboard_model->all(TRUE);
		$this->_layout('admin/bb/index');
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
		$this->arViewData['bulletin'] = $this->bulletinboard_model->find_or_fail($id, TRUE);
		$this->arViewData['bulletin_photos'] = $this->bbphotos_model->bulletin($id);
		$this->_layout('admin/bb/show');
	}

	public function add()
	{
		$posts = $this->input->post();

		$this->load->model('bulletinboard_model', '', TRUE);
		$this->bulletinboard_model->add_news($posts);
		// get the new bulletin Id
		$newBulletin = $this->bulletinboard_model->newId;
		// upload photos and enter values in db
		$this->load->library('photoupload_library');
		$this->photoupload_library->addBbPhotos($newBulletin);
		// redirect to bulletin
		redirect('admin/bb/details/'.$newBulletin);
	}

	public function edit($id)
	{
		$posts = $this->input->post();

		$this->load->model('bulletinboard_model', '', TRUE);
		$this->bulletinboard_model->update($id, $posts);
		// upload photos and enter values in db
		$this->load->library('photoupload_library');
		$this->photoupload_library->addBbPhotos($id);
		// redirect to bulletin
		redirect('admin/bb/details/'.$id);
	}

	public function delete($id)
	{
		$this->load->model('bulletinboard_model', '', TRUE);
		$this->load->model('bbphotos_model');
		
		$photos = $this->bbphotos_model->bulletin($id);

		foreach ($photos as $photo) {
			unlink(FCPATH.'public/'.$photo->large_url);
			unlink(FCPATH.'public/'.$photo->small_url);
		}
		$this->bulletinboard_model->delete($id);
		$this->bbphotos_model->deleteBulletin($id);
		redirect('admin/bb');
	}

}
