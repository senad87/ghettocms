<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banners_model extends CI_Model {

	function __construct(){
		// Call the Model constructor
		parent::__construct();
		$this->load->model('Entry_model');
	}
        
        public function insert( $name, $description, $url, $creation_date, $activation_date, $file_location, $state = 2, $language_id = 1 ){
            
            $data = array( 'name' => $name,
			   'description' => $description,
			   'url' => $url,
                           'creation_date' => $creation_date,
                           'activation_date' => $activation_date,
                           'file_location' => $file_location,
                           'state' => $state,
                           'language_id' => $language_id
                         );
            
            $this->db->insert('banners', $data);
            $banner_id = $this->db->insert_id();
            return $banner_id;
            
        }
        
        public function update( $item_id, $name, $description, $url, $activation_date, $file_location ){
            
		$data = array( 'name' => $name,
			   'description' => $description,
			   'url' => $url,
                           'creation_date' => $creation_date,
                           'activation_date' => $activation_date,
                           'file_location' => $file_location
                         );
                
		$this->db->where( array("id" => $item_id) );
		$this->db->update('banners', $data);
        }
        
        public function getBannerByID($id){
            $this->db->select('*')->from('banners')->where( array("id" => $id) )->limit(1);
            $query = $this->db->get();
            return $query->first_row();
        }
        
        /**
         * Function count banners with state Published and Unpublished
         * @return int number of banners
         */
        public function countActive($language_id = 1){
            $this->db->from('banners')->where( array( 'state >' => 1, 'language_id' => $language_id ) );
            return $this->db->count_all_results();
        }
        
        public function getActiveLimited( $limit, $offset, $return_array = 0 ){
            $this->db->select('*')->from('banners')->where( array( 'state >' => 1 ) )->limit( $limit, $offset );
            $query = $this->db->get();
            if($return_array == 1){
		return $query->result_array();
            }else{
		return $query->result();
            }
        }
        
        
        
        
}