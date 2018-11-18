<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Session extends CI_Session {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('users/Users_model');
	}

	function sess_destroy() {
		$this->Users_model->add(array('user_id'=>$this->session->userdata('uid'), 'user_is_login'=>0));

		parent::sess_destroy();
	}

}

/* End of file MY_Session.php */
/* Location: ./application/core/MY_Session.php */