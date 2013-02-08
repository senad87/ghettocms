<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Four extends MX_Controller {

	
	function __construct()
	{
		parent::__construct();

	}
	
	function test($data){
		$menu_id = $data['menu_id'];
		include "application/modules/four/views/four_view.php";
	}	

		
	
}

/* End of file articles.php */
/* Location: ./application/modules/articles/controllers/articles.php */
