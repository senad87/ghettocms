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
			$sql = "SELECT entries.title, entries.creation_date, stories.* FROM stories,entries WHERE (entries.entry_state_id=3 AND entries.type_id=stories.id AND entries.entry_type_id=1) AND (headline LIKE ? OR title LIKE ? OR lead LIKE ? OR body LIKE ? ) ".$limit;
			$query = $this->db->query($sql, array("%".$keyword."%", "%".$keyword."%", "%".$keyword."%", "%".$keyword."%"));
			$result = $query->result();
			if(!empty($result)){
				return $result;
			}else{
				return false;
			}
	}

	function countResults($keyword){
	
			$sql = "SELECT count(*) as count FROM stories,entries WHERE (entries.entry_state_id=3 AND entries.type_id=stories.id AND entries.entry_type_id=1) AND (headline LIKE ? OR title LIKE ? OR lead LIKE ? OR body LIKE ?) ";
			$query = $this->db->query($sql, array("%".$keyword."%", "%".$keyword."%", "%".$keyword."%", "%".$keyword."%"));
		
			return $query->first_row()->count;
	
	}
	
}

/* End of file search_model.php */
/* Location: ./application/modules/search/controllers/search_model.php */
