<?php

class Entry_state_model extends CI_Model {

	function __construct(){
	        // Call the Model constructor
	        parent::__construct();
	}
	
	public function get_entry_state_name_by_state_id($id){
	
		$query = $this->db->get_where("entry_state",array("id"=>$id));
		return $query->result();
	}
	
	public function get_story_states(){
		$query = $this->db->get("entry_state");
		return $query->result();
	}
	
	/**
	 * Get entry state name by state id
	 * 
	 * @param int $id
	 * @return string state_name
	 */
	public function getStateName($id){
		
		$query = $this->db->get_where("entry_state",array("id"=>$id));
		return $query->first_row()->state_name;
		
	}

}
/* End of file story_state_model.php */
/* Location: ./system/application/models/story_state_model.php */
