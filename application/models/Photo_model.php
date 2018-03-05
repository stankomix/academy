<?php

/**
 * Photo Model class file.
 *
 * @author 		Sam Takunda <sam.takunda@gmail.com>
 * @copyright 	(c) 2016, Commercial Fire Protection
 */

class Photo_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	/**
	 * Get photos in gallery $id
	 *
	 * @param int $id
	 *
	 * @return StdClass[]
	 */
	public function gallery($id)
	{
		$db_result = $this->db->get_where('photos', [ 'file_id' => $id ]);

		return $db_result->result();
	}

	public function get($id)
	{
		$this->load->database();

		$this->db->where('id', $id);
		$db_result = $this->db->get('photos');

		return $db_result->row();
	}

	public function addPhoto($file_id, $photo, $ext)
	{
		$data = [
			'file_id'		=> $file_id,
			'large_url' 	=> 'photos/'.$photo.$ext,
			'small_url'		=> 'photos/'.$photo.'-k'.$ext,
			'description' 	=> '',
			'status'		=> 1
		];

		$this->load->database();
		$this->db->insert('photos', $data);
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('photos');
	}

	public function delete_for_file($id)
	{
		$this->db->where('file_id', $id);
		$this->db->delete('photos');
	}

}
