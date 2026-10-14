<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warranty_model extends CI_Model {

	var $table = 'db_warranty as a';
	var $column_order = array('a.id', 'a.warranty_code', 'a.claim_date', 'b.customer_name', 'a.item_name', 'a.serial_no', 'a.expected_delivery_date', 'a.status', 'a.total_charge', null);
	var $column_search = array('a.warranty_code', 'b.customer_name', 'b.mobile', 'a.item_name', 'a.serial_no', 'a.sales_code', 'a.status');
	var $order = array('a.id' => 'desc');

	public function __construct() {
		parent::__construct();
		$this->_check_table();
	}

	private function _check_table() {
		$check = $this->db->query("SHOW TABLES LIKE 'db_warranty'");
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

		if (!empty($this->input->post('status'))) {
			$this->db->where('a.status', $this->input->post('status'));
		}
		if (!empty($this->input->post('customer_id'))) {
			$this->db->where('a.customer_id', $this->input->post('customer_id'));
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
		$this->db->from('db_warranty');
		$this->db->where('store_id', get_current_store_id());
		return $this->db->count_all_results();
	}

	public function generate_warranty_code($store_id) {
		$q = $this->db->query("SELECT coalesce(max(id),0)+1 as next_id FROM db_warranty WHERE store_id = $store_id");
		$next_id = $q->row()->next_id;
		return 'WRN-' . date('Y') . '-' . sprintf("%04d", $next_id);
	}

	public function save_claim() {
		$store_id = get_current_store_id();
		$customer_id = intval($this->input->post('customer_id'));
		$item_id = intval($this->input->post('item_id'));
		$item_name = trim($this->input->post('item_name'));
		$serial_no = trim($this->input->post('serial_no'));
		$sales_code = trim($this->input->post('sales_code'));
		$purchase_date = !empty($this->input->post('purchase_date')) ? system_fromatted_date($this->input->post('purchase_date')) : null;
		$warranty_period_days = intval($this->input->post('warranty_period_days'));
		$warranty_expiry_date = !empty($this->input->post('warranty_expiry_date')) ? system_fromatted_date($this->input->post('warranty_expiry_date')) : null;
		$problem_description = trim($this->input->post('problem_description'));
		$accessories_received = trim($this->input->post('accessories_received'));
		$product_condition = trim($this->input->post('product_condition'));
		$claim_date = !empty($this->input->post('claim_date')) ? system_fromatted_date($this->input->post('claim_date')) : date('Y-m-d');
		$expected_delivery_date = !empty($this->input->post('expected_delivery_date')) ? system_fromatted_date($this->input->post('expected_delivery_date')) : null;

		if (empty($customer_id) || empty($item_name) || empty($problem_description)) {
			return json_encode(array('status' => 'failed', 'message' => 'Please fill Customer, Product Name, and Problem Description.'));
		}

		// Calculate expiry date if purchase date & days given but expiry empty
		if (!empty($purchase_date) && $warranty_period_days > 0 && empty($warranty_expiry_date)) {
			$warranty_expiry_date = date('Y-m-d', strtotime("+$warranty_period_days days", strtotime($purchase_date)));
		}

		$warranty_code = $this->generate_warranty_code($store_id);

		$data = array(
			'store_id'               => $store_id,
			'warranty_code'          => $warranty_code,
			'customer_id'            => $customer_id,
			'sales_id'               => 0,
			'sales_code'             => $sales_code,
			'item_id'                => $item_id,
			'item_name'              => $item_name,
			'serial_no'              => $serial_no,
			'purchase_date'          => $purchase_date,
			'warranty_period_days'   => $warranty_period_days,
			'warranty_expiry_date'   => $warranty_expiry_date,
			'problem_description'    => $problem_description,
			'accessories_received'   => $accessories_received,
			'product_condition'      => $product_condition,
			'claim_date'             => $claim_date,
			'expected_delivery_date' => $expected_delivery_date,
			'delivery_date'          => null,
			'status'                 => 'Received',
			'technician_notes'       => '',
			'action_taken'           => '',
			'service_charge'         => 0,
			'parts_charge'           => 0,
			'total_charge'           => 0,
			'payment_type'           => null,
			'created_by'             => $this->session->userdata('inv_username'),
			'created_date'           => date('Y-m-d'),
			'created_time'           => date('H:i:s')
		);

		$this->db->insert('db_warranty', $data);
		$id = $this->db->insert_id();

		if ($id) {
			return json_encode(array(
				'status'        => 'success',
				'message'       => 'Warranty claim registered successfully!',
				'claim_id'      => $id,
				'warranty_code' => $warranty_code
			));
		} else {
			return json_encode(array('status' => 'failed', 'message' => 'Failed to register warranty claim.'));
		}
	}

	public function get_claim_details($id) {
		$store_id = get_current_store_id();
		$this->db->select('w.*, c.customer_name, c.mobile as customer_mobile, c.email as customer_email, c.address as customer_address, c.city as customer_city, i.item_code, i.sales_price, i.warranty_days as item_warranty_days, a.account_name');
		$this->db->from('db_warranty as w');
		$this->db->join('db_customers as c', 'c.id = w.customer_id', 'left');
		$this->db->join('db_items as i', 'i.id = w.item_id', 'left');
		$this->db->join('ac_accounts as a', 'a.id = w.account_id', 'left');
		$this->db->where('w.id', $id);
		$this->db->where('w.store_id', $store_id);
		return $this->db->get()->row();
	}

	public function update_status() {
		$store_id = get_current_store_id();
		$id = intval($this->input->post('id'));
		$status = $this->input->post('status');
		$technician_notes = trim($this->input->post('technician_notes'));
		$action_taken = trim($this->input->post('action_taken'));
		$service_charge = floatval($this->input->post('service_charge'));
		$parts_charge = floatval($this->input->post('parts_charge'));
		$total_charge = $service_charge + $parts_charge;
		$payment_type = $this->input->post('payment_type');
		$delivered_to = trim($this->input->post('delivered_to'));
		$account_id = intval($this->input->post('account_id'));
		$delivery_date = $this->input->post('delivery_date') ? system_fromatted_date($this->input->post('delivery_date')) : null;

		if ($status == 'Delivered' && empty($delivery_date)) {
			$delivery_date = date('Y-m-d');
		}

		// Retrieve claim details
		$claim = $this->db->where('id', $id)->where('store_id', $store_id)->get('db_warranty')->row();
		if (!$claim) {
			return json_encode(array('status' => 'failed', 'message' => 'Warranty record not found.'));
		}

		if ($status == 'Delivered' && empty($delivered_to)) {
			$cust = $this->db->where('id', $claim->customer_id)->get('db_customers')->row();
			$delivered_to = $cust ? $cust->customer_name : 'Customer';
		}

		$update_data = array(
			'status'           => $status,
			'technician_notes' => $technician_notes,
			'action_taken'     => $action_taken,
			'service_charge'   => $service_charge,
			'parts_charge'     => $parts_charge,
			'total_charge'     => $total_charge,
			'payment_type'     => $payment_type,
			'delivered_to'     => $delivered_to,
			'account_id'       => $account_id
		);
		if (!empty($delivery_date)) {
			$update_data['delivery_date'] = $delivery_date;
		}

		$this->db->where('id', $id)->where('store_id', $store_id)->update('db_warranty', $update_data);

		// Record in Cash/Bank Accounts system if charges were collected
		if ($total_charge > 0) {
			if (empty($account_id)) {
				$cash_acc = $this->db->where('store_id', $store_id)->where('parent_id', 0)->order_by('id', 'asc')->get('ac_accounts')->row();
				$account_id = $cash_acc ? $cash_acc->id : 0;
			}

			if (!empty($account_id) && function_exists('insert_account_transaction')) {
				insert_account_transaction(array(
					'transaction_type'    => 'WARRANTY SERVICE',
					'reference_table_id'  => $id,
					'credit_account_id'   => $account_id,
					'credit_amt'          => $total_charge,
					'debit_amt'           => 0,
					'process'             => 'SAVE',
					'note'                => 'Warranty Service & Delivery Charge for ' . $claim->warranty_code . ' (' . $claim->item_name . ') - ' . $action_taken,
					'transaction_date'    => !empty($delivery_date) ? $delivery_date : date('Y-m-d'),
					'payment_code'        => $claim->warranty_code,
					'customer_id'         => $claim->customer_id,
					'store_id'            => $store_id
				));
			}
		}

		return json_encode(array('status' => 'success', 'message' => ($status == 'Delivered') ? 'Product marked as Delivered and charges recorded successfully!' : 'Status updated successfully!'));
	}

	public function check_warranty($search) {
		$store_id = get_current_store_id();
		$search = trim($search);
		if (empty($search)) {
			return array();
		}

		$results = array();

		// 1. Search in db_warranty by serial_no, warranty_code, or customer mobile
		$q_w = $this->db->query("SELECT w.*, c.customer_name, c.mobile as customer_mobile 
			FROM db_warranty w 
			LEFT JOIN db_customers c ON c.id = w.customer_id 
			WHERE w.store_id = $store_id AND (w.serial_no LIKE '%$search%' OR w.warranty_code LIKE '%$search%' OR c.mobile LIKE '%$search%' OR w.sales_code LIKE '%$search%')
			ORDER BY w.id DESC");
		
		foreach ($q_w->result() as $row) {
			$today = date('Y-m-d');
			$is_under_warranty = false;
			$days_diff = 0;
			$status_text = 'Unknown';

			if (!empty($row->warranty_expiry_date)) {
				$today_dt = new DateTime(date('Y-m-d'));
				$expiry_dt = new DateTime(date('Y-m-d', strtotime($row->warranty_expiry_date)));
				$total_dur = !empty($row->warranty_period_days) ? intval($row->warranty_period_days) : 0;
				if ($today_dt <= $expiry_dt) {
					$is_under_warranty = true;
					$days_diff = $today_dt->diff($expiry_dt)->days;
					if ($total_dur > 0 && $days_diff > $total_dur) { $days_diff = $total_dur; }
					$status_text = ($total_dur > 0) ? "Valid ($days_diff Days Left of $total_dur Days)" : "Valid ($days_diff days remaining)";
				} else {
					$is_under_warranty = false;
					$days_diff = $expiry_dt->diff($today_dt)->days;
					$status_text = "Expired ($days_diff days ago)";
				}
			}

			// Count total times this serial/product came for warranty
			$count_q = $this->db->query("SELECT count(*) as total_claims FROM db_warranty WHERE store_id = $store_id AND serial_no = '" . $this->db->escape_str($row->serial_no) . "' AND serial_no != ''");
			$total_claims = ($count_q && $count_q->num_rows() > 0) ? $count_q->row()->total_claims : 1;

			$results[] = array(
				'source'                 => 'warranty_claim',
				'warranty_code'          => $row->warranty_code,
				'item_id'                => $row->item_id,
				'item_name'              => $row->item_name,
				'serial_no'              => $row->serial_no,
				'customer_id'            => $row->customer_id,
				'customer_name'          => $row->customer_name,
				'customer_mobile'        => $row->customer_mobile,
				'sales_code'             => $row->sales_code,
				'purchase_date'          => $row->purchase_date ? show_date($row->purchase_date) : '-',
				'warranty_period_days'   => $row->warranty_period_days,
				'warranty_expiry_date'   => $row->warranty_expiry_date ? show_date($row->warranty_expiry_date) : '-',
				'is_under_warranty'      => $is_under_warranty,
				'status_text'            => $status_text,
				'total_claims'           => $total_claims,
				'claim_status'           => $row->status
			);
		}

		// 2. Search in db_sales for sales_code or customer mobile with item warranty (ONLY items with warranty > 0)
		$q_sales = $this->db->query("SELECT s.id as sales_id, s.sales_code, s.sales_date, c.id as customer_id, c.customer_name, c.mobile as customer_mobile, si.item_id, si.description, COALESCE(NULLIF(si.warranty_days, 0), i.warranty_days, 0) as warranty_days, i.item_name, i.item_code, i.custom_barcode 
			FROM db_sales s 
			JOIN db_salesitems si ON si.sales_id = s.id 
			JOIN db_items i ON i.id = si.item_id 
			LEFT JOIN db_customers c ON c.id = s.customer_id 
			WHERE s.store_id = $store_id 
			AND (COALESCE(NULLIF(si.warranty_days, 0), i.warranty_days, 0) > 0)
			AND (s.sales_code LIKE '%$search%' OR c.mobile LIKE '%$search%' OR si.description LIKE '%$search%' OR i.item_name LIKE '%$search%' OR i.custom_barcode LIKE '%$search%' OR i.item_code LIKE '%$search%')
			ORDER BY s.id DESC LIMIT 15");

		foreach ($q_sales->result() as $s) {
			$warranty_days = intval($s->warranty_days);
			if ($warranty_days <= 0) {
				continue; // Skip items with no warranty
			}
			$purchase_date_str = date('Y-m-d', strtotime($s->sales_date));
			$purchase_dt = new DateTime($purchase_date_str);
			$today_dt = new DateTime(date('Y-m-d'));
			$expiry_dt = (clone $purchase_dt)->modify("+$warranty_days days");
			$expiry_date = $expiry_dt->format('Y-m-d');

			if ($today_dt > $expiry_dt) {
				$days_expired = $expiry_dt->diff($today_dt)->days;
				$is_under_warranty = false;
				$days_diff = $days_expired;
				$status_text = "Expired ($days_expired days ago)";
			} else {
				$is_under_warranty = true;
				if ($today_dt <= $purchase_dt) {
					// Sold today or future: exactly 0 days elapsed, full warranty intact
					$days_diff = $warranty_days;
				} else {
					$days_passed = $purchase_dt->diff($today_dt)->days;
					$days_diff = max(0, $warranty_days - $days_passed);
				}
				$status_text = "Valid ($days_diff Days Left of $warranty_days Days)";
			}

			// Past claims count
			$count_q = $this->db->query("SELECT count(*) as total_claims FROM db_warranty WHERE store_id = $store_id AND (sales_code = '{$s->sales_code}' OR (customer_id = {$s->customer_id} AND item_id = {$s->item_id}))");
			$total_claims = ($count_q && $count_q->num_rows() > 0) ? $count_q->row()->total_claims : 0;

			$results[] = array(
				'source'                 => 'sales_invoice',
				'warranty_code'          => '-',
				'item_id'                => $s->item_id,
				'item_name'              => $s->item_name,
				'serial_no'              => $s->description,
				'customer_id'            => $s->customer_id,
				'customer_name'          => $s->customer_name,
				'customer_mobile'        => $s->customer_mobile,
				'sales_code'             => $s->sales_code,
				'purchase_date'          => show_date($purchase_date_str),
				'warranty_period_days'   => $warranty_days,
				'warranty_expiry_date'   => show_date($expiry_date),
				'is_under_warranty'      => $is_under_warranty,
				'status_text'            => $status_text,
				'total_claims'           => $total_claims,
				'claim_status'           => 'Sold (Warranty active from ' . show_date($purchase_date_str) . ')'
			);
		}

		// 3. Search in-stock products in db_items (UNSOLD items in inventory)
		// For in-stock items, warranty countdown DOES NOT start until sold! Full days remain intact.
		$q_stock = $this->db->query("SELECT i.id, i.item_name, i.item_code, i.custom_barcode, i.warranty_days, i.stock, i.item_serials
			FROM db_items i
			WHERE i.store_id = $store_id
			AND i.warranty_days > 0
			AND (i.stock > 0 OR i.status = 1)
			AND (i.item_name LIKE '%$search%' OR i.custom_barcode LIKE '%$search%' OR i.item_code LIKE '%$search%' OR i.item_serials LIKE '%$search%')
			ORDER BY i.id DESC LIMIT 10");

		foreach ($q_stock->result() as $stk) {
			$warranty_days = intval($stk->warranty_days);
			if ($warranty_days <= 0) continue;

			// Check available serials for this item
			$serials_list = array();
			$sq = $this->db->query("SELECT serial_code FROM db_item_serials WHERE item_id = {$stk->id} AND status = 'Available'");
			if($sq->num_rows() > 0){
				foreach($sq->result() as $s_row){
					$serials_list[] = $s_row->serial_code;
				}
			}

			$serial_display = !empty($serials_list) ? implode(', ', array_slice($serials_list, 0, 5)) . (count($serials_list) > 5 ? '... (+' . (count($serials_list) - 5) . ' more)' : '') : 'Stock Item';

			$results[] = array(
				'source'                 => 'in_stock',
				'warranty_code'          => '-',
				'item_id'                => $stk->id,
				'item_name'              => $stk->item_name,
				'serial_no'              => $serial_display,
				'customer_id'            => 0,
				'customer_name'          => 'In Stock (Unsold)',
				'customer_mobile'        => '-',
				'sales_code'             => 'Not Sold Yet',
				'purchase_date'          => 'In Stock (' . format_qty($stk->stock) . ' available)',
				'warranty_period_days'   => $warranty_days,
				'warranty_expiry_date'   => 'Starts upon Sale (Full ' . $warranty_days . ' Days)',
				'is_under_warranty'      => true,
				'status_text'            => 'In Stock (' . $warranty_days . ' Days Warranty)',
				'total_claims'           => 0,
				'claim_status'           => 'In Stock (Unsold)'
			);
		}

		return $results;
	}

	public function get_service_history($search) {
		$store_id = get_current_store_id();
		$search = trim($search);

		$this->db->select('w.*, c.customer_name, c.mobile as customer_mobile');
		$this->db->from('db_warranty as w');
		$this->db->join('db_customers as c', 'c.id = w.customer_id', 'left');
		$this->db->where('w.store_id', $store_id);

		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('w.serial_no', $search);
			$this->db->or_like('w.item_name', $search);
			$this->db->or_like('w.warranty_code', $search);
			$this->db->or_like('c.mobile', $search);
			$this->db->or_like('c.customer_name', $search);
			$this->db->group_end();
		}

		$this->db->order_by('w.id', 'desc');
		return $this->db->get()->result();
	}

	public function delete_claim($id) {
		$store_id = get_current_store_id();
		$this->db->where('id', $id)->where('store_id', $store_id)->delete('db_warranty');
		return ($this->db->affected_rows() > 0) ? 'success' : 'failed';
	}
}
