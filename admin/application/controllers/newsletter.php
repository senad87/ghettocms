<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Newsletter extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		//$this->load->model('Comments_model');
		$this->load->model('Menu_model');
		$this->load->model('Story_model');
		$this->load->model('Entry_model');
		$this->load->model('Category_model');
		$this->load->model('Image_model');
		$this->load->model('Newsletter_model');
		$this->load->library('Jquery_pagination');
		$this->home_id = $this->Menu_model->get_home_id();
		//$this->load->library('pagination');
		//check_login();
	}
	
	function index(){
		$subscribers = $this->Newsletter_model->getSubscribers();
		//print_r($subscribers);
		$message = $this->uri->segment(3);
		if($message){
			$data['message'] = "You have successfully send newsletter.";
		}
		
		$data['home_id'] = $this->Menu_model->get_home_id();
					$total_rows = $this->Entry_model->get_number_of_non_deleted_entries_by_type(1);
					$per_page = "20";
					/*** load pagination ***/
					//$this->pagination->load_pagination("story/index/0", 4, $total_rows, $per_page);
					$config['uri_segment'] = 4;
					$config['num_links'] = 2;
					$config['base_url'] = base_url()."/newsletter/stories_ajax";
					$config['total_rows'] = $total_rows;
					$config['per_page'] = $per_page;
					$config['div'] = '#content'; /* Here #content is the CSS selector for target DIV */
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
					$data['pagination'] = $this->jquery_pagination->create_links();
					/*** end of pagination ***/
					$entries = $this->Entry_model->get_undeleted_entries(1, $per_page, $offset = 0);
					foreach($entries as $entry){
						$story = $this->Story_model->get_story_by_id($entry->type_id);
						$stories_array_of_objects[] = $story[0];		
					}
					$data['stories'] = $stories_array_of_objects;
					//var_dump($data['pagination']);
					$this->load->view('header_view');
					$this->load->view('newsletter/newsletter_view', $data);
	}
	
	
	
	public function stories_ajax($offset = 0){
		//$data['home_id'] = $this->Menu_model->get_home_id();
		$total_rows = $this->Entry_model->get_number_of_non_deleted_entries_by_type(1);
		$per_page = "20";
		/*** load pagination ***/
		//$this->pagination->load_pagination("story/index/0", 4, $total_rows, $per_page);
		$config['uri_segment'] = 3;
		$config['num_links'] = 2;
		$config['base_url'] = base_url()."/newsletter/stories_ajax";
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$config['div'] = '#content'; /* Here #content is the CSS selector for target DIV */
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
					$data['pagination'] = $this->jquery_pagination->create_links();
					/*** end of pagination ***/
					$entries = $this->Entry_model->get_undeleted_entries(1, $per_page, $offset);
					foreach($entries as $entry){
						$story = $this->Story_model->get_story_by_id($entry->type_id);
						$stories_array_of_objects[] = $story[0];		
					}
					$data['stories'] = $stories_array_of_objects;
 					$this->load->view("newsletter/stories_list_view", $data);
	}
	
	
	public function add_stories(){
		$data['home_id'] = $this->Menu_model->get_home_id();
		$data['ids'] = $this->input->post('ids');
		foreach($data['ids'] as $id){
		 	$story = $this->Story_model->get_story_by_id($id);
	        $entry_id = $this->Entry_model->get_entry_id_by_type_id($id, 1);
	        $categories = $this->Category_model->get_categories_by_entry_id($entry_id);
	        $images = $this->Image_model->get_images_by_entry_id($entry_id);
	        
	        $i=0;
	        foreach($images as $image){
	        	$poster_photos[$i] = $this->Image_model->get_image($image->image_id);
	        	
	        	if(isset($poster_photos[$i][0])){
	        		if($poster_photos[$i][0]->poster_photo == 1 && $poster_photos[$i][0]->dimension_id == 2){
	        		
	        			$thumb_image = $poster_photos[$i];
	        		}
	        	}
	        	$i++;
	        }
	        
	        //TODO:check url for image display
	        if(isset($thumb_image)){
	        	$data['thumb_images'][$id] = $thumb_image;
	        }
	        
	        foreach($categories as $category){
	    		$set_categories[][$id] = $category->category_id;
	    	}
	    	$data['entry_id'][$id] = $entry_id;
	    	$data['set_categories'][$id]=$set_categories;
	        $data['root_categories'][$id]=$this->Category_model->get_category_kids(0);
	    
	        $data['stories'][$id] = $story[0];
	        
	        $modified_date = explode(" ", $story[0]->modified_date);
	        $modified_date_array = explode("-", $modified_date[0]);
	        $modified_date = $modified_date_array[1]."/".$modified_date_array[2]."/".$modified_date_array[0];
	        $data['modified_date'] = $modified_date;
	        
		}      
	        //$this->load->view("header_view");
	        //$this->load->view('stories/edit_story_form_view', $data);
	        $this->load->view('newsletter/newsletter_content_view', $data);
	
	}
	
	public function send(){
		$data['home_id'] = $this->Menu_model->get_home_id();

		$ids = $this->input->post('ids');
		$ids = unserialize($ids);
		$subscribers = $this->Newsletter_model->getSubscribers();
		
		
		/*** get stories data ***/
		foreach($ids as $id){
		 	$story = $this->Story_model->get_story_by_id($id);
	        $entry_id = $this->Entry_model->get_entry_id_by_type_id($id, 1);
	        $categories = $this->Category_model->get_categories_by_entry_id($entry_id);
	        $images = $this->Image_model->get_images_by_entry_id($entry_id);
	        
	        $i=0;
	        foreach($images as $image){
	        	$poster_photos[$i] = $this->Image_model->get_image($image->image_id);
	        	
	        	if(isset($poster_photos[$i][0])){
	        		if($poster_photos[$i][0]->poster_photo == 1 && $poster_photos[$i][0]->dimension_id == 2){
	        		
	        			$thumb_image = $poster_photos[$i];
	        		}
	        	}
	        	$i++;
	        }
	        
	        //TODO:check url for image display
	        if(isset($thumb_image)){
	        	$data['thumb_images'][$id] = $thumb_image;
	        }
	        
	        foreach($categories as $category){
	    		$set_categories[][$id] = $category->category_id;
	    	}
	    	$data['entry_id'][$id] = $entry_id;
	    	$data['set_categories'][$id]=$set_categories;
	        $data['root_categories'][$id]=$this->Category_model->get_category_kids(0);
	    
	        $data['stories'][$id] = $story[0];
	        
	        $modified_date = explode(" ", $story[0]->modified_date);
	        $modified_date_array = explode("-", $modified_date[0]);
	        $modified_date = $modified_date_array[1]."/".$modified_date_array[2]."/".$modified_date_array[0];
	        $data['modified_date'] = $modified_date;
		}  
		
		
		$this->load->library('email');
		
		$config['protocol'] = 'mail';
		$config['wordwrap'] = FALSE;
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		
		$this->email->from('no-reply@nsz.gov.rs' , 'NSZ Poslovi');
		 
		//$this->email->cc('another@another-example.com'); 
		//$this->email->bcc('them@their-example.com'); 
		
		
		foreach($subscribers as $subscriber){
			$msg = '';
			$msg = $this->load->view('newsletter/newsletter_content_view', $data, TRUE);
			$this->email->subject('NSZ Poslovi - Newsletter');
			$this->email->to($subscriber->email);
			$msg.="<br />Кликните <a href='".root_url()."newsletter/unsubscribe/".$subscriber->md5."/' >овде</a> ако желите да се одјавите.";
			$this->email->message($msg);	
			$this->email->send();
		}
		
		//echo $this->email->print_debugger();
		//die;
		//his->index();
		redirect('newsletter/index/mes');
	} 

	
	/*private function getStoriesDetails($ids_array){
		//$data['ids'] = $this->input->post('ids');
		foreach($ids_array as $id){
		 	$story = $this->Story_model->get_story_by_id($id);
	        $entry_id = $this->Entry_model->get_entry_id_by_type_id($id, 1);
	        $categories = $this->Category_model->get_categories_by_entry_id($entry_id);
	        $images = $this->Image_model->get_images_by_entry_id($entry_id);
	        
	        $i=0;
	        foreach($images as $image){
	        	$poster_photos[$i] = $this->Image_model->get_image($image->image_id);
	        	
	        	if(isset($poster_photos[$i][0])){
	        		if($poster_photos[$i][0]->poster_photo == 1 && $poster_photos[$i][0]->dimension_id == 2){
	        		
	        			$thumb_image = $poster_photos[$i];
	        		}
	        	}
	        	$i++;
	        }
	        
	        //TODO:check url for image display
	        if(isset($thumb_image)){
	        	$data['thumb_images'][$id] = $thumb_image;
	        }
	        
	        foreach($categories as $category){
	    		$set_categories[][$id] = $category->category_id;
	    	}
	    	$data['entry_id'][$id] = $entry_id;
	    	$data['set_categories'][$id]=$set_categories;
	        $data['root_categories'][$id]=$this->Category_model->get_category_kids(0);
	    
	        $data['stories'][$id] = $story[0];
	        
	        $modified_date = explode(" ", $story[0]->modified_date);
	        $modified_date_array = explode("-", $modified_date[0]);
	        $modified_date = $modified_date_array[1]."/".$modified_date_array[2]."/".$modified_date_array[0];
	        $data['modified_date'] = $modified_date;
	        
	        return $details_array = array('set_categories'=>);
		}
	
	}*/
	

			
	
}

/* End of file articles.php */
/* Location: ./application/controllers/newsletter.php */
