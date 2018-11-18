<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('product/Product_model');
		$this->load->model('merchant/Merchant_model');
		$this->load->helper('string');
	}

	function category_list_get(){
		$merchant_id = $this->get('merchant_id');

		try{
			$get_category = $this->Product_model->get_category(array('merchant_id'=>$merchant_id));

			if (!empty($get_category)){
				$this->response(REST_Controller::Success_($get_category));
			}else{
				throw new Exception("Category is empty");
			}
		}catch(Exception $e){
			$this->response(REST_Controller::Exception_($e));
		}
	}

	function product_list_get(){
		$merchant_id = $this->get('merchant_id');

		try{
			$get_product = $this->Product_model->get(array('merchant_id'=>$merchant_id));

			if (!empty($get_product)){
				$this->response(REST_Controller::Success_($get_product));
			}else{
				throw new Exception("Product is empty");
			}
		}catch(Exception $e){
			$this->response(REST_Controller::Exception_($e));
		}
	}

	function process_post($process='add'){
		$merchant_id			= $this->post('merchant_id');
		$product_name			= $this->post('product_name');
		$product_desc			= $this->post('product_desc');
		$product_price		= $this->post('product_price');
		$product_image		= $this->post('product_image');
		$category_id	= $this->post('category_id');
		$user_id					= $this->post('user_id');


		//edit
		$product_id = $this->post('product_id');

		try{
			if($process == 'add'){
				if(empty($merchant_id)){
					throw new Exception("Merchant cannot be empty");
				}

				$merchant = $this->Merchant_model->get(array('merchant_id' => $merchant_id));
				
				if(count($merchant) == 0){
					throw new Exception("Merchant not found");
				}
			}

			if($process == 'edit'){
				if(empty($product_id)){
					throw new Exception("No menu selected");
				}
			
				$product = $this->Product_model->get(array('id' => $product_id))->row();
				
				if(count($product) == 0){
					throw new Exception("Product not found");
				}
			}

			if(empty($category_id)){
				throw new Exception("Category cannot be empty");
			}

			if(empty($product_name)){
				throw new Exception("Product name cannot be empty");
			}

			if(!empty($product_image)){
				$image_file   	= time().rand(1111,9999).".png";
	      	$decoded_image = base64_decode($product_image);
	      	$upload_image 	= file_put_contents('./uploads/product/'.$image_file, $decoded_image);
			
	      	if($upload_image === false){
	      		throw new Exception("Error uploading image");
	      	}
	      }	

			$now = date('Y-m-d H:i:s');

			$data = array(
				'merchant_id'				=> $merchant_id,
				'product_name'			=> $product_name,
				'category_id'				=> $category_id,
				'product_desc'			=> $product_desc,
				'product_price'			=> $product_price,
				'user_id'						=> $user_id,
				'product_input_date'=> $now
			);

			if($process == 'add'){
				$data['product_image'] = isset($image_file) ? $image_file : 'no_image.png';
				$do_process = $this->Product_model->add($data);
			}else{
				unset($data['merchant_id'],$data['product_input_date']);
				if(isset($image_file)){
					$data['product_image'] = $image_file; 
				}	
				$data['product_last_update'] = $now;
				$do_process = $this->Product_model->add($data,array('product_id' => $product_id));
			}

			if($do_process){
				$return = $process == 'add' ? array('product_id' => $do_process) : 'OK';
				$this->response(REST_Controller::Success_($return));
			}else{
				throw new Exception("Error Processing Request");
			}
		}catch(Exception $e){
			$this->response(REST_Controller::Exception_($e));
		}
	}

}

/* End of file Product.php */
/* Location: ./application/controllers/api/Product.php */