<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_store extends CI_Model {

	function get($arr_criteria=null, $limit=null, $offset=null){
		return $this->db->get_where('store', $arr_criteria, $limit, $offset);
	}

}

/* End of file m_merchant.php */
/* Location: ./application/models/m_merchant.php */