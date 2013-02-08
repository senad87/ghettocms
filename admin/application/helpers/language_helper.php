<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$CI = get_instance();
    	$CI->load->model('Language_model', '', TRUE);

/**
 * getLanguages
 *
 * Get list of activated languages
 */    	
if (!function_exists('getLanguages')){
	function getLanguages(){
		global $CI;
		$languages = $CI->Language_model->get_all();
		return $languages;
	}
}
