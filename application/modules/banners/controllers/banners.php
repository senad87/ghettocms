<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banners extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model('Banners_model');
		
	}
        
        public function displayme($module_id, $data = array(), $offset = 0) {

            //TODO: This is big hack fix ASAP
            $data_menu_id = $data;
            if (!is_array($data)) {
                $data = array();
                $data['menu_id'] = $data_menu_id;
            }
            //load module instance by id
            $module_instance = $this->Position_model->get_module_by_id($module_id);
            $module_params = unserialize($module_instance[0]->params);
            //var_dump($module_params);
            foreach ($module_params['items'] as $set_item) {
                //var_dump($set_item);
                $items[] = $this->Banners_model->getBannerByID($set_item);
            }
            $data['items'] = $items;
            //pre_dump($data['items']);
            
            $this->load->view( "slider_view", $data );
        }
}