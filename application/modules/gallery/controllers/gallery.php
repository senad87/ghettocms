<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gallery extends MX_Controller {

	private $db_model;
        private $entry_type;
        private $entry_images;
        private $db_entry_tags;
        private $db_tag;
        private $db_images;
        private $db_categories;
        private $language_id;
        private $published;
        private $db_admin_users;
        private $admin_user;
        const TYPE_NAME = 'gallery';
        
	
	function __construct(){
		// Call the Model constructor
		parent::__construct();
		$this->load->helper(array('form', 'url', 'date'));
                $this->db_categories = $this->load->model('categories/Categories_model');
                $this->load->model('menu/Menu_model');
                $this->load->model('Entry_model');
                $this->load->model('Entry_type_model');
                $this->load->model('Entry_state_model');
		$this->db_model = $this->load->model('Gallery_model');
		$this->db_images = $this->load->model('images/Images_model');
                $this->entry_images = $this->load->model('images/Entry_images_model');
                
                $this->db_admin_users = $this->load->model('admin_users/Admin_Users_model');
		$this->admin_user = $this->load->model('admin_users/Admin_User_model');
                
                $this->load->model('comments/Comments_model');
                $this->db_entry_tags = $this->load->model('Entry_tags_model');
                $this->db_tag = $this->load->model('tags/Tag_model');
                $this->load->library('image_lib');
                //$this->load->library('Jquery_pagination');
                $this->entry_type = $this->Entry_type_model->getTypeByName( self::TYPE_NAME );
                $this->published = $this->Entry_state_model->getStateByName( 'Published' );
                $this->language_id = 1;
                
                $this->load->library('pagination');
        }
        
        //display single gallery
    public function index($from_menu, $entry_id) {
        $from_menu = $this->security->xss_clean($from_menu);
        $entry_id = $this->security->xss_clean($entry_id);
        $data['from_menu_id'] = $from_menu;
        $menu = $this->Menu_model->getMenuByID($data['from_menu_id']);
        //TODO: DAMIR proveriti sta se desava sa ovim postom
        //senad: getting post data if anything is posted to this menu/page/item or what eva
        if ( count($_POST) > 0 ) {
            $data['post'] = $_POST;
        } else {
            $data['post'] = false;
        }
        
        $entry = $this->Entry_model->getEntryByID($entry_id);
        $entry->gallery = $this->db_model->getGalleryByID( $entry->type_id );
        //pre_dump( $entry->gallery );
        $entry->category = $this->db_categories->getCategoryByID($entry->category_id);
        
        $images = $this->db_images->getImagesByEntryID($entry_id);

        foreach ($images as $image) {
            $entry->images[] = $this->db_images->getImageByID($image->image_id);
        }
        usort( $entry->images, function($a, $b){
                                       return ($a->order > $b->order);
                                       });
        $author = $this->admin_user->init($entry->admin_user_id, $this->db_admin_users);
        $entry->author_name = $author->getUsername();

        //senad: getting the flag "comments" in entries and categories 
        //to see wheter to show comments or not both on entrie and category level
        $cat_ids = $this->Comments_model->getEntryCategoryId($entry->id);
        $cat_comment_status = $this->Comments_model->checkStatusForCat($cat_ids);
        $entry_comment_status = $this->Comments_model->checkStatusForEntry($entry->id);
        $data['cat_comment_status'] = $cat_comment_status;
        $data['entry_comment_status'] = $entry_comment_status;
        $entry->num_of_comments = $this->Comments_model->countEntryComments($entry->id);
        $entry->tags = $this->db_entry_tags->attachTags($entry, $this->db_tag);

        $data['item'] = $entry;
        
        $this->load->view('single_default_view', $data);
    }
                
        //svaki modul bi trebalo da bude svestan menija na kom se nalazi, 
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
           //pre_dump( $menu );
           $data['menu'] = $menu;
            /*** get module params ***/
            //load module instance by id
            $module_instance = $this->Position_model->get_module_by_id( $module_id );
            $module_params = unserialize($module_instance[0]->params);
            $data['module_id'] = $module_id;
            $data['module_params'] = $module_params;
            //number of entries
            $total_rows = $this->Entry_model->countByTypeAndCategory( $module_params['categories'], $this->entry_type->id, 
                                                                      $this->language_id, $this->published->id );
           
            if( $total_rows > 0 ){
                $data['items'] = array();
                $data['total_rows'] = $total_rows; 
                $per_page = $module_params['number'];
                $this->load_pagination( $menu->name . "/" . $data['menu_id'] . "/", $uri_segments = 3, $total_rows, $per_page);
                $data['pagination'] = $this->pagination->create_links();
                 
                 
                 $entries = $this->Entry_model->getByTypeAndCategoryLimited( $module_params['categories'], $this->entry_type->id, 
                                                                             $per_page, $offset, 
                                                                             $this->language_id, $order_col = 'id',
                                                                             $order = 'desc', $this->published->id );
                 //Foreach entry we need tags and topics, author, poster photo ...
                 foreach( $entries as $entry ){
                     
                     $entry->type_name = self::TYPE_NAME;
                     $entry->category = $this->db_categories->getCategoryByID( $entry->category_id );
                     $entry->gallery = $this->db_model->get_gallery_by_id( $entry->type_id );
                     $entry->menu = $this->Menu_model->getMenuByID( $entry->category->menu_id );
                     $this->entry_images->init( $this->db_images, $entry );
                     $entry->image = $this->entry_images->getImageByDim( $module_params['photo_size'] );
                     
                     $author = $this->admin_user->init( $entry->admin_user_id, $this->db_admin_users );
                     $entry->author_name = $author->getUsername();
                     
                     $entry->num_of_comments = $this->Comments_model->countEntryComments( $entry->id );
                     //TODO: Get Tags and Topics
                     $entry = $this->db_entry_tags->attachTags( $entry, $this->db_tag );
                     $data['items'][] = $entry;
                 }
                 $data['total_rows'] = $total_rows;
                 $this->load->view( 'list_view', $data );
            }else{
                show_404();
                //TODO: Display message : There is no content in this Category
            }
        }
        
        public function getImages(){
            $gallery_id = $this->input->post('gallery_id');
            $entry_id = $this->Entry_model->get_entry_id_by_type_id( $gallery_id, 3 );
            //get images ids
            $images = $this->Images_model->get_images_by_entry_id( $entry_id );
            
            $images_paths = array();
            foreach($images as $image){
                $image = $this->Images_model->get_image($image->image_id);
                $images_data[] = $image[0];
            }
            $data['gallery_id'] = $gallery_id;
            //pre_dump( $images_data );
            
            usort( $images_data, function($a, $b){
                                            return ($a->order > $b->order);
                                          });
            
            $data['images_data'] = $images_data;
            //pre_dump( $data['images_data'] );
            $this->load->view('gallery_view', $data);            
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
}
/* End of file gallery.php */
/* Location: ./system/application/controllers/gallery.php */
