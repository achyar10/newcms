<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_topup_bank extends CI_Model {

	function insert($data){
		return $this->db->insert('topup_bank', $data);
	}	

}

/* End of file m_topup_bank.php */
/* Location: ./application/models/m_topup_bank.php */