<?php

class Module_model extends CI_Model {

	function __construct(){
	        // Call the Model constructor
	        parent::__construct();
	}
	
	public function get_module_by_id($id){
		$query = $this->db->get_where('modules', array("id"=>$id));
		return $query->result();
	}
	
	public function get_all_modules($language_id = 1){
		$query = $this->db->get_where('modules', array("language_id" => $language_id));
		return $query->result();
	}
	
	public function get_by_module($module, $language_id = 1){
		$query = $this->db->get_where('modules', array("module"=>$module, "language_id" => $language_id));
		return $query->result();
	}
	
	public function insert($title, $description, $module, $menu_id, $position_id, $language_id, $params){
		
		$created = date('Y-m-d G:i:s');
		$modified = date('Y-m-d G:i:s');
		$published = date('Y-m-d G:i:s');
		
		$data = array('title' => $title ,
	                  'description' => $description,
					  'module' => $module,
					  'params' => $params,
					  'created' => $created,
					  'modified' => $modified,
					  'published' => $published,
					  'language_id' => $language_id 	
	                 );

        $this->db->insert('modules', $data); 
        $module_id = $this->db->insert_id();
        var_dump( $module_id );
        $this->db->insert('join_menu_module_position', array("menu_id" => $menu_id, "position_id" => $position_id, "module_id" => $module_id));
		
        return $module_id;
	}
	
	/**
	 * 
	 * Insert module with all data into modules table
	 * @param string $title
	 * @param string $description
	 * @param string $module
	 * @param string $menu_id
	 * @param string $position_id
	 * @param string $params
	 */
	public function insert_data($title, $description, $module, $params){
		$created = date('Y-m-d G:i:s');
		$modified = date('Y-m-d G:i:s');
		$published = date('Y-m-d G:i:s');
		
		$data = array('title' => $title ,
	                  'description' => $description,
					  'module' => $module,
					  'params' => $params,
					  'created' => $created,
					  'modified' => $modified,
					  'published' => $published 	
	                 );

        $this->db->insert('modules', $data); 
        return $this->db->insert_id();
	}
	
	public function update($title, $description, $module, $menu_id, $position_id, $params){
		$created = date('Y-m-d G:i:s');
		$modified = date('Y-m-d G:i:s');
		$published = date('Y-m-d G:i:s');
		
		$data = array('title' => $title ,
	                  'description' => $description,
					  'module' => $module,
					  'params' => $params,
					  'created' => $created,
					  'modified' => $modified,
					  'published' => $published 	
	                 );

        $this->db->insert('modules', $data); 
        $module_id = $this->db->insert_id();
        $update_data = array("module_id" => $module_id);
		$this->db->where(array('menu_id'=>$menu_id, 'position_id' => $position_id));
		$this->db->update('join_menu_module_position', $update_data);
		
		return $module_id;
	}
	
	public function update_module_instance($title, $description, $menu_id, $position_id, $module_id, $params){
		$created = date('Y-m-d G:i:s');
		$modified = date('Y-m-d G:i:s');
		$published = date('Y-m-d G:i:s');
		
		$data = array('title' => $title ,
	                  'description' => $description,
					  'params' => $params,
					  'modified' => $modified 	
	                 );
	    
	    $this->db->where(array('id'=>$module_id));
		$this->db->update('modules', $data);
	}
	
	public function delete(){
		
	}
	
	public function get_module_position_by_menu_id($id){
		$query = $this->db->get_where('join_menu_module_position', array("menu_id"=>$id, "active"=>1));
		return $query->result();
	}
	
	public function get_module_by_menu_and_position($menu_id, $position_id){
		$query = $this->db->get_where('join_menu_module_position', array("menu_id"=>$menu_id, "position_id"=>$position_id, "active"=>1));
		return $query->result();
	}
	
	public function update_join($menu_id, $position_id, $module_id){
		$data = array('module_id' => $module_id);
		$this->db->where(array('menu_id'=>$menu_id, 'position_id' => $position_id));
		$this->db->update('join_menu_module_position', $data);
	}
	
	public function insert_join($menu_id, $position_id, $module_id){
		$data = array("menu_id" => $menu_id,
					  "position_id" => $position_id,
					  "module_id" => $module_id
					  );
		$this->db->insert('join_menu_module_position', $data);
	}
}