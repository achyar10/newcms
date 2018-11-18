<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_log_ins extends CI_Model {

	function get_log($arr_criteria=null, $limit=null, $offset=null){
		return $this->db->get_where('log_ins', $arr_criteria, $limit, $offset);
	}

	function update($data, $condition){
		return $this->db->update('log_ins', $data, $condition);
	}

	function insert($data){
		return $this->db->insert('log_ins', $data);
	}

	function update_or_insert($imei){
		$imei_check = $this->db->get_where('log_ins', array('imei' => $imei))->row();
		
		if(count($imei_check) > 0){		
			return $this->db->set('counter', "counter+1" , FALSE)->where('imei', $imei)->update('log_ins');
		}else{
			return $this->db->insert('log_ins', array(
				'imei' 	 => $imei,
				'counter' => 1,
				'cdate'	 => date('Y-m-d H:i:s')	
			));
		}
	}

	function delete($array){
		return $this->db->delete('log_ins', $array);
	}

}

/* End of file M_log_ins.php */
/* Location: ./application/models/M_log_ins.php */