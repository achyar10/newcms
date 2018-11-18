<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Machine extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('api/M_register_machine_cashier', 'machine');
	}

	function check_post(){
		$machine_code 	= $this->post('machine_code', TRUE); 
		$machine 		= $this->machine->get_machine(array('code' => $machine_code))->row();

		try{
			if(count($machine)  > 0 ){
				$result["status"] = $machine->status;
				$result["imei"]   = ($machine->imei == '' ? '0' : $machine->imei);	
				$this->response(REST_Controller::Success_($result));
			}else{
				throw new Exception("Machine not found");
			}
		}catch(Exception $e){
			$this->response(REST_Controller::Exception_($e));
		}
	}

	function activate_post(){
		$this->load->model('api/M_log_ins', 'log_ins');

		$merchant_code = $this->post('merchant_code', TRUE); 
		$pin 				= md5(sha1(md5(sha1(md5($this->post('pin', TRUE))))));
		$code 			= $this->post('machine_code', TRUE); 
		$imei 			= $this->post('imei', TRUE); 
		$date 			= date('Y-m-d H:i:s');
		$serial			= $this->post('serial', TRUE);

		$result = array();

		try{
			if(empty($imei)){
				throw new Exception("IMEI can't be empty");
			}
			
			$check_imei = $this->log_ins->get_log(array('imei' => $imei))->row();
			if(count($check_imei) > 0 && $check_imei->counter >= 3){
				throw new Exception("You've reached maximum attempt");
			}

			$machine =  $this->machine->get_machine_info(array('b.merchant_code' => $merchant_code, 'a.pin' => $pin, 'a.code' => $code))->row();
			if(count($machine) > 0 && ($machine->imei == $imei || empty($machine->imei))){
				$this->machine->update(array('serial' => $serial, 'status' => 1, 'imei' => $imei,'register_date' => date('Y-m-d H:i:s')), array('code' => $code, 'pin' => $pin));
				$this->log_ins->delete(array('imei' => $imei));
				$this->response(REST_Controller::Success_('OK'));
			}else{
				$this->log_ins->update_or_insert($imei); 
				throw new Exception("Error Processing Request");
			}
		}catch(Exception $e){
			$this->response(REST_Controller::Exception_($e));
		}

	}
}

/* End of file Machine 2.php */
/* Location: ./application/controllers/Machine 2.php */