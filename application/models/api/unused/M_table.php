<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_table extends CI_Model {

	function check($merchant_code,$store_code){
		$q = "SELECT a.table_no , IFNULL(b.bill,'YES') available
			FROM 
			(SELECT table_no 
			FROM register_machine_table 
			WHERE merchant_code = '$merchant_code' AND store_code = '$store_code'
			GROUP BY table_no
			) a
			LEFT JOIN 
			(SELECT table_no, 'NO' bill
			FROM order_master 
			WHERE merchant_code = '$merchant_code' AND store_code = '$store_code' AND bill = 'NO'
			GROUP BY table_no) b ON a.table_no = b.table_no ";
		return $this->db->query($q);
	}

}

/* End of file table.php */
/* Location: ./application/models/table.php */