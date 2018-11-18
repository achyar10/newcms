<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('api/M_pay_master', 'pay_master');
	}

	//buat KDS
	public function index_get(){
		$merchant_code = $this->get('merchant_code');

		try{
			if(empty($merchant_code)){
				throw new Exception("Merchant cannot be empty");
			}

			$get = $this->pay_master->get_report($merchant_code)->result_array();

			if(count($get) == 0){
				throw new Exception("No data found");
			}

			$this->response(REST_Controller::Success_($get));
		}catch(Exception $e){
			$this->response(REST_Controller::Exception_($e));
		}
	}

	function list_per_day_get(){
		$today 			= date('Y-m-d');
		$merchant_code	= $this->get('merchant_code');

		try{
			if(empty($merchant_code)){
				throw new Exception("Merchant code cannot be empty");
			}

			$pay = $this->pay_master->get_join(array('DATE(a.pay_date)' => $today, 'a.merchant_code' => $merchant_code, 'a.void' => 'NO'))->result();
			if(count($pay) == 0){
				throw new Exception("No data found.");
			}	

			$data = array();
			foreach($pay as $p){
				array_push($data,array(
					'pay_id' 			=> $p->id,
	            'transaction_no'	=> $p->transaction_no,
	            'grand_total'		=> number_format($p->grand_total),
	            'pay_date'			=> $p->pay_date,
	            'username'			=> $p->username,
	            'card_number'		=> $p->card_number,
	            'pay_method'		=> $p->payment_name
				));
			}
			$this->response(REST_Controller::Success_($data));
		}catch(Exception $e){
			$this->response(REST_Controller::Exception_($e));
		}
	}

	public function detail_get(){
		$pay_id = $this->get('pay_id');

		try{
			if(empty($pay_id)){
				throw new Exception("No data selected");
			}

			$get = $this->pay_master->get_report_detail($pay_id)->result_array();
			$arr = array();
			foreach($get as $g){
				$g['total']	= $g['qty'] * $g['price_per_item'];
				array_push($arr,$g);
			}

			if(count($arr) == 0){
				throw new Exception("No data found");
			}

			$this->response(REST_Controller::Success_($arr));
		}catch(Exception $e){
			$this->response(REST_Controller::Exception_($e));
		}
	}

	function clicked_get(){
   	$pay_id = $this->get('pay_id');	
   	
   	try{
   		if(empty($pay_id)){
   			throw new Exception("Undefined payment");
   		}
   		$update = $this->pay_master->update(array('clicked' => 'YES'),array('id' => $pay_id));
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

/* End of file report.php */
/* Location: ./application/controllers/report.php */