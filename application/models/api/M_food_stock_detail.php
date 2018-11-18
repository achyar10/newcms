<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Food_stock_detail extends CI_Model {

	function insert_batch($data){
		return $this->db->insert_batch('food_stock_detail', $data);
	}

}

/* End of file m_Food_stock_detail.php */
/* Location: ./application/models/m_Food_stock_detail.php */