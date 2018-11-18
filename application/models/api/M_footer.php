<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_footer extends CI_Model {

	function get($arr_criteria=null, $limit=null, $offset=null){
		$this->db->order_by('line', 'asc');
		return $this->db->get_where('footer', $arr_criteria, $limit, $offset);	   
	}

}

/* End of file m_footer.php */
/* Location: ./application/models/m_footer.php */