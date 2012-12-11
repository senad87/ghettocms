<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Images_model extends CI_Model {

	function __construct()
	{
		parent::__construct();	
	}
	
	/**
	 * 
	 * Get all images related to entry
	 * @param int $entry_id
	 */
	public function get_images_by_entry_id($entry_id){
		$query = $this->db->get_where("join_entries_images",array("entry_id"=>$entry_id, "active"=>1));
		return $query->result();
	}

	public function get_image($id){
		$query = $this->db->get_where("images",array("id"=>$id));
		return $query->result();
	}
}