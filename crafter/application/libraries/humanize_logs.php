<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Humanize_logs extends CI_Humanizer {

	public function __construct()
	{
		parent::__construct();	

		$this->load->helper('date');
		$this->lang->load('logs');

	}

	public function logs($datas)
	{	
		// Css classes

		// Colors for label - Don't remove default index !
		$css_labels = array('default' => '', 'error' => 'label-danger', 'debug' => 'label-default', 'info' => 'label-info');

		// Security
		$label = strtolower($datas['label']);

		// Check if exists, else use default value
		if (isset($css_labels[$label]))
		{
			$css_label = $css_labels[$label];
		}
		else
		{
			$css_label = $css_labels['default'];
		}


		// Add in datas
		$datas['css_label'] = $css_label;
		$datas['date_fr'] = date('d M Y - H:i:s', $datas['date_timestamp']);
		$datas['label'] = $this->lang->line($label);


		return $datas;
	}

	public function dates($dates)
	{
		// Init results
		$results = array();

		foreach ($dates as $key => $date)
		{	
			// Get timestamp
			$timestamp = strtotime($date);
			$results[$key]['date_human'] = date('d M Y', $timestamp);
			$results[$key]['date_raw'] = $date;
		}

		return $results;
	}

	public function header_date($date)
	{
		// Get timestamp 
		$timestamp = strtotime($date);
		$header_date = date('d M Y', $timestamp);

		return $header_date;

	}


}