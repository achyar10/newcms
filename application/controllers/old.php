<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('string');
    }

    public function index() {
        $res = array('message' => 'Nothing here');

        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($res));
    }

    public function login() {
       $this->load->model('users/User_model');
        $params['success'] = 0;
        $params['message'] = 'Email or password incorrect';
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        if ($this->form_validation->run()) {
            $data['user_email'] = $this->input->post('email', TRUE);
            $data['user_password'] = sha1($this->input->post('password', TRUE));
            $user = $this->User_model->get($data);
            if (count($user) == 1) {
                $arr_res = array(
                    'user_role_role_id' => $user[0]['role_name'],
                    'id' => $user[0]['user_id'],
                    'email' => $user[0]['user_email'],
                    'fullname' => $user[0]['user_full_name'],
                );
                $params['success'] = 1;
                $params['data'] = $arr_res;
                $params['message'] = 'Login Success';
            } else {
                $params['success'] = 0;
                $params['message'] = 'Email or password incorrect';
            };
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($params));
    }

    public function get_user($merchant_id=null, $branch_id=null) {
        // $merchant_id = $this->get('merchant_id');
        // $branch_id = $this->get('branch_id');
        $this->load->model('users/User_model');
        $res = $this->User_model->get(array('merchant'=>$merchant_id, 'branch'=>$branch_id));

        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($res));
    }

    public function get_class2() {
        $this->load->model('student/Student_model');
        $res = $this->Student_model->get(array('group'=>true));

        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($res));
    }


    public function get_student_by_class($id = NULL) {
        if ($id != NULL) {
            $this->load->model('student/Student_model');
            $res = $this->Student_model->get(array('status'=>1, 'class_id'=>$id));

            $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($res));
        } else {
            redirect('api');
        }
    }


    public function get_student_by_id($student_id= NULL) {
        if ($payment_id != NULL) {
            $this->load->model('student/Student_model');
            $res = $this->Student_model->get(array('id' => $student_id));

            $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($res));
        } else {
            redirect('api');
        }
    }

    public function get_student() {
            $this->load->model('student/Student_model');
            $res = $this->Student_model->get();

            $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($res)); 
    }


    public function get_payout_bulan($payment_id = NULL, $student_id= NULL) {
        if ($payment_id != NULL) {
            $this->load->model('bulan/Bulan_model');
            $res = $this->Bulan_model->get(array('payment_id' => $payment_id, 'student_id' => $student_id));

            $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($res));
        } else {
            redirect('api');
        }
    }

}
