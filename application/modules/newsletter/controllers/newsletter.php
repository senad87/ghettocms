<?php 

class Newsletter extends MX_Controller {

public $id;
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model('Newsletter_model');
		$this->load->model('position/Position_model');
		$this->load->library('pagination');
		$this->load->library('form_validation');
	}
	
	function displayme($module_id, $data=array(), $offset = 0){
		//print_r($this->session->userdata);
		//$this->id = $module_id;
		//var_dump(count($data));
		//TODO: This is big hack fix ASAP
		//var_dump($data);
		if(isset($data['message'])){
			$message = $data['message'];
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
		include APPPATH.'modules/newsletter/views/newsletter_box_view.php';

	}

		
		public function subscribe(){
				//error_reporting(E_ALL);
			    //$email = $this->params->getParam(PARAM_POST, "email", "string");
			    $this->form_validation->set_message('required', trans('Ovo polje je obavezno.'));
				$this->form_validation->set_message('valid_email', trans('Molimo unesite validnu adresu.'));
			    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			    
			    $menu = $this->load->module('menu');
			    $email = $this->input->post('email');
			    $sub['module_id'] = $this->input->post('id');
			    $sub['email'] = $email;
			    $subscribed = $this->Newsletter_model->getMail($email);
			    //var_dump($subscribed);
			    //var_dump($module_id);
			    //$isAlreadySubscribed = $this->Newsletter_model->isAlreadySubscribed($email);
				if($this->form_validation->run() == FALSE){
					$menu->index(0, $sub);
				}else{
					if($subscribed){
						$sub['message'] = trans("Već ste prijavljeni.");
					}else{
						$this->session->set_userdata('newsletter', 'subscribed');
						$this->Newsletter_model->subscribe($email);
						$sub['message'] = trans("Uspešno ste se prijavili");
					}
					$menu->index(0, $sub);
				}
	
			}
		
		public function sub(){
				$menu = $this->load->module('menu');
				$id = $this->uri->segment(3);
				$sub['module_id']=$id;
				$menu->index(0, $sub);
		}
			
			public function unsubscribe(){
				$menu = $this->load->module('menu');
				$md5 = $this->uri->segment(3);
				$sub['module_id'] = 497; //ovo je hardkodirano, moram da smilim sistem, kako da prebacujem module id
				if($this->Newsletter_model->unsubscribe($md5)){
					$sub['message'] = trans("Uspešno ste se odjavili.");
				}else{
					$sub['message'] = trans("Greška. Molimo probajte kasnije.");
				}
					$menu->index(0, $sub);
			}
			
	function dispsub($id='', $sub='', $data=''){
		//var_dump($sub);
		$module_id = $id;
		@$message = $sub['message'];
		include APPPATH."modules/newsletter/views/newsletter_center_view.php";
	}
	
	
	/*public function email_check($email){
		$isAlreadySubscribed = $this->Newsletter_model->isAlreadySubscribed($email);
		var_dump($isAlreadySubscribed);
		if (!$isAlreadySubscribed){
			$this->form_validation->set_message('username_check', 'Već ste se prijavili.');
			return FALSE;
		}else{
			return TRUE;
		}	
	}*/
	
	
	
}
?>	
		
