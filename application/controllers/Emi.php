<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Emi extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load_global();
		$this->load->model('Emi_model', 'emi');
	}

	public function index() {
		$this->permission_check('emi_view');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('emi_list');
		$this->load->view('emi/emi_list', $data);
	}

	public function add() {
		$this->permission_check('emi_add');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('new_emi_plan');
		$this->load->view('emi/emi_add', $data);
	}

	public function save() {
		$this->permission_check_with_msg('emi_add');
		echo $this->emi->save_emi_plan();
	}

	public function collection() {
		$this->permission_check('emi_view');
		$data = $this->data;
		$data['page_title'] = 'EMI Collection & Installment Management';
		$data['kpis'] = $this->emi->get_collection_kpis();
		$this->load->view('emi/emi_collection', $data);
	}

	public function ajax_collection() {
		$this->permission_check_with_msg('emi_view');
		$list = $this->emi->get_collection_datatables();

		$data = array();
		$today = date('Y-m-d');
		foreach ($list as $rec) {
			$row = array();
			
			// 0. Plan Code & Item
			$row[] = '<a href="' . base_url('emi/details/' . $rec->emi_id) . '" class="text-bold text-primary" title="View Plan Ledger">' . $rec->emi_code . '</a><br><small class="text-muted">' . html_escape(character_limiter($rec->item_details, 25)) . '</small>';
			
			// 1. Customer
			$row[] = '<strong>' . html_escape($rec->customer_name) . '</strong><br><small><i class="fa fa-phone text-muted"></i> ' . html_escape($rec->customer_mobile) . '</small>';
			
			// 2. Installment No
			$row[] = '<span class="badge bg-purple" style="font-size: 13px;">#' . $rec->installment_no . ' of ' . $rec->total_installments . '</span>';
			
			// 3. Due Date
			$is_overdue = ($rec->status != 'Paid' && strtotime($rec->due_date) < strtotime($today));
			$date_html = show_date($rec->due_date);
			if ($is_overdue) {
				$days_over = floor((strtotime($today) - strtotime($rec->due_date)) / 86400);
				$date_html .= '<br><span class="label label-danger">' . $days_over . 'd Overdue</span>';
			} else if ($rec->status != 'Paid' && $rec->due_date == $today) {
				$date_html .= '<br><span class="label label-warning">Due Today</span>';
			}
			$row[] = $date_html;
			
			// 4. Installment Amount
			$row[] = $this->currency($rec->amount);
			
			// 5. Paid Amount
			$row[] = '<span class="text-green text-bold">' . $this->currency($rec->paid_amount) . '</span>';
			
			// 6. Due Balance
			$inst_due = max(0, $rec->amount - $rec->paid_amount);
			$row[] = '<span class="text-red text-bold">' . $this->currency($inst_due) . '</span>';
			
			// 7. Plan Installment Progress (Months Paid vs Due)
			$paid_cnt = intval($rec->paid_count);
			$due_cnt = intval($rec->due_count);
			$tot_cnt = intval($rec->total_installments);
			$pct = ($tot_cnt > 0) ? round(($paid_cnt / $tot_cnt) * 100) : 0;
			$progress_html = '<div style="min-width: 110px;">
				<small class="text-bold text-success">' . $paid_cnt . ' Paid</small> / <small class="text-bold text-danger">' . $due_cnt . ' Due</small>
				<div class="progress progress-xs" style="margin-top: 3px; margin-bottom: 0; background: #e2e8f0;">
					<div class="progress-bar progress-bar-success" style="width: ' . $pct . '%"></div>
				</div>
			</div>';
			$row[] = $progress_html;
			
			// 8. Status Badge
			if ($rec->status == 'Paid') {
				$status_badge = '<span class="label label-success"><i class="fa fa-check"></i> Paid</span>';
			} else if ($is_overdue) {
				$status_badge = '<span class="label label-danger"><i class="fa fa-clock-o"></i> Overdue</span>';
			} else if ($rec->status == 'Partial') {
				$status_badge = '<span class="label label-warning"><i class="fa fa-adjust"></i> Partial</span>';
			} else {
				$status_badge = '<span class="label label-info"><i class="fa fa-hourglass-half"></i> Pending</span>';
			}
			$row[] = $status_badge;
			
			// 9. Actions
			$actions = '';
			if ($this->permissions('emi_payment') && $rec->status != 'Paid') {
				$actions .= '<button type="button" class="btn btn-xs btn-success btn-flat" onclick="open_collection_pay_modal(' . $rec->id . ', ' . $rec->emi_id . ', \'' . $rec->emi_code . '\', \'' . addslashes(html_escape($rec->customer_name)) . '\', ' . $rec->installment_no . ', ' . $inst_due . ', \'' . show_date($rec->due_date) . '\')">
					<i class="fa fa-money"></i> Receive
				</button> ';
			}
			$actions .= '<a href="' . base_url('emi/details/' . $rec->emi_id) . '" class="btn btn-xs btn-default btn-flat" title="View EMI Plan"><i class="fa fa-eye text-primary"></i></a>';
			$row[] = $actions;

			$data[] = $row;
		}

		$output = array(
			"draw"            => isset($_POST['draw']) ? $_POST['draw'] : 1,
			"recordsTotal"    => $this->emi->count_collection_all(),
			"recordsFiltered" => $this->emi->count_collection_filtered(),
			"data"            => $data,
		);
		echo json_encode($output);
	}

	public function ajax_list() {
		$this->permission_check_with_msg('emi_view');
		$list = $this->emi->get_datatables();

		$data = array();
		$no = isset($_POST['start']) ? $_POST['start'] : 0;
		foreach ($list as $rec) {
			$no++;
			$row = array();
			$row[] = '<span class="text-bold text-primary">' . $rec->emi_code . '</span>';
			$row[] = show_date($rec->start_date);
			$row[] = '<strong>' . html_escape($rec->customer_name) . '</strong><br><small class="text-muted">' . html_escape($rec->customer_mobile) . '</small>';
			$row[] = html_escape($rec->item_details);
			$row[] = $this->currency($rec->total_payable);
			$row[] = $this->currency($rec->down_payment);
			$row[] = '<span class="text-green text-bold">' . $this->currency($rec->paid_amount) . '</span>';
			$row[] = '<span class="text-red text-bold">' . $this->currency($rec->due_amount) . '</span>';
			$row[] = '<span class="label label-info">' . $rec->total_installments . ' (' . $rec->emi_frequency . ')</span>';

			// Status badge
			if ($rec->status == 'Completed' || $rec->due_amount <= 0) {
				$status_badge = '<span class="label label-success">Completed</span>';
			} else {
				$status_badge = '<span class="label label-warning">Active</span>';
			}
			$row[] = $status_badge;

			// Actions
			$actions = '<div class="btn-group">
				<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
					Action <span class="caret"></span>
				</button>
				<ul class="dropdown-menu dropdown-menu-right" role="menu">';

			if ($this->permissions('emi_view')) {
				$actions .= '<li><a href="' . base_url('emi/details/' . $rec->id) . '"><i class="fa fa-book text-primary"></i> View Book / Ledger</a></li>';
			}

			if ($this->permissions('emi_payment') && $rec->status != 'Completed' && $rec->due_amount > 0) {
				$actions .= '<li><a href="javascript:void(0)" onclick="quick_pay_modal(' . $rec->id . ')"><i class="fa fa-money text-green"></i> Pay Installment</a></li>';
			}

			if ($this->permissions('emi_view')) {
				$actions .= '<li><a href="' . base_url('emi/print_ledger/' . $rec->id) . '" target="_blank"><i class="fa fa-print text-info"></i> Print Statement</a></li>';
				$actions .= '<li><a href="' . base_url('emi/pdf_ledger/' . $rec->id) . '" target="_blank"><i class="fa fa-file-pdf-o text-red"></i> PDF Statement</a></li>';
			}

			if ($this->permissions('emi_delete')) {
				$actions .= '<li class="divider"></li>';
				$actions .= '<li><a href="javascript:void(0)" onclick="delete_emi(' . $rec->id . ')" class="text-red"><i class="fa fa-trash text-red"></i> Delete Plan</a></li>';
			}

			$actions .= '</ul></div>';
			$row[] = $actions;

			$data[] = $row;
		}

		$output = array(
			"draw"            => isset($_POST['draw']) ? $_POST['draw'] : 1,
			"recordsTotal"    => $this->emi->count_all(),
			"recordsFiltered" => $this->emi->count_filtered(),
			"data"            => $data,
		);
		echo json_encode($output);
	}

	public function details($id) {
		$this->belong_to('db_emi', $id);
		$this->permission_check('emi_view');

		$details = $this->emi->get_emi_details($id);
		if (!$details) {
			show_404();
		}

		$data = $this->data;
		$data['page_title'] = $this->lang->line('emi_details') . ' - ' . $details['emi']->emi_code;
		$data['emi'] = $details['emi'];
		$data['installments'] = $details['installments'];
		$data['payments'] = $details['payments'];

		$this->load->view('emi/emi_details', $data);
	}

	public function pay_installment() {
		$this->permission_check_with_msg('emi_payment');
		echo $this->emi->pay_installment();
	}

	public function get_installment_info($id) {
		$this->permission_check_with_msg('emi_payment');
		$store_id = get_current_store_id();
		$row = $this->db->where('id', $id)->where('store_id', $store_id)->get('db_emi_installments')->row();
		echo json_encode($row);
	}

	public function print_receipt($payment_id) {
		$this->permission_check('emi_view');
		$receipt = $this->emi->get_payment_receipt($payment_id);
		if (!$receipt) {
			show_error("Receipt Not Found", 404);
		}

		$data = $this->data;
		$data['page_title'] = $this->lang->line('emi_receipt') . ' #' . $receipt->receipt_no;
		$data['receipt'] = $receipt;
		$this->load->view('emi/emi_receipt', $data);
	}

	public function pdf_receipt($payment_id) {
		$this->permission_check('emi_view');
		$receipt = $this->emi->get_payment_receipt($payment_id);
		if (!$receipt) {
			show_error("Receipt Not Found", 404);
		}

		$data = $this->data;
		$data['page_title'] = $this->lang->line('emi_receipt') . ' #' . $receipt->receipt_no;
		$data['receipt'] = $receipt;
		$data['is_pdf'] = true;

		$this->load->view('emi/emi_receipt', $data);

		$html = $this->output->get_output();
		$options = new Options();
		$options->set('isRemoteEnabled', true);
		$dompdf = new Dompdf($options);
		$dompdf->loadHtml($html, 'UTF-8');
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();
		$dompdf->stream("EMI_Receipt_" . $receipt->receipt_no . ".pdf", array("Attachment" => 0));
	}

	public function print_ledger($id) {
		$this->belong_to('db_emi', $id);
		$this->permission_check('emi_view');

		$details = $this->emi->get_emi_details($id);
		if (!$details) {
			show_404();
		}

		$data = $this->data;
		$data['page_title'] = 'EMI Statement - ' . $details['emi']->emi_code;
		$data['emi'] = $details['emi'];
		$data['installments'] = $details['installments'];
		$data['payments'] = $details['payments'];

		$this->load->view('emi/emi_ledger_print', $data);
	}

	public function pdf_ledger($id) {
		$this->belong_to('db_emi', $id);
		$this->permission_check('emi_view');

		$details = $this->emi->get_emi_details($id);
		if (!$details) {
			show_404();
		}

		$data = $this->data;
		$data['page_title'] = 'EMI Statement - ' . $details['emi']->emi_code;
		$data['emi'] = $details['emi'];
		$data['installments'] = $details['installments'];
		$data['payments'] = $details['payments'];
		$data['is_pdf'] = true;

		$this->load->view('emi/emi_ledger_print', $data);

		$html = $this->output->get_output();
		$options = new Options();
		$options->set('isRemoteEnabled', true);
		$dompdf = new Dompdf($options);
		$dompdf->loadHtml($html, 'UTF-8');
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();
		$dompdf->stream("EMI_Statement_" . $details['emi']->emi_code . ".pdf", array("Attachment" => 0));
	}

	public function delete() {
		$this->permission_check_with_msg('emi_delete');
		$id = $this->input->post('id');
		echo $this->emi->delete_emi($id);
	}
}
