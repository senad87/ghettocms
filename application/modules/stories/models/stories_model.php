<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stories_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		
	}
	
	/**
	 * 
	 * Get all story data
	 * @param int $story_id
	 */
	public function get_story_by_id($story_id){
		$query = $this->db->get_where("stories",array("id"=>$story_id));
		return $query->result();
	}
	
	
	public function get_entry_id($story_id){
		$this->db->select('id');
		$query = $this->db->get_where("entries",array("type_id"=>$story_id));
		return $query->first_row()->id;
	}
	
	public function get_entry_category_id($entry_id){
		$this->db->select('category_id');
		$query = $this->db->get_where("join_entries_categories",array("entry_id"=>$entry_id));
		return $query->first_row()->category_id;
	}
	
	public function getEntriesByTypeAndCategory($id, $type_id = 1){
		//$this->db->order_by("id", "desc"); 
		$query = $this->db->get_where("entries",array("category_id"=>$id, "entry_type_id"=>$type_id, "entry_state_id" => 3));
		return $query->result();
	}
	
}
