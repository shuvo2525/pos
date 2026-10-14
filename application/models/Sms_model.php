<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_model extends CI_Model {
	public function xss_html_filter($input){
		return $this->security->xss_clean(html_escape($input));
	}
	//UPDATE SMS API
	public function api_update(){
		extract($this->xss_html_filter(array_merge($this->data,$_POST,$_GET)));
		//print_r($this->xss_html_filter(array_merge($this->data,$_POST,$_GET)));exit();
		//echo $whatsAppUrl;exit();
		//echo $whatsAppUrl;exit;
		$store_id = get_current_store_id();
		$this->db->trans_begin();
		if($hidden_rowcount>0){
		$this->db->query("delete from db_smsapi where store_id=".$store_id);
		$this->db->query("ALTER TABLE db_smsapi AUTO_INCREMENT = 1");
			for($i=1; $i<=$hidden_rowcount; $i++){
				if(isset($_POST['info_'.$i])){
					$info 	 	= $_POST['info_'.$i];
					$key 	 	= $_POST['key_'.$i];
					$key_value 	= $_POST['key_val_'.$i];
					
					$q1=$this->db->query("insert into db_smsapi(
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

		$q2=$this->db->query("update db_store set sms_status=$sms_status where id=".$store_id);
		if(!$q2){
			return "failed";
		}

		//save WhatsApp API
		$fivemojo = array('url' => $whatsAppUrl,'token'=>$whatsAppToken,'instance_id'=>$whatsAppInstanceId);
		
		$q1=$this->db->select("*")->where("store_id",$store_id)->get("db_fivemojo");
        if($q1->num_rows()>0){
          $q2 = $this->db->where("store_id",$store_id)->update("db_fivemojo",$fivemojo);
        }
        else{
        	$fivemojo = array_merge($fivemojo,array('store_id' => $store_id));
        	$q2=$this->db->insert("db_fivemojo",$fivemojo);
        }

        if(!$q2){
        	return "failed";
        }

			$this->session->set_flashdata('success', 'Record Successfully Saved!!');
			$this->db->trans_commit();
		    return "success";
	}
	//Send Message
	public function send_sms($mobile,$message){

		$store_id = get_current_store_id();
		if(empty($store_id)){
			$store_id = 1;
		}

		$store_rec = get_store_details($store_id);
		$sms_status = isset($store_rec->sms_status) ? intval($store_rec->sms_status) : 0;

		// Fallback to store 1 if current store has SMS disabled
		if($sms_status == 0 && $store_id != 1){
			$s1 = get_store_details(1);
			if(isset($s1->sms_status) && $s1->sms_status > 0){
				$store_rec = $s1;
				$sms_status = intval($s1->sms_status);
				$store_id = 1;
			}
		}

		if($sms_status == 0){
			return "Sorry! Can't Send. Please Enable SMS in SMS API settings.";
		}

		if($sms_status == 1){
			// HTTP/URL SMS API (Manual configuration)
			$q1 = $this->db->query("select * from db_smsapi where store_id=".$store_id);
			if($q1->num_rows() == 0 && $store_id != 1){
				$q1 = $this->db->query("select * from db_smsapi where store_id=1");
			}

			if($q1->num_rows() > 0){
				$baseUrl = '';
				$mobileKey = 'number';
				$messageKey = 'message';
				$api = array();

				foreach($q1->result() as $res1){
					if($res1->info == 'url'){
						$baseUrl = trim($res1->key_value);
					}
					else if($res1->info == 'mobile'){
						if(!empty($res1->key)){
							$mobileKey = trim($res1->key);
						}
					}
					else if($res1->info == 'message'){
						if(!empty($res1->key)){
							$messageKey = trim($res1->key);
						}
					}
					else{
						if(!empty($res1->key)){
							$api[trim($res1->key)] = trim($res1->key_value);
						}
					}
				}

				if(empty($baseUrl)){
					return "SMS Gateway URL is not configured!";
				}

				// Clean mobile number (digits only)
				$clean_mobile = preg_replace('/[^0-9]/', '', $mobile);

				// Assign mobile and message parameters based on manual keys
				$api[$mobileKey] = $clean_mobile;
				$api[$messageKey] = $message;

				// Ensure 'weblink' is never passed as a query parameter
				unset($api['weblink']);

				$ch = curl_init();
				$data = http_build_query($api);
				$sep = (strpos($baseUrl, '?') !== false) ? '&' : '?';
				$fullUrl = $baseUrl . $sep . $data;

				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($ch, CURLOPT_URL, $fullUrl);
				curl_setopt($ch, CURLOPT_TIMEOUT, 30);
				 
				$response = curl_exec($ch);
				$curlErr = curl_error($ch);
				$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
				 
				if(!empty($curlErr)){
					return 'cURL Error: ' . $curlErr;
				}

				// Parse JSON response if returned by API
				$json = @json_decode($response, true);
				if(is_array($json)){
					if(isset($json['response_code'])){
						if($json['response_code'] == 202 || $json['response_code'] == 200){
							return 'success';
						} else {
							$err_msg = isset($json['error_message']) ? $json['error_message'] : ('API Response Code: ' . $json['response_code']);
							return $err_msg;
						}
					}
					if(isset($json['status']) && (strtolower($json['status']) == 'success' || $json['status'] === true)){
						return 'success';
					}
					if(isset($json['success']) && $json['success'] === true){
						return 'success';
					}
				}

				// Text response check
				if($httpCode >= 200 && $httpCode < 300){
					if(stripos($response, 'error') !== false || stripos($response, 'invalid') !== false || stripos($response, 'fail') !== false){
						return "SMS Notice: " . strip_tags($response);
					}
					return 'success';
				}

				return "SMS Gateway HTTP " . $httpCode . ": " . strip_tags($response);
			}
			else{
				return "SMS API is not configured! Please configure in SMS API settings.";
			}
		}

		if($sms_status == 3){
			//WhatsApp API
			$this->load->model('fivemojo_model');
			return $this->fivemojo_model->index($mobile,$message);
		}

		return "SMS Status Unknown";
	}

}

/* End of file Sms_model.php */
/* Location: ./application/models/Sms_model.php */