<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Bender Framework
 *
 * An open source application development framework for PHP based on the core of CodeIgniter 2.1.4
 *
 * @package		Bender Framework
 * @author		Ges Jeremie
 * @link		https://github.com/GesJeremie/Bender-framework
 */

// ------------------------------------------------------------------------

/**
 * Bender Assets Helpers
 *
 * @package		Bender Framework
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Ges Jeremie
 * @link		/
 */

// ------------------------------------------------------------------------

/**
 * Include stylesheet tag
 *
 * Return all stylesheets links with HTML tag
 *
 * @access	public
 * @return	mixed (FALSE/string)
 */
if ( ! function_exists('stylesheet_include_tag'))
{
	function stylesheet_include_tag($stylesheets)
	{
		// Check if assets library loaded
		if (FALSE === ($OBJ =& _get_assets_object()))
		{
			return FALSE;
		}

		// Get args given 
		$stylesheets = func_get_args();

		// Init output
		$output = '';

		// Loop all stylesheets and generate output
		foreach ($stylesheets as $stylesheet) 
		{
			$output .= $OBJ->render_css($stylesheet, TRUE) . PHP_EOL;
		}

		// Return output generated
		return $output;

	}
}

// ------------------------------------------------------------------------

/**
 * Javascript include tag
 *
 * Return all scripts links with HTML tag
 *
 * @access	public
 * @return	mixed (FALSE/string)
 */
if ( ! function_exists('javascript_include_tag'))
{
	function javascript_include_tag($javascripts)
	{
		// Check if assets library loaded
		if (FALSE === ($OBJ =& _get_assets_object()))
		{
			return FALSE;
		}

		// Get args given 
		$javascripts = func_get_args();

		// Init output
		$output = '';

		// Loop all javascripts and generate output
		foreach ($javascripts as $javascript) 
		{
			$output .= $OBJ->render_js($javascript, TRUE) . PHP_EOL;
		}

		// Return output generated
		return $output;

	}
}

// ------------------------------------------------------------------------

/**
 * Assets Object
 *
 * Determines what the assets class was instantiated as, fetches
 * the object and returns it.
 *
 * @access	private
 * @return	mixed
 */
if ( ! function_exists('_get_assets_object'))
{
	function &_get_assets_object()
	{
		$CI =& get_instance();

		// We set this as a variable since we're returning by reference.
		$return = FALSE;
		
		if (FALSE !== ($object = $CI->load->is_loaded('assets')))
		{
			if ( ! isset($CI->$object) OR ! is_object($CI->$object))
			{
				return $return;
			}
			
			return $CI->$object;
		}
		
		return $return;
	}
}


/* End of file assets_helper.php */
/* Location: ./system/helpers/assets_helper.php */