<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menus_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		
	}
	
	
    /**
	 * get_menu_kids
	 *
	 * Function get all active (non deleted) menus where parent_id = id param
	 * If $id param is 0 function get active ROOT Menus
	 * 
	 * @param int $id
	 * @param int $language_id
	 */
	public function get_menu_kids($id = 0, $language_id = 1){
		
		$this->db->order_by("ordering", "asc");
		$query = $this->db->get_where('menus', array('parent_id' => $id, "menu_state_id" => 3, "language_id" => $language_id));
		return $query->result();
	}
}

/* End of file menus_model.php */
/* Location: ./application/modules/menus/controllers/menus_model.php */
