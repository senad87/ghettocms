<?php

class Topic_model extends CI_Model {

	private $id;
	private $name;
	private $description;
	private $active;
	
	
	function __construct(){
	        parent::__construct();
	}
	
	/*public function insert($name, $description = "", $entry_type_id = 0){
        	$data = array(
                               'name' => $name,
                               'description' => $description,
			        	       'entry_type_id' => $entry_type_id
                            );

                $this->db->insert('topics', $data); 
	}*/
	
	public function get_active($limit = 10, $offset = 0){
        	$query = $this->db->get_where('topics', array('active' => 1), $limit, $offset);
        	return $query->result();
	}
	
	public function get_all_active(){
        	$query = $this->db->get_where('topics', array('active' => 1));
        	return $query->result();
	}
	
	public function get_number_of_active(){
        	$query = $this->db->where(array('active' => 1));
        	return $this->db->count_all_results('topics');
        	
	}
	
	public function get_number_of_rows_with_name($name){
	        $this->db->where(array('name'=>$name,'active'=>1));
		return $this->db->count_all_results('topics');
	}
	
	/**
	 * 
	 * System topics are topics displayed on the entry type ($entry_type_id) form
	 * we are using this type of topics as additional params for entries as Genre, Platform etc. for
	 * Game entry type
	 * 
	 * @param int $entry_type_id
	 */
	public function get_system($entry_type_id = 1){
	    $query = $this->db->get_where('system_topics', array('entry_type_id' => $entry_type_id, "active"=>1));
        return $query->result();
	}
	
	public function update_system($topic_id, $entry_type_id){
		/*$data = array("name" => $name, "description" => $description, "entry_type_id" => $entry_type);
		$this->db->where('id', $id);
		$this->db->update('topics', $data);*/
	}
	
	public function get_deleted(){
	
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
		$query = $this->db->get_where('topics', array('entry_type_id' => $entry_type_id));
        return $query->result();
	}
	
}
/* End of file topic_model.php */
/* Location: ./system/application/modules/tags/models/topic_model.php */