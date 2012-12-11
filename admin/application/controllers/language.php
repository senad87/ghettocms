<?php

class Language extends CI_Controller {

	function __construct(){
	    // Call the Model constructor
	    parent::__construct();
	    $this->lang->load('messages', 'english');
		$this->load->helper(array('form', 'url'));
		$this->load->helper('login_helper.php');
		$this->load->model("Language_model");
		check_login();
	}
	
	public function change($id){
		//Check and get language by id if OK set language into session 
		$language = $this->Language_model->get_by_id($id);
		if($language){
			$this->session->set_userdata('language_id', $language->id);
			$this->session->set_userdata('language', $language->language);
			redirect(base_url());
		}
		
		//if language with given ID does not exist do not change session data
		
	}
}