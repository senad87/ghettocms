<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Position extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model('Position_model');	
	}
	//senad: dodao $sub_module_id, ako je prosledjena ova vrednost, umesto modula koji bi se inace prikazao, prikazuje se modul sa id-jem $sub_module_id
	//ako je sub array onda sadrzi informacije vezane za modul, a ako je string onda e offser.
	//Ovde treba preimenovati promenjivu kako bi bilo ocigledno sta se desava, nazvatije additional data, $add_data ili tako nesto
	function index($position_id, $menu_id, $sub=false, $offset=0, $entry_page=0){
		
		$data['menu_id'] = $menu_id;
		$data['offset'] = $offset;
		//TODO: ovde treba dodati proveru da li
		//      na toj poziciji postoji modul pa tek onda raditi upite
		//print_r($position_name);
		$module_pos_menu = $this->Position_model->get_module_by_menu_and_position($menu_id, $position_id, $entry_page);
		$module_instance = $this->Position_model->get_module_by_id($module_pos_menu[0]->module_id);
		//var_dump( $module_instance );
		$module_name = $module_instance[0]->module;
		$module = $this->load->module($module_name);
		//var_dump($sub['module_id']);
		if(isset($sub['module_id'])){
			$sub_module_instance = $this->Position_model->get_module_by_id($sub['module_id']);
			$sub_module_name = $sub_module_instance[0]->module;
			$sub_module = $this->load->module($sub_module_name);
			$sub_module->dispsub($sub_module_instance[0]->id, $sub, $data);
		}else{
			//var_dump($module);
			$module->displayme($module_instance[0]->id, $data);
		}
	}
	
		
}

/* End of file position.php */
/* Location: ./application/modules/position/controllers/position.php */
