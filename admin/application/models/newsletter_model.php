<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Newsletter_model extends CI_Model {

	function __construct(){
		parent::__construct();	
	}
	
	
	
	function insert($item_id, $name, $email, $comment, $status=0){
		$createdDate = date('Y-m-d H:i:s');
		$sql = "INSERT INTO comments (entry_id, name, email, body, status, createdDate) VALUES (?, ?, ?, ?, ?, ?)";
		$query = $this->db->query($sql, array($item_id, $name, $email, $comment, $status, $createdDate));
		if($query){
			return true;
		}else{
			return false;
		}
	}
	
	function update($id, $name, $email, $body){
		
		$sql = "UPDATE comments SET name=?, email=?, body=?  WHERE id=?";
		$query = $this->db->query($sql, array($name, $email, $body, $id));
		return true;
	
	}
	
	
	function getComments($limit=0, $offset=0){
		$this->db->order_by("createdDate", "desc");
		$query = $this->db->get("comments", $limit, $offset);
		return $query->result();
	}
	
	function getSubscribers(){
		$sql = "SELECT * FROM newsletter WHERE status=1";
		$query = $this->db->query($sql);
		$result = $query->result();
		if(!empty($result)){
			return $result;
		}else{
			return false;
		}
	}
	
	
	function getNumRows(){
		//$this->db->where(array("entry_state_id >" => 1, "entry_type_id"=> $entry_type_id));
		$number = $this->db->count_all_results('comments');
		return $number;
	
	}
	
	function delete($id){
		$sql = "UPDATE comments SET status=-1 WHERE id=?";
		$query = $this->db->query($sql, array($id));
		return true;
  	}
	
	function publish($id){
  		$published = date('Y-m-d H:i:s');
		$sql = "UPDATE comments SET status=1 WHERE id=?";
		$query = $this->db->query($sql, array($id));
		return true;
  	}
  	
  	function unpublish($id){
		$sql = "UPDATE comments SET status=0 WHERE id=?";
		$query = $this->db->query($sql, array($id));
		return true;
  	}
  	
  	function get_entry($type_id){
  		$sql = "SELECT * FROM entries WHERE type_id=?";
		$query = $this->db->query($sql, array($type_id));
		$result = $query->first_row();
		if(!empty($result)){
			return $result;
		}else{
			return false;
		}
  	}
  	
  	function get_story($id){
  		$sql = "SELECT * FROM stories WHERE id=?";
		$query = $this->db->query($sql, array($id));
		$result = $query->first_row();
		//print_r($result);
		if(!empty($result)){
			return $result;
		}else{
			return false;
		}
  	}
  	
  	function get_game($id){
  		$sql = "SELECT * FROM games WHERE id=?";
		$query = $this->db->query($sql, array($id));
		$result = $query->first_row();
		if(!empty($result)){
			return $result;
		}else{
			return false;
		}
  	
  	}
  	
	function get_entry_title($type_id){
		$entry = $this->get_entry($type_id);
		
		if($entry->entry_type_id == 1){
			//print_r($entry->type_id);
			$entry_type = $this->get_story($type_id);
		}else{
			$entry_type = $this->get_game($type_id);
		}
		return $entry_type->title;
	}
	
	
}

/* End of file comments_model.php */
/* Location: ./application/controllers/comments_model.php */
