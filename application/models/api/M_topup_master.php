<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_topup_master extends CI_Model {

	function insert($data){
		$this->db->insert('topup_master', $data);
		return $this->db->insert_id();
	}

}

/* End of file m_topup.php */
/* Location: ./application/models/m_topup.php */