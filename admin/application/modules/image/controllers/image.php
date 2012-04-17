<?php

class Image extends MX_Controller {
    
	function __construct(){

	parent::__construct();
	$this->load->helper(array('form', 'url', 'date', 'category', 'date'));
	$this->load->helper('login_helper.php');
	$this->lang->load('messages', 'english');
	//$this->load->library('form_validation');
	//$this->load->library('pagination');
	//$this->load->model('Game_model');
	//$this->load->model('topic/Topic_model');
	$this->load->model('Image_model');
	//$this->load->model('Tag_model');
	$this->load->model('Entry_model');
	$this->load->model('Entry_state_model');
	$this->load->model('Admin_user_model');
	//$this->load->model('category/Category_model');
	//$this->load->helper('categories_list_helper.php');
	//$this->language_id = $this->session->userdata('language_id');
	check_login();

	}

	public function insert_image($upload_data, $entry_id, $images_dir){
		
		$data = array('upload_data' => $upload_data);
		//var_dump($data);
		$file_name = $data['upload_data']['file_name'];
		$file_path = $images_dir."".$data['upload_data']['file_name'];
			
		$image_id = $this->Image_model->insert_new($file_name, $file_path);
		$this->Image_model->connect_with_entry($entry_id, $image_id);
		$dimensions = $this->Image_model->get_other_dimensions();
		foreach($dimensions as $dimension){
			$copy_name = $dimension->width."x".$dimension->height."_".$file_name;
			$copy_file_path = $images_dir."".$copy_name;
			$this->resize_poster_photo($file_path, $dimension->width, $dimension->height, $copy_name);
			$copy_image_id = $this->Image_model->insert_new($copy_name, $copy_file_path, $image_id, 1, $dimension->id);
			$this->Image_model->connect_with_entry($entry_id, $copy_image_id);
		}
		//connect image with entrie
		return true;
	}
	
	public function update_image($upload_data, $entry_id, $images_dir){
		
		$data = array('upload_data' => $upload_data);
		$file_name = $data['upload_data']['file_name'];
		//$full_path = $data['upload_data']['full_path'];
		$file_path = $images_dir."".$data['upload_data']['file_name'];
		//$admin_user_id = $this->session->userdata('id');
		//disconnect entry from all images
		$this->Image_model->delete_connection($entry_id);
		
		//Insert new image
		$new_image_id = $this->Image_model->insert_new($file_name, $file_path);
		$this->Image_model->connect_with_entry($entry_id, $new_image_id);
		//create all dimensions
		$dimensions = $this->Image_model->get_other_dimensions();
		foreach($dimensions as $dimension){
			$copy_name = $dimension->width."x".$dimension->height."_".$file_name;
			$copy_file_path = $images_dir."".$copy_name;
			$this->resize_poster_photo($file_path, $dimension->width, $dimension->height, $copy_name);
			$copy_image_id = $this->Image_model->insert_new($copy_name, $copy_file_path, $new_image_id, 1, $dimension->id);
	    		//connect entry with new copy
			$this->Image_model->connect_with_entry($entry_id, $copy_image_id);
		}
		
	}
	   
	public function resize_poster_photo($source_image_path, $width, $height, $copy_name){
		
		$config['image_library'] = 'gd2';
		$config['source_image']	= $source_image_path;
		//$config['create_thumb'] = TRUE;
		//If only the new image name is specified it will be placed in the same folder as the original
		
		$config['new_image'] = $copy_name;
		$config['maintain_ratio'] = TRUE;
		$config['overwrite']	= FALSE;
		$config['width']	 = $width;
		$config['height']	= $height;
		
		
		$this->load->library('image_lib', $config);
		$this->image_lib->initialize($config); 
		$this->image_lib->resize();
		return true;
		
	}
}
