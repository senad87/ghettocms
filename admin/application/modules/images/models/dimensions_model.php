<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dimensions_model extends CI_Model {

	function __construct(){
            // Call the Model constructor
            parent::__construct();
	}
        
        /**
         * Get dimension params by ID
         * @param int $id
         * @return boolean
         */
        public function get( $id ){
            $this->db->select('*')->from('dimensions')->where( array("id" => $id) )->limit(1);
            $query = $this->db->get();
            $result = $query->first_row();
            if( !empty($result) ) {
                return $result;
            } else {
                return false;
            }
        }
        
        public function getByName( $name = "large" ){
            $this->db->select('*')->from('dimensions')->where( array("name" => $name) )->limit(1);
            $query = $this->db->get();
            $result = $query->first_row();
            if( !empty($result) ) {
                return $result;
            } else {
                return false;
            }
        }
}        