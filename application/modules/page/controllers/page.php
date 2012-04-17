<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->model('menu/Menu_model');
		$this->load->model('templates/Templates_model');
		$this->load->model('articles/Articles_model');
		$this->load->model('stories/Stories_model');
		$this->load->model('games/Games_model');
		$this->load->model('images/Images_model');
		$this->load->model('users/Users_model');
		$this->load->model('comments/Comments_model');
		$this->load->model('categories/Categories_model');
	}
	
	/**
	 * 
	 * Function display single article page
	 * @param int $from_menu_id
	 * @param int $entrie_type_name
	 * @param int $id
	 */
    /*function index($from_menu_id, $entry_type_name, $id = 0){
    	//senad getting post date if anything is posted to this menu/page/item or what eva
		//var_dump($_POST);
		if(count($_POST) > 0){
			$data['post'] = $_POST;
		}else{
			$data['post'] = false;	
		}
		
		$entry_type = $this->Articles_model->get_entry_type_by_name($entry_type_name);
		$entry = $this->Articles_model->get_entry_by_type($id, $entry_type[0]->id);
		//$entry_type = $this->Articles_model->getTableByEntryType($entry->entry_type_id);
		//var_dump();
		$item = $this->Articles_model->getEntryType($entry[0]->type_id, $entry_type[0]->table_name);
		print_r("<pre>");
		var_dump($item);
		print_r("</pre>");
		exit;
		//$id is extually type_id, story id or game id
		//entry_type_id = 1 for story and 2 for game
		if($entry_type[0]->id == 1){
			//var_dump($entry_type[0]->id);
			$story = $this->Stories_model->get_story_by_id($id);
			//get category for story
			$entry_id = $this->Stories_model->get_entry_id($id);
			$category_id = $this->Stories_model->get_entry_category_id($entry_id);
			$category = $this->Categories_model->get_category_by_id($category_id);
			$data['category_name'] = $category[0]->name;
			//print_r($category[0]->name);
			//get category for story end
			$story_author = $this->Users_model->get_user_by_id($story[0]->admin_user_id);
			//var_dump($story);
			$data['item_id'] = $story[0]->id;
			$data['item_title'] = $story[0]->title;
			$data['item_headline'] = $story[0]->headline;
			$data['item_lead'] = $story[0]->lead;
			$data['item_body'] = $story[0]->body;
			$data['item_creation_date'] = $story[0]->creation_date;
			$data['item_modified_date'] = $story[0]->modified_date;
			$data['item_author_name'] = $story_author[0]->username;
			//print_r($story);
			
			$cat_ids = $this->Comments_model->getEntryCategoryId($data['item_id']);
			$cat_comment_status = $this->Comments_model->checkStatusForCat($cat_ids);
			
			//var_dump($cat_comment_status);
			$entry_comment_status = $this->Comments_model->checkStatusForEntry($data['item_id']);
			$data['cat_comment_status'] = $cat_comment_status;
			$data['entry_comment_status'] = $entry_comment_status;
			//use default template for the story entry type
			$template_file_name = "story_default_view";
		}else{
			$template_file_name = "game_default_view";
		}
		$data['from_menu_id'] = $from_menu_id;
		//get story image
    	$images = $this->Images_model->get_images_by_entry_id($entry[0]->id);
    	//var_dump($images);
		if(count($images) > 0){
			$j = 0;
	        foreach($images as $image){
	        	$poster_photos[$j] =  $this->Images_model->get_image($image->image_id);
	        	if(isset($poster_photos[$j][0])){
	        		if($poster_photos[$j][0]->dimension_id == 1){
	        		
	        			$data['thumb_image_id'] = $poster_photos[$j][0]->id;
	        			$data['thumb_image_path'] = str_replace("../", "", $poster_photos[$j][0]->path);
	        		}
	        	}
	        	$j++;
	        }
		}
		
		//var_dump($thumb_image_path);
		//TODO: Create logic for loading real template
		//Template is set on menu level, we need to check for $from_menu_id menu and if it is not set
		//we need the parent one which has set layout for single entry page
		//$data['menu'] = $menu;
		//$template = $this->Templates_model->get_template_by_id($menu[0]->template_id);
		//$template_file_name_array = explode(".", $template[0]->file_name);	
		//$template_file_name = $template_file_name_array[0];
		
		$this->load->view($template_file_name, $data);
	}
	*/
	
	public function story($from_menu_id, $id = 0){
		$data['from_menu_id'] = $from_menu_id;
		//for stories entry type is 1
		$data['entry'] = $this->Articles_model->get_entry_by_type($id, 1);
		if($data['entry']){
			$data['story'] = $this->Stories_model->get_story_by_id($data['entry'][0]->type_id);
			$data['item_id'] = $data['entry'][0]->id;
			//senad: getting post date if anything is posted to this menu/page/item or what eva
			if(count($_POST) > 0){
				$data['post'] = $_POST;
			}else{
				$data['post'] = false;	
			}
			
			//get story image
	    		$images = $this->Images_model->get_images_by_entry_id($data['entry'][0]->id);
	    		//var_dump($images);
			if(count($images) > 0){
				$j = 0;
				foreach($images as $image){
					$poster_photos[$j] =  $this->Images_model->get_image($image->image_id);
					if(isset($poster_photos[$j][0])){
						if($poster_photos[$j][0]->dimension_id == 1){
						
							$data['thumb_image_id'] = $poster_photos[$j][0]->id;
							$data['thumb_image_path'] = str_replace("../", "", $poster_photos[$j][0]->path);
						}
					}
					$j++;
				}
			}
			//senad: getting the flag "comments" in entries and categories 
			//to see wheter to show comments or not both on entrie and category lever
			$cat_ids = $this->Comments_model->getEntryCategoryId($data['item_id']);
			$cat_comment_status = $this->Comments_model->checkStatusForCat($cat_ids);
			$entry_comment_status = $this->Comments_model->checkStatusForEntry($data['item_id']);
			$data['cat_comment_status'] = $cat_comment_status;
			$data['entry_comment_status'] = $entry_comment_status;
			
			//end of image initialization
			//get author
			$story_author = $this->Users_model->get_user_by_id($data['entry'][0]->admin_user_id);
			$data['author'] = $story_author[0]->username;
			$template_file_name = "story_default_view";
			$this->load->view($template_file_name, $data);
		}else{
			show_404('page');
		}
	}
	
	public function game($from_menu_id, $id = 0){
		$data['from_menu_id'] = $from_menu_id;
		//for stories entry type is 1
		$data['entry'] = $this->Articles_model->get_entry_by_type($id, 1);
		if($data['entry']){
			//print_r("Entry:");
			//print_r("<pre>");
			//print_r($data['entry']);
			//print_r("</pre>");
			$data['game'] = $this->Games_model->getGameByID($data['entry'][0]->type_id);
			print_r("Game:");
			print_r("<pre>");
			print_r($data['game']);
			print_r("</pre>");
			//exit;
			
		}else{
			show_404('page');
		}
	}
	
}
/* End of file page.php */
/* Location: ./application/modules/page/controllers/page.php */
