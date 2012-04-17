<?php

class Story_model extends CI_Model {

	function __construct(){
		// Call the Model constructor
		parent::__construct();
		$this->load->model('Entry_model');
	}

	/**
	 * 
	 * Insert new story into database trough transaction, first insert data into stories table, than into entries table and than in join_entries_categories
	 * @param string $title
	 * @param string $lead
	 * @param string $body
	 * @param int $language_id
	 * @param int $category_id
	 * @param int $author_id
	 */
	public function insert($headline, $title, $lead, $body, $category_id, $tags_id = array(), $language_id = 1, $creation_date = "", $author_id = 0){

		if($creation_date == ""){
			$creation_date = date('Y-m-d G:i:s');
		}
		$modified_date = date('Y-m-d G:i:s');
		
		$data = array( 'headline' => $headline,
			       'lead' => $lead,
			       'body' => $body
			);
		
		//TODO: Check if this transaction realy works if works fine do implementation in all places
		$this->db->trans_start();
		$this->db->insert('stories', $data);
		$story_id = $this->db->insert_id();
		//insert into entries table, intersection table
		$entries_data = array("type_id" => $story_id, "entry_type_id" => 1, "title"=> $title, "creation_date" => $creation_date, "modified_date" => $modified_date, "admin_user_id" => $author_id, "category_id"=>$category_id, "language_id" => $language_id, "comments" => 1);
		$this->db->insert('entries', $entries_data);
		$entry_id = $this->db->insert_id();
		
		//insert into join_entries_tags only if have something to insert
		if(count($tags_id) > 0){
			foreach($tags_id as $tag_id) {
				if($tag_id > 0){
					$this->db->insert('join_entries_tags', array("entry_id" => $entry_id, "tag_id" => $tag_id));
				}
			}
		}
	
		$this->db->trans_complete();
		return $entry_id;
	}

	/**
	 * 
	 * Select all stories from stories table
	 */
	public function get_all_stories(){

		$query = $this->db->get("stories");
		$stories[] = array();
		return $query->result();
	}

	/**
	 * 
	 * Get all story data
	 * @param int $story_id
	 */
	public function get_story_by_id($story_id){
		$query = $this->db->get_where("stories",array("id"=>$story_id));
		return $query->result();
	}

	/**
	 * 
	 * Update stories table
	 * @param int $id
	 * @param string $headline
	 * @param string $lead
	 * @param string $body
	 */
	public function update_story_data($id, $headline, $lead, $body){
		$data = array("headline" => $headline, "lead" => $lead, "body" => $body);
		$this->db->where('id', $id);
		$this->db->update('stories', $data);
	}

	/**
	 * 
	 * Get all stories from category with category_id
	 * @param int $category_id
	 */
	public function get_stories_by_category_id($category_id){
		$query = $this->db->get_where("join_entries_categories",array("category_id"=>$category_id));
		return $query->result();
	}
	
}
/* End of file story_model.php */
/* Location: ./system/application/models/story_model.php */
