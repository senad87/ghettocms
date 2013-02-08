<?php

class Action_model extends CI_Model {

	private $id;
	private $name;
	
	function __construct(){
	        // Call the Model constructor
	        parent::__construct();
	}
	
	public function get_action_by_id($id){
        	$query = $this->db->get_where('actions', array('id' => $id));
		return $query->result();
	}
}
/* End of file action_model.php */
/* Location: ./system/application/models/action_model.php */
