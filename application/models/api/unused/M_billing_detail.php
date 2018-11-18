<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_billing_detail extends CI_Model {

	function insert_batch($data){
		return $this->db->insert_batch('billing_detail', $data);
	}

	function get_detail($where=null,$limit=null,$offset=null){
		$this->db->select('a.*, b.menu_name, b.menu_print_abbrev');
		$this->db->from('billing_detail a');
		$this->db->join('food_menu b', 'a.food_id = b.id');
		if($where!=null) $this->db->where($where);
		if($limit!=null) $this->db->limit($limit, $offset);
		return $this->db->get();
	}

	function get($arr_criteria=null, $limit=null, $offset=null){
		return $this->db->get_where('billing_detail', $arr_criteria, $limit, $offset);
	}

	function get_join_menu($billing_code=array()){
		$billing_code = implode(',', $billing_code);

		$sql = "SELECT a.food_id, a.food_category_id, SUM(a.qty) qty, a.price_per_item, SUM(a.qty*a.price_per_item) total, a.open_menu, c.menu_print_abbrev
				FROM billing_detail a
				INNER JOIN billing_master b ON a.billing_master_id = b.id
				INNER JOIN food_menu c ON a.food_id = c.id
				WHERE b.billing_code IN ($billing_code)
				GROUP BY a.food_id";
		return $this->db->query($sql);
	}

}

/* End of file m_billing_detail.php */
/* Location: ./application/models/m_billing_detail.php */