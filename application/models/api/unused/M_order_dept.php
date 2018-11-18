<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_order_dept extends CI_Model {

	function insert($order_master_id,$next_order=false){
		$sql = "INSERT INTO order_dept (order_master_id , order_detail_id, table_no,  merchant_code, store_code , store_dept_id , food_id, food_name , qty , done)
			SELECT d.id order_master_id, b.id order_detail_id, d.table_no, d.merchant_code, d.store_code,  a.store_dept_id, b.food_id, c.menu_name, b.qty, '0' done
			FROM food_dept a
			INNER JOIN order_detail b ON a.food_id = b.food_id
			INNER JOIN food_menu c ON a.food_id = c.id
			INNER JOIN order_master d ON b.order_master_id = d.id
			WHERE b.order_master_id = $order_master_id";

		if($next_order != false) $sql .= " AND b.id NOT IN (SELECT e.order_detail_id FROM order_dept e WHERE e.order_master_id = $order_master_id) ";
		return $this->db->query($sql);
	}


	function get($arr_criteria=null, $limit=null, $offset=null){
		return $this->db->get_where('order_dept', $arr_criteria, $limit, $offset);
	}


	function update($data, $condition){
		return $this->db->update('order_dept', $data, $condition);
	}
}

/* End of file m_order_dept.php */
/* Location: ./application/models/m_order_dept.php */