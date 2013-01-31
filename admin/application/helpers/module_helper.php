<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function serializePost( $parray = array() ){

            foreach ($parray as $key => $value) {
                if ($key != "module" && $key != "position_id" && $key != "menu_id" && $key != "module_title" && $key != "module_description" && $key != "name") {
                    $param[$key] = $value;
                }
            }
            $params = serialize($param);
            //var_dump($params);
            return $params;
	}
