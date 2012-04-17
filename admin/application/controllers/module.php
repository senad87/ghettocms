<?php

class Module extends CI_Controller {

	private $language_id = 1;
	
	//TODO: Refactoring complite class ASAP
	function __construct(){
	        // Call the Controler constructor
	        parent::__construct();
	        
	        $this->load->helper('login_helper.php');
	        $this->load->helper('xml2array_helper.php');
	        $this->load->helper('menus_tree_helper.php');
	        $this->load->helper('categories_list_helper.php');
	        $this->load->helper('directory');
	        $this->load->library('form_validation');
	        $this->load->model('Menu_model');
	        $this->load->model('Category_model');
	        $this->load->model('Entry_model');
	        $this->load->model('Story_model');
	        $this->load->model('Client_model');
	        $this->load->model('Module_model');
	        $this->load->model('Module_instance_model');
	        $this->load->library('Jquery_pagination');
	        
	        $this->lang->load('messages', 'english');
			$this->language_id = $this->session->userdata('language_id');
	        
			check_login();
	}
	
	
	
	/**
	 * Parsing XML and display form for creating new module instance of selected module
	 * by module name provided as POST param through jQuery .load request
	 * 
	 */
	public function load_new_module(){
		
		$module = $this->input->post('module');
		
		$objDOM = new DOMDocument(); 
		$objDOM->load("../application/modules/".$module."/info.xml"); //make sure path is correct 
		$params = $objDOM->getElementsByTagName("params"); 
        
		// for each params tag, parse the document and get values for
		$data['module'] = $module;
		$data['clients'] = $this->Client_model->get_all_clients();
		//load full menu tree
		$data['root_menus'] = $this->Menu_model->get_menu_kids(0, $this->language_id);
		$this->load->view("modules/dialog/basic_params_view", $data);
		foreach ($params as $param){
            $data['group'] = $param->getAttribute("group");
            $this->load->view("modules/dialog/attributes_group_view", $data);
			$param = $param->getElementsByTagName("param");
			foreach ($param as $param_item){
				    //mandatory attributes for all param types
					$data['default'] = $param_item->getAttribute("default");
					$data['name'] = $param_item->getAttribute("name");
					$data['label'] = $param_item->getAttribute("label");
					$data['cssclass'] = $param_item->getAttribute("cssclass");
				//load specific params with specific views for each param type
				if($param_item->getAttribute("type") == "select"){
					$data['options'] = $param_item->getElementsByTagName("option");
					$this->load->view("modules/dialog/select_view", $data);
				}elseif($param_item->getAttribute("type") == "input"){
					$this->load->view("modules/dialog/input_text_view", $data);
				}elseif($param_item->getAttribute("type") == "rich_text"){
					$this->load->view("modules/dialog/rich_text_view", $data);
				}elseif($param_item->getAttribute("type") == "radio"){
					$data['options'] = $param_item->getElementsByTagName("option");
					$this->load->view("modules/dialog/radio_view", $data);
				}elseif($param_item->getAttribute("type") == "tags"){
					//TODO:add possibility to filter content by tags
				}elseif($param_item->getAttribute("type") == "categories"){	
					$data['root_categories'] = $this->Category_model->get_category_kids(0, $this->language_id);
					$this->load->view("modules/dialog/categories_view", $data);
				}elseif($param_item->getAttribute("type") == "menus"){
					//Load tree view of the root menus with radio buttons, only load root menus
					$data['root_menus'] = $this->Menu_model->get_menu_kids(0, $this->language_id);
					$this->load->view("modules/dialog/menus_view", $data);
				}elseif($param_item->getAttribute("type") == "menu_tree"){
					//Load tree view of the root menus with radio buttons, only load root menus
					$data['root_menus'] = $this->Menu_model->get_menu_kids(0, $this->language_id);
					$this->load->view("modules/dialog/menus_view", $data);
				}elseif($param_item->getAttribute("type") == "stories"){
					//echo 'test';
					//get all published and unpublished entries of the sotry type
					$total_rows = $this->Entry_model->get_number_of_non_deleted_entries_by_type(1, $this->language_id);
					$per_page = "10";
					/*** load pagination ***/
					//$this->pagination->load_pagination("story/index/0", 4, $total_rows, $per_page);
					$config['uri_segment'] = 4;
					$config['num_links'] = 2;
					$config['base_url'] = base_url()."/module/stories_ajax";
					$config['total_rows'] = $total_rows;
					$config['per_page'] = $per_page;
					$config['div'] = '#content'; /* Here #content is the CSS selector for target DIV */
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
					$entries = $this->Entry_model->get_undeleted_entries(1, $per_page, 0, $this->language_id);
					foreach($entries as $entry){
						$story = $this->Story_model->get_story_by_id($entry->type_id);
						$stories_array_of_objects[] = $story[0];		
					}
					$data['stories'] = $stories_array_of_objects;
 					$this->load->view("modules/dialog/stories_view", $data);
				}
				//TODO: Add menu_tree type
			}
			$this->load->view("modules/dialog/endof_attributes_group_view", $data);	
		}
	}
	
	public function stories_ajax($offset = 0){
		
		$total_rows = $this->Entry_model->get_number_of_non_deleted_entries_by_type(1);
		$per_page = "10";
		/*** load pagination ***/
		//$this->pagination->load_pagination("story/index/0", 4, $total_rows, $per_page);
		$config['uri_segment'] = 3;
		$config['num_links'] = 2;
		$config['base_url'] = base_url()."/module/stories_ajax";
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$config['div'] = '#content'; /* Here #content is the CSS selector for target DIV */
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
					$entries = $this->Entry_model->get_undeleted_entries(1, $per_page, $offset, $this->language_id);
					foreach($entries as $entry){
						$story = $this->Story_model->get_story_by_id($entry->type_id);
						$stories_array_of_objects[] = $story[0];		
					}
					$data['stories'] = $stories_array_of_objects;
 					$this->load->view("modules/dialog/stories_view", $data);
	}
	
	public function stories_ajax_edit($module_id, $offset = 0){
	
		$module = $this->Module_model->get_module_by_id($module_id);
		$data['module'] = $module;
		/* extract module instance params from database column params and create array */
		$params_data_array = explode(";;", $module[0]->params);
		$module_params = array();
		foreach ($params_data_array as $params_data){
			$param_data = explode(":=", $params_data);
			if($param_data[0] == "categories"){
				$param_data[1] = explode(",",$param_data[1]);
				//$module_params[$param_data[0]] = $param_data[1];
			}
				$module_params[$param_data[0]] = $param_data[1];
		}
		//var_dump($module_params);
		$data['module_params'] = $module_params;
		$total_rows = $this->Entry_model->get_number_of_non_deleted_entries_by_type(1);
		$per_page = "10";
		/*** load pagination ***/
		//$this->pagination->load_pagination("story/index/0", 4, $total_rows, $per_page);
		$config['uri_segment'] = 4;
		$config['num_links'] = 2;
		$config['base_url'] = base_url()."/module/stories_ajax_edit/".$module_id;
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$config['div'] = '#content'; /* Here #content is the CSS selector for target DIV */
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
		$entries = $this->Entry_model->get_undeleted_entries(1, $per_page, $offset, $this->language_id);
		foreach($entries as $entry){
			$story = $this->Story_model->get_story_by_id($entry->type_id);
			$stories_array_of_objects[] = $story[0];
		}
		$data['stories'] = $stories_array_of_objects;
		$this->load->view("modules/dialog/edit/stories_view", $data);
	}
	
	/**
	 * 
	 * Load on POST request when user submit first module to position
	 */
	public function load_add_module(){
		/*
		 * Parse POST and find name => values for all params
		 */
		//multiselect create array of params by default so we need special logic 
		//to create coma separated string of categories id
		//title, description, client_id, menu_id, postition_id are same for all module types
		foreach ($_POST as $key=>$value){
			if($key == "categories"){
				$param[] = $key.":=".implode(",",$value);
			}elseif($key != "module" && $key != "position_id" && $key != "menu_id" && $key != "module_title" && $key != "module_description" && $key != "name"){
				$param[] = $key.":=".$value;
			}
		}
		
		$params = implode(";;",$param);
		$data['params'] = $params;
		$data['module_title'] = $this->input->post('module_title');
		$data['module_description'] = $this->input->post('module_description');
		$data['module'] = $this->input->post('module');
		$data['menu_id'] = $this->input->post('menu_id');
		$data['position_id'] = $this->input->post('position_id');
		
		$data['module_id'] = $this->Module_model->insert($data['module_title'], $data['module_description'], $data['module'], $data['menu_id'], $data['position_id'], $this->language_id, $params);
		$this->load->view("modules/position_preview_view", $data);
	}
	
	public function load_module_by_id(){
		
		$module_id = $this->input->post('module_id');
		$module = $this->input->post('module');
		$position_id = $this->input->post('position_id');
		$menu_id = $this->input->post('menu_id');
		
		$module_object = $this->Module_model->get_module_by_id($module_id);
		$data['module_id'] = $module_id;
		$data['module'] = $module;
		$data['position_id'] = $position_id;
		$data['module_title'] = $module_object[0]->title;
		$data['module_description'] = $module_object[0]->description;
		$mod_pos_menu = $this->Module_model->get_module_by_menu_and_position($menu_id, $position_id);
		//var_dump($mod_pos_menu);
		if(count($mod_pos_menu) > 0){
			$this->Module_model->update_join($menu_id, $position_id, $module_id);
		}else{
			$this->Module_model->insert_join($menu_id, $position_id, $module_id);
		}
		$this->load->view("modules/position_preview_view", $data);
	
	}
	
	/**
	 * 
	 * Load tempalate for already set modules for each position, this function is load over jQuery .ajax on full page load (document ready)
	 */
	public function load(){
		$position_id = $this->input->post('position_id');
		$menu_id = $this->input->post('menu_id');
		
		//TODO:get module id by menu and position, if id > 0 display template with module data else return 0
		$menu_module_pos = $this->Module_model->get_module_by_menu_and_position($menu_id, $position_id);
		if(count($menu_module_pos) > 0){
			$module = $this->Module_model->get_module_by_id($menu_module_pos[0]->module_id);
			$data['module'] = $module[0]->module;
			$data['module_title'] = $module[0]->title;
			$data['module_description'] = $module[0]->description;
			$data['module_id'] = $menu_module_pos[0]->module_id;
			$data['position_id'] = $menu_module_pos[0]->position_id;
			$this->load->view("modules/position_preview_view", $data);
		}else{
			echo 0;
		}
		
	}
	
	/**
	 * 
	 * Function is load from jQuery .post metod when user submit module update from Replace Module flow
	 */
	public function load_replace_module(){
		/*
		 * Parse POST and find name => values for all params
		 */
		//multiselect create array of params by default so we need special logic 
		//to create coma separated string of categories id
		//title, description, client_id, menu_id, postition_id are same for all module types
		foreach ($_POST as $key=>$value){
			if($key == "categories"){
				$param[] = $key.":=".implode(",",$value);
			}elseif($key != "module" && $key != "position_id" && $key != "menu_id" && $key != "module_title" && $key != "module_description" && $key != "name"){
				$param[] = $key.":=".$value;
			}
		}
		
		$params = implode(";;",$param);
		$data['params'] = $params;
		$data['module_title'] = $this->input->post('module_title');
		$data['module_description'] = $this->input->post('module_description');
		$data['module'] = $this->input->post('module');
		$data['menu_id'] = $this->input->post('menu_id');
		$data['position_id'] = $this->input->post('position_id');
		
		$data['module_id'] = $this->Module_model->update($data['module_title'], $data['module_description'], $data['module'], $data['menu_id'], $data['position_id'], $params);
		$this->load->view("modules/position_preview_view", $data);
	}
	
	public function load_edit_module(){
		//$module = $this->input->post('module');
		$module_id = $this->input->post('module_id');
		$position_id = $this->input->post('position_id');
		//TODO: get module by ID
		$module = $this->Module_model->get_module_by_id($module_id);
		$data['module'] = $module;
		/* extract module instance params from database column params and create array */
		$params_data_array = explode(";;", $module[0]->params);
		$module_params = array();
		foreach ($params_data_array as $params_data){
			$param_data = explode(":=", $params_data);
			if($param_data[0] == "categories"){
				$param_data[1] = explode(",",$param_data[1]);
				//$module_params[$param_data[0]] = $param_data[1];
			}
				$module_params[$param_data[0]] = $param_data[1];
		}
		$data['module_params'] = $module_params;
		/* END OF extracting params */
		//var_dump($module_params);
		//var_dump($module);
		//exit;
		$objDOM = new DOMDocument(); 
		$objDOM->load("../application/modules/".$module[0]->module."/info.xml"); //make sure path is correct 
		$params = $objDOM->getElementsByTagName("params"); 
        
		// for each params tag, parse the document and get values for
		$data['root_module_name'] = $module[0]->module;
		$data['clients'] = $this->Client_model->get_all_clients();
		//load full menu tree
		$data['root_menus'] = $this->Menu_model->get_menu_kids(0, $this->language_id);
		$this->load->view("modules/dialog/edit/basic_params_view", $data);
		foreach ($params as $param){
            $data['group'] = $param->getAttribute("group");
            $this->load->view("modules/dialog/edit/attributes_group_view", $data);
			$param = $param->getElementsByTagName("param");
			foreach ($param as $param_item){
				    //mandatory attributes for all param types
					$data['default'] = $param_item->getAttribute("default");
					$data['name'] = $param_item->getAttribute("name");
					$data['label'] = $param_item->getAttribute("label");
					$data['cssclass'] = $param_item->getAttribute("cssclass");
				//load specific params with specific views for each param type
				if($param_item->getAttribute("type") == "select"){
					$data['options'] = $param_item->getElementsByTagName("option");
					$this->load->view("modules/dialog/edit/select_view", $data);
				}elseif($param_item->getAttribute("type") == "input"){
					$this->load->view("modules/dialog/edit/input_text_view", $data);
				}elseif($param_item->getAttribute("type") == "rich_text"){
					$this->load->view("modules/dialog/edit/rich_text_view", $data);
				}elseif($param_item->getAttribute("type") == "radio"){
					$data['options'] = $param_item->getElementsByTagName("option");
					$this->load->view("modules/dialog/edit/radio_view", $data);
				}elseif($param_item->getAttribute("type") == "tags"){
					//TODO:add possibility to filter content by tags
				}elseif($param_item->getAttribute("type") == "categories"){	
					$data['root_categories'] = $this->Category_model->get_category_kids(0, $this->language_id);
					$this->load->view("modules/dialog/edit/categories_view", $data);
				}elseif($param_item->getAttribute("type") == "menus"){
					//TODO: Load tree view of the menus with checkboxes
					$data['root_menus'] = $this->Menu_model->get_menu_kids(0, $this->language_id);
					$this->load->view("modules/dialog/edit/menus_view", $data);
				}elseif($param_item->getAttribute("type") == "stories"){
					
				//get all published and unpublished entries of the sotry type
					$total_rows = $this->Entry_model->get_number_of_non_deleted_entries_by_type(1);
					$per_page = "10";
					/*** load pagination ***/
					//$this->pagination->load_pagination("story/index/0", 4, $total_rows, $per_page);
					$config['uri_segment'] = 4;
					$config['num_links'] = 2;
					$config['base_url'] = base_url()."/module/stories_ajax_edit/".$module_id;
					$config['total_rows'] = $total_rows;
					$config['per_page'] = $per_page;
					$config['div'] = '#content'; /* Here #content is the CSS selector for target DIV */
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
					$entries = $this->Entry_model->get_undeleted_entries(1, $per_page, 0, $this->language_id);
					foreach($entries as $entry){
						$story = $this->Story_model->get_story_by_id($entry->type_id);
						$stories_array_of_objects[] = $story[0];		
					}
					$data['stories'] = $stories_array_of_objects;
 					$this->load->view("modules/dialog/edit/stories_view", $data);
				}
			}
			$this->load->view("modules/dialog/endof_attributes_group_view", $data);	
		}
	}
	
	//TODO: create metod submit edited module
	public function load_update_module(){
		/*
		 * Parse POST and find name => values for all params
		 */
		//multiselect create array of params by default so we need special logic 
		//to create coma separated string of categories id
		//title, description, client_id, menu_id, postition_id are same for all module types
		foreach ($_POST as $key=>$value){
			if($key == "categories"){
				$param[] = $key.":=".implode(",",$value);
			}elseif($key != "module" && $key != "position_id" && $key != "menu_id" && $key != "module_title" && $key != "module_description" && $key != "name"){
				$param[] = $key.":=".$value;
			}
		}
		
		$params = implode(";;",$param);
		$data['params'] = $params;
		$data['module_title'] = $this->input->post('module_title');
		$data['module_description'] = $this->input->post('module_description');
		$data['module'] = $this->input->post('module');
		$data['menu_id'] = $this->input->post('menu_id');
		$data['position_id'] = $this->input->post('position_id');
		$data['module_id'] = $this->input->post('module_id');
 		$this->Module_model->update_module_instance($data['module_title'], $data['module_description'], $data['menu_id'], $data['position_id'], $data['module_id'], $params);
		
 		$this->load->view("modules/position_preview_view", $data);
	}
	
//NOT IN USE FOR CURRENT VERSION OF THE SOFTWARE
	/**
	 * 
	 * Function display list of avalabile modules in the system using info.xml files in modules folders on front end(client)
	 * @param int $message_id
	 */
	public function index($message_id = 0){
		
		//$data['modules'] = $this->Module_model->get_all_modules();
		if ($message_id == 1){
			$message = $this->lang->line('message_story_added_successfully');
		} elseif ($message_id == 2) {
			$message = $this->lang->line('message_story_adding_faild');
		} elseif ($message_id == 3){
			$message = $this->lang->line('message_story_updated_successfully');
		} else {
			$message = "";
		}
		
		$modules_directories = directory_map('../application/modules/',1);
		//create array using only modules which are contain xml description file
		foreach($modules_directories as $module){
			if (file_exists('../application/modules/'.$module.'/info.xml')){
				$modules[] = $module;
			}
		}
		$data['modules'] = $modules;
		$data['message'] = $message;
		$this->load->view("header_view");
        $this->load->view("modules/modules_home_view", $data);
	}
	
	//NOT IN USE FOR CURRENT VERSION OF THE SOFTWARE
	/**
	 * 
	 * Parsing XML and display form for creating new module instance of selected module
	 * by module name
	 * @param string $module Module name
	 */
	public function new_module($module){
		
		$objDOM = new DOMDocument(); 
		$objDOM->load("../application/modules/".$module."/info.xml"); //make sure path is correct 
		$params = $objDOM->getElementsByTagName("params"); 
        
		// for each params tag, parse the document and get values for
		//load main header
		$this->load->view("header_view");
		$data['module'] = $module;
		$data['clients'] = $this->Client_model->get_all_clients();
		//load full menu tree
		$data['root_menus'] = $this->Menu_model->get_menu_kids(0);
		//load containers of the view
		$this->load->view("modules/head_new_module_form_view", $data);
		foreach ($params as $param){
            $data['group'] = $param->getAttribute("group");
            $this->load->view("modules/attributes_group_view", $data);
			$param = $param->getElementsByTagName("param");
			foreach ($param as $param_item){
				    //mandatory attributes for all param types
					$data['default'] = $param_item->getAttribute("default");
					$data['name'] = $param_item->getAttribute("name");
					$data['label'] = $param_item->getAttribute("label");
					$data['cssclass'] = $param_item->getAttribute("cssclass");
				//load specific params with specific views for each param type
				if($param_item->getAttribute("type") == "select"){
					$data['options'] = $param_item->getElementsByTagName("option");
					$this->load->view("modules/select_view", $data);
				}elseif($param_item->getAttribute("type") == "input"){
					$this->load->view("modules/input_text_view", $data);
					}elseif($param_item->getAttribute("type") == "rich_text"){
					$this->load->view("modules/rich_text_view", $data);
				}elseif($param_item->getAttribute("type") == "radio"){
					$data['options'] = $param_item->getElementsByTagName("option");
					$this->load->view("modules/radio_view", $data);
				}elseif($param_item->getAttribute("type") == "tags"){
					//TODO:add possibility to filter content by tags
				}elseif($param_item->getAttribute("type") == "categories"){	
					//TODO: Load tree view of the categories with checkboxes
					$data['root_categories'] = $this->Category_model->get_category_kids(0);
					$this->load->view("modules/categories_view", $data);
				}elseif($param_item->getAttribute("type") == "menus"){
					//TODO: Load tree view of the menus with checkboxes
				}
			}
			$this->load->view("modules/endof_attributes_group_view", $data);	
		}
		$this->load->view("modules/foot_new_module_form_view");
	}
	
	//NOT IN USE FOR CURRENT VERSION OF THE SOFTWARE
	/**
	 * 
	 * Insert POST data for module instance 
	 */
	public function add_new(){
		/*
		 * Parse POST and find name => values for all params
		 */
		//multiselect create array of params by default so we need special logic 
		//to create coma separated string of categories id
		//title, description, client_id, menu_id, postition_id are same for all module types
		foreach ($_POST as $key=>$value){
			if($key == "module_title"){
				$module_title = $value;
			}elseif($key == "module_description"){	
				$module_description = $value;
			}elseif($key == "client"){	
				$client_id = $value;
			}elseif($key == "module"){
				$module = $value;
			}elseif($key == "menus"){
				$menus = $value;
			}elseif($key == "position_id"){
				$position_id = $value;			
			}elseif($key == "categories"){
				$param[] = $key.":=".implode(",",$value);
			}else{
				$param[] = $key.":=".$value;
			}
		}
		
		$params = implode(";;",$param);
		$this->Module_model->insert($module_title, $module_description, $module, $params);
		redirect("module/instances/".$module);
	
	}
	
	//NOT IN USE FOR CURRENT VERSION OF THE SOFTWARE
	public function instances($module){
		$data['instances'] = $this->Module_model->get_by_module($modulem, $this->language_id);
		$data['module'] = $module;
		$this->load->view("header_view");
        $this->load->view("modules/module_instances_home_view", $data);
	}
}