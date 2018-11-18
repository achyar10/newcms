<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_topup_cash extends CI_Model {

	function insert($data){
		return $this->db->insert('topup_cash', $data);
	}

}

/* End of file m_topup_cash.php */
/* Location: ./application/models/m_topup_cash.php */