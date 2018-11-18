<?php

/**
 * Description of M_down_payment
 *
 * @author denny
 */
class M_down_payment extends MY_Model {
    private $_table = 'down_payment';
    private $_table1 = 'user';
    private $_table2 = 'user_dept';
    private $_table3 = 'merchant';
    private $_table4 = 'store';
    
    public function __construct() {
        parent::__construct($this);
    }
    
    public function is_authorized($where=array()) {
        try {
            $query = $this->db
                            ->select("user.name, user_dept.dept_name")
                            ->from($this->_table1)
                            ->join($this->_table3, 'merchant.merchant_code = user.merchant_code')
                            ->join($this->_table4, 'store.code = user.store_code')
                            ->join($this->_table2, 'user_dept.id = user.user_dept_id')
                            ->where($where)
                            ->get();
            
            if (!$query) {
                MY_Model::DBException_();
            }
            
            return $query->num_rows();
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    public function save($params) {
        try {            
            if (!$this->db->insert($this->_table, $params)) {
                MY_Model::DBException_();
            }
        
            return $this->db->insert_id();
        } catch (Exception $e) {
            throw $e;
        }       
    }


    function update($data, $condition){
        return $this->db->update('down_payment', $data, $condition);
    }

    function get($arr_criteria=null, $limit=null, $offset=null){
        return $this->db->get_where('down_payment', $arr_criteria, $limit, $offset);
    }
}
