<?php

class Home extends CI_Controller {

	function __construct(){
	        // Call the Model constructor
	        parent::__construct();
	        
	        $this->load->helper(array('form', 'url'));
	        $this->load->helper('login_helper.php');
	        $this->load->library('form_validation');
	        $this->load->model('Admin_user_model');
	        check_login();
	}

	
	function index()
	{
		$this->load->view('header_view');
		//$this->load->view('home_view');
	}
}
/* End of file home.php */
/* Location: ./system/application/controllers/home.php */
