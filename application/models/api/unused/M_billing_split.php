<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_billing_split extends CI_Model {

	function insert($data){
		return $this->db->insert('billing_split', $data);
	}

}

/* End of file m_billing_split.php */
/* Location: ./application/models/m_billing_split.php */