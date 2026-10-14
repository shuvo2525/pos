<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Fivemojo_model extends CI_Model {

    public function index($mobile,$message)
    {

        $data = ['phone' => $mobile, 'text' => $message];
        //echo "<pre>";
        //print_r($this->sendSMS($data));
        return $this->sendSMS($data);
    }

    protected function sendSMS($data) {
        $store_id = get_current_store_id();
        if(empty($store_id)){
            $store_id = 1;
        }

        $q1 = $this->db->select("*")->where('store_id', $store_id)->get("db_fivemojo");
        if($q1->num_rows() == 0 && $store_id != 1){
            $q1 = $this->db->select("*")->where('store_id', 1)->get("db_fivemojo");
        }

        if($q1->num_rows() == 0){
            return "WhatsApp API is not configured! Please configure WhatsApp API in SMS API settings.";
        }

        $url = trim($q1->row()->url);
        $token = trim($q1->row()->token);
        $instance_id = trim($q1->row()->instance_id);

        if(empty($url)){
            $url = 'https://app.fivemojo.com/api/send.php';
        }

        if(empty($token) && empty($instance_id)){
            return "WhatsApp API Token/Instance ID is missing! Please configure them in SMS API settings.";
        }

        // Clean phone number: digits only
        $phone = preg_replace('/[^0-9]/', '', $data['phone']);
        // Bangladesh auto-prefix: 11 digits starting with 01 -> 8801XXXXXXXXX
        if(strlen($phone) == 11 && substr($phone, 0, 2) === '01'){
            $phone = '88' . $phone;
        }

        try{
            $api = array();
            
            // Check if UltraMsg endpoint
            if(stripos($url, 'ultramsg.com') !== false){
                $api['token'] = $token;
                $api['to'] = $phone;
                $api['body'] = $data['text'];
            } else {
                // FiveMojo / Standard WhatsApp API Gateway
                $api['type'] = 'text';
                $api['message'] = $data['text'];
                $api['number'] = $phone;
                if(!empty($instance_id)){
                    $api['instance_id'] = $instance_id;
                }
                if(!empty($token)){
                    $api['access_token'] = $token;
                    $api['token'] = $token;
                }
            }

            $ch = curl_init();
            $queryData = http_build_query($api);
            $sep = (strpos($url, '?') !== false) ? '&' : '?';
            $fullUrl = $url . $sep . $queryData;

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
                return "WhatsApp cURL Error: " . $curlErr;
            }

            $json = @json_decode($response, true);
            if(is_array($json)){
                if(isset($json['status']) && (strtolower($json['status']) == 'error' || $json['status'] === false)){
                    $msg = isset($json['message']) ? $json['message'] : (isset($json['error']) ? $json['error'] : 'Failed to send WhatsApp message');
                    return "WhatsApp Error: " . $msg;
                }
                if(isset($json['error'])){
                    return "WhatsApp Error: " . (is_string($json['error']) ? $json['error'] : json_encode($json['error']));
                }
                if(isset($json['status']) && (strtolower($json['status']) == 'success' || $json['status'] === true)){
                    return 'success';
                }
                if(isset($json['sent']) && ($json['sent'] === true || $json['sent'] === 'true')){
                    return 'success';
                }
            }

            if($httpCode >= 200 && $httpCode < 300){
                if(stripos($response, 'error') !== false || stripos($response, 'invalid') !== false){
                    return "WhatsApp Notice: " . strip_tags($response);
                }
                return 'success';
            }

            return "WhatsApp Gateway HTTP " . $httpCode . ": " . strip_tags($response);
        }
        catch(Exception $e){
            return "WhatsApp Exception: " . $e->getMessage();
        }
    }

}

/* End of file twilio_sms.php */
/* Location: ./application/models/twilio_sms.php */