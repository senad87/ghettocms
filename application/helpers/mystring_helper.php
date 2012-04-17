<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//iconv_set_encoding("internal_encoding", "UTF-8");
//iconv_set_encoding("input_encoding", "UTF-8");
//iconv_set_encoding("output_encoding", "UTF-8");
	function cut($string, $length=40, $append='...' ){

			$cut = substr($string, 0, $length);
			if(strlen($string) > $length){
				$cut = $cut.$append;
			}
			return $cut;
	}	

	function url_sufix($string){
		$string = preg_replace("/[^a-zA-Z]p{Cyrillic}]/u", " ", $string);
		$sufix = str_replace(" ", "_", $string).".html";
		return $sufix;
	}
	
	
	function chrс($letter){
		return htmlspecialchars($letter);
	}
	//error_reporting(E_ALL);
	function trans($string){
		$pairs_spec = array("NJ"=>chrс("Њ"), "LJ"=>chrс("Љ"), "Dž"=>chrс("Џ"),
					   "Ž"=>chrс("Ж"), "Đ"=>chrс("Ђ"), "Š"=>chrс("Ш"),
					   "Č"=>chrс("Ч"), "Ć"=>chrс("Ћ"),
					   "nj"=>chrс("њ"), "lj"=>chrс("љ"), "dž"=>chrс("џ"),
					   "ž"=>chrс("ж"), "đ"=>chrс("ђ"), "š"=>chrс("ш"),
					   "č"=>chrс("ч"), "ć"=>chrс("ћ"));
		
		$pairs_upper = array("A"=>chrс("А"),"E"=>chrс("Е"),"O"=>chrс("О"),"J"=>chrс("Ј"),"K"=>chrс("К"), "M"=>chrс("М"), "T"=>chrс("Т"), "R"=>chrс("Р"), "U"=>chrс("У"), "I"=>chrс("И"),
					   "P"=>chrс("П"), "S"=>chrс("С"), "D"=>chrс("Д"),
					   "F"=>chrс("Ф"), "G"=>chrс("Г"), "H"=>chrс("Х"),
					   "L"=>chrс("Л"), "Z"=>chrс("З"), "C"=>chrс("Ц"),
					   "V"=>chrс("В"), "B"=>chrс("Б"), "N"=>chrс("Н"));
		
		$pairs_lower = array("a"=>chrс("а"),"e"=>chrс("е"),"o"=>chrс("о"),"j"=>chrс("ј"),"k"=>chrс("к"), "m"=>chrс("м"), "t"=>chrс("т"),"r"=>chrс("р"), "u"=>chrс("у"), "i"=>chrс("и"),
					   "p"=>chrс("п"), "s"=>chrс("с"), "d"=>chrс("д"),
					   "f"=>chrс("ф"), "g"=>chrс("г"), "h"=>chrс("х"),
					   "l"=>chrс("л"), "z"=>chrс("з"), "c"=>chrс("ц"),
					   "v"=>chrс("в"), "b"=>chrс("б"), "n"=>chrс("н"));
		
		
		
		//$new_string=strtr($string, "RTUIOPASDFGHJKLZCVBNM", "РТУИОПАСДФГХЈКЛЗЦВБНМ");
		//$new_string=strtr($string, $pairs_clean);
		$new_string=strtr($string, $pairs_spec);
		$new_string=strtr($new_string, $pairs_upper);
		$new_string=strtr($new_string, $pairs_lower);
		
		//$new_string = htmlspecialchars("Р");
		return $new_string;
	}
	
	
	

