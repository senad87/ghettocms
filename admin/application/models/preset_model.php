<?php

class Preset_model extends CI_Model {

	function __construct(){
	        // Call the Model constructor
	        parent::__construct();
	}
	
	public function get_preset($id){
		$query = $this->db->get_where("presets", array("id" => $id));
		return $query->first_row();
	} 
	/**
	 * 
	 * Insert data into preset table
	 * @param string $name
	 * @param string $description
	 * @param int $template_id
	 * @param int $state_id
	 * @param int $language_id
	 */
	public function insert($name, $description, $template_id, $state_id = 1, $language_id = 1){
		
		$data = array("name" => $name,
					  "description" => $description,
					  "template_id" => $template_id,
					  "state_id" => $state_id,
		              "language_id" => $language_id
					 );
					 
		$this->db->insert('presets', $data);
		return $this->db->insert_id();
	
	}
	
	/**
	 * 
	 * Insert data into join_preset_module_position
	 * @param int $preset_id
	 * @param int $position_id
	 * @param int $module_id
	 */
	public function insert_join($preset_id, $position_id, $module_id){
		$data = array("preset_id" => $preset_id,
					  "position_id" => $position_id,
					  "module_id" => $module_id
					  );
		$this->db->insert('join_preset_module_position', $data);
	}
	
	/**
	 * 
	 * Get modules postions by selected preset_id
	 * @param int $preset_id
	 */
	public function get_join($preset_id){
		$query = $this->db->get_where("join_preset_module_position", array("preset_id" => $preset_id));
		return $query->result();
	}
	
	public function get_number($active = 1, $language_id = 1){
		
		$this->db->where(array("state_id" => $active, "language_id" => $language_id));
		$number = $this->db->count_all_results('presets');
		return $number;
	
	}
	
	public function get_limited_list($active = 1, $language_id = 1, $limit = 10, $offset = 0){
		$this->db->order_by("id", "desc");
		$query = $this->db->get_where("presets", array("state_id" => $active, "language_id" => $language_id), $limit, $offset);
		return $query->result();
	}
}