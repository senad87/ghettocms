<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		
	}
	
	function search($keyword, $offset=false, $limit=false){
			if($offset===false){
	  			$limit = "";
	  		}else{
	  			$limit = " LIMIT ".$offset.", ".$limit;
	  		}
			$sql = "SELECT * FROM stories WHERE headline LIKE ? OR title LIKE ? OR lead LIKE ? OR body LIKE ? ".$limit;
			$query = $this->db->query($sql, array("%".$keyword."%", "%".$keyword."%", "%".$keyword."%", "%".$keyword."%"));
		
			return $query->result();	
	}

	function countResults($keyword){
	
			$sql = "SELECT count(*) as count FROM stories WHERE headline LIKE ? OR title LIKE ? OR lead LIKE ? OR body LIKE ?";
			$query = $this->db->query($sql, array("%".$keyword."%", "%".$keyword."%", "%".$keyword."%", "%".$keyword."%"));
		
			return $query->first_row()->count;
	
	}
	
}

/* End of file search_model.php */
/* Location: ./application/modules/search/controllers/search_model.php */
