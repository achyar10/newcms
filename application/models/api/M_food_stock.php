<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Food_stock extends CI_Model {

	function insert($data){
		$this->db->insert('food_stock', $data);
		return $this->db->insert_id();
	}

	function report($merchant_code){
		return $this->db->query("SELECT a.*, b.name username
		FROM food_stock a
		INNER JOIN `user` b ON a.user_id = b.id
		WHERE EXTRACT(YEAR_MONTH FROM CURDATE()) = '".date('Ym')."'
		AND a.merchant_code = '{$merchant_code}'
		ORDER BY a.created_date DESC
		;");
	}

	function report_detail($food_stock_id){
		return $this->db->query("SELECT a.*, b.menu_name
		FROM food_stock_detail a
		INNER JOIN food_menu b ON a.food_id = b.id
		WHERE a.food_stock_id = {$food_stock_id}");
	}

}

/* End of file food_stock.php */
/* Location: ./application/models/food_stock.php */