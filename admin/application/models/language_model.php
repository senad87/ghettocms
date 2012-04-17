<?php

class Language_model extends CI_Model {
	
	function __construct(){
	        // Call the Model constructor
	        parent::__construct();
	}
	
	public function get_all(){
		$query = $this->db->get_where('languages', array("active" => 1));
		return $query->result();
	}
	
	public function get_by_id($id){
		$query = $this->db->get_where('languages', array("id" => $id));
		if(count($query->result()) > 0){
			return $query->first_row();
		}else{
			return FALSE;
		}
	}
}
