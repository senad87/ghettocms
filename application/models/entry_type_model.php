<?php

class Entry_type_model extends CI_Model {

    function __construct(){
            // Call the Model constructor
            parent::__construct();
    }
    
    public function getTypeByID( $id ){
        $this->db->select('*')->from('entry_types')->where( 'id', $id )->limit(1);
        $result = $this->db->get()->first_row();
        return $result;
    }
    
    public function getTypeByName( $name ){
        $this->db->select('*')->from('entry_types')->where( 'name', $name )->limit(1);
        $result = $this->db->get()->first_row();
        return $result;
    }
}