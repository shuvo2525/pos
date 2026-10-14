<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_model extends CI_Model {

	var $table = 'db_store a';
	var $column_order = array(
								'a.id',
								'a.store_code',
								'a.store_name',
								'a.mobile',
								'a.address',
								'a.created_date',
								'a.created_by',
								'b.package_name',
								'b.expire_date',
								'a.status'); //set column field database for datatable orderable

	var $column_search = array(
								'a.id',
								'a.store_code',
								'a.store_name',
								'a.mobile',
								'a.address',
								'a.created_date',
								'a.created_by',
								'b.package_name',
								'b.expire_date',
								'a.status',
								); //set column field database for datatable searchable 

	var $order = array('a.id' => 'desc'); // default order 

	private function _get_datatables_query()
	{
		$this->db->select("a.*, b.package_name, b.expire_date, b.payment_status, b.package_type, b.package_status, b.id as subscription_id");
		$this->db->from($this->table);

		$this->db->join('db_subscription b','b.id=a.current_subscriptionlist_id','left');
		//$this->db->join('db_package c','c.id=a.package_id','left');

		//echo $this->db->get_compiled_select();exit;

		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function store_making_codes(){
		 /*Create Store Code*/
		$this->db->query("ALTER TABLE db_store AUTO_INCREMENT = 1");
        $store_id=$this->db->query('select max(id)+1 as store_id from db_store')->row()->store_id;
		$data = array();
        $data['store_code'] = 'ST'.str_pad($store_id, 4, '0', STR_PAD_LEFT);
        $data['category_init'] ="CT"."/".str_pad($store_id, 2, '0', STR_PAD_LEFT)."/";
        $data['item_init'] ="IT".str_pad($store_id, 2, '0', STR_PAD_LEFT);
        $data['supplier_init'] ="SU"."/".str_pad($store_id, 2, '0', STR_PAD_LEFT)."/";
        $data['purchase_init'] ="PU"."/".date("Y")."/".str_pad($store_id, 2, '0', STR_PAD_LEFT)."/";
        $data['purchase_return_init'] ="PR"."/".date("Y")."/".str_pad($store_id, 2, '0', STR_PAD_LEFT)."/";
        $data['customer_init'] ="CU"."/".str_pad($store_id, 2, '0', STR_PAD_LEFT)."/";
        $data['sales_init'] ="SL"."/".date("Y")."/".str_pad($store_id, 2, '0', STR_PAD_LEFT)."/";
        $data['sales_return_init'] ="SR"."/".date("Y")."/".str_pad($store_id, 2, '0', STR_PAD_LEFT)."/";
        $data['expense_init'] ="EX"."/".date("Y")."/".str_pad($store_id, 2, '0', STR_PAD_LEFT)."/";
        $data['accounts_init'] ="AC"."/".str_pad($store_id, 2, '0', STR_PAD_LEFT)."/";
        $data['quotation_init'] ="QT"."/".date("Y")."/".str_pad($store_id, 2, '0', STR_PAD_LEFT)."/";
        $data['money_transfer_init'] ="MT"."/".str_pad($store_id, 2, '0', STR_PAD_LEFT)."/";
        $data['sales_payment_init'] ="SP"."/".date("Y")."/".str_pad($store_id, 2, '0', STR_PAD_LEFT)."/";
        $data['sales_return_payment_init'] ="SRP"."/".date("Y")."/".str_pad($store_id, 2, '0', STR_PAD_LEFT)."/";
        $data['purchase_payment_init'] ="PP"."/".date("Y")."/".str_pad($store_id, 2, '0', STR_PAD_LEFT)."/";
        $data['purchase_return_payment_init'] ="PRP"."/".date("Y")."/".str_pad($store_id, 2, '0', STR_PAD_LEFT)."/";
        $data['expense_payment_init'] ="XP"."/".date("Y")."/".str_pad($store_id, 2, '0', STR_PAD_LEFT)."/";
        $data['cust_advance_init'] ="ADV"."/".date("Y")."/".str_pad($store_id, 2, '0', STR_PAD_LEFT)."/";
        $data['language_id'] =1;
        $data['sales_discount'] =0;
        $data['change_return'] =1;
        $data['mrp_column'] =1;
        $data['show_signature'] =0;
        $data['previous_balance_bit'] =1;
        $data['round_off'] =1;
        $data['sales_invoice_format_id'] =3;
        $data['pos_invoice_format_id'] =1;
        $data['sales_invoice_footer_text'] ='This is footer text. It is in Store Management.';
        $data['invoice_terms'] ='';
        $data['t_and_c_status'] =1;
        $data['t_and_c_status_pos'] =1;
        $data['qty_decimals'] =2;
        $data['number_to_words'] ='Default';
        $data['default_account_id'] ='';
        return $data;
	}

	public function create_url_sms_api($store_id){
		$q1=$this->db->select("*")->where("store_id",$store_id)->get("db_smsapi");
		if($q1->num_rows()==0){
			$insertArray = [
			   [
			      'store_id' => $store_id,
			      'info' => 'url',
			      'key' => 'weblink',
			      'key_value' => 'http://example.com/sendmessage',
			   ],
			   [
			      'store_id' => $store_id,
			      'info' => 'mobile',
			      'key' => 'mobiles',
			      'key_value' => '',
			   ],
			   [
			      'store_id' => $store_id,
			      'info' => 'message',
			      'key' => 'message',
			      'key_value' => '',
			   ],
			   
			];
			if(!$this->db->insert_batch('db_smsapi', $insertArray)){
				return false;
			}
		}
		return true;
	}

	public function create_url_sms_templates($store_id){
		$q1=$this->db->select("*")->where("store_id",$store_id)->get("db_smstemplates");
		if($q1->num_rows()==0){
			$insertArray = [
			   [
			      'store_id' => $store_id,
			      'template_name' => 'GREETING TO CUSTOMER ON SALES',
			      'content' => "Hi {{customer_name}},
Your sales Id is {{sales_id}},
Sales Date {{sales_date}},
Total amount  {{sales_amount}},
You have paid  {{paid_amt}},
and due amount is  {{due_amt}}
Thank you Visit Again",
			      'variables' => "{{customer_name}}                          
{{sales_id}}
{{sales_date}}
{{sales_amount}}
{{paid_amt}}
{{due_amt}}
{{store_name}}
{{store_mobile}}
{{store_address}}
{{store_website}}
{{store_email}}
",
				'status'	=> 1,
				'undelete_bit'	=> 1,
			   ],
			   [
			      'store_id' => $store_id,
			      'template_name' => 'GREETING TO CUSTOMER ON SALES RETURN',
			      'content' => "Hi {{customer_name}},
Your sales return Id is {{return_id}},
Return Date {{return_date}},
Total amount  {{return_amount}},
We paid  {{paid_amt}},
and due amount is  {{due_amt}}
Thank you Visit Again",
			      'variables' => "{{customer_name}}                          
{{return_id}}
{{return_date}}
{{return_amount}}
{{paid_amt}}
{{due_amt}}
{{company_name}}
{{company_mobile}}
{{company_address}}
{{company_website}}
{{company_email}}
",
				'status'	=> 1,
				'undelete_bit'	=> 1,
			   ],
			   
			];
			if(!$this->db->insert_batch('db_smstemplates', $insertArray)){
				return false;
			}
		}
		return true;
	}

	public function save_registration(){
		extract($this->security->xss_clean(html_escape(array_merge($this->data,$this->store_making_codes(),$_POST,$_GET))));
		$country = $this->db->select("country")->where("id",$country)->get("db_country")->row()->country;
		$state = $this->db->select("state")->where("id",$state)->get("db_states")->row()->state;

		$this->db->query("ALTER TABLE db_store AUTO_INCREMENT = 1");
		$this->db->trans_begin();
		$data = array(
		    				'store_code'				=> $store_code,
		    				'store_name'				=> $store_name,
		    				'store_website'				=> '',
		    				'mobile'					=> $mobile,
		    				'phone'						=> '',
		    				'email'						=> $email,
		    				'country'					=> $country,
		    				'state'						=> $state,
		    				'city'						=> $city,
		    				'address'					=> ' ',
		    				'postcode'					=> '',
		    				'bank_details'				=> '',
		    				'category_init'				=> $category_init,
		    				'item_init'					=> $item_init,
		    				'supplier_init'				=> $supplier_init,
		    				'purchase_init'				=> $purchase_init,
		    				'purchase_return_init'		=> $purchase_return_init,
		    				'customer_init'				=> $customer_init,
		    				'sales_init'				=> $sales_init,
		    				'sales_return_init'			=> $sales_return_init,
		    				'expense_init'				=> $expense_init,
		    				'quotation_init'			=> $quotation_init,
		    				'money_transfer_init'		=> $money_transfer_init,
		    				'accounts_init'				=> $accounts_init,
		    				'currency_id'				=> $currency,
		    				'currency_placement'		=> $currency_placement,
		    				'timezone'					=> $timezone,
		    				'date_format'				=> $date_format,
		    				'date_format'				=> $date_format,
		    				'time_format'				=> $time_format,
		    				'sales_discount'			=> $sales_discount,
		    				'change_return'				=> $change_return,
		    				'mrp_column'				=> $mrp_column,
		    				'show_signature'				=> $show_signature,
		    				'previous_balance_bit'		=> $previous_balance_bit,
		    				'sales_invoice_format_id'	=> $sales_invoice_format_id,
		    				'pos_invoice_format_id'		=> $pos_invoice_format_id,
		    				'sales_invoice_footer_text'	=> $sales_invoice_footer_text,
		    				'invoice_terms'				=> $invoice_terms,
		    				'round_off'					=> $round_off,
		    				'decimals'					=> $decimals,
		    				'qty_decimals'					=> $qty_decimals,
		    				'sales_payment_init'		=> $sales_payment_init,
		    				'sales_return_payment_init'	=> $sales_return_payment_init,
		    				'purchase_payment_init'		=> $purchase_payment_init,
		    				'purchase_return_payment_init'	=> $purchase_return_payment_init,
		    				'expense_payment_init'	=> $expense_payment_init,
		    				'cust_advance_init'	=> $cust_advance_init,
		    			);

		if(isset($sidebar_color) && !empty($sidebar_color)){
			$data['sidebar_color']=$sidebar_color;
		}
		if(isset($sidebar_font_color) && !empty($sidebar_font_color)){
			$data['sidebar_font_color']=$sidebar_font_color;
		}
		if(isset($sidebar_active_color) && !empty($sidebar_active_color)){
			$data['sidebar_active_color']=$sidebar_active_color;
		}
		if(isset($sidebar_submenu_color)){
			$data['sidebar_submenu_color']=$sidebar_submenu_color;
		}
		if(isset($sidebar_submenu_hover_color)){
			$data['sidebar_submenu_hover_color']=$sidebar_submenu_hover_color;
		}


		
			$store_code_count=$this->db->query("select count(*) as store_code_count from db_store where upper(store_code)=upper('$store_code')")->row()->store_code_count;
			if($store_code_count>0){
				echo "Sorry! Store Code Already Exist!\nPlease Change Store Code";exit();
			}
			$extra_info = array(
							'invoice_view'				=> 1,
		    				'sms_status'				=> 0,
		    				'language_id'				=> $language_id,
		    				/*System Info*/
		    				'created_date' 				=> $CUR_DATE,
		    				'created_time' 				=> $CUR_TIME,
		    				'created_by' 				=> $first_name,
		    				'system_ip' 				=> $SYSTEM_IP,
		    				'system_name' 				=> $SYSTEM_NAME,
		    				'status' 					=> 1,
		    			);

			$data=array_merge($data,$extra_info);
			
			$q1 = $this->db->insert('db_store', $data);
			if(!$q1){
				echo "failed";exit();
			}

			$store_id = $this->db->insert_id();
			$this->load->model('customers_model');

			$q2=$this->customers_model->create_walk_in_customer($store_id);

			$q3 = $this->create_default_warehouse($store_id,null,null);
			if(!$q3){
				echo "failed";exit();
			}

			//Create User
			if(!empty($email)){
			$query=$this->db->query("select * from db_users where email='$email'")->num_rows();
			if($query>0){ return "This Email ID already exist.";}
			}
			$info = array(
			    				'username' 				=> $first_name, 
			    				'last_name' 			=> $last_name, 
			    				'password' 				=> md5($password), 
			    				'mobile' 				=> $mobile,
			    				'email' 				=> $email,
			    				/*System Info*/
			    				'created_date' 			=> $CUR_DATE,
			    				'created_time' 			=> $CUR_TIME,
			    				'created_by' 			=> $CUR_USERNAME,
			    				'system_ip' 			=> $SYSTEM_IP,
			    				'system_name' 			=> $SYSTEM_NAME,
			    				'status' 				=> 1,
			    			);
			if(!empty($profile_picture)){
				$info['profile_picture'] = $profile_picture;
			}
			
			$info['role_id'] = store_admin_id();
			
			$info['store_id']=(store_module()) ? $store_id : $this->session->userdata('store_id');	
			$q1 = $this->db->insert('db_users', $info);
			if (!$q1){
				return "failed";
			}
			$user_id = $this->db->insert_id();

			//Update default warehouse id

			$warehouse_id = $this->db->select("id")->where("store_id",$store_id)->get("db_warehouse")->row()->id;

			$this->db->set("default_warehouse_id", $warehouse_id)->where("id",$user_id)->update("db_users");

			//UPDATE THE USER ID INTO STORE
			$this->db->set("user_id",$user_id)
						->where("id",$store_id)
						->update("db_store");
						
			if(warehouse_module() && isset($_POST['warehouses']) && $role_id!=1 && $role_id!=store_admin_id()){
				$warehouses_list = sizeof($_POST['warehouses']);
				foreach ($_POST['warehouses'] as $res => $val) {
					$warehouse_info = array ( 'user_id'=> $user_id, 'warehouse_id'=>$val );
					$q2 = $this->db->insert("db_userswarehouses",$warehouse_info);
					if (!$q2){
						return "failed";
					}
				}
			}

			if(!$this->create_url_sms_api($store_id)){
				return "failed";
			}
			if(!$this->create_url_sms_templates($store_id)){
				return "failed";
			}
			$this->load->helper('accounts');
			create_default_accounts($store_id);
			
			// Automatically create and link initial subscription package
			$this->create_initial_store_subscription($store_id);

			$this->db->trans_commit();
			$this->session->set_flashdata('success', 'Account created Succssfully!! Please Login!');
			return "success";
			

		
	}
	public function verify_and_save(){

		//Filtering XSS and html escape from user inputs 
		extract($this->security->xss_clean(html_escape(array_merge($this->data,$_POST,$_GET))));
		
		$this->db->trans_begin();

		
		$store_logo='';
		if(!empty($_FILES['store_logo']['name'])){
			$config['upload_path']          = './uploads/store/';
	        $config['allowed_types']        = 'gif|jpg|jpeg|png';
	        $config['max_size']             = 1000;
	        $config['max_width']            = 1000;
	        $config['max_height']           = 1000;

	        $this->load->library('upload', $config);

	        if ( ! $this->upload->do_upload('store_logo'))
	        {
	                $error = array('error' => $this->upload->display_errors());
	                return $error['error'];
	                exit();
	        }
	        else
	        {
	        	   $store_logo='uploads/store/'.$this->upload->data('file_name');
	        }
		}

		$signature='';
		if(!empty($_FILES['signature']['name'])){
			$config['upload_path']          = './uploads/signature/';
	        $config['allowed_types']        = 'gif|jpg|jpeg|png';
	        $config['max_size']             = 1000;
	        $config['max_width']            = 1000;
	        $config['max_height']           = 1000;

	        $this->load->library('upload', $config);

	        if ( ! $this->upload->do_upload('signature'))
	        {
	                $error = array('error' => $this->upload->display_errors());
	                return $error['error'];
	                exit();
	        }
	        else
	        {
	        	   $signature='uploads/signature/'.$this->upload->data('file_name');
	        }
		}

		$change_return = (isset($change_return)) ? 1 : 0;
		$mrp_column = (isset($mrp_column)) ? 1 : 0;
		$show_signature = (isset($show_signature)) ? 1 : 0;
		$previous_balance_bit = (isset($previous_balance_bit)) ? 1 : 0;
		$round_off = (isset($round_off)) ? 1 : 0;


		$data = array(
		    				'store_code'				=> $store_code,
		    				'store_name'				=> $store_name,
		    				'store_website'				=> $store_website,
		    				'mobile'					=> $mobile,
		    				'phone'						=> $phone,
		    				'email'						=> $email,
		    				'country'					=> $country,
		    				'state'						=> $state,
		    				'city'						=> $city,
		    				'address'					=> $address,
		    				'postcode'					=> $postcode,
		    				'bank_details'				=> $bank_details,
		    				'category_init'				=> $category_init,
		    				'item_init'					=> $item_init,
		    				'supplier_init'				=> $supplier_init,
		    				'purchase_init'				=> $purchase_init,
		    				'purchase_return_init'		=> $purchase_return_init,
		    				'customer_init'				=> $customer_init,
		    				'sales_init'				=> $sales_init,
		    				'sales_return_init'			=> $sales_return_init,
		    				'expense_init'				=> $expense_init,
		    				'quotation_init'			=> $quotation_init,
		    				'money_transfer_init'		=> $money_transfer_init,
		    				'accounts_init'				=> $accounts_init,
		    				'currency_id'				=> $currency,
		    				'currency_placement'		=> $currency_placement,
		    				'timezone'					=> $timezone,
		    				'date_format'				=> $date_format,
		    				'date_format'				=> $date_format,
		    				'time_format'				=> $time_format,
		    				'sales_discount'			=> $sales_discount,
		    				'sales_discount'			=> $sales_discount,
		    				'change_return'				=> $change_return,
		    				'mrp_column'				=> $mrp_column,
		    				'show_signature'				=> $show_signature,
		    				'previous_balance_bit'				=> $previous_balance_bit,
		    				'sales_invoice_format_id'	=> $sales_invoice_format_id,
		    				'pos_invoice_format_id'		=> $pos_invoice_format_id,
		    				'sales_invoice_footer_text'	=> $sales_invoice_footer_text,
		    				'invoice_terms'				=> $invoice_terms,
		    				'round_off'					=> $round_off,
		    				'decimals'					=> $decimals,
		    				'qty_decimals'					=> $qty_decimals,
		    				'sales_payment_init'		=> $sales_payment_init,
		    				'sales_return_payment_init'	=> $sales_return_payment_init,
		    				'purchase_payment_init'		=> $purchase_payment_init,
		    				'purchase_return_payment_init'	=> $purchase_return_payment_init,
		    				'expense_payment_init'	=> $expense_payment_init,
		    				'cust_advance_init'	=> $cust_advance_init,
		    				't_and_c_status'	=> $t_and_c_status,
		    				't_and_c_status_pos'	=> $t_and_c_status_pos,
		    				'number_to_words'	=> $number_to_words,
		    				'default_account_id'	=> (!empty($default_account_id))?$default_account_id:null,
		    			);

		if(!empty($store_logo)){
			$data['store_logo']=$store_logo;
		}

		if(!empty($signature)){
			$data['signature']=$signature;
		}

		if(isset($sidebar_color) && !empty($sidebar_color)){
			$data['sidebar_color']=$sidebar_color;
		}
		if(isset($sidebar_font_color) && !empty($sidebar_font_color)){
			$data['sidebar_font_color']=$sidebar_font_color;
		}
		if(isset($sidebar_active_color) && !empty($sidebar_active_color)){
			$data['sidebar_active_color']=$sidebar_active_color;
		}
		if(isset($sidebar_submenu_color)){
			$data['sidebar_submenu_color']=$sidebar_submenu_color;
		}
		if(isset($sidebar_submenu_hover_color)){
			$data['sidebar_submenu_hover_color']=$sidebar_submenu_hover_color;
		}

		/*custom helper*/
		if(gst_number()){
			$data['gst_no']=$gst_no;
		}
		if(vat_number()){
			$data['vat_no']=$vat_no;
		}
		if(pan_number()){
			$data['pan_no']=$pan_no;
		}
		/*end*/

		


		if($command=='save'){
			$store_code_count=$this->db->query("select count(*) as store_code_count from db_store where upper(store_code)=upper('$store_code')")->row()->store_code_count;
			if($store_code_count>0){
				echo "Sorry! Store Code Already Exist!\nPlease Change Store Code";exit();
			}

			// Validate mandatory setup charge (even if 0, must be provided and >= 0)
			if(!isset($_POST['setup_charge']) || trim($_POST['setup_charge']) === '' || floatval($_POST['setup_charge']) < 0){
				echo "Setup charge is mandatory (enter 0 if no setup fee)!";
				exit();
			}

			// If Paid plan with payment gateway, store starts as 0 and activates immediately upon payment confirmation.
			// Direct Save by Super Admin starts active immediately.
			$initial_store_status = (isset($_POST['pay_via_gateway']) && $_POST['pay_via_gateway'] == 1 && isset($_POST['store_package_type']) && $_POST['store_package_type'] == 'Paid') ? 0 : 1;

			$extra_info = array(
							'invoice_view'				=> 1,
		    				'sms_status'				=> 0,
		    				'language_id'				=> $language_id,
		    				/*System Info*/
		    				'created_date' 				=> $CUR_DATE,
		    				'created_time' 				=> $CUR_TIME,
		    				'created_by' 				=> $CUR_USERNAME,
		    				'system_ip' 				=> $SYSTEM_IP,
		    				'system_name' 				=> $SYSTEM_NAME,
		    				'status' 					=> $initial_store_status,
		    			);
			$data=array_merge($data,$extra_info);
			$q1 = $this->db->insert('db_store', $data);
			$store_id = $this->db->insert_id();
			$this->load->model('customers_model');
			$q2=$this->customers_model->create_walk_in_customer($store_id);

			if(!$this->create_url_sms_api($store_id)){
				return "failed";
			}
			if(!$this->create_url_sms_templates($store_id)){
				return "failed";
			}
			$q3 = $this->create_default_warehouse($store_id,null,null);
			if(!$q3){
				echo "failed";exit();
			}

			// Automatically create and link initial subscription package
			$this->create_initial_store_subscription($store_id);

			$this->load->helper('accounts');
			create_default_accounts($store_id);

			if($q1){
				$this->db->trans_commit();
				if(isset($_POST['pay_via_gateway']) && $_POST['pay_via_gateway'] == 1 && isset($_POST['store_package_type']) && $_POST['store_package_type'] == 'Paid'){
					$pkg_id = isset($_POST['selected_package_id']) ? intval($_POST['selected_package_id']) : 1;
					echo "redirect:" . base_url('online_payments/buy_package/paypal/' . $pkg_id . '/' . $store_id);
					exit();
				}
				$this->session->set_flashdata('success', 'Success!! Store Created Successfully! Note: Direct Save requires Super Admin permission/authorization to become active.');
				echo "success";
			}

		}
		
		exit();
	}

	public function create_initial_store_subscription($store_id){
		$store_package_type = isset($_POST['store_package_type']) ? trim($_POST['store_package_type']) : 'Free';
		$selected_package_id = isset($_POST['selected_package_id']) ? intval($_POST['selected_package_id']) : 0;
		$billing_cycle = isset($_POST['billing_cycle']) ? trim($_POST['billing_cycle']) : 'monthly';
		$setup_charge = isset($_POST['setup_charge']) ? floatval($_POST['setup_charge']) : 0.00;
		$package_charge = isset($_POST['package_charge']) ? floatval($_POST['package_charge']) : 0.00;
		$pay_via_gateway = isset($_POST['pay_via_gateway']) ? intval($_POST['pay_via_gateway']) : 0;

		$pkg = null;
		if($selected_package_id > 0){
			$pkg = $this->db->where('id', $selected_package_id)->get('db_package')->row();
		}

		if(empty($pkg)){
			// Fallback to first package of this type
			$pkg = $this->db->where('package_type', $store_package_type)->where('status', 1)->order_by('id', 'asc')->get('db_package')->row();
		}

		if(empty($pkg)){
			$pkg = $this->db->where('status', 1)->order_by('id', 'asc')->get('db_package')->row();
		}

		if(empty($pkg)){
			return false;
		}

		$today = date('Y-m-d');
		$time = date('h:i:s a');

		$package_type = isset($pkg->package_type) ? $pkg->package_type : $store_package_type;
		$trial_days = (!empty($pkg->trial_days) && $pkg->trial_days > 0) ? intval($pkg->trial_days) : 0;

		if($package_type == 'Free'){
			$expire_date = date('Y-m-d', strtotime('+1 year'));
			$base_pkg_price = 0.00;
			$payment_type = 'Free';
			$package_count = 1;
		} else if($package_type == 'Trial'){
			$days = ($trial_days > 0) ? $trial_days : 14;
			$trial_days = $days;
			$expire_date = date('Y-m-d', strtotime("+$days days"));
			$base_pkg_price = 0.00;
			$payment_type = 'Trial';
			$package_count = 1;
		} else { // Paid
			if($billing_cycle == 'yearly' || $billing_cycle == 'annual'){
				$base_pkg_price = ($pkg->annual_price > 0) ? $pkg->annual_price : ($pkg->monthly_price * 12);
				$payment_type = 'Yearly';
				$package_count = 12;
				$expire_date = date('Y-m-d', strtotime('+1 year'));
			} else {
				$base_pkg_price = $pkg->monthly_price;
				$payment_type = 'Monthly';
				$package_count = 1;
				$expire_date = date('Y-m-d', strtotime('+1 month'));
			}
		}

		$total_gross = $base_pkg_price + $setup_charge;

		// DIRECT SAVE vs PAYMENT GATEWAY:
		// If Paid plan with payment gateway, store starts as 0 and activates immediately upon payment confirmation.
		// Direct Save by Super Admin activates immediately as Paid / Active.
		if($pay_via_gateway == 1 && $package_type == 'Paid'){
			$payment_by = 'Payment Gateway';
			$payment_status = 'Pending';
			$package_status = 'Pending';
			$store_status = 0; // Activates directly once gateway payment confirms
		} else {
			$payment_by = 'Manual';
			$payment_status = 'Paid';
			$package_status = 'Active';
			$store_status = 1;
		}

		$auto_lock_day = intval(date('j', strtotime($expire_date)));
		$auto_lock_date = $expire_date;

		$sub_data = array(
			'store_id' => $store_id,
			'package_id' => $pkg->id,
			'package_type' => $package_type,
			'package_name' => $pkg->package_name,
			'description' => $pkg->description,
			'subscription_date' => $today,
			'expire_date' => $expire_date,
			'trial_days' => $trial_days,
			'max_users' => $pkg->max_users,
			'max_warehouses' => $pkg->max_warehouses,
			'max_items' => $pkg->max_items,
			'max_invoices' => $pkg->max_invoices,
			'package_charge' => $base_pkg_price,
			'setup_charge' => $setup_charge,
			'payment_gross' => $total_gross,
			'payment_by' => $payment_by,
			'payment_status' => $payment_status,
			'package_status' => $package_status,
			'payment_type' => $payment_type,
			'package_count' => $package_count,
			'created_date' => $today,
			'created_time' => $time,
			'created_by' => $this->session->userdata('inv_username') ? $this->session->userdata('inv_username') : 'System'
		);

		$this->db->insert('db_subscription', $sub_data);
		$sub_id = $this->db->insert_id();

		$this->db->where('id', $store_id)->update('db_store', array(
			'status' => $store_status,
			'current_subscriptionlist_id' => $sub_id,
			'auto_lock_day' => ($auto_lock_day > 0) ? $auto_lock_day : intval(date('j')),
			'auto_lock_date' => $auto_lock_date
		));

		return $sub_id;
	}

	//Get store_details
	public function get_details($id){
		$data=$this->data;

		$query1=$this->db->query("select * from db_store where upper(id)=upper('$id')");
		if($query1->num_rows()==0){
			show_404();exit;
		}
		else{
			/* QUERY 1*/
			$query=$this->db->query("select * from db_sitesettings order by id asc limit 1");
			$query=$query->row();
			$data['q_id']=$query1->row()->id;
			return array_merge($data,$query1->row_array());
			return $data;
		}
	}


	public function update_status($id,$status){
       if (set_status_of_table($id,$status,'db_store')){
            $store = $this->db->where('id', $id)->get('db_store')->row();
            if(!empty($store)){
                $next_lock_date = '';
                if($status == 1 && !empty($store->auto_lock_day) && $store->auto_lock_day > 0){
                    if(empty($store->auto_lock_date) || $store->auto_lock_date <= date('Y-m-d')){
                        $target_month = date('Y-m', strtotime('+1 month'));
                        $max_day = intval(date('t', strtotime($target_month . '-01')));
                        $day_to_use = min($store->auto_lock_day, $max_day);
                        $next_lock_date = $target_month . '-' . sprintf('%02d', $day_to_use);
                        $this->db->where('id', $id)->update('db_store', array('auto_lock_date' => $next_lock_date));
                    }
                }
                if(!empty($store->current_subscriptionlist_id)){
                    if($status == 1){
                        $sub_up = array(
                            'package_status' => 'Active',
                            'payment_status' => 'Paid'
                        );
                        if(!empty($next_lock_date)){
                            $sub_up['expire_date'] = $next_lock_date;
                        }
                        $this->db->where('id', $store->current_subscriptionlist_id)->update('db_subscription', $sub_up);
                    } else {
                        $this->db->where('id', $store->current_subscriptionlist_id)->update('db_subscription', array(
                            'package_status' => 'Unsubscribed'
                        ));
                    }
                }
            }
            echo "success";
        }
        else{
            echo "failed";
        }
	}
	public function delete_store_from_table($ids){
			$this->db->trans_begin();
			$query1=$this->db->where_in('id',$ids)->where('id!=1')->delete('db_store');
	        if ($query1){
	        	$this->db->trans_commit();
	            echo "success";
	        }
	        else{
	            echo "failed";
	        }	
	}
	public function create_default_warehouse($store_id,$mobile='',$email=''){
		$created_date = date("Y-m-d");
		$query1="insert into db_warehouse(store_id,warehouse_type,warehouse_name,mobile,email,status,created_date) 
									values($store_id,'System','System Warehouse','$mobile','$email',1,'$created_date')";
		
		if ($this->db->simple_query($query1)){
				$this->session->set_flashdata('success', 'Success!! New Warehouse Created Succssfully!!');
		        return "success";
		}
		else{
		        return "failed";
		}
	}

	public function update_auto_lock($store_id, $auto_lock_day, $auto_lock_date, $auto_lock_note = '', $activate_store = 0){
		if($store_id == 1){
			return "Cannot set auto lock on Super Admin store";
		}
		
		$auto_lock_day = intval($auto_lock_day);
		if($auto_lock_day < 0 || $auto_lock_day > 31){
			return "Invalid day of month. Please select between 1 and 31, or 0 to disable.";
		}

		if($auto_lock_day == 0 && empty($auto_lock_date)){
			$update_data = array(
				'auto_lock_day' => 0,
				'auto_lock_date' => null,
				'auto_lock_note' => null
			);
		} else {
			// If auto_lock_date is empty, calculate based on auto_lock_day
			if(empty($auto_lock_date)){
				$cur_day = intval(date('j'));
				if($auto_lock_day > $cur_day){
					$target_month = date('Y-m');
				} else {
					$target_month = date('Y-m', strtotime('+1 month'));
				}
				$max_day = intval(date('t', strtotime($target_month . '-01')));
				$day_to_use = min($auto_lock_day, $max_day);
				$auto_lock_date = $target_month . '-' . sprintf('%02d', $day_to_use);
			} else {
				$auto_lock_date = date('Y-m-d', strtotime($auto_lock_date));
			}

			$update_data = array(
				'auto_lock_day' => $auto_lock_day,
				'auto_lock_date' => $auto_lock_date,
				'auto_lock_note' => (!empty($auto_lock_note)) ? trim($auto_lock_note) : null
			);
		}

		if($activate_store == 1){
			$update_data['status'] = 1;
			$store = $this->db->where('id', $store_id)->get('db_store')->row();
			if(!empty($store) && !empty($store->current_subscriptionlist_id)){
				$this->db->where('id', $store->current_subscriptionlist_id)->update('db_subscription', array(
					'package_status' => 'Active',
					'payment_status' => 'Paid'
				));
			}
		}

		$this->db->where('id', $store_id)->update('db_store', $update_data);
		return "success";
	}

	public function save_subscription_date($store_id, $sub_date){
		if($store_id == 1){
			return "Cannot set lock date on Super Admin store";
		}
		$store = $this->db->where('id', $store_id)->get('db_store')->row();
		if(empty($store)){
			return "Store not found";
		}
		if(empty($sub_date)){
			return "Please select a valid date from calendar";
		}

		$parsed_time = strtotime($sub_date);
		if(!$parsed_time){
			return "Invalid date format";
		}

		$formatted_date = date('Y-m-d', $parsed_time);
		$day_of_month = intval(date('j', $parsed_time));

		$store_update = array(
			'auto_lock_day'  => $day_of_month,
			'auto_lock_date' => $formatted_date,
			'status'         => ($formatted_date >= date('Y-m-d')) ? 1 : 0
		);

		// Ensure valid subscription record exists
		$sub_id = $store->current_subscriptionlist_id;
		$sub_rec = !empty($sub_id) ? $this->db->where('id', $sub_id)->get('db_subscription')->row() : null;
		if(empty($sub_rec)){
			$sub_rec = $this->db->where('store_id', $store_id)->order_by('id', 'desc')->get('db_subscription')->row();
		}

		if(!empty($sub_rec)){
			$sub_update = array(
				'expire_date' => $formatted_date
			);
			if($formatted_date >= date('Y-m-d')){
				$sub_update['package_status'] = 'Active';
				$sub_update['payment_status'] = 'Paid';
			} else {
				$sub_update['package_status'] = 'Unsubscribed';
			}
			$this->db->where('id', $sub_rec->id)->update('db_subscription', $sub_update);
			$store_update['current_subscriptionlist_id'] = $sub_rec->id;
		} else {
			$sub_data = array(
				'store_id'          => $store_id,
				'package_id'        => 3,
				'package_name'      => 'Starter 100',
				'package_type'      => 'Paid',
				'payment_type'      => 'Monthly',
				'subscription_date' => date('Y-m-d'),
				'expire_date'       => $formatted_date,
				'payment_status'    => ($formatted_date >= date('Y-m-d')) ? 'Paid' : 'Pending',
				'package_status'    => ($formatted_date >= date('Y-m-d')) ? 'Active' : 'Unsubscribed',
				'created_date'      => date('Y-m-d'),
				'created_time'      => date('h:i:s a'),
				'created_by'        => $this->session->userdata('inv_username') ?: 'admin',
				'system_ip'         => $this->input->ip_address(),
				'system_name'       => gethostbyaddr($this->input->ip_address()) ?: 'POS'
			);
			$this->db->insert('db_subscription', $sub_data);
			$store_update['current_subscriptionlist_id'] = $this->db->insert_id();
		}

		$this->db->where('id', $store_id)->update('db_store', $store_update);

		return "success";
	}

	public function get_shop_tenant_tables(){
		$res = $this->db->query("SELECT DISTINCT TABLE_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND COLUMN_NAME = 'store_id'")->result_array();
		$tables = array();
		foreach($res as $r){
			if($r['TABLE_NAME'] != 'db_store'){
				$tables[] = $r['TABLE_NAME'];
			}
		}
		return $tables;
	}

	public function generate_shop_backup_sql($store_id){
		$store = $this->db->where('id', $store_id)->get('db_store')->row();
		if(empty($store)){
			return false;
		}

		$store_code = !empty($store->store_code) ? $store->store_code : 'ST'.$store_id;
		$store_name = !empty($store->store_name) ? $store->store_name : 'Shop_'.$store_id;

		// Collect structured data for perfect cross-shop restoration
		$backup_package = array(
			'version'         => '3.1',
			'source_store_id' => intval($store_id),
			'store_code'      => $store_code,
			'store_name'      => $store_name,
			'exported_at'     => date('Y-m-d H:i:s'),
			'tables'          => array()
		);

		// Order of tables: Reference/Master tables first, then dependent transaction tables
		$ordered_tables = array(
			'db_warehouse',
			'db_roles',
			'db_permissions',
			'db_category',
			'db_brands',
			'db_units',
			'db_tax',
			'db_variants',
			'db_warranty',
			'db_expense_category',
			'ac_accounts',
			'db_paymenttypes',
			'db_customers',
			'db_custadvance',
			'db_shippingaddress',
			'db_suppliers',
			'db_items',
			'db_item_serials',
			'db_users',
			'db_sales',
			'db_salesitems',
			'db_salespayments',
			'db_salesreturn',
			'db_salesitemsreturn',
			'db_salespaymentsreturn',
			'db_purchase',
			'db_purchaseitems',
			'db_purchasepayments',
			'db_purchasereturn',
			'db_purchaseitemsreturn',
			'db_purchasepaymentsreturn',
			'db_quotation',
			'db_quotationitems',
			'db_hold',
			'db_holditems',
			'db_expense',
			'ac_transactions',
			'ac_moneydeposits',
			'ac_moneytransfer',
			'db_emi',
			'db_emi_installments',
			'db_emi_payments',
			'db_employees',
			'db_stockadjustment',
			'db_stockadjustmentitems',
			'db_stocktransfer',
			'db_stocktransferitems',
			'db_coupons',
			'db_customer_coupons',
			'db_warehouseitems',
			'db_bankdetails'
		);

		// Also check any other tenant tables in database
		$all_tenant_tables = $this->get_shop_tenant_tables();
		foreach($all_tenant_tables as $att){
			if(!in_array($att, $ordered_tables)){
				$ordered_tables[] = $att;
			}
		}

		foreach($ordered_tables as $table){
			if(!$this->db->table_exists($table)){
				continue;
			}
			$this->db->where('store_id', $store_id);
			if($table == 'db_users'){
				$this->db->where('id !=', 1);
			}
			$rows = $this->db->get($table)->result_array();
			if(!empty($rows)){
				$backup_package['tables'][$table] = $rows;
			}
		}

		$json_payload = json_encode($backup_package);

		$sql = "-- ============================================================\n";
		$sql .= "-- POS SHOP-WISE DATABASE BACKUP\n";
		$sql .= "-- SOURCE_STORE_ID: " . $store_id . "\n";
		$sql .= "-- STORE_CODE: " . $store_code . "\n";
		$sql .= "-- STORE_NAME: " . $store_name . "\n";
		$sql .= "-- BACKUP_DATE: " . date('Y-m-d H:i:s') . "\n";
		$sql .= "-- POS System: Version 3.1\n";
		$sql .= "-- ============================================================\n\n";

		// Embed structured data for cross-shop restore
		$sql .= "/*POS_DATA_JSON_START\n" . $json_payload . "\nPOS_DATA_JSON_END*/\n\n";

		$sql .= "SET FOREIGN_KEY_CHECKS=0;\n";
		$sql .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n\n";

		// Generate SQL statements as well
		foreach($backup_package['tables'] as $table => $rows){
			$sql .= "-- ------------------------------------------------------------\n";
			$sql .= "-- Table `" . $table . "` (" . count($rows) . " records)\n";
			$sql .= "-- ------------------------------------------------------------\n";

			foreach($rows as $row){
				$cols = array();
				$vals = array();
				foreach($row as $col => $val){
					$cols[] = "`" . $col . "`";
					$vals[] = ($val === null) ? 'NULL' : $this->db->escape($val);
				}
				$sql .= "REPLACE INTO `" . $table . "` (" . implode(', ', $cols) . ") VALUES (" . implode(', ', $vals) . ");\n";
			}
			$sql .= "\n";
		}

		$sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
		$sql .= "-- END OF BACKUP --\n";

		return $sql;
	}

	public function delete_shop_data($store_id){
		if($store_id == 1){
			return "Cannot delete data of Super Admin SaaS store";
		}
		$store = $this->db->where('id', $store_id)->get('db_store')->row();
		if(empty($store)){
			return "Store not found";
		}

		$this->db->trans_begin();
		$this->db->query("SET FOREIGN_KEY_CHECKS=0");

		$tables = $this->get_shop_tenant_tables();
		foreach($tables as $table){
			if(!$this->db->table_exists($table)) continue;
			if($table == 'db_users'){
				$this->db->where('store_id', $store_id)->where('id !=', 1)->delete($table);
			} else {
				$this->db->where('store_id', $store_id)->delete($table);
			}
		}

		// Re-create default system warehouse for this store
		$created_date = date("Y-m-d");
		$mobile = !empty($store->mobile) ? $store->mobile : '';
		$email = !empty($store->email) ? $store->email : '';
		$this->db->query("INSERT INTO db_warehouse(store_id,warehouse_type,warehouse_name,mobile,email,status,created_date) VALUES($store_id,'System','System Warehouse',".$this->db->escape($mobile).",".$this->db->escape($email).",1,'$created_date')");

		$this->db->query("SET FOREIGN_KEY_CHECKS=1");

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return "Failed to delete shop data";
		} else {
			$this->db->trans_commit();
			return "success";
		}
	}

	public function restore_shop_backup_sql($target_store_id, $content, $clean_existing = 1){
		if(empty($content)){
			return "Backup content is empty";
		}
		$target_store = $this->db->where('id', $target_store_id)->get('db_store')->row();
		if(empty($target_store)){
			return "Target store not found";
		}

		// Check if payload has structured JSON package
		$is_json_backup = false;
		$backup_data = null;
		if(strpos($content, '/*POS_DATA_JSON_START') !== false && strpos($content, 'POS_DATA_JSON_END*/') !== false){
			$start = strpos($content, '/*POS_DATA_JSON_START') + strlen('/*POS_DATA_JSON_START');
			$end = strpos($content, 'POS_DATA_JSON_END*/');
			$json_str = trim(substr($content, $start, $end - $start));
			$backup_data = json_decode($json_str, true);
			if(!empty($backup_data) && isset($backup_data['tables'])){
				$is_json_backup = true;
			}
		} else if(substr(trim($content), 0, 1) === '{'){
			$backup_data = json_decode(trim($content), true);
			if(!empty($backup_data) && isset($backup_data['tables'])){
				$is_json_backup = true;
			}
		}

		// 1. Clean existing data in target store if requested
		if($clean_existing == 1 && $target_store_id != 1){
			$del_res = $this->delete_shop_data($target_store_id);
			if($del_res !== 'success'){
				return "Failed to clean existing data: " . $del_res;
			}
		}

		$this->db->trans_begin();
		$this->db->query("SET FOREIGN_KEY_CHECKS=0");

		if($is_json_backup){
			// Intelligent cross-shop import with ID remapping
			$id_map = array();
			$target_code = !empty($target_store->store_code) ? $target_store->store_code : 'ST'.$target_store_id;

			// Define insertion order
			$table_order = array(
				'db_warehouse', 'db_roles', 'db_permissions', 'db_category', 'db_brands',
				'db_units', 'db_tax', 'db_variants', 'db_warranty', 'db_expense_category',
				'ac_accounts', 'db_paymenttypes', 'db_customers', 'db_custadvance',
				'db_shippingaddress', 'db_suppliers', 'db_items', 'db_item_serials',
				'db_users', 'db_sales', 'db_salesitems', 'db_salespayments',
				'db_salesreturn', 'db_salesitemsreturn', 'db_salespaymentsreturn',
				'db_purchase', 'db_purchaseitems', 'db_purchasepayments',
				'db_purchasereturn', 'db_purchaseitemsreturn', 'db_purchasepaymentsreturn',
				'db_quotation', 'db_quotationitems', 'db_hold', 'db_holditems',
				'db_expense', 'ac_transactions', 'ac_moneydeposits', 'ac_moneytransfer',
				'db_emi', 'db_emi_installments', 'db_emi_payments', 'db_employees',
				'db_stockadjustment', 'db_stockadjustmentitems', 'db_stocktransfer',
				'db_stocktransferitems', 'db_coupons', 'db_customer_coupons',
				'db_warehouseitems', 'db_bankdetails'
			);

			// Append any extra tables in backup_data
			foreach(array_keys($backup_data['tables']) as $tbl){
				if(!in_array($tbl, $table_order)){
					$table_order[] = $tbl;
				}
			}

			foreach($table_order as $table){
				if(!isset($backup_data['tables'][$table]) || !$this->db->table_exists($table)){
					continue;
				}

				$rows = $backup_data['tables'][$table];
				foreach($rows as $row){
					$old_id = isset($row['id']) ? $row['id'] : null;
					unset($row['id']); // Allocate new auto-increment ID to avoid clash!
					$row['store_id'] = $target_store_id; // Assign to target store!

					// Foreign key remapping
					if(isset($row['warehouse_id']) && isset($id_map['db_warehouse'][$row['warehouse_id']])){
						$row['warehouse_id'] = $id_map['db_warehouse'][$row['warehouse_id']];
					}
					if(isset($row['warehouse_from']) && isset($id_map['db_warehouse'][$row['warehouse_from']])){
						$row['warehouse_from'] = $id_map['db_warehouse'][$row['warehouse_from']];
					}
					if(isset($row['warehouse_to']) && isset($id_map['db_warehouse'][$row['warehouse_to']])){
						$row['warehouse_to'] = $id_map['db_warehouse'][$row['warehouse_to']];
					}
					if(isset($row['category_id']) && isset($id_map['db_category'][$row['category_id']])){
						$row['category_id'] = $id_map['db_category'][$row['category_id']];
					}
					if(isset($row['brand_id']) && isset($id_map['db_brands'][$row['brand_id']])){
						$row['brand_id'] = $id_map['db_brands'][$row['brand_id']];
					}
					if(isset($row['unit_id']) && isset($id_map['db_units'][$row['unit_id']])){
						$row['unit_id'] = $id_map['db_units'][$row['unit_id']];
					}
					if(isset($row['tax_id']) && isset($id_map['db_tax'][$row['tax_id']])){
						$row['tax_id'] = $id_map['db_tax'][$row['tax_id']];
					}
					if(isset($row['customer_id']) && isset($id_map['db_customers'][$row['customer_id']])){
						$row['customer_id'] = $id_map['db_customers'][$row['customer_id']];
					}
					if(isset($row['supplier_id']) && isset($id_map['db_suppliers'][$row['supplier_id']])){
						$row['supplier_id'] = $id_map['db_suppliers'][$row['supplier_id']];
					}
					if(isset($row['item_id']) && isset($id_map['db_items'][$row['item_id']])){
						$row['item_id'] = $id_map['db_items'][$row['item_id']];
					}
					if(isset($row['sales_id']) && isset($id_map['db_sales'][$row['sales_id']])){
						$row['sales_id'] = $id_map['db_sales'][$row['sales_id']];
					}
					if(isset($row['purchase_id']) && isset($id_map['db_purchase'][$row['purchase_id']])){
						$row['purchase_id'] = $id_map['db_purchase'][$row['purchase_id']];
					}
					if(isset($row['account_id']) && isset($id_map['ac_accounts'][$row['account_id']])){
						$row['account_id'] = $id_map['ac_accounts'][$row['account_id']];
					}
					if(isset($row['debit_account_id']) && isset($id_map['ac_accounts'][$row['debit_account_id']])){
						$row['debit_account_id'] = $id_map['ac_accounts'][$row['debit_account_id']];
					}
					if(isset($row['credit_account_id']) && isset($id_map['ac_accounts'][$row['credit_account_id']])){
						$row['credit_account_id'] = $id_map['ac_accounts'][$row['credit_account_id']];
					}
					if(isset($row['ref_accounts_id']) && isset($id_map['ac_accounts'][$row['ref_accounts_id']])){
						$row['ref_accounts_id'] = $id_map['ac_accounts'][$row['ref_accounts_id']];
					}
					if(isset($row['role_id']) && isset($id_map['db_roles'][$row['role_id']])){
						$row['role_id'] = $id_map['db_roles'][$row['role_id']];
					}

					// For users: avoid unique username conflict
					if($table == 'db_users'){
						$check_u = $this->db->where('username', $row['username'])->count_all_results('db_users');
						if($check_u > 0){
							$row['username'] = $row['username'] . '_' . strtolower($target_code);
						}
					}

					$this->db->insert($table, $row);
					$new_id = $this->db->insert_id();
					if($old_id && $new_id){
						$id_map[$table][$old_id] = $new_id;
					}
				}
			}
		} else {
			// Raw SQL parser fallback
			$queries = array();
			$lines = explode("\n", $content);
			$current_query = '';

			foreach($lines as $line){
				$trimmed = trim($line);
				if(empty($trimmed) || strpos($trimmed, '--') === 0 || strpos($trimmed, '/*') === 0){
					continue;
				}
				$current_query .= $line . "\n";
				if(substr($trimmed, -1) === ';'){
					$queries[] = $current_query;
					$current_query = '';
				}
			}

			foreach($queries as $query){
				$q = trim($query);
				if(!empty($q)){
					// Never overwrite target db_store row from backup
					if(stripos($q, 'INTO `db_store`') !== false || stripos($q, 'INTO db_store') !== false){
						continue;
					}
					$this->db->query($q);
				}
			}
		}

		$this->db->query("SET FOREIGN_KEY_CHECKS=1");

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return "Failed to restore backup SQL";
		} else {
			$this->db->trans_commit();
			return "success";
		}
	}

}

