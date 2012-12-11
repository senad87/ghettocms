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
                $module_params = unserialize( $module_instance[0]->params );
		
		include $this->load->_ci_model_paths[0].'views/plain_html_view.php';
		//$this->load->view("plain_html_view", $data);
	}
}
/* End of file plain_html.php */
/* Location: ./application/modules/plain_html/controllers/plain_html.php */