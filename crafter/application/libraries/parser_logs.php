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

	private $_logs_folder = '';
	private $_files = array();
	private $_datas = array();

	public function __construct() 
	{

		// Where is the log folder in the base application ?
		$this->_logs_folder = $this->_find_logs_folder();

		// Fetch all files
		$this->_files = glob($this->_logs_folder . 'log-*.php');


		// We are ready, exec some methods !

	}

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

	public function count_files() 
	{

		return count($this->_files);

	}

	public function find_all() {

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
					$results[$key]['datas'][] = $this->parse_line($line);
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

	public function parse_line($line)
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

?>
