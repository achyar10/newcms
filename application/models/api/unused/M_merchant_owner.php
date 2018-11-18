<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_merchant_owner extends CI_Model {

	function insert($data){
		return $this->db->insert('merchant_owner', $data);
	}

}

/* End of file M_merchant_owner.php */
/* Location: ./application/models/M_merchant_owner.php */