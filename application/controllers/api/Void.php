<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Void extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('api/M_pay_master', 'pay');
		$this->load->model('api/M_pay_detail', 'pay_detail');
		$this->load->model('api/M_food_menu', 'food');
		$this->load->model('api/M_void', 'void');
	}

	public function index_post(){
		$payment_id = $this->post('payment_id');
		$user_id    = $this->post('user_id');

		try{
			if(empty($payment_id)){
				throw new Exception("Undefined payment");
			}

			if(empty($user_id)){
				throw new Exception("Undefined user");
			}

			$void = $this->void->get(array('pay_master_id' => $payment_id))->row();
			if(count($void) > 0){
				throw new Exception("This transaction has already been voided.");
			}

			$pay = $this->pay->get(array('id' => $payment_id))->row();
		
			if(empty($pay)){
				throw new Exception("01 - Transaction not found");
			}

			$pay_detail = $this->pay_detail->get(array('pay_id' => $payment_id))->result();

			if(empty($pay_detail)){
				throw new Exception("02 - Transaction not found");	
			}

			$item_id = array(); $item_qty = array();
			foreach($pay_detail as $p){
				array_push($item_id , $p->food_id);
				array_push($item_qty, $p->qty);
			}

			$update_stock = $this->food->update_stock_batch($item_id,$item_qty,'+');

			if($update_stock){
				$this->pay->update(array('void' => 'YES'),array('id' => $payment_id));
				$this->void->insert(array(
					'pay_master_id' => $payment_id,
					'void_date'		 => date('Y-m-d H:i:s'),
					'user_id'		 => $user_id
				));

				$this->response(REST_Controller::Success_('OK'));

			}else{
				throw new Exception("Error Processing Request");
			}

		}catch(Exception $e){
			$this->response(REST_Controller::Exception_($e));
		}
	}

}

/* End of file Void.php */
/* Location: ./application/controllers/Void.php */