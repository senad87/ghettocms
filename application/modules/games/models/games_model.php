<?php

class Games_model extends CI_Model {   
   	
   	function __construct(){
                // Call the Model constructor
                parent::__construct();
        }
        
		/**
         * 
         * Get all game data by id
         * @param int $id
         */
        public function getGameByID($id){
        	$query = $this->db->get_where("games",array("id"=>$id));
	        return $query->first_row();
        }
        
            
}
