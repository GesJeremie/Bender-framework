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
 * Assets class
 *
 * Manager of assets
 * 
 * @package		Bender Framework
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Ges Jeremie
 */
class CI_Assets {

	/**
	 * Stock $assets from config.php with all css/js added by register's method
	 *
	 * @var array
	 */
	private $_assets = array();

	/**
	 * The file path of css/js tracker
	 * Fill by construct() method
	 *
	 * @var string
	 */
	private $_track_filepath = '';

	// ------------------------------------------------------------------------

	/**
	 * Constructor
	 * 
	 * Load dependencies and initialize class
	 *
	 */
	public function __construct()
	{
		// Get instance of CI
		$CI =& get_instance();

		// Dependencies
		$CI->load->helper('url');
		$CI->load->helper('html');

		// Get config assets.php
		$this->_initialize();
	}

	// ------------------------------------------------------------------------

	/**
	 * Initialize
	 * 
	 * Catch config/assets.php file and fill track_filepath
	 *
	 * @access	private
	 * @return	void
	 */
	private function _initialize() 
	{
		$file_path = APPPATH . 'config/assets.php';

		// Fetch config file
		if ( ! file_exists($file_path))
		{
			exit('Assets : The configuration file does not exist.');
		}

		require($file_path);

		// Security
		if ( ! isset($assets['compress'])) 
		{
			exit('Assets : $assets[\'compress\'] does not exist.');
		}

		// Another security about compress
		foreach (array('development', 'testing', 'production') as $value) 
		{
			if ( ! is_bool($assets['compress'][$value]))
			{
				exit('Assets : $assets[\'compress\'][\'' . $value . '\'] must be a boolean');
			}

		}

		// All fields filled ?
		foreach (array('css', 'js') as $type)
		{
			if (isset($assets[$type])) 
			{
				$this->_check_elements_config($type, $assets);
			}
		}

		// Stock in var class
		$this->_assets = $assets;

		// Clean $assets to avoid conflict (it's little useless but i'm paranoid)
		unset($assets);

		// Give the file where we track files
		$this->_track_filepath = APPPATH . 'cache/assets-track.json';
	}

	/**
	 * Check elements config
	 * 
	 * Check if assets/config.php is valid
	 *
	 * @access	private
	 * @return	void
	 */
	private function _check_elements_config($type, $assets)
	{
		foreach ($assets[$type] as $elements) 
		{
			// Check if all attributes are valid
			foreach (array('name', 'version', 'src', 'compress') as $attribute) 
			{
				if ( ! isset($elements[$attribute]))
				{
					exit('Assets : Invalid ' . $type . ' config, forget attribute : ' . $attribute);
				}

			}


			// Check now if compress is boolean type
			if ( ! is_bool($elements['compress'])) 
			{
				exit('Assets : Invalid ' . $type . ' config, attribute compress must be boolean type');
			}
		}
	}



	// ------------------------------------------------------------------------

	/**
	 * Register Css
	 * 
	 * Method to register new css
	 *
	 * @access	public
	 * @param 	string 	The name of your stylesheet
	 * @param 	mixed (string/int) 	Version of your stylesheet
	 * @param   string 	Location path of your stylesheet (Auto base path of your assets folder added)
	 * @param   bool 	Do you want compress your file ?
	 * @return	void
	 */
	public function register_css($name, $version, $src, $compress = FALSE) 
	{	
		$this->_register('css', $name, $version, $src, $compress);
	}

	/**
	 * Register Js
	 * 
	 * Method to register new js
	 *
	 * @access	public
	 * @param 	string 	The name of your script
	 * @param 	mixed (string/int) 	Version of your script
	 * @param   string 	Location path of your script (Auto base path of your assets folder added)
	 * @param   bool 	Do you want compress your file ?
	 * @return	void
	 */
	public function register_js($name, $version, $src, $compress = FALSE)
	{
		$this->_register('js', $name, $version, $src, $compress);
	}

	/**
	 * Register
	 * 
	 * Generic method to reduce the code and register new asset
	 *
	 * @access	private
	 * @return	void
	 */
	private function _register($type, $name, $version, $src, $compress)
	{

		// Avoid string, etc ..
		if ( ! is_bool($compress)) 
		{
			$compress = FALSE;
		}

		// Chek if you must replace config values
		if (isset($this->_assets[$type])) 
		{
			foreach ($this->_assets[$type] as $position => $value) {

				if ($value['name'] == $name && $value['version'] == $version) 
				{
					// Replace values
					$this->_assets[$type][$position]['src'] = $src;
					$this->_assets[$type][$position]['compress'] = $compress;

					// Stop exec
					return;
				}

			}
		}

		// Add in assets
		$this->_assets[$type][] = array(

			'name'  => $name,
			'version' => $version,
			'src'     => $src,
			'compress' => $compress

			);
	}

	// ------------------------------------------------------------------------

	/**
	 * Render Js
	 * 
	 * Display the final src javascript by the name
	 *
	 * @access	public
	 * @param 	string 	What's the name of your script ?
	 * @param  	bool 	Do you want the include tag ?
	 * @param 	mixed (string/int) 	What's the version to render ?
	 * @return	mixed (string/bool) The link or FALSE if no js to load
	 */
	public function render_js($name, $html_output = TRUE, $version='')
	{
		$return = $this->_render('js', $name, $html_output, $version);
		return $return;
	}

	/**
	 * Render Css
	 * 
	 * Display the final src stylesheet by the name
	 *
	 * @access	public
	 * @param 	string 	What's the name of your stylesheet ?
	 * @param  	bool 	Do you want the link tag ?
	 * @param 	mixed (string/int) 	What's the version to render ?
	 * @return	mixed (string/bool) The link or FALSE if no stylesheet to load
	 */
	public function render_css($name, $html_output = TRUE, $version='') 
	{
		$return = $this->_render('css', $name, $html_output, $version);
		return $return;
	}

	/**
	 * Render
	 * 
	 * Generic method to reduce the code.
	 *
	 * @access	private
	 * @return	mixed
	 */
	private function _render($type, $name, $html_output, $version) 
	{
		if (isset($this->_assets[$type]))
		{
			foreach ($this->_assets[$type] as $value) 
			{
				if ($value['name'] == $name && ($version === '' OR $value['version'] == $version) )
				{

					// Go compress method : check if you must compress
					// create "cache", etc.
					$src = $this->_compress($value, $type);

					// Create init output
					$output = assets_url($src);

					if ($html_output === TRUE) 
					{
						if ($type == 'css')
						{
							// Create link tag <link href ... > 
							$output = link_tag($output);
						}
						else 
						{
							// Create script tag 
							// In another version, i will add script_tag() method 
							// into the html helper
							$output = '<script src="' . $output . '"></script>';
						}

					}

					return $output;
				} 
			}
		}

		// No css to load, good bye !
		return FALSE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Compress Css
	 * 
	 * Minify css code
	 *
	 * @access	public
	 * @param 	string 	Content to compress
	 * @return	string
	 */
	public function compress_css($contents) {
		
		// Inspired by Manas tungare
		// Source : http://manas.tungare.name/software/css-compression-in-php

		// Remove comments
		$contents = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $contents);

		// Remove space after colons
		$contents = str_replace(': ', ':', $contents);

		// Remove whitespace
		$contents = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $contents);

		return $contents;

	}

	/**
	 * Compress Js
	 * 
	 * Minify js code
	 *
	 * @access	public
	 * @param 	string 	Content to compress
	 * @return	string
	 */
	public function compress_js($contents)
	{
        // Remove comments
        $contents = preg_replace("/((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:\/\/.*))/", "", $contents);

        // Remove tabs, spaces, newlines, etc. 
        $contents = str_replace(array("\r\n","\r","\t","\n",'  ','    ','     '), '', $contents);

        // remove other spaces before/after )
        $contents = preg_replace(array('(( )+\))','(\)( )+)'), ')', $contents);

		return $contents;
	}

	// ------------------------------------------------------------------------

	/**
	 * Flush
	 * 
	 * Delete all files generated by the assets class
	 *
	 * @access	public
	 * @return	bool
	 */
	public function flush() 
	{
		// Shortcut to beautify the code
		$track_filepath = $this->_track_filepath;

		if (file_exists($track_filepath))
		{
			// Get content
			$contents = file_get_contents($track_filepath);
			$contents = json_decode($contents, TRUE);

			// Loop file and delete
			foreach ($contents as $position => $file)
			{
				if (file_exists($file))
				{
					unlink($file);
				}

				// Delete line track
				unset($contents[$position]);
			}

			// Re index values
			$contents = array_values($contents);
			$contents = json_encode($contents);

			file_put_contents($track_filepath, $contents);

		}

		return TRUE;
	}

	// ------------------------------------------------------------------------

	/**
	 * Open track file
	 * 
	 * Just method to open properly the track file
	 *
	 * @access	private
	 * @return	string
	 */
	private function _open_track_file()
	{

		// File where we track files path
		$track_filepath = $this->_track_filepath;

		// Check if track file already exist
		if ( ! file_exists($track_filepath))
		{
			$files = array();
			$files = json_encode($files);

			// Create file
			file_put_contents($track_filepath, $files);
		}

		// Get contents
		$contents = file_get_contents($track_filepath);

		return $contents;
	}

	/**
	 * Track File
	 * 
	 * Add new file path to track
	 *
	 * @access	private
	 * @param 	string 	File path to track
	 * @return	void
	 */
	private function _track_file($filepath) 
	{

		$contents = $this->_open_track_file();

		// Decode with array way
		$contents = json_decode($contents, TRUE);

		// Check if file already tracked 
		if ( ! in_array($filepath, $contents))
		{
			$contents[] = $filepath;
		}

		// Re-encode
		$contents = json_encode($contents);

		file_put_contents($this->_track_filepath, $contents);

	}

	/**
	 * Stop track file
	 * 
	 * Stop track of file path
	 *
	 * @access	public
	 * @param 	string 	The file path to stop track
	 * @return	void
	 */
	private function _stop_track_file($filepath)
	{

		$contents = $this->_open_track_file();

		// Decode with array way
		$contents = json_decode($contents, TRUE);

		// Loop and delete file
		foreach ($contents as $position => $file)
		{
			if ($file == $filepath)
			{
				unset($contents[$position]);
			}
		}

		// Reset index 
		$contents = array_values($contents);

		// Re-encode 
		$contents = json_encode($contents);

		file_put_contents($this->_track_filepath, $contents);


	}

	// ------------------------------------------------------------------------

	/**
	 * Compress 
	 * 
	 * Check if you must compress and create compressed files
	 *
	 * @access	public
	 * @param 	array 	Config datas
	 * @param 	string 	The type of asset (js/css)
	 * @return	string
	 */
	private function _compress($datas, $type)
	{	

		// Check environment Compress
		if ($this->_assets['compress'][ENVIRONMENT] === TRUE && $datas['compress'] === TRUE)
		{
			// Open file 
			$filepath = FCPATH . 'assets/' . ltrim($datas['src'], '/');

			if ( ! file_exists($filepath))
			{
				// Little error to track
				log_message('error', 'Assets : Unable to compress, file path does not exist : ' . $filepath);

				return $datas['src'];
			}
			else 
			{

				// Get the content
				$contents = file_get_contents($filepath);

				// Get infos 
				$infos = pathinfo($filepath);

				// Create flag
				$flag = md5($contents);

				// Create new datas
				$new_filename = $infos['filename'] . '-' . $flag . '.min.' . $type;
				$new_filepath = $infos['dirname'] . '/' . $new_filename;

				// Check if this file at this time never compressed
				if ( ! file_exists($new_filepath))
				{

					$method = 'compress_' . $type;
					$contents = $this->$method($contents);

					file_put_contents($new_filepath, $contents);

					// Keep history for flush() method
					$this->_track_file($new_filepath);

				} 

				// Clear old useless file compressed
				$files = glob($infos['dirname'] . '/' . $infos['filename'] . '-*.min.' . $type);

				foreach ($files as $file)
				{
					if ($file != $new_filepath)
					{
						unlink($file);

						// Delete file tracked
						$this->_stop_track_file($file);
					}
				}
				

				// Convert new filepath to use with an url
				$output = str_replace(FCPATH . 'assets', '', $new_filepath);

				return $output;

			}

		}

		return $datas['src'];

	}
}

/* End of file Assets.php */
/* Location: ./system/libraries/Assets.php */