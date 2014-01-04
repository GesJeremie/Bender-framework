<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends Base_Controller {

	public function index()
	{
		// Base controller will autoload :
		//
		// layout : views/_layouts/welcome.php
		// view : views/welcome/index.php (injected into $yield of the layout)
		//
		// Nothing to do ... auto-magic !
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */