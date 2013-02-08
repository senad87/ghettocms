<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Banners extends MX_Controller {

	private $language_id = 1;
        private $controller = 'banners';
        private $model;
        private $width;
        private $height;
        
	
	function __construct(){
		// Call the Model constructor
		parent::__construct();
		$this->load->helper( array('form', 'url', 'date', 'login_helper') );
		$this->load->library('pagination');
                $this->model = $this->load->model('Banners_model');
                $this->load->library('Jquery_pagination');
		$this->lang->load('messages', 'english');
		$this->language_id = $this->session->userdata('language_id');
		check_login();
	}
        
        public function index( $order="id-desc", $offset=0 ){
            $data['offset'] = $offset;
            $order_array = explode('-', $order);
            $data['orderColumn'] = $order_array[0];
            $data['order'] = $order_array[1];
            
            //get all published and unpublished entries of the story type
	    $total_rows = $this->model->countActive( $this->language_id );
	    $per_page = "20";
            /*** load pagination ***/
	    $this->pagination->load_pagination($this->controller . "/index/".$order, 4, $total_rows, $per_page);
	    /*** end of pagination ***/
	    $data['items'] = $this->model->getActiveLimited($per_page, $offset, $this->language_id, 1);
	    
            $this->load->view('header_view');
            $this->load->view('list_view', $data);
        }
        
        public function createNew(){
            $this->load->view("header_view");
            $this->load->view('new_view');
        }
        
        public function createNew_post(){
            
            $title = $this->input->post('title');
	    $lead = $this->input->post('lead');
            $url = $this->input->post('url');
	    $activation_date = $this->input->post('activation_date');
            //from datepicker to mysql datetime format
            $creation_date_array = explode("/", $activation_date);
	    $activation_date = $creation_date_array[2]."-".$creation_date_array[0]."-".$creation_date_array[1]." ".date("G:i:s");
            
            $creation_date = date('Y-m-d G:i:s');
            
            /*** file uplaod cofniguration ***/
	    $uplaod_folder = '../images/banners/';
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
	        
	    if ( $this->upload->do_upload('image_file') ){
	    	$data = array('upload_data' => $this->upload->data());
	    	$file_name = $data['upload_data']['file_name'];
	    	$file_path = $images_dir."".$data['upload_data']['file_name'];
	        
                $copy_name = $this->width."x".$this->height."_".$file_name;
		$copy_file_path = $images_dir."".$copy_name;
		$this->resize_poster_photo($file_path, $this->width, $this->height, $copy_name);
                
                $banner_id = $this->model->insert($title, $lead, $url, $creation_date, $activation_date, $copy_file_path, $state = 2, $this->language_id);
                //pre_dump( $banner_id );
                $this->messages->add('Banner successfully created', 'success');
	        redirect('/banners');	
	    }else{
                redirect('/banners/createNew');
            }
            
        }
        
        public function edit( $entry_id, $message_id = 0 ){
            $banner = $this->model->getBannerByID($entry_id);
            $data['item'] = $banner;
            //get date from mysql datetime
            $activation_date = explode(" ", $data['item']->activation_date);
            $activation_date = mysql_to_human($activation_date[0]);
            $data['modified_date'] = $activation_date;

            $this->load->view("header_view");
            $this->load->view('edit_view', $data);
        }
        
        public function edit_post(){
            $item_id = $this->input->post('item_id');
            $title = $this->input->post('title');
	    $lead = $this->input->post('lead');
            $url = $this->input->post('url');
	    $activation_date = $this->input->post('activation_date');
            $file_location = $this->input->post('file_location');
            //from datepicker to mysql datetime format
            $creation_date_array = explode("/", $activation_date);
	    $activation_date = $creation_date_array[2]."-".$creation_date_array[0]."-".$creation_date_array[1]." ".date("G:i:s");
            
            if(!$file_location){
                /*** file uplaod cofniguration ***/
                $uplaod_folder = '../images/banners/';
                $current_date_string = md5(date("Y-m-d"));
                $images_dir = $uplaod_folder."".$current_date_string."/";
                if (!file_exists($images_dir))
                    mkdir($images_dir);
                
                $config['upload_path'] = $images_dir;
                $config['allowed_types'] = 'jpg|jpeg|';
                $config['max_size']	= '1000';
                $config['overwrite']	= FALSE;
                $this->load->library('upload', $config);
                /*** end of file upload configuration ***/
                if ( $this->upload->do_upload('image_file') ){
                    $data = array('upload_data' => $this->upload->data());
                    $file_name = $data['upload_data']['file_name'];
                    $file_path = $images_dir."".$data['upload_data']['file_name'];

                    $copy_name = $this->width."x".$this->height."_".$file_name;
                    $copy_file_path = $images_dir."".$copy_name;
                    $this->resize_poster_photo($file_path, $this->width, $this->height, $copy_name);

                    $this->model->update($item_id, $title, $lead, $url, $activation_date, $copy_file_path);
                    //pre_dump( $banner_id );
                    $this->messages->add('Banner successfully updated', 'success');
                    redirect('/banners');	
                }else{
                    redirect('/banners/createNew');
                }
            }else{
                $this->model->update( $item_id, $title, $lead, $url, $activation_date, $file_location );
                $this->messages->add('Banner successfully updated', 'success');
                redirect('/banners');
            }
            
            
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