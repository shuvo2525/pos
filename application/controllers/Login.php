<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->php_verification();
		$this->load_info();
	//	if(get_domain()!=get_dbdomain()){echo appinfo_domain_msg();exit();}
		is_sql_full_group_by_enabled();
	}

	public function php_verification(){
		$phpversion = phpversion();
		if (version_compare($phpversion, required_php_version(), '<')) {
			echo 'Application required PHP Version 7.4 or higher. Your server loaded with PHP Version '.$phpversion;
			exit;
		}
	}

	public function langauge($id){
		$this->load->model('language_model');
        $this->language_model->set($id);
        redirect($_SERVER['HTTP_REFERER']);
	}

	public function index()
	{	
		if($this->session->userdata('logged_in')==1){ redirect(base_url().'dashboard','refresh');	}
		$data = $this->data;
		$this->load->view('login',$data);
	}
	public function verify()
	{
		//print_r($_POST);exit;
		$this->form_validation->set_rules('email','Email/Username','required');
		$this->form_validation->set_rules('pass','Password','required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_flashdata('failed', 'Please Enter Email & password!');
			redirect('login');
		}
		else{

			$email=$this->input->post('email');
			$password=$this->input->post('pass');
			

			$this->load->model('login_model');//Model
			$this->login_model->verify_credentials($email,$password);
			
		}
	}
	public function forgot_password(){
		if($this->session->userdata('logged_in')==1){ redirect(base_url().'dashboard','refresh');	}
		$data = $this->data;
		$this->load->view('forgot-password',$data);
	}
	public function send_otp(){		
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		
		if($this->form_validation->run()==FALSE){
			$this->session->set_flashdata('failed', 'Invalid Email!');
			redirect(base_url().'login/forgot_password');
		}
		else{
			$email=$this->input->post('email');
			$this->load->model('login_model');//Model
			$response = $this->login_model->verify_email_send_otp($email);

			if($response==true){//Model->Method
				redirect(base_url().'login/otp');
			}
			else{
				redirect(base_url().'login/forgot_password');
			}			
		}
	}
	public function otp(){
		if($this->session->userdata('logged_in')==1){ redirect(base_url().'dashboard','refresh'); }
		if(!$this->session->userdata('email') || !$this->session->userdata('otp')){
			$this->session->set_flashdata('failed', 'Please enter your registered email address first.');
			redirect(base_url().'login/forgot_password');
			return;
		}
		$data = $this->data;
		$this->load->view('otp',$data);
	}
	public function verify_otp(){
		$this->form_validation->set_rules('otp', 'OTP', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		
		if($this->form_validation->run()==FALSE){
			$this->session->set_flashdata('failed', 'Please enter your OTP code!');
			redirect(base_url().'login/otp');
		}
		else{
			$otp = trim($this->input->post('otp'));
			$email = trim($this->input->post('email'));
			
			if($this->session->userdata('email')==$email && $this->session->userdata('otp')==$otp){
				$data = $this->data;
				$data['email'] = $email;
				$data['otp'] = $otp;
				
				$this->load->view("change-login-password",$data);
			}
			else{
				$this->session->set_flashdata('failed', 'Invalid OTP code! Please check and enter again.');
				redirect(base_url().'login/otp');
			}			
		}
	}
	public function change_password(){

		$this->form_validation->set_rules('otp', 'OTP', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[4]');
		$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]');
		
		$otp = trim($this->input->post('otp'));
		$email = trim($this->input->post('email'));
		$password = $this->input->post('password');
		$cpassword = $this->input->post('cpassword');

		if($this->form_validation->run()==FALSE){
			$this->session->set_flashdata('failed', validation_errors() ? strip_tags(validation_errors()) : 'Please enter and confirm matching passwords!');
			$data = $this->data;
			$data['email'] = $email;
			$data['otp'] = $otp;
			$this->load->view("change-login-password", $data);
			return;
		}
		else{
			$this->load->model('login_model');
			if($password==$cpassword && $this->session->userdata('email')==$email && $this->session->userdata('otp')==$otp){
				if($this->login_model->change_password($password,$email)){
					$array_items = array('email','otp');
					$this->session->unset_userdata($array_items);
					$this->session->set_flashdata('success', 'Password Changed Successfully! Please log in with your new password.');
					redirect(base_url().'login','refresh');
				}
				else{
					$data = $this->data;
    				$data['email'] = $email;
    				$data['otp'] = $otp;
    				$this->session->set_flashdata('failed', 'Failed to update password! Please try again.');
    				$this->load->view("change-login-password",$data);
				}			
			}
			else{
			        $data = $this->data;
    				$data['email'] = $email;
    				$data['otp'] = $otp;
    				$this->session->set_flashdata('failed', 'Password mismatch or session expired! Please try again.');
    				$this->load->view("change-login-password",$data);
			}
		}

	}
	

}
