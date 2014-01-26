<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config extends Base_Controller {

	protected $libs = array('app_config', 'form_validation');

	public function __construct() 
	{
		parent::__construct();

	}

	public function index()
	{
		
		$environment = $this->app_config->environment();
		$routes = $this->app_config->get_routes();

		$this->view_datas['routes'] = $routes;
		$this->view_datas['environment'] = $environment;

	}

	public function environment($new_environment)
	{
		$this->app_config->environment($new_environment);

		redirect('config');
	}

}

/* End of file config.php */
/* Location: ./application/controllers/config.php */