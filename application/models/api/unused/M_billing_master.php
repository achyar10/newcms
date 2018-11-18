<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_billing_master extends CI_Model {

	function insert($data){
		$this->db->insert('billing_master', $data);
		return $this->db->insert_id();
	}

	function update($data, $condition){
		return $this->db->update('billing_master', $data, $condition);
	}

	function get($arr_criteria=null, $limit=null, $offset=null){
		return $this->db->get_where('billing_master', $arr_criteria, $limit, $offset);
	}

	function get_join_table($billing_code = array()){
		$this->db->where_in('billing_code', $billing_code);
		$this->db->where('paid', 'NO');
		return $this->db->get('billing_master');
	}

	function set_paid_join($billing_code=array()){
		$billing_code = implode(',',$billing_code);
		$sql = "UPDATE billing_master SET paid = 'YES' WHERE billing_code IN ($billing_code)";
		return $this->db->query($sql);
	}

}

/* End of file m_billing_master.php */
/* Location: ./application/models/m_billing_master.php */