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

		$content = file_get_contents(APPPATH . 'views/_skeletons/' . ltrim($load_skeleton, '/') . '.php');
	
		foreach ($datas as $key => $value)
		{
			$content = str_replace('{' . $key . '}', $value, $content);
		}
		
		$result = file_put_contents($output, $content);

		if ($result === FALSE) {

			return FALSE;

		}

		return TRUE;

	}

}


/* End of file Skeleton.php */
/* Location: ./application/libraries/Skeleton.php */
