<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model('Categories_model');	
	}

	function index()
	{
		$data['categories'] = $this->Categories_model->getCategories();
		$data['categories_model'] =& $this->Categories_model;
		$this->load->view('header_view');	
		$this->load->view('categoriesList_view', $data);
		$this->load->view('footer_view');
	}
	
	function createNew(){
		$data['sections'] = $this->Categories_model->getSections();
		$this->load->view('header_view');	
		$this->load->view('newCategory_view', $data);
		$this->load->view('footer_view');
	}
	
	function createNew_post(){
		$title = $this->input->post('title');
		$description = $this->input->post('description');
		$section_id = $this->input->post('section_id');
		//TODO: dodati falidation i poruke
		$this->Categories_model->insertCategory($section_id, $title, $description);
		
		$this->index();
		
	}
	
	function edit(){
		$this->load->view('header_view');	
		$this->load->view('editArticle_view');
		$this->load->view('footer_view');
	}
	function delete(){
		//after delete
		$this->index();
	}
	function publish(){
		//after publish
		$this->index();
	}
	function unpublish(){
		//after unpublish
		$this->index();
	}
			
	
}

/* End of file articles.php */
/* Location: ./application/modules/page/controllers/articles.php */
