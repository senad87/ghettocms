<?php

class Game extends MX_Controller {

    private $language_id = 1;
    
    function __construct(){

        parent::__construct();
        $this->load->helper(array('form', 'url', 'date', 'category', 'date'));
        $this->load->helper('login_helper.php');
        $this->lang->load('messages', 'english');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->model('Game_model');
        $this->load->model('topic/Topic_model');
        $this->load->model('Image_model');
        $this->load->model('tag/Tag_model');
        $this->load->model('Entry_model');
        $this->load->model('Entry_state_model');
        $this->load->model('Admin_user_model');
        $this->load->model('category/Category_model');
        $this->load->helper('categories_list_helper.php');
        $this->language_id = $this->session->userdata('language_id');
        check_login();
    
    }

    
	public function index($order="id-desc", $offset=0){

		$data['offset'] = $offset;
		$order_array = explode('-', $order);
		$data['orderColumn'] = $order_array[0];
		$data['order'] = $order_array[1];
		
		//get all published and unpublished entries of the game type
		$total_rows = $this->Entry_model->countByType(2, $this->language_id);
		$per_page = "20";
		/*** load pagination ***/
		$this->pagination->load_pagination("game/index/".$order, 4, $total_rows, $per_page);
		/*** end of pagination ***/

		$entries = $this->Entry_model->getUndeleted(2, $per_page, $offset, $this->language_id, 1);
		$data['entries'] = $this->createList($entries);
		
		/*** load date for filters***/
		//load root categories
		$data['root_categories']=$this->Category_model->get_category_kids(0);
		//load admin users list
		$data['authors']=$this->Admin_user_model->get_all_users();
		//load story states
		$data['states']=$this->Entry_state_model->get_story_states();
		/*** end of loading data for filters ***/
		
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
	* Function display form for adding new Game article
	*
	*/
	public function createNew(){
		//load category tree
		$root_categories = $this->Category_model->get_category_kids(0);
		$data['root_categories'] = $root_categories;
		
		$image_dimension = $this->Image_model->get_dimensions();		
		$data['largest_image'] = $image_dimension[0];
		
		$system_topics = $this->Topic_model->get_system(2, $this->language_id);
		//var_dump($system_topics);
		//print_r($system_topics."<br />");
		
		if(count($system_topics) > 0){
			foreach($system_topics as $system_topic){
			    $topic = $this->Topic_model->get_topic_by_id($system_topic->topic_id);
			    //var_dump($topic);
			    //get tags by topic id
			    $tags[$system_topic->topic_id] = $this->Tag_model->get_active_tags_by_topic_id($system_topic->topic_id);
			    $topics[] = $topic[0];
			}
			$data['topics'] = $topics;
			$data['tags'] = $tags;	
		}
		
		//var_dump($topics);
		//$data['all_topics'] = $this->Topic_model->get_all_active();
		$data['linked_topics'] = $this->Topic_model->get_linked_topic(2);
		//var_dump($data['linked_topics']);
		$this->load->view('header_view');
		$this->load->view('new_view', $data);
	}
    
	/**
	* Function take POST data end insert new game to database
	*
	*/
	public function createNew_post(){
		//var_dump($_POST);
		$i = 0;
		$j = 0;
		foreach($_POST as $key => $value){
		  	$category_array = explode("_", $key);
			if($category_array[0] == "tag"){
				$tags_id[$j] = $value;
				$j++;
			}
		}
			  
		$title = $this->input->post('title');
		$lead = $this->input->post('lead');
		$release_date = $this->input->post('release_date');
		//change date format to ISO 8601 yy-mm-dd
		$release_date = human_to_mysql($release_date, "/");
		$body = $this->input->post('editor1');
		$category_id = $this->input->post('category_id');
		//add form validation
		$language_id = $this->language_id;
		$admin_user_id = $this->session->userdata('id');
		
		$entry_id = $this->Game_model->insert($title, $lead, $release_date, $body, $admin_user_id, $tags_id, $category_id, $language_id);
		
		/*** file uplaod cofniguration ***/
		//TODO: Check this part, move this configuration becouse it is same for all entry types
		$uplaod_folder = '../images/';
		$current_date_string = md5(date("Y-m-d"));
		$images_dir = $uplaod_folder."".$current_date_string."/";
		if (!file_exists($images_dir))
				mkdir($images_dir);

		$config['upload_path'] = $images_dir;
		$config['allowed_types'] = 'jpg|jpeg|';
		$config['max_size']	= '1000';
		$config['overwrite']	= FALSE;
		$this->load->library('upload', $config);
		//$this->upload->initialize($config);
		/*** end of file upload configuration ***/
		
		$module = $this->load->module("image");
		if($this->upload->do_upload('image_file')){
			$isUploaded = $module->insert_image($this->upload->data(), $entry_id, $images_dir);
		}else{
			$this->upload->display_errors();
			exit;
		}
		//check if entry created successfully and if it is ok insert title as tag in linked topic
		if ($this->input->post('linked_topic_id') > 0){
			$this->Tag_model->insert($title, intval($this->input->post('linked_topic_id')),  $this->language_id);
		}
		//TODO: Insert system tags and topics
		//TODO: Display diffrent message if game added or not
		$this->messages->add('Game successfully created', 'success');
	        redirect('/game');
	}
	
    
	//TODO: fix release date format add helper to change formats from one
	public function edit($entry_id, $message_id = 0){

		$entry = $this->Entry_model->getEntryByID($entry_id);
		$data['entry'] = $entry;
		$data['game'] = $this->Game_model->getGameByID($entry->type_id);
		$data['entry_id'] = $entry->type_id;
		$game_tags = $this->Tag_model->get_active_tags_by_entry_id($entry_id);
		foreach ($game_tags as $game_tag){
			$set_tag = $this->Tag_model->get_tag_by_id($game_tag->tag_id);
			$set_tags[$set_tag[0]->topic_id] = $set_tag[0]->id;
		}
		
		$data['set_tags'] = $set_tags;
		//get category of the entry
		$data['set_category'] = $entry->category_id;
		$data['root_categories']=$this->Category_model->get_category_kids(0, $this->language_id);
		//load image
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
	        
		//load system topics
		$system_topics = $this->Topic_model->get_system(2, $this->language_id);
		$topics = array();
		$tags = array();
		//var_dump($system_topics);
		foreach($system_topics as $system_topic){
			$topic = $this->Topic_model->get_topic_by_id($system_topic->topic_id);
			//get tags by topic id
			$tags[$system_topic->topic_id] = $this->Tag_model->get_active_tags_by_topic_id($system_topic->topic_id);
			$topics[] = $topic[0];
		}
		
		$data['topics'] = $topics;
		$data['tags'] = $tags;
		$gata['game_tags'] = $game_tags;
		$this->load->view('header_view');
		$this->load->view('edit_view', $data);
	}
    
	//TODO: game basic data does not work, add tags update
	public function edit_post(){
		//add form validation
		$i = 0;
		$j = 0;
		$category_id = array();
		foreach($_POST as $key => $value){
			$category_array = explode("_", $key);
			if($category_array[0] == "tag"){
				$tags_id[$j] = $value;
			    $j++;
			}
		}

		$id = $this->input->post('id');
		$entry_id = $this->input->post('entry_id');
		$title = $this->input->post('title');
		$lead = $this->input->post('lead');
		$category_id = $this->input->post('category_id');
		$release_date = $this->input->post('release_date');
		//change date format to ISO 8601 yy-mm-dd
		$release_date = human_to_mysql($release_date, "/");
		
		$body = $this->input->post('editor1');
                $image_id = $this->input->post('image_id');
		$admin_user_id = $this->session->userdata('id');
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
				$module = $this->load->module("image");
				$isUpdated = $module->update_image($this->upload->data(), $entry_id, $images_dir);
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
			
			/*** tag update ***/
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
			/*** end of tags update ***/
		}
		
		$this->Entry_model->update($entry_id, $title, $category_id);
		$this->Game_model->update($id, $lead, $body, $release_date);
		
		$this->messages->add('Game successfully edited', 'success');
		redirect('/game');
	}
    
	/**
	* 
	* Display games from the trash, deleted games in table
	* @param int $offset
	*/
	public function trash($order="id-desc", $offset=0){
		
		$data['offset'] = $offset;
		$order_array = explode('-', $order);
		$data['orderColumn'] = $order_array[0];
		$data['order'] = $order_array[1];
		
		//TODO: Get deleted entries
		$total_rows = $this->Entry_model->countDeleted(2, $this->language_id);
		$per_page = "20";
		/*** load pagination ***/
		$this->pagination->load_pagination("game/trash/".$order, 4, $total_rows, $per_page);
		/*** end of pagination ***/
		
		$entries = $this->Entry_model->getDeleted(2, $per_page, $offset,  $this->language_id, 1);
		
		$data['entries'] = addCategoryName($entries);
		$data['pagination'] = $this->pagination->create_links();
		
		$this->load->view('header_view');
		$this->load->view('list_deleted_view', $data);
	}

	/**
	* delete
	*
	* Function set status of selected games to deleted(status id = 1)
	*
	*/
	public function delete(){

		$ids = $this->input->post('ids');
	    	$ids = explode(",", $ids);
	    	$count = count($ids);
		foreach ($ids as $id){
			$this->Entry_model->update_entry_state($id, 1);
		}
		$this->messages->add($count.' Game(s) successfully deleted', 'success');
	}
	
	/**
	 * publish
	 *
	 * Function update status of selected games to published(status id = 3)
	 */
	public function publish(){
		$ids = $this->input->post('ids');
	    $ids = explode(",", $ids);
	    $count = count($ids);
		foreach ($ids as $id){
			$this->Entry_model->update_entry_state($id, 3);
		}
		$this->messages->add($count.' Game(s) successfully published', 'success');
	}
	
	/**
	 * unpublish
	 *
	 * Function update status of selected games to unpublished(status id = 2)
	 */
	public function unpublish(){
		$ids = $this->input->post('ids');
        $ids = explode(",", $ids);
        $count = count($ids);
		foreach ($ids as $id){
			$this->Entry_model->update_entry_state($id, 2);
		}
		$this->messages->add($count.' Game(s) successfully unpublished', 'success');
	}
	
	/**
	 * restore
	 * 
	 * Set status to unpublish if category of the games is not deleted
	 */
	public function restore(){
		//TODO: Add check of game category
		$ids = $this->input->post('ids');
        	$ids = explode(",", $ids);
        	//var_dump($ids);
        	$count = count($ids);
		foreach ($ids as $id){
			$this->Entry_model->update_entry_state($id, 2);
		}
		$this->messages->add($count.' Game(s) successfully restored', 'success');
	}
    
	public function games_list($games_array_of_objects){
		$games_row = array();
		$i = 0;
		foreach ($games_array_of_objects as $game){

			$entry = $this->Entry_model->get_entry_by_type($game->id, 2);
			$entry_id = $entry[0]->id;
			$categories = $this->Category_model->get_categories_by_entry_id($entry_id);
			$categories_names_string = "";
			foreach($categories as $category){
				$categories_names = $this->Category_model->get_category_by_id($category->category_id);
				if($categories_names_string == ""){
				$categories_names_string = $categories_names[0]->name;
				}else{
				$categories_names_string = $categories_names[0]->name.", ".$categories_names_string;
				}
			}

			$game_state = $this->Entry_state_model->get_entry_state_name_by_state_id($entry[0]->entry_state_id);
			$game_author = $this->Admin_user_model->get_user_by_id($game->admin_user_id);
			$games_row[$i] = array("id" => $game->id,
					"game_name" => $game->game_name,
					"categories_names" => $categories_names_string,
					"creation_date" => $game->creation_date,
					"modified_date" => $game->modified_date,
					"author_name" => $game_author[0]->username,
					"game_state" => $game_state[0]->state_name
			);
			$i++;
		}
		return $games_row;
	}
}
/* End of file game.php */
/* Location: ./system/application/controllers/game.php */
