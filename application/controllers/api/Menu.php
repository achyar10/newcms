<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('api/M_food_menu', 'food');
		$this->load->model('api/M_merchant', 'merchant');
	}

	public function list_post(){
		$category_id 	= $this->post('category_id'); //array
		$merchant_code	= $this->post('merchant_code');

		$where = " a.merchant_code = {$merchant_code} AND a.active = '1' ";

		try{
			if(empty($merchant_code)){
				throw new Exception("Merchant code cannot be empty");
			}

			if(!empty($category_id)){
				$where .= ' AND a.category_id IN ('.implode(',', $category_id).')';
			}

			$get_menu = $this->food->get_menu($where)->result_array();
				
			if (!empty($get_menu)){
	           $i=0;
	           	foreach ($get_menu as $m ) {
	           		$menu[$i] = $m;
	           		$menu[$i]['image_url'] = base_url().'assets/img/menu/'.$m['menu_image'];
	           		$i++;
	           	}

	           $this->response(REST_Controller::Success_($menu));
	        }else{
	           throw new Exception("Menu is empty");
	        }
		}catch(Exception $e){
			$this->response(REST_Controller::Exception_($e));
		}
	}

	function category_get(){
		$this->load->model('api/M_food_category', 'category');
	
		try{
			$get_category = $this->category->get()->result_array();
				
			if (!empty($get_category)){
	           $this->response(REST_Controller::Success_($get_category));
	        }else{
	           throw new Exception("Category is empty");
	        }
		}catch(Exception $e){
			$this->response(REST_Controller::Exception_($e));
		}
	}

	function process_post($process='add'){
		$merchant_code			= $this->post('merchant_code');
		$menu_name				= $this->post('menu_name');
		$menu_print_abbrev	= $this->post('menu_print_abbrev');
		$menu_desc				= $this->post('menu_desc');
		$menu_price				= $this->post('menu_price');
		$menu_stock				= $this->post('menu_stock');
		$menu_image				= $this->post('menu_image');
		$category_id			= $this->post('category_id');

		//edit
		$food_id = $this->post('menu_id');

		try{
			if($process == 'add'){
				if(empty($merchant_code)){
					throw new Exception("Merchant code cannot be empty");
				}

				$merchant = $this->merchant->get(array('merchant_code' => $merchant_code))->row();
				
				if(count($merchant) == 0){
					throw new Exception("Merchant not found");
				}
			}

			if($process == 'edit'){
				if(empty($food_id)){
					throw new Exception("No menu selected");
				}
			
				$food = $this->food->get(array('id' => $food_id))->row();
				
				if(count($food) == 0){
					throw new Exception("Menu not found");
				}
			}

			if(empty($category_id)){
				throw new Exception("Category cannot be empty");
			}

			if(empty($menu_name)){
				throw new Exception("Menu name cannot be empty");
			}

			if(!empty($menu_image)){
				$image_file   	= time().rand(1111,9999).".png";
	      	$decoded_image = base64_decode($menu_image);
	      	$upload_image 	= file_put_contents('./assets/img/menu/'.$image_file, $decoded_image);
			
	      	if($upload_image === false){
	      		throw new Exception("Error uploading image");
	      	}
	      }	

			$now = date('Y-m-d H:i:s');

			$data = array(
				'merchant_code'		=> $merchant_code,
				'category_id'			=> $category_id,
				'menu_name'				=> $menu_name,
				'menu_print_abbrev'	=> $menu_print_abbrev,
				'menu_price'			=> $menu_price,
				'menu_desc'				=> $menu_desc,
				'created_date'			=> $now,
				'stock'					=> $menu_stock
			);

			if($process == 'add'){
				$data['menu_image'] = isset($image_file) ? $image_file : 'no_image.png';
				$do_process = $this->food->insert($data);
			}else{
				unset($data['merchant_code'],$data['stock'],$data['created_date']);
				if(isset($image_file)){
					$data['menu_image'] = $image_file; 
				}	
				$data['modified_date'] = $now;
				$do_process = $this->food->update($data,array('id' => $food_id));
			}

			if($do_process){
				$return = $process == 'add' ? array('food_id' => $do_process) : 'OK';
				$this->response(REST_Controller::Success_($return));
			}else{
				throw new Exception("Error Processing Request");
			}
		}catch(Exception $e){
			$this->response(REST_Controller::Exception_($e));
		}
	}
	
	

}

/* End of file menu.php */
/* Location: ./application/controllers/menu.php */