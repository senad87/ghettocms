<?php

class Tag_model extends CI_Model {

	private $id;
	private $name;
	private $topic_id;
	private $active;
	
	function __construct(){
	       
	        parent::__construct();
	}
	
	public function get_active_tags_by_topic_id($topic_id){
	
		$query = $this->db->get_where('tags', array('topic_id' => $topic_id, 'active'=>1));
		return $query->result();
	
	}
	
	public function get_active_tags(){
        	$query = $this->db->get_where('tags', array('active'=>1));
		return $query->result();
	
	}
	
	public function get_number_of_active_tags(){
		$this->db->where(array("active" => 1));
		$number = $this->db->count_all_results('tags');
		return $number;
	}
	
	public function get_active_tags_limited($limit = 10, $offset = 0){
		$this->db->order_by("id", "desc");    
		$query = $this->db->get_where("tags",array('active'=>1),$limit, $offset);
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
		return $query->first_row();
	
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
/* Location: ./system/application/modules/tag/models/tag_model.php */