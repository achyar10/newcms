<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tes extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		echo phpinfo();
	}

}

/* End of file Tes.php */
/* Location: ./application/controllers/Tes.php */