<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menus extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->helper('menus_helper.php');
		$this->load->model('Menus_model');
		$this->load->model('position/Position_model');
			
	}

	

	function displayme($module_id, $data=array()){
		//print_r($data);
		$menu_id = $data['menu_id'];
		//load module instance by id
		$module_instance = $this->Position_model->get_module_by_id($module_id);
		//load module params
//		$params_data_array = explode(";;",$module_instance[0]->params);
//		$module_params = array();
//		foreach ($params_data_array as $params_data){
//			$param_data = explode(":=", $params_data);
//			if($param_data[0] == "categories"){
//				$param_data[1] = explode(",",$param_data[1]);
//				//$module_params[$param_data[0]] = $param_data[1];
//			}
//				$module_params[$param_data[0]] = $param_data[1];
//		}
                $module_params = unserialize( $module_instance[0]->params );
		//var_dump($module_params);
                //load menu
		$menuItems = $this->Menus_model->get_menu_kids($module_params['menus_id'], $this->session->userdata('language_id'));
		//var_dump($menuItems);
                include $this->load->_ci_model_paths[0].'views/menu_view.php';
	}			
	
}

/* End of file menus.php */
/* Location: ./application/modules/menus/controllers/menus.php */
