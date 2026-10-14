<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Barcode extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}
	
    function index($input = ''){
		$input = trim(urldecode($input));
		if(empty($input)){
			$input = '000000000000';
		}

		try {
			require_once(APPPATH . 'libraries/tcpdf/tcpdf_barcodes_1d.php');
			$barcodeobj = new TCPDFBarcode($input, 'C128');
			
			// 1. If GD is loaded, generate crisp PNG
			if(extension_loaded('gd') && function_exists('imagecreate')){
				$png = $barcodeobj->getBarcodePngData(2, 38, array(0, 0, 0));
				if(!empty($png)){
					header('Content-Type: image/png');
					header('Cache-Control: public, max-age=86400');
					echo $png;
					exit;
				}
			}

			// 2. Pure PHP Vector SVG (works offline on any PC/server without GD)
			$svg = $barcodeobj->getBarcodeSVGcode(1.5, 38, 'black');
			if(!empty($svg)){
				$svg = preg_replace('/<svg\s+width="([^"]+)"\s+height="([^"]+)"/', '<svg viewBox="0 0 $1 $2" width="$1" height="$2" preserveAspectRatio="none"', $svg);
				header('Content-Type: image/svg+xml; charset=utf-8');
				header('Cache-Control: public, max-age=86400');
				echo $svg;
				exit;
			}
		} catch (Throwable $e) {
			// Fallback if needed
		}

		if(function_exists('imagecreate')){
			header('Content-Type: image/png');
			$width = 200;
			$height = 40;
			$im = @imagecreate($width, $height);
			$bg = imagecolorallocate($im, 255, 255, 255);
			$fg = imagecolorallocate($im, 0, 0, 0);
			$len = strlen($input);
			for($x=10; $x < $width - 10; $x += 4){
				imagefilledrectangle($im, $x, 5, $x + 2, $height - 5, $fg);
			}
			imagepng($im);
			imagedestroy($im);
			exit;
		}
    }

    public function get_barcode($code=''){
    	return $this->index($code);
    }
}
