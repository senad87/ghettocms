<?php

class Access extends CI_Controller {
   
	function __construct(){

		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->helper('login_helper.php');
		$this->lang->load('messages', 'english');
		$this->load->library('form_validation');
		$this->load->model('Admin_user_model');
		$this->load->model('Language_model');
      $this->load->library('phpass');
	}
	/**
	 * login_form
	 *
	 * Function only display form for login user to administrator
	 *
	 */
	 
	public function login_form(){    
		$this->load->view('login_form_view');
	}
	
	/**
	 * login
	 *
	 * Check login data of the users from the POST and display home page or return user to login page
	 */
	 
	public function login(){
		//get form data
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		//validate form data
		$this->form_validation->set_rules('username', 'username', 'required|min_length[5]|max_length[12]|xss_clean');
		$this->form_validation->set_rules('password', 'password', 'required');
		
		if ($this->form_validation->run() == FALSE){
			//form validation faild show login form again	
			$this->load->view('login_form_view');
		}else{
			//check user data in db
			//$user = $this->Admin_user_model->get_user_by_username_and_password($username, $password);
         $user = $this->Admin_user_model->get_user_by_username($username);
		   $hashed_pass = $user->password;
		        //if (count($user) == 1){
              if ($this->phpass->check($password, $hashed_pass)){
			        //TODO: Get user role and add to session data to be displayed in the header
			        //get user privileges from database
			        $privileges_array = $this->Admin_user_model->get_user_privileges_by_group_id($user->group_id);
			        $language = $this->Language_model->get_by_id(1);
			        //set session data and display user name in the header
			        $user_session_data = array("id"=>$user->id,
			                                   "name"=>$user->name,
			                                   "username"=>$user->username,
			                                   "user_privileges"=>$privileges_array,
			                                   "language_id" => 1,
                                            "language" => $language->language,
			                                   "loggedIn"=>TRUE);
	                        $this->session->set_userdata($user_session_data);
	                        $data['username']=$user->username;
	                        $this->load->view('header_view');
	                        $this->load->view('home_view');  
	                             
		        }else{
			        $data['wrong_username_or_pass'] = $this->lang->line('wrong_username_or_password');;
			        $this->load->view('login_form_view', $data);
		        }
		}
	}
	
	/**
	 * logout
	 * 
	 * This function distory, delete all session data for this particular user and dispaly login form
	 */
	public function logout(){
		
		$user_session_data = array("id"=>"", "name"=>"", "username"=>"", "loggedIn"=>"");
		$this->session->unset_userdata($user_session_data);
		$this->load->view('login_form_view');
	
	}
	
}
/* End of file access.php */
/* Location: ./system/application/controllers/access.php */
