<?php

/**
 * Tests Model class file.
 *
 * @author 		Sam Takunda <sam.takunda@gmail.com>
 * @copyright 	(c) 2016, Commercial Fire Protection
 */

class Test_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get test completion stats for user $id
	 *
	 * @param int $id User Id
	 *
	 * @return StdClass
	 */
	public function progress($id)
	{
		$this->db->select('COUNT(id) as total_mandatory');
		$this->db->where('mandatory', 1);
		$this->db->where('status', 1);
		$mandatory_result = $this->db->get('tests');

		if (!$mandatory_result->num_rows()) {
			return (object)[
				'taken' => 0,
				'mandatory' => 0,
				'remaining' => 0,
				'percentage' => 0
			];
		}

		$mandatory = $mandatory_result->row()->total_mandatory;

		$this->db->reset_query();

		$this->db->select('COUNT(id) AS taken');
		$this->db->where('user_id', $id);
		$this->db->where('status', 1);
		$this->db->where("test_id IN ('SELECT * FROM tests WHERE mandatory=1 AND status=1')");
		$db_result = $this->db->get('test_answers');

		$taken = (!$db_result->num_rows()) ? 0 :  $db_result->row()->taken;

		$percentage = ($taken / $mandatory) * 100;
		if ($percentage > 97) $percentage = 100;

		return (object)[
			'taken' => $taken,
			'mandatory' => $mandatory,
			'remaining' => $mandatory - $taken, 
			'percentage' => $percentage
		];
	}

	public function all()
	{

		$db_result = $this->db->get('tests');

		return $db_result->result();

	}

	public function get($id)
	{
		$this->load->database();
		$this->db->where('id', $id);
		$db_result = $this->db->get('tests');

		return $db_result->row();
	}

	public function add($fields)
	{
		$data = [
			'title'			=> $fields['title'],
			'test_type'		=> 'Online',
			'mandatory'		=> $fields['mandatory'],
			'status'		=> $fields['status'],
			'create_date'   => date('Y-m-d H:i:s')
		];

		$this->db->insert('tests', $data);
	}

	public function update($id, $fields)
	{

		$data = [
			'title'			=> $fields['title'],
			'mandatory'		=> $fields['mandatory'],
			'status'		=> $fields['status']
		];

		$this->db->where('id', $id);
		$this->db->update('tests', $data);
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('tests');
	}


}
