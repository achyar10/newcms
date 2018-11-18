<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_manage extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
        header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }
    $this->load->model(array('users/Users_model'));
}

public function index() {
    $id = $this->session->userdata('uid'); 
    $data['total_user'] = count($this->Users_model->get());
    
    $data['title'] = 'Dashboard';
    $data['main'] = 'dashboard/dashboard';
    $this->load->view('manage/layout', $data);
}

}
