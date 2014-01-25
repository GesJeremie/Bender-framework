<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Add class "active" on menu
 *
 * @access	public
 * @param 	string 	Class match
 * @return	mixed (FALSE/string)
 */
if ( ! function_exists('menu_active'))
{
	function menu_active($class)
	{
		$CI =& get_instance();

		if ($CI->router->class === $class)
		{
			return 'active';
		}

		return FALSE;

	}
}

/* End of file css_helper.php */
/* Location: ./application/helpers/css_helper.php */