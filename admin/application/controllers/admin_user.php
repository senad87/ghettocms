<?php

class Admin_user extends CI_Controller {

	function __construct(){
	        // Call the Model constructor
	    parent::__construct();
	    $this->load->model('Admin_user_model');
	    $this->load->model('Group_model');
		$this->lang->load('messages', 'english');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->helper('login_helper.php');
		$this->load->library('pagination');
		check_login();
	}

	/**
	 * index
	 *
	 * Functuin display home page of the user management section, list of users
	 *
	 * @param int $message_id ID of the messsage to be displayed depend of the action
	 */
	public function index($message_id = 0, $offset = 0){
	
		$all_users = $this->Admin_user_model->get_all_users();
		$total_rows = count($all_users);
		/*** load pagination ***/
		$config['uri_segment'] = 4;
		$config['num_links'] = 2;
		$config['base_url'] = base_url()."admin_user/index/0";
		$config['total_rows'] = $total_rows;
		$config['per_page'] = '5';
		
		$config['full_tag_open'] = '<ul class="pagination">';//surround the entire pagination begining
		$config['full_tag_close'] = '</ul>';//surround the entire pagination end
		$config['num_tag_open'] = '<li>';//digit link open
		$config['num_tag_close'] = '</li>';//digit link close
		$config['cur_tag_open'] = '<li class="current_page">';//current page open
		$config['cur_tag_close'] = '</li>';//current page close
		$config['next_tag_open'] = '<li class="next_page">';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li class="previous_page">';
		$config['prev_tag_close'] = '</li>';
		$config['first_link'] = '&lt;&lt;';//first link title
		$config['first_tag_open'] = '<li class="first_page">';//first link open
		$config['first_tag_close'] = '</li>';//first link close
		$config['last_link'] = '&gt;&gt;';//last link title
		$config['last_tag_open'] = '<li class="last_page">';//last link open
		$config['last_tag_close'] = '</li>';//last link close
		$this->pagination->initialize($config);
		/*** end of pagination ***/
		
		$users = $this->Admin_user_model->get_all_users_limited($config['per_page'], $offset);
		$users_array = array();
		$i = 0; 
		foreach($users as $user){
			$users_array[$i]['id'] = $user->id;
			$users_array[$i]['name'] = $user->name;
			$users_array[$i]['username'] = $user->username;
			$users_array[$i]['role_name'] = $this->Admin_user_model->get_role_by_role_id($user->group_id);
			$i++;
		}
		
		if ($message_id == 1){
			$message = $this->lang->line('message_user_added_successfully');
		} elseif ($message_id == 2) {
			$message = $this->lang->line('message_user_adding_faild');
		} elseif ($message_id == 3){
			$message = $this->lang->line('message_user_updated_successfully');
		} else {
			$message = "";
		}
		
		$data['pagination'] = $this->pagination->create_links();
		$data['message'] = $message;
		$data['users'] = $users_array;
		$this->load->view('users/users_home_view', $data);
	}
	/**
	 * new_user
	 *
	 * This function display form for adding new user
	 */
	public function new_user(){
		
		$roles = $this->Group_model->get_all_groups();
		$data['roles'] = $roles;
		
		$this->load->view('users/new_user_form_view', $data);
	}
	
	/**
	 * add_new
	 *
	 * This function add new user to system or return to form if params are not OK
	 * 
	 */
	public function add_new(){
		
		$name = $this->input->post('name');
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$repassword = $this->input->post('repassword');
		$role_id = $this->input->post('role');
		//form validation rules
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|max_length[12]|xss_clean|callback_username_check');
                $this->form_validation->set_rules('password', 'password', 'required|matches[repassword]');
                $this->form_validation->set_rules('email', 'email', 'valid_email');
                $this->form_validation->set_rules('repassword', 'repassword', 'required');
		
		if ($this->form_validation->run() == FALSE){
			$this->new_user();
		} else {
			$user_id = $this->Admin_user_model->insert_new_user($name, $username, $password, $role_id, $email);
			if($user_id > 0){
				redirect('/admin_user/index/1');
			} else {
			        redirect('/admin_user/index/2');
			}
		}
	}
	
	/**
	 * username_check
	 * This function check thoes user with username exist in database
	 *
	 * @param string $str User name of the new user
	 */
	public function username_check($str){
		
		$existing_users = $this->Admin_user_model->get_number_of_rows_with_username($str);
		if ($existing_users > 0){
			$this->form_validation->set_message('username_check', 'The %s '.$str.' already exists!');
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/**
	 * edit
	 *
	 * Function get user data and display data in the form for edit
	 * @param int $user_id
	 */
	public function edit($user_id){
	
		$user = $this->Admin_user_model->get_user_by_id($user_id);
		$roles = $this->Group_model->get_all_groups();
		
		$data['user'] = $user[0];
		$data['roles'] = $roles;
		$this->load->view('users/edit_user_form_view', $data);
	
	}
	
	/**
	 * update_data
	 *
	 * Function get POST data from the form and update that data in the database
	 *
	 */
	public function update_data(){
		
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$repassword = $this->input->post('repassword');
		$role_id = $this->input->post('role');
		//form validation
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|max_length[12]|xss_clean');
                $this->form_validation->set_rules('password', 'password', 'matches[repassword]');
                $this->form_validation->set_rules('email', 'email', 'valid_email');
                $this->form_validation->set_rules('repassword', 'repassword', 'required');
		//do not redirect to edit metod, form validation does not display messages int that case 
		if ($this->form_validation->run() == FALSE){
			$this->edit($id);
		} else {
			if(isset($password)){
				$this->Admin_user_model->update_user_data($id, $name, $username, $password, $role_id, $email);
			}else{
				$this->Admin_user_model->update_user_data_no_password($id, $name, $username, $role_id, $email);
			}
			redirect('/admin_user/index/3');	
		}
	}
	
	/**
	 * delete
	 *
	 * Function delete all users checked in the user list template
	 * 
	 */
	public function delete(){
		$users_string = $this->input->post('users_array');
		$users_array = explode(",",$users_string);
		foreach ($users_array as $user_id){
			$this->Admin_user_model->update_user_state($user_id, 0);
		}
	}	
}
/* End of file admin_user.php */
/* Location: ./system/application/controllers/admin_user.php */