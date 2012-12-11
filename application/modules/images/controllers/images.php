<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Images extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model('Images_model');
	}
	
	public function resize($img_id, $width, $height){
		var_dump($img_id);
		print_r($width);
		print_r($height);
	}
}