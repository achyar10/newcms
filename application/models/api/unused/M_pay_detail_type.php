<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pay_detail_type extends CI_Model {

	function insert($data){
		return $this->db->insert('pay_detail_type', $data);
	}

	function insert_batch($data){
		return $this->db->insert_batch('pay_detail_type', $data);
	}

}

/* End of file m_pay_detail_type.php */
/* Location: ./application/models/m_pay_detail_type.php */