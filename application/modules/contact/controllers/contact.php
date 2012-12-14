<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends MX_Controller {

	function __construct()
	{
            parent::__construct();
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->library('recaptcha');
	    $this->load->library('form_validation');
	    $this->load->helper('form');
	    $this->lang->load('recaptcha');
            //$this->load->model('Comments_model');
		
	}
        
        public function displayme($module_id, $data = array(), $offset = 0) {
            //load module instance by id
            $module_instance = $this->Position_model->get_module_by_id($module_id);
            $module_params = unserialize($module_instance[0]->params);
            $data['menu_id'] = $data['menu_id'];
            //$data['item_id'] = $data[1];
            //$data['post'] = $data[2];
		
            if( isset($_POST) ){			
		$data['menu_id'] = $this->input->post('menu_id');
		//$data['item_id'] = $this->input->post('item_id');
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$comment = $this->input->post('comment');
		$response = $this->input->post('recaptcha_response_field');
		$challenge = $this->input->post('recaptcha_challenge_field');
		$data['cap'] = $this->recaptcha->check_answer($this->input->ip_address(),$challenge,$response);
		$ip_address = $this->session->userdata('ip_address');
		//var_dump($data['cap']);
		$data['recaptcha'] = $this->recaptcha->get_html();
		
		$this->form_validation->set_message('required', 'Ovo polje je obavezno.');
		$this->form_validation->set_message('valid_email', 'Email mora biti validan');
		$this->form_validation->set_rules('name', 'Ime', 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean');
		$this->form_validation->set_rules('comment', 'comment', 'required|max_length[600]|xss_clean');
		$this->form_validation->set_rules('recaptcha_response_field', '', 'required');
		
		if($this->form_validation->run()==FALSE || $data['cap']==FALSE){
                    $this->load->view('contact_view', $data);
		}else{
                    $this->load->library('email');
                    //email configuration
                    $config['protocol'] = 'mail';
                    $config['mailtype'] = 'html';
                    $this->email->initialize($config);
                    $this->email->from($email, $name);
                    $this->email->to( $module_params['recipient_email'] );
                    $this->email->bcc('mehicdado@gmail.com');
                    $this->email->subject( $module_params['subject'] );
                        
                    $this->email->message($comment);	
                    $this->email->send();
                    $this->load->view('success_view');
		}
			
            }else{
		    $data['recaptcha'] = $this->recaptcha->get_html();
                    $this->load->view('contact_view', $data);
            }
        }
}