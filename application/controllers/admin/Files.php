<?php

/**
 * Files Controller class file.
 *
 * @author 		Sam Takunda <sam.takunda@gmail.com>
 * @author 		Alex Semhiles <semhiles@gmail.com>
 * @copyright 	(c) 2016, Commercial Fire Protection
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Files extends MY_Controller {

	private $categoryNames = [
		'handbooks' => 'Handbooks',
		'videos' => 'Videos',
		'guides' => 'Guides',
		'manuals' => 'Manuals',
		'other' => 'Other',
	];

	public function _remap($method, $params = [])
    {
    	// check if user has access to controller
    	$this->load->library('admin_library');
    	$this->admin_library->checkAccess('files');

        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }

        show_404();

    }

	public function index()
	{
		$this->load->model('file_model', '', TRUE);

		$this->arViewData['files'] = $this->file_model->recent();
		$this->arViewData['stats'] = $this->file_model->category_stats(TRUE);
		$this->_layout('admin/files/index');
	}

	public function category($id)
	{
		$this->load->model('file_model', '', TRUE);

		$this->arViewData['category'] = $this->file_model->real_id($id);
		$this->arViewData['files'] = $this->file_model->category($id, TRUE);
		$this->arViewData['files_count'] = $this->file_model->count_for_category($id, TRUE);
		$this->_layout('admin/files/category_' . $id);
	}

	public function gallery($id)
	{
		$this->load->model('file_model', '', TRUE);
		$this->load->model('photo_model');

		$galleryInformation = $this->file_model->find_or_fail($id);
		if ($galleryInformation->category !== 'Event Photos') return;

		$this->arViewData['galleryInformation'] = $galleryInformation;
		$this->arViewData['photos'] = $this->photo_model->gallery($id);

		$this->_layout('admin/files/gallery');
	}

	public function download($id)
	{
		$this->load->model('file_model', '', TRUE);
		$file = $this->file_model->find_or_fail($id);
		$this->file_model->click($id);

		$path = __DIR__ . '/../../public/uploads/' . $file->file_name;

		if (!file_exists($path)) return;

	    header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename="'.basename($path).'"');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    readfile($path);
	    exit;
	}

	/**
	 * Serve embedded content
	 *
	 * @param int $id File id
	 *
	 * @return void
	 */
	public function embed($id)
	{
		$this->load->model('file_model', '', TRUE);
		$file = $this->file_model->find_or_fail($id);
		$this->file_model->click($id);

		$this->load->view('files/embed', ['file' => $file]);
	}

	public function add()
	{	
		$category = $this->input->post('category');
		$posts = $this->input->post();
		$this->load->model('file_model', '', TRUE);

		if ($category == 'Event Photos') {

				$this->load->library('photoupload_library');

				$this->file_model->add_event_photos($posts);
				$this->photoupload_library->addEventPhotos($this->file_model->newId);
				$category = 'Photos';
		
		} elseif ($category == 'Video(online)' || $category == 'Training Videos(online)') {

				$this->file_model->add_video_url($posts);
				$category = 'Videos';

		} else {

				$this->load->library('fileupload_library');
				$this->fileupload_library->add();

		}

		redirect('/admin/files/category/'.strtolower($category) );
	}

	public function edit($id)
	{
		$posts = $this->input->post();

		$this->load->model('file_model', '', TRUE);
		$this->file_model->update($id, $posts);
		// upload photos and enter values in db
		$this->load->library('photoupload_library');
		$this->photoupload_library->addEventPhotos($id);
		
		$file = $this->file_model->find_or_fail($id);
		$category = strtolower($file->category);
		// redirect to file category
		if ($category == 'event photos'){
			redirect('/admin/files/gallery/'.$id.'/edit');

		} else {
			
			redirect('/admin/files/category/'.$category);
		}

	}

	public function delete($id)
	{
		$this->load->model('file_model', '', TRUE);
		$this->load->model('photo_model');
		$file = $this->file_model->find_or_fail($id);

		if ($file->category == 'Event Photos') {
		
			$photos = $this->photo_model->gallery($id);

			foreach ($photos as $photo) {
				unlink(FCPATH.'public/'.$photo->large_url);
				unlink(FCPATH.'public/'.$photo->small_url);
			}

			$this->photo_model->delete_for_file($id);
		
		} else {
			
			unlink(FCPATH.'public/uploads/'.$file->file_name);
		}
		$this->file_model->delete($id);
		redirect('/admin/files');
	}

}
