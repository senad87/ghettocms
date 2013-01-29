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
        
        public function getImagesByDimension( $images, $dimension_id, $order_col = 'id', $order = 'ASC' ){
            
            $this->db->select('*')->from( 'images' )
                     ->where_in( 'id', $images )
                     ->where( array('dimension_id' => $dimension_id) )
                     ->limit(1)
                     ->order_by( $order_col, $order );
            return $this->db->get()->result();
            
        }
}