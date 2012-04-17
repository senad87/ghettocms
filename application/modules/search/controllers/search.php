<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends MX_Controller {
	
	
	public $id;
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model('Search_model');
		$this->load->library('pagination');
	}
	
	function displayme($module_id, $data=array(), $offset = 0){
		//$this->id = $module_id;
		//var_dump(count($data));
		//TODO: This is big hack fix ASAP
		//var_dump($data);
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
		//print_r($this->load->_ci_model_paths[0]);
		include $this->load->_ci_model_paths[0].'views/search_box_view.php';

	}	

	function post(){
	$keyword = $this->uri->segment(3);
	$offset = $this->uri->segment(5);
	$offset==false?$offset=0:"";
		if($_POST){
			$module_id = $this->input->post('id');
			$sub['module_id'] = $module_id;
			$sub['offset'] = 0;
			$sub['keyword'] = $this->input->post('keyword');
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
		//var_dump($keyword);
		$menu_id = $data['menu_id'];		
		if(isset($keyword) && $keyword!=''){
		//echo 'test';
		//print_r($sub);
			/*** load pagination ***/
			
			$total_rows = $this->Search_model->countResults($keyword);
			$per_page = "5";
	
			$this->load_pagination("search/post/".$sub['keyword']."/".$id, 5, $total_rows, $per_page);
			
			$results = $this->Search_model->search($keyword, $offset, $per_page);
			$pagination = $this->pagination->create_links();
			/*** end of pagination ***/
			//$entries = $this->Entry_model->get_undeleted_entries(1, $per_page, $offset);
		}
		//if($results==false){
		$message = "Nema rezultata koji odgovaraju datoj ključnoj reči.";
		

		include "application/modules/search/views/results_list_view.php";
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
	
	function test(){
		echo 'test';
	}
			
	
}

/* End of file articles.php */
/* Location: ./application/modules/articles/controllers/articles.php */
