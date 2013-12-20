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
 * Humanizer Class
 *
 * With Bender Humanizer you can reduce your business code in your views, 
 * and humanize your datas, enjoy !
 * 
 * @package		Bender Framework
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Ges Jeremie
 */
class CI_Humanizer {

	public function __construct()
	{
		// Nothing here dude.
	}

	/**
	 * Run
	 *
	 * Run humanizer
	 *
	 * @access	private
	 * @param	array 	Array to humanize
	 * @param 	string 	Name function to execute
	 * @return	bool
	 */
	public function run($datas, $function)
	{
		// Check if method exists before execute
		if ( ! method_exists($this, $function))
		{
			return FALSE;
		}

		// Check type datas
		if ( ! is_array($datas))
		{
			return FALSE;
		}

		// Init humanize
		$humanize = array();

		// Check if we must loop array or not
		if ($this->_is_multi_array($datas))
		{
			foreach ($datas as $data)
			{
				// Enqueue results
				$humanize[] = $this->$function($data);
			}
		}
		else
		{
			// Single request
			$humanize = $this->$function($datas);
		}

		return $humanize;

	}

	/**
	 * Multi Array
	 *
	 * Check if an array is multidimensional
	 *
	 * @access	private
	 * @param	array 	Array to check
	 * @return	bool
	 */
	private function _is_multi_array($datas) {

		if (count($datas) !== count($datas, COUNT_RECURSIVE))
		{
			return TRUE;
		}

		return FALSE;

	}

}

?>