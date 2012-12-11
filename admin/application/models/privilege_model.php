<?php

class Privilege_model extends CI_Model {

	private $id;
	private $action_id;
	private $subject_type_id;
	private $subject_id;
	
	function __construct(){
	        // Call the Model constructor
	        parent::__construct();
	}
	
	public function get_privilege_id_by_group_id($id){
		$query = $this->db->get_where('join_groups_privileges', array('group_id' => $id, 'status' => 1));
		return $query->result();
	}

	public function get_existing_privileges_by_group_id($id){
		$query = $this->db->get_where('join_groups_privileges', array('group_id' => $id));
		return $query->result();
	}
	

	/**
	 * update_privilege_status
	 *
	 * Function update status of the relation group - privilege, 1 set or 0 no privilege for group 
	 * @param int $id Id of the group
	 * @param int $privilege_id Id of the privilege
	 * @param int $status Status of the privilege, is it assign to the user group or not
	 */
	
	public function update_privilege_status($id, $privilege_id, $status){
	
        	$data = array("status" => $status);
        	$this->db->where(array('group_id'=>$id, 'privilege_id'=>$privilege_id));
        	$this->db->update('join_groups_privileges', $data);
        		
	}
	
	/**
	 * update_privileges_status_by_group_id
	 *
	 * Function update status of all privileges of the user group with $group_id, assign or remove all privileges
	 * 
	 * @param int $group_id Id of the group
	 * @param int $status Status of the privilege, is it assign to the user group or not
	 */
	public function update_privileges_status_by_group_id($group_id, $status){
	
        	$data = array("status" => $status);
        	$this->db->where(array('group_id'=>$group_id));
        	$this->db->update('join_groups_privileges', $data);
	
	}
	
	public function insert_privilege_group($id, $privilege_id, $status){
	
                $insert_data = array("group_id" => $id, "privilege_id" => $privilege_id, 'status'=>$status);
                $this->db->insert('join_groups_privileges', $insert_data);
		
	}
	
	public function get_privilege_by_id($id){
		$query = $this->db->get_where('privileges', array('id' => $id));
		return $query->result();
	}
	
	public function get_all_privileges(){
       	$query = $this->db->get('privileges', array('active' => 1));
		return $query->result();
	}
	
	public function insert(){
	
	}
	
	public function update(){
	
	}
	
	public function delete(){
	
	}	
}	
/* End of file privilege_model.php */
/* Location: ./system/application/models/privilege_model.php */
