<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader {

	public function script($view, $vars = array(), $return = FALSE) {
		list($path, $view) = Modules::find($view, $this->_module, 'views/scripts/');
		$this->_ci_view_path = $path;
		return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return));
	}
	
	public function style($view, $vars = array(), $return = FALSE) {
		list($path, $view) = Modules::find($view, $this->_module, 'views/styles/');
		$this->_ci_view_path = $path;
		return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return));
	}

}