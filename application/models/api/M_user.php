<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model {

	function get_user($arr_criteria=null, $limit=null, $offset=null){
		return $this->db->get_where('user', $arr_criteria, $limit, $offset);
	}

	function update($data, $condition){
		return $this->db->update('user', $data, $condition);
	}

	function insert($data){
		$this->db->insert('user', $data);
		return $this->db->insert_id();
	}

	function user_login($username,$password,$merchant_id,$branch_id){
		return $this->db->query("SELECT a.user_id, IFNULL(a.merchant_merchant_id,'') merchant_merchant_id, IFNULL(b.merchant_name,'') merchant_name, IFNULL(b.address,'') merchant_address, IFNULL(b.phone,'') merchant_phone
			FROM `user` a 
			LEFT JOIN merchant b ON a.merchant_merchant_id = b.merchant_id
			WHERE a.name = '$username' 
			AND a.password = sha1($password)
			AND a.merchant_code = '$merchant_code' 
			")->row_array();
	}
}

/* End of file m_user.php */
/* Location: ./application/models/m_user.php */