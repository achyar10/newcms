<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pay_master extends CI_Model {

	function get($arr_criteria=null, $limit=null, $offset=null){
		return $this->db->get_where('pay_master', $arr_criteria, $limit, $offset);
	}

	function insert($data){
		$this->db->insert('pay_master', $data);
		return  $this->db->insert_id();
	}

	function get_info($where=null,$limit=null,$offset=null){
		$this->db->select('a.*, b.name, b.name store_name, b.address store_address, b.city store_city, b.postal_code store_postal, b.phone store_phone, c.name cashier_username');
		$this->db->from('pay_master a');
		$this->db->join('store b', 'a.store_code = b.code AND a.merchant_code = b.merchant_code');
		$this->db->join('user c', 'a.cashier_id = c.id');
		if($where!=null) $this->db->where($where);
		if($limit!=null) $this->db->limit($limit, $offset);
		return $this->db->get();
	}

	function closing($cashier_id,$merchant_code,$store_code){
		return $this->db->query("SELECT a.transaction_no,  b.payment_desc , a.grand_total
				FROM pay_master a
				INNER JOIN payment_method b ON a.payment_bank_id = b.id
				WHERE a.pay_date = CURDATE()
				AND a.closing = '0'
				AND a.cashier_id = $cashier_id
				AND a.merchant_code = '$merchant_code'
				AND a.store_code = '$store_code'
			");
	}

}

/* End of file m_pay_master.php */
/* Location: ./application/models/m_pay_master.php */