<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Toolbar_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		
	}
	
	
	function insertArticle($title, $lead, $body){
  
  		$created = date('Y-m-d H:i:s');
		$sql = "INSERT INTO tbl_articles (title, lead, body, created) VALUES (?, ?, ?, ?) ";
		$query = $this->db->query($sql, array($title, $lead, $body, $created));
		if($query){
			return $this->db->insert_id();
		}else{
			return false;
		}
  	}
  	
  	function getArticles($offset=false, $limit=false){
  		if($offset===false){
  			$limit = "";
  		}else{
  			$limit = " LIMIT ".$offset.", ".$limit;
  		}
		$sql = "SELECT * FROM tbl_articles WHERE status=0 OR status=1 ORDER BY created DESC".$limit;
		$query = $this->db->query($sql);

		return $query->result();
  	}
  	
  	function getTrashArticles($offset=false, $limit=false){
  		if($offset===false){
  			$limit = "";
  		}else{
  			$limit = " LIMIT ".$offset.", ".$limit;
  		}
		$sql = "SELECT * FROM tbl_articles WHERE status=-1 ORDER BY created DESC".$limit;
		$query = $this->db->query($sql);

		return $query->result();
  	}
  	
  	function getArticle($id){
 		$sql = "SELECT * FROM tbl_articles WHERE id=?";
		$query = $this->db->query($sql, array($id));
		$result = $query->first_row();

		return $result; 	
  	}
  	
  	function deleteArticle($id){
		$sql = "UPDATE tbl_articles SET status=-1 WHERE id=?";
		$query = $this->db->query($sql, array($id));
		return true;
  	}
  	//za sad je -2 a mozda bi terbalo da se deletuje skroz
  	function removeArticle($id){
		$sql = "UPDATE tbl_articles SET status=-2 WHERE id=?";
		$query = $this->db->query($sql, array($id));
		return true;
  	}
  	
  	function publishArticle($id){
		$sql = "UPDATE tbl_articles SET status=1 WHERE id=?";
		$query = $this->db->query($sql, array($id));
		return true;
  	}
  	
  	function unpublishArticle($id){
		$sql = "UPDATE tbl_articles SET status=0 WHERE id=?";
		$query = $this->db->query($sql, array($id));
		return true;
  	}
  		
}

/* End of file articles_model.php */
/* Location: ./application/modules/articles/controllers/articles_model.php */
