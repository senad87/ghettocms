<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comments extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('recaptcha');
	    $this->load->library('form_validation');
	    $this->load->helper('form');
	    $this->lang->load('recaptcha');
		$this->load->model('Comments_model');
		
	}
	
	function index($data=array()){
		
		$data['menu_id'] = $data[0];
		$data['item_id'] = $data[1];
		$data['post'] = $data[2];
		$data['comments'] = $this->Comments_model->getComments($data['item_id']);
		
		if($data['post']){			
			$data['menu_id'] = $this->input->post('menu_id');
			$data['item_id'] = $this->input->post('item_id');
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$comment = $this->input->post('comment');
			$response = $this->input->post('recaptcha_response_field');
			$challenge = $this->input->post('recaptcha_challenge_field');
			$data['cap'] = $this->recaptcha->check_answer($this->input->ip_address(),$challenge,$response);
			$ip_address = $this->session->userdata('ip_address');
			//var_dump($data['cap']);
			$data['recaptcha'] = $this->recaptcha->get_html();
			
			$this->form_validation->set_message('required', 'Ovo polje je obavezno');
			$this->form_validation->set_message('valid_email', 'Email mora biti ispravan');
			$this->form_validation->set_rules('name', 'Ime', 'required|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean');
			$this->form_validation->set_rules('comment', 'comment', 'required|max_length[600]|xss_clean');
			$this->form_validation->set_rules('recaptcha_response_field', '', 'required');
			
			//var_dump($data['cap']);
			if($this->form_validation->run()==FALSE || $data['cap']==FALSE){
				$this->load->view('comments_view', $data);
			}else{
				//$status = 2, insert comment as unpublished
				$this->Comments_model->insert($data['item_id'], $name, $email, $comment, $ip_address, $status = 2);
				$this->load->view('success_view', $data);
			}
			
		}else{
		    $data['recaptcha'] = $this->recaptcha->get_html();
			$this->load->view('comments_view', $data);
		}
		
	
	
	}
	
	/*function comment_post(){
	
	
		$this->load->library('recaptcha');
	    $this->load->library('form_validation');
	    $this->load->helper('form');
	    $this->lang->load('recaptcha');

		$data['menu_id'] = $this->input->post('menu_id');
		$data['item_id'] = $this->input->post('item_id');
		$data['recaptcha'] = $this->recaptcha->get_html();
		
		//print_r($data['recaptcha']);
		
		$this->form_validation->set_message('required', 'Ово поље је обавезно');
		$this->form_validation->set_message('valid_email', 'Email mora biti validan');
		$this->form_validation->set_rules('name', 'Ime', 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean');
		$this->form_validation->set_rules('comment', 'comment', 'required|max_length[600]|xss_clean');
		$this->form_validation->set_rules('recaptcha_response_field', 'required');
		
	
		if($this->form_validation->run()==FALSE){
			$this->load->view('commentsReload_view', $data);
		}else{
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$comment = $this->input->post('comment');

			$this->Comments_model->insert($data['item_id'], $name, $email, $comment);
		
			$this->load->view('success_view', $data);
		}
	
	}*/
		//var_dump($data);
		//load module instance by id
		/*$module_instance = $this->Position_model->get_module_by_id($module_id);
		//load module params
		$params_data_array = explode(";;",$module_instance[0]->params);
		$module_params = array();
		foreach ($params_data_array as $params_data){
			$param_data = explode(":=", $params_data);
			$module_params[$param_data[0]] = $param_data[1];
		}
		//get all entries from selected categories
		$entries = $this->Articles_model->get_entries_by_categories($module_params['categories']);
		//create comma separated string of entries id
		foreach ($entries as $entry){
			$entries_id_array[] = $entry->entry_id;
		}
		$entries_string = implode(",",$entries_id_array);
		//get published stories by entries
		$stories_entries = $this->Articles_model->get_published_type_by_entries(1, $entries_string, $module_params['number']);
		
		foreach($stories_entries as $story_entry){
			$stories_objects_array[] = $this->Stories_model->get_story_by_id($story_entry->type_id);	
		}
		$stories[]=array();
		$i=0;
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
		//var_dump($data['menu_id']);
		include $this->load->_ci_model_paths[0].'views/article_list_view.php';
	}	*/	
			
	
}

/* End of file articles.php */
/* Location: ./application/modules/articles/controllers/articles.php */
