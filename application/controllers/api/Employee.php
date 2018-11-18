<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('employee/Employee_model');
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

	function get_employee_get(){
		try{
			$get_employee = $this->Employee_model->get();

			if (!empty($get_employee)){
				$this->response(REST_Controller::Success_($get_employee));
			}else{
				throw new Exception("Employees is empty");
			}
		}catch(Exception $e){
			$this->response(REST_Controller::Exception_($e));
		}
	}

}

/* End of file Employee.php */
/* Location: ./application/controllers/Employee.php */