<?php
/**
 * Class is database layer and contain queries on admin_users table
 *
 * @author damir
 */
class Admin_Users_model extends CI_Model {

	function __construct(){
		// Call the Model constructor
		parent::__construct();
		
	}
        
        public function get( $id ){
            $this->db->select('*')->from('admin_users')
                     ->where( array( 'id' => $id) )->limit(1);
            return $this->db->get()->first_row();
        }
        
        
}

?>
