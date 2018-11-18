<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_printer extends CI_Model {

	function print_by_dept($order_master_id){
		$sql = "SELECT store_dept_id, e.dept_name, food_id, menu_name, qty, GROUP_CONCAT(ip_address SEPARATOR '||') ip_address
				FROM 
				(
				SELECT GROUP_CONCAT(a.food_id SEPARATOR '||') food_id , GROUP_CONCAT(d.menu_print_abbrev SEPARATOR '||') menu_name, GROUP_CONCAT(a.qty SEPARATOR '||') qty , b.store_dept_id, c.ip_address, c.primary
				FROM order_detail a 
				INNER JOIN food_dept b ON a.food_id = b.food_id
				INNER JOIN printer  c ON c.store_dept_id = b.store_dept_id
				INNER JOIN food_menu d ON d.id = a.food_id
				WHERE a.order_master_id = $order_master_id AND a.print = 'NO'
				GROUP BY c.ip_address, c.store_dept_id
				ORDER BY b.store_dept_id, FIELD(c.primary,'YES','NO')
				) tabel
				INNER JOIN store_dept e ON e.id = store_dept_id 
				GROUP BY tabel.store_dept_id
				";
		return $this->db->query($sql);
	}

	function get_printer($define_dept_name, $merchant_code, $store_code){
        $dept_name = array( 'CASHIER' => 3 );
        $result = array();

        if (array_key_exists($define_dept_name, $dept_name)) {
            $dept_id = $dept_name[$define_dept_name];

            $printer = $this->db->query("SELECT * FROM printer a WHERE a.store_dept_id = $dept_id ORDER BY FIELD(a.primary, 'YES','NO')")->result();
                
            if(count($printer) > 0){
                foreach($printer as $p){
                    array_push($result, $p->ip_address);   
                }
            }
        }

        return $result ;
    }
}

/* End of file m_printer.php */
/* Location: ./application/models/m_printer.php */