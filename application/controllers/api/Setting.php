<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('api/M_user', 'user');
	}

	public function change_password_post(){
		$old_password = $this->post('old_password');
		$new_password = $this->post('new_password');	
		$user_id	  = $this->post('user_id');

		try{
			$user = $this->user->get_user(array('id' => $user_id))->row();
			if(count($user) == 0){
				throw new Exception("User not found.");
			}

			if($user->password != md5($old_password)){
				throw new Exception("Old password doesn't match");
			}

			$update = $this->user->update(array('password' => md5($new_password)),array('id' => $user_id));

			if(!$update){
				throw new Exception("Error while updating password.");
			}

			$this->response(REST_Controller::Success_(true));
		}catch (Exception $e) {
            $this->response(REST_Controller::Exception_($e), $e->getCode());
        }		
	}

}

/* End of file setting.php */
/* Location: ./application/controllers/setting.php */