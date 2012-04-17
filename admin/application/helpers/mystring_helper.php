<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function cut($string, $length=40, $append='...' ){

			$cut = substr($string, 0, $length);
			if(strlen($string) > $length){
				$cut = $cut.$append;
			}
			return $cut;
	}
	
	function neat_trim($str, $n=40, $delim='...') {
		   
		   $len = strlen($str);
		   if($len > $n){
		       preg_match('/(.{' . $n . '}.*?)\b/', $str, $matches);
		       return rtrim($matches[1]) . $delim;
		   }else{
		       return $str;
		   }
	}
	

	function url_sufix($string){
		$string = preg_replace("/[^a-zA-Z]/", " ", $string);
		$sufix = str_replace(" ", "_", $string).".html";
		return $sufix;
	}
	
	/**
	 * Cut string to n symbols and add delim but do not break words.
	 *
	 * Example:
	 * <code>
	 *  $string = 'this sentence is way too long';
	 *  echo neat_trim($string, 16);
	 * </code>
	 *
	 * Output: 'this sentence is...'
	 *
	 * @access public
	 * @param $str string string we are operating with
	 * @param $n integer character count to cut to
	 * @param string|NULL delimiter. Default: '...'
	 * @return string processed string
	 **/
	function word_trim($str, $n, $delim='...') {
	   $len = strlen($str);
	   if ($len > $n) {
	       preg_match('/(.{' . $n . '}.*?)\b/', $str, $matches);
	       return rtrim($matches[1]) . $delim;
	   }
	   else {
	       return $str;
	   }
	}
