<?php

class Group_model extends CI_Model {

	private $id;
	private $name;

	function __construct(){
	        // Call the Model constructor
	        parent::__construct();
	}
	
	public function get_group_by_id($id){
		$query = $this->db->get_where('groups', array('id' => $id));
		return $query->result();
	}
	/**
	 * get_all_groups
	 *
	 * Get all groups from groups table
	 */
	public function get_all_groups(){
        	$query = $this->db->get_where('groups', array("state"=>1));
        	return $query->result();
	}
	
	/**
	 * get_all_groups_limited
	 *
	 * Get all groups from groups table
	 */
	public function get_all_groups_limited($limit = 10, $offset = 0){
        	$query = $this->db->get_where('groups', array("state"=>1), $limit, $offset);
        	return $query->result();
	}
	
	/**
	 * update_name_by_id
	 *
	 * Update, change user group name by id
	 */
	public function update_name_by_id($id, $name){
		$data = array("name" => $name);
        	$this->db->where(array('id'=>$id));
        	$this->db->update('groups', $data);
	}
	
	public function insert($group_name){
	
                $insert_data = array("name" => $group_name);
                $this->db->insert('groups', $insert_data);
                $group_id = $this->db->insert_id();
                return $group_id;
	
	}
	
	public function update_group_state($id, $state){
		$data = array("state" => $state);
        	$this->db->where(array('id'=>$id));
        	$this->db->update('groups', $data);
	}
}
/* End of file group_model.php */
/* Location: ./system/application/models/group_model.php */
