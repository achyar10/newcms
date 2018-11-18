<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_merchant extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged_merchant') == NULL) {
        header("Location:" . site_url('merchant/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }
    $this->load->model(array('employee/Employee_model','register/Register_model'));
}

public function index() {
    $merchant_id = $this->session->userdata('merchant_id'); 
    $data['total_employee'] = count($this->Employee_model->get(array('merchant_id'=>$merchant_id)));
    $data['total_register'] = count($this->Register_model->get(array('merchant_id' => $merchant_id)));
    
    $data['title'] = 'Dashboard';
    $data['main'] = 'dashboard/dashboard_merchant';
    $this->load->view('merchant/layout', $data);
}

}
