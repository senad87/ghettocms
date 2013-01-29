<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Entry_state_model extends CI_Model {

//    private $id;
//    private $state_name;

    function __construct(){
            // Call the Model constructor
            parent::__construct();
    }
    
    public function getStateByName( $name ){
        
        $this->db->select('*')->from('entry_state')->where( 'state_name', $name )->limit(1);
        $state = $this->db->get()->first_row();
        return $state;
        
    }
    
}