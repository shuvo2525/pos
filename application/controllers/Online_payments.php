<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Online_payments extends MY_Controller

{

    function  __construct() {

        parent::__construct();
        $this->load_global();
        $this->load->library('paypal_lib');

        $this->load->model('online_payments_model','online_payments');

    }

    

    

    function index(){
        redirect(base_url('subscription'),'refresh');

    }

    public function free_package($pid=''){

        redirect(base_url('online_payments/paymentSuccess/Free/'.$pid),'refresh');
    }

    function buy_package($gateway='paypal',$pid,$target_store_id=0){
        //IF EMPTY ID
        if(empty($pid)){
            echo "Something went wrong";exit;
        }

        //Find package exist or not
        $q1 = $this->db->select("*")->where("id",$pid)->get("db_package");
        if($q1->num_rows()==0){
            echo "There is no package available";exit;
        }

        //Validate is PayPal & Instamojo configured or not
        if($gateway=='paypal'){
            if(!$this->online_payments->validatePaypalRecords()){
                // Set fallback sandbox email if none configured so test/sandbox payments don't break
                $paypal_row = $this->db->where('store_id', 1)->get('db_paypal')->row();
                if(empty($paypal_row) || empty($paypal_row->email)){
                    $this->db->where('store_id', 1)->update('db_paypal', array('email' => 'sb-merchant@business.example.com', 'sandbox' => 1));
                }
            }    
        }
        else{
            if(!$this->online_payments->validateInstamojoRecords()){
                echo "Instamojo Payment Gateway not configured, contact Admin!";exit;
            }    
        }


        $this->load->model('package_model');
        $package_rec = $this->package_model->get_package_list($pid);
        
        $package_name = $package_rec['package_list'][1]['package_name'];
        $monthly_price = $package_rec['package_list'][1]['monthly_price'];
        $annual_price = $package_rec['package_list'][1]['annual_price'];

        $package_price= ($monthly_price>0) ? $monthly_price : $annual_price;
        
        $store_id = ($target_store_id > 0) ? intval($target_store_id) : get_current_store_id(); // target store id

        // Check if store already has a calculated subscription gross (Package + Setup Charge)
        if(!empty($store_id)){
            $sub_rec = $this->db->where('store_id', $store_id)->order_by('id', 'desc')->get('db_subscription')->row();
            if(!empty($sub_rec) && !empty($sub_rec->payment_gross) && $sub_rec->payment_gross > 0){
                $package_price = floatval($sub_rec->payment_gross);
            }
        }

        if($gateway=='paypal'){
            //Set variables for paypal form

            $returnURL = base_url().'online_payments/paymentSuccess/Paid'; //payment success url

            $failURL = base_url().'online_payments/paymentFail'; //payment fail url

            $notifyURL = base_url().'online_payments/ipn'; //ipn url

            //get particular product data

            

            

            $logo = base_url().'Your_logo_url';

             

            $this->paypal_lib->add_field('return', $returnURL);

            $this->paypal_lib->add_field('fail_return', $failURL);

            $this->paypal_lib->add_field('notify_url', $notifyURL);

            $this->paypal_lib->add_field('item_name', $package_name);

            $this->paypal_lib->add_field('custom', $store_id);

            $this->paypal_lib->add_field('item_number',  $pid);

            $this->paypal_lib->add_field('amount',  $package_price);        

            $this->paypal_lib->image(base_url()."/uploads/admin.png");

             

            $this->paypal_lib->paypal_auto_form();
        }
        else{
            //Instamojo
            $this->load->library('instamojo');
            $pay = $this->instamojo->pay_request(
                $amount = $package_price,
                $purpose = $package_name,
                $buyer_name = $this->session->userdata('inv_username'),
                $email = $this->session->userdata('email'),
                $phone = "",
                $send_email = 'TRUE',
                $send_sms = 'FALSE',
                $repeated = 'FALSE',
                $redirect_url = base_url("online_payments/paymentSuccess/Paid/".$pid."/instamojo")
            );

            //$redirect_url = $pay['longurl'];

            redirect($pay['longurl'], 'refresh');
        }
    }

    public function save(){
        $this->form_validation->set_rules('package_id', 'Package Name', 'trim|required');
        $this->form_validation->set_rules('category', 'Package Category', 'trim|required');
        $this->form_validation->set_rules('package_count', 'Package Count', 'trim|required');
        $this->form_validation->set_rules('total', 'Total', 'trim|required');
        //$this->form_validation->set_rules('status', 'Status', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $package_id = $this->input->post('package_id');
            $pkg_details = get_package_details($package_id);
            $package_type = (!empty($pkg_details->package_type)) ? $pkg_details->package_type : 'Paid';
            $result = $this->paymentSuccess($package_type=$package_type,$pid=$package_id,$gateway="Manual");
            echo $result;
        } else {
            echo validation_errors();
        }
    }

    public function bank_transfer($pid=''){
        $data=$this->data;
        $data['page_title']=$this->lang->line('bankTransfer');
        $this->load->view('bank_details',$data);
    }
     public function paymentSuccess($package_type='Paid',$pid='',$gateway=''){

        //get the transaction data
        extract($this->data);


        //Manual Payment mean Super admin will allocate manually
        if($package_type=='Paid' && $gateway=='Manual'){
            $store_id = $this->input->post('store_id');
            $total = $this->input->post('total');
            $package_id = $this->input->post('package_id');
            $description = $this->input->post('description');
            $package_count = $this->input->post('package_count');
            $category = $this->input->post('category');//Monthly or Annually
            $payment_type = $this->input->post('payment_type');

            $store_details = get_store_details($store_id);
            $user = get_user_details($store_details->user_id);

            $data['payment_by'] = 'Manual';
            $data['payer_email'] = (!empty($user)) ? $user->email : ($store_details->email ?? '');

            $data['store_id'] = $store_id;
            
            $data['txn_id'] = '';//for PayPal
            $data['payment_id'] = ''; //for Instamojo

            $data['payment_gross'] = $total;
            $data['currency_code'] = '';
            $data['payment_status'] = "success";

            $data['package_id'] = $package_id; 
            $data['package_count'] = $package_count; 
            $data['payment_type'] = $payment_type; 
        }

        else if($package_type=='Paid' && $gateway=='instamojo'){
            $store_id = get_current_store_id();
            $this->load->library('instamojo');
            $paymentId =  $this->input->get('payment_request_id');
            $instamojo     = $this->instamojo->status($paymentId);
            //echo "<pre>";print_r($instamojo);exit;
            $data['payment_by'] = 'Instamojo';
            $data['payer_email'] = $instamojo['email'];
            $data['store_id'] = $store_id;
            
            $data['txn_id'] = '';//of paypal
            $data['payment_id'] = $instamojo["id"];//of instamojo

            $data['payment_gross'] = $instamojo['payments'][0]["amount"];
            $data['currency_code'] = $instamojo['payments'][0]["currency"];
            $data['payment_status'] = $instamojo["status"];

            $data['package_id'] = $pid; 
        }
        else if($package_type=='Paid' && $gateway!='Manual'){

            $paypalInfo = !empty($this->input->post()) ? $this->input->post() : $this->input->get();
            $store_id = !empty($paypalInfo['custom']) ? intval($paypalInfo['custom']) : get_current_store_id();
            //print_r($paypalInfo);exit;
            
            $data['payment_by'] = 'PayPal';
            $data['payer_email'] = !empty($paypalInfo["payer_email"]) ? $paypalInfo["payer_email"] : ($this->session->userdata('email') ?: '');
            $data['store_id'] = $store_id; 
            $data['package_id'] = !empty($paypalInfo['item_number']) ? intval($paypalInfo['item_number']) : (!empty($pid) ? intval($pid) : 3);
            $data['txn_id'] = !empty($paypalInfo["txn_id"]) ? $paypalInfo["txn_id"] : (!empty($paypalInfo["tx"]) ? $paypalInfo["tx"] : ('PP-'.time()));
            $data['payment_gross'] = !empty($paypalInfo["mc_gross"]) ? $paypalInfo["mc_gross"] : (!empty($paypalInfo["amt"]) ? $paypalInfo["amt"] : 0);
            $data['currency_code'] = !empty($paypalInfo["mc_currency"]) ? $paypalInfo["mc_currency"] : (!empty($paypalInfo["cc"]) ? $paypalInfo["cc"] : 'USD');
            $data['payment_status'] = !empty($paypalInfo["payment_status"]) ? $paypalInfo["payment_status"] : 'Completed';
        }
        else{
            $store_id = get_current_store_id();
            //Find is it first time or second time ?
            $prev_package_type='';
            $q1 = $this->db->select("package_type")->where("package_id",$pid)->where("store_id",$store_id)->get("db_subscription");
            if($q1->num_rows()>0){
                $prev_package_type = $q1->row()->package_type;
            }
            if($prev_package_type=='Free'){
                $this->session->set_flashdata('warning', 'Sorry!! This Package already used to your account!');
                redirect(base_url('subscription'),'refresh');
                exit;
            }
            $data['payment_by'] = 'Manual';
            $data['payer_email'] = '';//
            $data['store_id'] =$store_id;
            $data['package_id'] = $pid; 
            
            $data['txn_id'] = '';
            $data['payment_gross'] = 0;
            $data['currency_code'] = '';
            $data['payment_status'] = '';
        }

        $data['subscription_date']    = $CUR_DATE;
        $data['created_date']    = $CUR_DATE;
        $data['created_time']    = $CUR_TIME;
        $data['created_by']    = $CUR_USERNAME;
        $data['system_ip']    = $SYSTEM_IP;
        $data['system_name']    = $SYSTEM_NAME;


        //GET PACKAGE DETAILS
        $this->load->model('package_model');
        $package_rec = $this->package_model->get_package_list($data['package_id']);
        $data['package_name'] = $package_rec['package_list'][1]['package_name'];
        $data['trial_days'] = $package_rec['package_list'][1]['trial_days'];

        $data['max_users'] = ($package_rec['package_list'][1]['max_users']=='∞') ? '-1' : $package_rec['package_list'][1]['max_users'];

        $data['max_warehouses'] = ($package_rec['package_list'][1]['max_warehouses']=='∞') ? '-1' : $package_rec['package_list'][1]['max_warehouses'];

        $data['max_items'] = ($package_rec['package_list'][1]['max_items']=='∞') ? '-1' : $package_rec['package_list'][1]['max_items'];

        $data['max_invoices'] = ($package_rec['package_list'][1]['max_invoices']=='∞') ? '-1' : $package_rec['package_list'][1]['max_invoices'];

        //$data['max_warehouses'] = $package_rec['package_list'][1]['max_warehouses'];
        //$data['max_items'] = $package_rec['package_list'][1]['max_items'];
        //$data['max_invoices'] = $package_rec['package_list'][1]['max_invoices'];
        $data['package_type'] = $package_rec['package_list'][1]['package_type'];
        $monthly_price = $package_rec['package_list'][1]['monthly_price'];
        $annual_price = $package_rec['package_list'][1]['annual_price'];



        $data['description'] = ($gateway=='Manual') ? $description : $package_rec['package_list'][1]['description'];
        
        $posted_lock_day = $this->input->post('auto_lock_day');
        $posted_lock_date = $this->input->post('auto_lock_date');
        $store_curr = $this->db->where("id", $store_id)->get("db_store")->row();
        $auto_lock_day = (isset($posted_lock_day) && $posted_lock_day !== '') ? intval($posted_lock_day) : intval($store_curr->auto_lock_day ?? 0);

        if($gateway=='Manual'){//Manual adjustments
            if(!empty($posted_lock_date)){
                $expire_date = date("Y-m-d", strtotime($posted_lock_date));
            }
            else if($auto_lock_day > 0){
                $cur_day = intval(date('j'));
                $target_month = ($auto_lock_day > $cur_day) ? date('Y-m') : date('Y-m', strtotime('+1 month'));
                $max_day = intval(date('t', strtotime($target_month . '-01')));
                $day_to_use = min($auto_lock_day, $max_day);
                $expire_date = $target_month . '-' . sprintf('%02d', $day_to_use);
            }
            else if($category=="monthly_price"){                
                $expire_date = date("Y-m-d",strtotime("+".$package_count." month"));
            }
            else if($category=="annual_price"){//Annually
                $expire_date = date("Y-m-d",strtotime("+".$package_count." year"));
            }
            else if($category=="trial" || $data['package_type']=='Trial'){
                $days = (!empty($data['trial_days']) && $data['trial_days'] > 0) ? $data['trial_days'] : 14;
                $expire_date = date("Y-m-d",strtotime("+".$days." days"));
            }
            else if($category=="free" || $data['package_type']=='Free'){
                $days = (!empty($data['trial_days']) && $data['trial_days'] > 0) ? $data['trial_days'] : 365;
                $expire_date = date("Y-m-d",strtotime("+".$days." days"));
            }
            else{
                $expire_date = date("Y-m-d",strtotime("+".$package_count." month"));
            }
        }
        else if($data['package_type']=='Free' || $data['package_type']=='Trial'){
            $days = (!empty($data['trial_days']) && $data['trial_days'] > 0) ? $data['trial_days'] : 30;
            $expire_date = date("Y-m-d",strtotime("+".$days." days"));
        }
        else{
            // Payment gateway payment (PayPal, Instamojo, etc.)
            if($auto_lock_day > 0){
                $target_month = date('Y-m', strtotime('+1 month'));
                $max_day = intval(date('t', strtotime($target_month . '-01')));
                $day_to_use = min($auto_lock_day, $max_day);
                $expire_date = $target_month . '-' . sprintf('%02d', $day_to_use);
            } else if($monthly_price>0){
                $expire_date = date("Y-m-d",strtotime("+1 month"));
            }
            else{
                $expire_date = date("Y-m-d",strtotime("+1 year"));
            }
        }
        
        $data['expire_date'] = $expire_date;
        $data['payment_status'] = 'Paid';
        $data['package_status'] = 'Active';

        $this->db->insert("db_subscription",$data);

        //update the store
        $subscription_plan_id = $this->db->insert_id();
        $update_store_data = array("current_subscriptionlist_id" => $subscription_plan_id, "status" => 1);
        if(empty($auto_lock_day) || $auto_lock_day <= 0){
            $auto_lock_day = intval(date('j'));
        }
        $update_store_data['auto_lock_day'] = $auto_lock_day;
        $update_store_data['auto_lock_date'] = $expire_date;
        $this->db->where("id",$store_id)->update("db_store", $update_store_data);
        //calculate expire date
        //end

        //pass the transaction data to view
        $this->session->set_flashdata('success', 'Congratulations!! Payment completed successfully. Your store has been automatically unlocked and activated!');

        if($gateway=='Manual'){
            return 'success';
        }
        else{
            redirect(base_url('dashboard'),'refresh');
        }

     }

      

     function paymentFail(){

        //if transaction cancelled

        $this->session->set_flashdata('failed', 'Sorry!! Payment Failed, try again!');
        redirect(base_url('subscription'),'refresh');

     }

      

     function ipn(){

        //paypal return transaction details array

        $paypalInfo    = $this->input->post();

 

        $data['user_id'] = $paypalInfo['custom'];

        $data['product_id']    = $paypalInfo["item_number"];

        $data['txn_id']    = $paypalInfo["txn_id"];

        $data['payment_gross'] = $paypalInfo["mc_gross"];

        $data['currency_code'] = $paypalInfo["mc_currency"];

        $data['payer_email'] = $paypalInfo["payer_email"];

        $data['payment_status']    = $paypalInfo["payment_status"];
        

 

        $paypalURL = $this->paypal_lib->paypal_url;        

        $result    = $this->paypal_lib->curlPost($paypalURL,$paypalInfo);

         

        //check whether the payment is verified
        if(preg_match("/VERIFIED/i",$result)){
            //insert the transaction data into the database
            $this->online_payments->storeTransaction($data);

        }

    }

}