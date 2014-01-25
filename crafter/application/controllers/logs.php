<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logs extends Base_Controller {

	protected $libs = array('parser_logs', 'humanize_logs', 'session');

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
		$this->view_datas = array(

			'logs' => $logs,
			'dates' => $dates

			);

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
		$this->view_datas = array(

			'path_log' => $this->parser_logs->logs_folder(),
			'get_date' => $date,
			'header_date' => $header_date,
			'logs' => $logs,
			'dates' => $dates

			);

	}

	public function delete($date)
	{
		// Try to delete file
		$deleted = $this->parser_logs->delete($date);

		// Put session
		$this->session->put('deleted_file', $deleted);

		// Redirect
		redirect('logs/index');
	}




}

/* End of file logs.php */
/* Location: ./application/controllers/logs.php */