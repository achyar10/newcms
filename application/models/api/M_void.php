<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_void extends CI_Model {

	function insert($data){
		$this->db->insert('void', $data);
		return $this->db->insert_id();
	}

	function get($arr_criteria=null, $limit=null, $offset=null){
		return $this->db->get_where('void', $arr_criteria, $limit, $offset);
	}
}

/* End of file M_void.php */
/* Location: ./application/models/M_void.php */