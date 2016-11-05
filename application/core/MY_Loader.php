<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader {

	function __construct(){
		parent::__construct();
	}

	public function get_vars(){
		return $this->_ci_cached_vars;
	}

}

/* End of file MY_Loader.php */
/* Location: ./application/controllers/MY_Loader.php */