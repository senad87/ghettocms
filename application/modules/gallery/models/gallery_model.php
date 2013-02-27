<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gallery_model extends CI_Model {

	function __construct(){
		// Call the Model constructor
		parent::__construct();
		$this->load->model('Entry_model');
	}

	/**
	 * 
	 * Insert new gallery into database trough transaction, first insert data into stories table, than into entries table and than in join_entries_categories
	 * @param string $title
	 * @param string $lead
	 * @param string $body
	 * @param int $language_id
	 * @param int $category_id
	 * @param int $author_id
	 */
	public function insert($title, $lead, $category_id, $tags_id = array(), $language_id = 1, $creation_date = "", $author_id = 0){

		if($creation_date == ""){
			$creation_date = date('Y-m-d G:i:s');
		}
		$modified_date = date('Y-m-d G:i:s');
		
		$data = array( 'lead' => $lead );
		
		//TODO: Check if this transaction realy works if works fine do implementation in all places
		$this->db->trans_start();
		$this->db->insert('galleries', $data);
		$gallery_id = $this->db->insert_id();
		//insert into entries table, intersection table
		$entries_data = array("type_id" => $gallery_id, "entry_type_id" => 3, "title"=> $title, "creation_date" => $creation_date, "modified_date" => $modified_date, "admin_user_id" => $author_id, "category_id"=>$category_id, "language_id" => $language_id, "comments" => 1);
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
	 * Get all gallery data
	 * @param int $gallery_id
	 */
	public function get_gallery_by_id($gallery_id){
		$query = $this->db->get_where("galleries",array("id"=>$gallery_id));
		return (array)$query->first_row();
	}
        
        public function getGalleryByID( $gallery_id ){
            $this->db->select('*')->from('galleries')
                              ->where( array( 'id' => $gallery_id ) )
                              ->limit(1);
            return $this->db->get()->first_row();
        }

	/**
	 * 
	 * Update stories table
	 * @param int $id
	 * @param string $headline
	 * @param string $lead
	 * @param string $body
	 */
	public function update_gallery_data($id, $lead){
		$data = array("lead" => $lead);
		$this->db->where('id', $id);
		$this->db->update('galleries', $data);
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
/* End of file gallery_model.php */
/* Location: ./system/application/models/gallery_model.php */
