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
 * Parser logs
 *
 * @package		Bender Framework
 * @subpackage	Crafter
 * @category	Libraries
 * @author		Ges Jeremie
 */
class Parser_logs {

	/**
	 * Stock path of logs folder
	 *
	 * @var string
	 */
	private $_logs_folder = '';

	/**
	 * Stock all files fetched in the logs directory
	 *
	 * @var array
	 */
	private $_files = array();

	/**
	 * All datas filled by generic method _get_datas()
	 *
	 * @var array
	 */
	private $_datas = array();

	// --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * Find where is the logs folder in the base application
	 * and fetch all files
	 *
	 * @access	public
	 */
	public function __construct() 
	{

		// Where is the log folder in the base application ?
		$this->_logs_folder = $this->_find_logs_folder();

		// Fetch all files
		$this->_files = glob($this->_logs_folder . 'log-*.php');


		// We are ready, exec some methods !

	}

	// --------------------------------------------------------------------

	/**
	 * Count files
	 *
	 * Count all logs files fetched
	 *
	 * @access	public
	 * @return	int
	 */
	public function count_files() 
	{

		return count($this->_files);

	}

	// --------------------------------------------------------------------

	/**
	 * Logs folder
	 *
	 * Return logs path
	 *
	 * @access	public
	 * @return	int
	 */
	public function logs_folder()
	{
		return $this->_logs_folder;
	}

	// --------------------------------------------------------------------

	/**
	 * Find dates
	 *
	 * Find all logs dates
	 *
	 * @access	public
	 * @return	mixed 	bool/array
	 */
	public function find_dates() {

		// Run request
		$this->_get_datas();

		// Error
		if ($this->_datas === FALSE)
		{
			return FALSE;
		}

		// Init dates results
		$dates = array();

		foreach ($this->_datas as $datas)
		{
			// Add dates
			$dates[] = str_replace('log-', '', $datas['name']);
		}

		// We fetched all dates, now return values
		return $dates;

	}

	// --------------------------------------------------------------------

	/**
	 * Find by date
	 *
	 * Find all logs by specific date
	 *
	 * @access	public
	 * @param	string 	Catch only files with this date (Ex. 2013-12-20)
	 * @return	bool 	bool/array
	 */
	public function find_by_date($date)
	{

		// Run request
		$this->_get_datas();

		// Error
		if ($this->_datas === FALSE)
		{
			return FALSE;
		}

		// Init date results & increment
		$date_results = array();
		$increment = 0;

		foreach ($this->_datas as $datas)
		{
			$the_date = str_replace('log-', '', $datas['name']);

			// Is it the same date ?
			if ($the_date === $date)
			{
				foreach ($datas['datas'] as $data)
				{
					// Add in results date
					$date_results[$increment] = $data;

					// Where we are in the array ?
					$increment++;
				}
			}
		}


		// No results ? Bummer ...
		if (empty($date_results))
		{
			return FALSE;
		}

		// We get results, return !
		return $date_results;

	}

	// --------------------------------------------------------------------

	/**
	 * Find all
	 *
	 * Find all logs
	 *
	 * @access	public
	 * @return	bool 	bool/array
	 */
	public function find_all() 
	{

		// Run request
		$this->_get_datas();

		// Error
		if ($this->_datas === FALSE)
		{
			return FALSE;
		}

		// Init results & increment
		$results = array();
		$increment = 0;

		// Loop all logs files
		foreach ($this->_datas as $datas)
		{
			// Loop only datas, we drop name
			foreach ($datas['datas'] as $data)
			{
				$results[$increment] = $data;

				$increment++;

			}
		}

		return $results;
		
	}

	// --------------------------------------------------------------------

	/**
	 * Delete
	 *
	 * Delete file by date
	 *
	 * @access	public
	 * @return	bool
	 */
	public function delete($date)
	{

		foreach ($this->_files as $file)
		{
			// Get the date
			$the_date = str_replace($this->_logs_folder . 'log-', '', $file);

			// Drop ".php"
			$the_date = substr($the_date, 0, -4);
			
			// Find the date !
			if ($date === $the_date)
			{
				// Check if file exists
				if (file_exists($file))
				{
					// Delete !
					unlink($file);

					return TRUE;
				}
			}

		}

		// Bummer ...
		return FALSE;

	}

	// --------------------------------------------------------------------

	/**
	 * Find logs folder
	 *
	 * Find where is the log folder
	 *
	 * @access	private
	 * @return	string 	The absolute log path
	 */
	private function _find_logs_folder() 
	{

		// Path of config file
		$config_file = APP_APPPATH . 'config/config.php';

		// Require file to fetch $config datas
		require($config_file);

		// Get log path
		if (empty($config['log_path'])) {

			$log_path = APP_APPPATH . 'logs/';


		} else {

			$log_path = $config['log_path'];
		}

		// Unset useless datas
		unset($config);

		return $log_path;

	}

	// --------------------------------------------------------------------

	/**
	 * Get datas
	 *
	 * Generic method, fetch all logs 
	 *
	 * @access	private
	 * @return	bool 	bool/array
	 */
	private function _get_datas() 
	{

		$results = array();

		foreach ($this->_files as $key => $file) 
		{

			// Get the name of file
			$name = str_replace($this->_logs_folder, '', $file);
			$name = str_replace('.php', '', $name);

			// Stock data
			$results[$key]['name'] = $name;

			// Get content
			$content = file_get_contents($file);

			// Explode lines
			$lines = explode("\n", $content);

			// Drop useless lines
			unset($lines[0]); // if defined [...]
			unset($lines[1]); // Blank line

			// Re assign keys
			$lines = array_values($lines);

			// Loop all files
			foreach ($lines as $line) 
			{

				if ( ! empty($line))
				{
					$results[$key]['datas'][] = $this->_parse_line($line);
				}

			}

		}

		// Security
		if (empty($results))
		{
			$results = FALSE;
		}

		$this->_datas = $results;

	}
	
	// --------------------------------------------------------------------

	/**
	 * Parse line
	 *
	 * Parse log line and retrieve datas
	 *
	 * @access	public
	 * @param	string 	Line to parse
	 * @return	string 	Line parsed
	 */
	private function _parse_line($line)
	{

		// Get the label
		$end_label = strpos($line, '-');
		$label = substr($line, 0, $end_label);
		$label = trim($label);

		// Get the date & description
		list($date, $description) = explode('-->', substr($line, $end_label+1));

		$date = trim($date);
		$description = trim($description);

		// Convert date to timestamp
		$date_timestamp = strtotime($date);

		// Return line parsed
		$parsed = array(

			'label'		  		=> $label,
			'date_gmt' 		 	=> $date,
			'date_timestamp'	=> $date_timestamp,
			'description' 		=> $description

			);	

		return $parsed;


	}


}

/* End of file Parser_logs.php */
/* Location: ./application/libraries/Parser_logs.php */
