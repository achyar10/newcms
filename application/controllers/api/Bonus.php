<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bonus extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('api/M_topup_bonus', 'bonus');
	}

	public function index_get(){
		$payment_method_id = $this->get('payment_method_id');
	
		try{
			if(empty($payment_method_id)){
				throw new Exception("Please select payment method");
			}

			$now = date('Y-m-d H:i:s');

			$bonus = $this->bonus->get(array(
			'start_date <=' 	=> $now,
			'end_date >='		=> $now,
			'payment_method_id'	=> $payment_method_id))->result_array();

			if(count($bonus) == 0){
				throw new Exception("No data found");
			}

			$this->response(REST_Controller::Success_($bonus));
		}catch(Exception $e){
			$this->response(REST_Controller::Exception_($e));
		}
	}

}

/* End of file bonus.php */
/* Location: ./application/controllers/bonus.php */