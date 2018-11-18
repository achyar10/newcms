<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Topup extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('api/M_card', 'card');
		$this->load->model('api/M_topup_master', 'topup_master');
		$this->load->model('api/M_topup_cash', 'topup_cash');
		$this->load->model('api/M_topup_bank', 'topup_bank');
		$this->load->model('api/M_topup_bonus', 'topup_bonus');
		$this->load->model('api/M_topup_invoice', 'inv');
	}

	public function index_post(){
		$card_number		= $this->post('card_number');
		$payment_method_id= $this->post('payment_method_id');
		$user_id				= $this->post('user_id');
		$bonus_id			= $this->post('bonus_id');
		$grand_total		= $this->post('grand_total');

		//payment bank
		$approval_code		= $this->post('approval_code');
		$ccno					= $this->post('ccno');

		//payment cash
		$pay_cash			= $this->post('pay_cash');
		$now 					= date('Y-m-d H:i:s');
		
		try{
			if(empty($card_number)){
				throw new Exception("Card number cannot be empty");
			}

			$card = $this->card->get(array('card_number' => $card_number))->row();

			if(count($card) == 0){
				throw new Exception("Card not found");
			}

			if(empty($grand_total)){
				throw new Exception("Total topup cannot be empty");
			}

			if(empty($payment_method_id)){
				throw new Exception("Please select payment method");
			}

			if(empty($user_id)){
				throw new Exception("User cannot be empty");
			}

			if($payment_method_id == 2){
				if(empty($approval_code)){
					throw new Exception("Approval code cannot be empty");
				}

				if(empty($ccno)){
					throw new Exception("Credit number cannot be empty");
				}
			}

			$inv = $this->inv->set_invoice();
			if($inv['result'] == false){
				throw new Exception("Error Processing Request");
			}

			$invoice = $inv['inv'];
			$now = date('Y-m-d H:i:s');
			$sub_total = $grand_total;

			if(!empty($bonus_id)){
				$bonus = $this->topup_bonus->get(array(
					'start_date <=' 		=> $now,
					'end_date >='	 		=> $now,
					'id'				 		=> $bonus_id,
					'payment_method_id'	=> $payment_method_id
				))->row();
				
				if(count($bonus) == 0){
					throw new Exception("Bonus not found");
				}

				$bonus_percent = $bonus->bonus_percent;
				$grand_total = $grand_total + ($grand_total * $bonus_percent)/100;
			}

			$this->db->trans_start();

			$insert_data = array(
				'transaction_no'		=> $invoice,
				'card_number'			=> $card_number,
				'payment_method_id'	=> $payment_method_id,
				'sub_total'				=> $sub_total,
				'grand_total'			=> $grand_total,
				'bonus_id'				=> empty($bonus_id) ? 0 : $bonus_id,
				'user_id'				=> $user_id,
				'bonus_percent'		=> isset($bonus_percent) ? $bonus_percent : 0,
				'created_date'			=> $now
			);

			$topup_id = $this->topup_master->insert($insert_data);

			if($payment_method_id == 2){
				$this->topup_bank->insert(array(
					'topup_master_id' => $topup_id,
					'ccno'				=> $ccno,
					'approval_code'	=> $approval_code
				));
			}

			$this->card->update(array('last_payment_method_id' => $payment_method_id, 'last_topup_master_id' => $topup_id), array('card_number' => $card_number));
			$this->card->update_saldo($grand_total,$card_number,'+');

			$this->db->trans_complete();
         if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            throw new Exception("Error Processing Transaction");
         }else{
            $this->db->trans_commit();
            $this->response(REST_Controller::Success_(array('invoice' => $invoice)));
         } 
		}catch(Exception $e){
			$this->response(REST_Controller::Exception_($e));
		}
	}
}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */