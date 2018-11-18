<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_merchant extends CI_Model {

	function get($arr_criteria=null, $limit=null, $offset=null){
		return $this->db->get_where('merchant', $arr_criteria, $limit, $offset);
	}

	function insert($data){
		$this->db->insert('merchant', $data);
		return $this->db->insert_id();
	}

	function update($data, $condition){
		return $this->db->update('merchant', $data, $condition);
	}
}

/* End of file m_merchant.php */
/* Location: ./application/models/m_merchant.php */