<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logs extends Base_Controller {

	protected $libs = array('parser_logs');

	public function __construct() 
	{
		parent::__construct();
	}

	public function index()
	{
		
		$this->view_datas['logs'] = $this->parser_logs->find_all();

	}



}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */