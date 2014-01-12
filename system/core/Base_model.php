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
 * Bender Application Base Model Class
 *
 * This class extends CI_Model to add some helpful methods
 *
 * @package		Bender Framework
 * @subpackage	Core
 * @category	Models
 * @author		Ges Jeremie
 */
class Base_model extends CI_Model {

	/**
	 * Name of the current model used
	 * Filled by constructor method
	 *
	 * @var string
	 */
	private $_name_model;

	/**
	 * Do you want use auto timestamp system ?
	 * The system will add created_at and/or updated_at
	 * field data when you perform request like save() or update()
	 *
	 * @var string
	 */
	private $_auto_timestamp = TRUE;

	/**
	 * Do you want add suffix for your datas when you 
	 * perform request like save() or update()
	 *
	 * @var string
	 */
	protected $_suffix_label;

	/**
	 * Table where will perform all requests
	 * If empty, we will guess the table for you
	 *
	 * @var string
	 */
	protected $_table = '';

	/**
	 * The primary key used
	 * If empty, "id" will choose by default
	 *
	 * @var string
	 */
	protected $_primary_key = '';

	/**
	 * Find() method return datas with array or object type, as you want
	 * If empty, "array" type will choose by default
	 *
	 * @var string
	 */
	protected $_return_type = '';

	/**
	 * A simple config array to reduce the code below
	 *
	 * @var string
	 */
	private $_return_methods = array(

		'result' => array('object' => 'result',  'array' => 'result_array'),
		'first'  => array('object' => 'object',  'array' => 'array'),
		'last'   => array('object' => 'object',  'array' => 'array')

		);

	// --------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();

		$this->_fetch_table();

		$this->_fetch_return_type();

		$this->_fetch_suffix_label();

		$this->_fetch_primary_key();

		// Used by save() and update() methods
		$this->load->helper('date');

	}

	// --------------------------------------------------------------------
	/**
	 * Finder
	 *
	 * System to find some datas, you can use like :
	 * 
	 * ->find('first') 	Will find the first row data
	 * ->find('all') 	Will find all datas
	 * ->find(5) 		Will find for primary key = 5
	 * ->find('last') 	Will find the last row data
	 * 
	 * @access	public
	 * @param 	mixed 	string/int
	 * @return	mixed 	array/object
	 */
	public function find($type)
	{
		if ($type === 'all')
		{
			// Return all datas from the table with the right type
			return $this->db->get($this->_table)->{$this->_return_methods['result'][$this->_return_type]}();
		}

		if (is_int($type))
		{
			// Return datas by primary key (Ex. id = 5)
			return $this->db->get_where($this->_table, array($this->_primary_key => $type))->{$this->_return_methods['result'][$this->_return_type]}();
		}

		if ($type === 'first')
		{
			// Return the first row datas
			return $this->db->get($this->_table)->first_row($this->_return_methods['first'][$this->_return_type]);	
		}

		if ($type === 'last')
		{
			// Return the last row datas
			return $this->db->get($this->_table)->last_row($this->_return_methods['last'][$this->_return_type]);
		}


	}

	// --------------------------------------------------------------------

	/**
	 * Save
	 *
	 * Will save your datas
	 *
	 * @access	private
	 * @param 	mixed 	array/object 	Your datas
	 * @return	int 	Value of primary key saved
	 */
	public function save($datas)
	{
		// Add created_at and updated_at if doesn't exists
		if ($this->_auto_timestamp === TRUE)
		{
			// Like time(), but respect CI system
			$now = now();

			if (is_object($datas))
			{
				// Convert with array way
				$datas = (array) $datas;
			}
	
			if ( ! isset($datas['created_at']))
			{
				$datas['created_at'] = $now;
			}		

			if ( ! isset($datas['updated_at']))
			{
				$datas['updated_at'] = $now;
			}
			



		}

		// Suffix datas if needed
		$datas = $this->_suffix_datas($datas);

		// Insert datas
		$this->db->insert($this->_table, $datas);

		// Return id of inserted datas
		return $this->db->insert_id();
	}

	// --------------------------------------------------------------------

	/**
	 * Where
	 *
	 * 
	 *
	 * @access	public
	 * @return	object
	 */
	public function where($key, $value='')
	{
		// Find by primary key
		if (is_int($key) && empty($value))
		{
			$this->db->where($this->_primary_key, $key);
		}
		// Associative array method
		elseif (is_array($key) && empty($value))
		{
			$key = $this->_suffix_datas($key);

			$this->db->where($key);
		}
		// Key/value
		else
		{
			$this->db->where($this->_suffix_label . $key, $value);
		}

		// Chaining
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Update
	 *
	 * Method to update datas in the database
	 *
	 * @access	public
	 * @param 	mixed 	array/object 	Datas to update
	 * @return	int
	 */
	public function update($datas)
	{

		if ($this->_auto_timestamp === TRUE)
		{
			if (is_object($datas))
			{
				// Convert with array way
				$datas = (array) $datas;
			}

			// Add updated_at if doesn't exists
			if ( ! isset($datas['updated_at']))
			{
				$datas['updated_at'] = now();
			}
		}

		// Suffix datas if needed
		$datas = $this->_suffix_datas($datas);

		// Update datas
		$this->db->update($this->_table, $datas);

		return $this->db->affected_rows();
	}

	// --------------------------------------------------------------------

	/**
	 * Delete
	 *
	 * Delete datas
	 *
	 * @access	public
	 * @return	int
	 */
	public function delete()
	{
		// Delete datas
		$this->db->delete($this->_table);

		return $this->db->affected_rows();

	}

	// --------------------------------------------------------------------

	/**
	 * Suffix datas
	 *
	 * Auto suffix datas 
	 *
	 * @access	private
	 * @param 	mixed 	array/object 	Datas to suffix
	 * @return	mixed 	array/object
	 */
	private function _suffix_datas($datas)
	{
		// Do you want the suffix label system ?
		if ($this->_suffix_label !== FALSE)
		{
			
			$suffixed = array();

			// Loop all datas
			foreach ($datas as $key => $data)
			{
				// Add in suffixed array
				$suffixed[$this->_suffix_label . $key] = $data;
			}
			
			return $suffixed;
	
		}

		return $datas;
	}

	/**
	 * Fetch table
	 *
	 * Check and guess table to use and fill $_table and $_name_model
	 *
	 * @access	private
	 * @return	void
	 */
	private function _fetch_table()
	{
		// No table specified, so we will try guess
		if ($this->_table === FALSE OR empty($_table))
		{
			// Load inflector 
			$this->load->helper('inflector');

			// Get the name model
			$name_model = strtolower( get_class($this) );
			$name_model = str_replace('_model', '', $name_model);

			// Convert with plural way
			$name_table = plural($name_model);

			$this->_table = $name_table;

			$this->_name_model = $name_model;

		}
	}

	/**
	 * Fetch return type
	 *
	 * If return type not specified, we will add default value
	 *
	 * @access	private
	 * @return	void
	 */
	private function _fetch_return_type()
	{	
		// If no return type specified or different of object and array, add by default "array"
		if (empty($this->_return_type) OR ! in_array($this->_return_type, array('object', 'array')))
		{
			$this->_return_type = 'array';
		}	
	}

	/**
	 * Fetch primary key
	 *
	 * If primary key not specified, we will add default value
	 *
	 * @access	private
	 * @return	void
	 */
	private function _fetch_primary_key()
	{
		// If no primary key specified, add by default "id"
		if (empty($this->_primary_key))
		{
			$this->_primary_key = $this->_suffix_label . 'id';
		}
	}

	/**
	 * Fetch suffix label
	 *
	 * Check if the developer wants use the suffix system.
	 * If it's TRUE but empty we will guess suffix_label to use
	 *
	 * @access	private
	 * @return	void
	 */
	private function _fetch_suffix_label()
	{
		// Do you want suffix label system ?
		if ($this->_suffix_label !== FALSE)
		{
			// If empty we will add by convention the name model with underscore
			if (empty($this->_suffix_label))
			{
				$this->_suffix_label = $this->_name_model . '_';
			}
		}
	}

}

?>