<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logs extends Base_Controller {

	protected $libs = array('parser_logs', 'humanize_logs', 'session', 'pagination');

	public function __construct() 
	{
		parent::__construct();
	}

	public function index($offset=0)
	{		
		// Get datas
		$logs = $this->parser_logs->find_all();
		$dates = $this->parser_logs->find_dates();

		// Humanize 
		$logs = $this->humanize_logs->run($logs, 'logs');
		$dates = $this->humanize_logs->run($dates, 'dates');

		// Order by "fresh"
		$logs_sliced = array_reverse($logs);

		// Slice for pagination system
		$logs_sliced = array_slice($logs, $offset, 30);

		// Initialize pagination system
		// We add base configuration from config/app.php
		// to use boostrap pagination design system
		$config = array_merge(

			$this->config->item('pagination_design_bootstrap'),

			array(

			'base_url' => site_url('logs/index'),
			'total_rows' => count($logs),
			'per_page' => 30,

			)
		);

		$this->pagination->initialize($config);


		// Inject in view
		$this->view_datas = array(

			'logs' => $logs_sliced,
			'dates' => $dates

			);

	}

	public function dates($date, $offset=0)
	{		
		// Get datas
		$logs = $this->parser_logs->find_by_date($date);
		$dates = $this->parser_logs->find_dates();

		// Humanize 
		$logs = $this->humanize_logs->run($logs, 'logs');
		$dates = $this->humanize_logs->run($dates, 'dates');
		$header_date = $this->humanize_logs->run($date, 'header_date');
		
		$logs = array_reverse($logs);

		// Slice for pagination system
		$logs_sliced = array_slice($logs, $offset, 30);

		// Initialize pagination system
		// We add base configuration from config/app.php
		// to use boostrap pagination design system
		$config = array_merge(

			$this->config->item('pagination_design_bootstrap'),

			array(

			'base_url' => site_url('logs/dates/' . $date),
			'total_rows' => count($logs),
			'per_page' => 30,
			'uri_segment' => 4

			)
		);

		$this->pagination->initialize($config);


		// Inject in view
		$this->view_datas = array(

			'path_log' => $this->parser_logs->logs_folder(),
			'get_date' => $date,
			'header_date' => $header_date,
			'logs' => $logs_sliced,
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