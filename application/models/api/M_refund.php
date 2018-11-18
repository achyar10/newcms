<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_refund extends CI_Model {

	function insert($data){
		return $this->db->insert('refund', $data);
	}

}

/* End of file m_refund.php */
/* Location: ./application/models/m_refund.php */