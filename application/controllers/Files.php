<?php

/**
 * Files Controller class file.
 *
 * @author 		Sam Takunda <sam.takunda@gmail.com>
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

	public function index()
	{
		$this->load->model('file_model', '', TRUE);

		$this->arViewData['files'] = $this->file_model->recent();
		$this->arViewData['stats'] = $this->file_model->category_stats();
		$this->_layout('files/index');
	}

	public function category($id)
	{
		$this->load->model('file_model', '', TRUE);

		$this->arViewData['category'] = $this->file_model->real_id($id);
		$this->arViewData['files'] = $this->file_model->category($id);
		$this->arViewData['files_count'] = $this->file_model->count_for_category($id);
		$this->_layout('files/category_' . $id);
	}

	public function gallery($id)
	{
		$this->load->model('file_model', '', TRUE);
		$this->load->model('photo_model');

		$galleryInformation = $this->file_model->find_or_fail($id);
		if ($galleryInformation->category !== 'Event Photos') return;

		$this->arViewData['galleryInformation'] = $galleryInformation;
		$this->arViewData['photos'] = $this->photo_model->gallery($id);

		$this->_layout('files/gallery');
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

}
