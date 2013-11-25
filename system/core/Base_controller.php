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

	/**
	 * Base sanitize rules for auto datas validation
	 *
	 * @var string
	 */
	protected $sanitize_rules = 'xss_clean|encode_php_tags|prep_for_form';

	/**
	 * Activate autoload view system ?
	 *
	 * @var bool
	 */
	protected $autoload_view = TRUE;

	/**
	 * All view datas
	 *
	 * @var array
	 */
	protected $view_datas = array();

	/**
	 * Asides to load
	 *
	 * @var mixed (FALSE/array)
	 */
	protected $asides = FALSE;

	/**
	 * Layout to load, if empty we will guess the right layout to load
	 *
	 * @var string
	 */
	protected $layout = '';

	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();

		// Autoload helpers/models/libraries
		$this->_loader();

	}

	// ------------------------------------------------------------------------

	public function _remap($method, $params) 
	{


		if (method_exists($this, $method))
		{

			// Autoload form validation rules
			$this->_load_rules($method);

			// Call the current method
			call_user_func_array(array($this, $method), $params);

			// Load view 
			$this->_autoload_view($method, $params);

		}
		else 
		{
			// Check if method "_404()" added by the developer
			if (method_exists($this, '_404'))
			{
				call_user_func(array($this, '_404'));
			} 
			else 
			{
				show_404(strtolower(get_class($this)) . '/' . $method);
			}
		}

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
	private function _loader() 
	{

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
			foreach ($this->models as $model) 
			{

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

	/**
	 * Load rules
	 * 
	 * Detect if set of rules exists for this method
	 * If exists, we execute the function
	 *
	 * @access	private
	 * @param 	string 	Method
	 * @return	void
	 */
	private function _load_rules($method)
	{
		$method_rules = $method . 'Rules';

		// If set of rules added, execute
		if (method_exists($this, $method_rules))
		{
			call_user_func(array($this, $method_rules));
		}

	}

	// ------------------------------------------------------------------------

	/**
	 * Rules
	 * 
	 * Shortcut for $this->form_validation->set_rules() and implement 
	 * autosanitize system
	 *
	 * @access	private
	 * @param 	string 	The name of input to check
	 * @param 	string 	Message to return if error
	 * @param 	string 	Rules to attach
	 * @param 	bool 	Do you want use the autosanitize system ?
	 * @return	void
	 */
	public function rules($input_name, $msg, $rules='', $autosanitize = TRUE)
	{
		// Form validation loaded ?
		$loaded = $this->load->is_loaded('form_validation');

		if ($loaded !== FALSE)
		{

			// Auto sanitize
			if ($autosanitize === TRUE)
			{ 

				// Avoid null and others
				$sanitize_rules = (string) $this->sanitize_rules;

				// Sanitize rules exists
				if ( ! empty($sanitize_rules)) 
				{
					$rules = trim($rules, '|') . '|' . trim($this->sanitize_rules, '|');
				}
			}

			// Enqueue rules
			$this->$loaded->set_rules($input_name, $msg, $rules);
		}

	}

	// ------------------------------------------------------------------------

	/**
	 * System to autoload view
	 *
	 * @access	private
	 * @return	bool
	 * 
	 */
	private function _autoload_view($method, $params) {

		// Do you want autoload view ?
		if ($this->autoload_view === FALSE) 
		{
			return FALSE;
		}

		// Guess load to view
		$load_view = $this->router->directory . $this->router->class . '/' . $this->router->method;

		// Check if view exists
		if ( ! file_exists(APPPATH . 'views/' . $load_view . '.php'))
		{
			return FALSE;
		}

		// Load view into $yield and inject global view datas
		$view_datas['yield'] = $this->load->view($load_view, $this->view_datas, TRUE);

		// Do we have any asides ? Load them
		if ($this->asides !== FALSE && ! empty($this->asides))
		{

			foreach ($this->asides as $name => $file)
			{

				// Add yield_ data
				$view_datas['yield_' . $name] = $this->load->view($file, $this->view_datas, TRUE);

			}

		}

		// Merge view datas
		$view_datas = array_merge($this->view_datas, $view_datas);

		// Check if autoload layout
		if ($this->layout !== FALSE)
		{

			// No layout specify ? Ok we will try to guess it
			if (empty($this->layout)) 
			{
				$this->layout = $this->router->class;
			}

			// Check if layout exists
			if (file_exists(APPPATH . 'views/_layouts/' . $this->layout . '.php'))
			{
				// Load view
				$this->load->view('_layouts/' . $this->layout, $view_datas);

				return TRUE;
			}

			// Ok layout doesn't exists, try to load default layout
			if (file_exists(APPPATH . 'views/_layouts/default.php'))
			{
				// Load view
				$this->load->view('_layouts/default', $view_datas);

				return TRUE;
			}

		} 
		
		// No layout to load, so output view directly
		$this->output->set_output($view_datas['yield']);

		return TRUE;
		

	}
}

?>