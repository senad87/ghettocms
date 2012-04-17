<?php

class Topic extends MX_Controller {

	private $language_id = 1;
	
	function __construct(){

		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->helper('login_helper.php');
		$this->lang->load('messages', 'english');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->model('Topic_model');
		$this->load->model('tag/Tag_model');
		$this->load->model('Entry_type_model');
		
		$this->language_id = $this->session->userdata('language_id');
		
		check_login();
	}
	
	/**
	 * 
	 * Display list of topics
	 * @param int $message
	 * @param int $offset
	 */
	public function index($order="id-desc", $offset=0){
        	
        $data['offset'] = $offset;
		$order_array = explode('-', $order);
		$data['orderColumn'] = $order_array[0];
		$data['order'] = $order_array[1];
		
        $total_rows = $this->Topic_model->get_number_of_active($this->language_id);
        $per_page = "10";
		/*** load pagination ***/
		$this->pagination->load_pagination("topic/index/0", 4, $total_rows, $per_page);
		$data['topics'] = $this->Topic_model->get_active($per_page, $offset, $this->language_id, 1);
		$data['pagination'] = $this->pagination->create_links();
		//display list of all topics
        	$this->load->view('header_view');
        	$this->load->view('topics_home_view', $data);
	
	}
	
	/**
	 * 
	 * display form for adding topic
	 * not additional data required
	 */
	public function createNew(){
		$data['entry_types'] = $this->Entry_type_model->get_entry_types();
		$this->load->view('header_view');
		$this->load->view('new_topic_form_view', $data);
	}
	
	/**
	 * createNew_post
	 *
	 * Function validate form and insert post data to database
	 */
	public function createNew_post(){
	
        	$name = $this->input->post('name');
	        $description = $this->input->post('description');
	        $entry_type = $this->input->post('entry_type');
	        
	        $this->form_validation->set_rules('name', 'Topic name', 'required|callback_topicname_check');
		
		if ($this->form_validation->run() == FALSE){
		        //display form again
			$this->load->view("header_view");
			$this->load->view('new_topic_form_view');
	        } else {
		        //insert new topic
		        $topic_id = $this->Topic_model->insert($name, $description, $entry_type, $this->language_id);
		        $this->messages->add('Topic successfully created', 'success');
	        	redirect('/topic');	
	        }
	
	}
	
	/**
	 * delete
	 *
	 * Function delete selected topics
	 */
	public function delete(){
		
		$ids = $this->input->post('ids');
	    	$ids = explode(",", $ids);
	    	$count = count($ids);
		foreach ($ids as $id){
			//var_dump($id);
			//set active to 0
			$this->Topic_model->delete($id, 0);
		}
		$this->messages->add($count.' Topic(s) successfully deleted', 'success');
	}
	
	/**
	 * topicname_check
	 * This function check thoes topic exist in database
	 *
	 * @param string $str topic
	 */
	public function topicname_check($str){
		
		$existing_topics = $this->Topic_model->get_number_of_rows_with_name($str);
		if ($existing_topics > 0){
			$this->form_validation->set_message('topicname_check', ' %s '.$str.' already exists!');
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	public function edit($id){
		$topic= $this->Topic_model->get_topic_by_id($id);
		$data['topic'] = $topic[0];
		//get tags
		$data['tags'] = $this->Tag_model->get_active_tags_by_topic_id($id);
		$data['entry_types'] = $this->Entry_type_model->get_entry_types();
		$used_entry_type = $this->Topic_model->get_entry_type_by_topic_id($id);
		$data['used_entry_type'] = $used_entry_type[0]->entry_type_id;
		$this->load->view('header_view');
		$this->load->view('edit_topic_form_view', $data);
	}
	
	/**
	 * edit_post
	 * Update data of the topic, with data from POST
	 *
	 */
	public function edit_post(){
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$description = $this->input->post('description');
		$entry_type = $this->input->post('entry_type');  
		$this->Topic_model->update($id, $name, $description, $entry_type);
		$this->messages->add('Topic successfully edited', 'success');
		redirect('/topic');
	}
	
	/**
	 * 
	 * Display form with multiselect for setting system topics
	 * 
	 * @param int $type
	 */
	public function selectSystem($type){
		//get system for this entry type
		$data['entry_type'] = $type;
		$data['sys_topics_array'] = $this->getSystemArray($type);
		$data['topics'] = $this->Topic_model->get_all_active($this->language_id);
		$this->load->view('select_system_view', $data);
		$this->load->script('select_system_script');
		$this->load->script('set_system_script');
	}
	

	public function setSystem_post(){
		//entry type id
		$entry_type = $this->input->post('entry_type');
		$topics = $this->input->post('topics');
		$sys_topics = $this->getSystemArray($entry_type, TRUE);
		//first deactivate all system topics
		//var_dump($topics);
	    $this->Topic_model->deactivate_all_systems($entry_type);
		if(isset($topics) && is_array($topics)){
		    foreach ($topics as $id){
				if(in_array($id, $sys_topics)){
					//print_r("Update".$id);
					$this->Topic_model->update_system($id, 1);
				}else{
					//print_r("Insert".$id);
					$this->Topic_model->insert_system($id, $entry_type, $this->language_id);
				}
			}
		}
		//set required data for view
		$data['entry_type'] = $entry_type;
		$data['sys_topics_array'] = $this->getSystemArray($entry_type);
		$data['topics'] = $this->Topic_model->get_all_active($this->language_id);
		
		$this->load->view('select_system_view', $data);
		$this->load->script('select_system_script');
		$this->load->script('set_system_script');
	}
	
	private function getSystemArray($type = 1, $all = FALSE){
		//get system for this entry type
		$sys_topics = $this->Topic_model->get_system($type, $this->language_id, FALSE, $all);
		$sys_topics_array = array();
		//create array only from sys topics id's
		foreach($sys_topics as $sys_topic){
			$sys_topics_array[] = $sys_topic->topic_id;
		}
		return $sys_topics_array;
	}
}
/* End of file topic.php */
/* Location: ./system/application/modules/controllers/topic.php */
