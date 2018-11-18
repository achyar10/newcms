<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Merchant extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('merchant/Merchant_model');
		$this->load->helper('string');
	}

	public function index_get(){
		$res = array('message' => 'Nothing here');

		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($res));
	}

	function get_merchant_get(){
		try{
			$get_merchant = $this->Merchant_model->get();

			if (!empty($get_merchant)){
				$this->response(REST_Controller::Success_($get_merchant));
			}else{
				throw new Exception("Merchant is empty");
			}
		}catch(Exception $e){
			$this->response(REST_Controller::Exception_($e));
		}
	}

	function edit_post(){
		$merchant_code 	= $this->post('merchant_code');
		$merchant_name		= $this->post('merchant_name');
		$merchant_address	= $this->post('merchant_address');
		$merchant_phone	= $this->post('merchant_phone');

		try{
			if(empty($merchant_code)){
				throw new Exception("Merchant code cannot be empty");
			}

			$merchant = $this->merchant->get(array('merchant_code' => $merchant_code))->row();

			if(count($merchant) == 0){
				throw new Exception("Merchant not found");
			}

			$update_data = array(
				'merchant_name' => $merchant_name,
				'address'    	 => $merchant_address,
				'phone'  		 => $merchant_phone
			);

			$update = $this->merchant->update($update_data,array('merchant_code' => $merchant_code));

			if($update){
				$this->response(REST_Controller::Success_('OK'));
			}else{
				throw new Exception("Error Processing Request");
			}
		}catch(Exception $e){
			$this->response(REST_Controller::Exception_($e));
		}
	}

}

/* End of file merchant.php */
/* Location: ./application/controllers/merchant.php */