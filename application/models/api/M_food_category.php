<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_food_category extends CI_Model {

	function get($arr_criteria=null, $limit=null, $offset=null){
		return $this->db->get_where('food_category', $arr_criteria, $limit, $offset);
	}

}

/* End of file m_food_category.php */
/* Location: ./application/models/m_food_category.php */