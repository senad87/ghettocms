<?php

class Menu_model extends CI_Model {

	function __construct(){
	        // Call the Model constructor
	        parent::__construct();
	}
	
	/**
	 * get_menu_kids
	 *
	 * Function get all (non deleted) menus where parent_id = id param
	 * If $id param is 0 function get non deleted (published and unpublished) ROOT Menus
	 * 
	 * @param int $id
	 */
	public function get_menu_kids($id = 0, $language_id = 1){
		
		$this->db->order_by("ordering", "asc");
		$query = $this->db->get_where("menus", array("parent_id" => $id, "menu_state_id >" => 1, "language_id" => $language_id));
		return $query->result();
	}
	
	/**
	 * 
	 * Insert new menu into database
	 * @param int $parent_id
	 * @param string $name
	 * @param string $url
	 * @param int $language_id
	 */
	public function insert($parent_id, $name, $menu_type_id, $url = "", $open_in = 1, $language_id = 1){
			//get max of order for same parent id, get last menu in the list by order
			
		$max_order = $this->get_maxorder_by_parent_id($parent_id, $language_id);	
		if($max_order != NULL and $max_order != ""){
				$ordering = $max_order[0]->ordering + 1;
			}else{
				$ordering = 1;
			}
	        //end of the make order
	        $data = array(
	                       'parent_id' => $parent_id,
	                       'name' => $name,
	        			   'menu_type_id' => $menu_type_id,	
	                       'url' => $url,
	        			   'open_in' => $open_in,
	        			   'ordering' => $ordering,
	                       'language_id' =>  $language_id
	                    );
	
	        $this->db->insert('menus', $data); 
	        return $this->db->insert_id();
	}
	
	public function get_maxorder_by_parent_id($parent_id, $language_id = 1){
		$sql = "SELECT MAX(ordering) as ordering FROM menus WHERE parent_id = ? AND language_id = ? AND menu_state_id > 1";
		$query = $this->db->query($sql, array($parent_id, $language_id));
	    return $query->result();
	}
	
	public function get_minorder_by_parent_id($parent_id, $language_id = 1){
		$sql = "SELECT MIN(ordering) as ordering FROM menus WHERE parent_id = ? AND language_id = ? AND menu_state_id > 1";
		$query = $this->db->query($sql, array($parent_id, $language_id));
	    return $query->result();
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
	
	public function get_menu_modules($id){
		$query = $this->db->get_where('join_menu_module_position', array('menu_id' => $id, 'active' => 1));
		return $query->result();
	}
	
	/**
	 * 
	 * Update data of the menu by id
	 * @param int $id
	 * @param int $name
	 * @param int $url
	 */
	public function update($id, $name, $url){
		$data = array("name" => $name, "url"=>$url);
        $this->db->where('id', $id);
        $this->db->update('menus', $data);
	}
	
	public function update_item($id, $name, $url, $open_in, $menu_type_id, $parent_menu_id){
		$data = array("name" => $name, "url"=>$url, "open_in"=>$open_in, "menu_type_id" => $menu_type_id, "parent_id"=>$parent_menu_id);
        $this->db->where('id', $id);
        $this->db->update('menus', $data);
	}
	
	/**
	 * 
	 * Update menu ordering by menu id
	 * @param int $id
	 * @param int $ordering
	 */	
	public function update_ordering($id, $ordering){
		$data = array("ordering" => $ordering);
        $this->db->where('id', $id);
        $this->db->update('menus', $data);
	}
	
	/**
	 * 
	 * Get menu by parent_id and ordering
	 * @param int $parent_id
	 * @param int $ordering
	 */
	public function get_menu_by_ordering($parent_id, $ordering){
		$query = $this->db->get_where('menus', array('parent_id' => $parent_id, 'ordering' => $ordering, 'menu_state_id >' => 1));
		return $query->result();
	}
	
	public function get_menu_types(){
		$query = $this->db->get('menu_types');
		return $query->result();
	}
	
	public function update_template($id, $template_id){
		$data = array("template_id" => $template_id);
        $this->db->where('id', $id);
        $this->db->update('menus', $data);
	}
	
	public function delete($id){
		$data = array("menu_state_id" => 1);
        $this->db->where('id', $id);
        $this->db->update('menus', $data);
	}
	
	public function set_as_home($id, $language_id = 1){
		$data = array("home" => 0);
		$this->db->where('language_id', $language_id);
       	$this->db->update('menus', $data);
       	
       	$update_data = array("home" => 1);
       	$this->db->where(array('id' => $id, 'language_id' => $language_id));
        $this->db->update('menus', $update_data);
	}
	//TODO: Add language here
	public function get_home_id(){
		$this->db->select('id');
		$query = $this->db->get_where('menus', array('home' => 1));
		$result = $query->first_row();
		return $result->id;
	}
	
	/**
	 * 
	 * Get state name by state id from table menu_states
	 * @param unknown_type $id
	 */
	public function get_state_by_id($id){
		
		$query = $this->db->get_where('menu_states', array('id' => $id));
		return $query->result();
	
	}
	
	public function update_state($id, $menu_state_id){
		$update_data = array("menu_state_id" => $menu_state_id);
       	$this->db->where('id', $id);
        $this->db->update('menus', $update_data);
	}
}