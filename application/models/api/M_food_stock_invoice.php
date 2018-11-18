<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_food_stock_invoice extends CI_Model {

	function get_invoice($arr_criteria=null, $limit=null, $offset=null){
		return $this->db->get_where('food_stock_invoice', $arr_criteria, $limit, $offset);
	}

	function set_invoice($merchant_code){
		$month = date('m'); $year = date('Y'); $now = date('Y-m-d H:i:s');
		$inv = $this->get_invoice(array('merchant_code' => $merchant_code))->row();

		if(count($inv) > 0){
			if($inv->year == $year && $inv->month == $month){
				$invoice_number = $inv->invoice+1;	
			}else{ $invoice_number = 1; }

			$process = $this->db->update('food_stock_invoice', array('month' => $month, 'year' => $year,'invoice' => $invoice_number,'modified_date' => $now), array('merchant_code' => $merchant_code));
		}else{
			$invoice_number = 1;

			$process = $this->db->insert('food_stock_invoice', array(
			'merchant_code' => $merchant_code,
			'month' 			 => $month, 
			'year' 			 => $year,
			'invoice' 		 => $invoice_number,
			'modified_date' => $now
			));
		}

		if($process){
			return array(
				'result' => true,
				'inv' => 'ST'.date('ym').'/'.$merchant_code."/".str_pad($invoice_number,4,"0",STR_PAD_LEFT)
			);
		}else{
			return array('result' => false);
		}
	}
}

/* End of file m_order_invoice.php */
/* Location: ./application/models/m_order_invoice.php */