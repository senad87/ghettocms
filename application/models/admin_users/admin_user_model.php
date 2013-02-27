<?php

/**
 * Entity class for Admin User
 *
 * @author damir
 */
class Admin_User_model  extends CI_Model{
    
    private $id;
    private $name;
    private $username;
    private $group_id;
    private $email;
    private $active;
    
    
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function init( $user_id, Admin_Users_model $db_model ){
        
        $this->db_model = $db_model;
        $user = $this->db_model->get( $user_id );
        //pre_dump($user);
        $this->id = $user->id;
        $this->name = $user->name;
        $this->username = $user->username;
        $this->group_id = $user->group_id;
        $this->email = $user->email;
        $this->active = $user->active;
        
        return $this;
    }
    
    public function getUsername(){
        return $this->username;
    }
    
}

?>
