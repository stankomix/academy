<?php 

class Test_questions_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
		
	/*
	* Get all test question using from a test id
	*/
	public function get($id){
		$this->load->database();
		$this->db->where('test_id', $id);
		$db_result = $this->db->get('test_questions');
		
			return $db_result->result();
		
	}
	
	public function add($fields){
		$data = [
			'test_id'		=> $fields['test_id'],
			'question'		=> $fields['title'],
			'options'		=> json_encode($fields['questions']),
			'correct_answer'=> $fields['correct_answer'],
			'status'   => $fields['status']
		];

		$this->db->insert('test_questions', $data);
	}
	
	public function edit($id){
		$this->load->database();
		$this->db->where('id', $id);
		$db_result = $this->db->get('test_questions');
		
		if($db_result->num_rows() > 0){
			return $db_result->row();
		}else{
			return false;
		}
		
	}
	
	public function update($id, $fields)
	{
		$data = [
				'question'		=> $fields['title'],
				'options'		=> json_encode($fields['questions']),
				'correct_answer'=> $fields['correct_answer'],
				'status'   => $fields['status']
		];

		$this->db->where('id', $id);
		$this->db->update('test_questions', $data);
	}
	
	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('test_questions');
	}
	
}