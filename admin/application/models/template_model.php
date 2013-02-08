<?php

class Template_model extends CI_Model {

        function __construct(){
                // Call the Model constructor
                parent::__construct();
        }


		public function get_template_by_id($id){
			$query = $this->db->get_where('templates', array("id" => $id));
			return $query->result();
		}
        
        public function insert($name, $num_of_position, $file_name, $file_path, $active = 1){
			$this->db->insert('templates', array("name" => $name, "num_of_positions" => $num_of_position, "file_name"=>$file_name, "file_path" => $file_path, "active" => $active));
			return $this->db->insert_id();
		}
		
		public function get_templates_by_state($state){
			$query = $this->db->get_where('templates', array("active" => $state));
			return $query->result();
		}
		
		public function get_number_of_templates_by_state($state){
			$this->db->where(array("active" => $state));
			$number = $this->db->count_all_results('templates');
			return $number;
		}
		
		/**
		 * 
		 * Update column active to set value
		 * @param int $id
		 * @param int $active
		 */
		public function update_active($id, $active = 0){
			$data = array("active" => $active);
			$this->db->where('id', $id);
			$this->db->update('templates', $data);
		}

}