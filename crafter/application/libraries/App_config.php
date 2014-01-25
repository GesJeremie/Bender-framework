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
 * App Config
 *
 * @package		Bender Framework
 * @subpackage	Crafter
 * @category	Libraries
 * @author		Ges Jeremie
 */
class App_config {

	/**
	 * Constructor
	 *
	 * @access	public
	 */
	public function __construct()
	{
	}

	// --------------------------------------------------------------------

	/**
	 * Environment
	 * 
	 * Get or replace environment value
	 *
	 * @access	public
	 * @param 	string 	The new value (Ex. testing / production)
	 * @return 	mixed 	Bool/string (Return false if nothing found, true if replaced or just the value)
	 */
	public function environment($replace_value='')
	{
		// Where is the value of environment ?
		$path = APP_FCPATH . 'index.php';

		// Open
		$content = file_get_contents($path);

		// Find our value
		$pattern = '#define\(\'ENVIRONMENT\', \'[a-z]*\'\);#';

		// Run regex find
		preg_match($pattern, $content, $matches);

		// Not found ?
		if (empty($matches))
		{
			return FALSE;
		}

		// Beautify code
		$environment = $matches[0];

		// Do we must replace value ?
		if ( ! empty($replace_value) && in_array($replace_value, array('development', 'testing', 'production')))
		{

			$pattern_replace = "define('ENVIRONMENT', '$replace_value');";
			$new_content = str_replace($environment, $pattern_replace, $content);

			// Delete old file
			unlink($path);

			// Create new file
			file_put_contents($path, $new_content);

			return TRUE;

		}

		// We want return the value fetched

		// Treatments
		$environment = str_replace('define(\'ENVIRONMENT\',', '', $environment);

		// Delete useless chars
		foreach (array('\'', ';', ')') as $delete_element)
		{
			$environment = str_replace($delete_element, '', $environment);
		}

		// Just trim
		$environment = trim($environment);

		return $environment;

	}	

	// --------------------------------------------------------------------

	/**
	 * Get routes
	 * 
	 * Get all routes of the routes.php file 
	 *
	 * @access	public
	 * @return 	array 	All routes
	 */

	public function get_routes()
	{

		$path = APP_APPPATH . 'config/routes.php';

		// Explode and list in array all lines of file
		$lines = $this->_get_lines_file($path);

		// Get our config value
		$routes = $this->_get_array_config($lines, 'route');

		return $routes;

	}


	/**
	 * Add route
	 * 
	 * Add new route in the config file routes.php
	 *
	 * @access	public
	 * @param 	string 	Index of new route array
	 * @param 	string 	Value of new route array
	 * @return 	bool
	 */
	public function add_route($rewrite, $execute)
	{

		$path = APP_APPPATH . 'config/routes.php';

		// Explode and list in array all lines of file
		$lines = $this->_get_lines_file($path);

		// Init last position
		$last_position = FALSE;

		// Loop all lines
		foreach ($lines as $pos => $line)
		{
			// Tiny security
			$line = trim($line);

			// Check if it's the route config array
			if (substr($line, 0, 7) === '$route[')
			{
				// Right now, this line it's the last position of the route array
				$last_position = $pos;
			}
		}

		// Did we found the last position ?
		if ($last_position === FALSE)
		{
			return FALSE;
		}

		// Add new key / value route in the lines array at the last position
		array_splice($lines, $last_position+1, 0, '$route[\'' . $rewrite . '\'] = \'' . $execute . '\';');

		// Remake the content
		$content = implode("\n", $lines);

		// Delete file
		unlink($path);

		// Recreate file
		file_put_contents($path, $content);

		// It's ok
		return TRUE;
		
	}

	/**
	 * Delete route
	 * 
	 * Just delete specific route
	 *
	 * @access	public
	 * @param 	string 	The key in route array to delete
	 * @return 	bool 	
	 */
	public function delete_route($rewrite)
	{

		$path = APP_APPPATH . 'config/routes.php';

		// Explode and list in array all lines of file
		$lines = $this->_get_lines_file($path);

		// Count chars
		$rewrite_len = strlen($rewrite);

		// Init delete index
		$delete_index = FALSE;

		// Loop all lines
		foreach ($lines as $pos => $line)
		{
			// Tiny security
			$line = trim($line);

			// Is it the route array config ?
			if (substr($line, 0, 7) === '$route[')
			{
				// Explode
				list($key, $value) = explode('=', $line);

				// Key treatment
				$key = str_replace('$route[', '', $key);
				$key = trim($key, '\'"] ');	

				// Is it the key to delete ?
				if ($key == $rewrite)
				{
					// Stock the position
					$delete_index = $pos;

					// Found, stop loop
					break;
				}

			}

		}

		// Did we found the key to delete ?
		if ($delete_index === FALSE)
		{
			return FALSE;
		}

		// Delete key in lines
		unset($lines[$delete_index]);

		// Remake the content
		$content = implode("\n", $lines);

		// Delete file
		unlink($path);

		// Recreate file
		file_put_contents($path, $content);

		// It's ok
		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Get lines file
	 * 
	 * Open file submited and get all lines with array way
	 *
	 * @access	private
	 * @param 	string 	The path where we want fetch lines
	 * @return 	array
	 */
	private function _get_lines_file($path)
	{

		if ( ! file_exists($path))
		{
			return FALSE;
		}

		$content = file_get_contents($path);
		$lines = explode("\n", $content);

		return $lines;

	}

	/**
	 * Get array config
	 * 
	 * Get specific config array 
	 *
	 * @access	private
	 * @param 	string 	All lines of file where we want fetch datas
	 * @param 	string 	The var name of the config to fetch
	 * @return 	array
	 */
	private function _get_array_config($lines, $name)
	{

		// Init config var
		$config = array();

		foreach ($lines as $line)
		{
			$line = trim($line);

			// Ex. Name "route" become $route[
			$start_array = '$' . $name . '[';

			// It is a line about our array config ?
			if (substr($line, 0, strlen($start_array)) == $start_array)
			{
				list($key, $value) = explode('=', $line);

				// Key treatment
				$key = str_replace($start_array, '', $key);
				$key = trim($key, '\'"] ');	

				// Value treatment
				$value = trim($value, ';\'" ');

				// Fill array
				$config[$key] = $value;

			}
		}

		return $config;

	}

}

/* End of file Parser_logs.php */
/* Location: ./application/libraries/Parser_logs.php */
