<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_order_master extends CI_Model {

	function insert($data){
		$this->db->insert('order_master', $data);
		return $this->db->insert_id();
	}

	function update_sub_total($order_id,$value){
		return $this->db->set('sub_total', "sub_total+$value" , FALSE)
        ->where('id', $order_id)
        ->update('order_master');
	}

	function get_order($arr_criteria=null, $limit=null, $offset=null){
		return $this->db->get_where('order_master', $arr_criteria, $limit, $offset);
	}

	function update($data, $condition){
		return $this->db->update('order_master', $data, $condition);
	}

	function set_bill_tables($order_master_id=array()){
		$order_master_id = implode(',', $order_master_id);
		return $this->db->query("UPDATE order_master SET bill = 'YES' WHERE id IN ($order_master_id)");
	}

}

/* End of file m_order_master.php */
/* Location: ./application/models/m_order_master.php */