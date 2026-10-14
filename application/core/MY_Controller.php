<?php
/**
 * Author: Askarali
 */
class MY_Controller extends CI_Controller{
      public $source_version = "1.7.1";
      public function __construct()
      {
        parent::__construct();

        // Ensure MySQL 8.0/8.4 and MariaDB sql_mode compatibility on live servers
        if(isset($this->db) && $this->db->conn_id){
          @$this->db->query("SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION'");
        }

        //$this->output->enable_profiler(TRUE);

        //Before Login Update check
        if($this->uri->segment(1) == 'login' || empty($this->uri->segment(1))){
          $this->update_db();
          $this->ensure_upload_directories();
        }

        //Used after logout
        if(!empty($this->input->cookie("language"))){
         $this->session->set_userdata('language',$this->input->cookie("language"));
         
         $cookie = array(
            'name'   => 'language',
              'value'  => '',
              'expire' => '0',
              );
          $this->input->set_cookie($cookie);
        }
        //end
        
        $default_lang = ($this->session->has_userdata('language')) ? $this->session->userdata('language') : "English";

        $this->lang->load($default_lang, $default_lang);
      }
      public function load_info(){
        /*if(strtotime(date("d-m-Y")) >= strtotime(date("05-04-2019"))){
            echo "License Expired! Contact Admin";exit();
          }*/

            //CHECK LANGUAGE IN SESSION ELSE FROM DB
            if(!$this->session->has_userdata('language') && $this->session->has_userdata('logged_in') ){
              $this->load->model('language_model');
              $this->language_model->set(get_current_store_language());
            }
            if($this->session->has_userdata('logged_in')){
              $this->lang->load($this->session->userdata('language'), $this->session->userdata('language'));
            }
            //End

            //If currency not set retrieve from DB
            $this->load_currency_data();
            //end

            

            $query =$this->db->select('site_name,version')->where('id',1)->get('db_sitesettings');

            $this->db->select('store_name,timezone,time_format,date_format,decimals,qty_decimals,default_account_id');
            if($this->session->userdata('logged_in')){
              $this->db->where('id',get_current_store_id());
            }
            else{
              $this->db->where('id',1);
            }
            $this->db->from('db_store');
            $query1 = $this->db->get();

            date_default_timezone_set(trim($query1->row()->timezone));

            $time_format = ($query1->row()->time_format=='24') ? date("h:i:s") : date("h:i:s a");

            $date_view_format = trim($query1->row()->date_format);
            $this->session->set_userdata(array('view_date'  => $date_view_format));
            $this->session->set_userdata(array('view_time'  => $query1->row()->time_format));
            $this->session->set_userdata(array('decimals'  => $query1->row()->decimals));
            $this->session->set_userdata(array('qty_decimals'  => $query1->row()->qty_decimals));
            $this->session->set_userdata(array('store_name'  => $query1->row()->store_name));
            $this->session->set_userdata(array('default_account_id'  => $query1->row()->default_account_id));
            

            $this->data = array('theme_link'    => base_url().'theme/',
                                'base_url'      => base_url(),
                                'SITE_TITLE'    => $query->row()->site_name,
                                'VERSION'       => $query->row()->version,
                                'CURRENCY'      => $this->session->userdata('currency'),
                                'CURRENCY_PLACE'=> $this->session->userdata('currency_placement'),
                                'CURRENCY_CODE' => $this->session->userdata('currency_code'),
                                'CUR_DATE'      => date("Y-m-d"),
                                'VIEW_DATE'     => $date_view_format,
                                'CUR_TIME'      => $time_format,
                                'SYSTEM_IP'     => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                                'SYSTEM_NAME'   => (!empty($_SERVER['REMOTE_ADDR'])) ? @gethostbyaddr($_SERVER['REMOTE_ADDR']) : 'localhost',
                                'CUR_USERNAME'  => $this->session->userdata('inv_username'),
                                'CUR_USERID'    => $this->session->userdata('inv_userid'),
                                'CUR_USERID'    => $this->session->userdata('inv_userid'),
                                    );
      }
      public function load_currency_data(){
        if($this->session->userdata('logged_in')){
          $q1=$this->db->query("SELECT a.currency_name,a.currency,a.currency_code,a.symbol,b.currency_placement FROM db_currency a,db_store b WHERE a.id=b.currency_id AND b.id=".get_current_store_id());
          if($q1->num_rows()>0){
              $currency = (!empty($q1->row()->currency)) ? $q1->row()->currency : 'Tk';
              $currency_placement = (!empty($q1->row()->currency_placement)) ? $q1->row()->currency_placement : 'Right';
              $currency_code = (!empty($q1->row()->currency_code)) ? $q1->row()->currency_code : 'BDT';
              $this->session->set_userdata(array('currency'  => $currency,'currency_placement'  => $currency_placement,'currency_code'  => $currency_code));
          } else {
              $this->session->set_userdata(array('currency'  => 'Tk','currency_placement'  => 'Right','currency_code'  => 'BDT'));
          }
        }
        else{
          $this->session->set_userdata(array('currency'  => 'Tk','currency_placement'  => 'Right','currency_code'  => 'BDT')); 
        }
      }

      public function verify_store_and_user_status(){
            //USER ACTIVE OR NOT
            if(!get_user_details()->status){
              $this->session->set_flashdata('failed', 'Your account is temporarily inactive!');
              redirect('logout');exit;
            }
      }

      public function check_store_lock_and_subscription(){
            if(is_admin()){
              return true;
            }
            if(!is_store_locked_or_expired()){
              return true;
            }

            $controller = strtolower($this->router->fetch_class());
            $method = strtolower($this->router->fetch_method());

            // Allowed controllers / auth & payment flows when locked:
            $allowed = array('dashboard', 'subscription', 'subscribers', 'online_payments', 'gateways', 'users', 'logout', 'login', 'site');
            if(in_array($controller, $allowed)){
              if($controller == 'users' && !in_array($method, array('edit', 'update_user', 'change_password', 'update_password'))){
                // Restricted from user admin operations
              } else {
                return true;
              }
            }

            // DataTables requests (AJAX POST with draw) are purely for viewing table data:
            // User requested: "r sob menu te dokte parbe oikhane kiso lock dekhabae na sudu operation hobe na"
            if(isset($_POST['draw'])){
              return true;
            }

            // If an OPERATION is attempted (POST requests to add/edit/delete/save transactions/items/sales/etc.):
            if(!empty($_POST)){
              if($this->input->is_ajax_request()){
                echo "failed<<<###>>>Operation Restricted: Your store is currently locked. Adding, editing, or deleting records is disabled. Please unlock your store or contact Admin.";
                exit();
              } else {
                $this->session->set_flashdata('error', 'Operation Restricted: Your store is currently locked. Adding, editing, or deleting records is disabled. Please unlock your store or contact Admin.');
                redirect($_SERVER['HTTP_REFERER'] ?? 'dashboard');
                exit();
              }
            }

            // For regular page browsing (GET request):
            // User requested: "r sob menu te dokte parbe oikhane kiso lock dekhabae na sudu operation hobe na"
            // Allow all menu views without kicking them to store_locked_view!
            return true;
      }

      public function load_global($validate_subs='VALIDATE'){
            //Check login or redirect to logout
            if($this->session->userdata('logged_in')!=1){ redirect(base_url().'logout','refresh');    }

            $this->verify_store_and_user_status();

            $this->load_info();

            $this->check_store_lock_and_subscription();
      }

      public function currency($value='',$with_comma=true){
        $value = trim($value);

        $clean_value = str_replace(',', '', $value);
        if(!empty($value) && is_numeric($clean_value)){
          $value = ($with_comma) ? store_number_format($clean_value, true) : store_number_format($clean_value, false);
        }

        $currency = $this->session->userdata('currency');
        if(empty($currency)){
          $currency = 'Tk';
        }

        $placement = $this->session->userdata('currency_placement');
        if(empty($placement)){
          $placement = 'Right';
        }

        if($placement=='Left'){
          if(!empty($value)){
            return $currency." ".$value;
          }
          return $currency."".$value;
        }
        else{
          if(!empty($value)){
            return $value." ".$currency;    
          }
          return $value."".$currency; 
        }
      }

      

      public function store_wise_currency($store_id,$value=''){

        $q1=$this->db->query("SELECT a.currency_name,a.currency,a.currency_code,a.symbol,b.currency_placement FROM db_currency a,db_store b WHERE a.id=b.currency_id AND b.id=".$store_id);
              $currency = (!empty($q1->row()->currency)) ? $q1->row()->currency : 'Tk';
              $currency_placement = (!empty($q1->row()->currency_placement)) ? $q1->row()->currency_placement : 'Right';
              $currency_code = (!empty($q1->row()->currency_code)) ? $q1->row()->currency_code : 'BDT';

        $value = trim($value);
        $clean_value = str_replace(',', '', $value);
        if(!empty($value) && is_numeric($clean_value)){
          $value = store_number_format($clean_value, true);
        }
        if($currency_placement=='Left'){
          if(!empty($value)){
            return $currency." ".$value;
          }
          return $currency."".$value;
        }
        else{
          if(!empty($value)){
            return $value." ".$currency;    
          }
          return $value."".$currency; 
        }
      }
      
      public function currency_code($value=''){
        if(!empty($this->session->userdata('currency_code'))){
          if($this->session->userdata('currency_placement')=='Left'){
            return $this->session->userdata('currency_code')." ".$value;
          }
          else{
           return $value." ".$this->session->userdata('currency'); 
          }
        }
        else{
          return $value;
        }
      }
      public function permissions($permissions=''){
          //If he the Admin
          if($this->session->userdata('inv_userid')==1){
            return true;
          }

          // If Store Admin (Shop Admin), grant all HR/Employee, EMI, Warranty, and Messaging/SMTP permissions by default
          if(($this->session->userdata('role_id')==2 || (function_exists('is_store_admin') && is_store_admin())) && (
              strpos($permissions, 'employee_') === 0 || 
              strpos($permissions, 'emi_') === 0 || 
              strpos($permissions, 'warranty_') === 0 ||
              strpos($permissions, 'email_') === 0 ||
              $permissions === 'smtp_settings' ||
              $permissions === 'send_email' ||
              $permissions === 'send_sms' ||
              $permissions === 'sms_settings' ||
              $permissions === 'sms_api_view'
          )){
            return true;
          }

          $role_id = intval($this->session->userdata('role_id'));
          if($role_id <= 0){
            return false;
          }

          $tot=$this->db->query('SELECT count(*) as tot FROM db_permissions where permissions="'.$permissions.'" and role_id='.$role_id)->row()->tot;
          if($tot==1){
            return true;
          }
           return false;
        }
        
        public function permission_check($value=''){
          if(!$this->permissions($value)){
             show_error("Access Denied", 403, $heading = "You Don't Have Enough Permission!!");
          }
          return true;
        }
        public function permission_check_with_msg($value=''){
          if(!$this->permissions($value)){
             echo "You Don't Have Enough Permission for this Operation!";
            exit();
          }
          return true;
        }
        public function show_access_denied_page()
        {
          show_error("Access Denied", 403, $heading = "You Don't Have Enough Permission!!");
        }
            //end
        public function get_current_version_of_db(){
          return $this->db->select('version')->from('db_sitesettings')->get()->row()->version;
        }
        
        public function belong_to($table,$rec_id){
          if(!is_it_belong_to_store($table,$rec_id)){
            show_error("Data may not avaialable!!", 403, $heading = "Something Went Wrong!!");
          }
        }

        public function print_qr($data = '') {
          $data_clean = trim($data);
          $decoded = @base64_decode(str_replace('-', '=', str_replace('_', '/', $data_clean)), true);
          if ($decoded !== false && !empty($decoded) && preg_match('/^[a-zA-Z0-9\/_\.\-:\?=&]+$/', $decoded)) {
            $data_clean = $decoded;
          }
          $qr_uri = generate_invoice_qr_uri($data_clean);
          return (!empty($qr_uri)) ? '<img src="' . $qr_uri . '" alt="QR Code" style="height:70px; width:70px; display:block; margin:0 auto;" />' : '';
        }

       public function update_db()
        { 
          //Before Login purpose only
          $this->load->model('updates_model');
          $this->updates_model->index();
        }

        public function ensure_upload_directories()
        {
          $dirs = array('bg', 'company', 'csv', 'customers', 'employees', 'htaccess_file', 'items', 'no_logo', 'signature', 'site', 'store', 'users');
          foreach ($dirs as $d) {
            $path = FCPATH . 'uploads/' . $d;
            if (!is_dir($path)) {
              @mkdir($path, 0777, true);
            }
          }
        }

}