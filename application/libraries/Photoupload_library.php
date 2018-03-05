<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Photoupload_library {

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
        $this->CI->load->model('bbphotos_model');
        $this->CI->load->model('photo_model');
        $this->upload = $this->CI->upload;
        $this->input = $this->CI->input;
        $this->bbphotos_model = $this->CI->bbphotos_model;
        $this->photo_model = $this->CI->photo_model;

    }

    public function addBbPhotos($bb_id)
    {
      // add new images
      $timestamp = date("YmdHis");
      $random =  rand(100,900);
      $newName = "$timestamp-$random";

      $config['upload_path']          = FCPATH.'public/photos/';
      $config['allowed_types']        = 'gif|jpg|png|mov|docs|pdf';
      $config['max_size']             = 512000;
      $config['max_width']            = 8000;
      $config['max_height']           = 6000;

      $pics = $this->input->post('pics');
      for ($i=1; $i < $pics+1; $i++) {

          // change file name
          $config['file_name'] = $newName.'-'.$i;
          $this->upload->initialize($config);
          
          // upload file and get the extension
          $this->upload->do_upload('pic'.$i);
          $fileExt = $this->upload->data('file_ext');
          
          // create thumbnail
          $this->makeSmaller($newName.'-'.$i, $fileExt);
          // ad image to db
          $this->bbphotos_model->addPhoto($bb_id, $newName.'-'.$i, $fileExt);
      }
    }

    public function addEventPhotos($file_id)
    {
      // add new images
      $timestamp = date("YmdHis");
      $random =  rand(100,900);
      $newName = "$timestamp-$random";

      $config['upload_path']          = FCPATH.'public/photos/';
      $config['allowed_types']        = 'gif|jpg|png|mov|docs|pdf';
      $config['max_size']             = 512000;
      $config['max_width']            = 8000;
      $config['max_height']           = 6000;

      $pics = $this->input->post('pics');
      for ($i=1; $i < $pics+1; $i++) {

          // change file name
          $config['file_name'] = $newName.'-'.$i;
          $this->upload->initialize($config);
          
          // upload file and get the extension
          $this->upload->do_upload('pic'.$i);
          $fileExt = $this->upload->data('file_ext');
          
          // create thumbnail
          $this->makeSmaller($newName.'-'.$i, $fileExt);
          // ad image to db
          $this->photo_model->addPhoto($file_id, $newName.'-'.$i, $fileExt);
      }
    }

    public function makeSmaller($image, $fileExt)
  {
        $uploadFolder = FCPATH.'public/photos/';
        $targetFile = $uploadFolder.$timestamp.'-'.$random.$fileExt;

        $imageExts = ['jpg', 'gif', 'png'];

        $this->load($uploadFolder.$image.$fileExt);
        $this->resizeToWidth(320);
       	$this->save($uploadFolder.$image.'-k'.$fileExt);

  }

    public function load($filename) {
    	
    	$image_info = getimagesize($filename);
    	$this->image_type = $image_info[2];
    	if( $this->image_type == IMAGETYPE_JPEG ) {
        	$this->image = imagecreatefromjpeg($filename);
    	} elseif( $this->image_type == IMAGETYPE_GIF ) {
        	$this->image = imagecreatefromgif($filename);
    	} elseif( $this->image_type == IMAGETYPE_PNG ) {
    		$this->image = imagecreatefrompng($filename);
    	}
   }

   public function save($filename, $image_type=IMAGETYPE_JPEG, $permissions=null) {
      
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,90);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image,$filename);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image,$filename);
      }   
      if( $permissions != null) {
         chmod($filename,$permissions);
      }

   }

   public function getWidth() {
   
      return imagesx($this->image);
   
   }
    public function getHeight() {
      return imagesy($this->image);
   }
    public function resizeToHeight($height) {
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
    public function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
    public function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100; 
      $this->resize($width,$height);
   }
    public function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;   
   }

}
