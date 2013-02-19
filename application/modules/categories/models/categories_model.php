<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		
	}
	
	/**
	 * 
	 * Get only active categories for entry_id, entry belong to those categories
	 * @param int $entry_id
	 */
	public function get_categories_by_entry_id($entry_id){
		$query = $this->db->get_where('join_entries_categories',array('entry_id'=>$entry_id, "active"=>1));
	        return $query->result();
	}
	
	public function get_category_by_id($id){
	        $query = $this->db->get_where('categories',array('id'=>$id));
	        return $query->result();
	}
	
	/**
	 * 
	 * @param int $id
	 * @return object of categories class
	 */
	public function getCategoryByID($id){
	        $query = $this->db->get_where('categories',array('id'=>$id));
	        return $query->first_row();
	}
        
	
	public function getCategoryName($id){
		$this->db->select('name');
		$query = $this->db->get_where('categories',array('id'=>$id));
	    return $query->first_row();
	}
	
	/**
	 * get_category_kids
	 *
	 * Function get all active (non deleted) categories where parent category id is id param
	 * If $id param is 0 function get active ROOT Categories
	 *
	 * @param int $id
	 */
	public function get_category_kids($id = 0, $language_id = 1){

		$this->db->select('id, name');
		$query = $this->db->get_where('categories', array('parent_id' => $id, "active" => 1, "language_id" => $language_id));
		return $query->result();

	}
}
/* End of file articles_model.php */
/* Location: ./application/modules/articles/controllers/articles_model.php */
