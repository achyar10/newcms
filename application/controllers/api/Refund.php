<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Refund extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('api/M_card', 'card');
		$this->load->model('api/M_refund', 'refund');
	}

	public function process_post(){
		$card_number 	= $this->post('card_number');
		$user_id			= $this->post('user_id');
		$now 				= date('Y-m-d H:i:s');

		try{
			if(empty($user_id)){
				throw new Exception("User cannot be empty");
			}

			if(empty($card_number)){
				throw new Exception("Card number cannot be empty");
			}

			$card = $this->card->get(array('card_number' => $card_number))->row();

			if(count($card) == 0){
				throw new Exception("Card not found");
			}

			if($card->last_payment_method_id != 1){
				throw new Exception("Cannot refund transaction with debit/credit payment.");
			}

			if($card->saldo == 0){
				throw new Exception("No value to refund.");
			}

			$now = date('Y-m-d H:i:s');

			$this->db->trans_start();

			$this->refund->insert(array(
				'topup_master_id'	=> $card->last_topup_master_id,
				'member_card'		=>	$card_number,
				'refund_total'		=>	$card->saldo,
				'created_date'		=>	$now,
				'user_id'			=> $user_id
			));

			$this->card->update(array('saldo' => 0), array('card_number' => $card_number));

			$this->db->trans_complete();
            if($this->db->trans_status() === FALSE) {
               $this->db->trans_rollback();
               throw new Exception("Error Processing Request");
            }else{
               $this->db->trans_commit();
               $this->response(REST_Controller::Success_('OK'));
            } 
		}catch (Exception $e) {
         $this->response(REST_Controller::Exception_($e, REST_Controller::HTTP_NOT_FOUND));
   		$this->response(REST_Model::Exception_($e, ));

      }

	}

}

/* End of file refund.php */
/* Location: ./application/controllers/refund.php */