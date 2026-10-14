<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Warranty extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load_global();
		$this->load->model('Warranty_model', 'warranty');
	}

	public function index() {
		$this->permission_check('warranty_view');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('warranty_list');
		$this->load->view('warranty/warranty_list', $data);
	}

	public function add() {
		$this->permission_check('warranty_add');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('new_warranty_claim');
		$this->load->view('warranty/warranty_add', $data);
	}

	public function save() {
		$this->permission_check_with_msg('warranty_add');
		echo $this->warranty->save_claim();
	}

	public function check() {
		$this->permission_check('warranty_view');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('check_warranty');
		$this->load->view('warranty/warranty_check', $data);
	}

	public function ajax_check() {
		$this->permission_check_with_msg('warranty_view');
		$search = $this->input->post('search');
		$results = $this->warranty->check_warranty($search);
		echo json_encode($results);
	}

	public function history() {
		$this->permission_check('warranty_view');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('service_history');
		$this->load->view('warranty/warranty_history', $data);
	}

	public function ajax_history() {
		$this->permission_check_with_msg('warranty_view');
		$search = $this->input->post('search');
		$results = $this->warranty->get_service_history($search);
		echo json_encode($results);
	}

	public function ajax_list() {
		$this->permission_check_with_msg('warranty_view');
		$list = $this->warranty->get_datatables();

		$data = array();
		$no = isset($_POST['start']) ? $_POST['start'] : 0;
		foreach ($list as $rec) {
			$no++;
			$row = array();
			$row[] = '<span class="text-bold text-primary">' . $rec->warranty_code . '</span>';
			$row[] = show_date($rec->claim_date);
			$row[] = '<strong>' . html_escape($rec->customer_name) . '</strong><br><small class="text-muted">' . html_escape($rec->customer_mobile) . '</small>';
			$row[] = '<strong>' . html_escape($rec->item_name) . '</strong>' . (!empty($rec->serial_no) ? '<br><small class="text-info"><i class="fa fa-barcode"></i> ' . html_escape($rec->serial_no) . '</small>' : '');
			$row[] = !empty($rec->expected_delivery_date) ? show_date($rec->expected_delivery_date) : '-';

			// Status badge
			if ($rec->status == 'Delivered') {
				$status_html = '<span class="label label-success" style="font-size:12px;"><i class="fa fa-check-circle"></i> Delivered</span>';
				if (!empty($rec->delivery_date)) {
					$status_html .= '<br><small class="text-muted"><i class="fa fa-calendar"></i> ' . show_date($rec->delivery_date) . '</small>';
				}
				if (!empty($rec->delivered_to)) {
					$status_html .= '<br><small class="text-muted"><i class="fa fa-user"></i> ' . html_escape($rec->delivered_to) . '</small>';
				}
			} else {
				$badge_class = 'label-info';
				if ($rec->status == 'Received') { $badge_class = 'label-primary'; }
				else if ($rec->status == 'Under Repair') { $badge_class = 'label-warning'; }
				else if ($rec->status == 'Ready for Delivery') { $badge_class = 'label-info'; }
				else if ($rec->status == 'Rejected') { $badge_class = 'label-danger'; }
				$status_html = '<span class="label ' . $badge_class . '" style="font-size:12px;">' . html_escape($rec->status) . '</span>';
			}

			$row[] = $status_html;
			$row[] = $this->currency($rec->total_charge);

			// Actions
			$actions = '<div class="btn-group">
				<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
					Action <span class="caret"></span>
				</button>
				<ul class="dropdown-menu dropdown-menu-right" role="menu">';

			if ($this->permissions('warranty_view')) {
				$actions .= '<li><a href="' . base_url('warranty/view/' . $rec->id) . '"><i class="fa fa-eye text-primary"></i> View Job Details</a></li>';
			}

			if ($this->permissions('warranty_edit')) {
				if ($rec->status != 'Delivered') {
					$actions .= '<li><a href="javascript:void(0)" onclick="open_delivery_modal(' . $rec->id . ')"><i class="fa fa-truck text-green"></i> <strong>Deliver Product</strong></a></li>';
				}
				$actions .= '<li><a href="javascript:void(0)" onclick="open_status_modal(' . $rec->id . ')"><i class="fa fa-refresh text-warning"></i> Update Status / Charges</a></li>';
			}

			if ($this->permissions('warranty_view')) {
				$actions .= '<li><a href="' . base_url('warranty/print_slip/' . $rec->id . '/receiving') . '" target="_blank"><i class="fa fa-print text-info"></i> Print Receiving Slip</a></li>';
				$actions .= '<li><a href="' . base_url('warranty/pdf_slip/' . $rec->id . '/receiving') . '" target="_blank"><i class="fa fa-file-pdf-o text-red"></i> PDF Receiving Slip</a></li>';

				if ($rec->status == 'Delivered' || $rec->total_charge > 0) {
					$actions .= '<li class="divider"></li>';
					$actions .= '<li><a href="' . base_url('warranty/print_slip/' . $rec->id . '/delivery') . '" target="_blank"><i class="fa fa-print text-green"></i> Print Delivery Slip</a></li>';
					$actions .= '<li><a href="' . base_url('warranty/pdf_slip/' . $rec->id . '/delivery') . '" target="_blank"><i class="fa fa-file-pdf-o text-red"></i> PDF Delivery Slip</a></li>';
				}
			}

			if ($this->permissions('warranty_delete')) {
				$actions .= '<li class="divider"></li>';
				$actions .= '<li><a href="javascript:void(0)" onclick="delete_claim(' . $rec->id . ')" class="text-red"><i class="fa fa-trash text-red"></i> Delete Claim</a></li>';
			}

			$actions .= '</ul></div>';
			$row[] = $actions;

			$data[] = $row;
		}

		$output = array(
			"draw"            => isset($_POST['draw']) ? $_POST['draw'] : 1,
			"recordsTotal"    => $this->warranty->count_all(),
			"recordsFiltered" => $this->warranty->count_filtered(),
			"data"            => $data,
		);
		echo json_encode($output);
	}

	public function view($id) {
		$this->belong_to('db_warranty', $id);
		$this->permission_check('warranty_view');

		$claim = $this->warranty->get_claim_details($id);
		if (!$claim) {
			show_404();
		}

		$data = $this->data;
		$data['page_title'] = 'Warranty Job Details - ' . $claim->warranty_code;
		$data['claim'] = $claim;

		$this->load->view('warranty/warranty_view', $data);
	}

	public function get_claim_json($id) {
		$this->permission_check_with_msg('warranty_view');
		$claim = $this->warranty->get_claim_details($id);
		echo json_encode($claim);
	}

	public function update_status() {
		$this->permission_check_with_msg('warranty_edit');
		echo $this->warranty->update_status();
	}

	public function print_slip($id, $type = 'receiving') {
		$this->belong_to('db_warranty', $id);
		$this->permission_check('warranty_view');

		$claim = $this->warranty->get_claim_details($id);
		if (!$claim) {
			show_404();
		}

		$data = $this->data;
		$data['page_title'] = ($type == 'delivery') ? 'Service Delivery Slip - ' . $claim->warranty_code : 'Warranty Receiving Slip - ' . $claim->warranty_code;
		$data['claim'] = $claim;
		$data['slip_type'] = $type;

		$this->load->view('warranty/warranty_receipt', $data);
	}

	public function pdf_slip($id, $type = 'receiving') {
		$this->belong_to('db_warranty', $id);
		$this->permission_check('warranty_view');

		$claim = $this->warranty->get_claim_details($id);
		if (!$claim) {
			show_404();
		}

		$data = $this->data;
		$data['page_title'] = ($type == 'delivery') ? 'Service Delivery Slip - ' . $claim->warranty_code : 'Warranty Receiving Slip - ' . $claim->warranty_code;
		$data['claim'] = $claim;
		$data['slip_type'] = $type;
		$data['is_pdf'] = true;

		$this->load->view('warranty/warranty_receipt', $data);

		$html = $this->output->get_output();
		$options = new Options();
		$options->set('isRemoteEnabled', true);
		$dompdf = new Dompdf($options);
		$dompdf->loadHtml($html, 'UTF-8');
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();
		$dompdf->stream(($type == 'delivery' ? 'Delivery_Slip_' : 'Receiving_Slip_') . $claim->warranty_code . ".pdf", array("Attachment" => 0));
	}

	public function delete() {
		$this->permission_check_with_msg('warranty_delete');
		$id = $this->input->post('id');
		echo $this->warranty->delete_claim($id);
	}
}
