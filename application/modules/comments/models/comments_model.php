<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comments_model extends CI_Model {

	function __construct(){
		parent::__construct();
	}
	
	function insert($item_id, $name, $email, $comment, $ip_address, $status=0){
		
                $createdDate = date('Y-m-d H:i:s');
                $data = array('entry_id' => $item_id, 'name' => $name, 
                            'email' => $email, 'body' => $comment,
                            'ip_address'=>$ip_address, 'status' => $status, 'createdDate' => $createdDate );
                $this->db->insert('comments', $data);
                
                if( $this->db->insert_id() > 0){
			return true;
		}else{
			return false;
		}	
	}
	
	function getComments($entry_id){
		$sql = "SELECT * FROM comments WHERE entry_id=? AND status = 3 ORDER BY createdDate DESC";
		$query = $this->db->query($sql, array($entry_id));
		$result = $query->result();
		if(!empty($result)){
			return $result;
		}else{
			return false;
		}
	}

	function getEntryCategoryId($entry_id){
		$sql = "SELECT category_id FROM entries WHERE id=?";
		$query = $this->db->query($sql, array($entry_id));
		$result = $query->first_row();
		if(!empty($result)){
			return $result->category_id;
		}else{
			return false;
		}
	}
	
	//checks if `comments` is set to 1 for category with given id $cat_id
	function checkStatusForCat($cat_id){
		//var_dump($cat_id);die;
		$sql = "SELECT comments FROM categories WHERE id=?";
		$query = $this->db->query($sql, array($cat_id));
		$result = $query->first_row();
		if(!empty($result)){
			return $result->comments;
		}else{
			return false;
		}
	}
	
	function checkStatusForEntry($entry_id){
		$sql = "SELECT comments FROM entries WHERE id=?";
		$query = $this->db->query($sql, array($entry_id));
		$result = $query->first_row();
		if(!empty($result)){
			return $result->comments;
		}else{
			return false;
		}
	
	}
	
	public function countEntryComments($entry_id){
		$sql = "SELECT COUNT(id) AS number FROM comments WHERE entry_id = ? AND status = 3";
		$query = $this->db->query($sql, array($entry_id));
		$result = $query->first_row();
		if(!empty($result)){
			return $result->number;
		}else{
			return false;
		}
	}
	
	public function get_entries_by_categories($categories){
		/*$categories = array($categories);
		$this->db->where_in('category_id', $categories);
		$query = $this->db->get_where('join_entries_categories', array("active" => 1));
		*/
		$categories = mysql_real_escape_string($categories);
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
	public function get_published_type_by_entries($entry_type_id, $entries, $limit = 3){
		$entries = mysql_real_escape_string($entries);
		$sql = "SELECT * FROM entries WHERE entry_type_id = ? AND entry_state_id=3 AND id IN (".$entries.") ORDER BY id DESC LIMIT ".$limit;
		$query = $this->db->query($sql, array($entry_type_id));
		return $query->result();
	
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
