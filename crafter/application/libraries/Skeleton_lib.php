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
 * Skeleton
 *
 * @package		Bender Framework
 * @subpackage	Crafter
 * @category	Libraries
 * @author		Ges Jeremie
 */
class Skeleton_lib {

	/**
	 * Constructor
	 *
	 * @access	public
	 */
	public function __construct()
	{
		$this->load->library('parser');
	}

	/**
	 * __get
	 *
	 * Access CI's loaded classes
	 *
	 * @param	string
	 * @access private
	 */
	function __get($key)
	{
		$CI =& get_instance();
		return $CI->$key;
	}

	/**
	 * Run
	 * 
	 * Load skeleton file, inject datas and create file parsed
	 * 
	 * @access	public
	 * @param 	string 	The skeleton file to load
	 * @param 	array 	Datas to inject into the skeleton file
	 * @param 	string 	Path where you want create new file parsed
	 * @return	bool
	 */
	public function run($load_skeleton, $datas, $output)
	{
		// Open file
		$content = file_get_contents(APPPATH . 'views/_skeletons/' . ltrim($load_skeleton, '/') . '.php');

		// Parse string
		$content = $this->parser->parse_string($content, $datas, TRUE);

		// Output on the path
		$result = file_put_contents($output, $content);

		// Not created ?
		if ($result === FALSE) {

			return FALSE;

		}

		// Success !
		return TRUE;

	}

}


/* End of file Skeleton.php */
/* Location: ./application/libraries/Skeleton.php */
