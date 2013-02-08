<?php

class Module_instance_model extends CI_Model {

	function __construct(){
	        // Call the Model constructor
	        parent::__construct();
	}
	
	public function get_all_module_instances($module_id){
		$query = $this->db->get_where('module_instances',array("module_id" => $module_id));
		return $query->result();
	}
	public function insert($title, $params, $module_id, $active = 1){
		$data = array('title' => $title ,
	                  'params' => $params,
					  'module_id' => $module_id,
					  'active' => $active
	                 );
	
        $this->db->insert('module_instances', $data); 
        return $this->db->insert_id();
	}
	
	public function update(){
		
	}
	
	public function delete(){
		
	}
}
