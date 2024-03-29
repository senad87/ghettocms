<?php

class Story extends MX_Controller {

	private $language_id = 1;
	
	function __construct(){
		// Call the Model constructor
		parent::__construct();
		$this->load->helper(array('form', 'url', 'date'));
		$this->load->helper('categories_list_helper.php');
		$this->load->helper('category');
		$this->load->helper('login_helper.php');
		$this->load->library('pagination');
		$this->load->model('Story_model');
		$this->load->model('Entry_state_model');
		$this->load->model('Entry_model');
		$this->load->model('Admin_user_model');
		$this->load->model('category/Category_model');
		$this->load->model('comments/Comments_model');
		$this->load->model('topic/Topic_model');
		$this->load->model('tag/Tag_model');
		$this->load->model('Image_model');
		$this->lang->load('messages', 'english');
		$this->language_id = $this->session->userdata('language_id');
		check_login();
	}
	
	/**
	 * index
	 *
	 * Function display list of all stories with status Published or Unpublished
	 *
	 * @param int $message_id used to display message after Update or Insert story
	 * @param int $offset used for pagination
	 */
	public function index($order="id-desc", $offset=0){
	
		$data['offset'] = $offset;
		$order_array = explode('-', $order);
		$data['orderColumn'] = $order_array[0];
		$data['order'] = $order_array[1];
		
		//get all published and unpublished entries of the story type
		$total_rows = $this->Entry_model->countByType(1, $this->language_id);
		$per_page = "20";
		/*** load pagination ***/
		$this->pagination->load_pagination("story/index/".$order, 4, $total_rows, $per_page);
		/*** end of pagination ***/
		$entries = $this->Entry_model->getUndeleted(1, $per_page, $offset, $this->language_id, 1);
		
		//prepare array for table view
		$data['entries'] = $this->createList($entries);
		//print_r($data['entries']);
		
		/*** right columns data ***/
		/*** load data for filters***/
		//load root categories
		$data['root_categories']=$this->Category_model->get_category_kids(0, $this->language_id);
		//load admin users list
		$data['authors']=$this->Admin_user_model->get_all_users();
		//load story states
		$data['states']=$this->Entry_state_model->get_story_states();
		/*** end of loading data for filters ***/
		
		//get multiselect of all topics to mark system topics
		$data['topics'] = $this->Topic_model->get_all_active($this->language_id);
		$system_topics = $this->Topic_model->get_system(1, $this->language_id);
		
		$sys_topics_array = array();
		foreach($system_topics as $system_topic){
			$sys_topics_array[] = $system_topic->topic_id;
		}
		
		$data['sys_topics_array'] = $sys_topics_array;
		/*** end of topics initialization ***/
		$data['pagination'] = $this->pagination->create_links();
		
		$this->load->view('header_view');
		$this->load->view('list_view', $data);
	}
	
	/**
	 * Add strings (names, titles) insted of FK
	 * @param $items
	 * @return array $ $result_array
	 */
	private function createList($items){
		$result_array = array();
		foreach($items as $item){
			$item['category'] = $this->Category_model->getName($item['category_id']);
			$item['state'] = $this->Entry_state_model->getStateName($item['entry_state_id']);
			$result_array[] = $item; 
		}
		
		return $result_array;
	}
	
	
	
	/**
	 * trash
	 *
	 * Function display list of all sotires with status Deleted
	 */
	public function trash($order="id-desc", $offset=0){
	
		$data['offset'] = $offset;
		$order_array = explode('-', $order);
		$data['orderColumn'] = $order_array[0];
		$data['order'] = $order_array[1];
		
		//TODO: Get deleted entries
		$total_rows = $this->Entry_model->countDeleted(1, $this->language_id);
		$per_page = "20";
		/*** load pagination ***/
		$this->pagination->load_pagination("story/trash/".$order, 4, $total_rows, $per_page);
		/*** end of pagination ***/
		
		$entries = $this->Entry_model->getDeleted(1, $per_page, $offset,  $this->language_id, 1);
		
		$data['entries'] = addCategoryName($entries);
		$data['pagination'] = $this->pagination->create_links();
		//print_r($this->session->userdata);
		$this->load->view('header_view');
		$this->load->view('list_deleted_view', $data);
	
	}
	
	/**
	 * new_story
	 *
	 * Function display form for adding new story
	 *
	 */
	public function createNew(){

		$root_categories = $this->Category_model->get_category_kids(0, $this->language_id);
		$data['root_categories'] = $root_categories;
		$image_dimension = $this->Image_model->get_dimensions();		
		$data['largest_image'] = $image_dimension[0];
		$current_date = date("Y-m-d");
		/*** topics initialization ***/
		$system_topics = $this->Topic_model->get_system(1, $this->language_id);
        	if(count($system_topics) > 0){
			foreach($system_topics as $system_topic){
				$topic = $this->Topic_model->get_topic_by_id($system_topic->topic_id);
				//get tags by topic id
				$tags[$system_topic->topic_id] = $this->Tag_model->get_active_tags_by_topic_id($system_topic->topic_id);
				$topics[] = $topic[0];
			}
			//$data['all_topics'] = $this->Topic_model->get_all_active();
			$data['linked_topics'] = $this->Topic_model->get_linked_topic(1, $this->language_id);
			$data['topics'] = $topics;
			$data['tags'] = $tags;
			/*** end of topic initialization ***/
        	}
		$this->load->view("header_view");
		$this->load->view('new_view', $data);
		
	}
	
	/**
	 * add_new
	 *
	 * Function get data from POST and insert new story into database
	 *
	 */
	public function createNew_post(){
	
	        $j = 0;
	        $tags_id = array();
	        foreach($_POST as $key => $value){
		       if(isset($category_array)){
			       if($category_array[0] == "tag"){
			    	$tags_id[$j] = $value;
				    $j++;
			    	}
		    	}
	        }
	       
	        $category_id =  $this->input->post('category_id');
	        $headline =  $this->input->post('headline');
	        $title = $this->input->post('title');
	        $lead = $this->input->post('lead');
	        $creation_date = $this->input->post('creation_date');
	        
	        $creation_date_array = explode("/", $creation_date);
	        $creation_date = $creation_date_array[2]."-".$creation_date_array[0]."-".$creation_date_array[1]." ".date("G:i:s");
	        
	        $body = $this->input->post('editor1');
	        
	        //$language_id = 1;
		$admin_user_id = $this->session->userdata('id');
		$entry_id = $this->Story_model->insert($headline, $title, $lead, $body, $category_id, $tags_id, $this->language_id, $creation_date, $admin_user_id);
		
		/*$this->load->library('upload');
		$module = $this->load->module("image");
		$isUploaded = $module->insert_image($this->upload->do_upload('image_file'), $entry_id);
		*/
		//var_dump($isUploaded);
		//exit;   
	        /*** file uplaod cofniguration ***/
		$uplaod_folder = '../images/';
		$current_date_string = md5(date("Y-m-d"));
		$images_dir = $uplaod_folder."".$current_date_string."/";
		if (!file_exists($images_dir))
            		mkdir($images_dir);
            	//chmod($images_dir, 0777);
            
	        $config['upload_path'] = $images_dir;
		$config['allowed_types'] = 'jpg|jpeg|';
		$config['max_size']	= '1000';
		$config['overwrite']	= FALSE;
		$this->load->library('upload', $config);
		/*** end of file upload configuration ***/
	        
		if ($this->upload->do_upload('image_file')){
			$data = array('upload_data' => $this->upload->data());
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
		}
		
		/*** insert tags ***/
		if ($entry_id > 0){
			$message_id = 1;
		        if ($this->input->post('title_topic') > 0){
			       	$this->Tag_model->insert($title, intval($this->input->post('title_topic')));
		        }
	        }else{
		       $message_id = 2;
	        }
	        $this->messages->add('Story successfully created', 'success');
	        redirect('/story');	
	}
	
	/**
	 * edit
	 *
	 * Function display form for story edit
	 *
	 */
	public function edit($entry_id, $message_id = 0){

	        $entry = $this->Entry_model->getEntryByID($entry_id);
	        $data['entry'] = $entry;
	        $story = $this->Story_model->get_story_by_id($entry->type_id);
	 
	        $images = $this->Image_model->get_images_by_entry_id($entry_id);
	        $i = 0;
	        foreach($images as $image){
	        	$poster_photos[$i] =  $this->Image_model->get_image($image->image_id);
	        	
	        	if(isset($poster_photos[$i][0])){
	        		if($poster_photos[$i][0]->poster_photo == 1 && $poster_photos[$i][0]->dimension_id == 2){
	        		
	        			$thumb_image = $poster_photos[$i];
	        		}
	        	}
	        	$i++;
	        }
	        
	        //TODO:check url for image display
	        if(isset($thumb_image)){
	        	$data['thumb_image'] = $thumb_image;
	        }
	        
	        
	    	$data['entry_id'] = $entry_id;
	    	$data['set_category'] = $entry->category_id;
	        $data['root_categories']=$this->Category_model->get_category_kids(0, $this->language_id);
	        
	        /*** initialize tags for story ***/
	        $story_tags = $this->Tag_model->get_active_tags_by_entry_id($entry_id);
	        $set_tags = array();
	        if(count($story_tags) > 0){
		        foreach ($story_tags as $story_tag){
			    		$set_tag = $this->Tag_model->get_tag_by_id($story_tag->tag_id);
			    		$set_tags[$set_tag[0]->topic_id] = $set_tag[0]->id;
				}
	        	$data['set_tags'] = $set_tags;
	        }
	        
	        /*** end of tags initialization ***/
	        
	        /*** load system topics ***/
		$system_topics = $this->Topic_model->get_system(1, $this->language_id);
	        $topics = array();
	        $tags = array();
		
	        foreach($system_topics as $system_topic){
	            $topic = $this->Topic_model->get_topic_by_id($system_topic->topic_id);
	            //get tags by topic id
	            $tags[$system_topic->topic_id] = $this->Tag_model->get_active_tags_by_topic_id($system_topic->topic_id);
	            $topics[] = $topic[0];
	        }
	        $data['topics'] = $topics;
	        $data['tags'] = $tags;
	        $gata['story_tags'] = $story_tags;
	        /*** end of system tags loading ***/
		//display message with error if image is missing or upload is faild
	        if($message_id == 4){
	        	$data['message'] = $this->lang->line('message_story_updated_faild');
	        }else{
	        	$data['message'] = "";
	        }
	        $data['story'] = $story[0];
	        //get date from mysql datetime
	        $modified_date = explode(" ", $entry->modified_date);
	        $modified_date = mysql_to_human($modified_date[0]);
	        $data['modified_date'] = $modified_date;
	        
	        $this->load->view("header_view");
	        $this->load->view('edit_view', $data);  
	
	}
	
	/**
	 * edit_post
	 *
	 * Function get POST data and update story data
	 *
	 */
	 //TODO: This is next thing to be done, fix this
	public function edit_post(){

		//TODO: Check this part, only tags need to be separated from POST array
		$i = 0;
		$j = 0;
		$category_id = array();
		$tags_id = array();
		foreach($_POST as $key => $value){
			$category_array = explode("_", $key);
			if($category_array[0] == "tag"){
			    	$tags_id[$j] = $value;
				    $j++;
			    }
		}
		$id = $this->input->post('story_id');
		$headline = $this->input->post('headline');
		$title = $this->input->post('title');
		$entry_id = $this->input->post('entry_id');
		$lead = $this->input->post('lead');
		$category_id = $this->input->post('category_id');
		$body = $this->input->post('editor1');
		$creation_date = $this->input->post('creation_date');
		
		$creation_date_array = explode("/", $creation_date);
	    	$creation_date = $creation_date_array[2]."-".$creation_date_array[0]."-".$creation_date_array[1]." ".date("G:i:s");
		
		$image_id = $this->input->post('image_id');
		$admin_user_id = $this->session->userdata('id');
		/*** update category ***/
        //TODO: Check this update, this can be removed now due to entry update in line 408
        $this->Entry_model->updateCategoryID($id, $category_id);
		/*** end of category update ***/
		/*** image update ***/
		if(!$image_id || $image_id < 1){
			/*** file uplaod cofniguration ***/
			$uplaod_folder = '../images/';
			$current_date_string = md5(date("Y-m-d"));
			$images_dir = $uplaod_folder."".$current_date_string."/";
				if (!file_exists($images_dir))
	    		mkdir($images_dir);
			    		
		        //chmod($images_dir, 0777);
			$config['upload_path'] = $images_dir;
			$config['allowed_types'] = 'jpg|jpeg|';
			$config['max_size']	= '1000';
			$config['overwrite']	= FALSE;
			$this->load->library('upload', $config);
			/*** end of file upload configuration ***/
			
			
			if ($this->upload->do_upload('image_file')){
				$data = array('upload_data' => $this->upload->data());
				$file_name = $data['upload_data']['file_name'];
				//$full_path = $data['upload_data']['full_path'];
				$file_path = $images_dir."".$data['upload_data']['file_name'];
				//$admin_user_id = $this->session->userdata('id');
				//disconnect entry from all images
				$this->Image_model->delete_connection($entry_id);
				//Insert new image
				$new_image_id = $this->Image_model->insert_new($file_name, $file_path);
				$this->Image_model->connect_with_entry($entry_id, $new_image_id);
				$dimensions = $this->Image_model->get_other_dimensions();
				foreach($dimensions as $dimension){
					$copy_name = $dimension->width."x".$dimension->height."_".$file_name;
					$copy_file_path = $images_dir."".$copy_name;
					$this->resize_poster_photo($file_path, $dimension->width, $dimension->height, $copy_name);
					$copy_image_id = $this->Image_model->insert_new($copy_name, $copy_file_path, $new_image_id, 1, $dimension->id);
			    		//connect entry with new copy
					$this->Image_model->connect_with_entry($entry_id, $copy_image_id);
				}    	
			}else{
				$this->Image_model->delete_connection($entry_id);
			}
		}
		
		if(count($tags_id) > 0){
			$existing_tags = $this->Tag_model->get_tags_by_entry_id($entry_id);
			
			$existing_tags_array = array();
				foreach($existing_tags as $existing_tag){
				$existing_tags_array[] = $existing_tag->tag_id;
			}
			
			/*** story tag update ***/
			//first disconect entry from all tags, update active to 0 in join_entries_tags
			$this->Tag_model->update_tags_state_by_entry_id($entry_id);
			//foreach set tag from edit form update active to 1
			foreach($tags_id as $tag){
				$this->Tag_model->update_join_state($entry_id, $tag, 1);
				//if tag is not in existing tags and is not empty or 0 insert new tag 
				if(!in_array($tag, $existing_tags_array) && $tag > 0 && $tag != ""){
					$this->Tag_model->insert_entry_tag($entry_id, $tag);
				}
			}
			/*** end of story tags update ***/
		}
		//TODO: Update entry data
		$this->Entry_model->update($entry_id, $title, $category_id);
		$this->Story_model->update_story_data($id, $headline, $lead, $body);
		$this->messages->add('Story successfully edited', 'success');
		redirect('/story');
	}
	
	/**
	 * delete
	 *
	 * Function set status of selected stories to deleted(status id = 1)
	 *
	 */
	public function delete(){

		$ids = $this->input->post('ids');
	    	$ids = explode(",", $ids);
	    	$count = count($ids);
		foreach ($ids as $id){
		//var_dump($id);
			$this->Entry_model->update_entry_state($id, 1);
		}
		$this->messages->add($count.' Story(s) successfully deleted', 'success');
		
	}
	
	/**
	 * publish
	 *
	 * Function update status of selected stories to published(status id = 3)
	 */
	public function publish(){
		$ids = $this->input->post('ids');
	    $ids = explode(",", $ids);
	    $count = count($ids);
		foreach ($ids as $id){
			$this->Entry_model->update_entry_state($id, 3);
		}
		$this->messages->add($count.' Stories successfully published', 'success');
	}
	
	/**
	 * unpublish
	 *
	 * Function update status of selected stories to unpublished(status id = 2)
	 */
	public function unpublish(){
		$ids = $this->input->post('ids');
        $ids = explode(",", $ids);
        $count = count($ids);
		foreach ($ids as $id){
			$this->Entry_model->update_entry_state($id, 2);
		}
		$this->messages->add($count.' Stories successfully unpublished', 'success');
	}
	
	/**
	 * restore
	 * 
	 * Set status to unpublish if category of the stories is not deleted
	 */
	public function restore(){
		//TODO: Add check of story category
		$ids = $this->input->post('ids');
        	$ids = explode(",", $ids);
        	//var_dump($ids);
        	$count = count($ids);
		foreach ($ids as $id){
			$this->Entry_model->update_entry_state($id, 2);
		}
		$this->messages->add($count.' Stories successfully restored', 'success');
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
/* End of file story.php */
/* Location: ./system/application/controllers/story.php */
