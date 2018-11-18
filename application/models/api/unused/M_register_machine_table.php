<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_register_machine_table extends CI_Model {

	function get_machine($arr_criteria=null, $limit=null, $offset=null){
		return $this->db->get_where('register_machine_table', $arr_criteria, $limit, $offset);
	}

	function update($data, $condition){
		return $this->db->update('register_machine_table', $data, $condition);
	}
}

/* End of file m_register_machine_table.php */
/* Location: ./application/models/m_register_machine_table.php */