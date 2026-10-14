<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

use chillerlan\QRCode\{QRCode, QROptions};

class Qrcode_model extends CI_Model {
    public function __construct(){
		parent::__construct();
	}

	public function qr_image($data='')
	{
		$data  = trim($data);	

		//if the parameter value was base64 encoded
		$decoded = @base64_decode(str_replace('-', '=', str_replace('_', '/', $data)), true);
		if($decoded !== false && !empty($decoded)){
			$data = $decoded;
		}

		$qr_uri = generate_invoice_qr_uri($data);
		return (!empty($qr_uri)) ? '<img src="' . $qr_uri . '" alt="QR Code" style="height:70px; width:70px; display:block; margin:0 auto;" />' : '';		
	}
}