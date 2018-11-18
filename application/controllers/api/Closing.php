<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Closing extends REST_Controller {

	private $doc_path;

	public function __construct(){
		parent::__construct();
		$this->load->model('api/M_pay_master', 'pay');
		$this->doc_path = 'assets/document/closing';
	}

	public function list_get(){
		$user_id 		= $this->get('user_id');
		$merchant_code	= $this->get('merchant_code');
		$date 		   = date('Y-m-d');
	
		try{
			if(empty($user_id)){
				throw new Exception("User not found");
			}

			if(empty($merchant_code)){
				throw new Exception("Merchant is not defined");
			}

			$where = ' WHERE DATE(a.pay_date) = "'.$date.'" AND a.user_id = '.$user_id.' AND a.closing = "0" AND a.merchant_code = "'.$merchant_code.'" AND a.void = "NO"';
			$list  = $this->pay->pay_list($where)->result();

			if(count($list) > 0){
				$closing_list = array();
				foreach($list as $l){
					$menu_category  = explode(',', $l->menu_category);
					$menu_name 		 = explode(',', $l->menu_name);
					$menu_qty  		 = explode(',', $l->qty);
					$menu_price		 = explode(',', $l->menu_price);
					$menu_list 		 = array();

					for($i=0; $i<count($menu_name); $i++){
						array_push($menu_list,array(
							'menu_name'			=> $menu_name[$i],
							'menu_category'	=> $menu_category[$i],
							'menu_qty'			=> $menu_qty[$i],
							'menu_price'		=> $menu_price[$i]
						));
					}
					array_push($closing_list, array(
						'invoice' 		=> $l->invoice,
						'grand_total'  => $l->grand_total,
						'pay_date'		=> date('d M Y H:i',strtotime($l->pay_date)),
						'pay_method' 	=> $l->pay_method, 
						'menu_list' 	=> $menu_list
					));
				}

				$this->response(REST_Controller::Success_($closing_list));
			}else{
				throw new Exception("No data found");
			}
		}catch(Exception $e){
			$this->response(REST_Controller::Exception_($e));
		}
	}

	function send_email_post(){ 
		$this->load->model('api/M_user', 'user');

		$user_id 		= $this->post('user_id');
		$merchant_code	= $this->post('merchant_code');
		$email_to		= $this->post('email');
		$date 		   = date('Y-m-d');

		try{
			if(empty($user_id)){
				throw new Exception("User not found");
			}

			$user = $this->user->get_user(array('id' => $user_id))->row();
			if(count($user) == 0){
				throw new Exception("User not found.");
			}

			$saldo_awal = $user->deposit;

			if(empty($merchant_code)){
				throw new Exception("Merchant is not defined");
			}

			$condition = array(
				'a.user_id'				=> $user_id,
				'a.merchant_code'		=> $merchant_code,
				'DATE(a.pay_date)'	=> date('Y-m-d'),
				'closing'				=> '0',
				'a.void'					=> 'NO'
			);

			$list  = $this->pay->get_join($condition)->result_array();

			if(count($list) > 0){
				$this->load->library("Excel/PHPExcel");
            $objPHPExcel = new PHPExcel();
            $styleArray  = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));

            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("A1", "No." ,PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("B1", "No Transaksi" ,PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("C1", "Tipe Pembayaran" ,PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("D1", "No Kartu" ,PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("E1", "Nominal" ,PHPExcel_Cell_DataType::TYPE_STRING);

            $i=2; $no = 1; $nom =0; 
            foreach ($list as $d) {
               $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("A$i",$no,PHPExcel_Cell_DataType::TYPE_NUMERIC);
               $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("B$i",$d["transaction_no"],PHPExcel_Cell_DataType::TYPE_STRING);
               $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("C$i",$d["payment_name"],PHPExcel_Cell_DataType::TYPE_STRING);
               $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("D$i",$d["card"],PHPExcel_Cell_DataType::TYPE_STRING);
               $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("E$i", $d["grand_total"],PHPExcel_Cell_DataType::TYPE_NUMERIC);
               $nom = $nom + $d["grand_total"] ;
               $i++; $no++;
            }

            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("E$i", $nom,PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $i++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("D$i", 'Deposit',PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("E$i", $saldo_awal,PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $i++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("D$i", 'Total',PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("E$i", $saldo_awal+$nom,PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $objPHPExcel->getActiveSheet()->getStyle("A1:E$no")->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(27);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(27);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(18);

            $objPHPExcel->getActiveSheet()->setTitle('Excel');
            $objWriter 	= PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $file 		= $user->name."_".date("d M y H:i:s");
            $objWriter->save(str_replace(__FILE__,'./'.$this->doc_path.'/'.$file.'.xlsx',__FILE__));

            $dest = $this->doc_path."/".$file.".xlsx";
            
            // Konfigurasi email.
				$email_from = 'noreply@appsku.co.id';

		      $config = [
			      'protocol'  	=> 'SMTP',
			      'smtp_host' 	=> 'mail.apppsku.co.id',
			      'smtp_user' 	=>  $email_from,   
			      'smtp_pass' 	=> 'AppsMail!2018',
			      'smtp_port' 	=>  587,
			      'smtp_timeout' => 30,
			      'wordwrap'  	=> TRUE,
			      'wrapchars' 	=> 80,
			      'mailtype'  	=> 'html',
			      'charset'   	=> 'utf-8',
			      'validate'  	=> TRUE,
			      'crlf'      	=> "\r\n",
			      'newline'   	=> "\r\n",
			   ];

		     	$this->load->library('email', $config);
		     	$this->email->from($email_from, $email_to);   
		     	$this->email->to($email_to);                  
		     	$this->email->subject('Data_'.$file);
		     	if(file_exists($dest)) $this->email->attach($dest);

		     	if ($this->email->send()){
		     		$this->pay->update(array('closing' => '1'), array(
						'user_id'				=> $user_id,
						'merchant_code'		=> $merchant_code,
						'DATE(pay_date)'	=> date('Y-m-d')) 
		     		);

		     		$this->user->update(array('deposit' => 0),array('id' => $user_id));

		     	}else{
		     		throw new Exception("Error Processing Request");
		     	}
			}

			$this->response(REST_Controller::Success_('OK'));
		}catch(Exception $e){
			$this->response(REST_Controller::Exception_($e));
		}
	}
}

/* End of file Closing.php */
/* Location: ./application/controllers/Closing.php */
