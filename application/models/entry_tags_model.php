<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Entry_tags_model extends CI_Model {

    function __construct(){
            // Call the Model constructor
            parent::__construct();
    }
    
    public function attachTags( stdClass $object, Tag_model $tags_db_model ){
        $object->tags = array();
        $object_tags = $this->getTagsByEntry( $object->id );
        foreach( $object_tags as $tag ){
            $object->tags[] = $tags_db_model->getTagByID( $tag->tag_id );
        }
        return $object;
    }
    
    public function getTagsByEntry( $entry_id ){
        $this->db->select('*')->from('join_entries_tags')->where ('entry_id', $entry_id );
        return $this->db->get()->result();
    }
    
}