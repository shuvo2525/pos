<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_model extends CI_Model {
	public function xss_html_filter($input){
		return $this->security->xss_clean(html_escape($input));
	}
	//UPDATE SMS API
	public function api_update(){
		extract($this->xss_html_filter(array_merge($this->data,$_POST,$_GET)));
		//print_r($this->xss_html_filter(array_merge($this->data,$_POST,$_GET)));exit();
		$store_id = get_current_store_id();
		$this->db->trans_begin();
		if($hidden_rowcount>0){
		$this->db->query("delete from db_emailapi where store_id=".$store_id);
		$this->db->query("ALTER TABLE db_emailapi AUTO_INCREMENT = 1");
			for($i=1; $i<=$hidden_rowcount; $i++){
				if(isset($_POST['info_'.$i])){
					$info 	 	= $_POST['info_'.$i];
					$key 	 	= $_POST['key_'.$i];
					$key_value 	= $_POST['key_val_'.$i];
					
					$q1=$this->db->query("insert into db_emailapi(
								info,`key`,key_value,store_id)
								values(
								'$info',
								'$key',
								'$key_value',
								$store_id
							)");
					if(!$q1){
						return "failed";
					}

				}//if end()
			}//for end()	
		}

		$q2=$this->db->query("update db_store set email_status=$email_status where id=".$store_id);
		if(!$q2){
			return "failed";
		}



			$this->session->set_flashdata('success', 'Record Successfully Saved!!');
			$this->db->trans_commit();
		    return "success";
	}

	//Send email
	public function send_email(array $content){

		extract($this->xss_html_filter($content));

		//Validate
		if(empty($to)){
			return "Recipient email address is required";
		}
		if(empty($subject)){
			return "Email subject is required";
		}
		if(empty($message)){
			return "Email message content is required";
		}

		// Determine store details
		$target_store_id = isset($content['store_id']) ? intval($content['store_id']) : 0;
		if(empty($target_store_id)){
			$target_store_id = get_current_store_id();
		}
		if(empty($target_store_id)){
			$target_store_id = 1;
		}

		$store_rec = get_store_details($target_store_id);

		// If target store doesn't have active SMTP, fallback to store 1 (SaaS Admin)
		if((empty($store_rec->smtp_status) || empty($store_rec->smtp_host)) && $target_store_id != 1){
			$admin_store = get_store_details(1);
			if(!empty($admin_store->smtp_status) && !empty($admin_store->smtp_host)){
				$store_rec = $admin_store;
			}
		}

		$smtp_status = isset($store_rec->smtp_status) ? intval($store_rec->smtp_status) : 0;

		//If SMTP active
		if($smtp_status && !empty($store_rec->smtp_host)){
			$smtp_host = trim($store_rec->smtp_host);
			$smtp_port = trim($store_rec->smtp_port);
			$smtp_crypto = '';

			// Clean host & determine crypto
			if(strpos($smtp_host, 'ssl://') === 0){
				$smtp_host = substr($smtp_host, 6);
				$smtp_crypto = 'ssl';
			} else if(strpos($smtp_host, 'tls://') === 0){
				$smtp_host = substr($smtp_host, 6);
				$smtp_crypto = 'tls';
			}

			if(empty($smtp_crypto)){
				if($smtp_port == '465'){
					$smtp_crypto = 'ssl';
				} else if($smtp_port == '587'){
					$smtp_crypto = 'tls';
				}
			}

			$config = Array(
				'protocol'     => 'smtp',
				'smtp_host'    => $smtp_host,
				'smtp_port'    => $smtp_port,
				'smtp_user'    => trim($store_rec->smtp_user),
				'smtp_pass'    => trim($store_rec->smtp_pass),
				'mailtype'     => 'html',
				'charset'      => 'utf-8',
				'wordwrap'     => TRUE,
				'newline'      => "\r\n",
				'crlf'         => "\r\n",
				'smtp_timeout' => 15,
			);
			if(!empty($smtp_crypto)){
				$config['smtp_crypto'] = $smtp_crypto;
			}

		    //Load email library & initialize
		    $this->load->library('email');
		    $this->email->initialize($config);
		    $this->email->clear(TRUE);
		    
		    $this->email->to($to);
		    $from_email = !empty($store_rec->smtp_user) ? trim($store_rec->smtp_user) : (!empty($store_rec->email) ? trim($store_rec->email) : 'no-reply@' . ($_SERVER['SERVER_NAME'] ?? 'pos.local'));
		    $from_name  = !empty($store_rec->store_name) ? trim($store_rec->store_name) : 'POS System';
		    $this->email->from($from_email, $from_name);

		    //Email content
		    $this->email->subject($subject);
		    $this->email->message($message);

		    //Send email
		    if($this->email->send()){
		        return true;
		    }
		    else{
		        $debug = $this->email->print_debugger(array('headers'));
		        log_message('error', 'SMTP Send Failed: ' . strip_tags($debug));

		        // Fallback to PHP mail()
		        $headers  = "MIME-Version: 1.0\r\n";
		        $headers .= "Content-type:text/html;charset=UTF-8\r\n";
		        $headers .= "From: " . $from_name . " <" . $from_email . ">\r\n";
		        if(@mail($to, $subject, $message, $headers)){
		        	return true;
		        }

		        return "SMTP Send Error: " . strip_tags($debug);
		    }
		}//If SMTP enabled
		else{
			//Send through regular email method
			$from_email = !empty($store_rec->email) ? trim($store_rec->email) : 'no-reply@' . ($_SERVER['SERVER_NAME'] ?? 'pos.local');
			$from_name  = !empty($store_rec->store_name) ? trim($store_rec->store_name) : 'POS System';
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8\r\n";
			$headers .= "From: " . $from_name . " <" . $from_email . ">\r\n";

			if(@mail($to, $subject, $message, $headers)){
				return true;
			}
			else{
				return "Failed to send Email! Please configure SMTP settings in Settings > SMTP.";
			}
		}
	}

}