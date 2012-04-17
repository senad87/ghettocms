<?php
class Template extends CI_Controller {

	private $language_id = 1;
	
	function __construct(){
	        // Call the Model constructor
	        parent::__construct();
	        
	        $this->load->model('Template_model');
	        $this->load->model('Module_model');
	        $this->load->model('Menu_model');
	        $this->load->helper('categories_list_helper.php');
	        $this->load->helper('login_helper.php');
	        $this->load->helper('directory');
	        $this->load->library('form_validation');
	        $this->load->library('pagination');
	        $this->lang->load('messages', 'english');
	        
	        $this->lang->load('messages', 'english');
			$this->language_id = $this->session->userdata('language_id');
	        
			check_login();
	}
	
	//display list of avalabile templates
	public function index($message_id = 0, $offset = 0){
		$per_page = 10;
		$total_rows = $this->Template_model->get_number_of_templates_by_state(1);
		//var_dump($total_rows);
		/*** load pagination ***/
		$this->pagination->load_pagination("template/index/0", 4, $total_rows, $per_page);
		/*** end of pagination ***/
		$data['templates'] = $this->Template_model->get_templates_by_state(1);
		$data['pagination'] = $this->pagination->create_links();
		
		if ($message_id == 1){
			$message = $this->lang->line('message_template_added_successfully');
		} elseif ($message_id == 2) {
			$message = $this->lang->line('message_template_adding_faild');
		} elseif ($message_id == 3){
			$message = $this->lang->line('message_template_updated_successfully');
		} else {
			$message = "";
		}
		if($total_rows == 0){
			$data['no_entries'] = $this->lang->line('message_template_empty_table');
		}
		$data['message'] = $message;
		$this->load->view("header_view");
	    $this->load->view('templates/templates_home_view', $data);
	}
	
	public function new_template(){
		$this->load->view("header_view");
	    $this->load->view('templates/new_template_form_view',array('error' => '' ));  
	}
	
	public function add(){
		$name = $this->input->post('name');
		$num_of_positions = $this->input->post('num_of_positions');
		//$file_name = $this->input->post('file_name');
		
		/*** file uplaod cofniguration ***/
		$config['upload_path'] = '../admin/application/views/templates/betemplates';
		$config['allowed_types'] = 'html|php';
		$config['max_size']	= '1000';
		$config['overwrite']	= TRUE;
		$this->load->library('upload', $config);
		/*** end of file upload configuration ***/
		//TODO:add form validation
		//file upload validation	
		if (!$this->upload->do_upload('template_file'))
		{
			$error = array('error' => $this->upload->display_errors());
			$this->load->view("header_view");
			$this->load->view('templates/new_template_form_view', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$file_path = $data['upload_data']['full_path'];
			$file_name = $data['upload_data']['file_name'];
			//TODO: create css_file_path 
			$template_id = $this->Template_model->insert($name, $num_of_positions, $file_name, $file_path);
			if ($template_id > 0){
		       $message_id = 1;
	        }else{
		       $message_id = 2;
	        }
			redirect('/template/index/'.$message_id, 'refresh');
		}
	}
	
	public function edit($id){
		
	}
	
	public function update_data(){
		
	}
	
	/**
	 * delete
	 *
	 * Function set active of selected templates to 0, delete template
	 *
	 */
	public function delete(){
        $items_string = $this->input->post('items_array');
        $items_array = explode(",",$items_string);
		//TODO: Check if some of the menus using this template
        foreach ($items_array as $item_id){
			//set to delete
			//TODO: Check if some of the menus using this template
			//$this->Entry_model->update_entry_state($story_id, 1, 1);
			$this->Template_model->update_active($item_id, 0);
		}
	}
	
	/**
	 * 
	 * Load template as jQuery .load response
	 */
	public function load(){
		$id = $this->input->post('id');
		$menu_id = $this->input->post('menu_id');
		
		$template = $this->Template_model->get_template_by_id($id);
		$this->Menu_model->update_template($menu_id, $id);
		//get modules list
		//TODO: get already set modules by position
		//array create from join_menu_module_position table
		$mod_pos_array = $this->Module_model->get_module_position_by_menu_id($menu_id);
		$modules_directories = directory_map('../application/modules/',1);
		//create array using only modules which are contain xml description file
		foreach($modules_directories as $module){
			if (file_exists('../application/modules/'.$module.'/info.xml')){
				$modules[] = $module;
			}
		}
		$module_instances = array();
		foreach($modules as $module){
			$module_instances[$module] = $this->Module_model->get_by_module($module, $this->language_id);
		}
		//var_dump($module_instances);
		$data['template'] = $template;
		$data['modules'] = $modules;
		$data['instances'] = $module_instances;
		$this->load->view('templates/betemplates/'.$template[0]->file_name, $data);
		$this->load->view('templates/layout_view.php');	
	}
	
	
}
