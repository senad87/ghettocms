<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Single_story extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model('articles/Articles_model');
		$this->load->model('users/Users_model');
		$this->load->model('categories/Categories_model');
		$this->load->model('images/Images_model');
		$this->load->model('stories/Stories_model');
	}
	
	function displayme($module_id, $data=array()){
		
		$module_instance = $this->Position_model->get_module_by_id($module_id);
		//load module params and insert them into array
		$params_data_array = explode(";;",$module_instance[0]->params);
		$module_params = array();
		foreach ($params_data_array as $params_data){
			$param_data = explode(":=", $params_data);
			$module_params[$param_data[0]] = $param_data[1];
		}
		
		$story = $this->Stories_model->get_story_by_id($module_params['story_id']);
		//TODO: get entry_id by story id
		$entry = $this->Articles_model->get_entry_by_type($story[0]->id, 1);
		
		//TODO: get image, author name, categories names
		$images = $this->Images_model->get_images_by_entry_id($entry[0]->id);
		if(count($images) > 0){
			$j = 0;
	        foreach($images as $image){
	        	$poster_photos[$j] =  $this->Images_model->get_image($image->image_id);
	        	if(isset($poster_photos[$j][0])){
	        		if($poster_photos[$j][0]->dimension_id == $module_params['photo_size']){
	        		
	        			$thumb_image_id = $poster_photos[$j][0]->id;
	        			$thumb_image_path = str_replace("../", "", $poster_photos[$j][0]->path);
	        		}
	        	}
	        	$j++;
	        }
		}
		
		include $this->load->_ci_model_paths[0].'views/single_story_view.php';
		
	}
	
}