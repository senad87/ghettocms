<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Advanced_headbox extends MX_Controller {
    protected $articles;
    protected $entry_type;
    protected $users;
    protected $categories;
    protected $images;
    protected $stories;
    protected $position;
    protected $tag;
    protected $topic;
    protected $menu;

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->entry_type = $this->load->model('Entry_type_model');
        $this->articles = $this->load->model('articles/Articles_model');
        $this->users = $this->load->model('users/Users_model');
        $this->categories = $this->load->model('categories/Categories_model');
        $this->images = $this->load->model('images/Images_model');
        $this->stories = $this->load->model('stories/Stories_model');
        $this->position = $this->load->model('position/Position_model');
        $this->tag = $this->load->model('tags/Tag_model');
        $this->topic = $this->load->model('tags/Topic_model');
        $this->menu = $this->load->model('menu/Menu_model');
        //$this->load->library('pagination');
        //$this->load->library('Jquery_pagination');
    }
    
    public function displayme( $module_id, $data = array(), $offset = 0 ){
        //TODO: This is big hack fix ASAP
        $data_menu_id = $data;
        if (!is_array($data)) {
            $data = array();
            $data['menu_id'] = $data_menu_id;
        }
        
        //load module instance by id
        $module_instance = $this->Position_model->get_module_by_id($module_id);
        $module_params = unserialize($module_instance[0]->params);
        $data['module_params'] = $module_params;
        
        //pre_dump( $data['module_params'] );
        $counter = 0;
        foreach ($module_params['items'] as $set_item) {
            //var_dump($set_item);
              $items[$counter] = $this->articles->getEntryByID( $set_item );
              $images = $this->Images_model->get_images_by_entry_id( $set_item );
              $items[$counter]->image_id = "";
              $items[$counter]->image_path = "";
              $items[$counter]->category = $this->categories->getCategoryByID( $items[$counter]->category_id );
              $items[$counter]->entry_type = $this->entry_type->getTypeByID( $items[$counter]->entry_type_id ); 
              if ( count($images) > 0 ) {
                $j = 0;
                foreach ($images as $image) {
                  $poster_photos[$j] = $this->Images_model->get_image($image->image_id);
                  if (isset($poster_photos[$j][0])) {
                      if ($poster_photos[$j][0]->dimension_id == 1) {
                          $items[$counter]->image_id = $poster_photos[$j][0]->id;
                          $items[$counter]->image_path = str_replace("../", "", $poster_photos[$j][0]->path);
                      }
                  }
                  $j++;
                }
              }
              //pre_dump( $images );
              
              
              $counter++;
              
        }
        $data['items'] = $items;
      //pre_dump( $items );
        //include $this->load->_ci_model_paths[0] . 'views/slider_view.php';
        $this->load->view( "slider_view", $data );
    }
    
    

}