<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tags extends MX_Controller {


	public $id;

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model('Topic_model');
		$this->load->model('Tag_model');
		$this->load->model('articles/Articles_model');
		$this->load->model('categories/Categories_model');
		$this->load->model('images/Images_model');
		$this->load->model('stories/Stories_model');
		$this->load->model('users/Users_model');
		$this->load->model('menu/Menu_model');
		//$this->load->library('pagination');
		$this->load->library('Jquery_pagination');
	}

	public function index($from_menu_id, $tag_id, $tag, $offset = 0){
		//print_r($from_menu_id);
		$num_of_entries = $this->Articles_model->countEntriesByTag($tag_id);
		if($num_of_entries->number > 0){
			$total_rows = $num_of_entries->number;
			$per_page = 2;
			//$entries = $this->Articles_model->get_entries_by_categories($module_params['categories'], $per_page, $offset);
			$entries = $this->Articles_model->getEntriesByTagLimited($tag_id, $per_page, $offset, FALSE);
			//TODO: Add helper for pagination
			$this->load_jquery_pagination("tags/ajax/page/".$from_menu_id."/".$tag_id."/".$tag."/", 7, "tag_list", $total_rows, $per_page);
			$pagination = $this->jquery_pagination->create_links();
			$stories[]=array();
			$i=0;
			//print_r($entries);
			foreach($entries as $one_entry){
				//print_r($entry);
				$entry = $this->Articles_model->getEntryByID($one_entry->entry_id);
				//print_r($entry_obj);
				if($entry){
					/*** Get poster photo for each entry ***/
					$thumb_image_id = array();
					$thumb_image_path = array();			
					$images = $this->Images_model->get_images_by_entry_id($entry->id);
					if(count($images) > 0){
						$j = 0;
						foreach($images as $image){
							$poster_photos[$j] =  $this->Images_model->get_image($image->image_id);
							if(isset($poster_photos[$j][0])){
								if($poster_photos[$j][0]->dimension_id == 1){
									$thumb_image_id = $poster_photos[$j][0]->id;
									$thumb_image_path = str_replace("../", "", $poster_photos[$j][0]->path);
								}
							}
							$j++;
						}
					}
					/*** End of Poster photo initialization ***/
	
					$entry_type = $this->Articles_model->getTableByEntryType($entry->entry_type_id);
					$item = $this->Articles_model->getEntryType($entry->type_id, $entry_type->table_name);
					$story_author = $this->Users_model->get_user_by_id($entry->admin_user_id);
	
					$category = $this->Categories_model->getCategoryByID($entry->category_id);
					//var_dump($category);
					$item->lead?$lead=$item->lead:$lead=FALSE;
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
								"author_name" => $story_author->username
								//"topic_name" => $topic_name,
								//"tag" => $tag,
								//"tag_id" => $tag_id
					);
					$i++;
				}
			}
			//print_r($stories_row);
			include $this->load->_ci_model_paths[0]."views/full_list_view.php";
			//$this->load->script('select_system_script');
			
		}else{
			include $this->load->_ci_model_paths[0].'views/no_articles_view.php';
		}

	}
	
	public function page($from_menu_id, $tag_id, $tag, $offset = 0){
		
		$num_of_entries = $this->Articles_model->countEntriesByTag($tag_id);
		$total_rows = $num_of_entries->number;
		//print_r($total_rows);
		$per_page = 2;
		//print_r('menu id:'.$from_menu_id."tag id:".$tag_id."tag str:".$tag."offset:".$offset);
		$entries = $this->Articles_model->getEntriesByTagLimited($tag_id, $per_page, $offset, FALSE);
		//print_r($entries);
		//TODO: Add helper for pagination
			$this->load_jquery_pagination("tags/ajax/page/".$from_menu_id."/".$tag_id."/".$tag."/", 7, "tag_list", $total_rows, $per_page);
			$pagination = $this->jquery_pagination->create_links();
			$stories[]=array();
			$i=0;
			//print_r($entries);
			foreach($entries as $one_entry) {
				$entry = $this->Articles_model->getEntryByID($one_entry->entry_id);
				
				if($entry){
					/*** Get poster photo for each entry ***/
					$thumb_image_id = array();
					$thumb_image_path = array();			
					$images = $this->Images_model->get_images_by_entry_id($entry->id);
					if(count($images) > 0){
						$j = 0;
						foreach($images as $image){
							$poster_photos[$j] =  $this->Images_model->get_image($image->image_id);
							if(isset($poster_photos[$j][0])){
								if($poster_photos[$j][0]->dimension_id == 1){
									$thumb_image_id = $poster_photos[$j][0]->id;
									$thumb_image_path = str_replace("../", "", $poster_photos[$j][0]->path);
								}
							}
							$j++;
						}
					}
					/*** End of Poster photo initialization ***/
	
					$entry_type = $this->Articles_model->getTableByEntryType($entry->entry_type_id);
					$item = $this->Articles_model->getEntryType($entry->type_id, $entry_type->table_name);
					$story_author = $this->Users_model->get_user_by_id($entry->admin_user_id);
	
					$category = $this->Categories_model->getCategoryByID($entry->category_id);
					//var_dump($category);
					$item->lead?$lead=$item->lead:$lead=FALSE;
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
								"author_name" => $story_author->username
								//"topic_name" => $topic_name,
								//"tag" => $tag,
								//"tag_id" => $tag_id
					);
					$i++;
				}
			}
			
			include $this->load->_ci_model_paths[0]."views/ajax_list_view.php";
	}

	/**
	 *
	 * Function display form with select inputs for every system topic related to
	 * stories type of the entry
	 * @param int $module_id
	 * @param array $data
	 * @param int $offset
	 */
	function displayme($module_id, $data=array(), $offset = 0){
		//TODO: This is big hack fix ASAP
		$data_menu_id = $data;
		if(!is_array($data)){
			$data = array();
			$data['menu_id'] = $data_menu_id;
		}

		$module_instance = $this->Position_model->get_module_by_id($module_id);
		//load module params
		$params_data_array = explode(";;",$module_instance[0]->params);
		$module_params = array();
		foreach ($params_data_array as $params_data){
			$param_data = explode(":=", $params_data);
			$module_params[$param_data[0]] = $param_data[1];
		}

		/*** topics initialization ***/
		$system_topics = $this->Topic_model->get_system(1);
		foreach($system_topics as $system_topic){
			$topic = $this->Topic_model->get_topic_by_id($system_topic->topic_id);
			//get tags by topic id
			$tags[$system_topic->topic_id] = $this->Tag_model->get_active_tags_by_topic_id($system_topic->topic_id);
			$topics[] = $topic[0];
		}
		$data['topics'] = $topics;
		$data['tags'] = $tags;
		/*** end of topic initialization ***/
		include $this->load->_ci_model_paths[0].'views/select_tag_view.php';

	}

	//TODO: This function filter data only by first system topic this should be moved to articles module
	public function post(){
		//keyword is tag id in this case
		$keyword = $this->uri->segment(3);
		$offset = $this->uri->segment(5);
		$offset==false?$offset=0:"";
		if($_POST){
			$module_id = $this->input->post('id');
			$sub['module_id'] = $module_id;
			$sub['offset'] = 0;
				
			//we get selected tag id
			$sub['keyword'] = $this->input->post('tag_0');
			//var_dump($sub['keyword']);
			$menu = $this->load->module('menu');
			$menu->index(0, $sub);
		}elseif($keyword){
			$sub['module_id'] = $this->uri->segment(4);
			$sub['offset'] = $offset;
			$sub['keyword'] = $keyword;
			$menu = $this->load->module('menu');
			$menu->index(0, $sub);
		}else{
			show_404('page');
		}
	}

	function dispsub($id, $sub, $data){

		$offset = $sub['offset'];
		$keyword = trans($sub['keyword']);

		$menu_id = $data['menu_id'];
		if(isset($keyword) && $keyword > 0){
			/*** load pagination ***/
			//$total_rows = $this->Search_model->countResults($keyword);
				
			$module_id = $sub['module_id'];
			//load module instance by id
			$module_instance = $this->Position_model->get_module_by_id($sub['module_id']);
			//load module params
			$params_data_array = explode(";;",$module_instance[0]->params);
			$module_params = array();
			foreach ($params_data_array as $params_data){
				$param_data = explode(":=", $params_data);
				$module_params[$param_data[0]] = $param_data[1];
			}
			//var_dump($module_params);
			$entries = $this->Articles_model->get_entries_by_tag($keyword);

			//create comma separated string of entries id
			if(count($entries) > 0){
				$entries_id_array = array();
				foreach ($entries as $entry){
					$entries_id_array[] = $entry->entry_id;
				}
				$entries_string = implode(",",$entries_id_array);

				/*** pagination part START ***/
				$total_rows = $this->Articles_model->get_num_published_by_type(1, $entries_string);
				$total_rows = $total_rows[0]->number;

				$per_page = $module_params['number'];
				//$per_page = 5; //override for testin' purpose
				//$data['offset']?$offset=$data['offset']:$offset=0; ///shor if syntax checks if offset is set and sets it to zero if it's not
				$this->load_pagination("tags/post/".$sub['keyword']."/".$id, 5, $total_rows, $per_page);
				/*** pagination part END ***/
				//get published stories by entries
				$stories_entries = $this->Articles_model->get_published_type_by_entries(1, $entries_string, $per_page, $offset);
				$pagination = $this->pagination->create_links();
				/*** end of pagination ***/
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

					//Get tags by entry id
					$tags = $this->Tag_model->get_active_tags_by_entry_id($entry_id);
					//var_dump($tags);
					if(count($tags) > 0){
						//TODO: Get tag by ID
						$tag_object = $this->Tag_model->get_tag_by_id($tags[0]->tag_id);
						$topic = $this->Topic_model->get_topic_by_id($tag_object[0]->topic_id);
						$topic_name = $topic[0]->name;
						$tag_id = $tag_object[0]->id;
						$tag = $tag_object[0]->tag;
					}else{
						$topic_name = "";
						$tag_id = 0;
						$tag = "";
					}

					$thumb_image_id = array();
					$thumb_image_path = array();

					$images = $this->Images_model->get_images_by_entry_id($entry_id);
					//var_dump($images);
					if(count($images) > 0){
						$j = 0;
						foreach($images as $image){
							$poster_photos[$j] =  $this->Images_model->get_image($image->image_id);
							//var_dump($poster_photos[$i]);
							if(isset($poster_photos[$j][0])){
								if($poster_photos[$j][0]->dimension_id == $module_params['photo_size']){

									$thumb_image_id = $poster_photos[$j][0]->id;
									$thumb_image_path = str_replace("../", "", $poster_photos[$j][0]->path);
								}
							}
							$j++;
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
								"topic_name" => $topic_name,
								"tag" => $tag,
								"tag_id" => $tag_id	
						);
						$i++;
					}
				}
			}else{
				//if($results==false){
				$message = "Nema objavljenih članaka za izabrani broj publikacije.";
			}
			//exit;
			include "application/modules/tags/views/list_view.php";
		}

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

	public function list_tags($data){
		//print_r($data['entry_id']);
		$tags_array = array();
		if(isset($data['entry_id'])){
			$tags = $this->Tag_model->get_active_tags_by_entry_id($data['entry_id']);
			//print_r($tags);
			foreach($tags as $key=>$tag){
				$tags_array[] = $this->Tag_model->get_tag_by_id($tag->tag_id);
			}
			//print_r($tags_array);
		}else{
			$tags_array = FALSE;
		}
		$data['tags'] = $tags_array;
		$this->load->view("list_tags_view", $data);
	}
}
/* End of file tags.php */
/* Location: ./application/modules/tags/controllers/tags.php */
