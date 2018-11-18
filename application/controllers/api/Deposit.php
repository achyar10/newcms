<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Deposit extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('api/M_user', 'user');
		$this->load->model('api/M_deposit', 'deposit');
	}

	public function index_post(){
		$user_id		= $this->post('user_id');
		$deposit 	= $this->post('deposit');
	
		try{
			if(empty($user_id)){
				throw new Exception("Undefined User");
			}

			if(empty($deposit)){
				throw new Exception("Deposit cannot be empty");
			}

			if($deposit <= 0){
				throw new Exception("Deposit should greater than 0");
			}

			$user = $this->user->get_user(array('id' => $user_id))->row();

			if(count($user) == 0){
				throw new Exception("User not found");
			}

			$this->deposit->insert(array(
				'user_id' 		=> $user_id,
				'deposit'		=>	$deposit,
				'createdate'	=> date('Y-m-d H:i:s')
			));

			$update = $this->user->update(array('deposit' => $deposit),array('id' => $user_id));
			if($update){
				$this->response(REST_Controller::Success_('OK'));
			}else{
				throw new Exception("Error Processing Request");
			}
		}catch(Exception $e){
			$this->response(REST_Controller::Exception_($e));
		}
	}

}

/* End of file Deposit.php */
/* Location: ./application/controllers/Deposit.php */