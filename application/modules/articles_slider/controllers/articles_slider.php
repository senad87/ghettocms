<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articles_slider extends MX_Controller {

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
		//var_dump($data);
		//load module instance by id
		$module_instance = $this->Position_model->get_module_by_id($module_id);
		//load module params
		$params_data_array = explode(";;",$module_instance[0]->params);
		$module_params = array();
		foreach ($params_data_array as $params_data){
			$param_data = explode(":=", $params_data);
			/*if($param_data[0] == "categories"){
				$param_data[1] = explode(",",$param_data[1]);
				//$module_params[$param_data[0]] = $param_data[1];
			}*/
				$module_params[$param_data[0]] = $param_data[1];
		}
		//var_dump($module_params);
		//get all entries from selected categories
		$entries = $this->Articles_model->get_entries_by_categories($module_params['categories']);
		//var_dump($entries);
		//create comma separated string of entries id
		foreach ($entries as $entry){
			$entries_id_array[] = $entry->entry_id;
		}
		$entries_string = implode(",",$entries_id_array);
		//get published stories by entries
		$stories_entries = $this->Articles_model->get_published_type_by_entries(1, $entries_string, $module_params['number']);
		
		foreach($stories_entries as $story_entry){
			$stories_objects_array[] = $this->Stories_model->get_story_by_id($story_entry->type_id);
			//TODO: Category url, author name, and photo	
		}
		$stories[]=array();
		$i=0;
		//var_dump($stories_objects_array);
		foreach($stories_objects_array as $story){
			//TODO:fix this, we already have entry id for each story
			$entry = $this->Articles_model->get_entry_by_type($story[0]->id, 1);
			$entry_id = $entry[0]->id;
			$categories = $this->Categories_model->get_categories_by_entry_id($entry_id);
			$categories_names_string = "";
			foreach($categories as $category){
				$categories_names = $this->Categories_model->get_category_by_id($category->category_id);
				if($categories_names_string == ""){
					$categories_names_string = $categories_names[0]->name;
				}else{
				        $categories_names_string = $categories_names[0]->name.", ".$categories_names_string;
			        }
			}
			
			$thumb_image_id = array();
			$thumb_image_path = array();
			if($module_params['poster_photo'] == 1){
				$images = $this->Images_model->get_images_by_entry_id($entry_id);
				//var_dump($images);
				if(count($images) > 0){
					$j = 0;
			        foreach($images as $image){
			        	$poster_photos[$j] =  $this->Images_model->get_image($image->image_id);
			        	//var_dump($poster_photos[$i]);
			        	if(isset($poster_photos[$j][0])){
			        		if($poster_photos[$j][0]->poster_photo == 1 && $poster_photos[$j][0]->dimension_id == $module_params['photo_size']){
			        		
			        			$thumb_image_id = $poster_photos[$j][0]->id;
			        			$thumb_image_path = str_replace("../", "", $poster_photos[$j][0]->path);
			        		}
			        	}
			        	$j++;
			        }
				}
			}
			
			$story_author = $this->Users_model->get_user_by_id($story[0]->admin_user_id);
			if (count($categories) > 0){
				$stories_row[$i] = array("id" => $story[0]->id,
							"title" => $story[0]->title,
							"lead" => $story[0]->lead,
							"photo_id" => $thumb_image_id,
							"photo_path" => $thumb_image_path,
							"categories_names" => $categories_names_string,
							"creation_date" => $story[0]->creation_date,
							"modified_date" => $story[0]->modified_date,
							"author_name" => $story_author[0]->username,
							);
				$i++;
			}
		}
		//var_dump($stories_row);
		//var_dump($data['menu_id']);
		include $this->load->_ci_model_paths[0].'views/article_list_view.php';
	}


}