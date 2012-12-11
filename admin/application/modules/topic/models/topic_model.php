<?php

class Topic_model extends CI_Model {

	function __construct(){
		// Call the Model constructor
		parent::__construct();
	}

	public function insert($name, $description = "", $entry_type_id = 0, $language_id = 1){
		$data = array('name' => $name,
                      	      'description' => $description,
			      'entry_type_id' => $entry_type_id,
			      'language_id' => $language_id);
		
		$this->db->insert('topics', $data);
	}

	public function get_active($limit = 10, $offset = 0, $language_id = 1, $return_array = 0){
		$query = $this->db->get_where('topics', array('active' => 1, "language_id" => $language_id), $limit, $offset);
		if($return_array == 1){
			return $query->result_array();
		}else{
			return $query->result();
		}
	}

	public function get_all_active($language_id = 1, $return_array = 0){
		$query = $this->db->get_where('topics', array('active' => 1, 'language_id' => $language_id));
		if($return_array == 1){
			return $query->result_array();
		}else{
			return $query->result();
		}
	}

	public function get_number_of_active($language_id = 1){
		
		$query = $this->db->where(array('active' => 1, 'language_id' => $language_id));
		return $this->db->count_all_results('topics');
		 
	}

	public function get_number_of_rows_with_name($name){
		$this->db->where(array('name'=>$name,'active'=>1));
		return $this->db->count_all_results('topics');
	}

	

	public function update($id, $name, $description, $entry_type){
		$data = array("name" => $name, "description" => $description, "entry_type_id" => $entry_type);
		$this->db->where('id', $id);
		$this->db->update('topics', $data);
	}

	public function delete($id, $active){
		$data = array("active" => $active);
		$this->db->where('id', $id);
		$this->db->update('topics', $data);
	}

	public function get_topic_by_id($id){
		$query = $this->db->get_where('topics', array('id' => $id));
		return $query->result();
	}

	public function get_topic_by_name($name){
		$sql = "SELECT * FROM topics WHERE LOWER(name) = ? AND active = 1 LIMIT 1";
		// $query = $this->db->get_where('topics', array('name' => $name, 'active'=>1));
		$query = $this->db->query($sql, array($name));
		$result = $query->result();
		return $result[0];
	}
	
	/**
	 * 
	 * Create new system topic by inserting data into system_topics table
	 * 
	 * @param int $topic_id
	 * @param int $entry_type_id
	 * @param int $language_id
	 */
	public function insert_system($topic_id, $entry_type_id, $language_id = 1){
		$data = array('topic_id' => $topic_id,
                      'entry_type_id' => $entry_type_id,
			          'language_id' => $language_id);
		
		$this->db->insert('system_topics', $data);
	}
	
	/**
	 * Activate or deactivate existing system topic
	 * @param int $active
	 */
	public function update_system($id, $active){
		$data = array('active' => $active);
		$this->db->where(array('topic_id' => $id));
		$this->db->update('system_topics', $data);
	}
	
	public function deactivate_all_systems($type){
		$data = array('active' => 0);
		$this->db->where(array('entry_type_id' => $type));
		$this->db->update('system_topics', $data);
	}
	
	/**
	 *
	 * System topics are topics displayed on the entry type ($entry_type_id) form
	 * we are using this type of topics as additional params for entries as Genre, Platform etc. for Game entry type
	 * 
	 * @param int $entry_type_id
	 */
	public function get_system($entry_type_id = 1, $language_id = 1, $result_array = FALSE, $all = FALSE){
		/*print_r("<pre>");
		var_dump($entry_type_id);
		var_dump($language_id);
		var_dump($result_array);
		var_dump($all);
		print_r("</pre>");*/
		if($all){
			$query = $this->db->get_where('system_topics', array('entry_type_id' => $entry_type_id, 'language_id' => $language_id));
		}else{
			//echo "Get active";
			$query = $this->db->get_where('system_topics', array('entry_type_id' => $entry_type_id, 'language_id' => $language_id, 'active' => 1));
		}
		
		if($result_array){
			return $query->result_array();
		}else{
			return $query->result();
		}
	}

	/**
	 *
	 * TODO:Enter desc
	 * @param int $id
	 */
	public function get_entry_type_by_topic_id($id){
		$query = $this->db->get_where('topics', array('id' => $id));
		return $query->result();
	}

	/**
	 * Get topics by entry_type_id, tags of this topic are populating from titles of entry type (stories, games, articles etc.)
	 *
	 * @param int $entry_type_id
	 */
	public function get_linked_topic($entry_type_id){
		$query = $this->db->get_where('topics', array('entry_type_id' => $entry_type_id, 'active' => 1));
		return $query->result();
	}

}
/* End of file topic_model.php */
/* Location: ./system/application/modules/models/topic_model.php */
