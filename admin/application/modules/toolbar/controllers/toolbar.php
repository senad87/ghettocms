<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Toolbar extends MX_Controller {

	function __construct()
	{
		//check_login();
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		//$this->load->model('Articles_model');
		//$this->load->model('categories/Categories_model');	
	}

	function index($title, $module, $buttons){
		$data['title'] = $title;
		$data['module'] = $module;
		$data['buttons'] = $buttons;
		
		/*foreach($buttons as $button){
			
			$data['buttons'][] = explode('|', $button);
		}
		print_r($data['buttons']);die;*/
		
		$this->load->view('toolbar_view', $data);
		$this->load->style('validation_style');
		$this->load->script('jquery_validation_script');
		$this->load->script('jquery_bt_min_script');
		$this->load->script('toolbar_script', $data);
		//$this->load->style('ketchup_style', $data);
		
		
			
	}
	
	function item($id, $title, $module, $buttons){
		$data['title'] = $title;
		$data['module'] = $module;
		$data['buttons'] = $buttons;
		$data['id'] = $id;
		//unutar viewa jedan foreach koji ce da izrenderuje sva dugmad prosledjena iz viewa
		$this->load->view('itemToolbar_view', $data);
	}
}
/* End of file toolbar.php */
/* Location: ./application/modules/toolbar/controllers/toolbar.php */
