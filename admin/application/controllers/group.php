<?php

class Group extends CI_Controller {

	function __construct(){

		parent::__construct();
		$this->load->model('Group_model');
		$this->load->model('Privilege_model');
		$this->load->model('Action_model');
		$this->load->model('Subject_model');
		$this->load->helper('login_helper.php');
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->lang->load('messages', 'english');
	        check_login();
		
	}
	
	/**
	 * This function display list of the avalabile user groups
	 *
	 *
	 */
	public function index($message = 0){
        	if ($message == 2){
	        	$data['message'] = $this->lang->line('message_user_group_added_successfully');
        	}
        	//select and display all groups in the table with edit, delete and new options
        	$data['groups'] = $this->Group_model->get_all_groups();
        	$this->load->view("header_view");
        	$this->load->view('groups/user_groups_home_view', $data);
	}
	

	/**
	 * new_group
	 *
	 * Function display form for new user group creation and display list of all avalabile privileges
	 */

	public function new_group(){

		//get all avalbile privileges
		$all_privileges = $this->Privilege_model->get_all_privileges();
		$data['all_privileges'] = $this->privileges_list($all_privileges);
		$this->load->view("header_view");
		$this->load->view("groups/new_user_group_form_view", $data);

	}
	
	/**
	 * add
	 *
	 * Function insert new user group and all of user group privileges
	 * TODO: Add form validation
	 */
	 
	public function add(){
		$name = $this->input->post('name');
		//checked privileges to be set for user group
	        $set_privileges_array = $this->input->post('privilege_id');
	        //var_dump($set_privileges_array);
	        //form validation rules
		$this->form_validation->set_rules('name', 'Group name', 'required');
		$this->form_validation->set_rules('privilege_id', 'User privileges', 'callback_check_selected_privileges');
		//$this->form_validation->set_message('required', 'Your custom message here');
	        if ($this->form_validation->run() == FALSE){
		        //get all avalbile privileges
			$all_privileges = $this->Privilege_model->get_all_privileges();
			$data['all_privileges'] = $this->privileges_list($all_privileges);
			$this->load->view("header_view");
			$this->load->view("new_user_group_form_view", $data); 
	        } else {
		        //first we insert new group in the groups table
		        $group_id = $this->Group_model->insert($name);
		        if($group_id > 0){
			        //set checked privileges to join_group_privileges
			        foreach ($set_privileges_array as $set_privilege_id){
					$this->Privilege_model->insert_privilege_group($group_id, $set_privilege_id, 1);        	
				}
		        $message = 2;//successfull insertion of the user group
		        }
		        
		        redirect('/group/index/2');
	        }
	}
	
	/**
	 * check_selected_privileges
	 *
	 * Set custom message if at list one privilege is not set for adding new user group
	 * Function used for error message customization only 
	 * @param mixed $privileges
	 */
	public function check_selected_privileges($privileges){
	
		if ($privileges){
			return TRUE;
		}else{
			$this->form_validation->set_message('check_selected_privileges', 'You must select at list one privilege!');
			return FALSE;
		}
	}
	
	/**
	 * edit
	 * 
	 * Function get group and all privileges related to that group
	 */
	 
	public function edit($id, $message = 0){
		$group = $this->Group_model->get_group_by_id($id);
		$group_privileges = $this->Privilege_model->get_privilege_id_by_group_id($group[0]->id);
		//TODO:Create group privileges id array, and add check attributes for group privileges
		//var_dump($group_privileges);
		$user_group_privileges = array();
		$i = 0;
		foreach ($group_privileges as $privilege){
        		$user_group_privileges[$i] = $privilege->privilege_id;
        		$i++;
		}
		
        $all_system_privileges = $this->Privilege_model->get_all_privileges();
		//var_dump($all_system_privileges);
        if($message == 1){
			$data['message'] = $this->lang->line('message_user_group_updated_successfully');
		}
		
		$data['user_group_privileges'] = $user_group_privileges;
		$data['all_privileges'] = $this->privileges_list($all_system_privileges);
		$data['group'] = $group;
		$this->load->view("header_view");
		$this->load->view('groups/edit_user_group_view', $data);
	}
	
	/**
	 * update_data
	 * 
	 * Update data user group, group name and group privileges
	 * TODO:This method need to be fixed
	 */
	public function update_data(){
        	
        	$group_name = $this->input->post('groupname');
                $group_id = $this->input->post('groupid');
                //update group name
                $this->Group_model->update_name_by_id($group_id, $group_name);
        	//checked privileges to be set for user group
        	$set_privileges_array = $this->input->post('privilege_id');
        	//existing privileges
        	$existing_group_privileges = $this->Privilege_model->get_existing_privileges_by_group_id($group_id);

        	$existing_group_privileges_array = array();
        	$i = 0;//counter for existing_group_privileges array
        	foreach($existing_group_privileges as $existing_group_privilege){
                	$existing_group_privileges_array[$i] = $existing_group_privilege->privilege_id;
                	$i++;
        	}
        	//update status to 0 for all unchecked privileges
        	//first we set all to 0 and than only checked set to 1
        	//if no privilege in the table insert the checked one
        	$this->Privilege_model->update_privileges_status_by_group_id($group_id, 0);
        	foreach ($set_privileges_array as $set_privilege_id){
                	$this->Privilege_model->update_privilege_status($group_id, $set_privilege_id, 1);

                	//check if privilege_id, group_id exist in the table join_privileges_groups
                	if(!in_array($set_privilege_id, $existing_group_privileges_array)){

                	$this->Privilege_model->insert_privilege_group($group_id, $set_privilege_id, 1);
                	}
        	}
        	$message = 1;
        	$this->edit($group_id, $message);
	}
	
	public function delete(){
	
	        $group_string = $this->input->post('stories_array');
	        $groups_array = explode(",", $group_string);
		foreach ($groups_array as $group_id){
			//set to delete
			$this->Group_model->update_group_state($group_id, 0);
		}
	
	}
	/**
	 * privileges_list
	 *
	 * Take array of privileges objects and create list of privileges with action and subject names
	 *
	 * @param array $privileges
	 */
	private function privileges_list($privileges){
	
	$all_privileges_view = array();//created to be displayed in the view, adding name,action name
		$i = 0;
		
		foreach($privileges as $privilege){
		
			$privilege_data = $this->Privilege_model->get_privilege_by_id($privilege->id);
			$action = $this->Action_model->get_action_by_id($privilege_data[0]->action_id);
			$subject = $this->Subject_model->get_subject_by_id($privilege_data[0]->subject_type_id);
        		$subject_id = $privilege_data[0]->subject_id;
        		$all_privileges_view[$i] = array("privilege_id"=>$privilege->id,
                                        		"action"=>$action[0],
                                        		"subject_type"=>$subject[0],
                                        		"subject_id"=>$subject_id);
        		$i++;
		}
	return 	$all_privileges_view;
	}
}	
/* End of file group.php */
/* Location: ./system/application/controllers/group.php */
