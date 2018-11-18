<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_pay_master extends CI_Model {

	function insert($data){
		$this->db->insert('pay_master', $data);
		return $this->db->insert_id();
	}

	function get_report($merchant_code){
		$sql = "SELECT a.id pay_id, a.transaction_no, a.grand_total, a.pay_date, b.name username, CASE WHEN a.card_number = 0 THEN '-' ELSE a.card_number END card_number, c.payment_name pay_method
			FROM pay_master a
			INNER JOIN `user` b ON b.id = a.user_id
			INNER JOIN `payment_method` c ON a.payment_method_id = c.id
			WHERE a.merchant_code = '{$merchant_code}'
			AND EXTRACT(YEAR_MONTH FROM a.pay_date) = '".date('Ym')."'
			AND a.clicked = 'NO'
			AND a.void = 'NO'
			ORDER BY a.pay_date DESC
			";
		return $this->db->query($sql);
	}

	function get_report_detail($pay_id){
		return $this->db->query("SELECT b.menu_name, c.category_name, a.qty, a.price_per_item
		FROM pay_detail a 
		INNER JOIN food_menu b ON a.food_id = b.id
		INNER JOIN food_category c ON a.food_category_id = c.id
		WHERE a.pay_id = {$pay_id}");
	} 

	function update($data, $condition){
		return $this->db->update('pay_master', $data, $condition);
	}

	function pay_list($where='',$order_by='a.pay_date'){
		$sql = "SELECT 
					a.id pay_id, 
					a.transaction_no invoice,
					GROUP_CONCAT(e.menu_name) menu_name,
					GROUP_CONCAT(f.category_name) menu_category,
					GROUP_CONCAT(d.qty) qty,
					GROUP_CONCAT(d.price_per_item) menu_price,
					a.grand_total, 
					a.pay_date, 
					b.name username, 
					CASE WHEN a.card_number = 0 THEN '-' ELSE a.card_number END card_number, c.payment_name pay_method
				FROM pay_master a
				INNER JOIN `user` b ON b.id = a.user_id
				INNER JOIN `payment_method` c ON a.payment_method_id = c.id
				INNER JOIN pay_detail d ON a.id = d.pay_id
				INNER JOIN food_menu e ON e.id = d.food_id
				INNER JOIN food_category f ON d.food_category_id = f.id
				$where
				GROUP BY a.id
				ORDER BY $order_by ";

		return $this->db->query($sql);
	}

	function get_join($where=null,$limit=null,$offset=null){
		$this->db->select("a.*,b.payment_name , CASE WHEN a.card_number = 0 THEN '-' ELSE a.card_number END card, c.name username");
		$this->db->from('pay_master a');
		$this->db->join('payment_method b', 'a.payment_method_id = b.id');
		$this->db->join('user c', 'a.user_id = c.id');
		if($where!=null) $this->db->where($where);
		if($limit!=null) $this->db->limit($limit, $offset);
		return $this->db->get();
	}

	function get($arr_criteria=null, $limit=null, $offset=null){
		return $this->db->get_where('pay_master', $arr_criteria, $limit, $offset);
	}
}

/* End of file  */
/* Location: ./application/models/ */