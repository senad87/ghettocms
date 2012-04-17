<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Stories extends REST_Controller {

	public function listByCategory_get(){
	
		if(!$this->get('id') || !$this->get('width') || !$this->get('height'))
		{
			$this->response(NULL, 400);
		}
	
		$this->load->model("Stories_model");
		$this->load->model("images/Images_model");
		//get stories from entry table
		$stories = $this->Stories_model->getEntriesByTypeAndCategory($this->get('id'), $type = 1);
		//TODO: Get image
		$stories_array = array();
		$base_url = base_url();
		foreach($stories as $story){
			$new_story = new stdClass();
			
			$new_story->id = $story->id;
			$new_story->title = $story->title;
			//Get story by ID from stories table with story additional data, lead, body etc.
			$story_obj = $this->Stories_model->get_story_by_id($story->type_id); 
			$new_story->lead = $story_obj[0]->lead;
			
			$images = $this->Images_model->get_images_by_entry_id($story->id);
			
			if(count($images) > 0){
				$j = 1;
				foreach($images as $image){
					$image_instance = $this->Images_model->get_image($image->image_id);
					$str = "../";
					$path = str_replace($str, base_url(), $image_instance[0]->path);
					$property_name = "image_".$j."";
					$new_story->$property_name = $path;
					$j++;
				}
			}
			
			$new_story->body = $story_obj[0]->body;
			//add object to array of objects
			$stories_array[] = $new_story;
		}
		
		//TODO: Get image by size
		if($stories_array)
		{
		    $this->response($stories_array, 200); // 200 being the HTTP response code
		}else{
		    $this->response(array('error' => 'Stories could not be found'), 404);
		}

	}
	
	private function resizeImage($source_path, $width, $height){
		
		//TODO: Continue to work here
		$config['image_library'] = 'gd2';
		$config['source_image']	= $source_path;
		//var_dump($source_path);
		$path_array = explode("/", $source_path);
		$new_file_path = "../".$path_array[1]."/".$width."x".$height."_".$path_array[3];
		print_r("File path for check".$new_file_path."\n");
		//var_dump(file_exists($new_file_path));
		if (!file_exists($new_file_path)) {
			$copy_name = $width."x".$height."_".$path_array[3];
			//$config['create_thumb'] = TRUE;
			//If only the new image name is specified it will be placed in the same folder as the original
			//TODO:Check does image with given size exists
			print_r("copy name:".$copy_name);
			$config['new_image'] = $copy_name;
			$config['maintain_ratio'] = TRUE;
			$config['overwrite']	= FALSE;
			$config['width']	 = $width;
			$config['height']	= $height;
			$this->load->library('image_lib', $config);
			$this->image_lib->initialize($config); 
		if ( ! $this->image_lib->resize())
		{
    		echo $this->image_lib->display_errors();
		}
		print_r("\n");
		}
		//$thumb_image_path = str_replace("../", "", $poster_photos[$j][0]->path);
		$new_file_path = base_url().$path_array[1]."/".$width."x".$height."_".$path_array[3];
		//print_r("New file path:".$new_file_path."\n");
		return $new_file_path;
	}
}
