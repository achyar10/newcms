<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_deposit extends CI_Model {

	function insert($data){
		return $this->db->insert('deposit', $data);
	}

}

/* End of file M_deposit.php */
/* Location: ./application/models/M_deposit.php */