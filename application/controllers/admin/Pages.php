<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends MY_Controller {

	function __construct()
	{
		parent::__construct();
    	$this->load->library('admin_library');
	}

	// BULLETIN VIEWS

	public function add_bulletin()
	{
		// check user access
		$this->admin_library->checkAccess('bb');

		$this->_layout('admin/add/bulletin');
	}

	public function edit_bulletin($id)
	{
		// check user access
		$this->admin_library->checkAccess('bb');

		$this->load->model('bulletinboard_model', '', TRUE);
		$this->load->model('bbphotos_model');

		$this->arViewData['bb_id'] = $id;
		$this->arViewData['bulletin_photos'] = $this->bbphotos_model->bulletin($id);
		$this->arViewData['bulletin'] = $this->bulletinboard_model->find_or_fail($id, $is_admin=TRUE);
		
		$this->_layout('admin/edit/bulletin');
	}

	public function delete_bulletin($id)
	{
		// check user access
		$this->admin_library->checkAccess('bb');

		$this->load->model('bulletinboard_model', '', TRUE);
		$this->load->model('bbphotos_model');

		$this->arViewData['bb_id'] = $id;
		$this->arViewData['bulletin_photos'] = $this->bbphotos_model->bulletin($id);
		$this->arViewData['bulletin'] = $this->bulletinboard_model->find_or_fail($id, $is_admin=TRUE);
		
		$this->_layout('admin/delete/bulletin');
	}

	// FILES VIEW

	public function edit_file($id)
	{
		// check user access
		$this->admin_library->checkAccess('files');

		$this->load->model('file_model', '', TRUE);
		$this->load->model('photo_model');
		$file = $this->file_model->find_or_fail($id);

		if ($file == NULL) {

			redirect('/files');

		} else {

			$category = $file->category;

			if ($category == "Event Photos") {
				$category = 'photos';
			}

			$this->arViewData['file'] = $file;
			$this->arViewData['photos'] = $this->photo_model->gallery($id);
			$this->arViewData['category'] = strtolower($category);
			$this->_layout('admin/edit/file');
		}

	}

	public function delete_file($id)
	{
		// check user access
		$this->admin_library->checkAccess('files');

		$this->load->model('file_model', '', TRUE);
		$this->load->model('photo_model');
		$file = $this->file_model->find_or_fail($id);

		if ($file == NULL) {

			redirect('/files');

		} else {

			$this->arViewData['file'] = $file;
			$this->arViewData['photos'] = $this->photo_model->gallery($id);
			$this->_layout('admin/delete/file');
		}

	}

	public function add_file()
	{
		// check user access
		$this->admin_library->checkAccess('files');

		$this->_layout('admin/add/file');
	}

	// USER VIEWS

	public function edit_user($id)
	{
		// check user access
		$this->admin_library->checkAccess('users');

		$this->load->model('user_model', '', TRUE);
		$this->load->model('employee_positions_model');
		$user = $this->user_model->get($id);
		
		if ($user == NULL){
			
			redirect('/admin/users');

		} else {
			
			$this->arViewData['user'] = $user;
			$this->arViewData['positions'] = $this->employee_positions_model->all();
			$this->_layout('admin/users/edit');
		}

	}

	public function delete_user($id)
	{
		// check user access
		$this->admin_library->checkAccess('users');

		$this->load->model('user_model', '', TRUE);
		$user = $this->user_model->get($id);

		if ($user == NULL){

			redirect('/admin/users');

		} else {

			$this->arViewData['user'] = $user;
			$this->_layout('admin/users/delete');
		}

	}

	public function add_user()
	{
		// check user access
		$this->admin_library->checkAccess('users');

		$this->load->model('user_model', '', TRUE);
		$this->load->model('employee_positions_model');
		
		$this->arViewData['positions'] = $this->employee_positions_model->all();
		$this->_layout('admin/users/add');
	}

	// TEST VIEW

	public function add_test()
	{
		// check user access
		$this->admin_library->checkAccess('tests');

		$this->_layout('admin/add/test');
	}

	public function edit_test($id)
	{
		// check user access
		$this->admin_library->checkAccess('tests');

		$this->load->model('test_model');
		$test = $this->test_model->get($id);

		$this->arViewData['test'] = $test;
		$this->_layout('admin/edit/test');
	}

	public function delete_test($id)
	{
		// check user access
		$this->admin_library->checkAccess('tests');

		$this->load->model('test_model');
		$test = $this->test_model->get($id);

		$this->arViewData['test'] = $test;
		$this->_layout('admin/delete/test');
	}

	// ADMIN VIEWS
	public function add_admin($pageNo = 0)
	{
		// check user access
		$this->admin_library->checkAccess('admins');

		$this->load->model('user_model', '', TRUE);

		$this->arViewData['users'] = $this->user_model->all();
		$this->_layout('admin/add/admin');
	}

	public function confirm_admin($id)
	{
		// check user access
		$this->admin_library->checkAccess('admins');

		$this->load->model('user_model', '', TRUE);
		$user = $this->user_model->get($id);
		
		$this->arViewData['user'] = $user;
		$this->_layout('admin/add/confirm_admin');
	}

	public function edit_admin($id)
	{
		// check user access
		$this->admin_library->checkAccess('admins');

		$this->load->model('admin_model');
        $privileges = [
        	['name' => 'timecards', 'label' => 'Create and close user timecards'],
        	['name' => 'overtime', 'label' => 'Create Overtime timecards'],
        	['name' => 'users', 	'label' => 'Edit Users'],
        	['name' => 'bb', 		'label' => 'Edit Bulletin Board'],
        	['name' => 'files', 	'label' => 'Edit Files'],
        	['name' => 'tests', 	'label' => 'Edit Tests'],
        	['name' => 'payroll',	'label' => 'View Payroll']
        ];

        $this->arViewData['privileges'] = $privileges;
		$this->arViewData['admin'] = $this->admin_model->get($id);
		$this->_layout('admin/edit/admin');
	}

	public function delete_admin($id)
	{
		// check user access
		$this->admin_library->checkAccess('admins');

		$this->load->model('admin_model');

		$this->arViewData['privileges'] = $privileges;
		$this->arViewData['admin'] = $this->admin_model->get($id);
		$this->_layout('admin/delete/admin');
	}

	// TIMECARD VIEWS
	public function timecards_select()
	{
		// check user access
		$this->admin_library->checkAccess('timecards');
		
		$this->load->model('user_model', '', TRUE);
		$this->load->model('timecard_model');
		$open_users = $this->timecard_model->user_open_timecard();
		if (is_null($open_users) ){
			$open_users = [];
		}

		$this->arViewData['open_users'] = $open_users;
		$this->arViewData['users'] = $this->user_model->all();
		$this->_layout('admin/users/timecard_list');

	}

	public function timecards_user($id)
	{
		// check user access
		$this->admin_library->checkAccess('timecards');
		$this->admin_library->set_user_timecard($id);

		redirect('/admin/overtime');
	}

}	