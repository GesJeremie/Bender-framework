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
 * Bender Application Base Controller Class
 *
 * This class extends CI_Controller to add some helpful methods
 *
 * @package		Bender Framework
 * @subpackage	Core
 * @category	Controllers
 * @author		Ges Jeremie
 */
class Base_controller extends CI_Controller {

	/**
	 * List of all helpers to load
	 *
	 * @var array
	 */
	protected $helpers = array();

	/**
	 * List of all models to load
	 *
	 * @var array
	 */
	protected $models = array();

	/**
	 * List of all libs to load
	 *
	 * @var array
	 */
	protected $libs = array();

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();

		// Autoload helpers/models/libraries
		$this->_loader();

	}

	// ------------------------------------------------------------------------

	/**
	 * Loader
	 * 
	 * System to load helpers/models/libraries called by _construct()
	 *
	 * @access	private
	 * @return	void
	 */
	private function _loader() {

		// Helpers to load ?
		if ( ! empty($this->helpers)) 
		{
			foreach ($this->helpers as $helper) 
			{
				// Drop "_helper" if added
				$clear_helper = str_replace('_helper', '', $helper);
				$helper = $clear_helper . '_helper';

				// Load the helper
				$this->load->helper($helper);
			}
		}

		// Models to load ?
		if ( ! empty($this->models)) 
		{
			foreach ($this->models as $model) {

				// Drop "_model" if added
				$clear_model = str_replace('_model', '', $model);
				$model = $clear_model . '_model';

				// Load the model
				$this->load->model($model, $clear_model);

			}
		}

		// Libs to load
		if ( ! empty($this->libs)) 
		{
			foreach ($this->libs as $lib) 
			{
				if ($lib == 'dbutil') 
				{
					$this->load->dbutil();
				} 
				elseif ($lib == 'dbforge')
				{
					$this->load->dbforge();
				}
				else 
				{
					$base_name = $lib;

					// The developper wants new name for this library ?
					if (strpos(strtolower($lib), ' as ')) 
					{
						// Security if developer put AS than as
						$lib = str_replace(' AS ', ' as ', $lib);
						$name = explode(' as ', $lib);
						$base_name = $name[1];
						$lib = $name[0];

					}

					// Load library
					$this->load->library($lib, array(), $base_name);

				}
			}
		}
	}

	// ------------------------------------------------------------------------

}

?>