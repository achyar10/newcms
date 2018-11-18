<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pay_detail extends CI_Model {

	function insert_batch($data){
		return $this->db->insert_batch('pay_detail', $data);
	} 

	function get($arr_criteria=null, $limit=null, $offset=null){
		return $this->db->get_where('pay_detail', $arr_criteria, $limit, $offset);
	}

}

/* End of file m_pay_detail.php */
/* Location: ./application/models/m_pay_detail.php */