<?php

/**
 * Admin Model class file.
 *
 * @author 		Sam Takunda <sam.takunda@gmail.com>
 * @copyright 	(c) 2016, Commercial Fire Protection
 */

class Admin_model extends CI_Model {

	public $newId;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Determine if user with id $user_id is an admin
	 *
	 * @param int $user_id  User Id
	 *
	 * @return bool
	 */
	public function is_admin($user_id)
	{
		$this->db->limit(1);

		$db_result = $this->db->get_where(
			'admins',
			array(
				'user_id' => $user_id,
				'status' => 1,
			)
		);

		return ($db_result->num_rows() > 0);
	}

	public function user_tiles($user_id)
	{
		$this->db->where('user_id', $user_id);
		$db_result = $this->db->get('admins');
		$row = $db_result->row();

		$tiles = explode('.', $row->tiles);

		return $tiles;
	}

	public function all()
	{
		$this->db->select('user_id, name_surname, tiles, admins.status AS status');
		$this->db->from('users');
		$this->db->join('admins', 'users.id = admins.user_id');
		$db_result = $this->db->get();

		return $db_result->result();
	}

	public function get($user_id)
	{
		$this->db->select('user_id, name_surname, email, tiles, admins.status AS status');
		$this->db->from('users');
		$this->db->join('admins', 'users.id = admins.user_id');
		$this->db->where('user_id', $user_id);
		$db_result = $this->db->get();

		return $db_result->row();
	}

	public function get_id($id)
	{
		$this->db->select('user_id, name_surname, email, tiles, admins.status AS status');
		$this->db->from('users');
		$this->db->join('admins', 'users.id = admins.user_id');
		$this->db->where('admins.id', $id);
		$db_result = $this->db->get();

		return $db_result->row();
	}

	public function add($user_id)
	{
		$data = [
			'user_id' => $user_id,
			'status' =>	1
		];

		$this->db->insert('admins', $data);
		$this->newId = $this->db->insert_id();
	}

	public function update($id, $fields, $status)
	{
		$tiles = '';

		foreach ($fields as $key => $value) {
			if ($value == 1) {
				$tiles = $tiles.'.'.$key;
			}
		}

		$data = [
			'status'	=> $status,
			'tiles'		=> $tiles
		];

		$this->db->where('user_id', $id);
		$this->db->update('admins', $data);
	}

	public function delete($id)
	{
		$this->db->where('user_id', $id);
		$this->db->delete('admins');
	}

}
