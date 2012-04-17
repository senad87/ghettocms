<?php 
class Client_model extends CI_Model {

	function __construct(){
	        // Call the Model constructor
	        parent::__construct();
	}
	
	public function get_all_clients(){
		$query = $this->db->get('clients');
		return $query->result();
	}
}