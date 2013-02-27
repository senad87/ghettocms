<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Entry_images_model extends CI_Model {
    protected $db_model;
    protected $entry;


    function __construct()
	{
		parent::__construct();	
	}
        
        public function init( $db_model, $entry ){
            $this->db_model = $db_model;
            $this->entry = $entry;
        }
        
        /**
         * Get entry image by specified dimensions
         * @param int $dimension
         * @return object on success or FALSE if entry does not have image with 
         * dimension provided
         */
        public function getImageByDim( $dimension ){
            $images = $this->db_model->get_images_by_entry_id( $this->entry->id );
            $images_arr = array();
            foreach ( $images as $images ){
                $images_arr[] = $images->image_id;
            }
            
            if( is_array( $images_arr ) and count( $images_arr ) > 0 ){
                return $this->db_model->getImagesByDimension( $images_arr, $dimension );
            }else{
                return FALSE;
            }
        }
        
        
}