<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_order_detail extends CI_Model {

	function insert_batch($data){
		$this->db->insert_batch('order_detail', $data);
		return $this->db->affected_rows() > 0 ? true : false;
	}

	function list_order($where=null,$limit=null,$offset=null){
		$this->db->select('a.*, b.menu_code, b.menu_name, b.menu_image, b.menu_print_abbrev, b.menu_desc, b.menu_discount, c.category_name');
		$this->db->from('order_detail a');
		$this->db->join('food_menu b', 'a.food_id = b.id');
		$this->db->join('food_category c', 'ON a.food_category_id = c.id');
		$this->db->join('order_master d', 'a.order_master_id = d.id');
		if($where!=null) $this->db->where($where);
		if($limit!=null) $this->db->limit($limit, $offset);
		$this->db->order_by('a.id', 'asc');
		return $this->db->get();
	}

	function get_detail($arr_criteria=null, $limit=null, $offset=null){
		return $this->db->get_where('order_detail', $arr_criteria, $limit, $offset);
	}

	function update($data, $condition){
		return $this->db->update('order_detail', $data, $condition);
	}

	function add_qty_served($order_detail_id,$value){
		return $this->db->set('qty_served', "qty_served+$value" , FALSE)
        ->where('id', $order_detail_id)
        ->update('order_detail');
	}

	function set_qty_paid($order_master_id){
		return $this->db->query("UPDATE order_detail SET qty_paid = qty WHERE order_master_id = $order_master_id");
	}

	function add_qty_paid($order_detail_id,$value){
		return $this->db->set('qty_paid', "qty_paid+$value" , FALSE)
        ->where('id', $order_detail_id)
        ->update('order_detail');
	}

	function set_paid($order_master_id){
		$sql = "SELECT *
				FROM order_detail a
				WHERE a.order_master_id = $order_master_id 
				AND a.qty != a.qty_paid";

		$check = $this->db->query($sql)->row();
		if(count($check) == 0){
			$this->db->update('order_master',  array('bill' => 'YES'), array('id' => $order_master_id));
		}
	}  

	function insert($data){
		return $this->db->insert('order_detail', $data);
	}
}

/* End of file m_order_detail.php */
/* Location: ./application/models/m_order_detail.php */