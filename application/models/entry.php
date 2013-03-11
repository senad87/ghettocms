<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Entry extends CI_Model {

    private $id;
    private $type_id;
    private $entry_type_id;
    private $entry_state_id;
    private $category_id;
    private $title;
    private $creation_date;
    private $modified_date;
    private $admin_user_id;
    private $comments;
    private $language_id;

    function __construct(){
            // Call the Model constructor
            parent::__construct();
    }
    
    
}    