<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plain_html extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model('articles/Articles_model');
		$this->load->model('users/Users_model');
		$this->load->model('categories/Categories_model');
		$this->load->model('images/Images_model');
		$this->load->model('stories/Stories_model');
	}
	
	function displayme($module_id, $data=array()){
		$module_instance = $this->Position_model->get_module_by_id($module_id);
		//load module params
		$params_data_array = explode(";;",$module_instance[0]->params);
		$module_params = array();
		foreach ($params_data_array as $params_data){
			$param_data = explode(":=", $params_data);
			/*if($param_data[0] == "categories"){
				$param_data[1] = explode(",",$param_data[1]);
				//$module_params[$param_data[0]] = $param_data[1];
			}*/
				
			$module_params[$param_data[0]] = $param_data[1];
				
		}
		//var_dump($module_params['html_source']);
		//$data['plain_html'] = $module_params['html_source'];
		include $this->load->_ci_model_paths[0].'views/plain_html_view.php';
		//$this->load->view("plain_html_view", $data);
	}
}
/* End of file plain_html.php */
/* Location: ./application/modules/plain_html/controllers/plain_html.php */