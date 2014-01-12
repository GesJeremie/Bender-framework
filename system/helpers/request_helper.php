<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Bender Framework
 *
 * An open source application development framework for PHP based on the core of CodeIgniter 2.1.4
 *
 * @package     Bender Framework
 * @author      Ges Jeremie
 * @link        https://github.com/GesJeremie/Bender-framework
 */

// ------------------------------------------------------------------------

/**
 * Bender Request Helpers
 *
 * @package     Bender Framework
 * @subpackage  Helpers
 * @category    Helpers
 * @author      Ges Jeremie
 * @link        /
 */

// ------------------------------------------------------------------------

if ( ! function_exists('_check_request'))
{
    /**
    * Check request
    *
    * Check if it's a POST request
    *
    * @access private
    * @param string $type The value to test
    * @return bool 
    */
    function _check_request($type)
    {
        // Get instance of CI
        $CI =& get_instance();

        // Get current type request method
        $request = $CI->input->server('REQUEST_METHOD');

        // Check if current request method equal to type
        if ($request === $type)
        {
            return TRUE;
        }

        // Bummer ...
        return FALSE;

    }
}

if ( ! function_exists('is_post'))
{
	/**
    * Is post
    *
    * Check if it's a POST request
    *
    * @return bool 
    */
	function is_post()
	{
		return _check_request('POST');
	}
}

if ( ! function_exists('is_get'))
{
	/**
    * Is get
    *
    * Check if it's a GET request
    *
    * @return bool 
    */
	function is_get()
	{
		return _check_request('GET');
	}
}

if ( ! function_exists('is_put'))
{
	/**
    * Is put
    *
    * Check if it's a PUT request
    *
    * @return bool 
    */
	return _check_request('PUT');
}

if ( ! function_exists('is_delete'))
{
	/**
    * Is delete
    *
    * Check if it's a DELETE request
    *
    * @return bool 
    */
	return _check_request('DELETE');
}


/* End of file request_helper.php */
/* Location: ./system/helpers/request_helper.php */