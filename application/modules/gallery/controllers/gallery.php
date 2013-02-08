<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gallery extends MX_Controller {

	private $entry_type;
        private $entry_images;
        private $db_entry_tags;
        private $db_tag;
        private $db_images;
        private $language_id;
        private $published;
        private $db_admin_users;
        private $admin_user;
        const TYPE_NAME = 'gallery';
        
	
	function __construct(){
		// Call the Model constructor
		parent::__construct();
		$this->load->helper(array('form', 'url', 'date'));
                $this->load->model('Entry_model');
                $this->load->model('Entry_type_model');
                $this->load->model('Entry_state_model');
		$this->load->model('Gallery_model');
		$this->db_images = $this->load->model('images/Images_model');
                $this->entry_images = $this->load->model('images/Entry_images_model');
                
                $this->db_admin_users = $this->load->model('admin_users/Adminuser_model');
		$this->admin_user = $this->load->model('admin_users/Adminuser');
                
                $this->load->model('comments/Comments_model');
                $this->db_entry_tags = $this->load->model('Entry_tags_model');
                $this->db_tag = $this->load->model('tags/Tag_model');
                $this->load->library('image_lib');
                //$this->load->library('Jquery_pagination');
                $this->entry_type = $this->Entry_type_model->getTypeByName( self::TYPE_NAME );
                $this->published = $this->Entry_state_model->getStateByName( 'Published' );
                $this->language_id = 1;
        }
                
        //svaki modul bi trebalo da bude svestam menija na kom se nalazi, 
        //da prima offset ukoliko se radi o listi,
        //da prima jos neke dodatne podatke
        public function displayme( $module_id, $data = array() ){
            if( is_array($data) ){
                $offset = $data['offset'];
            }else{
                $data_menu_id = $data;
                $data = array();
                $data['menu_id'] = $data_menu_id;
            }
            $menu = $this->Menu_model->getMenuByID( $data['menu_id'] );
            /*** get module params ***/
            //load module instance by id
            $module_instance = $this->Position_model->get_module_by_id( $module_id );
            $module_params = unserialize($module_instance[0]->params);
            
            //number of entries
            $total_rows = $this->Entry_model->countByTypeAndCategory( $module_params['categories'], $this->entry_type->id, 
                                                                      $this->language_id, $this->published->id );
            
            if( $total_rows > 0 ){
                
                 $per_page = $module_params['number'];
                 $entries = $this->Entry_model->getByTypeAndCategoryLimited( $module_params['categories'], $this->entry_type->id, 
                                                                             $per_page, $offset, 
                                                                             $this->language_id, $order_col = 'id',
                                                                             $order = 'desc', $this->published->id );
                 //Foreach entry we need tags and topics, autor, poster photo ...
                 foreach( $entries as $entry ){
                     
                     $this->entry_images->init( $this->db_images, $entry );
                     $entry->image = $this->entry_images->getImageByDim( $module_params['photo_size'] );
                     
                     $author = $this->admin_user->init( $entry->admin_user_id, $this->db_admin_users );
                     $entry->author_name = $author->getUsername();
                     
                     $entry->num_of_comments = $this->Comments_model->countEntryComments( $entry->id );
                     //TODO: Get Tags and Topics
                     $entry = $this->db_entry_tags->attachTags( $entry, $this->db_tag );
                     pre_dump($entry);
                 }
            }else{
                //TODO: Display message : There is no content in this Category
            }
        }
        
        public function getImages(){
            $gallery_id = $this->input->post('gallery_id');
            $entry_id = $this->Entry_model->get_entry_id_by_type_id($gallery_id, 3);
            //get images ids
            $images = $this->Images_model->get_images_by_entry_id($entry_id);
            
            $images_paths = array();
            foreach($images as $image){
                $image = $this->Images_model->get_image($image->image_id);
                $images_data[] = $image[0];
            }
            $data['gallery_id'] = $gallery_id;
            $data['images_data'] = $images_data;
            

            $this->load->view('gallery_view', $data);            
        }
	
	/**
	 * index
	 *
	 * Function display list of all stories with status Published or Unpublished
	 *
	 * @param int $message_id used to display message after Update or Insert gallery
	 * @param int $offset used for pagination
	 */
//	public function index($order="id-desc", $offset=0){
//	
//		$data['offset'] = $offset;
//		$order_array = explode('-', $order);
//		$data['orderColumn'] = $order_array[0];
//		$data['order'] = $order_array[1];
//		
//		//get all published and unpublished entries of the gallery type
//		$total_rows = $this->Entry_model->countByType(3, $this->language_id);
//		$per_page = "20";
//		/*** load pagination ***/
//		$this->pagination->load_pagination("gallery/index/".$order, 4, $total_rows, $per_page);
//		/*** end of pagination ***/
//		$entries = $this->Entry_model->getUndeleted(3, $per_page, $offset, $this->language_id, 1);
//		
//		//prepare array for table view
//		$data['entries'] = $this->createList($entries);
//		//print_r($data['entries']);
//		
//		/*** right columns data ***/
//		/*** load data for filters***/
//		//load root categories
//		//$data['root_categories']=$this->Category_model->get_category_kids(0, $this->language_id);
//		//load admin users list
//		//$data['authors'] = $this->Admin_user_model->get_all_users();
//		//load gallery states, TODO: function name should be change to 'get_entry_states'
//		$data['states'] = $this->Entry_state_model->get_story_states();
//		/*** end of loading data for filters ***/
//		
//		//get multiselect of all topics to mark system topics
//		$data['topics'] = $this->Topic_model->get_all_active($this->language_id);
//		$system_topics = $this->Topic_model->get_system(1, $this->language_id);
//		
//		$sys_topics_array = array();
//		foreach($system_topics as $system_topic){
//			$sys_topics_array[] = $system_topic->topic_id;
//		}
//		
//		//$data['sys_topics_array'] = $sys_topics_array;
//		/*** end of topics initialization ***/
//		$data['pagination'] = $this->pagination->create_links();
//		
//		$this->load->view('header_view');
//		$this->load->view('list_view', $data);
//	}
//	
//	/**
//	 * Add strings (names, titles) insted of FK
//	 * @param $items
//	 * @return array $ $result_array
//	 */
//	private function createList($items){
//		$result_array = array();
//		foreach($items as $item){
//			//$item['category'] = $this->Category_model->getName($item['category_id']);
//			$item['state'] = $this->Entry_state_model->getStateName($item['entry_state_id']);
//			$result_array[] = $item; 
//		}
//		
//		return $result_array;
//	}
//	
//	
//	
//	/**
//	 * trash
//	 *
//	 * Function display list of all sotires with status Deleted
//	 */
//	public function trash($order="id-desc", $offset=0){
//	
//		$data['offset'] = $offset;
//		$order_array = explode('-', $order);
//		$data['orderColumn'] = $order_array[0];
//		$data['order'] = $order_array[1];
//		
//		//TODO: Get deleted entries
//		$total_rows = $this->Entry_model->countDeleted(1, $this->language_id);
//		$per_page = "20";
//		/*** load pagination ***/
//		$this->pagination->load_pagination("gallery/trash/".$order, 4, $total_rows, $per_page);
//		/*** end of pagination ***/
//		
//		$entries = $this->Entry_model->getDeleted(1, $per_page, $offset,  $this->language_id, 1);
//		
//		$data['entries'] = addCategoryName($entries);
//		$data['pagination'] = $this->pagination->create_links();
//		//print_r($this->session->userdata);
//		$this->load->view('header_view');
//		$this->load->view('list_deleted_view', $data);
//	
//	}
//	
//	/**
//	 * new_gallery
//	 *
//	 * Function display form for adding new gallery
//	 *
//	 */
//	public function createNew(){
//
//		$root_categories = $this->Category_model->get_category_kids(0, $this->language_id);
//		$data['root_categories'] = $root_categories;
//		$image_dimension = $this->Image_model->get_dimensions();		
//		$data['largest_image'] = $image_dimension[0];
//		$current_date = date("Y-m-d");
//		/*** topics initialization ***/
//		$system_topics = $this->Topic_model->get_system(1, $this->language_id);
//        	if(count($system_topics) > 0){
//			foreach($system_topics as $system_topic){
//				$topic = $this->Topic_model->get_topic_by_id($system_topic->topic_id);
//				//get tags by topic id
//				$tags[$system_topic->topic_id] = $this->Tag_model->get_active_tags_by_topic_id($system_topic->topic_id);
//				$topics[] = $topic[0];
//			}
//			//$data['all_topics'] = $this->Topic_model->get_all_active();
//			$data['linked_topics'] = $this->Topic_model->get_linked_topic(1, $this->language_id);
//			$data['topics'] = $topics;
//			$data['tags'] = $tags;
//			/*** end of topic initialization ***/
//        	}
//                
//                $data['images'] = $this->Images_model->getImages();
//                
//		$this->load->view("header_view");
//		$this->load->view('new_view', $data);
//		
//	}
//	
//	/**
//	 * add_new
//	 *
//	 * Function get data from POST and insert new gallery into database
//	 *
//	 */
//	public function createNew_post(){
//	
//	        $j = 0;
//	        $tags_id = array();
//	        foreach($_POST as $key => $value){
//		       if(isset($category_array)){
//			       if($category_array[0] == "tag"){
//			    	$tags_id[$j] = $value;
//				    $j++;
//			    	}
//		    	}
//	        }
//	       
//	        $category_id =  $this->input->post('category_id');
//	        $headline =  $this->input->post('headline');
//	        $title = $this->input->post('title');
//	        $lead = $this->input->post('lead');
//	        $creation_date = date('Y-m-d G:i:s');
//                $imagepaths = $this->input->post('images');
//	        
//	        //$creation_date_array = explode("/", $creation_date);
//	        //$creation_date = $creation_date_array[2]."-".$creation_date_array[0]."-".$creation_date_array[1]." ".date("G:i:s");
//	        
//	        $body = $this->input->post('editor1');
//
//		$admin_user_id = $this->session->userdata('id');
//		$entry_id = $this->Gallery_model->insert($title, $lead, $category_id, $tags_id, $this->language_id, $creation_date, $admin_user_id);
//		
//                
//                //galleri images insert(they are already uploaded)
//                foreach($imagepaths as $imagepath){
//                    $image_id = $this->Image_model->insert_new('', $imagepath);
//                    $this->Image_model->connect_with_entry($entry_id, $image_id);
//                }
//		   
//	        /*** file uplaod cofniguration ***/
//		$uplaod_folder = '../images/';
//		$current_date_string = md5(date("Y-m-d"));
//		$images_dir = $uplaod_folder."".$current_date_string."/";
//		if (!file_exists($images_dir))
//            		mkdir($images_dir);
//            	//chmod($images_dir, 0777);
//            
//	        $config['upload_path'] = $images_dir;
//		$config['allowed_types'] = 'jpg|jpeg|';
//		$config['max_size']	= '1000';
//		$config['overwrite']	= FALSE;
//		$this->load->library('upload', $config);
//		/*** end of file upload configuration ***/
//	        
//		if ($this->upload->do_upload('image_file')){
//			$data = array('upload_data' => $this->upload->data());
//			$file_name = $data['upload_data']['file_name'];
//			$file_path = $images_dir."".$data['upload_data']['file_name'];
//				
//		        $image_id = $this->Image_model->insert_new($file_name, $file_path);
//		        $this->Image_model->connect_with_entry($entry_id, $image_id);
//			$dimensions = $this->Image_model->get_other_dimensions();
//		        foreach($dimensions as $dimension){
//		        	$copy_name = $dimension->width."x".$dimension->height."_".$file_name;
//		        	$copy_file_path = $images_dir."".$copy_name;
//		        	$this->resize_poster_photo($file_path, $dimension->width, $dimension->height, $copy_name);
//		        	$copy_image_id = $this->Image_model->insert_new($copy_name, $copy_file_path, $image_id, 1, $dimension->id);
//		        	$this->Image_model->connect_with_entry($entry_id, $copy_image_id);
//		        }
//		        //connect image with entrie
//		}
//		
//		/*** insert tags ***/
//		if ($entry_id > 0){
//			$message_id = 1;
//		        if ($this->input->post('title_topic') > 0){
//			       	$this->Tag_model->insert($title, intval($this->input->post('title_topic')));
//		        }
//	        }else{
//		       $message_id = 2;
//	        }
//	        $this->messages->add('gallery successfully created', 'success');
//	        redirect('/gallery');	
//	}
//	
//	/**
//	 * edit
//	 *
//	 * Function display form for gallery edit
//	 *
//	 */
//	public function edit($entry_id, $message_id = 0){
//
//	        $entry = $this->Entry_model->getEntryByID($entry_id);
//	        $data['entry'] = $entry;
//	        $gallery = $this->Gallery_model->get_gallery_by_id($entry->type_id);
//                
//                $data['images_ids'] = $this->Image_model->get_images_by_entry_id($entry_id);
//                
//                
//                
//                
//                $data['images'] = array();
//                foreach($data['images_ids'] as $image_ids){
//                    //print_r($image_ids['image_id']);
//                    $image = $this->Image_model->get_image($image_ids->image_id);
//                    $data['images'][$image_ids->image_id] = $image[0];
//                }
//                
//                //echo "<pre>";
//                //print_r($data['images_ids']);
//                //echo "</pre>";
//                //die;
//	    	$data['entry_id'] = $entry_id;
//	    	$data['set_category'] = $entry->category_id;
//	        $data['root_categories']=$this->Category_model->get_category_kids(0, $this->language_id);
//	        
//	        /*** initialize tags for gallery ***/
//	        $gallery_tags = $this->Tag_model->get_active_tags_by_entry_id($entry_id);
//	        $set_tags = array();
//	        if(count($gallery_tags) > 0){
//		        foreach ($gallery_tags as $gallery_tag){
//			    		$set_tag = $this->Tag_model->get_tag_by_id($gallery_tag->tag_id);
//			    		$set_tags[$set_tag[0]->topic_id] = $set_tag[0]->id;
//				}
//	        	$data['set_tags'] = $set_tags;
//	        }
//	        
//	        /*** end of tags initialization ***/
//	        
//	        /*** load system topics ***/
//		$system_topics = $this->Topic_model->get_system(1, $this->language_id);
//	        $topics = array();
//	        $tags = array();
//		
//	        foreach($system_topics as $system_topic){
//	            $topic = $this->Topic_model->get_topic_by_id($system_topic->topic_id);
//	            //get tags by topic id
//	            $tags[$system_topic->topic_id] = $this->Tag_model->get_active_tags_by_topic_id($system_topic->topic_id);
//	            $topics[] = $topic[0];
//	        }
//	        $data['topics'] = $topics;
//	        $data['tags'] = $tags;
//	        $gata['gallery_tags'] = $gallery_tags;
//	        /*** end of system tags loading ***/
//		//display message with error if image is missing or upload is faild
//	        if($message_id == 4){
//	        	$data['message'] = $this->lang->line('message_gallery_updated_faild');
//	        }else{
//	        	$data['message'] = "";
//	        }
//	        $data['gallery'] = $gallery;
//	        //get date from mysql datetime
//	        $modified_date = explode(" ", $entry->modified_date);
//	        $modified_date = mysql_to_human($modified_date[0]);
//	        $data['modified_date'] = $modified_date;
//	        
//	        $this->load->view("header_view");
//	        $this->load->view('edit_view', $data);  
//	
//	}
//	
//	/**
//	 * edit_post
//	 *
//	 * Function get POST data and update gallery data
//	 *
//	 */
//	 //TODO: This is next thing to be done, fix this
//	public function edit_post(){
//
//		//TODO: Check this part, only tags need to be separated from POST array
//		$i = 0;
//		$j = 0;
//		$category_id = array();
//		$tags_id = array();
//		foreach($_POST as $key => $value){
//			$category_array = explode("_", $key);
//			if($category_array[0] == "tag"){
//			    	$tags_id[$j] = $value;
//				    $j++;
//			    }
//		}
//                
//                //TODO:
//                //collect post like this
//                //foreach($_POST as $key=>$value){
//                //$data[$key] = $this->input->post($key);
//                //}
//
//                $id = $this->input->post('gallery_id');
//		$title = $this->input->post('title');
//		$entry_id = $this->input->post('entry_id');
//		$lead = $this->input->post('lead');
//		$category_id = $this->input->post('category_id');
//                $creation_date = date('Y-m-d G:i:s');
//                $images = $this->input->post('images');
//                
//                $gallery_images = $this->Image_model->get_images_by_entry_id($entry_id);
//                $gallerie_images_array = array();
//                //cast $gallery_images object to array an take only needed values
//                foreach($gallery_images as $gal_img){
//                    $gallerie_images_array[] = $gal_img->image_id;
//                }
//                //galleri images insert/deletion (they are already uploaded)
//                //$posted_gallery_images sadrzi id-ijeve slika koje su vec dodate u galeriju ciji broj moze niti umanjen
//                //u slucaju da je user izbrise sliku koja je bila dodata pre pocetka editovanja(prilokom kreiranja) galerije
//                $posted_gallery_images = array();
//                //$added_images_paths sadrzi putanje slika koje su dodate galleriji u toku editovanja
//                $added_images_paths = array();
//                //$image_val is id(for image already added to gallery) or image path(for image added during editing)
//                if(!empty($images)){
//                    foreach($images as $image_val){
//                        if(is_numeric($image_val)){
//                            //slike koje su vec dodate u galeriju, za njih $image_val ima vrednost id-ja
//                            $posted_gallery_images[] = $image_val;
//                        }else{
//                            //slike koje su dodate prilikom editovanja, za njih dobijam image path to su nove slike
//                            $added_images_paths[] = $image_val;
//                        } 
//                    }
//                }
//                
//                $forDeletion = array_diff($gallerie_images_array, $posted_gallery_images);
//                
//                //echo "<pre>";
//                //print_r($gallery_images);
//                //echo "</pre>";
//                if(!empty($forDeletion)){
//                    foreach($forDeletion as $del_image_id){
//                        $this->Image_model->delete_connection_for_single_image($entry_id, $del_image_id);
//                    }
//                }
//               //die;
//                //new images 
//                foreach($added_images_paths as $path){
//                    $image_id = $this->Image_model->insert_new('', $path);
//                    $this->Image_model->connect_with_entry($entry_id, $image_id);
//                }
//
//		//$image_id = $this->input->post('image_id');
//		$admin_user_id = $this->session->userdata('id');
//		/*** update category ***/
//                //TODO: Check this update, this can be removed now due to entry update in line 408
//                $this->Entry_model->updateCategoryID($id, $category_id);
//		/*** end of category update ***/
//		
//
////               if(!$image_id || $image_id < 1){
////			
////			$uplaod_folder = '../images/';
////			$current_date_string = md5(date("Y-m-d"));
////			$images_dir = $uplaod_folder."".$current_date_string."/";
////				if (!file_exists($images_dir))
////	    		mkdir($images_dir);
////			    		
////		        //chmod($images_dir, 0777);
////			$config['upload_path'] = $images_dir;
////			$config['allowed_types'] = 'jpg|jpeg|';
////			$config['max_size']	= '1000';
////			$config['overwrite']	= FALSE;
////			$this->load->library('upload', $config);
////			
////			
////			
////			if ($this->upload->do_upload('image_file')){
////				$data = array('upload_data' => $this->upload->data());
////				$file_name = $data['upload_data']['file_name'];
////				//$full_path = $data['upload_data']['full_path'];
////				$file_path = $images_dir."".$data['upload_data']['file_name'];
////				//$admin_user_id = $this->session->userdata('id');
////				//disconnect entry from all images
////				$this->Image_model->delete_connection($entry_id);
////				//Insert new image
////				$new_image_id = $this->Image_model->insert_new($file_name, $file_path);
////				$this->Image_model->connect_with_entry($entry_id, $new_image_id);
////				$dimensions = $this->Image_model->get_other_dimensions();
////				foreach($dimensions as $dimension){
////					$copy_name = $dimension->width."x".$dimension->height."_".$file_name;
////					$copy_file_path = $images_dir."".$copy_name;
////					$this->resize_poster_photo($file_path, $dimension->width, $dimension->height, $copy_name);
////					$copy_image_id = $this->Image_model->insert_new($copy_name, $copy_file_path, $new_image_id, 1, $dimension->id);
////			    		//connect entry with new copy
////					$this->Image_model->connect_with_entry($entry_id, $copy_image_id);
////				}    	
////			}else{
////				
////			}
////		}
//             
//		
//		if(count($tags_id) > 0){
//			$existing_tags = $this->Tag_model->get_tags_by_entry_id($entry_id);
//			
//			$existing_tags_array = array();
//				foreach($existing_tags as $existing_tag){
//				$existing_tags_array[] = $existing_tag->tag_id;
//			}
//			
//			/*** gallery tag update ***/
//			//first disconect entry from all tags, update active to 0 in join_entries_tags
//			$this->Tag_model->update_tags_state_by_entry_id($entry_id);
//			//foreach set tag from edit form update active to 1
//			foreach($tags_id as $tag){
//				$this->Tag_model->update_join_state($entry_id, $tag, 1);
//				//if tag is not in existing tags and is not empty or 0 insert new tag 
//				if(!in_array($tag, $existing_tags_array) && $tag > 0 && $tag != ""){
//					$this->Tag_model->insert_entry_tag($entry_id, $tag);
//				}
//			}
//			/*** end of gallery tags update ***/
//		}
//		//TODO: Update entry data
//		$this->Entry_model->update($entry_id, $title, $category_id);
//		$this->Gallery_model->update_gallery_data($id, $lead);
//		$this->messages->add('Gallery successfully edited', 'success');
//		redirect('/gallery');
//	}
//	
//	/**
//	 * delete
//	 *
//	 * Function set status of selected stories to deleted(status id = 1)
//	 *
//	 */
//	public function delete(){
//
//		$ids = $this->input->post('ids');
//	    	$ids = explode(",", $ids);
//	    	$count = count($ids);
//		foreach ($ids as $id){
//		//var_dump($id);
//			$this->Entry_model->update_entry_state($id, 1);
//		}
//		$this->messages->add($count.' gallery(s) successfully deleted', 'success');
//		
//	}
//	
//	/**
//	 * publish
//	 *
//	 * Function update status of selected stories to published(status id = 3)
//	 */
//	public function publish(){
//		$ids = $this->input->post('ids');
//	    $ids = explode(",", $ids);
//	    $count = count($ids);
//		foreach ($ids as $id){
//			$this->Entry_model->update_entry_state($id, 3);
//		}
//		$this->messages->add($count.' Stories successfully published', 'success');
//	}
//	
//	/**
//	 * unpublish
//	 *
//	 * Function update status of selected stories to unpublished(status id = 2)
//	 */
//	public function unpublish(){
//		$ids = $this->input->post('ids');
//        $ids = explode(",", $ids);
//        $count = count($ids);
//		foreach ($ids as $id){
//			$this->Entry_model->update_entry_state($id, 2);
//		}
//		$this->messages->add($count.' Stories successfully unpublished', 'success');
//	}
//	
//	/**
//	 * restore
//	 * 
//	 * Set status to unpublish if category of the stories is not deleted
//	 */
//	public function restore(){
//		//TODO: Add check of gallery category
//		$ids = $this->input->post('ids');
//        	$ids = explode(",", $ids);
//        	//var_dump($ids);
//        	$count = count($ids);
//		foreach ($ids as $id){
//			$this->Entry_model->update_entry_state($id, 2);
//		}
//		$this->messages->add($count.' Stories successfully restored', 'success');
//	}
//
//	
//	public function resize_poster_photo($source_image_path, $width, $height, $copy_name){
//		$config['image_library'] = 'gd2';
//		$config['source_image']	= $source_image_path;
//		//$config['create_thumb'] = TRUE;
//		//If only the new image name is specified it will be placed in the same folder as the original
//		
//		$config['new_image'] = $copy_name;
//		$config['maintain_ratio'] = TRUE;
//		$config['overwrite']	= FALSE;
//		$config['width']	 = $width;
//		$config['height']	= $height;
//		
//		
//		$this->load->library('image_lib', $config);
//		$this->image_lib->initialize($config); 
//		$this->image_lib->resize();
//		return true;
//	}
//        
//        
//        
//        
//        ///galerri part
//        function loadEdit(){
//		$ids = $this->input->post('ids');
//		if($ids != ""){
//                    $data['ids'] = implode(',', $ids);
//                    $images = array();
//                    foreach($ids as $id){
//                            $images[] = $this->Images_model->getImage($id);
//                    }
//                    $data['images'] = $images;
//                    $this->load->view('loadEdit_view', $data);
//		}
//		
//		
//		
//	}
//	
//	
//	public function upload(){
//		//$uploaddir = '../upload_img';
//            
//		$uploaddir = '../images/';
//		$current_date_string = md5(date("Y-m-d"));
//		$images_dir = $uploaddir."".$current_date_string."/";
//		if (!file_exists($images_dir))
//            		mkdir($images_dir);
//                
//		$file = $images_dir . uniqid()."-".basename($_FILES['uploadfile']['name']);
//		//print_r($_FILES['uploadfile']['error']);
//                
//		if(!file_exists($file)){ 
//                    if(move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)){ 
//				//$id = $this->Images_model->insertImage($_FILES['uploadfile']['name'],$tags=$_FILES['uploadfile']['name'], $file);
//                                $file = substr($file, 2);//removes two dot at begging
//                                $response = array('id'=>uniqid(), 'filepath'=>$file);
//
//                                header('Content-type: application/json');
//                                echo json_encode($response);
//			}else{
//			 	echo "error";
//			}
//		}else{
//			echo "file_exists";
//		
//		}
//                
//               /* $dimensions = $this->Image_model->get_other_dimensions();
//                foreach($dimensions as $dimension){
//                    $copy_name = $dimension->width."x".$dimension->height."_".$file_name;
//                    $copy_file_path = $images_dir."".$copy_name;
//                    $this->resize_poster_photo($file_path, $dimension->width, $dimension->height, $copy_name);
//                    $copy_image_id = $this->Image_model->insert_new($copy_name, $copy_file_path, $image_id, 1, $dimension->id);
//                    $this->Image_model->connect_with_entry($entry_id, $copy_image_id);
//                }
//                  */      
//	}
//	
//	
//	//loads java script at the bottom of the page 
//	public function script() {
//		$data['id'] = $this->input->post('id');
//		$data['image'] = $this->input->post('image');
//		$this->load->view('script_view', $data);
//	}
//	
//	public function deleteImg(){
//	
//		$data['id'] = $this->input->post('id');
//		//print_r($data['id']);
//		$this->Images_model->deleteImage($data['id']);
//		//ovde uzmem idijeve, za njih dovucem iz baze putanje i obrisem ih i sa fajl sistema i iz baze
//		//$data['image'] = $this->input->post('image');
//		//unlink("upload_img/".$data['image']);
//	}
//	
//	public function update(){
//		$data['id'] = $this->input->post('id');
//		$data['title'] = $this->input->post('title');
//		$data['tags'] = $this->input->post('tags');
//		$this->Images_model->updateImage($data['id'], $data['title'], $data['tags']);
//	}
//	
//	public function open(){
//		$id = $this->uri->segment(3);
//		$data['image'] = $this->Images_model->getImage($id);
//		$data['image_info'] = getimagesize(root_url().substr($data['image']->path, 2));
//		//print_r($data['image_info']);
//		$data['width'] = $data['image_info'][0];
//		$data['height'] = $data['image_info'][1];
//		//print_r($data);die;
//		$this->load->view('crop_view', $data);
//	}
//	
//	public function crop(){
//			$uploaddir = '../upload_img';
//			$src = substr($this->input->post('src'), 2);
//			//print_r($src);
//			$x = $this->input->post('x');
//			$y = $this->input->post('y');
//			$width = $this->input->post('w');
//			$height = $this->input->post('h');
//			
//			$config['image_library'] = 'gd2';
//			$config['source_image']	= '../'.$src;
//			$config['width'] = $width;
//			$config['height'] = $height;
//			$config['create_thumb'] = FALSE;
//                        $config['maintain_ratio'] = FALSE; 
//		
//			$config['x_axis'] = $x;
//			$config['y_axis'] = $y;
//			$config['new_image'] = $uploaddir.'/crop';
//			//$config['new_image'] = '../'.$src.'-crop';
//			$this->image_lib->initialize($config);
//			
//			if(!$this->image_lib->crop()){
//    			echo $this->image_lib->display_errors();
//			}
//			
//			
//			/*
//			$targ_w = $targ_h = 150;
//			$jpeg_quality = 90;
//			
//			$img_r = imagecreatefromjpeg($src);
//			$dst_r = ImageCreateTrueColor($targ_w, $targ_h);
//			
//			imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y, $targ_w, $targ_h, $width, $height);
//			
//			//header('Content-type: image/jpeg');
//			//imagejpeg($dst_r, null, $jpeg_quality));*/
//	}
//        
//        public function galleries_ajax($offset = 0){
//		//$data['home_id'] = $this->Menu_model->get_home_id();
//		$total_rows = $this->Entry_model->get_number_of_published_entries_by_type(3);
//		$per_page = "20";
//		/*** load pagination ***/
//		//$this->pagination->load_pagination("story/index/0", 4, $total_rows, $per_page);
//		$config['uri_segment'] = 3;
//		$config['num_links'] = 2;
//		$config['base_url'] = base_url()."/gallery/galleries_ajax";
//		$config['total_rows'] = $total_rows;
//		$config['per_page'] = $per_page;
//		$config['div'] = '#content'; /* Here #content is the CSS selector for target DIV */
//		//$config['js_rebind'] = "alert('it works !!'); "; /* if you want to bind extra js code */
//					
//		$config['full_tag_open'] = '<ul class="pagination">';//surround the entire pagination begining
//		$config['full_tag_close'] = '</ul>';//surround the entire pagination end
//		$config['num_tag_open'] = '<li>';//digit link open
//		$config['num_tag_close'] = '</li>';//digit link close
//		$config['cur_tag_open'] = '<li class="current_page">';//current page open
//		$config['cur_tag_close'] = '</li>';//current page close
//		$config['next_tag_open'] = '<li class="next_page">';
//		$config['next_tag_close'] = '</li>';
//		$config['prev_tag_open'] = '<li class="previous_page">';
//		$config['prev_tag_close'] = '</li>';
//		$config['first_link'] = '&lt;&lt;';//first link title
//		$config['first_tag_open'] = '<li class="first_page">';//first link open
//		$config['first_tag_close'] = '</li>';//first link close
//		$config['last_link'] = '&gt;&gt;';//last link title
//		$config['last_tag_open'] = '<li class="last_page">';//last link open
//		$config['last_tag_close'] = '</li>';//last link close
//					
//					
//					
//					
//					$this->jquery_pagination->initialize($config);
//					$data['pagination'] = $this->jquery_pagination->create_links();
//					/*** end of pagination ***/
//					$entries = $this->Entry_model->getUndeleted(3, $per_page, $offset);
//					foreach($entries as $entry){
//						$story = $this->Story_model->get_gallery_by_id($entry->type_id);
//						$stories_array_of_objects[] = $story[0];		
//					}
//					$data['stories'] = $stories_array_of_objects;
// 					$this->load->view("newsletter/stories_list_view", $data);
//	}
//        
//        
//        public function getFirstImage(){
//            $gallery_id = $this->input->post('gallery_id');
//            $entry_id = $this->Entry_model->get_entry_id_by_type_id($gallery_id, 3);
//            $images = $this->Image_model->get_images_by_entry_id($entry_id);
//            if(!empty($images)){
//                $image = $this->Image_model->get_image($images[0]->image_id);
//                header('Content-type: application/json');
//                echo json_encode(array('image_path' => $image[0]->path));
//            }
//            
//        }
//        
//        public function galleryDialog(){
//            // get galleries part 
//                $total_rows = $this->Entry_model->get_number_of_published_entries_by_type(3);
//                $per_page = "20";
//                /*** load pagination ***/
//                //$this->pagination->load_pagination("story/index/0", 4, $total_rows, $per_page);
//                $config['uri_segment'] = 4;
//                $config['num_links'] = 2;
//                $config['base_url'] = base_url()."/gallery/galleries_ajax";
//                $config['total_rows'] = $total_rows;
//                $config['per_page'] = $per_page;
//                $config['div'] = '#content'; /* Here #content is the CSS selector for target DIV */
//                //$config['js_rebind'] = "alert('it works !!'); "; /* if you want to bind extra js code */
//                $config['full_tag_open'] = '<ul class="pagination">';//surround the entire pagination begining
//                $config['full_tag_close'] = '</ul>';//surround the entire pagination end
//                $config['num_tag_open'] = '<li>';//digit link open
//                $config['num_tag_close'] = '</li>';//digit link close
//                $config['cur_tag_open'] = '<li class="current_page">';//current page open
//                $config['cur_tag_close'] = '</li>';//current page close
//                $config['next_tag_open'] = '<li class="next_page">';
//                $config['next_tag_close'] = '</li>';
//                $config['prev_tag_open'] = '<li class="previous_page">';
//                $config['prev_tag_close'] = '</li>';
//                $config['first_link'] = '&lt;&lt;';//first link title
//                $config['first_tag_open'] = '<li class="first_page">';//first link open
//                $config['first_tag_close'] = '</li>';//first link close
//                $config['last_link'] = '&gt;&gt;';//last link title
//                $config['last_tag_open'] = '<li class="last_page">';//last link open
//                $config['last_tag_close'] = '</li>';//last link close
////
////
////
//                $this->jquery_pagination->initialize($config);
//                $data['pagination'] = $this->jquery_pagination->create_links();
//                /*** end of pagination ***/
//                $entries = $this->Entry_model->getUndeleted(3, $per_page, $offset = 0);
//                $galleries = array();
//                
//                foreach($entries as $entry){
//                        $galleries[$entry->type_id] = $this->Gallery_model->get_gallery_by_id($entry->type_id);
//                        $galleries[$entry->type_id]['title'] = $entry->title;
//                        $galleries[$entry->type_id]['created'] = $entry->creation_date;
//                }
//                
////                echo "<pre>";
////                print_r($galleries);
////                echo "</pre>";
//                
//                $data['galleries'] = $galleries;
//                
//                $this->load->view('gallery_dialog_view', $data);
//        }

}
/* End of file gallery.php */
/* Location: ./system/application/controllers/gallery.php */
