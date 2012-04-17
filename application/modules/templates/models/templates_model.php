<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Templates_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		
	}
	
	public function get_template_by_id($id){
		$query = $this->db->get_where('templates', array('id' => $id));
		return $query->result();
	}

}	