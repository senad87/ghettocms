<?php

class Images_model extends CI_Model {

	function __construct(){
        // Call the Model constructor
        parent::__construct();
	}
	
	public function insertImage($title, $tags, $path){
            $creation_date = date('Y-m-d H:i:s');
            //$modified_date = date('Y-m-d H:i:s');
            $sql = "INSERT INTO images (title, path, creation_date) VALUES (?,?,?)";
            $query = $this->db->query($sql, array($title, $path, $creation_date));

            if($query){
                return $this->db->insert_id();
            }else{
                return false;
            }
	
	}
	
	
	function getImages($offset=false, $limit=false){
		if($offset===false){
                    $limit = "";
  		}else{
                    $limit = " LIMIT ".$offset.", ".$limit;
  		}
		$sql = "SELECT * FROM images WHERE status=1 ORDER BY creation_date DESC".$limit;
                //$sql = "SELECT * FROM images LIMIT 591, 20";
		$query = $this->db->query($sql);	
		return $query->result();
	
	}
	
	function getImage($id){
		$sql = "SELECT * FROM images WHERE id=?";
		$query = $this->db->query($sql, array($id));
                $result = $query->first_row();
                if(!empty($result)){
                    return $result;
                }else{
                    return false;
                }
		//return $query->first_row();
	}
	
	public function deleteImage($id){
		$sql = "UPDATE images SET status=0 WHERE id=?";
		$query = $this->db->query($sql, array($id));
		return true;
	}
	
	public function updateImage($id, $title, $lead){
		$sql = "UPDATE images SET title=?, lead=? WHERE id=?";
		$query = $this->db->query($sql, array($title, $lead, $id));
		return true;
	}
	
	
	
	
	
	
	public function uniqueString($strExt = '') {
		// explode the IP of the remote client into four parts
		@$arrIp = explode('.', $_SERVER['REMOTE_ADDR']);
		// get both seconds and microseconds parts of the time
		@list($usec, $sec) = explode(' ', microtime());
		// fudge the time we just got to create two 16 bit words
		@$usec = (integer) ($usec * 65536);
		@$sec = ((integer) $sec) & 0xFFFF;
		// fun bit--convert the remote client's IP into a 32 bit
		// hex number then tag on the time.
		// Result of this operation looks like this xxxxxxxx-xxxx-xxxx
		@$strUid = sprintf("%08x-%04x-%04x", ($arrIp[0] << 24) | ($arrIp[1] << 16) | ($arrIp[2] << 8) | $arrIp[3], $sec, $usec);
		// tack on the extension and return the filename
		return $strUid.$strExt;
	}
        
        public function getDimensions(){
            $query = $this->db->get("dimensions");
            return $query->result();
        }
}
/* End of file images_model.php */
/* Location: ./system/application/models/images_model.php */
