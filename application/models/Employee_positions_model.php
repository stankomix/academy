<?php

/**
 * Employee Positions Model class file.
 *
 * @author 		Sam Takunda <sam.takunda@gmail.com>
 * @copyright 	(c) 2016, Commercial Fire Protection
 */

class Employee_positions_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function all()
	{

		$db_result = $this->db->get('employee_positions');

		return $db_result->result();

	}

	/**
	 * Get employee type for given user
	 *
	 * @param interger : user id
	 *
	 * @return string
	 */
	public function get_type_user($id)
	{
		$this->db->where('users.id', $id);
		$this->db->from('users');
		$this->db->join('employee_positions', 'employee_positions.id = users.employee_position_id');
		$db_result = $this->db->get();

		$user = $db_result->row();

		return $user->type;
	}

	/**
	 * Get employee title for given user
	 *
	 * @param interger : user id
	 *
	 * @return string
	 */
	public function get_title_user($id)
	{
		$this->db->where('users.id', $id);
		$this->db->from('users');
		$this->db->join('employee_positions', 'employee_positions.id = users.employee_position_id');
		$db_result = $this->db->get();

		$user = $db_result->row();

		return $user->title;
	}

}
