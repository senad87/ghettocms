<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Position_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		
	}
	
	public function get_module_by_menu_and_position($menu_id, $position_id, $entry_page = 0){
		$query = $this->db->get_where('join_menu_module_position', array("menu_id"=>$menu_id, "position_id"=>$position_id, "entry_page"=>$entry_page, "active"=>1));
		return $query->result();
	}

	public function get_module_by_id($id){
		$query = $this->db->get_where('modules', array("id"=>$id));
		return $query->result();
	}
}

/* End of file menus_model.php */
/* Location: ./application/modules/menus/controllers/menus_model.php */