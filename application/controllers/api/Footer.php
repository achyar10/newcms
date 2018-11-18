<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Footer extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('api/M_footer', 'footer');
	}

	public function index_get(){
		
		try{
			$result = $this->footer->get()->result();
			
			if(count($result) == 0){
				throw new Exception("Footer is empty");
			}

			$footer = array();
			if(count($result) > 0){
				foreach ($result as $r) {
					array_push($footer, $r->desc);
				}
			}

			$this->response(REST_Controller::Success_($footer));
		}catch (Exception $e) {
         	$this->response(REST_Controller::Exception_($e));
      	}
	}

}

/* End of file footer.php */
/* Location: ./application/controllers/footer.php */