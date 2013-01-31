<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articles_model extends CI_Model {

	function __construct()
	{
		parent::__construct();	
	}
	
	public function get_entries_by_categories($categories, $limit = 10, $offset = 0, $language_id = 1){

                $this->db->select('*')->from('entries')->where_in('category_id', $categories)
                         ->where( array("entry_state_id" => 3, "language_id" => $language_id) )
                         ->limit( $limit, $offset )
                         ->order_by('modified_date','DESC');
                $query = $this->db->get();
		return $query->result();
	}
	
	public function count_entries_by_categories($categories, $language_id = 1){
            $this->db->select('*')->from('entries')->where_in('category_id', $categories)->where( array("entry_state_id" => 3, "language_id" => $language_id) );
            return $this->db->count_all_results();;
	}
	
	
	
	/**
	 * 
	 * Get all entries with from entry type and in entry id list
	 * @param int $entry_type_id
	 * @param string $entries
	 */
	public function get_published_type_by_entries($entry_type_id, $entries, $limit = 3, $offset = 0){
		$limit = mysql_real_escape_string($limit);
		$offset = mysql_real_escape_string($offset);
		$sql = "SELECT * FROM entries WHERE entry_type_id = ? AND entry_state_id=3 AND id IN (".$entries.") ORDER BY id DESC LIMIT ".$offset.",".$limit;
		$query = $this->db->query($sql, array($entry_type_id));
		return $query->result();
	
	}
	
	public function get_num_published_by_type($entry_type_id, $entries){
		
		$sql = "SELECT COUNT(*) AS number FROM entries WHERE entry_type_id = ? AND entry_state_id=3 AND id IN (".$entries.")";
		$query = $this->db->query($sql, array($entry_type_id));
		return $query->result();
	
	}
	
	public function get_entries_by_tag($tag_id){
		$sql = "SELECT * FROM join_entries_tags WHERE active = 1 AND tag_id = ?";
		$query = $this->db->query($sql, array($tag_id));
		return $query->result();
	}
	
	public function countEntriesByTag($tag_id, $entry_state_id = 3){
		$sql = "SELECT COUNT(jet.entry_id) AS number FROM join_entries_tags jet 
				INNER JOIN entries e ON jet.entry_id = e.id
				WHERE jet.active = 1 AND jet.tag_id = ? AND e.entry_state_id = ?";
		$query = $this->db->query($sql, array($tag_id, $entry_state_id));
		return $query->first_row();
	}
	
	public function getEntriesByTagLimited($tag_id, $limit = 3, $offset = 0, $result_array = FALSE, $entry_state_id = 3){
		$limit = mysql_real_escape_string($limit);
		$offset = mysql_real_escape_string($offset);
		
		$sql = "SELECT * FROM join_entries_tags jet
				INNER JOIN entries e ON jet.entry_id = e.id
				WHERE active = 1 AND tag_id = ? AND e.entry_state_id = ?
				ORDER BY entry_id DESC LIMIT ".$offset.",".$limit;
		$query = $this->db->query($sql, array($tag_id, $entry_state_id));
		if($result_array){
			return $query->result_array();
		}else{
			return $query->result();
		}
	}
	
	/**
	 * getEntryType
	 *
	 * Select data from specified table by id, used for different type of entries
	 *
	 * @param int $type_id
	 * @param string $table_name
	 */
	public function getEntryType($type_id, $table_name="stories"){
		$sql = "SELECT * FROM ".$table_name." WHERE id = ?";
		$query = $this->db->query($sql, array($type_id));
		return $query->first_row();
	}
	
	public function getTableByEntryType($entry_type_id = 1){
		$sql = "SELECT * FROM entry_types WHERE id = ?";
		$query = $this->db->query($sql, array($entry_type_id));
		return $query->first_row();
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
		return $query->first_row();
	}
	
	/**
	 * 
	 * Get entry object by entry_type_id (story, game etc.) and type_id (sotry_id and/or game_id etc.) 
	 * @param int $type_id
	 * @param int $entry_type_id
	 */
	public function get_entry_by_type($type_id, $entry_type_id = 1){
		$query = $this->db->get_where("entries",array("type_id" => $type_id, "entry_type_id"=> $entry_type_id));
		$result = $query->result();
		if(!empty($result)){
			return $result;
		}else{
			return false;
		}
	}
	
	public function get_entry_type_by_name($type_name){
		$query = $this->db->get_where("entry_types",array("type_name" => $type_name));
		return $query->result();
	}
	
	public function getEntryByID($id){
		$query = $this->db->get_where("entries",array("id" => $id, "entry_state_id" => 3));
		$result = $query->first_row();
		if(!empty($result)){
			return $result;
		}else{
			return false;
		}
	}
	
}

/* End of file articles_model.php */
/* Location: ./application/modules/articles/controllers/articles_model.php */
