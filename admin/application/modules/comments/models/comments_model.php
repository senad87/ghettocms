<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comments_model extends CI_Model {

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
	
	function getComments($limit=0, $offset=0, $order){
		$this->db->order_by($order[0], $order[1]);
		$query = $this->db->get_where("comments", array("status !=" => -1), $limit, $offset);
		return $query->result();
	}
	
	function getComment($id){
		$sql = "SELECT * FROM comments WHERE id=?";
		$query = $this->db->query($sql, array($id));
		$result = $query->first_row();
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
		$sql = "UPDATE comments SET status=1 WHERE id=?";
		$query = $this->db->query($sql, array($id));
		return true;
  	}
	
	function publish($id){
  		$published = date('Y-m-d H:i:s');
		$sql = "UPDATE comments SET status=3 WHERE id=?";
		$query = $this->db->query($sql, array($id));
		return true;
  	}
  	
  	function unpublish($id){
		$sql = "UPDATE comments SET status=2 WHERE id=?";
		$query = $this->db->query($sql, array($id));
		return true;
  	}
  	
  	function get_entry($type_id){
  		$sql = "SELECT * FROM entries WHERE id=?";
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
		if($entry){
			if($entry->entry_type_id == 1){
				$entry_type = $this->get_story($type_id);
			}else{
				$entry_type = $this->get_game($type_id);
			}
			return $entry->title;
		}else{
			return false;
		}
	}
}

/* End of file comments_model.php */
/* Location: ./application/controllers/comments_model.php */