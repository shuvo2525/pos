<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Author: Askarali Makanadar
 * Date: 05-11-2018
 */
class Login_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function verify_credentials($email,$password)
	{
		//Filtering XSS and html escape from user inputs 
		$email=$this->security->xss_clean(html_escape($email));
		$password=$this->security->xss_clean(html_escape($password));


		$this->db->select("a.email,a.store_id,a.id,a.username,a.first_name,a.last_name,a.role_id,b.role_name,a.status");
		$this->db->from("db_users a");
		$this->db->from("db_roles b");
		$this->db->where("b.id=a.role_id");
		$this->db->where("(a.email='$email' or username='$email')");
		$this->db->where("a.password",md5($password));
		$query = $this->db->get();
		if($query->num_rows()==1){

			//Verify is SaaS module Active ?
			if($query->row()->id==1){
				if(!store_module()){
					$this->session->set_flashdata('failed', 'Access Denied!! SaaS module is not Active!!');
					redirect('login');exit;
				}
			}

			$store_rec = get_store_details($query->row()->store_id);
			//USER ACTIVE OR NOT
			if(!$query->row()->status){
				$this->session->set_flashdata('failed', 'Your account is temporarily inactive!');
				redirect('login');exit;
			}

			// Store lock/expired notice
			if($query->row()->store_id != 1 && (!$store_rec->status || is_store_locked_or_expired($query->row()->store_id))){
				$this->session->set_flashdata('warning', 'Notice: Your shop is currently locked by Super Admin or your subscription has expired. Posting and viewing data/reports are restricted until reactivated.');
			}

			$user_full_name = trim($query->row()->first_name . ' ' . $query->row()->last_name);
			if(empty($user_full_name)){
				$user_full_name = ucfirst($query->row()->username);
			}

			$logdata = array(
							'inv_username'  => $query->row()->username,
							'full_name'     => $user_full_name,
							'first_name'    => $query->row()->first_name,
							'user_lname'    => $query->row()->last_name,
				        	 'inv_userid'  => $query->row()->id,
				        	 'logged_in' => TRUE,
				        	 'role_id' => $query->row()->role_id,
				        	 'role_name' => trim($query->row()->role_name),
				        	 'store_id' => trim($query->row()->store_id),
				        	 'email' => trim($query->row()->email),
				        	);
			$this->session->set_userdata($logdata);
			$this->session->set_flashdata('success', 'Welcome '.ucfirst($user_full_name)." !");
			redirect(base_url().'dashboard');
		}
		else{
			$this->session->set_flashdata('failed', 'Invalid Email or Password!');
			redirect('login');
		}		
	}
	public function verify_email_send_otp($email)
	{
		//Filtering XSS and html escape from user inputs 
		$to = $this->security->xss_clean(html_escape(trim($email)));
				
		$query = $this->db->query("select * from db_users where email='$to' and status=1");

		if($query->num_rows() == 0){
			$this->session->set_flashdata('failed', 'This Email ID does not exist in our records or the account is inactive!');
			return false;
		}

		$user_row = $query->row();
		$store_id = $user_row->store_id;

		$store_query = $this->db->query("select email,store_name from db_store where id=$store_id");
		$store_name = ($store_query->num_rows() > 0) ? $store_query->row()->store_name : 'Shop POS';
		$user_name = !empty($user_row->first_name) ? $user_row->first_name : $user_row->username;
		
		$otp = rand(1000, 9999);

		$subject = "OTP for Password Recovery: " . $otp . " - " . $store_name;

		$message = '<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><style>body{font-family: Arial, sans-serif; background:#f4f6f8; margin:0; padding:20px;}.card{max-width:520px; margin:20px auto; background:#ffffff; border-radius:12px; padding:32px; box-shadow:0 4px 12px rgba(0,0,0,0.06); border:1px solid #e2e8f0;}.header{text-align:center; padding-bottom:20px; border-bottom:1px solid #edf2f7;}.title{color:#1e293b; font-size:22px; font-weight:700; margin-bottom:8px;}.lead{color:#64748b; font-size:14px; margin-bottom:24px;}.otp-box{background:#f0fdf4; border:2px dashed #22c55e; border-radius:10px; text-align:center; padding:18px; margin:20px 0;}.otp-code{font-size:32px; font-weight:800; letter-spacing:8px; color:#15803d;}.footer{margin-top:28px; padding-top:16px; border-top:1px solid #edf2f7; color:#94a3b8; font-size:12px; text-align:center;}</style></head>
<body>
<div class="card">
	<div class="header">
		<h2 style="margin:0; color:#0f172a;">' . htmlspecialchars($store_name) . '</h2>
	</div>
	<div style="padding-top:20px;">
		<div class="title">Password Recovery Code</div>
		<p class="lead">Hello <b>' . htmlspecialchars(ucfirst($user_name)) . '</b>,<br>You have requested to reset your account password. Use the verification code below to proceed:</p>
		<div class="otp-box">
			<div style="font-size:12px; font-weight:700; color:#166534; text-transform:uppercase; margin-bottom:6px;">Your OTP Security Code</div>
			<div class="otp-code">' . $otp . '</div>
		</div>
		<p style="color:#64748b; font-size:13px; line-height:1.6;">This code is valid for your current password recovery session. For security reasons, never share this OTP with anyone.</p>
		<p style="color:#64748b; font-size:13px;">If you did not request this, please ignore this email.</p>
	</div>
	<div class="footer">
		© ' . date('Y') . ' ' . htmlspecialchars($store_name) . '. All rights reserved.
	</div>
</div>
</body>
</html>';

		$this->load->model('email_model');

		$contents = array(
			'to'       => $to,
			'subject'  => $subject,
			'message'  => $message,
			'store_id' => $store_id
		);
		$response = $this->email_model->send_email($contents);

		if($response === true){
			$this->session->set_flashdata('success', 'OTP has been sent to your email! (Please check your Inbox and Spam folder)');
			$otpdata = array('email' => $to, 'otp' => $otp);
			$this->session->set_userdata($otpdata);
			return true;
		}
		else{
			// Check if local test environment (XAMPP localhost)
			$remote_addr = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
			$http_host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
			$is_local = (in_array($remote_addr, array('127.0.0.1', '::1')) || strpos($http_host, 'localhost') !== false);
			
			if($is_local){
				// On local development, allow tester to proceed smoothly with generated OTP
				$this->session->set_flashdata('success', 'OTP Code Generated: <b>' . $otp . '</b> (Localhost test notice: ' . strip_tags($response) . ')');
				$otpdata = array('email' => $to, 'otp' => $otp);
				$this->session->set_userdata($otpdata);
				return true;
			} else {
				$err_msg = is_string($response) ? $response : 'Failed to send OTP email! Please check SMTP settings.';
				$this->session->set_flashdata('failed', $err_msg);
				return false;
			}
		}
	}
	public function verify_otp($otp)
	{
		//Filtering XSS and html escape from user inputs 
		$otp=$this->security->xss_clean(html_escape($otp));
		$email=$this->security->xss_clean(html_escape($email));
		if($this->session->userdata('email')==$email){ redirect(base_url().'logout','refresh');	}
				
		$query=$this->db->query("select * from db_users where username='$username' and password='".md5($password)."' and status=1");
		if($query->num_rows()==1){

			$logdata = array(
							'inv_username'  => $query->row()->username,
							'user_lname'  => $query->row()->last_name,
				        	 'inv_userid'  => $query->row()->id,
				        	 'logged_in' => TRUE,
				        	 'role_id' => $query->row()->role_id,
				        	 'role_name' => trim($query->row()->role_name),
				        	 'store_id' => trim($query->row()->store_id),
				        	);
			$this->session->set_userdata($logdata);
			return true;
		}
		else{
			return false;
		}		
	}
	public function change_password($password,$email){
			$query=$this->db->query("select * from db_users where email='$email' and status=1");
			if($query->num_rows()==1){
				/*if($query->row()->username == 'admin'){
					echo "Restricted Admin Password Change";exit();
				}*/
				$password=md5($password);
				$query1="update db_users set password='$password' where email='$email'";
				if ($this->db->simple_query($query1)){

				        return true;
				}
				else{
				        return false;
				}
			}
			else{
				return false;
				}

		}
}