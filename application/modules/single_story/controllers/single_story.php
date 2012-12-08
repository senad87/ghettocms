<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Single_story extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('articles/Articles_model');
        $this->load->model('users/Users_model');
        $this->load->model('categories/Categories_model');
        $this->load->model('images/Images_model');
        $this->load->model('stories/Stories_model');
    }

    public function displayme($module_id, $data = array()) {

        $module_instance = $this->Position_model->get_module_by_id($module_id);
        //load module params and insert them into array
        $module_params = unserialize($module_instance[0]->params);
        
        $entry = $this->Articles_model->getEntryByID( $module_params['story_id'] );
        $story = $this->Stories_model->get_story_by_id( $entry->type_id );
        
        $images = $this->Images_model->get_images_by_entry_id( $entry->id );
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

        include $this->load->_ci_model_paths[0] . 'views/single_story_view.php';
    }

}