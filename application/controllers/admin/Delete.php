<?PHP 
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete extends MY_Controller {

	public $image;
	public $image_type;

	public function bb_photo_delete($id)
	{
		// check if user has access to controller
    	$this->load->library('admin_library');
    	$this->admin_library->checkAccess('bb');

		$this->load->model('bbphotos_model');
		
		$photo = $this->bbphotos_model->get($id);
		$bb_id = $posts = $this->input->post('bb_id');

		unlink(FCPATH.'public/'.$photo->large_url);
		unlink(FCPATH.'public/'.$photo->small_url);

		$this->bbphotos_model->delete($id);
		
		redirect('/admin/bb/'.$bb_id.'/edit');
	}

	public function bb_photo($id)
	{
		// check if user has access to controller
    	$this->load->library('admin_library');
    	$this->admin_library->checkAccess('bb');

		$this->load->model('bbphotos_model');
		$photo = $this->bbphotos_model->get($id);
		if (count($photo) != 0) {

			$this->arViewData['bulletin_photo'] = $photo;
			$this->_layout('admin/delete/bbphoto');
		
		} else {
			 show_404();
		}

	}

	public function photo_delete($id)
	{
		// check if user has access to controller
    	$this->load->library('admin_library');
    	$this->admin_library->checkAccess('files');

		$this->load->model('photo_model');
		
		$photo = $this->photo_model->get($id);
		$file_id = $this->input->post('file_id');

		unlink(FCPATH.'public/'.$photo->large_url);
		unlink(FCPATH.'public/'.$photo->small_url);

		$this->photo_model->delete($id);
		
		redirect('/admin/files/'.$file_id.'/edit');
	}

	public function photo($id)
	{
		// check if user has access to controller
    	$this->load->library('admin_library');
    	$this->admin_library->checkAccess('files');

		$this->load->model('photo_model');
		$this->arViewData['photo'] = $this->photo_model->get($id);
		$this->_layout('admin/delete/photo');
	}

}
