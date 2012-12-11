<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Languages extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model('Languages_model');
	}

	public function change($id){
		//Check and get language by id if OK set language into session
		$language = $this->Languages_model->get_by_id($id);
		if($language){
			$this->session->set_userdata('language_id', $language->id);
			$this->session->set_userdata('language', $language->language);
			redirect(base_url());
		}
		//if language with given ID does not exist do not change session data
	}
}