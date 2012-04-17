<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MX_Exceptions extends CI_Exceptions
{

	/**
	 * General Error Page Override
	 *
	 * This function takes an error message as input
	 * (either as a string or an array) and displays
	 * it using the specified template.
	 *
	 * @access	private
	 * @param	string	the heading
	 * @param	string	the message
	 * @param	string	the template name
	 * @return	string
	 */
	function show_error($heading, $message, $template = 'error_general', $status_code = 500)
	{
		//$ci =& get_instance();
		//var_dump($ci);die;
		//print_r($template);
		//$template = 'error_general';
		set_status_header($status_code);

		$message = '<p>'.implode('</p><p>', ( ! is_array($message)) ? array($message) : $message).'</p>';

		if (ob_get_level() > $this->ob_level + 1)
		{
			ob_end_flush();
		}
		//echo 'test';
		//$vars = get_defined_vars();
		//print_r();
		ob_start();
		include(APPPATH.'errors/'.$template.EXT);
		//redirect('menu/index/51');
		//header(header('Location: http://www.example.com/'));
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
}