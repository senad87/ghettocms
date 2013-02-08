<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stories extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper(array('url'));
		$this->load->model('menu/Menu_model');
		$this->load->model('templates/Templates_model');
		$this->load->model('articles/Articles_model');
		$this->load->model('Stories_model');
		$this->load->model('games/Games_model');
		$this->load->model('images/Images_model');
		$this->load->model('users/Users_model');
		$this->load->model('comments/Comments_model');
		$this->load->model('categories/Categories_model');
	}
	
	/**
	 * 
	 * Function display single story page
	 * @param int $from_menu_id
	 * @param int $id
	 */
    function index($from_menu_id, $id=0){
    	$data['from_menu_id'] = $from_menu_id;
		//for stories entry type is 1
		$data['entry'] = $this->Articles_model->get_entry_by_type($id, 1);
		if($data['entry']){
			$data['story'] = $this->Stories_model->get_story_by_id($data['entry'][0]->type_id);
			$data['item_id'] = $data['entry'][0]->id;
			//senad: getting post data if anything is posted to this menu/page/item or what eva
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
			//end of image initialization
			//senad: getting the flag "comments" in entries and categories 
			//to see wheter to show comments or not both on entrie and category level
			$cat_ids = $this->Comments_model->getEntryCategoryId($data['item_id']);
			$cat_comment_status = $this->Comments_model->checkStatusForCat($cat_ids);
			$entry_comment_status = $this->Comments_model->checkStatusForEntry($data['item_id']);
			$data['cat_comment_status'] = $cat_comment_status;
			$data['entry_comment_status'] = $entry_comment_status;
		    if($cat_comment_status && $entry_comment_status){
				$data['num_comments'] = $this->Comments_model->countEntryComments($data['entry'][0]->id);
			}else{
				$data['num_comments'] = FALSE;
			}
			
			$data['category'] = $this->Categories_model->getCategoryByID($data['entry'][0]->category_id);
			//related menu by category
			$data['menu_name'] = $this->Menu_model->getNameByID($data['category']->menu_id);
			//end of image initialization
			//get author
			$story_author = $this->Users_model->get_user_by_id($data['entry'][0]->admin_user_id);
			$data['author'] = $story_author->username;
			$template_file_name = "story_default_view";
			$this->load->view($template_file_name, $data);
		}else{
			show_404('page');
		}
	}
}
/* End of file stories.php */
/* Location: ./application/modules/stories/controllers/stories.php */
