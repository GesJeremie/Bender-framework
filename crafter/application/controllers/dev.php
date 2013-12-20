<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dev extends Base_Controller {

	public function test()
	{
		$this->view_datas['yoplait'] = 'lol';
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */