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

	public function add_route()
	{


		if ($this->form_validation->run())
		{

			$rewrite = $this->input->post('rewrite');
			$execute = $this->input->post('execute');

			$this->app_config->add_route($rewrite, $execute);
		} 
		else
		{
			$this->session->put('add_route', validation_errors(), 'config');
		}


		redirect('config');

	}

	public function delete_route()
	{

		$rewrite = $this->input->post('pattern');
		
		if ( ! in_array($rewrite, $this->config->item('reserved_routes')))
		{
			$deleted = $this->app_config->delete_route($rewrite);
			$this->session->put('delete_route', $deleted, 'config');
		}
		else
		{
			$this->session->put('delete_reserved_route', 'You can\'t delete this route', 'config');
		}

		redirect('config');
	}

	public function add_routeRules()
	{
		$this->rules('rewrite', 'rewrite', 'required');
		$this->rules('execute', 'execute', 'required');
	}

}

/* End of file config.php */
/* Location: ./application/controllers/config.php */