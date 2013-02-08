<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	public function get_user_by_id($user_id){
		$query = $this->db->get_where("admin_users",array("id"=>$user_id));
		$result = $query->first_row();
		if(!empty($result)){
			return $result;
		}else{
			return false;
		}
	}
}

/* End of file users_model.php */
/* Location: ./application/modules/articles/controllers/users_model.php */
