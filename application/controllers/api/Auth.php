<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('users/Users_model');
		$this->load->helper('string');
	}

	function login_post(){

		$email = $this->post('email');
		$password = sha1($this->post('password'));
	
		try{
			if(empty($email)){
				throw new Exception("Email cannot be empty");
			}

			if(empty($password)){
				throw new Exception("Password cannot be empty");
			}

			$user = $this->Users_model->user_login($email, $password);

			if(count($user) == 0){
				throw new Exception("Email or Password Wrong");
			}

			$this->response(REST_Controller::Success_($user));
			
		}catch(Exception $e){
			 $this->response(REST_Controller::Exception_($e));
		}
	}

	function user_get(){
		try{
			$get_user = $this->Users_model->get();

			if (!empty($get_user)){
				$this->response(REST_Controller::Success_($get_user));
			}else{
				throw new Exception("Users is empty");
			}
		}catch(Exception $e){
			$this->response(REST_Controller::Exception_($e));
		}
	}

}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */