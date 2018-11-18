<?php

/**
 * Description of M_login
 *
 * @author gun
 */

class M_auth extends CI_Model {
    private $table = 'user';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_user_by_user_pwd($params) {
        try {            
            $query = $this->db
                    ->where($params)
                    ->get($this->table)
                    ->row();
            
            return $query;
            
        } catch (Exception $e) {
            throw $e;
        }
    }
}
