<?php

class Module extends MX_Controller {

	private $language_id = 1;
	
	function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper( array('module', 'login', 'xml2array', 'menus_tree', 'categories_list', 'directory') );
        $this->load->model('Menu_model');
        $this->load->model('category/Category_model');
        $this->load->model('banners/Banners_model');
        $this->load->model('Entry_model');
        $this->load->model('story/Story_model');
        $this->load->model('images/Images_model');
        $this->load->model('Client_model');
        $this->load->model('Module_model');
        $this->load->model('Module_instance_model');
        $this->load->library('MYJquery_pagination');

        $this->lang->load('messages', 'english');
        $this->language_id = $this->session->userdata('language_id');

        check_login();
    }
    
    /**
	 * Parsing XML and display form for creating new module instance of selected module
	 * by module name provided as POST param through jQuery .load request
	 * 
	 */
    public function load_new_module() {
        
        $module = $this->input->post('module');
        $objDOM = new DOMDocument();
        $objDOM->load( "../application/modules/" . $module . "/info.xml" ); //make sure path is correct 
        //TODO: This is empty for single_story module, must fix this
        $params = $objDOM->getElementsByTagName( "params" );
        
        // for each params tag, parse the document and get values for
        $data['module'] = $module;
        $data['clients'] = $this->Client_model->get_all_clients();
        //load full menu tree
        $data['root_menus'] = $this->Menu_model->get_menu_kids(0, $this->language_id);
        $this->load->view("dialog/basic_params_view", $data);
        foreach ($params as $param) {
            $data['group'] = $param->getAttribute("group");
            $this->load->view("dialog/attributes_group_view", $data);
            $param = $param->getElementsByTagName("param");
            foreach ($param as $param_item) {
                //mandatory attributes for all param types
                $data['default'] = $param_item->getAttribute("default");
                $data['name'] = $param_item->getAttribute("name");
                $data['label'] = $param_item->getAttribute("label");
                $data['cssclass'] = $param_item->getAttribute("cssclass");
                //pre_dump( $data );
                //load specific params with specific views for each param type
                if ($param_item->getAttribute("type") == "select") {
                    $data['options'] = $param_item->getElementsByTagName("option");
                    $this->load->view("dialog/select_view", $data);
                } elseif ($param_item->getAttribute("type") == "input") {
                    $this->load->view("dialog/input_text_view", $data);
                } elseif ($param_item->getAttribute("type") == "rich_text") {
                    $this->load->view("dialog/rich_text_view", $data);
                } elseif ($param_item->getAttribute("type") == "radio") {
                    $data['options'] = $param_item->getElementsByTagName("option");
                    $this->load->view("dialog/radio_view", $data);
                } elseif ($param_item->getAttribute("type") == "tags") {
                    //TODO:add possibility to filter content by tags
                } elseif ($param_item->getAttribute("type") == "categories") {
                    $data['root_categories'] = $this->Category_model->get_category_kids(0, $this->language_id);
                    $this->load->view("dialog/categories_view", $data);
                } elseif ($param_item->getAttribute("type") == "menus") {
                    //Load tree view of the root menus with radio buttons, only load root menus
                    $data['root_menus'] = $this->Menu_model->get_menu_kids(0, $this->language_id);
                    $this->load->view("dialog/menus_view", $data);
                } elseif ($param_item->getAttribute("type") == "menu_tree") {
                    //Load tree view of the root menus with radio buttons, only load root menus
                    $data['root_menus'] = $this->Menu_model->get_menu_kids(0, $this->language_id);
                    $this->load->view("dialog/menus_view", $data);
                } elseif ($param_item->getAttribute("type") == "stories") {
                    //get all published and unpublished entries of the story type
                    //$total_rows = $this->Entry_model->get_number_of_non_deleted_entries_by_type(1, $this->language_id);
                    $total_rows = $this->Entry_model->countByType(1, $this->language_id);
                    //pre_dump( $total_rows );
                    $per_page = "10";
                    /*** load pagination ***/
                    $this->myjquery_pagination->load_pagination( base_url() . "/module/stories_ajax", 4, $total_rows, $per_page, "#content" );
                    $data['pagination'] = $this->myjquery_pagination->create_links();
                    /*** end of pagination ** */
                    $data['entries'] = $this->Entry_model->getUndeleted(1, $per_page, 0, $this->language_id);
                    $this->load->view("dialog/stories_view", $data);
                }elseif ( $param_item->getAttribute("type") == "photo_size" ) {
                    //TODO: Get Photo size from database tabe dimeznions
                    $data['dimensions'] = $this->Images_model->getDimensions();
                    //pre_dump($data);
                    $this->load->view("dialog/photosize_view", $data);
                }elseif( $param_item->getAttribute("type") == "dragdrop" ){
                    $data = array();
                    //get all published and unpublished entries of the story type
                    $total_rows = $this->Banners_model->countActive( $this->language_id );
                    $per_page = "2";
                    /*** load pagination ***/
                    $this->myjquery_pagination->load_pagination( base_url() . "/module/banners_ajax", 4, $total_rows, $per_page);
                    $data['pagination'] = $this->myjquery_pagination->create_links();
                    /*** end of pagination ***/
                    $data['items'] = $this->Banners_model->getActiveLimited($per_page, 0, $this->language_id, 1);
                    //pre_dump($data['items']);
                    $this->load->view("dialog/dragdrop_view", $data);
                }
                //TODO: Add menu_tree type
            }
            $this->load->view("dialog/endof_attributes_group_view", $data);
        }
    }

    
    public function load_add_module(){
		/*
		 * Parse POST and find name => values for all params
		 */
		//multiselect create array of params by default so we need special logic 
		//to create coma separated string of categories id
		//title, description, client_id, menu_id, postition_id are same for all module types

                
                /*
                 * Parse POST and find name => values for all params
                 */
                $data['params'] = serializePost( $_POST );
		//$data['params'] = $params;
		$data['module_title'] = $this->input->post('module_title');
		$data['module_description'] = $this->input->post('module_description');
		$data['module'] = $this->input->post('module');
		$data['menu_id'] = $this->input->post('menu_id');
		$data['position_id'] = $this->input->post('position_id');
                $data['entry_page'] = $this->input->post('entry_page');
                if($data['entry_page'] == 1){
                    $data['storypos_id'] = "story-";
                }else{
                    $data['storypos_id'] = "";
                }
                
		$data['module_id'] = $this->Module_model->insert($data['module_title'], $data['module_description'], $data['module'], $data['menu_id'], $data['position_id'], $this->language_id, $data['params'], $data['entry_page'] );
		$data['hasModule'] = TRUE;
                $this->load->view("position_preview_view", $data);
	}
    /**
     * 
     * Load tempalate for already set modules for each position, this function is load over jQuery .ajax on full page load (document ready)
     */
    public function load() {
        
        $position_id = $this->input->get_post('position_id', TRUE);
        $menu_id = $this->input->get_post('menu_id', TRUE);
        $entry_page = $this->input->get_post('entry_page', TRUE);//for entry page templates type
        if($entry_page == 1){
            $data['storypos_id'] = "story-";
        }else{
            $data['storypos_id'] = "";
        }
        //var_dump($entry_page);
        //TODO:get module id by menu and position, if id > 0 display template with module data else return 0
        $menu_module_pos = $this->Module_model->get_module_by_menu_and_position($menu_id, $position_id, $entry_page);
        
        if (count($menu_module_pos) > 0) {
            //var_dump( $menu_module_pos[0] );
            $module = $this->Module_model->get_module_by_id($menu_module_pos[0]->module_id);
            //var_dump( $module );
            if( count($module) > 0 ){
                $data['hasModule'] = TRUE;
                $data['module'] = $module[0]->module;
                $data['module_title'] = $module[0]->title;
                $data['module_description'] = $module[0]->description;
                $data['module_id'] = $menu_module_pos[0]->module_id;
                $data['position_id'] = $menu_module_pos[0]->position_id;
                $this->load->view("position_preview_view", $data);
            }else{
                $data['hasModule'] = FALSE;
                $this->load->view("empty_position_view", $data);
            }
        } else {
            echo 0;
        }
    }

    /**
     * 
     * Function is load from jQuery .post metod when user submit module update from Replace Module flow
     */
    public function replace() {
        /*
         * Parse POST and find name => values for all params
         */
        $data['params'] = serializePost( $_POST );
        $data['module_title'] = $this->input->post('module_title');
        $data['module_description'] = $this->input->post('module_description');
        $data['module'] = $this->input->post('module');
        $data['menu_id'] = $this->input->post('menu_id');
        $data['position_id'] = $this->input->post('position_id');
        $data['entry_page'] = $this->input->post('entry_page');
        if($data['entry_page'] == 1){
            $data['storypos_id'] = "story-";
        }else{
            $data['storypos_id'] = "";
        }
        $data['module_id'] = $this->Module_model->update($data['module_title'], $data['module_description'], $data['module'], $data['menu_id'], $data['position_id'], $data['params'], $data['entry_page']);
        $data['hasModule'] = TRUE;
        $this->load->view("position_preview_view", $data);
    }
    
    public function load_module_by_id() {

        $module_id = $this->input->post('module_id');
        $module = $this->input->post('module');
        $position_id = $this->input->post('position_id');
        $menu_id = $this->input->post('menu_id');
        $entry_page = $this->input->post('entry_page');
        
        $module_object = $this->Module_model->get_module_by_id($module_id);
        $data['module_id'] = $module_id;
        $data['module'] = $module;
        $data['position_id'] = $position_id;
        $data['module_title'] = $module_object[0]->title;
        $data['module_description'] = $module_object[0]->description;
        
        $mod_pos_menu = $this->Module_model->get_module_by_menu_and_position($menu_id, $position_id, $entry_page);
        $data['hasModule'] = TRUE;
        if (count($mod_pos_menu) > 0) {
            $this->Module_model->update_join($menu_id, $position_id, $module_id, $entry_page);
        } else {
            $this->Module_model->insert_join($menu_id, $position_id, $module_id, $entry_page);
        }
        if($entry_page == 1){
            $data['storypos_id'] = "story-";
        }else{
            $data['storypos_id'] = "";
        }
        $this->load->view("position_preview_view", $data);
    }
    
    //TODO: create metod submit edited module
    public function load_update_module() {
        /*
         * Parse POST and find name => values for all params
         */
        $data['params'] = serializePost( $_POST );
        $data['module_title'] = $this->input->post('module_title');
        $data['module_description'] = $this->input->post('module_description');
        $data['module'] = $this->input->post('module');
        $data['menu_id'] = $this->input->post('menu_id');
        $data['position_id'] = $this->input->post('position_id');
        $data['module_id'] = $this->input->post('module_id');
        $data['entry_page'] = $this->input->post('entry_page');
        if( $data['entry_page'] == 1 ){
            $data['storypos_id'] = "story-";
        }else{
            $data['storypos_id'] = "";
        }
        $this->Module_model->update_module_instance($data['module_title'], $data['module_description'], $data['menu_id'], $data['position_id'], $data['module_id'], $data['params']);
        $data['hasModule'] = TRUE;
        $this->load->view("position_preview_view", $data);
    }
    
    public function load_edit_module() {
        //$module = $this->input->post('module');
        $module_id = $this->input->post('module_id');
        $position_id = $this->input->post('position_id');
        //TODO: get module by ID
        $module = $this->Module_model->get_module_by_id($module_id);
        $data['module'] = $module;
        /* extract module instance params from database column params and create array */
        $data['module_params'] = unserialize($module[0]->params);
        $objDOM = new DOMDocument();
        $objDOM->load("../application/modules/" . $module[0]->module . "/info.xml"); //make sure path is correct 
        $params = $objDOM->getElementsByTagName("params");
        //for each params tag, parse the document and get values for
        $data['root_module_name'] = $module[0]->module;
        $data['clients'] = $this->Client_model->get_all_clients();
        //load full menu tree
        $data['root_menus'] = $this->Menu_model->get_menu_kids(0, $this->language_id);
        $this->load->view("dialog/edit/basic_params_view", $data);
        foreach ($params as $param) {
            $data['group'] = $param->getAttribute("group");
            $this->load->view("dialog/edit/attributes_group_view", $data);
            $param = $param->getElementsByTagName("param");
            foreach ($param as $param_item) {
                //mandatory attributes for all param types
                $data['default'] = $param_item->getAttribute("default");
                $data['name'] = $param_item->getAttribute("name");
                $data['label'] = $param_item->getAttribute("label");
                $data['cssclass'] = $param_item->getAttribute("cssclass");
                //load specific params with specific views for each param type
                if ($param_item->getAttribute("type") == "select") {
                    $data['options'] = $param_item->getElementsByTagName("option");
                    $this->load->view("dialog/edit/select_view", $data);
                } elseif ($param_item->getAttribute("type") == "input") {
                    $this->load->view("dialog/edit/input_text_view", $data);
                } elseif ($param_item->getAttribute("type") == "rich_text") {
                    $this->load->view("dialog/edit/rich_text_view", $data);
                } elseif ($param_item->getAttribute("type") == "radio") {
                    $data['options'] = $param_item->getElementsByTagName("option");
                    $this->load->view("dialog/edit/radio_view", $data);
                } elseif ($param_item->getAttribute("type") == "tags") {
                    //TODO:add possibility to filter content by tags
                } elseif ($param_item->getAttribute("type") == "categories") {
                    $data['root_categories'] = $this->Category_model->get_category_kids(0, $this->language_id);
                    $this->load->view("dialog/edit/categories_view", $data);
                } elseif ($param_item->getAttribute("type") == "menus") {
                    //TODO: Load tree view of the menus with checkboxes
                    $data['root_menus'] = $this->Menu_model->get_menu_kids(0, $this->language_id);
                    $this->load->view("modules/dialog/edit/menus_view", $data);
                } elseif ($param_item->getAttribute("type") == "stories") {

                    //get all published and unpublished entries of the sotry type
                    //$total_rows = $this->Entry_model->get_number_of_non_deleted_entries_by_type(1);
                    $total_rows = $this->Entry_model->countByType(1, $this->language_id);
                    $per_page = "10";
                    /*** load pagination ***/
                    $this->myjquery_pagination->load_pagination( base_url() . "/module/stories_ajax_edit/" . $module_id, 4, $total_rows, $per_page, "#content" );
                    $data['pagination'] = $this->myjquery_pagination->create_links();
                    /*** end of pagination ***/
                    $data['entries'] = $this->Entry_model->getUndeleted(1, $per_page, 0, $this->language_id);
                    $this->load->view("dialog/edit/stories_view", $data);
                    
                }elseif ( $param_item->getAttribute("type") == "photo_size" ){
                    $data['dimensions'] = $this->Images_model->getDimensions();
                    $this->load->view("dialog/edit/photosize_view", $data);
                }elseif( $param_item->getAttribute("type") == "dragdrop" ){
                    $set_items = array();
                    //var_dump( $data['module_params']['items'] );
                    foreach ($data['module_params']['items'] as $set_item){
                        //var_dump($set_item);
                        $set_items[] = $this->Banners_model->getBannerByID($set_item);
                    }
                    //var_dump($set_items);
                    $data['set_items'] = $set_items;
                    //get all published and unpublished entries of the story type
                    $total_rows = $this->Banners_model->countActive( $this->language_id );
                    $per_page = "2";
                    /*** load pagination ***/
                    $this->myjquery_pagination->load_pagination( base_url() . "/module/banners_ajax", 3, $total_rows, $per_page);
                    $data['pagination'] = $this->myjquery_pagination->create_links();
                    /*** end of pagination ***/
                    $data['items'] = $this->Banners_model->getActiveLimited($per_page, 0, $this->language_id, 1);
                    //pre_dump($data['items']);
                    $this->load->view("dialog/edit/dragdrop_view", $data);
                }
            }
            $this->load->view("dialog/endof_attributes_group_view", $data);
        }
    }
    
    public function banners_ajax($offset = 0) {

        $data = array();
        //get all published and unpublished entries of the story type
        $total_rows = $this->Banners_model->countActive($this->language_id);
        $per_page = "2";
        /*         * * load pagination ** */
        $this->myjquery_pagination->load_pagination( base_url() . "/module/banners_ajax", 3, $total_rows, $per_page);
        $data['pagination'] = $this->myjquery_pagination->create_links();
        /*         * * end of pagination ** */
        $data['items'] = $this->Banners_model->getActiveLimited($per_page, $offset, $this->language_id, 1);
        //pre_dump($data['items']);
        $this->load->view("dialog/dragdrop_ajax_view", $data);
    }

    public function stories_ajax($offset = 0) {

        $total_rows = $this->Entry_model->countByType(1, $this->language_id);
        $per_page = "10";
        /*         * * load pagination ** */
        $this->myjquery_pagination->load_pagination( base_url() . "/module/stories_ajax", 3, $total_rows, $per_page, "#content" );
        $data['pagination'] = $this->myjquery_pagination->create_links();
        /*         * * end of pagination ** */
        $data['entries'] = $this->Entry_model->getUndeleted(1, $per_page, $offset, $this->language_id);
        $this->load->view("dialog/stories_view", $data);
    }
    
    public function stories_ajax_edit($module_id, $offset = 0) {

        $module = $this->Module_model->get_module_by_id($module_id);
        $data['module'] = $module;
        $data['module_params'] = unserialize( $module[0]->params );
        $total_rows = $this->Entry_model->countByType(1, $this->language_id);
        $per_page = "10";
        /*** load pagination ***/
        $this->myjquery_pagination->load_pagination( base_url() . "/module/stories_ajax_edit/" . $module_id, 4, $total_rows, $per_page, "#content" );
        $data['pagination'] = $this->myjquery_pagination->create_links();
        /*         * * end of pagination ** */
        $data['entries'] = $this->Entry_model->getUndeleted(1, $per_page, $offset, $this->language_id);
        $this->load->view("dialog/edit/stories_view", $data);
    }
}