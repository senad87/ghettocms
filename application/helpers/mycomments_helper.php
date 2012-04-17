<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

	$CI =& get_instance();
 	//print_r($CI);die;
	$CI->load->model('comments/Comments_model');
	
	
	function count_comments($entry_id){
		global $CI;
		if($CI->Comments_model->getComments($entry_id)){
			return count($CI->Comments_model->getComments($entry_id));
		}else{
			return 0;
		}
	}
	