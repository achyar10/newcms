<?php

/**
 * Description of M_report
 *
 * @author denny
 */
class M_report extends MY_Model {
    private $table_0 = 'billing_master';
    private $table_2 = 'billing_detail';
    private $table_3 = 'food_menu';
    private $table_6 = 'store';
    private $table_7 = 'merchant';
    private $table_8 = 'user';
    private $table_9 = 'pay_master';
    private $table_10 = 'pay_detail';
    private $table_11 = 'pay_detail_type';
    
    public function __construct() {
        parent::__construct($this);
    }
    
    public function get_report_per_today($where=array()) {
        try {
            $query = $this->db
                            ->select("billing_master.table_no, "
                                    . "billing_master.transaction_no, "
                                    . "pay_master.transaction_no, "
                                    . "pay_master.merchant_code, "
                                    . "pay_master.store_code, "
                                    . "pay_master.pay_date, "
                                    . "pay_master.discount_value as discount, "
                                    . "pay_master.service_value as service, "
                                    . "pay_master.tax_value as tax, "
                                    . "pay_master.sub_total, "
                                    . "pay_master.grand_total, "
                                    . "user.name as cashier_name")
                            ->from($this->table_9)
                            ->join($this->table_11, 'pay_detail_type.pay_id = pay_master.id')
                            ->join($this->table_0, 'billing_master.id = pay_detail_type.billing_id')                            
                            ->join($this->table_8, 'user.id = pay_master.cashier_id')
                            ->where($where)
                            ->get();                            
            
            if (!$query) {
                MY_Model::DBException_();
            }

            return $query->result();
        } catch (Exception $e) {
            throw $e;
        }
    }        
    
    public function report_detail($params=array()) {
    try {
            $query = $this->db
                    ->select(
                            'order_master.table_no, '
                            . 'pay_master.transaction_no, '
                            . 'pay_master.pay_date, '
                            . 'pay_master.pay_total, '
                            . 'pay_master.sub_total, '
                            . 'pay_master.grand_total, '
                            . 'pay_master.service_value as service, '
                            . 'pay_master.discount_value as discount, '
                            . 'pay_master.tax_value as tax, '                            
                            . 'user.name as cashier_name, '
                            . 'food_menu.menu_name, '
                            . 'food_menu.menu_print_abbrev, '
                            . 'pay_detail.qty, '
                            . 'pay_detail.price_per_item ')
                    
                    ->from($this->table_9)
                    ->join($this->table_10, 'pay_detail.pay_master_id = pay_master.id')
                    ->join($this->table_3, 'food_menu.id = pay_detail.food_id')    
                    ->join($this->table_6, 'store.code = pay_master.store_code')
                    ->join($this->table_7, 'merchant.merchant_code = pay_master.merchant_code')                    
                    ->join($this->table_8, 'user.id = pay_master.cashier_id')
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
    
    public function report_detail_2($where) {
        try {
            $query = $this->db->query("SELECT d.table_no, c.transaction_no as trx_no, d.transaction_no as bill_no, c.pay_date,
                                d.sub_total, c.service_value as service,
                                c.discount_value as discount, c.tax_value as tax, 
                                f.menu_name, f.menu_print_abbrev, pd.qty, pd.price_per_item,
                                u.name as cashier_name
                                FROM (pay_master c
                                INNER JOIN
                                (SELECT a.*, GROUP_CONCAT(b.table_no) table_no, b.transaction_no, b.sub_total, b.discount_value, b.service_value, b.tax_value
                                    FROM pay_detail_type a
                                    INNER JOIN billing_master b ON a.billing_id = b.id) d ON c.id = d.pay_id)
                                INNER JOIN pay_detail pd ON pd.pay_id = d.pay_id
                                INNER JOIN food_menu f ON f.id = pd.food_id
                                INNER JOIN user u ON u.id = c.cashier_id
                                WHERE c.merchant_code = '{$where["pay_master.merchant_code"]}' AND "
                                . "c.store_code = '{$where["pay_master.store_code"]}' AND c.transaction_no = '{$where["pay_master.transaction_no"]}'
                                "
                            );
                                
            return $query->result();
        } catch (Exception $e) {
            throw $e;
        }
    }

    // ------------- by ifa --------------- AND DATE(b.pay_date) = CURDATE()
    function report_by_cashier($merchant_code,$store_code,$cashier_id){
        return $this->db->query("SELECT b.pay_date,  b.id pay_master_id, b.transaction_no pay_invoice, b.sub_total, b.tax_value tax_percent, b.service_value service_percent, b.down_payment_value, b.special_discount, b.discount_value discount_percent, b.grand_total, b.cashier_id, GROUP_CONCAT(c.table_no) table_no
            FROM pay_detail_type a 
            INNER JOIN pay_master b ON a.pay_id = b.id
            INNER JOIN order_master c ON a.order_master_id = c.id
            WHERE b.merchant_code = '$merchant_code' AND b.store_code = '$store_code' AND b.cashier_id = $cashier_id  
            GROUP BY a.pay_id
            ORDER BY b.pay_date DESC");
    }


    function report_per_item($pay_id){
        return $this->db->query("SELECT a.food_id, b.menu_name food_name, a.food_category_id, c.category_name food_category_name, a.qty, a.price_per_item, (a.qty * a.price_per_item) total_price
            FROM pay_detail a
            INNER JOIN food_menu b ON a.food_id = b.id
            INNER JOIN food_category c ON a.food_category_id = c.id
            WHERE a.pay_id = $pay_id");
    }
}
