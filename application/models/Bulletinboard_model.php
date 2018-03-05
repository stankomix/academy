<?php

use Carbon\Carbon;

class Bulletinboard_model extends CI_Model {

	const BIRTHDAY_CATEGORY = '3';
	const NEW_HIRE_CATEGORY = '2';
	const STATUS_ACTIVE = 1;
	public $newId;

	public function __construct() {
		parent::__construct();
	}

	/**
	 * Get recent bulletins
	 *
	 * @param int $excludeId (Optional) Id of bulletin to exclude from results
	 * @param int $exclude_category  (Optional) Id of category to exclude from results
	 *
	 * @return StdClass[]
	 */
	public function recent($exludeId = null, $exclude_category = null)
	{
		$this->db->where('status', 1);

		if ($exludeId) {
			$this->db->where('id <>', $exludeId);
		}

		if ($exclude_category) {
			$this->db->where('category <>', $exclude_category);
		}

		$this->db->order_by('id', 'DESC');
		$this->db->limit(4);
		$db_result = $this->db->get('bulletin_board');

		return $db_result->result();
	}

	/**
	 * Get all bulletins
	 *
	 * @return StdClass[]
	 */
	public function all($is_admin = FALSE)
	{
		$this->db->select('bulletin_board.*, bb_photos.small_url');
		if (!$is_admin){
			$this->db->where('bulletin_board.status', 1);
		}
		$this->db->order_by('bulletin_board.id', 'DESC');
		$this->db->join('bb_photos', 'bb_photos.bb_id = bulletin_board.id', 'left');
		$this->db->group_by('bulletin_board.id');

		$db_result = $this->db->get('bulletin_board');

		return $db_result->result();
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
	public function find_or_fail($id, $is_admin = FALSE)
	{
		$this->db->where('bulletin_board.id', $id);
		if (!$is_admin){
			$this->db->where('bulletin_board.status', 1);
		}
		$this->db->join('bb_photos', 'bb_photos.bb_id = bulletin_board.id', 'left');
		$this->db->limit(1);

		$db_result = $this->db->get('bulletin_board');

		if (!$db_result->num_rows()) throw new Exception("Entry not found", 1);

		return $db_result->row();
	}

	/**
	 * Adds a birthday entry to the bulletin board
	 *
	 * @param string $name  Employee name
	 * @param string $date  Birthday date
	 *
	 * @return void
	 */
	public function add_birthday($name, $date)
	{
		$date = Carbon::createFromFormat('Y-m-d', $date);

		$this->db->set('title', 'HAPPY BIRTHDAY '.  strtoupper($name));
		$this->db->set('category', self::BIRTHDAY_CATEGORY);

		$this->db->set(
			'content',
			sprintf(
				'HAPPY BIRTHDAY %s %s!!',
				strtoupper($name),
				strtoupper($date->format('F j')).$date->format('S')
			)
		);

		$create_date = Carbon::create(Carbon::now()->year, $date->month, $date->day);
		$this->db->set('create_date', $create_date->toDateTimeString());
		$this->db->set('status', self::STATUS_ACTIVE);
		$this->db->insert('bulletin_board');
	}

	/**
	 * Get birthday entries to show on /dashboard
	 *
	 * @return StdClass[]
	 */
	public function get_birthdays()
	{
		$this->db->order_by('create_date', 'asc');
		$sql_where = "month(create_date) = month(NOW())";
		$db_result = $this->db->where('status', self::STATUS_ACTIVE)
			->where($sql_where)
			->where('category', self::BIRTHDAY_CATEGORY)
			->get('bulletin_board');

		return $db_result->result();	
	}

	/**
	 * Add a new hire entry to the bulletin board
	 *
	 * @param string $name  Employee name
	 * @param string $date  Hire date
	 *
	 * @return void
	 */
	public function add_hire($name, $date)
	{
		$date = Carbon::createFromFormat('Y-m-d', $date);

		$this->db->set('title', 'Welcome ' . $name . '!!');
		$this->db->set('category', self::NEW_HIRE_CATEGORY);
		$this->db->set('create_date', $date->toDateTimeString());
		$this->db->set('status', self::STATUS_ACTIVE);

		$this->db->set(
			'content',
			sprintf(
				'Let us welcome %s',
				$name
			)
		);

		$this->db->insert('bulletin_board');		
	}

	public function add_news($fields)
	{
		$data = [
			'title'			=> $fields['title'],
			'category'		=> $fields['category'],
			'content'		=> $fields['content'],
			'status'		=> $fields['status'],
			'create_date'   => date('Y-m-d H:i:s')
		];

		$this->db->insert('bulletin_board', $data);
		$this->newId = $this->db->insert_id();
	}

	public function update($id, $fields)
	{
		$data = [
			'title'			=> $fields['title'],
			'category'		=> $fields['category'],
			'content'		=> $fields['content'],
			'status'		=> $fields['status']
		];

		$this->db->where('id', $id);
		$this->db->update('bulletin_board', $data);
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('bulletin_board');
	}

}
