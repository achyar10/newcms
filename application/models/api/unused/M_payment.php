<?php

/**
 * Description of M_login
 *
 * @author gun
 */

class M_payment extends MY_Model {
    private $table = 'order_master';
    private $table_2 = 'order_detail';
    private $table_3 = 'food_menu';
    private $table_4 = 'payment_bank';
    private $table_5 = 'payment_method';
    private $table_6 = 'store';
    private $table_7 = 'merchant';
    private $table_8 = 'discount_list';
    
    public function __construct() {
        parent::__construct($this);
    }
    
    public function get_order($params) {
        try {            
            $query = $this->db
                    ->select(
                            'order_master.table_no, '
                            . 'order_master.order_date, '
                            . 'food_menu.menu_name, '
                            . 'food_menu.menu_print_abbrev, '
                            . 'food_menu.menu_discount, '
                            . 'order_detail.qty, '
                            . 'order_detail.price_per_item')
                    ->from($this->table)
                    ->join($this->table_2, 'order_detail.order_master_id = order_master.id')
                    ->join($this->table_3, 'food_menu.id = order_detail.food_id')
                    ->where($params)
                    ->get();

            if (!$query) {
                MY_Model::DBException_();
            }
            
            return $query->result();
            
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    public function get_order_receipt($params) {        
        try {
            $query = $this->db
                    ->select(
                            'order_master.table_no, '
                            . 'order_master.order_date, '
                            . 'order_master.pay_total, '
                            . 'order_master.approval_code, '
                            . 'food_menu.menu_name, '
                            . 'food_menu.menu_print_abbrev, '                            
                            . 'IF(merchant.service = \'ON\', merchant.service_value, 0) as service, '                            
                            . 'IF(NOW() >= discount_list.start_date AND NOW() <= discount_list.end_date, discount_list.discount_value, 0) as discount, '                            
                            . 'order_detail.qty, '
                            . 'order_detail.price_per_item, '
                            . 'store.name,'
                            . 'store.address,'
                            . 'store.city,'
                            . 'store.postal_code,'
                            . 'store.phone')
                    
                    ->from($this->table)
                    ->join($this->table_2, 'order_detail.order_master_id = order_master.id')
                    ->join($this->table_3, 'food_menu.id = order_detail.food_id')
                    ->join($this->table_6, 'store.code = order_master.store_code')
                    ->join($this->table_7, 'merchant.merchant_code = order_master.merchant_code')
                    ->join($this->table_8, 'discount_list.id = order_master.discount_id')
                    ->where($params)
                    ->get();

            if (!$query) {
                MY_Model::DBException_();
            }

            return $query->result();

        } catch (Exception $e) {
            throw $e;
        }        
    }
    
    public function check_order($where=array()) {
        try {
            $query = $this->db
                            ->where($where)
                            ->get($this->table);                            
            
            if (!$query) {
                MY_Model::DBException_();
            }
            
            return $query->row();
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    public function payment_method_lists() {
        try {
            $query = $this->db->get($this->table_5)->result();
            
            return $query;
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    public function bank_payment_list() {
        try {
            $query = $this->db->get($this->table_4)->result();
            
            return $query;
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    public function do_payment($params=array(), $where=array()) {
        try {
            $query = $this->db
                        ->where($where)
                        ->update($this->table, $params);
            
            if (!$query) {
                MY_Model::DBException_();
            }                        
            
            return $query;
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    public function get_payment_method($where) {
        try {
            $query = $this->db
                        ->select('payment_bank.bank_name, payment_method.payment_name')
                        ->from($this->table)
                        ->join($this->table_4, 'payment_bank.id = order_master.payment_bank_id')
                        ->join($this->table_5, 'payment_method.id = order_master.payment_method_id')
                        ->where($where)
                        ->get();
                
            if (!$query) {
                MY_Model::DBException_();
            }
            
            return $query->row();
        } catch (Exception $e) {
            throw $e;
        }
    }

    function get_receipt($order_master_id){
        $sql = "SELECT 
            a.transaction_no,
            a.`table_no`,
            DATE(NOW()) tanggal,
            c.`name` cashier_name,
            b.`name` store_name , 
            b.`address` store_address, 
            b.`city` store_city, 
            b.`postal_code` store_postal_code,
            a.`sub_total`,
            a.`discount_value`,
            CASE WHEN a.discount_value != 0 THEN (a.sub_total * a.discount_value)/100 ELSE 0 END discount_nominal,
            a.`service_value`,
            CASE WHEN a.service_value != 0 THEN (a.sub_total * a.service_value)/100 ELSE 0 END service_nominal,
            10 tax,
            CAST( (a.sub_total * 10)/100  AS UNSIGNED) tax_value,
            a.`grand_total`,
            CASE WHEN a.payment_method_id = 1 THEN pay_total ELSE a.grand_total END pay_total,
            CASE WHEN a.payment_method_id = 1 THEN a.pay_total-a.grand_total ELSE 0 END return_total,
            (SELECT d.desc FROM general_setting d WHERE id = 1) footer_receipt
            FROM `order_master` a
            INNER JOIN `store` b ON a.`store_code` = b.`code` AND a.`merchant_code` = b.`merchant_code`
            INNER JOIN `user` c ON a.`user_id` = c.`id`
            WHERE a.`id` = $order_master_id";
        return $this->db->query($sql);
    }
}
