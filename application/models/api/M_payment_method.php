<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_payment_method extends CI_Model {

	function get($arr_criteria=null, $limit=null, $offset=null){
		return $this->db->get_where('payment_method', $arr_criteria, $limit, $offset);
	}

}

/* End of file payment_method.php */
/* Location: ./application/models/payment_method.php */