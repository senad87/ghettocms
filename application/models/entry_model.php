<?php

class Entry_model extends CI_Model {

    private $id;

    function __construct(){
            // Call the Model constructor
            parent::__construct();
    }

    
    public function getEntriesByCategoryLimited( $category_id, $limit = 10, $offset = 0, 
                                                 $order_col = 'id', $order = 'desc', $language_id = 1 ){
            $query = $this->db->select('*')->from('join_entries_categories')
                              ->where( array('category_id'=>$category_id, 'active'=>1, 'language_id'=>$language_id ) )
                              ->limit( $limit, $offset )
                              ->order_by( $order_col, $order );
            return $query->result();
    }

    
    public function getByTypeAndCategoryLimited( $category_id, $type = 1, $limit = 10, 
                                                 $offset = 0, $language_id = 1, $order_col = 'id', $order = 'desc' ){
            $query = $this->db->select('*')->from('join_entries_categories')
                              ->where( array('category_id'=>$category_id, 'active'=>1, 'language_id'=>$language_id ) )
                              ->limit( $limit, $offset )->order_by( $order_col, $order );
            return $query->result();
    }

    public function countByTypeAndCategory( $category_id, $type = 1, $language_id = 1 ){
            $query = $this->db->select('*')->from('join_entries_categories')
                              ->where( array('category_id'=>$category_id, 'active'=>1, 'language_id'=>$language_id ) );
            $number = $this->db->count_all_results();
            return $number;
    }

/**
 * 
 * Get entry id by type id, type id is id of the content like story or game id
 * @param string $type_name
 * @param int $type_id
 */
public function get_entry_id_by_type_id($type_id, $entry_type_id = 1){
	$query = $this->db->get_where("entries",array("type_id" => $type_id, "entry_type_id"=> $entry_type_id));
	$entry = $query->result();
	return $entry[0]->id;
}

/**
 * 
 * Get entry object by entry_type_id (story, game etc.) and type_id (sotry_id and/or game_id etc.) 
 * @param int $type_id
 * @param int $entry_type_id
 */
public function get_entry_by_type($type_id, $entry_type_id = 1){
	$query = $this->db->get_where("entries",array("type_id" => $type_id, "entry_type_id"=> $entry_type_id));
	return $query->result();
}
/**
 * 
 * Get all entries with category_id
 * @param int $category_id
 */
public function get_entries_by_category_id($category_id){
	$query = $this->db->get_where("join_entries_categories",array("category_id"=>$category_id, "active"=>1));
	return $query->result();
}

public function get_number_of_non_deleted_entries_by_type($entry_type_id){
	$this->db->where(array("entry_state_id >" => 1, "entry_type_id"=> $entry_type_id));
	$number = $this->db->count_all_results('entries');
	return $number;
}


public function get_undeleted_entries($entry_type_id, $limit = 10, $offset = 0){
	$this->db->order_by("type_id", "desc");
	$query = $this->db->get_where("entries",array("entry_type_id" => $entry_type_id, "entry_state_id >"=>1), $limit, $offset);
	return $query->result();
}
/**
 * 
 * Get number of deleted entries by entry_type_id
 * @param int $entry_type_id
 */
public function get_number_of_deleted_entries($entry_type_id){
	$this->db->where(array("entry_state_id" => 1, "entry_type_id"=> $entry_type_id));
	$number = $this->db->count_all_results('entries');
	return $number;
}

/**
 * 
 * Get all entries with status 1, stands for deleted
 * @param int $entry_type_id
 * @param int $limit
 * @param int $offset
 */
public function get_deleted_entries($entry_type_id, $limit = 10, $offset = 0){
	//$this->db->order_by("type_id", "desc");
	$query = $this->db->get_where("entries",array("entry_type_id" => $entry_type_id, "entry_state_id"=>1), $limit, $offset);
	return $query->result();
}

public function get_entries_by_categories($categories){
	$categories = array($categories);
	$this->db->where_in('category_id', $categories);
	$query = $this->db->get('join_entries_categories');
	return $query->result();
}

}
/* End of file entry_model.php */
/* Location: ./system/application/models/entry_model.php */