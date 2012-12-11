<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Languages_model extends CI_Model {

	function __construct()
	{
		parent::__construct();	
	}

	public function get_all(){
		
		$query = $this->db->get('languages');
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