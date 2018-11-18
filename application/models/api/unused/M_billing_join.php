<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_billing_join extends CI_Model {

	function insert_batch($data){
		return $this->db->insert_batch('billing_join', $data);
	}

}

/* End of file m_billing_join.php */
/* Location: ./application/models/m_billing_join.php */