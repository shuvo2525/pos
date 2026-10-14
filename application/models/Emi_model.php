<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emi_model extends CI_Model {

	var $table = 'db_emi as a';
	var $column_order = array('a.id', 'a.emi_code', 'a.created_date', 'b.customer_name', 'a.item_details', 'a.total_amount', 'a.down_payment', 'a.paid_amount', 'a.due_amount', 'a.emi_frequency', 'a.status', null);
	var $column_search = array('a.emi_code', 'b.customer_name', 'b.mobile', 'a.item_details', 'a.status');
	var $order = array('a.id' => 'desc');

	var $col_column_order = array('i.id', 'e.emi_code', 'c.customer_name', 'i.installment_no', 'i.due_date', 'i.amount', 'i.paid_amount', null, null, 'i.status', null);
	var $col_column_search = array('e.emi_code', 'c.customer_name', 'c.mobile', 'e.item_details', 'i.status');

	public function __construct() {
		parent::__construct();
		$this->_check_table();
	}

	private function _check_table() {
		$check = $this->db->query("SHOW TABLES LIKE 'db_emi'");
		if (!$check->num_rows()) {
			$this->load->model('updates_model');
			$this->updates_model->index();
		}
	}

	private function _get_datatables_query() {
		$this->db->select('a.*, b.customer_name, b.mobile as customer_mobile');
		$this->db->from($this->table);
		$this->db->join('db_customers as b', 'b.id = a.customer_id', 'left');
		$this->db->where('a.store_id', get_current_store_id());

		if (!empty($this->input->post('customer_id'))) {
			$this->db->where('a.customer_id', $this->input->post('customer_id'));
		}
		if (!empty($this->input->post('status'))) {
			$this->db->where('a.status', $this->input->post('status'));
		}

		$i = 0;
		foreach ($this->column_search as $item) {
			if (isset($_POST['search']['value']) && !empty($_POST['search']['value'])) {
				if ($i === 0) {
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if (count($this->column_search) - 1 == $i) {
					$this->db->group_end();
				}
			}
			$i++;
		}

		if (isset($_POST['order'])) {
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	public function get_datatables() {
		$this->_get_datatables_query();
		if (isset($_POST['length']) && $_POST['length'] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get();
		return $query->result();
	}

	public function count_filtered() {
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all() {
		$this->db->from('db_emi');
		$this->db->where('store_id', get_current_store_id());
		return $this->db->count_all_results();
	}

	public function generate_emi_code($store_id) {
		$q = $this->db->query("SELECT coalesce(max(id),0)+1 as next_id FROM db_emi WHERE store_id = $store_id");
		$next_id = $q->row()->next_id;
		return 'EMI-' . date('Y') . '-' . sprintf("%04d", $next_id);
	}

	public function generate_receipt_no($store_id) {
		$q = $this->db->query("SELECT coalesce(max(id),0)+1 as next_id FROM db_emi_payments WHERE store_id = $store_id");
		$next_id = $q->row()->next_id;
		return 'REC-' . date('Y') . '-' . sprintf("%05d", $next_id);
	}

	public function save_emi_plan() {
		$store_id = get_current_store_id();
		$customer_id = $this->input->post('customer_id');
		$sales_id = $this->input->post('sales_id') ? $this->input->post('sales_id') : 0;
		$item_details = trim($this->input->post('item_details'));
		$total_amount = floatval($this->input->post('total_amount'));
		$down_payment = floatval($this->input->post('down_payment'));
		$interest_rate = floatval($this->input->post('interest_rate'));
		$emi_frequency = $this->input->post('emi_frequency'); // Monthly or Weekly
		$total_installments = intval($this->input->post('total_installments'));
		$start_date = system_fromatted_date($this->input->post('start_date'));
		$payment_type = $this->input->post('payment_type');
		$notes = trim($this->input->post('notes'));

		if (empty($customer_id) || empty($item_details) || $total_amount <= 0 || $total_installments <= 0 || empty($start_date)) {
			return json_encode(array('status' => 'failed', 'message' => 'Please fill all required fields correctly.'));
		}

		$financed_amount = $total_amount - $down_payment;
		if ($financed_amount < 0) {
			return json_encode(array('status' => 'failed', 'message' => 'Down payment cannot be greater than total amount.'));
		}

		$interest_amount = ($financed_amount * $interest_rate) / 100;
		$total_payable = $financed_amount + $interest_amount;
		$installment_amount = round($total_payable / $total_installments, 2);

		// Calculate end date based on installments and frequency
		$date_step = ($emi_frequency == 'Weekly') ? '+1 week' : '+1 month';
		$end_date_ts = strtotime($start_date);
		for ($i = 1; $i < $total_installments; $i++) {
			$end_date_ts = strtotime($date_step, $end_date_ts);
		}
		$end_date = date('Y-m-d', $end_date_ts);

		$this->db->trans_begin();

		$emi_code = $this->generate_emi_code($store_id);

		$emi_data = array(
			'store_id'            => $store_id,
			'emi_code'            => $emi_code,
			'customer_id'         => $customer_id,
			'sales_id'            => $sales_id,
			'item_details'        => $item_details,
			'total_amount'        => $total_amount,
			'down_payment'        => $down_payment,
			'financed_amount'     => $financed_amount,
			'interest_rate'       => $interest_rate,
			'interest_amount'     => $interest_amount,
			'total_payable'       => $total_payable,
			'emi_frequency'       => $emi_frequency,
			'total_installments'  => $total_installments,
			'installment_amount'  => $installment_amount,
			'paid_amount'         => 0,
			'due_amount'          => $total_payable,
			'start_date'          => $start_date,
			'end_date'            => $end_date,
			'status'              => 'Active',
			'notes'               => $notes,
			'created_by'          => $this->session->userdata('inv_username'),
			'created_date'        => date('Y-m-d'),
			'created_time'        => date('H:i:s')
		);

		$this->db->insert('db_emi', $emi_data);
		$emi_id = $this->db->insert_id();

		// Generate installments schedule
		$cur_date_ts = strtotime($start_date);
		$installments_batch = array();
		for ($n = 1; $n <= $total_installments; $n++) {
			$due_d = date('Y-m-d', $cur_date_ts);
			$installments_batch[] = array(
				'emi_id'         => $emi_id,
				'store_id'       => $store_id,
				'installment_no' => $n,
				'due_date'       => $due_d,
				'amount'         => $installment_amount,
				'paid_amount'    => 0,
				'payment_date'   => null,
				'payment_type'   => null,
				'payment_note'   => null,
				'status'         => 'Pending'
			);
			$cur_date_ts = strtotime($date_step, $cur_date_ts);
		}

		$this->db->insert_batch('db_emi_installments', $installments_batch);

		// Record down payment if given
		$receipt_id = 0;
		if ($down_payment > 0) {
			$receipt_no = $this->generate_receipt_no($store_id);
			$account_id = intval($this->input->post('account_id'));
			if (empty($account_id)) {
				$cash_acc = $this->db->where('store_id', $store_id)->where('parent_id', 0)->order_by('id', 'asc')->get('ac_accounts')->row();
				$account_id = $cash_acc ? $cash_acc->id : 0;
			}

			$down_pmt = array(
				'emi_id'         => $emi_id,
				'installment_id' => 0, // 0 indicates down payment
				'store_id'       => $store_id,
				'receipt_no'     => $receipt_no,
				'payment_date'   => date('Y-m-d'),
				'payment_amount' => $down_payment,
				'payment_type'   => !empty($payment_type) ? $payment_type : 'Cash',
				'account_id'     => $account_id,
				'payment_note'   => 'Down Payment on EMI Plan Creation',
				'created_by'     => $this->session->userdata('inv_username'),
				'created_date'   => date('Y-m-d'),
				'created_time'   => date('H:i:s')
			);
			$this->db->insert('db_emi_payments', $down_pmt);
			$receipt_id = $this->db->insert_id();

			// Record into Cash/Bank Accounts system
			if (!empty($account_id) && function_exists('insert_account_transaction')) {
				insert_account_transaction(array(
					'transaction_type'   => 'EMI PAYMENT',
					'reference_table_id' => $receipt_id,
					'credit_account_id'  => $account_id,
					'credit_amt'         => $down_payment,
					'debit_amt'          => 0,
					'process'            => 'SAVE',
					'note'               => 'EMI Down Payment for Plan ' . $emi_code . ' (' . $item_details . ')',
					'transaction_date'   => date('Y-m-d'),
					'payment_code'       => $receipt_no,
					'customer_id'        => $customer_id,
					'store_id'           => $store_id
				));
			}
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return json_encode(array('status' => 'failed', 'message' => 'Failed to save EMI Plan. Please try again.'));
		} else {
			$this->db->trans_commit();
			return json_encode(array(
				'status'     => 'success',
				'message'    => 'EMI Plan created successfully!',
				'emi_id'     => $emi_id,
				'receipt_id' => $receipt_id
			));
		}
	}

	public function get_emi_details($id) {
		$store_id = get_current_store_id();
		$this->db->select('a.*, b.customer_name, b.mobile as customer_mobile, b.email as customer_email, b.address as customer_address, b.city as customer_city');
		$this->db->from('db_emi as a');
		$this->db->join('db_customers as b', 'b.id = a.customer_id', 'left');
		$this->db->where('a.id', $id);
		$this->db->where('a.store_id', $store_id);
		$emi = $this->db->get()->row();

		if (!$emi) {
			return false;
		}

		// Get installments
		$this->db->where('emi_id', $id);
		$this->db->order_by('installment_no', 'asc');
		$installments = $this->db->get('db_emi_installments')->result();

		// Get payments
		$this->db->where('emi_id', $id);
		$this->db->order_by('id', 'desc');
		$payments = $this->db->get('db_emi_payments')->result();

		return array(
			'emi'          => $emi,
			'installments' => $installments,
			'payments'     => $payments
		);
	}

	public function pay_installment() {
		$store_id = get_current_store_id();
		$emi_id = intval($this->input->post('emi_id'));
		$installment_id = intval($this->input->post('installment_id'));
		$payment_amount = floatval($this->input->post('payment_amount'));
		$payment_date = system_fromatted_date($this->input->post('payment_date'));
		$payment_type = $this->input->post('payment_type');
		$payment_note = trim($this->input->post('payment_note'));

		if (empty($emi_id) || empty($installment_id) || $payment_amount <= 0 || empty($payment_date) || empty($payment_type)) {
			return json_encode(array('status' => 'failed', 'message' => 'Please fill all required payment fields.'));
		}

		// Verify installment
		$inst = $this->db->where('id', $installment_id)->where('emi_id', $emi_id)->where('store_id', $store_id)->get('db_emi_installments')->row();
		if (!$inst) {
			return json_encode(array('status' => 'failed', 'message' => 'Installment record not found.'));
		}

		$this->db->trans_begin();

		// Generate payment receipt
		$receipt_no = $this->generate_receipt_no($store_id);

		$account_id = intval($this->input->post('account_id'));
		if (empty($account_id)) {
			$cash_acc = $this->db->where('store_id', $store_id)->where('parent_id', 0)->order_by('id', 'asc')->get('ac_accounts')->row();
			$account_id = $cash_acc ? $cash_acc->id : 0;
		}

		$pmt_data = array(
			'emi_id'         => $emi_id,
			'installment_id' => $installment_id,
			'store_id'       => $store_id,
			'receipt_no'     => $receipt_no,
			'payment_date'   => $payment_date,
			'payment_amount' => $payment_amount,
			'payment_type'   => $payment_type,
			'account_id'     => $account_id,
			'payment_note'   => $payment_note,
			'created_by'     => $this->session->userdata('inv_username'),
			'created_date'   => date('Y-m-d'),
			'created_time'   => date('H:i:s')
		);
		$this->db->insert('db_emi_payments', $pmt_data);
		$payment_id = $this->db->insert_id();

		// Record in Cash/Bank Accounts system
		if ($payment_amount > 0 && !empty($account_id) && function_exists('insert_account_transaction')) {
			$emi_rec = $this->db->where('id', $emi_id)->get('db_emi')->row();
			$note_str = 'EMI Installment #' . $inst->installment_no . ' for ' . ($emi_rec ? $emi_rec->emi_code : 'EMI') . ' - ' . ($payment_note ? $payment_note : 'Installment Payment');
			insert_account_transaction(array(
				'transaction_type'   => 'EMI PAYMENT',
				'reference_table_id' => $payment_id,
				'credit_account_id'  => $account_id,
				'credit_amt'         => $payment_amount,
				'debit_amt'          => 0,
				'process'            => 'SAVE',
				'note'               => $note_str,
				'transaction_date'   => $payment_date,
				'payment_code'       => $receipt_no,
				'customer_id'        => $emi_rec ? $emi_rec->customer_id : null,
				'store_id'           => $store_id
			));
		}

		// Update installment
		$new_paid = $inst->paid_amount + $payment_amount;
		$inst_status = ($new_paid >= $inst->amount) ? 'Paid' : 'Partial';

		$this->db->where('id', $installment_id)->update('db_emi_installments', array(
			'paid_amount'  => $new_paid,
			'payment_date' => $payment_date,
			'payment_type' => $payment_type,
			'payment_note' => $payment_note,
			'status'       => $inst_status
		));

		// Update Master EMI record
		$total_paid_q = $this->db->query("SELECT coalesce(sum(paid_amount),0) as tot_paid FROM db_emi_installments WHERE emi_id = $emi_id AND store_id = $store_id");
		$total_paid = $total_paid_q->row()->tot_paid;

		$emi_rec = $this->db->where('id', $emi_id)->get('db_emi')->row();
		$due_amount = max(0, $emi_rec->total_payable - $total_paid);
		$emi_status = ($due_amount <= 0) ? 'Completed' : 'Active';

		$this->db->where('id', $emi_id)->update('db_emi', array(
			'paid_amount' => $total_paid,
			'due_amount'  => $due_amount,
			'status'      => $emi_status
		));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return json_encode(array('status' => 'failed', 'message' => 'Error recording payment.'));
		} else {
			$this->db->trans_commit();
			return json_encode(array(
				'status'     => 'success',
				'message'    => 'Payment received successfully!',
				'receipt_id' => $payment_id,
				'receipt_no' => $receipt_no
			));
		}
	}

	public function get_payment_receipt($payment_id) {
		$store_id = get_current_store_id();
		$this->db->select('p.*, e.emi_code, e.item_details, e.total_amount, e.down_payment, e.financed_amount, e.total_payable, e.paid_amount as emi_paid_amount, e.due_amount as emi_due_amount, e.emi_frequency, e.total_installments, e.installment_amount, c.customer_name, c.mobile as customer_mobile, c.email as customer_email, c.address as customer_address, c.city as customer_city, i.installment_no, i.due_date, i.amount as inst_amount');
		$this->db->from('db_emi_payments as p');
		$this->db->join('db_emi as e', 'e.id = p.emi_id', 'left');
		$this->db->join('db_customers as c', 'c.id = e.customer_id', 'left');
		$this->db->join('db_emi_installments as i', 'i.id = p.installment_id', 'left');
		$this->db->where('p.id', $payment_id);
		$this->db->where('p.store_id', $store_id);
		return $this->db->get()->row();
	}

	public function delete_emi($id) {
		$store_id = get_current_store_id();
		$this->db->trans_begin();
		$this->db->where('id', $id)->where('store_id', $store_id)->delete('db_emi');
		$this->db->where('emi_id', $id)->where('store_id', $store_id)->delete('db_emi_installments');
		$this->db->where('emi_id', $id)->where('store_id', $store_id)->delete('db_emi_payments');

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return 'failed';
		} else {
			$this->db->trans_commit();
			return 'success';
		}
	}

	private function _get_collection_datatables_query() {
		$store_id = get_current_store_id();
		$this->db->select("i.*, (i.amount - i.paid_amount) as inst_due, e.emi_code, e.item_details, e.total_installments, e.installment_amount as plan_inst_amt, e.total_payable, e.paid_amount as plan_paid_amount, e.due_amount as plan_due_amount, e.emi_frequency, e.status as plan_status, c.id as customer_id, c.customer_name, c.mobile as customer_mobile,
			(SELECT count(*) FROM db_emi_installments WHERE emi_id = e.id AND status = 'Paid') as paid_count,
			(SELECT count(*) FROM db_emi_installments WHERE emi_id = e.id AND status != 'Paid') as due_count");
		$this->db->from('db_emi_installments as i');
		$this->db->join('db_emi as e', 'e.id = i.emi_id', 'inner');
		$this->db->join('db_customers as c', 'c.id = e.customer_id', 'left');
		$this->db->where('i.store_id', $store_id);

		// Status filter: All, Pending, Overdue, Paid
		$status = $this->input->post('status');
		$today = date('Y-m-d');
		if ($status == 'Paid') {
			$this->db->where('i.status', 'Paid');
		} else if ($status == 'Overdue') {
			$this->db->where('i.status !=', 'Paid');
			$this->db->where('i.due_date <', $today);
		} else if ($status == 'Pending') {
			$this->db->where('i.status !=', 'Paid');
			$this->db->where('i.due_date >=', $today);
		} else if ($status == 'Due') {
			$this->db->where('i.status !=', 'Paid');
		}

		if (!empty($this->input->post('customer_id'))) {
			$this->db->where('e.customer_id', $this->input->post('customer_id'));
		}

		if (!empty($this->input->post('month_year'))) {
			$this->db->like('i.due_date', $this->input->post('month_year'), 'after');
		}

		$i = 0;
		foreach ($this->col_column_search as $item) {
			if (isset($_POST['search']['value']) && !empty($_POST['search']['value'])) {
				if ($i === 0) {
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if (count($this->col_column_search) - 1 == $i) {
					$this->db->group_end();
				}
			}
			$i++;
		}

		if (isset($_POST['order'])) {
			$col_idx = $_POST['order']['0']['column'];
			if (isset($this->col_column_order[$col_idx]) && $this->col_column_order[$col_idx] !== null) {
				$this->db->order_by($this->col_column_order[$col_idx], $_POST['order']['0']['dir']);
			}
		} else {
			$this->db->order_by('i.due_date', 'asc');
		}
	}

	public function get_collection_datatables() {
		$this->_get_collection_datatables_query();
		if (isset($_POST['length']) && $_POST['length'] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get();
		return $query->result();
	}

	public function count_collection_filtered() {
		$this->_get_collection_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_collection_all() {
		$this->db->from('db_emi_installments');
		$this->db->where('store_id', get_current_store_id());
		return $this->db->count_all_results();
	}

	public function get_collection_kpis() {
		$store_id = get_current_store_id();
		$today = date('Y-m-d');
		$cur_month = date('Y-m');

		// 1. Total Collected
		$q_col = $this->db->query("SELECT coalesce(sum(payment_amount),0) as total_collected FROM db_emi_payments WHERE store_id = $store_id");
		$total_collected = $q_col->row()->total_collected;

		// 2. Total Due across active plans
		$q_due = $this->db->query("SELECT coalesce(sum(due_amount),0) as total_due FROM db_emi WHERE store_id = $store_id AND status != 'Completed'");
		$total_due = $q_due->row()->total_due;

		// 3. Overdue (due_date < today AND status != 'Paid')
		$q_overdue = $this->db->query("SELECT count(*) as overdue_count, coalesce(sum(amount - paid_amount),0) as overdue_amount 
			FROM db_emi_installments 
			WHERE store_id = $store_id AND status != 'Paid' AND due_date < '$today'");
		$overdue_count = $q_overdue->row()->overdue_count;
		$overdue_amount = $q_overdue->row()->overdue_amount;

		// 4. Today's Due
		$q_today = $this->db->query("SELECT count(*) as today_count, coalesce(sum(amount - paid_amount),0) as today_amount 
			FROM db_emi_installments 
			WHERE store_id = $store_id AND status != 'Paid' AND due_date = '$today'");
		$today_count = $q_today->row()->today_count;
		$today_amount = $q_today->row()->today_amount;

		// 5. This Month's Due
		$q_month = $this->db->query("SELECT count(*) as month_count, coalesce(sum(amount - paid_amount),0) as month_amount 
			FROM db_emi_installments 
			WHERE store_id = $store_id AND status != 'Paid' AND due_date LIKE '$cur_month%'");
		$month_count = $q_month->row()->month_count;
		$month_amount = $q_month->row()->month_amount;

		return array(
			'total_collected' => $total_collected,
			'total_due'       => $total_due,
			'overdue_count'   => $overdue_count,
			'overdue_amount'  => $overdue_amount,
			'today_count'     => $today_count,
			'today_amount'    => $today_amount,
			'month_count'     => $month_count,
			'month_amount'    => $month_amount
		);
	}
}
