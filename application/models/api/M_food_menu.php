<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_food_menu extends CI_Model {

	function get_menu($where=null,$limit=null,$offset=null){
		$this->db->select('a.*, b.category_name');
		$this->db->from('food_menu a');
		$this->db->join('food_category b', 'a.category_id = b.id');
		if($where) $this->db->where($where);
		if($limit) $this->db->limit($limit, $offset);
		return $this->db->get();
	}	

	function insert($data){
		$this->db->insert('food_menu', $data);
		return $this->db->insert_id();
	}

	function get($arr_criteria=null, $limit=null, $offset=null){
		return $this->db->get_where('food_menu', $arr_criteria, $limit, $offset);
	}

	function subtract_stock($food_id=array(),$food_qty=array()){
		if(count($food_id) > 0){
			for($i=0; $i<count($food_id); $i++){
				$this->db->set('stock', "stock-{$food_qty[$i]}" , FALSE)->where('id', $food_id[$i])->update('food_menu');
			}			
		}
	}

	function update_stock_batch($food_id=array(),$food_qty=array(),$operator='+'){
		if(count($food_id) > 0){
			$sql = "UPDATE `food_menu` SET `stock` = CASE ";

			for($i=0; $i<=count($food_id)-1; $i++){
				$sql .= " WHEN `id` = {$food_id[$i]} THEN stock {$operator} {$food_qty[$i]} ";
			}

			$sql .= " ELSE `stock` END
			  		  WHERE `id` IN(".implode(',', $food_id).")
					";

			return $this->db->query($sql);
		}else{
			return false;
		}
	}

	function update($data=null, $condition=null){
		return $this->db->update('food_menu', $data, $condition);
	}

}

/* End of file m_food_menu.php */
/* Location: ./application/models/m_food_menu.php */