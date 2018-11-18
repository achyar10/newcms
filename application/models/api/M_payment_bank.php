<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_payment_bank extends CI_Model {

	function get($arr_criteria=null, $limit=null, $offset=null){
		return $this->db->get_where('payment_bank', $arr_criteria, $limit, $offset);
	}

}

/* End of file m_payment_bank.php */
/* Location: ./application/models/m_payment_bank.php */