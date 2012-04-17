<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comments extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('Comments_model');
		$this->load->model('Entry_state_model');
		$this->load->library('pagination');
		$this->load->helper('login_helper.php');
		check_login();
	}
	
	function index($order="id-desc", $offset=0){
		//print_r($this->session->userdata);
		$data['offset'] = $offset;
		$order_array = explode('-', $order);
		$data['orderColumn'] = $order_array[0];
		$data['order'] = $order_array[1];
		//echo "test";
		$total_rows = $this->Comments_model->getNumRows();
		//print_r($total_rows);
		$per_page = "10";
		//$data['offset'] = $offset;
		/*** load pagination ***/
		$data['model'] =& $this->Comments_model;
		$data['comments'] = $this->Comments_model->getComments($per_page, $offset, $order_array);
		$comments = array();
		foreach($data['comments'] as $key=>$values){
			foreach($values as $index=>$value){
				$comments[$key][$index]=$value;
				if($index=='entry_id'){
					$comments[$key]['entry_title'] = $this->Comments_model->get_entry_title($value);
				}
			}
		}
		$data['comments'] = $this->createList($comments);
		$this->pagination->load_pagination("comments/index/".$order, 4, $total_rows, $per_page);
		$data['pagination'] = $this->pagination->create_links();
	
		$this->load->view('header_view');
		$this->load->view('list_view', $data);
	}
	
	function edit(){
		$id = $this->uri->segment(3);
		$data['offset'] = $this->uri->segment(4);
		$data['comment'] = $this->Comments_model->getComment($id);
		$this->load->view('header_view');
		$this->load->view('edit_view', $data);
	}
	
	function edit_post(){
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$body = $this->input->post('body');
		$offset = $this->input->post('offset');
		
		$this->Comments_model->update($id, $name, $email, $body);
		$this->messages->add('Comment successfully edited', 'success');
		redirect('/comments');
	}
	
	
	function comment_post(){
		$data['menu_id'] = $this->input->post('menu_id');
		$data['item_id'] = $this->input->post('item_id');
		$this->form_validation->set_message('required', 'Ovo polje je obavezno.');
		$this->form_validation->set_rules('name', 'Ime', 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean');
		$this->form_validation->set_rules('comment', 'comment', 'required|max_length[600]|xss_clean');
		
		if($this->form_validation->run()==FALSE){
			$this->load->view('commentsReload_view', $data);
		}else{
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$comment = $this->input->post('comment');

			$this->Comments_model->insert($data['item_id'], $name, $email, $comment);
		
			$this->load->view('success_view', $data);
		}
	}
	
	function delete(){
		$ids = $this->input->post('ids');
		$ids = explode(',', $ids);
		$count = count($ids);
		foreach($ids as $id){
			$this->Comments_model->delete($id);
		}
		$this->messages->add($count.' Comment(s) successfully deleted', 'success');
	}
	
	function publish(){
		$ids = $this->input->post('ids');
		$ids = explode(',', $ids);
		$count = count($ids);
		foreach($ids as $id){
			$this->Comments_model->publish($id);
		}
		$this->messages->add($count.' Comment(s) successfully published', 'success');
	}
	
	function unpublish(){
		$ids = $this->input->post('ids');
		$ids = explode(',', $ids);
		$count = count($ids);
		foreach($ids as $id){
			$this->Comments_model->unpublish($id);
		}
		$this->messages->add($count.' Comment(s) successfully unpublished', 'success');
	}
	
	/**
	 * Add string instead of state FK state id
	 * @param $items
	 * @return array $ $result_array
	 */
	private function createList($items){
		$result_array = array();
		foreach($items as $item){
			$item['state'] = $this->Entry_state_model->getStateName($item['status']);
			$result_array[] = $item; 
		}
		
		return $result_array;
	}
}

/* End of file comments.php */
/* Location: ./application/modules/comments/controllers/comments.php */