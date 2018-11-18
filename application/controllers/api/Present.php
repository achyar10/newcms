<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Present extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('employee/Employee_model');
		$this->load->model('present/Present_model');
		$this->load->helper('string');
	}

	function present_post() {
		
		$nip = $this->post('nip');
		$desc = $this->post('desc');
		$out1 = $this->post('out1');
		$out2 = $this->post('out2');

		try {
			if(empty($nip)){
				throw new Exception("NIP cannot be empty");
			}

			$this->db->from('employees');
			$this->db->where('employee_nip', $nip);          
			$this->db->where('employee_status', TRUE); 
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				$params['employee_employee_nip'] = $nip;
				$params['employee_employee_id'] = $query->row('employee_id');
				$params['present_year'] = date('Y');
				$params['present_month'] = date('m');
				$params['present_date'] = date('Y-m-d');

				if ($desc == 1) {
					$checkin = $this->Present_model->get(array('date' => date('Y-m-d'), 'employee_nip' => $nip));
					if (!empty($checkin)) {
						throw new Exception("Maaf, anda sudah mengisi jam kedatangan untuk hari ini");
					} else {
						if (date('H:i:s') > '08:15:59') {
							$params['present_is_late'] = TRUE;
						}
						$params['present_entry_time_1'] = date('H:i:s');
						$this->Present_model->add($params);
						$this->response(REST_Controller::Success_($params));
					}
				} elseif ($desc == 2) {
					$checkout = $this->Present_model->get(array('date' => date('Y-m-d'), 'employee_nip' => $nip));
					if (empty($checkout)) {
						throw new Exception("Maaf, Anda belum presensi masuk");
					} else {
						$params['present_id'] = $checkout['present_id'];
						$params['present_out_desc_1'] = $out1;
						$params['present_out_time_1'] = date('H:i:s');
						$this->Present_model->add($params);
						$this->response(REST_Controller::Success_($params));
					}
				} elseif ($desc == 3) {
					$checkin = $this->Present_model->get(array('date' => date('Y-m-d'), 'employee_nip' => $nip));
					if ($checkin['present_out_time_1'] == null) {
						throw new Exception("Maaf, anda belum mengisi jam keluar untuk hari ini");
					} else {
						$params['present_id'] = $checkin['present_id'];
						$params['present_entry_time_2'] = date('H:i:s');
						$this->Present_model->add($params);
						$this->response(REST_Controller::Success_($params));
					}
				} elseif ($desc == 4) {
					$checkout = $this->Present_model->get(array('date' => date('Y-m-d'), 'employee_nip' => $nip));
					if ($checkout['present_entry_time_2'] == null) {
						throw new Exception("Maaf, Anda belum presensi masuk");
					} else {
						$params['present_id'] = $checkout['present_id'];
						$params['present_out_desc_2'] = $out2;
						$params['present_out_time_2'] = date('H:i:s');
						$this->Present_model->add($params);
						$this->response(REST_Controller::Success_($params));
					}
				}
			} else {
				throw new Exception("NIP, Tidak terdaftar");
			}
		} catch(Exception $e) {
			$this->response(REST_Controller::Exception_($e));
		}
	}

}

/* End of file Present.php */
/* Location: ./application/controllers/api/Present.php */