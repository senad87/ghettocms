<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		
	}

	/**
	 * 
	 * get menu by given menu id
	 * @param int $id
	 */
	public function get_menu_by_id($id){
		$query = $this->db->get_where('menus', array('id' => $id));
		return $query->result();
	}
	
	public function get_home_menu($language_id = 1){
		$query = $this->db->get_where('menus', array('home' => 1, 'menu_state_id' => 3, 'language_id' => $language_id));
		return $query->result();
	}
	
	public function get_home_id($language_id = 1){
		$this->db->select('id');
		$query = $this->db->get_where('menus', array('home' => 1, 'language_id' => $language_id));
		$result = $query->first_row();
		return $result->id;
	}
	
 	public function get_home_modules($menu_id){
		$query = $this->db->get_where('join_menu_module_position', array('menu_id '=> $menu_id, 'active' => 1));
		return $query->result();
	}
	
	public function getNameByID($id){
		$this->db->select('name');
		$query = $this->db->get_where('menus', array('id' => $id));
		return $query->first_row();
	}
}	
