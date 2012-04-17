<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$CI =& get_instance();
    	$CI->load->model('category/Category_model', '', TRUE);

/**
 * addCategoryName
 *
 * Function get array of entries and add Category name into array
 */    	
if (!function_exists('addCategoryName')){
	function addCategoryName($entries){
		global $CI;
		$entries_array = array();
		foreach($entries as $entry){
			$entry['category'] = $CI->Category_model->getName($entry['category_id']);
			$entries_array[] = $entry;
		}
		return $entries_array;
	}
}
