<?php
class Payment extends REST_Controller {
    
   public function __construct() {
      parent::__construct();
      $this->load->model('api/M_payment_method', 'payment_method');  
      $this->load->model('api/M_payment_bank', 'payment_bank');
      $this->load->model('api/M_pay_master', 'pay_master');
      $this->load->model('api/M_pay_detail', 'pay_detail');
      $this->load->model('api/M_food_menu', 'food_menu');
      $this->load->model('api/M_card', 'card');
      $this->load->model('api/M_pay_invoice', 'invoice');
   }

   function payment_method_lists_get() {
      try {
         $result = $this->payment_method->get()->result_array();
            
         if (empty($result)) {
            throw new Exception('Payment method list is empty');
         }
             
         $this->response(REST_Controller::Success_($result));
      } catch (Exception $e) {
         $this->response(REST_Controller::Exception_($e, REST_Controller::HTTP_NOT_FOUND));
      }
   }
   
   function payment_bank_lists_get() {
      try {
         $result = $this->payment_bank->get()->result_array();
            
         if (empty($result)) {
            throw new Exception('Bank list is empty');
         }
            
         $this->response(REST_Controller::Success_($result));
      } catch (Exception $e) {
         $this->response(REST_Controller::Exception_($e, REST_Controller::HTTP_NOT_FOUND));
      }
   }

   function pay_post(){
      $user_id           = $this->post('user_id');
      $merchant_code     = $this->post('merchant_code');   
      $payment_method_id = $this->post('payment_method_id');
      $discount			 = $this->post('discount_percent');

      //pay - member card
      $card_number       = $this->post('card_number');

      //pay - bank
      $bank_id				 = $this->post('bank_id');
      $approval_code		 = $this->post('approval_code');
      $ccno 				 = $this->post('ccno');

      //array
      $food_id          = $this->post('food_id');
      $food_qty         = $this->post('food_qty');
      $food_category_id = $this->post('food_category_id');
      $food_price       = $this->post('food_price');


      try{ 
         if(count($food_id) == 0){
            throw new Exception("No food selected");
         }

         if(empty($user_id)){
            throw new Exception("Unknown user");
         }

         $grand_total = 0;
         for($i=0; $i<count($food_price); $i++){
            $grand_total = $grand_total + ($food_qty[$i] * $food_price[$i]);
         }

         $insert_data = array();
         if(!empty($discount)){
         	$grand_total = $grand_total - (($grand_total * $discount) / 100);
         	$insert_data['discount_percent'] = $discount;
         }

         if($payment_method_id == 3){
         	if(empty($card_number)){
	            throw new Exception("Card cannot be empty");
	         }

	         $card = $this->card->get(array('card_number' => $card_number))->row();

	         if(count($card) == 0){
	            throw new Exception("Card not found");
	         }

         	if($card->saldo < $grand_total){
            	throw new Exception("Insufficient saldo");
         	}
         }
        
         $set_invoice = $this->invoice->set_invoice($merchant_code);
         if($set_invoice == false){
            throw new Exception("Internal error");
         }

         $invoice =  $set_invoice['inv'];

         $this->db->trans_start();
         $today = date('Y-m-d H:i:s');
         $insert_data['transaction_no']    = $invoice;
         $insert_data['merchant_code']     = $merchant_code;
         $insert_data['grand_total']       = $grand_total;
         $insert_data['user_id']           = $user_id;
         $insert_data['pay_date']          = $today; 
         $insert_data['payment_method_id'] = $payment_method_id;
         //bank payment
         if($payment_method_id == 2){
         	$insert_data['payment_bank_id'] 		= $bank_id;
         	$insert_data['payment_ccno']	  		= $ccno;
         	$insert_data['payment_approval']	  	= $approval_code;
         }
         //member card
         if($payment_method_id == 3) $insert_data['card_number'] = $card_number;

         $do_insert = $this->pay_master->insert($insert_data);
         if($do_insert){
            $pay_id  = $do_insert; $pay_detail = array();
            for($i=0; $i<count($food_id); $i++){
               if($food_qty[$i] > 0){
                  array_push($pay_detail,array(
                     'pay_id'             => $pay_id,
                     'food_id'            => $food_id[$i],
                     'food_category_id'   => $food_category_id[$i],
                     'qty'                => $food_qty[$i],
                     'price_per_item'     => $food_price[$i]
                  ));
               }
            }

            $this->pay_detail->insert_batch($pay_detail);
            $this->food_menu->update_stock_batch($food_id,$food_qty,'-');

            if($payment_method_id == 3) $this->card->update_saldo($grand_total,$card_number,'-');
            
            $this->db->trans_complete();
            if($this->db->trans_status() === FALSE) {
               $this->db->trans_rollback();
               throw new Exception("Error Processing Request");
            }else{
               $this->db->trans_commit();
               $this->response(REST_Controller::Success_(array('invoice' => $invoice )));
            } 
         }else{
            throw new Exception("Failed to get receipt.");
         }
      }catch(Exception $e){
         $this->response(REST_Controller::Exception_($e));
      } 
   }

  
}
