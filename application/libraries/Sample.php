<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sample {

	private $CI;

	public function __construct() {

		$this->CI =& get_instance();

	}

	public function sample_method() {

		// Load helper
		$this->CI->load->helper('string');

		// Now you can do this
		$string = "Joe's \"dinner\"";
		$string = strip_quotes($string); // results in "Joes dinner"

	}

}

/* End of file Sample.php */
/* Location: ./system/libraries/Sample.php */