<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('Users_model');	
	}

	function index(){
		$data['users'] = $this->Users_model->getUsers();
		$this->load->view('header_view');	
		$this->load->view('list_view');
		$this->load->view('footer_view');
	}
	
	function createNew(){
		$this->load->view('header_view');	
		$this->load->view('new_view');
		$this->load->view('footer_view');
	}
	
	function createNew_post(){
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[20]|callback_username_check');
		$this->form_validation->set_rules('password', 'Password', 'required|matches[passconf]|min_length[5]|max_length[20]');
         	$this->form_validation->set_rules('passconf', 'Verify Password', 'required');
         	$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
		$username = $this->input->post('username', TRUE);
		$password = $this->input->post('password', TRUE);
		$email = $this->input->post('email', TRUE);

		if($this->form_validation->run() == FALSE){
         		$this->createNew();	
          	}else{
          		$this->Users_model->insertUser($username, $password, $email);
          		$this->index();
          	}	
	}
	
	
	
	function edit(){
		$this->load->view('header_view');	
		$this->load->view('edit_view');
		$this->load->view('footer_view');
	}
	function delete(){
		//after delete
		$this->index();
	}
	
	function username_check($str){
		$this->form_validation->set_message('username_check', $this->lang->line('already_exists'));
		if($this->Users_model->isUsernameTaken($str)){
			return false;
		}else{
			return true;
		}
		
	}
	function email_check($str){
		$this->form_validation->set_message('email_check', $this->lang->line('already_exists'));
		if($this->Users_model->isEmailTaken($str)){
			return false;
		}else{
			return true;
		}
	}	
	
}

/* End of file users.php */
/* Location: ./application/modules/page/controllers/users.php */
