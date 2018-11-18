<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_topup_invoice extends CI_Model {

	function get_invoice($arr_criteria=null, $limit=null, $offset=null){
		return $this->db->get_where('topup_invoice', $arr_criteria, $limit, $offset);
	}

	function set_invoice(){
		$month = date('m'); $year = date('Y'); $now = date('Y-m-d H:i:s');
		$inv = $this->get_invoice()->row();

		if(count($inv) > 0){
			if($inv->year == $year && $inv->month == $month){
				$invoice_number = $inv->invoice + 1;
			}else{
				$invoice_number = 1;
			}	
			$process = $this->db->update('topup_invoice', array('invoice' => $invoice_number,'modified_date' => $now,'month' => $month, 'year' => $year));
		}else{
			$invoice_number = 1;

			$process = $this->db->insert('topup_invoice', array(
			'month' 		=> $month, 
			'year' 			=> $year,
			'invoice' 		=> $invoice_number,
			'modified_date' => $now
			));
		}
		
		if($process){
			return array(
				'result' => true,
				'inv' => 'TOP/'.date('ym').'/'.str_pad($invoice_number,6,"0",STR_PAD_LEFT)
			);
		}else{
			return array('result' => false);
		}
	}
}

/* End of file m_order_invoice.php */
/* Location: ./application/models/m_order_invoice.php */