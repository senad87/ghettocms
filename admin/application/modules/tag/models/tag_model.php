<?php

class Tag_model extends CI_Model {

	private $id;
	private $name;
	private $topic_id;
	private $active;
	
	function __construct(){
	        // Call the Model constructor
	        parent::__construct();
	}
	
	public function insert($tag, $topic_id, $language_id = 1){
	
		$insert_data = array("tag" => $tag, "topic_id" => $topic_id, "language_id" => $language_id);
                $this->db->insert('tags', $insert_data);
                $tag_id = $this->db->insert_id();
                return $tag_id;
	}
	
	public function get_active_tags_by_topic_id($topic_id){
	
		$query = $this->db->get_where('tags', array('topic_id' => $topic_id, 'active'=>1));
		return $query->result();
	
	}
	
	public function get_active_tags(){
        	$query = $this->db->get_where('tags', array('active'=>1));
		return $query->result();
	
	}
	
	public function get_number_of_active_tags($language_id = 1){
		$this->db->where(array("active" => 1, "language_id" => $language_id));
		$number = $this->db->count_all_results('tags');
		return $number;
	}
	
	public function get_active_tags_limited($limit = 10, $offset = 0, $language_id = 1){
		$this->db->order_by("id", "desc");    
		$query = $this->db->get_where("tags",array("active"=>1, "language_id" => $language_id), $limit, $offset);
		return $query->result();
	}
	
	public function get_number_of_active_tags_by_topic($topic_id){
		$this->db->where(array("active" => 1, "topic_id" => $topic_id));
		$number = $this->db->count_all_results('tags');
		return $number;
	}
	
	public function get_active_tags_by_topic_limited($topic_id, $limit, $offset){
		$this->db->order_by("id", "desc");    
		$query = $this->db->get_where("tags",array('active'=>1, "topic_id" => $topic_id),$limit, $offset);
		return $query->result();
	}
	
	public function get_tag_by_id($id){
        	$query = $this->db->get_where('tags', array('id'=>$id));
		return $query->result();
	
	}
	
	public function update($id, $tag, $topic_id){
        	$data = array("tag" => $tag, "topic_id" => $topic_id);
        	$this->db->where('id', $id);
        	$this->db->update('tags', $data);
	}
	
	public function delete($id){
        	$data = array("active" => 0);
        	$this->db->where('id', $id);
        	$this->db->update('tags', $data);
	
	}
	/**
	 * 
	 * Get all active tags for entry_id
	 * @param int $id ID of the entry, entry_id
	 */
	public function get_active_tags_by_entry_id($id){
		$query = $this->db->get_where('join_entries_tags', array('entry_id'=>$id, 'active'=>1));
		return $query->result();	
	}
	
	public function get_tags_by_entry_id($id){
		$query = $this->db->get_where('join_entries_tags', array('entry_id'=>$id));
		return $query->result();	
	}
	
	public function update_tags_state_by_entry_id($entry_id){
		$data = array("active" => 0);
		$this->db->where('entry_id', $entry_id);
        $this->db->update('join_entries_tags', $data);
	}
	
	public function update_join_state($entry_id, $tag_id, $active){
		$data = array("active" => $active);
		$this->db->where(array('entry_id' => $entry_id, 'tag_id' => $tag_id));
        $this->db->update('join_entries_tags', $data);
	}
	
	public function insert_entry_tag($entry_id, $tag_id){
		$insert_data = array("tag_id" => $tag_id, "entry_id" => $entry_id);
        $this->db->insert('join_entries_tags', $insert_data);
		
	}
	
	public function get_tag_by_name($tag){
		$query = $this->db->get_where('tags', array('tag'=>$tag));
		return $query->result();
	}
}	
/* End of file tag_model.php */
/* Location: ./system/application/models/tag_model.php */