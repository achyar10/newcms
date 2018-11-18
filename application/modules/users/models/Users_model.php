<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array()) {

        if (isset($params['id'])) {
            $this->db->where('users.user_id', $params['id']);
        }
        if (isset($params['email'])) {
            $this->db->where('user_email', $params['email']);
        }
        if (isset($params['password'])) {
            $this->db->where('user_password', $params['password']);
        }
        if (isset($params['fullname'])) {
            $this->db->where('user_full_name', $params['fullname']);
        }

        if (isset($params['status'])) {
            $this->db->where('user_status', $params['status']);
        }

        if (isset($params['role'])) {
            $this->db->where('users.role_id', $params['role']);
        }

        if (isset($params['limit'])) {
            if (!isset($params['offset'])) {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }

        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'desc');
        } else {
            $this->db->order_by('user_last_update', 'desc');
        }

        $this->db->select('user_id, user_password, user_full_name,
            user_email, user_status, user_last_login, user_input_date, user_last_update');
        $this->db->select('users.role_id, roles.role_name');

        $this->db->join('roles', 'roles.role_id = users.role_id', 'left');

        $res = $this->db->get('users');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    // Get Role From Databases
    function get_role($params = array()) {
        $this->db->select('roles.role_id, role_name');

        if (isset($params['id'])) {
            $this->db->where('roles.role_id', $params['id']);
        }
        if (isset($params['role_id'])) {
            $this->db->where('roles.role_id', $params['role_id']);
        }

        if (isset($params['limit'])) {
            if (!isset($params['offset'])) {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }

        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'desc');
        } else {
            $this->db->order_by('roles.role_id', 'desc');
        }

        $res = $this->db->get('roles');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    function add($data = array()) {

        if (isset($data['user_id'])) {
            $this->db->set('user_id', $data['user_id']);
        }

        if (isset($data['user_password'])) {
            $this->db->set('user_password', $data['user_password']);
        }

        if (isset($data['user_full_name'])) {
            $this->db->set('user_full_name', $data['user_full_name']);
        }

        if (isset($data['user_email'])) {
            $this->db->set('user_email', $data['user_email']);
        }

        if (isset($data['user_input_date'])) {
            $this->db->set('user_input_date', $data['user_input_date']);
        }

        if (isset($data['user_last_login'])) {
            $this->db->set('user_last_login', $data['user_last_login']);
        }

        if (isset($data['user_last_update'])) {
            $this->db->set('user_last_update', $data['user_last_update']);
        }

        if (isset($data['user_status'])) {
            $this->db->set('user_status', $data['user_status']);
        }

        if (isset($data['user_is_login'])) {
            $this->db->set('user_is_login', $data['user_is_login']);
        }

        if (isset($data['role_id'])) {
            $this->db->set('role_id', $data['role_id']);
        }

        if (isset($data['user_id'])) {
            $this->db->where('user_id', $data['user_id']);
            $this->db->update('users');
            $id = $data['user_id'];
        } else {
            $this->db->insert('users');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    function delete($id) {
        $this->db->where('user_id', $id);
        $this->db->delete('users');
    }

    function change_password($id, $params) {
        $this->db->where('user_id', $id);
        $this->db->update('users', $params);
    }

    function user_login($email, $password){
        $this->db->select('user_id, user_email, user_full_name, user_status');
        $this->db->where('user_email',$email);
        $this->db->where('user_password',$password);
        $res = $this->db->get('users');
        return $res->row_array();
    }

}
