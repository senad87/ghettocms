<?php

class Category extends MX_Controller {

	private $language_id = 1;
	
	function __construct(){
	        // Call the Model constructor
	        parent::__construct();
	        $this->load->model('Category_model');
	        $this->load->model('menu/Menu_model');
	        $this->load->helper('categories_list_helper.php');
	        $this->load->helper('login_helper.php');
	        $this->load->library('form_validation');
	        $this->language_id = $this->session->userdata('language_id');
	        check_login();
	}

	public function index($message = ""){
		$root_categories = $this->Category_model->get_category_kids(0, $this->language_id);
		$data['message'] = $message;
		$data['root_categories'] = $root_categories;
		$this->load->view("header_view");
		$this->load->view('categories_home_view', $data);
	}

	/**
	 * 
	 * Display new form for adding new category 
	 */
	public function createNew(){

	        $root_categories = $this->Category_model->get_category_kids(0, $this->language_id);
	        $data['root_categories'] = $root_categories;
	        //Get list of all published menus
	        $data['menus'] = $this->Menu_model->getMenusByState(3, $this->language_id);
	       // var_dump($data['menus']);
	        $this->load->view("header_view");
	        $this->load->view('new_category_form_view', $data);  
	}
	
	/**
	 * 
	 * Get POST data and insert new category to database
	 */
	public function createNew_post(){

		$parent_id = $this->input->post('parent_category_id');
		$name = $this->input->post('category_name');
		$description = $this->input->post('description');
		$menu_id = $this->input->post('menu_id');
		$new_category_id = $this->Category_model->insert_new_category($parent_id, $name, $menu_id, $description, $this->language_id);
        	$this->messages->add('Category successfully created', 'success');
	        redirect('/category');
		
	}
	
	/**
	 * 
	 * Display form with category data to edit category
	 * @param int $category_id
	 */
	public function edit($category_id){
		
		$data['root_categories'] = $this->Category_model->get_category_kids(0, $this->language_id);
		$categories = $this->Category_model->get_category_by_id($category_id);
		$data['category'] = $categories[0];
        $data['menus'] = $this->Menu_model->getMenusByState(3, $this->language_id);

		$this->load->view("header_view");
        $this->load->view('edit_category_form_view', $data);  
	
	}

	public function edit_post(){

		$id = $this->input->post('category_id');
		$name = $this->input->post('category_name');
		$description = $this->input->post('description');
		$parent_id = $this->input->post('parent_category_id');
		$menu_id = $this->input->post('menu_id');
		$this->Category_model->update_category_data($id, $name, $menu_id, $parent_id, $description);
		$this->messages->add('Category successfully edited', 'success');
		redirect('/category');
		
	}

	public function delete(){
		$ids = $this->input->post('ids');
	    	$ids = explode(",", $ids);
	    	$count = count($ids);
		foreach ($ids as $id){
		//var_dump($id);
			$this->Category_model->delete_category($id);
		}
		$this->messages->add($count.' Category(s) successfully deleted', 'success');
	}
	
	public function subcategories_select(){
	
		$id = $this->input->post('root_category_id');
		$categories = $this->Category_model->get_category_kids($id);
		$count_categories = count($categories);
		$data['categories'] = $categories;
		$this->load->view('ajax_categories_selectbox_view', $data);
		  
	
	}

}
/* End of file category.php */
/* Location: ./system/application/controllers/category.php */
