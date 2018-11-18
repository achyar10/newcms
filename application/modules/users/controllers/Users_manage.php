<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users_manage extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }
    $list_access = array(SUPERADMIN);
    if (!in_array($this->session->userdata('uroleid'),$list_access)) {
      redirect('manage');
    }
    $this->load->model('users/Users_model');

  }


  public function index($offset = NULL) {
    $this->load->library('pagination');
    $f = $this->input->get(NULL, TRUE);

    $data['f'] = $f;

    $params = array();
        // Nip
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['user_nik'] = $f['n'];
    }

    $paramsPage = $params;
    $params['limit'] = 5;
    $params['offset'] = $offset;
    $data['user'] = $this->Users_model->get($params);

    $config['per_page'] = 5;
    $config['uri_segment'] = 4;
    $config['base_url'] = site_url('manage/users/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    $config['total_rows'] = count($this->Users_model->get($paramsPage));
    $this->pagination->initialize($config);

    $data['title'] = 'Users';
    $data['main'] = 'users/user_list';
    $this->load->view('manage/layout', $data);
  }

    // Add User and Update
  public function add($id = NULL) {
    $this->load->library('form_validation');

    if (!$this->input->post('user_id')) {
      $this->form_validation->set_rules('user_password', 'Password', 'trim|required|xss_clean|min_length[6]');
      $this->form_validation->set_rules('passconf', 'Confirmation password', 'trim|required|xss_clean|min_length[6]|matches[user_password]');
      $this->form_validation->set_rules('user_email', 'Email', 'trim|required|xss_clean|is_unique[users.user_email]');
      $this->form_validation->set_message('passconf', 'Password dan Confirmation password not match');
    }
    $this->form_validation->set_rules('role_id', 'Roles', 'trim|required|xss_clean');
    $this->form_validation->set_rules('user_full_name', 'Full Name', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show"><button position="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    $data['operation'] = is_null($id) ? 'Add' : 'Edit';

    if ($_POST AND $this->form_validation->run() == TRUE) {

      if ($this->input->post('user_id')) {
        $params['user_id'] = $id;
        $params['user_last_update'] = date('Y-m-d H:i:s');
      } else {
        $params['user_input_date'] = date('Y-m-d H:i:s');
        $params['user_email'] = $this->input->post('user_email');
        $params['user_password'] = sha1($this->input->post('user_password'));
      }
      $params['role_role_id'] = $this->input->post('role_id');
      $params['user_full_name'] = $this->input->post('user_full_name');

      $this->Users_model->add($params);

      $this->session->set_flashdata('success', $data['operation'] . ' User success');
      redirect('manage/users');
    } else {
      if ($this->input->post('user_id')) {
        redirect('manage/users/edit/' . $this->input->post('user_id'));
      }

            // Edit mode
      if (!is_null($id)) {
        $object = $this->Users_model->get(array('id' => $id));
        if ($object == NULL) {
          redirect('manage/users');
        } else {
          $data['user'] = $object;
        }
      }
      $data['roles'] = $this->Users_model->get_role();
      $data['title'] = $data['operation'] . ' User';
      $data['main'] = 'users/user_add';
      $this->load->view('manage/layout', $data);
    }
  }

    // View data detail
  public function view($id = NULL) {
    $data['user'] = $this->Users_model->get(array('id' => $id));
    $data['title'] = 'User Detail';
    $data['main'] = 'users/user_view';
    $this->load->view('manage/layout', $data);
  }

    // Delete to database
  public function delete($id = NULL) {
   if ($this->session->userdata('uroleid')!= SUPERADMIN){
    redirect('manage');
  }
  if ($_POST) {
    $this->Users_model->delete($id);

    $this->session->set_flashdata('success', 'delete User success');
    redirect('manage/users');
  } elseif (!$_POST) {
    $this->session->set_flashdata('delete', 'Delete');
    redirect('manage/users/edit/' . $id);
  }
}


function rpw($id = NULL) {
  $this->load->library('form_validation');
  $this->form_validation->set_rules('user_password', 'Password', 'trim|required|xss_clean|min_length[6]');
  $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|xss_clean|min_length[6]|matches[user_password]');
  $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
  if ($_POST AND $this->form_validation->run() == TRUE) {
    $id = $this->input->post('user_id');
    $params['user_password'] = sha1($this->input->post('user_password'));
    $status = $this->Users_model->change_password($id, $params);

    $this->session->set_flashdata('success', 'Reset Password success');
    redirect('manage/users');
  } else {
    if ($this->Users_model->get(array('id' => $id)) == NULL) {
      redirect('manage/users');
    }
    $data['user'] = $this->Users_model->get(array('id' => $id));
    $data['title'] = 'Reset Password';
    $data['main'] = 'users/change_pass';
    $this->load->view('manage/layout', $data);
  }
}

}
