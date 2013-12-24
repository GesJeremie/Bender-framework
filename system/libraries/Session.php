<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
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
 * Session Class
 *
 * Replace default session class of CodeIgniter 
 * 
 * @package		BenderFramework
 * @subpackage	Libraries
 * @category	Sessions
 * @author		Jeremie Ges
 */
class CI_Session  {

	private $session_id = FALSE;

	/**
	 * Constructor
	 *
	 * The constructor checks if session started
	 * and tell to log system which instantiated.
	 */
	public function __construct() 
	{
		
		log_message('debug', 'Session Class Initialized');

		// Start session
		if ( ! $this->session_id) 
		{
			session_start();
			$this->session_id = session_id();
		}


	}

	/**
	 * Put new value with label, value and filter
	 *
	 * @access	public
	 * @return	bool
	 */
	public function put($label, $value, $filter='_default') 
	{
		// It is an array ?
		if (is_array($label)) 
		{

			// Loop all and create new session
			foreach ($label as $k => $v) 
			{

				$_SESSION[$filter][$k] = $v;

			}


		} 
		else 
		{
			// Just create new session
			$_SESSION[$filter][$label] = $value;

		}

		return TRUE;

	}

	/**
	 * Check if key / filter exist
	 *
	 * @access	public
	 * @return	bool
	 */
	public function has($key, $filter='_default') 
	{
		if (isset($_SESSION[$filter][$key])) 
		{
			return TRUE;
		}

		return FALSE;

	}

	/**
	 * Delete key from filter
	 *
	 * @access	public
	 * @return	bool
	 */
	public function forget($key, $filter='_default') 
	{
		if (isset($_SESSION[$filter][$key])) 
		{
			unset($_SESSION[$filter][$key]);
			return TRUE;
		}

		return FALSE;

	}

	/**
	 * Delete all key in filter 
	 *
	 * @access	public
	 * @return	bool
	 */
	public function flush($filter) 
	{
		if (isset($_SESSION[$filter])) 
		{
			unset($_SESSION[$filter]);
			return TRUE;
		}

		return FALSE;

	}

	/**
	 * Use session_destroy function to destroy all session
	 *
	 * @access	public
	 * @return	bool
	 */
	public function destroy() 
	{
		if (session_destroy() === TRUE) 
		{
			return TRUE;
		}

		return FALSE;

	}


	/**
	 * Get value of key / filter
	 *
	 * @access	public
	 * @return	mixed
	 */
	public function get($key, $filter='_default') 
	{
		if (isset($_SESSION[$filter][$key])) 
		{
			return $_SESSION[$filter][$key];
		}

		 return FALSE;
	}

	/**
	 * Get value of key / filter and forget key/value just after
	 *
	 * @access	public
	 * @return	mixed
	 */
	public function flash($key, $filter='_default')
	{

		$response = $this->get($key, $filter);

		// Forget data
		$this->forget($key, $filter);

		return $response;

	}

	/**
	 * Show all current sessions
	 *
	 * @access	public
	 * @return	mixed
	 */
	public function get_all() 
	{
		return $_SESSION;
	}

	/**
	 * Show current session id
	 *
	 * @access	public
	 * @return	mixed
	 */
	public function sess_id() 
	{
		return $this->session_id;
	}

}