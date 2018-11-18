<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_topup_bonus extends CI_Model {

	function get($arr_criteria=null, $limit=null, $offset=null){
		return $this->db->get_where('topup_bonus', $arr_criteria, $limit, $offset);
	}

}

/* End of file m_topup_bonus.php */
/* Location: ./application/models/m_topup_bonus.php */