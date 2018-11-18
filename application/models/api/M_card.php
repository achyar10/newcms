<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_card extends CI_Model {

	function get($arr_criteria=null, $limit=null, $offset=null){
		return $this->db->get_where('card', $arr_criteria, $limit, $offset);
	}

	function update_saldo($nominal,$card,$operator='+'){
		return $this->db->query("UPDATE card SET saldo =  saldo {$operator} {$nominal} WHERE card_number = '{$card}'");
	}	
	
	function update($data,$condition){
		return $this->db->update('card', $data, $condition);
	}
}

/* End of file m_card.php */
/* Location: ./application/models/m_card.php */