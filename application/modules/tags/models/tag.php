<?php
/**
 * Description of tag
 *
 * @author damir
 */
class Tag extends CI_Model {

	private $id;
	private $tag;
	private $topic_id;
	private $active;
        
        private $db_model;
	
	function __construct(){
	        parent::__construct();
	}
        
        public function init( $id, Tag_model $db_model ){
            $this->db_model = $db_model;
            if( $id > 0 ){
                $this = $this->db_model->getTagByID( $id );
            }
        }
        
        public function getName(){
            return $this->name;
        }
        
        public function getTopicID(){
            return $this->topic_id;
        }

}