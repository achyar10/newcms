<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Food_stock extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('api/M_food_stock', 'food_stock');
		$this->load->model('api/M_food_stock_detail', 'food_stock_detail');
		$this->load->model('api/M_food_menu', 'food_menu');
		$this->load->model('api/M_food_stock_invoice', 'invoice');
	}

	public function add_post(){
		//array
		$food_id 			= $this->post('food_id');
		$food_qty			= $this->post('food_qty');

		$user_id				= $this->post('user_id');
		$merchant_code 	= $this->post('merchant_code');

		try{
			if(empty($user_id)){
				throw new Exception("User cannot be empty");				
			}

			if(empty($merchant_code)){
				throw new Exception("Merchant cannot be empty");
			}

			if(count($food_id) == 0){
				throw new Exception("No food selected");
			}

			$invoice = $this->invoice->set_invoice($merchant_code); 
			
			if($invoice['result'] == FALSE){
				throw new Exception("Error Processing Request");
			}

			$invoice = $invoice['inv'];

			$this->db->trans_start();

			$food_stock_id = $this->food_stock->insert(array(
				'transaction_no' 	=> $invoice, 
				'merchant_code'		=> $merchant_code,
				'user_id'			=> $user_id,
				'created_date'		=> date('Y-m-d H:i:s')
			));

			$food_stock_detail = array();

			for($i=0; $i<=count($food_id)-1; $i++){
				//insert batch
				if($food_qty[$i] >= 0){
					array_push($food_stock_detail, array(
						'food_stock_id'	=> $food_stock_id,
						'food_id'		=> $food_id[$i],
						'qty'			=> $food_qty[$i]
					));
				}
			}
			$this->food_stock_detail->insert_batch($food_stock_detail);
			$this->food_menu->update_stock_batch($food_id,$food_qty,'+');

			$this->db->trans_complete();
			
			if($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				throw new Exception("Error Processing Transaction");
			}else{
				$this->db->trans_commit();
				$this->response(REST_Controller::Success_(array('invoice' => $invoice,'transaction_id' => $food_stock_id)));
			} 
		}catch(Exception $e){
			$this->response(REST_Controller::Exception_($e));
		}
	}

	function report_get(){
		$merchant_code = $this->get('merchant_code');
		try{
			if(empty($merchant_code)){
				throw new Exception("Merchant code cannot be empty");
			}
			
			$report = $this->food_stock->report($merchant_code)->result_array();

			if(count($report) == 0){
				throw new Exception("No data found");
			}

			$this->response(REST_Controller::Success_($report));
		}catch(Exception $e){
			$this->response(REST_Controller::Exception_($e));
		}
	}

	function report_detail_get(){
		$report_id = $this->get('report_id');
		try{
			if(empty($report_id)){
				throw new Exception("No report selected");
			}
			
			$report = $this->food_stock->report_detail($report_id)->result_array();

			if(count($report) == 0){
				throw new Exception("No data found");
			}

			$this->response(REST_Controller::Success_($report));
		}catch(Exception $e){
			$this->response(REST_Controller::Exception_($e));
		}
	}

}

/* End of file food_stock.php */
/* Location: ./application/controllers/food_stock.php */