<?php

class Game_model extends CI_Model {

        function __construct(){
                // Call the Model constructor
                parent::__construct();
        }
        
	public function insert($title, $lead, $release_date, $body, $author_id, $tags_id, $category_id, $language_id){
		$creation_date = date('Y-m-d G:i:s');
		$modified_date = date('Y-m-d G:i:s');
		$data = array(
		        'lead' => $lead,
		        'release_date' => $release_date,
		        'body' => $body,
		);

		$this->db->trans_start();//START transaction
		//insert into games
		$this->db->insert('games', $data);
		//insert into entries table
		$entries_data = array("type_id" => $this->db->insert_id(), "entry_type_id" => 2, "title"=> $title, "creation_date" => $creation_date, "modified_date" => $modified_date, "admin_user_id" => $author_id, "category_id"=>$category_id, "language_id" => $language_id, "comments" => 1);
		$this->db->insert('entries', $entries_data);
		$entry_id = $this->db->insert_id();
		
		//insert into join_entries_tags only if have something to insert
		if(count($tags_id) > 0){
			foreach($tags_id as $tag_id) {
				if($tag_id > 0){
				//var_dump($tag_id);
					$this->db->insert('join_entries_tags', array("entry_id" => $entry_id, "tag_id" => $tag_id));
				}
			}
		}
		$this->db->trans_complete();//END transaction
		
		return $entry_id;
	}
        
        /**
         * 
         * Get all game data by id
         * @param int $id
         */
        public function getGameByID($id){
        	$query = $this->db->get_where("games",array("id"=>$id));
	        return $query->first_row();
        }
        
        
	/**
	* 
	* Update data for game by game id, only in the games table
	* @param int $id
	* @param string $lead
	* @param string $release_date
	* @param string $body
	*/
	public function update($id, $lead, $body, $release_date){

		$modified_date = date('Y-m-d G:i:s');
		$data = array('lead' => $lead,
			'release_date' => $release_date,
			'body' => $body          
		);
		$this->db->where('id', $id);
		$this->db->update('games', $data);
	}
        
        public function delete(){
        
        } 
}
/* End of file game_model.php */
/* Location: ./system/application/models/game_model.php */
