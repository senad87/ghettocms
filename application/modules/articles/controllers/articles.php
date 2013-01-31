<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articles extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model('Articles_model');
		$this->load->model('users/Users_model');
		$this->load->model('categories/Categories_model');
		$this->load->model('images/Images_model');
		$this->load->model('stories/Stories_model');
		$this->load->model('position/Position_model');
		$this->load->model('tags/Tag_model');
		$this->load->model('tags/Topic_model');
		$this->load->model('menu/Menu_model');
		//$this->load->library('pagination');
		$this->load->library('Jquery_pagination');
	}
	
	public function displayme($module_id, $data = array(), $offset = 0) {

        //TODO: This is big hack fix ASAP
        $data_menu_id = $data;
        if (!is_array($data)) {
            $data = array();
            $data['menu_id'] = $data_menu_id;
        }
        //load module instance by id
        $module_instance = $this->Position_model->get_module_by_id($module_id);
        $module_params = unserialize($module_instance[0]->params);
        //number of entries
        $total_rows = $this->Articles_model->count_entries_by_categories($module_params['categories']);

        if ($total_rows > 0) {

            $per_page = $module_params['number'];

            $entries = $this->Articles_model->get_entries_by_categories($module_params['categories'], $per_page, $offset);
            //pre_dump($entries);
            //test jQuery pagination
            $this->load_jquery_pagination("articles/ajax/displayme/" . $module_id . "/" . $data['menu_id'] . "/", 6, $module_id, $total_rows, $per_page);
            $pagination = $this->jquery_pagination->create_links();
            //TODO: Get module for tags, get module by module name and menu_id
            //LEAVE THIS FOR OTHER VERSION
            
            $stories[] = array();
            $i = 0;
            foreach ($entries as $entry) {
                /*                 * * Entry tag initialization ** */
                //Get tags by entry id
                $tags = $this->Tag_model->get_active_tags_by_entry_id($entry->id);
                //var_dump($tags);
                if (count($tags) > 0) {
                    //TODO: Get tag by ID
                    $tag_object = $this->Tag_model->get_tag_by_id($tags[0]->tag_id);
                    $topic = $this->Topic_model->get_topic_by_id($tag_object->topic_id);
                    $topic_name = $topic[0]->name;
                    $tag_id = $tag_object->id;
                    $tag = $tag_object->tag;
                } else {
                    $topic_name = "";
                    $tag_id = 0;
                    $tag = "";
                }
                /*                 * * Get poster photo for each entry ** */
                $thumb_image_id = array();
                $thumb_image_path = array();

                $images = $this->Images_model->get_images_by_entry_id($entry->id);
                if (count($images) > 0) {
                    $j = 0;
                    foreach ($images as $image) {
                        $poster_photos[$j] = $this->Images_model->get_image($image->image_id);
                        if (isset($poster_photos[$j][0])) {
                            if ($poster_photos[$j][0]->dimension_id == $module_params['photo_size']) {
                                $thumb_image_id = $poster_photos[$j][0]->id;
                                $thumb_image_path = str_replace("../", "", $poster_photos[$j][0]->path);
                            }
                        }
                        $j++;
                    }
                }
                /*                 * * End of Poster photo initialization ** */

                $entry_type = $this->Articles_model->getTableByEntryType($entry->entry_type_id);
                $item = $this->Articles_model->getEntryType($entry->type_id, $entry_type->table_name);
                $story_author = $this->Users_model->get_user_by_id($entry->admin_user_id);

                $category = $this->Categories_model->getCategoryByID($entry->category_id);
                //var_dump($category);
                $item->lead ? $lead = $item->lead : $lead = FALSE;
                $stories_row[$i] = array("id" => $entry->type_id,
                    "type_name" => $entry_type->type_name,
                    "title" => $entry->title,
                    "lead" => $lead,
                    "photo_id" => $thumb_image_id,
                    "photo_path" => $thumb_image_path,
                    "category" => $category,
                    "menu_name" => $this->Menu_model->getNameByID($category->menu_id),
                    "creation_date" => $entry->creation_date,
                    "modified_date" => $entry->modified_date,
                    "author_name" => $story_author->username,
                    "topic_name" => $topic_name,
                    "tag" => $tag,
                    "tag_id" => $tag_id
                );
                $i++;
            }
            include $this->load->_ci_model_paths[0] . 'views/article_list_view.php';
            //$this->load->script('select_system_script');
        } else {
            include $this->load->_ci_model_paths[0] . 'views/no_articles_view.php';
        }
        //unset($this->load->_ci_model_paths);
    }

	
	private function load_pagination($pagination_url, $uri_segments, $total_rows, $per_page){
		$config['uri_segment'] = $uri_segments;
		$config['num_links'] = 2;
		$config['base_url'] = base_url()."".$pagination_url;
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		
		$config['full_tag_open'] = '<ul class="pagination">';//surround the entire pagination begining
		$config['full_tag_close'] = '</ul>';//surround the entire pagination end
		$config['num_tag_open'] = '<li>';//digit link open
		$config['num_tag_close'] = '</li>';//digit link close
		$config['cur_tag_open'] = '<li class="current_page">';//current page open
		$config['cur_tag_close'] = '</li>';//current page close
		$config['next_tag_open'] = '<li class="next_page">';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li class="previous_page">';
		$config['prev_tag_close'] = '</li>';
		$config['first_link'] = '&lt;&lt;';//first link title
		$config['first_tag_open'] = '<li class="first_page">';//first link open
		$config['first_tag_close'] = '</li>';//first link close
		$config['last_link'] = '&gt;&gt;';//last link title
		$config['last_tag_open'] = '<li class="last_page">';//last link open
		$config['last_tag_close'] = '</li>';//last link close
		$this->pagination->initialize($config);
	}
	
	private function load_jquery_pagination($pagination_url, $uri_segments, $module_id, $total_rows, $per_page){
		//$per_page = "10";
		/*** load pagination ***/
		//$this->pagination->load_pagination("story/index/0", 4, $total_rows, $per_page);
		$config['uri_segment'] = $uri_segments;
		$config['num_links'] = 2;
		$config['base_url'] = base_url()."/".$pagination_url;
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$config['div'] = '#'.$module_id; /* Here #content is the CSS selector for target DIV */
		//$config['js_rebind'] = "alert('it works !!'); "; /* if you want to bind extra js code */
					
		$config['full_tag_open'] = '<ul class="pagination">';//surround the entire pagination begining
		$config['full_tag_close'] = '</ul>';//surround the entire pagination end
		$config['num_tag_open'] = '<li>';//digit link open
		$config['num_tag_close'] = '</li>';//digit link close
		$config['cur_tag_open'] = '<li class="current_page">';//current page open
		$config['cur_tag_close'] = '</li>';//current page close
		$config['next_tag_open'] = '<li class="next_page">';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li class="previous_page">';
		$config['prev_tag_close'] = '</li>';
		$config['first_link'] = '&lt;&lt;';//first link title
		$config['first_tag_open'] = '<li class="first_page">';//first link open
		$config['first_tag_close'] = '</li>';//first link close
		$config['last_link'] = '&gt;&gt;';//last link title
		$config['last_tag_open'] = '<li class="last_page">';//last link open
		$config['last_tag_close'] = '</li>';//last link close
		$this->jquery_pagination->initialize($config);
	
	}
			
	
}

/* End of file articles.php */
/* Location: ./application/modules/articles/controllers/articles.php */
