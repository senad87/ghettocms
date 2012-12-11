<?php

class MY_Pagination extends CI_Pagination{
	
	function __construct(){
		parent::__construct();
	}
	
    /**
	 * 
	 * Put HTML code for pagination in one single function to be called from other functions
	 * @param string $pagination_url base url for pagination
	 * @param int $uri_segments
	 * @param int $total_rows
	 * @param string $per_page
	 */
	public function load_pagination($pagination_url, $uri_segments, $total_rows, $per_page){
		//print_r($pagination_url);
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
		$this->initialize($config);
	}
	
}