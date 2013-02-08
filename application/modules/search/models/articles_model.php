<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articles_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		
	}
	
	public function get_entries_by_categories($categories){
		/*$categories = array($categories);
		$this->db->where_in('category_id', $categories);
		$query = $this->db->get_where('join_entries_categories', array("active" => 1));
		*/
		$sql = "SELECT * FROM join_entries_categories WHERE active = 1 AND category_id IN (".$categories.")";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	
	
	/**
	 * 
	 * Get all entries with from entry type and in entry id list
	 * @param int $entry_type_id
	 * @param string $entries
	 */
	public function get_published_type_by_entries($entry_type_id, $entries, $limit = 3, $offset = 0){
		
		$sql = "SELECT * FROM entries WHERE entry_type_id = ? AND entry_state_id=3 AND id IN (".$entries.") ORDER BY id DESC LIMIT ".$offset.",".$limit;
		$query = $this->db->query($sql, array($entry_type_id));
		return $query->result();
	
	}
	
	public function get_num_published_by_type($entry_type_id, $entries){
		
		$sql = "SELECT COUNT(*) AS number FROM entries WHERE entry_type_id = ? AND entry_state_id=3 AND id IN (".$entries.")";
		$query = $this->db->query($sql, array($entry_type_id));
		return $query->result();
	
	}
	
	/*public function get_number_of_non_deleted_entries_by_type($entry_type_id){
		$this->db->where(array("entry_state_id >" => 1, "entry_type_id"=> $entry_type_id));
		$number = $this->db->count_all_results('entries');
		return $number;
	}*/
	
	/**
	 * 
	 * Get all story data
	 * @param int $story_id
	 */
	public function get_story_by_id($story_id){
		$query = $this->db->get_where("stories",array("id"=>$story_id));
		return $query->result();
	}
	
	/**
	 * 
	 * Get entry object by entry_type_id (story, game etc.) and type_id (sotry_id and/or game_id etc.) 
	 * @param int $type_id
	 * @param int $entry_type_id
	 */
	public function get_entry_by_type($type_id, $entry_type_id = 1){
		$query = $this->db->get_where("entries",array("type_id" => $type_id, "entry_type_id"=> $entry_type_id));
		return $query->result();
	}
	
	public function get_entry_type_by_name($type_name){
		$query = $this->db->get_where("entry_types",array("type_name" => $type_name));
		return $query->result();
	}
	
}

/* End of file articles_model.php */
/* Location: ./application/modules/articles/controllers/articles_model.php */
