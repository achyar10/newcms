<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_register_machine_cashier extends CI_Model {

	function get_machine($arr_criteria=null, $limit=null, $offset=null){
		return $this->db->get_where('register_machine_cashier', $arr_criteria, $limit, $offset);
	}

	function get_machine_info($where=null,$limit=null,$offset=null){
		$this->db->select('a.*', FALSE);
		$this->db->from('register_machine_cashier a');
		$this->db->join('merchant b', 'a.merchant_code = b.merchant_code');
		if($where!=null) $this->db->where($where);
		if($limit!=null) $this->db->limit($limit, $offset);
		return $this->db->get();
	}

	function update($data,$condition){
		return $this->db->update('register_machine_cashier', $data, $condition);
	}
}

/* End of file M_machine.php */
/* Location: ./application/models/M_machine.php */