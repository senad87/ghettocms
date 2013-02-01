<?php

class Image_model extends CI_Model {



	function __construct(){
        // Call the Model constructor
        parent::__construct();
	}
	
	public function insert_new($title='', $lead='', $path, $order=0, $source_image_id = 0, $poster_photo = 1, $dimension_id = 1){
		$creation_date = date('Y-m-d G:i:s');
		$modified_date = date('Y-m-d G:i:s');
		$data = array(
                       'title' => $title,
                       'lead' => $lead,
                       'path' => $path,
                       'order' => $order,
                       'source_image_id' => $source_image_id,	
                       'poster_photo' => $poster_photo,
                       'dimension_id' => $dimension_id,
                       'creation_date' => $creation_date,
                       'modified_date' =>  $modified_date
	               );
	                    
        $this->db->insert('images', $data); 
        return $this->db->insert_id();
	}
	
	public function connect_with_entry($entry_id, $image_id){
		$data = array(
                       'entry_id' => $entry_id,
                       'image_id' => $image_id
        			  
	                    );
		$this->db->insert('join_entries_images', $data); 
        
	}
	
	/**
	 * 
	 * Get all images related to entry
	 * @param int $entry_id
	 */
	public function get_images_by_entry_id($entry_id){
		$query = $this->db->get_where("join_entries_images",array("entry_id"=>$entry_id, "active"=>1));
		return $query->result();
	}
        
        public function get_images_ids_by_entry_id($entry_id){
                $this->db->select('image_id');
                $this->db->from('join_entries_images');
                $this->db->where('entry_id =', $entry_id);
                $this->db->where('active =', 1);
                
                $query = $this->db->get();
                return $query->result();

	}
        
        public function get_ordered_images_ids($entry_id){
            $this->db->select('image_id');
            $this->db->from('join_entries_images');
            $this->db->where("entry_id =", $entry_id);
            $this->db->where("active =", 1);
            $this->db->join('images', 'join_entries_images.image_id = images.id');
            $this->db->order_by("order", "ASC");

            $query = $this->db->get();
            return $query->result();

        }
        
        public function createOrderString($images){
            $orderStr = '';
            foreach($images as $image){
               $orderStr .= $image->id.":".$image->order;
               $orderStr .= "|";
            }
            $orderStr = substr($orderStr, 0, strlen($orderStr)-1);
            return $orderStr;
            
        }
	
	/*public function get_poster_photo_by_id($id){
		$query = $this->db->get_where("images",array("id"=>$id, "poster_photo"=>1));
		return $query->result();
	}*/
	
	public function get_image($id){
		$query = $this->db->get_where("images",array("id"=>$id));
		return $query->result();
	}
	
	public function update_connect_with_entry($entry_id, $image_id){
		$data = array("image_id" => $image_id);
		$this->db->where(array("entry_id"=>$entry_id, "image_id"=>$image_id));
		$this->db->update('join_entries_images', $data);
	}
	
	public function get_dimensions(){
		$query = $this->db->get("dimensions");
		return $query->result();
	}
	
	/**
	 * Get all poster photo dimensions smaller than original(the largest one)
	 * original dimension has id = 1
	 */
	public function get_other_dimensions(){
		$query = $this->db->get_where("dimensions", array("id >"=>1));
		return $query->result();
	}
	
	public function delete_connection($entry_id){
		$data = array("active" => 0);
		$this->db->where(array("entry_id"=>$entry_id));
		$this->db->update('join_entries_images', $data);
	}
        
        public function delete_connection_for_single_image($entry_id, $image_id){
		$data = array("active" => 0);
		$this->db->where(array("entry_id" => $entry_id, "image_id" => $image_id));
		$this->db->update('join_entries_images', $data);
	}
}
/* End of file image_model.php */
/* Location: ./system/application/models/image_model.php */


