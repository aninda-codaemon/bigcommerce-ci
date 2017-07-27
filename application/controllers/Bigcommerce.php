<?php
	/**
	* 
	*/
	class Bigcommerce extends CI_Controller
	{
		protected $_per_page;
		public function __construct()
		{
			# code...
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('App_model', 'app');
			$this->load->model('User_model', 'user');
			$this->load->model('Order_model', 'order');

			$this->_per_page = 50;
		}

		public function index(){
			show_404();
		}

		/**
	    * Function to direct the oauth
	    * landing page for the 
	    * for bigcommerce app
	    * Method: GET
	    **/
		public function get_app_install(){
			//echo '<pre>';
			//print_r($_GET);			
			
			//Making the POST request
			$url = 'https://login.bigcommerce.com/oauth2/token';
			//$header = array('Content-Type: application/x-www-form-urlencoded', 'Access-Control-Allow-Origin: *');
			$header = array('Content-Type: application/json');
			$method = 'POST';
			$params = array(
							'client_id' => 'mwshyzp578qge171a6csxn4st4836si',
							'client_secret' => 'gxx32k0karuq1yb1k2j03zz5xpoewgh',
							'code' => $this->input->get('code', true),
							'scope' => $this->input->get('scope', true),
							'grant_type' => 'authorization_code',
							'redirect_uri' => "https://shopify.shoptradeonline.com/shoptradeapp/bigcommerce/get_app_install",
							'context' => $this->input->get('context', true)
						);

			$response = $this->_call_api($url, $method, $params, $header);
			$dataToken = json_decode($response, true);
			//print_r(json_decode($response, true));

			$insertData = [
							'store_context' => $dataToken['context'],
							'store_scope' => $dataToken['scope'],
							'store_token' => $dataToken['access_token'],
							'store_username' => $dataToken['user']['username'],
							'store_email' => $dataToken['user']['email'],
							'store_id' => $dataToken['user']['id'],
							'store_status' => 1
						];

			//check if store data is already exist or not
			$storeExist = $this->app->check_store_already_installed($insertData);

			if ($storeExist > 0){
				//update the store data in tables				
				$storeupdate = $this->app->update_store_details($insertData);
			}else{
				//insert the store data in tables				
				$storeid = $this->app->save_store_details($insertData);	
			}
			
			$this->session->set_userdata('store_context', $dataToken['context']);

			//check if user is registered for a store
			$user_signed = $this->user->check_store_user_exist_store_context($dataToken['context']);

			if ($user_signed > 0){
				redirect('bigcommerce/orders', 'Location');
				die();
			}else{
				redirect('bigcommerce/registration', 'Location');
				die();
			}

			// $api_url = 'https://api.bigcommerce.com/'.$dataToken['context'].'/v3/catalog/products?include=variants,custom_fields';
			// $header = array('Accept: application/json', 'X-Auth-Client: mwshyzp578qge171a6csxn4st4836si', 'X-Auth-Token: '.$dataToken['access_token'].'');
			// $allProducts = $response = $this->_call_api($api_url, 'GET', [], $header);
			// print_r($allProducts);
			//$this->load->view('bigcommerce', ['data' =>$params]);

		}
		
		public function app_launch(){
			// Get cURL resource
			//echo '<pre>';
			//echo '<h1>App Launch</h1>';
			//print_r($_GET);
			$signedRequest = $this->input->get('signed_payload', true);
			list($encodedData, $encodedSignature) = explode('.', $signedRequest, 2);

			// decode the data
    		$signature = base64_decode($encodedSignature);
        	$jsonStr = base64_decode($encodedData);
    		$data = json_decode($jsonStr, true);

    		//print_r($data);

    		$this->session->set_userdata('store_context', $data['context']);

    		//check if user is registered for a store
			$user_signed = $this->user->check_store_user_exist_store_context($data['context']);
			
			if ($user_signed > 0){
				redirect('bigcommerce/orders', 'Location');
				die();
			}else{
				redirect('bigcommerce/registration', 'Location');
				die();
			}
		}

		/**
	    * Function to display the register form 
	    * to bigcommerce merchant to KTC app
	    * Method : GET
	    **/		
		public function registration(){
			$storeArray = $this->app->get_store_info_by_context($this->session->userdata('store_context'));
			
			$this->load->view('layout/big_register', ['store_info' => $storeArray]);
		}

		/**
	    * Function to register the bigcommerce
	    * merchant to KTC app
	    * Method : POST
	    **/
	    public function signup_user() {

	    	//echo '<pre>';print_r($_POST);die();

	        $userdata = $this->input->post();
	        $user_id = $userdata['userid'];
	        $sign_up['account']['tos'] = "1";
	        $sign_up['account']['first_name'] = $userdata['fn'];
	        $sign_up['account']['last_name'] = $userdata['ln'];
	        $sign_up['user']['email'] = $userdata['email'];
	        $sign_up['user']['password'] = $userdata['pwd'];
	        $sign_up['user']['password_confirmation'] = $userdata['rpwd'];
	        $sign_up['user']['password_confirmation'] = $userdata['rpwd'];
	        $sign_up['subscription_plan_name'] = '0_1_month_freemium_limit_10_shopify_knowthycustomer';
	        $sign_up['business_contact']['contact_phone'] = $userdata['phone'];
	        $sign_up['business_contact']['company'] = $userdata['cmpny'];
	        $sign_up['business_contact']['job_title'] = $userdata['jobt'];        
	        
	        //echo '<pre>';
	        //print_r($sign_up);die();

	        ////Get the user details/////
	        //$signed_up = $this->user->get_user_info_by_email($userdata['email']);
	        $signed_up = '';

	        if(empty($signed_up)) {

	            ///// Sign up new user on knowthycustomer site using API /////
	            $header = array('Content-Type: application/json');
	            $url = 'https://www.knowthycustomer.com/api/v4/account.json';
	            $res = $this->_call_api($url, 'POST', $sign_up, $header);
	            $res = json_decode($res);
	            
	            ///// Sign up - end /////
	            if($res->meta->status == 200) {
	                $user_data = array(
	                	'store_id' => $user_id,
		                'first_name' => $userdata['fn'],
		                'last_name' => $userdata['ln'],
		                'email' => $userdata['email'],
		                'phone' => $userdata['phone'],
		                'password' => md5($userdata['pwd']),
		                'company' => $userdata['cmpny'],
		                'job_title' => $userdata['jobt'],
		                'signup_flag' => 1,
	                );

	                ///Update the user details /////
	                echo $this->user->save_user_details($user_data);
	            }
	        }

	        ///// Redirect to the orders page after signup //////	        
	        redirect('bigcommerce/orders', 'Location');
	        die();
	    }

		public function orders(){
			error_reporting(E_ERROR);
			//echo '<pre>';
			// echo 'Store context: ' . $this->session->userdata('store_context');

			$store_context = $this->session->userdata('store_context');

			if (empty($store_context))
			{
				show_404();
				die();
			}

			//get store information from context
			$store_info = $this->app->get_store_info_by_context($store_context);
			//print_r($store_info);

			$api_url = 'https://api.bigcommerce.com/stores/ogyyko1meq/v2/orders.json';
			$header = array('Content-Type: application/json', 'X-Auth-Client: mwshyzp578qge171a6csxn4st4836si', 'X-Auth-Token: '.$store_info['store_token']);
			$method = 'GET';
			$params = [];
			$allOrders = $this->_call_api($api_url, $method, $params, $header);

			if (empty($allOrders)){
				echo 'No orders';
			}else{
				//var_dump($allOrders);
				//$decodedText = html_entity_decode($allOrders);
				//$allOrders = json_decode($allOrders, true);
				//print_r($allOrders);
				//echo json_last_error();
				//$responseText = $this->object_to_array($allOrders);
				//print_r($responseText);

				//$all = (object) $allOrders;
				//print_r(json_decode($allOrders, true));
				//echo gettype(json_decode($all, TRUE));

				//$ft = json_decode(html_entity_decode(urldecode(filter_input($allOrders, 'ft', FILTER_SANITIZE_STRING))));
				//var_dump($ft);

				$tmp = json_decode($allOrders, true);

				$responseOrders = array();

				foreach ($tmp as $row) {
					# code...					

					if (!empty($row['shipping_addresses'])){
						$ship_url = $row['shipping_addresses']['url'];
						$header = array('Accept: application/json', 'X-Auth-Client: mwshyzp578qge171a6csxn4st4836si', 'X-Auth-Token: '.$store_info['store_token']);
						$method = 'GET';
						$params = [];
						$shipAddress = $this->_call_api($ship_url, $method, $params, $header);						
						$row['ship_addr'] = json_decode($shipAddress, true);
					}

					$orderArray			= array(
												'store_id' => $store_info['id'],
												'increment_id' => $row['id'],
												'base_currency_code' => $row['default_currency_code'],
												'customer_email' => $row['billing_address']['email'],
												'customer_firstname' => $row['billing_address']['first_name'],
												'customer_lastname' => $row['billing_address']['last_name'],
												'customer_moddlename' => '',
												'store_name' => '',
												'order_create_date' => $row['date_created'],
												'shipping_description' => '',
												'base_grand_total' => $row['total_inc_tax'],
												'discount_amount' => $row['discount_amount'],
												'total_qty_ordered' => $row['items_total'],
												'customer_id' => $row['customer_id'],
												'order_description' => serialize(json_encode($row))
											);

					$addressArray		= array(
												'shipping_region' => $row['ship_addr'][0]['state'],
												'shipping_postcode' => $row['ship_addr'][0]['zip'],
												'shipping_firstname' => $row['ship_addr'][0]['first_name'],
												'shipping_lastname' => $row['ship_addr'][0]['last_name'],
												'shipping_street' => $row['ship_addr'][0]['street_1'],
												'shipping_city' => $row['ship_addr'][0]['city'],
												'shipping_email' => $row['ship_addr'][0]['email'],
												'shipping_telephone' => $row['ship_addr'][0]['phone'],
												'shipping_country_id' => $row['ship_addr'][0]['country'],											
												'billing_region' => $row['billing_address']['state'],
												'billing_postcode' => $row['billing_address']['zip'],
												'billing_lastname' => $row['billing_address']['last_name'],
												'billing_firstname' => $row['billing_address']['first_name'],
												'billing_street' => $row['billing_address']['street_1'],
												'billing_city' => $row['billing_address']['city'],
												'billing_email' => $row['billing_address']['email'],
												'billing_telephone' => $row['billing_address']['phone'],
												'billing_country_id' => $row['billing_address']['country'],
											);
					
					//check if order already exist or not
					$order_exist 		= $this->order->check_order_exist_store_increment($store_info['id'], $row['id']); 

					if ($order_exist > 0){
						//update the order details
						$this->order->update_order_details($orderArray, $addressArray, $store_info['id'], $row['id']);
					}else{
						//save the order details
						$this->order->save_order_details($orderArray, $addressArray);
					}

					$responseOrders[] = $row;
				}

				//print_r($responseOrders);
				//die();

				//get all orders for the store
				$page               		= 1;
				//get total records        
		        $total_activity     		= $this->order->get_total_order_store_by_store_id($store_info['id']);        
		        $per_page           		= $this->_per_page;
		        $total_page         		= floor($total_activity/$per_page);
		        $current_page       		= ($page - 1) * $per_page;
		        $next_page          		= $page + 1;

		        $all_orders      			= $this->order->get_all_order_details_store($store_info['id'], $current_page, $per_page);		        

		        //echo $this->input->ip_address().' IP';die();

				//$this->load->view('layout/order_listing', ['store_info' => $store_info, 'all_orders' => $all_orders, 'lastid' => 0, 'total_page' => $total_page, 'current_page' => $page, 'next_page' => $next_page]);
				$this->load->view('layout/big_order_listing', ['store_info' => $store_info, 'all_orders' => $all_orders, 'lastid' => 0, 'total_page' => $total_page, 'current_page' => $page, 'next_page' => $next_page, 'ip_address' => $this->get_client_ip()]);
			}
		}

		public function ajax_get_order_page(){
			$page               		= $this->input->post('page', true);;
	        $store_context 				= $this->session->userdata('store_context');

			//get store information from context
			$store_info 				= $this->app->get_store_info_by_context($store_context);
	        
	        //get total records        
	        $total_activity     		= $this->order->get_total_order_store_by_store_id($store_info['id']);
	        $per_page           		= $this->_per_page;
	        $total_page         		= floor($total_activity/$per_page);
	        $current_page       		= ($page-1)*$per_page;
	        $next_page          		= $page + 1;        
	        
	        $all_orders      			= $this->order->get_all_order_details_store($store_info['id'], $current_page, $per_page);

	        $page_data          		= $this->load->view('layout/ajax_order_table_data', ['store_info' => $store_info, 'all_orders' => $all_orders, 'lastid' => 0, 'total_page' => $total_page, 'current_page' => $page, 'next_page' => $next_page, 'ip_address' => $this->get_client_ip()], true);   

	        $response           		= array(
		                                    'total_activity' => $total_activity,
		                                    'total_page' => $total_page,
		                                    'current_page' => $page,
		                                    'next_page' => $next_page,
		                                    'page_data' => $page_data
		                                );

	        echo json_encode($response);
		}

		/**
	    * Function to call the curl
	    * for the api
	    * $url : string
	    * $method : string
	    * $data : array
	    **/
	    private function _call_api($url, $method, $data = array(), $headers = array()) {
	        $curl = curl_init();
	        curl_setopt($curl, CURLOPT_URL, $url);
	        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	        curl_setopt($curl, CURLOPT_VERBOSE, 0);
	        //curl_setopt($curl, CURLOPT_HEADER, 0);
	        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

	        if($method == 'POST'){
	        	curl_setopt($curl, CURLOPT_POST, 1);
	            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
	        }

	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	        $response = curl_exec($curl);

	        //print_r($response);
	        //print_r(curl_error($curl));
	        //print_r(curl_errno($curl));

	        curl_close ($curl);
	        return $response;
	    }
	    
	    // Function to get the client IP address
	    public function get_client_ip() {

	    	return $this->input->ip_address();

	           $ipaddress = '';
	        if ($_SERVER['HTTP_CLIENT_IP'])
	            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	        else if($_SERVER['HTTP_X_FORWARDED_FOR'])
	            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	        else if($_SERVER['HTTP_X_FORWARDED'])
	            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	        else if($_SERVER['HTTP_FORWARDED_FOR'])
	            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	        else if($_SERVER['HTTP_FORWARDED'])
	            $ipaddress = $_SERVER['HTTP_FORWARDED'];
	        else if($_SERVER['REMOTE_ADDR'])
	            $ipaddress = $_SERVER['REMOTE_ADDR'];
	        else
	            $ipaddress = 'UNKNOWN';
	        $ip = substr($ipaddress, 0, strpos($ipaddress, ','));
	        return $ip;
	    }
	}
?>