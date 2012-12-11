<?php

class Image extends CI_Controller {

	function __construct(){

		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->helper('login_helper.php');
		$this->lang->load('messages', 'english');
		$this->load->library('form_validation');
		$this->load->model('Admin_user_model');
		$this->load->model('image_model');
	}
	
	function index(){
		//shows images list
	}
	
	//public function image_list(){}
	
	public function add(){
	
		$this->load->view("header_view.php");
		$this->load->view('add_images_view');
		$this->load->view('footer_view');
			
	}
	
	public function edit(){}
	
	public function upload(){
	
		
		$uploaddir = 'upload_temp/';
		//$len = strlen($_FILES['uploadfile']['name']) - 1;
		//$childdir = $uploaddir.substr($_FILES['uploadfile']['name'],0, -$len); //takes first letter from string
		//if(@opendir($childdir) == false){
			//mkdir($childdir);
		//}
		
		$file = $uploaddir ."/". basename($_FILES['uploadfile']['name']);
		if(!file_exists($file)){ 
			if(move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)){ 
			  	echo "success"; 
			}else{
			 	echo "error";
			}
		}else{
			echo "file_exists";
		
		}
	}
	
	public function submit_uploads(){
	
	}
	
	//loads java script at the bottom of the page 
	public function script() {
		$data['id'] = $this->input->post('id');
		$data['image'] = $this->input->post('image');
		$this->load->view('script_view', $data);
	
	}
	
	public function delete(){
	
		$data['id'] = $this->input->post('id');
		$data['image'] = $this->input->post('image');
		unlink("upload_temp/".$data['image']);
	}
	
}
/* End of file image.php */
/* Location: ./system/application/controllers/image.php */
