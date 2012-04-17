<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Templates extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		//$this->load->helper(array('form', 'url'));
		$this->load->model('Templates_model');
		
	}
	
}