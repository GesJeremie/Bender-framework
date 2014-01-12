<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Skeleton extends Base_Controller {

	protected $libs = array('skeleton_lib as skeleton');

	public function __construct() 
	{
		parent::__construct();
	}

	public function index()
	{

	}

	public function create_skeleton_model()
	{
		if ($this->form_validation->run())
		{

			$name_model = $this->input->post('name_model');
			$name_model = strtolower($name_model);
			$name_model = str_replace('_model', '', $name_model);
			$name_model = ucfirst($name_model);

			$path = APPPATH . 'views/_skeletons/model.php';

			$skeleton_datas = array(

				'name_model' => $name_model,
				'comment' => 'Enjoy !'

				);

			$built = $this->skeleton->run('model', $skeleton_datas, APP_APPPATH . 'models/' . $name_model . '_model.php');

			if ($built)
			{
				$this->session->put('create_model_built_success', 'Model created', 'skeleton');
			} 
			else
			{
				$this->session->put('create_model_built_error', 'Unable to create the model', 'skeleton');
			}

		}
		else
		{
			$this->session->put('create_model_error', validation_errors(), 'skeleton');
		}

		redirect('skeleton');

	}	

	protected function create_skeleton_modelRules()
	{
		$this->rules('name_model', 'name model', 'required|alpha_dash');
	}
	

	public function create_skeleton_controller()
	{
		if ($this->form_validation->run())
		{

			$name_controller = $this->input->post('name_controller');
			$name_controller = strtolower($name_controller);
			$name_controller = ucfirst($name_controller);

			$path = APPPATH . 'views/_skeletons/controller.php';

			$skeleton_datas = array(

				'name_controller' => $name_controller,
				'comment' => 'Enjoy !'

				);

			$built = $this->skeleton->run('controller', $skeleton_datas, APP_APPPATH . 'controllers/' . $name_controller . '.php');

			if ($built)
			{
				$this->session->put('create_controller_built_success', 'Controller created', 'skeleton');
			} 
			else
			{
				$this->session->put('create_controller_built_error', 'Unable to create the controller', 'skeleton');
			}

		}
		else
		{
			$this->session->put('create_controller_error', validation_errors(), 'skeleton');
		}

		redirect('skeleton');

	}	

	protected function create_skeleton_controllerRules()
	{
		$this->rules('name_controller', 'name controller', 'required|alpha_dash');
	}
	
}

/* End of file skeleton.php */
/* Location: ./application/controllers/skeleton.php */