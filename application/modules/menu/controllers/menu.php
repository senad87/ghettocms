<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model('Menu_model');
		$this->load->model('templates/Templates_model');
		$this->load->model('languages/Languages_model');
		
	}
	/**
	 * 
	 * Display all pages from menu, handle every request
	 * @param int $id
	 * @param int $sub
	 */
    function index($id = 0, $sub=false){
	//set language
	//TODO: Get language by ID
	//print_r("Hello");
    	$session_language_id = $this->session->userdata('language_id');
    	//if no language data in session set default
    	//var_dump($session_language_id);
    	if(!$session_language_id){
		$language = $this->Languages_model->get_by_id(1);
		$user_session_data = array("language_id" => 1, "language" => $language->language);
		$session_language_id = 1;
		$this->session->set_userdata($user_session_data);
    	}
    	
	if($id == 0){
		$menu = $this->Menu_model->get_home_menu($session_language_id);
	}else{
		$menu = $this->Menu_model->get_menu_by_id($id);
	}
	
	$data['menu'] = $menu;
	if(is_array($sub)){
		$data['sub'] = $sub;
		$data['offset'] = false;
	}else{
		$data['sub'] = false;
		$data['offset'] = $sub; //if sub is a string that means that offset is in its place for pagination purpose
	}
	
	$template = $this->Templates_model->get_template_by_id($menu[0]->template_id);
	$template_file_name_array = explode(".", $template[0]->file_name);	
	$template_file_name = $template_file_name_array[0];
	
	$this->load->view($template_file_name, $data);
	}
	
}
/* End of file Menu.php */
/* Location: ./application/modules/page/controllers/menu.php */
