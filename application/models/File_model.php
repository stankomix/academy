<?php

/**
 * File Model class file.
 *
 * @author 		Sam Takunda <sam.takunda@gmail.com>
 * @copyright 	(c) 2016, Commercial Fire Protection
 */

class File_model extends CI_Model {

	public $newId;

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get recently uploaded files
	 *
	 * @return CI_DB_result 
	 */
	public function recent()
	{
		$this->db->order_by('id', 'desc');
		$db_result = $this->db->get_where('files', array ('status' => 1), 4);

		return $db_result->result();
	}

	/**
	 * Get files count per category
	 *
	 * @return string[]int
	 */
	public function category_stats($is_admin = FALSE)
	{
		$stats = [
			'Handbooks' => 0,
			'Videos' => 0,
			'Guides' => 0,
			'Event Photos' => 0,
			'Manuals' => 0,
			'Other' => 0
		];

		if ($is_admin) {

			$query = "SELECT COUNT(id) as files, category FROM files WHERE category ".
			"IN('Handbooks', 'Videos', 'Guides', 'Event Photos', 'Manuals', 'Other') GROUP BY category";

		} else {

			$query = "SELECT COUNT(id) as files, category FROM files WHERE status = 1 AND category ".
			"IN('Handbooks', 'Videos', 'Guides', 'Event Photos', 'Manuals', 'Other') GROUP BY category";
		}

		$db_result = $this->db->query($query);

		foreach ($db_result->result() as $row) {
			$stats[$row->category] = $row->files;
		}

		return $stats;
	}

	/**
	 * Get the number of files in category $id
	 *
	 * @param string $id Category name
	 *
	 * @return CI_DB_result
	 */
	public function count_for_category($id, $is_admin = FALSE)
	{
		$this->db->select('COUNT(id) as files');
		$this->db->where('category', $this->real_id($id));
		if (!$is_admin) {
			$this->db->where('status', 1);
		}
		$db_result = $this->db->get('files');

		return $db_result->row()->files;
	}

	/**
	 * Get files in category $id
	 *
	 * @param string $id Category Id
	 *
	 * @return CI_DB_result
	 */
	public function category($id, $is_admin = FALSE)
	{
 		$this->db->where('category', $this->real_id($id));
 		if (!$is_admin) {
 			$this->db->where('status', 1);
 		}
 		$this->db->order_by('create_date', 'DESC');

		$db_result = $this->db->get('files');

		return $db_result->result();
	}

	/**
	 * Get the database-side id for the given category id
	 *
	 * @param string $id Category id
	 *
	 * @return string
	 */
	public function real_id($id)
	{
		$categories = [
			'handbooks' => 'Handbooks',
			'videos' => 'Videos',
			'guides' => 'Guides',
			'manuals' => 'Manuals',
			'other' => 'Other',
			'photos' => 'Event Photos',
		];

		return $categories[$id];
	}

	/**
	 * Get row with id $id
	 *
	 * @param int $id Row id
	 *
	 * @throws \Exception
	 *
	 * @return StdClass
	 */
	public function find_or_fail($id)
	{
		$db_result = $this->db->get_where('files', [ 'id' => $id ]);

		if (!$db_result->num_rows()) throw new Exception("Item not found", 1);

		return $db_result->row();
	}

	/**
	 * Increment clicks
	 *
	 * @param int $id File id
	 *
	 * @return void
	 */
	public function click($id)
	{
		$this->db->where('id', $id);
		$this->db->set('clicks', 'clicks+1', FALSE);
		$this->db->update('files');
	}

	public function update($id, $fields)
	{
		if (isset($fields['embed_code']) ){
			
			$embed_code = '&lt;iframe width=&quot;560&quot; height=&quot;315&quot; src=&quot;'.
					  $fields['embed_code'].
					  '&quot; frameborder=&quot;0&quot; allowfullscreen&gt;&lt;/iframe&gt;';
		
		} else {
		
			$embed_code = '';
		
		}

		$data = [
			'title'			=> $fields['title'],
			'category'		=> $fields['category'],
			'status'		=> $fields['status'],
			'embed_code'    => $embed_code
		];

		$this->db->where('id', $id);
		$this->db->update('files', $data);
	}

	public function add_file($fields, $file)
	{
		$type = substr($file['file_ext'], 1);
		$size = $file['file_size'];
		
		if ($size >= 1024){
			
			$size = ($size / 1024);
			$size = (round($size, 2)).' MB';
		
		} else {
			
			$size = $size.' KB';
		}

		$data = [
			'title'			=> $fields['title'],
			'category'		=> $fields['category'],
			'status'		=> $fields['status'],
			'file_name'		=> $file['file_name'],
			'file_type'		=> $type,
			'file_size'		=> $size,
			'create_date'   => date('Y-m-d H:i:s')

		];

		$this->db->insert('files', $data);
		$this->newId = $this->db->insert_id();
	}

	public function add_event_photos($fields)
	{
		$data = [
			'title'			=> $fields['title'],
			'category'		=> $fields['category'],
			'status'		=> $fields['status'],
			'create_date'   => date('Y-m-d H:i:s')
		];

		$this->db->insert('files', $data);
		$this->newId = $this->db->insert_id();
	}

	public function add_video_url($fields)
	{
		if ($fields['category'] == 'Training Videos(online)'){
		
			$category = 'Training Videos';
		
		} else {
			
			$category = 'Videos';
		}

		$embed_code = '&lt;iframe width=&quot;560&quot; height=&quot;315&quot; src=&quot;'.
					  $fields['embed_code'].
					  '&quot; frameborder=&quot;0&quot; allowfullscreen&gt;&lt;/iframe&gt;';

		$data = [
			'title'			=> $fields['title'],
			'category'		=> $category,
			'status'		=> $fields['status'],
			'embed_code'	=> $embed_code,
			'create_date'   => date('Y-m-d H:i:s')
		];

		$this->db->insert('files', $data);
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('files');
	}

}
