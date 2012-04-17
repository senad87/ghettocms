<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Newsletter extends MX_Controller {
	
	
	public $id;
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model('Newsletter_model');
		//$this->load->library('pagination');
	}
	
	function displayme($module_id, $data=array(), $offset = 0){
		//$this->id = $module_id;
		//var_dump(count($data));
		//TODO: This is big hack fix ASAP
		//var_dump($data);
		$data_menu_id = $data;
		if(!is_array($data)){
			$data = array();
			$data['menu_id'] = $data_menu_id;
		}
	
		$module_instance = $this->Position_model->get_module_by_id($module_id);
		//load module params
		$params_data_array = explode(";;",$module_instance[0]->params);
		$module_params = array();
		foreach ($params_data_array as $params_data){
			$param_data = explode(":=", $params_data);
			$module_params[$param_data[0]] = $param_data[1];
		}
		//print_r($this->load->_ci_model_paths[0]);
		include $this->load->_ci_model_paths[0].'views/search_box_view.php';

	}	

	function post(){
		
	}
	
	function dispsub($id, $sub, $data){
		
	

		include APPPATH."/modules/newsletter/views/succes.php";
	}
	
	
	
	function test(){
		echo 'test';
	}
			
	
}

/* End of file articles.php */
/* Location: ./application/modules/articles/controllers/articles.php */
