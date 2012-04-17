<?php
class Entry_type_model extends CI_Model {
	
function __construct(){
        // Call the Model constructor
        parent::__construct();
}

public function get_entry_types(){
	$query = $this->db->get_where("entry_types");
	return $query->result();
}
}