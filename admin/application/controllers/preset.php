<?php

class Preset extends CI_Controller {

	private $language_id = 1;
	
	function __construct(){
        // Call the Model constructor
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->helper('login_helper.php');
		$this->lang->load('messages', 'english');
		$this->load->model('Preset_model');
		$this->load->model('Module_model');
		$this->load->model('Template_model');
		$this->load->model('Menu_model');
		$this->load->library('Jquery_pagination');
		$this->lang->load('messages', 'english');
		$this->language_id = $this->session->userdata('language_id');
		check_login();
	}
	
	/**
	 * 
	 * Use POST data from ajax request and create new preset with copies of module instances
	 */
	public function save(){
		
		$menu_id = $this->input->post('menu_id');
		$template_id = $this->input->post('template_id');
		$name = $this->input->post('name');
		$description = $this->input->post('description');
		
		//insert preset name and description and return id of the preset
		$preset_id = $this->Preset_model->insert($name, $description, $template_id, 1, $this->language_id);
		//get all modules by positions for menu_id
		$modules_positions = $this->Module_model->get_module_position_by_menu_id($menu_id);
		
		foreach($modules_positions as $module_position){
			//Insert module => position into join_preset_module_position
			$this->Preset_model->insert_join($preset_id, $module_position->position_id, $module_position->module_id);
		}
		//TODO: Set this message to be from messages file and return temaplate insted of echo
		echo "Preset save succesfully";	
	}
	
	/**
	 * 
	 * Load table of avalabile presets (name, desc, template name) with jQuery pagination and radio button
	 */
	public function load_list($offset = 0){
		$total_rows = $this->Preset_model->get_number(1, $this->language_id);
		//TODO: Create library to extend jQuery pagination library same as we do for default pagination
		$per_page = "10";
		/*** load pagination ***/
		$config['uri_segment'] = 3;
		$config['num_links'] = 3;
		$config['base_url'] = base_url()."/preset/load_list";
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$config['div'] = '#preset-list'; /* Here #content is the CSS selector for target DIV */
		//$config['js_rebind'] = "alert('it works !!'); "; /* if you want to bind extra js code */
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
		$this->jquery_pagination->initialize($config);
		$data['pagination'] = $this->jquery_pagination->create_links();
		/*** end of pagination ***/
		$presets = $this->Preset_model->get_limited_list(1, $this->language_id, $per_page, $offset);
		$presets_array = array();
		foreach($presets as $key => $preset){
			$presets_array[$key]['id'] = $preset->id;
			$presets_array[$key]['name'] = $preset->name;
			$presets_array[$key]['description'] = $preset->description;
			//Get template id and name
			$template = $this->Template_model->get_template_by_id($preset->template_id);
			$presets_array[$key]['tpl_id'] = $template[0]->id;
			$presets_array[$key]['tpl_name'] = $template[0]->name;
		}
		$data['items'] = $presets_array;
		$data['no_items'] = "There are no created protlets!";
		$this->load->view("presets/list_view", $data);	
	}
	
	public function load(){
		$preset_id = $this->input->post('preset_id');
		$menu_id = $this->input->post('menu_id');
		
		$preset = $this->Preset_model->get_preset($preset_id);
		//get module by position from preset
		$modules_positions = $this->Preset_model->get_join($preset_id);
		//Check join_menu_module_position by menu id if does not exist do insert
		//$menu_modules = $this->Menu_model->get_menu_modules($menu_id);
		
		foreach($modules_positions as $module_position){
			//Copy module data
			$module = $this->Module_model->get_module_by_id($module_position->module_id);
			//Paste module data
			$module_id = $this->Module_model->insert_data($module[0]->title, $module[0]->description, $module[0]->module, $module[0]->params);
			
			$menu_module_pos = $this->Module_model->get_module_by_menu_and_position($menu_id, $module_position->position_id);
			if(count($menu_module_pos) > 0){
				//Update join_menu_module_position by menu_id
				$this->Module_model->update_join($menu_id, $module_position->position_id, $module_id);
			}else{
				$this->Module_model->insert_join($menu_id, $module_position->position_id, $module_id);
			}
		}
		
		$this->Menu_model->update_template($menu_id, $preset->template_id);
		echo $preset->template_id;
		
	}
	
}