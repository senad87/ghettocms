<?php

class Admin_user_model extends CI_Model {

	function __construct(){
	        // Call the Model constructor
	        parent::__construct();
           $this->load->library('phpass');
	}
	
	/**
	 * insert_new_user
	 *
	 * Function inssert new user into database and return id of inserted user
	 * do password sha1 and create register_date and last_access_date
	 *
	 * @param string $name
	 * @param string $username
	 * @param string $password
	 * @param int $group_id
	 * @param string $email
	 @ @return int $id User id, auto_increment from database
	 */
	public function insert_new_user($name, $username, $password, $role_id, $email = ""){
		//$password = sha1($password);
      $password = $this->phpass->hash($password);
		$register_date = date('Y-m-d G:i:s');
		$last_access_date = $register_date;
		$data = array(
	                       'name' => $name,
	                       'username' => $username,
	                       'password' => $password,
	                       'group_id' =>  $role_id,
	                       'email' => $email,
	                       'register_date' => $register_date,
	                       'last_access_date' => $last_access_date
	                    );

	        $this->db->insert('admin_users', $data); 
	        return $this->db->insert_id();
	
	}
	
	/**
	 * get_number_of_rows_with_username
	 *
	 * Function return number of users with given username, used for check if username 
	 * exists in database
	 *
	 * @param string $username
	 * @return int $number Number of users with that username 
	 */
	public function get_number_of_rows_with_username($username){
		
		$this->db->where(array('username'=>$username,'active'=>1));
		$number = $this->db->count_all_results('admin_users');
		return $number;
	}
	
	/**
	 * get_all_users
	 *
	 * This function return all users from table admin_users
	 *
	 */
	public function get_all_users(){
		$query = $this->db->get_where("admin_users",array("active"=>1));
		return $query->result();
	}
	
	/**
	 * get_all_users_limited
	 *
	 * This function return limited list of users from table admin_users
	 *
	 * @param int $limit Number of rows to be returned
	 * @param int $offset 
	 */
	public function get_all_users_limited($limit = 10, $offset = 0){
		$query = $this->db->get_where("admin_users",array("active"=>1), $limit, $offset);
		return $query->result();
	}
	
	/**
	 * get_role_by_role_id
	 *
	 * This function return group name by group id (table roles renamed to groups)
	 *
	 * @param int $role_id 
	 */
	 public function get_role_by_role_id($role_id){
		$query = $this->db->get_where('groups',array("id"=>$role_id));
		$role = $query->result();
		return $role[0]->name;
	 }
	 
	 /**
	  * get_all_roles
	  *
	  * Function return avalabile roles in system
	  * @return array of objects Every object in array contain role $id and $name
	  */
	 public function get_all_roles(){
		$query = $this->db->get_where('groups');
		return $query->result();
	}
	
	public function update_user_state($id, $state_id){
		$data = array("active" => $state_id);
		$this->db->where('id', $id);
		$this->db->update('admin_users', $data);
	}
	
	public function update_user_data($id, $name, $username, $password, $group_id, $email = ""){
		$password = sha1($password);
		$data = array(
	                       'name' => $name,
	                       'username' => $username,
	                       'password' => $password,
	                       'group_id' =>  $group_id,
	                       'email' => $email
	                    );

	        $this->db->where('id', $id);
	        $this->db->update('admin_users', $data); 
	        //return $this->db->insert_id();
	
	}
	
	public function update_user_data_no_password($id, $name, $username, $group_id, $email){
	$data = array(
	                       'name' => $name,
	                       'username' => $username,
	                       'group_id' =>  $role_id,
	                       'email' => $email
	                    );

	        $this->db->where('id', $id);
	        $this->db->update('admin_users', $data); 
	
	}
	
	public function get_user_by_id($user_id){
		$query = $this->db->get_where("admin_users",array("id"=>$user_id));
		return $query->result();
	}
	
	public function get_user_by_username_and_password($username, $password){
		$password = sha1($password);
      //$user = $this->get_user_by_username($username);
		$query = $this->db->get_where("admin_users",array("username"=>$username, "password"=>$password));
		return $query->result();
	}
   
   public function get_user_by_username($username){
		$query = $this->db->get_where("admin_users",array("username"=>$username));
		return $query->row();
	}
	/**
	 * get_user_privileges_by_group_id
	 *
	 * Get all privileges id from intersection table by group_id
	 *
	 * @param int $group_id
	 *
	 */
	public function get_user_privileges_by_group_id($group_id){
		
		$this->db->select('privilege_id');
		$query = $this->db->get_where("join_groups_privileges",array("group_id"=>$group_id, "status"=>1));
		$result_array = array();
		foreach($query->result() as $row){
			$result_array[] = $row->privilege_id;
		}
		//var_dump($result_array);
		return $result_array;
	
	}
	
}
/* End of file admin_user_model.php */
/* Location: ./system/application/models/admin_user_model.php */
