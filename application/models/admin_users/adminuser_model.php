<?php
/**
 * Description of admin_user_model
 *
 * @author damir
 */
class Adminuser_model extends CI_Model {

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
