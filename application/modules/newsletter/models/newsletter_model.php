<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Newsletter_model extends CI_Model {

	function __construct(){
		parent::__construct();	
	}
	
	public function getNewsletterByID(){}
	public function subscribe($email){
		$createdDate = date('Y-m-d H:i:s');
		$ip = $this->session->userdata('ip_address');
		$sql = "INSERT INTO newsletter (email, md5, ip, createdDate) VALUES (?, ?, ?, ?)";
		$query = $this->db->query($sql, array($email, md5($email), $ip, $createdDate));
		if($query){
			return true;
		}else{
			return false;
		}
	}
	
	public function unsubscribe($md5){
		$sql = "UPDATE newsletter set status=0 WHERE md5=?";
		$query = $this->db->query($sql, array($md5));
		if($query){
			return true;
		}else{
			return false;
		}
	}
	
	public function isAlreadySubscribed($email){
			$sql = "SELECT email FROM newsletter WHERE email=?";
			$query = $this->db->query($sql, array($email));
			$result = $query->fist_row();
			if(!empty($result)){
				return $result->email;
			}else{
				return false;
			}
	
	}
	
function getMail($email){
		$sql = "SELECT email FROM newsletter WHERE email=? AND status=1 ";
		$query = $this->db->query($sql, array($email));
		$result = $query->first_row();
		if(!empty($result)){
			return $result->email;
		}else{
			return false;
		}

	}
	
	public function test($email){
		return $email;
	}
	
	
	/*function search($keyword, $offset=false, $limit=false){
			if($offset===false){
	  			$limit = "";
	  		}else{
	  			$limit = " LIMIT ".$offset.", ".$limit;
	  		}
			$sql = "SELECT * FROM stories WHERE headline LIKE ? OR title LIKE ? OR lead LIKE ? OR body LIKE ? ".$limit;
			$query = $this->db->query($sql, array("%".$keyword."%", "%".$keyword."%", "%".$keyword."%", "%".$keyword."%"));
		
			return $query->result();	
	}

	function countResults($keyword){
	
			$sql = "SELECT count(*) as count FROM stories WHERE headline LIKE ? OR title LIKE ? OR lead LIKE ? OR body LIKE ?";
			$query = $this->db->query($sql, array("%".$keyword."%", "%".$keyword."%", "%".$keyword."%", "%".$keyword."%"));
		
			return $query->first_row()->count;
	
	}*/
	
}

/* End of file search_model.php */
/* Location: ./application/modules/search/controllers/search_model.php */
