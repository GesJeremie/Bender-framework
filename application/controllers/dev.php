<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dev extends Base_Controller {

	protected $helpers = array('url');

	public function index()
	{
		$this->load->view('dev');

		echo 'ok ?';
	}

	public function indexAction() {

		// Executed if POST request
		echo 'lol';

		var_dump($this->input->post());

	}

	protected function indexRules() {
		


	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */