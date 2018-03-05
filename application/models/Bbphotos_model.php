<?php

/**
 * Bulletin Board Photos Model class file.
 *
 * @author 		Sam Takunda <sam.takunda@gmail.com>
 * @copyright 	(c) 2016, Commercial Fire Protection
 */

class Bbphotos_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	/**
	 * Get photos for bulletin with id $id
	 *
	 * @param int $id Bulletin board entry id
	 *
	 * @return StdClass[]
	 */
	public function bulletin($id)
	{
		$this->db->where('bb_id', $id);
		$this->db->where('status', 1);
		$this->db->order_by('id', 'ASC');
		$db_result = $this->db->get('bb_photos');

		return $db_result->result();
	}

	public function get($id)
	{
		$this->load->database();
		
		$this->db->where('id', $id);
		$db_result = $this->db->get('bb_photos');

		return $db_result->row();
	}

	public function addPhoto($bb_id, $photo, $ext)
	{
		$data = [
			'bb_id'			=> $bb_id,
			'large_url' 	=> 'photos/'.$photo.$ext,
			'small_url'		=> 'photos/'.$photo.'-k'.$ext,
			'description' 	=> '',
			'status'		=> 1
		];

		$this->load->database();
		$this->db->insert('bb_photos', $data);
	}

	public function deleteBulletin($id)
	{
		$this->db->where('bb_id', $id);
		$this->db->delete('bb_photos');
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('bb_photos');
	}

}
