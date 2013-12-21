<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logs extends Base_Controller {

	protected $libs = array('parser_logs', 'humanize_logs');

	public function __construct() 
	{
		parent::__construct();
	}

	public function index()
	{
		// Get datas
		$logs = $this->parser_logs->find_all();
		$dates = $this->parser_logs->find_dates();

		// Humanize 
		$logs = $this->humanize_logs->run($logs, 'logs');
		$dates = $this->humanize_logs->run($dates, 'dates');

		// Inject in view
		$this->view_datas['logs'] = $logs;
		$this->view_datas['dates'] = $dates;
	}

	public function dates($date)
	{		
		// Get datas
		$logs = $this->parser_logs->find_by_date($date);
		$dates = $this->parser_logs->find_dates();

		// Humanize 
		$logs = $this->humanize_logs->run($logs, 'logs');
		$dates = $this->humanize_logs->run($dates, 'dates');
		$header_date = $this->humanize_logs->run($date, 'header_date');
		
		// Inject in view
		$this->view_datas['header_date'] = $header_date;
		$this->view_datas['logs'] = $logs;
		$this->view_datas['dates'] = $dates;


	}



}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */