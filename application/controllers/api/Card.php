<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Card extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('api/M_card', 'card');
	}

	public function info_get(){
		$card_number = $this->get('card_number');
		
		try{
			if(empty($card_number)){
				throw new Exception("Card number cannot be empty");
			}
			$card = $this->card->get(array('card_number' => $card_number))->row();
			if(count($card) == 0){
				throw new Exception("Card not found");
			}
			$this->response(REST_Controller::Success_(array('saldo' => $card->saldo)));
		}catch(Exception $e){
			$this->response(REST_Controller::Exception_($e));
		}
	}

	
}

/* End of file card.php */
/* Location: ./application/controllers/card.php */