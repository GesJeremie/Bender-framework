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
		// Check form
		if ($this->form_validation->run())
		{

			// Get name model and add treatment
			$name_model = $this->input->post('name_model');
			$name_model = strtolower($name_model);
			$name_model = str_replace('_model', '', $name_model);
			$name_model = ucfirst($name_model);

			// Datas to inject
			$skeleton_datas = array(

				'name_model' => $name_model,
				'comment' => 'Enjoy !'

				);

			// Built template with skeleton
			$built = $this->skeleton->run('model', $skeleton_datas, APP_APPPATH . 'models/' . $name_model . '_model.php');

			// No problem ?
			if ($built)
			{
				$this->session->put('create_model_built_success', 'Model created', 'skeleton');
			} 
			else
			{
				// Error !
				$this->session->put('create_model_built_error', 'Unable to create the model', 'skeleton');
			}

		}
		else
		{
			// Error with form validation
			$this->session->put('create_model_error', validation_errors(), 'skeleton');
		}

		// Redirect to skeleton page
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
			// Base path controllers
			$path_controllers = APP_APPPATH . 'controllers/';

			// Get name controller and format
			$name_controller = $this->input->post('name_controller');
			$name_controller = strtolower($name_controller);

			// Init subfolder (maybe name_controller have subfolder in the string)
			$subfolder = '';

			// Check if isset subfolder into the controller's name
			$pos_slash = strpos($name_controller, '/');

			// Subfolder exists
			if ($pos_slash !== FALSE)
			{
				// We found a subfolder into the name
				
				// Fill subfolder
				$subfolder = substr($name_controller, 0, $pos_slash+1);

				// Re-fill name controller
				$name_controller = substr($name_controller, $pos_slash+1);

			}
		
			// Inject skeleton datas
			$skeleton_datas = array(

				'ucfirst_name_controller' => ucfirst($name_controller),
				'name_controller' => $name_controller,
				'subfolder' => $subfolder,
				'comment' => 'Enjoy !'

				);

			// Check if subfolder exists
			if ( ! isset($subfolder))
			{
				// Where we will generate the file created
				$path_output = $path_controllers . $name_controller . '.php';
			} 
			else
			{
				// Maybe subfolder doesn't exist, so we must create the dir
				if ( ! is_dir($path_controllers . $subfolder)) 
				{
					// Create the dir
					mkdir($path_controllers . $subfolder);
				}

				$path_output = $path_controllers . $subfolder . $name_controller . '.php';
			}

			if ( ! file_exists($path_output)) {

				// Built with skeleton lib
				$built = $this->skeleton->run('controller', $skeleton_datas, $path_output);

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
				$this->session->put('create_controller_error', 'File already exists, crafter stopped the process', 'skeleton');
			}

		}
		else
		{
			$this->session->put('create_controller_error', validation_errors(), 'skeleton');
		}

		redirect('skeleton');

	}	

	public function check_name_controller($str)
	{
		// Count chars in string
		$count = strlen($str);

		// Allowed chars 
		$allowed_chars = array('/', '-', '_');

		// We want only one "/" char in the string
		// so we init this var to know where we are.
		$slash_found = FALSE;

		// Loop all chars into the string
		for ($i=0; $i < $count; $i++)
		{
			// If it's not a string or not in allowed chars
			// it's not a correct format
			if ( ! ctype_alpha($str[$i]) && ! in_array($str[$i], $allowed_chars))
			{
				$this->form_validation->set_message('check_name_controller', 'Le champ %s n\'accepte pas le caractère : ' . $str[$i]);
				return FALSE;
			}

			// We found "/" char dude
			elseif ($str[$i] === '/')
			{
				// If already found we have 2 "/" in the string,
				// it's an incorrect format
				if ($slash_found === TRUE)
				{
					$this->form_validation->set_message('check_name_controller', 'Le champ %s n\'accepte qu\'un sous-répertoire');
					return FALSE;
				}
				else
				{
					// It's the first time where we have a "/"
					// Fill slash_found
					$slash_found = TRUE;
				}
			}

		}

		// Valid format for the string
		return TRUE;
	}


	protected function create_skeleton_controllerRules()
	{
		$this->rules('name_controller', 'name controller', 'required|callback_check_name_controller');
	}
	
}

/* End of file skeleton.php */
/* Location: ./application/controllers/skeleton.php */