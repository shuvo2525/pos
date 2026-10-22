<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
	}

	/**
	 * Sales invoices PDF Generation
	 * Generates modern A4 invoice matching reference design
	*/
	public function sales($sales_id=null){
		//Validate Record Authentication
		if(!is_admin()){
			$this->belong_to('db_sales',$sales_id);
			if(!$this->permissions('sales_add') && !$this->permissions('sales_edit') && !$this->permissions('sales_view')){
				$this->show_access_denied_page();
			}
		}

		$data = $this->data;
		$data['page_title'] = $this->lang->line('sales_invoice');
		$data = array_merge($data, array('sales_id' => $sales_id, 'is_pdf' => true));

		$html = $this->load->view('print-sales-invoice-3', $data, true);

		try {
			// Clean any previously sent buffers to prevent corrupting PDF stream
			while (ob_get_level() > 0) {
				ob_end_clean();
			}

			$options = new Options();
			$options->set('isRemoteEnabled', false);
			$options->set('defaultFont', 'Helvetica');
			$options->set('isHtml5ParserEnabled', true);
			$dompdf = new Dompdf($options);

			$dompdf->loadHtml($html, 'UTF-8');
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();

			$dompdf->stream("Sales-invoice-$sales_id-" . date('M') . "_" . date('d') . "_" . date('Y') . ".pdf", array("Attachment" => 0));
			exit;
		} catch(Throwable $e) {
			// Graceful fallback for any restricted environment: show print-ready HTML
			echo $html;
			exit;
		}
	}

	/**
	 * Purchase invoices PDF Generation
	 * Generates modern A4 invoice matching reference design
	*/
	public function purchase($purchase_id=null){
		//Validate Record Authentication
		if(!is_admin()){
			$this->belong_to('db_purchase',$purchase_id);
			if(!$this->permissions('purchase_add') && !$this->permissions('purchase_edit') && !$this->permissions('purchase_view')){
				$this->show_access_denied_page();
			}
		}

		$data = $this->data;
		$data['page_title'] = $this->lang->line('purchase_invoice');
		$data = array_merge($data, array('purchase_id' => $purchase_id, 'is_pdf' => true));

		$html = $this->load->view('print-purchase-invoice-3', $data, true);

		try {
			// Clean any previously sent buffers to prevent corrupting PDF stream
			while (ob_get_level() > 0) {
				ob_end_clean();
			}

			$options = new Options();
			$options->set('isRemoteEnabled', false);
			$options->set('defaultFont', 'Helvetica');
			$options->set('isHtml5ParserEnabled', true);
			$dompdf = new Dompdf($options);

			$dompdf->loadHtml($html, 'UTF-8');
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();

			$dompdf->stream("Purchase-invoice-$purchase_id-" . date('M') . "_" . date('d') . "_" . date('Y') . ".pdf", array("Attachment" => 0));
			exit;
		} catch(Throwable $e) {
			// Graceful fallback for any restricted environment: show print-ready HTML
			echo $html;
			exit;
		}
	}

}