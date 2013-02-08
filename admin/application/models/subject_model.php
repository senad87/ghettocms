<?php

class Subject_model extends CI_Model {

	private $id;
	private $name;

	function __construct(){
	        // Call the Model constructor
	        parent::__construct();
	}
	
	public function get_all_subjects(){
        	$query = $this->db->get('subject');
        	return $query->result();
	}
	
	public function get_subject_by_id($id){
        	$query = $this->db->get_where('subject', array('id' => $id));
		return $query->result();
	}
}
/* End of file subject_model.php */
/* Location: ./system/application/models/subject_model.php */
