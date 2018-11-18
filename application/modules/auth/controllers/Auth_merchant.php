<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth_merchant extends CI_Controller { 

    public function __construct() {
        parent::__construct();
        $this->load->model('user_merchant/User_merchant_model');
        $this->load->library('form_validation');
        $this->load->helper('string');
    }

    function index() {
        redirect('merchant/auth/login');
    }

    function login() {
        if ($this->session->userdata('logged_merchant')) {
            redirect('merchant');
        }
        if ($this->input->post('location')) {
            $location = $this->input->post('location');
        } else {
            $location = NULL;
        }
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($_POST AND $this->form_validation->run() == TRUE) {
            $email = $this->input->post('email', TRUE);
            $password = $this->input->post('password', TRUE);

            $user = $this->User_merchant_model->get(array('email' => $email, 'password' => sha1($password)));

            if (count($user) > 0) {
                $this->session->set_userdata('logged_merchant', TRUE);
                $this->session->set_userdata('uid_merchant', $user[0]['user_merchant_id']);
                $this->session->set_userdata('uemail_merchant', $user[0]['user_merchant_email']);
                $this->session->set_userdata('ufullname_merchant', $user[0]['user_merchant_full_name']);
                $this->session->set_userdata('last_login_merchant', $user[0]['user_merchant_last_login']);
                $this->session->set_userdata('branch_id', $user[0]['branch_branch_id']);
                $this->session->set_userdata('merchant_id', $user[0]['merchant_merchant_id']);
                $this->session->set_userdata('merchant_code', $user[0]['merchant_merchant_code']);
                $this->User_merchant_model->add(array('user_merchant_id'=>$this->session->userdata('uid_merchant'), 'user_merchant_last_login'=> date('Y-m-d H:i:s')));
                if ($location != '') {
                    header("Location:" . htmlspecialchars($location));
                } else {
                    redirect('merchant');
                }
            } else {
                if ($location != '') {
                    $this->session->set_flashdata('failed', 'Maaf, username dan password tidak cocok!');
                    header("Location:" . site_url('merchant/auth/login') . "?location=" . urlencode($location));
                } else {
                    $this->session->set_flashdata('failed', 'Maaf, username dan password tidak cocok!');
                    redirect('merchant/auth/login');
                }
            }
        } else {
            $this->load->view('merchant/login');
        }
    }

    // Logout Processing
    function logout() {
        $this->session->unset_userdata('logged_merchant');
        $this->session->unset_userdata('uid_merchant');
        $this->session->unset_userdata('uemail_merchant');
        $this->session->unset_userdata('ufullname_merchant');
        $this->session->unset_userdata('last_login_merchant');
        $this->session->unset_userdata('branch_id');
        $this->session->unset_userdata('merchant_id');
        $this->session->unset_userdata('merchant_code');

        $q = $this->input->get(NULL, TRUE);
        if ($q['location'] != NULL) {
            $location = $q['location'];
        } else {
            $location = NULL;
        }
        header("Location:" . $location);
    }

}
