<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_discount_list extends CI_Model {

	function get($arr_criteria=null, $limit=null, $offset=null){
		return $this->db->get_where('discount_list', $arr_criteria, $limit, $offset);
	}

}

/* End of file m_discount_list.php */
/* Location: ./application/models/m_discount_list.php */