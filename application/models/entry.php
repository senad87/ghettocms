<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Entry extends CI_Model {

    private $id;
    private $title;
    private $category;
    private $image;
    private $creation_date;
    private $modified_date;
    private $author;
    private $comments = array();
    private $state;
    //private $language_id;

    function __construct(){
            // Call the Model constructor
            parent::__construct();
    }
    
    public function init( $id, $title, $category, 
                          $image, $creation_date, $modified_date, 
                          $author, $state, $comments ){
        
        $this->id = $id;
        $this->title = $title;
        $this->category = $category;
        $this->image = $image;
        $this->creation_date = $creation_date;
        $this->modified_date = $modified_date;
        $this->author = $author;
        $this->state = $state;
        $this->comments = $comments;
        
    }
    
    /*public function __get( $name ) {
        return $this->$name;
    }*/
    
    public function getId(){
        return $this->id;
    }
    
    public function getTitle(){
        return $this->title;
    }
    
    public function getCategory(){
        return $this->category;
    }
    
    public function getImage(){
        return $this->image;
    }
    
    public function getCreationDate(){
        return $this->creation_date;
    }
    
    public function getModifiedDate(){
        return $this->modified_date;
    }
    
}    