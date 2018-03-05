<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fileupload_library {

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
        $this->CI->load->library('upload', $config);
        $this->upload = $this->CI->upload;
        $this->input = $this->CI->input;
        $this->CI->load->model('file_model', '', TRUE);
		$this->file_model = $this->CI->file_model;
    }

    public function add()
    {
		// add new images
		$timestamp = date("YmdHis");
		$random =  rand(100,900);
		$newName = "$timestamp-$random";

		$config['upload_path']          = FCPATH.'public/uploads/';
		$config['allowed_types']        = 'gif|jpg|png|mov|docs|pdf';
		$config['max_size']             = 512000;
		$config['max_width']            = 8000;
		$config['max_height']           = 6000;
		// change file name
		$config['file_name'] = $newName;
		$this->upload->initialize($config);
		// upload file
		$this->upload->do_upload('myFile');
		
		$posts = $this->input->post();
		$fileInfo = $this->upload->data();

		$this->file_model->add_file($posts, $fileInfo);
    }

}
