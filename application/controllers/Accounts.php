<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('accounts_model','accounts');
	}
	public function index()
	{
		$this->permission_check('accounts_view');
		$data=$this->data;
		$data['page_title']=$this->lang->line('accounts_list');
		$this->load->view('accounts/accounts_list',$data);
	}

	public function book($account_id)
	{
		$this->belong_to('ac_accounts',$account_id);
		$this->permission_check('accounts_view');
		$data=$this->data;
		$data['page_title']=$this->lang->line('account_book');
		$data['account_id']=$account_id;
		$this->load->view('accounts/account_book',$data);
	}
	public function cash_transactions()
	{
		$this->permission_check('accounts_view');
		$data=$this->data;
		$data['page_title']=$this->lang->line('cash_transactions');
		$this->load->view('accounts/cash_transactions',$data);
	}

	public function account_heads()
	{
		$this->permission_check('accounts_view');
		$data = $this->data;
		$store_id = get_current_store_id();
		$this->load->helper('accounts');
		create_default_accounts($store_id);

		$data['page_title'] = $this->lang->line('account_heads') ? $this->lang->line('account_heads') : 'Account Heads';

		// Summary statistics
		$data['total_heads'] = $this->db->where('store_id', $store_id)->where('parent_id', 0)->where('delete_bit', 0)->count_all_results('ac_accounts');
		$data['total_sub_accounts'] = $this->db->where('store_id', $store_id)->where('parent_id >', 0)->where('delete_bit', 0)->count_all_results('ac_accounts');
		
		$tot_bal = $this->db->select("coalesce(sum(balance),0) as tot_bal")->where('store_id', $store_id)->where('status', 1)->where('delete_bit', 0)->get('ac_accounts')->row()->tot_bal;
		$data['consolidated_balance'] = $tot_bal;

		$cash_acc_id = get_cash_account_id($store_id);
		$cash_bal = 0;
		if ($cash_acc_id > 0) {
			$cash_row = $this->db->select('balance')->where('id', $cash_acc_id)->get('ac_accounts')->row();
			if ($cash_row) { $cash_bal = $cash_row->balance; }
		}
		$data['cash_balance'] = $cash_bal;

		$this->load->view('accounts/account_heads', $data);
	}

	public function ajax_account_heads_list()
	{
		$this->load->helper('accounts');
		$store_id = get_current_store_id();
		create_default_accounts($store_id);

		$this->db->from('ac_accounts')
			->where('store_id', $store_id)
			->where('parent_id', 0)
			->where('delete_bit', 0);

		$search_val = isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '';
		if (!empty($search_val)) {
			$this->db->group_start()
				->like('account_name', $search_val)
				->or_like('account_code', $search_val)
				->or_like('note', $search_val)
			->group_end();
		}

		$total_filtered = $this->db->count_all_results('', false);

		$this->db->order_by('sort_code', 'ASC')->order_by('id', 'ASC');
		if (isset($_POST['length']) && $_POST['length'] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$records = $this->db->get()->result();

		$data = array();
		$no = isset($_POST['start']) ? $_POST['start'] : 0;

		foreach ($records as $head) {
			$no++;
			$sub_info = get_sub_accounts_info($head->id, $store_id);
			$sub_count = $sub_info['count'];
			$sub_total_bal = $sub_info['total_balance'];
			$consolidated_head_bal = floatval($head->balance) + floatval($sub_total_bal);

			$head_icon = 'fa-folder-open text-yellow';
			$h_upper = strtoupper($head->account_name);
			if (strpos($h_upper, 'BANK') !== false) {
				$head_icon = 'fa-university text-aqua';
			} elseif (strpos($h_upper, 'CASH') !== false) {
				$head_icon = 'fa-money text-green';
			} elseif (strpos($h_upper, 'BKASH') !== false || strpos($h_upper, 'BAKSH') !== false || strpos($h_upper, 'MOBILE') !== false || strpos($h_upper, 'NAGAD') !== false || strpos($h_upper, 'ROCKET') !== false) {
				$head_icon = 'fa-mobile text-red';
			} elseif (strpos($h_upper, 'CARD') !== false || strpos($h_upper, 'POS') !== false) {
				$head_icon = 'fa-credit-card text-purple';
			}

			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value="'.$head->id.'" class="checkbox column_checkbox">';
			$row[] = '<b>' . htmlspecialchars($head->account_code) . '</b>';
			
			$name_html = '<div style="display:flex; align-items:center;">';
			$name_html .= '<i class="fa '.$head_icon.' fa-lg" style="margin-right:8px; width:20px; text-align:center;"></i>';
			$name_html .= '<div><span style="font-weight:700; font-size:14px; color:#1e293b;">' . htmlspecialchars($head->account_name) . '</span>';
			if (!empty($head->note)) {
				$name_html .= '<br><small class="text-muted">' . htmlspecialchars($head->note) . '</small>';
			}
			$name_html .= '</div></div>';
			$row[] = $name_html;

			// Sub-accounts count with clickable badge
			if ($sub_count > 0) {
				$sub_badge = '<button type="button" class="btn btn-xs btn-default" style="border-radius:12px; font-weight:600; padding:3px 10px; background:#f5f3ff; color:#6d28d9; border:1px solid #ddd6fe;" onclick="view_sub_accounts('.$head->id.', \''.htmlspecialchars($head->account_name, ENT_QUOTES).'\')">';
				$sub_badge .= '<i class="fa fa-sitemap"></i> ' . $sub_count . ' Accounts <i class="fa fa-chevron-right" style="font-size:9px;"></i>';
				$sub_badge .= '</button>';
			} else {
				$sub_badge = '<span class="label label-default" style="font-size:11px; padding:3px 8px; border-radius:10px;"><i class="fa fa-info-circle"></i> Standalone (0 Subs)</span>';
			}
			$row[] = $sub_badge;

			// Balances
			$bal_col = '<div style="text-align:right;">';
			$bal_col .= '<span style="font-size:13.5px; font-weight:700; color:#0f172a;">' . store_number_format($consolidated_head_bal) . '</span>';
			if ($sub_count > 0) {
				$bal_col .= '<br><small class="text-muted">Head: ' . store_number_format($head->balance) . ' | Subs: ' . store_number_format($sub_total_bal) . '</small>';
			}
			$bal_col .= '</div>';
			$row[] = $bal_col;

			// Status
			$status_html = ($head->status == 1) 
				? '<span class="label label-success"><i class="fa fa-check"></i> Active</span>' 
				: '<span class="label label-danger"><i class="fa fa-times"></i> Inactive</span>';
			$row[] = $status_html;

			// Actions
			$actions = '<div class="btn-group" title="Manage Head">';
			$actions .= '<a class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" href="#" style="padding:4px 10px;">Action <span class="caret"></span></a>';
			$actions .= '<ul role="menu" class="dropdown-menu dropdown-light pull-right" style="box-shadow: 0 4px 12px rgba(0,0,0,0.15); border-radius:6px;">';

			if ($this->permissions('accounts_add')) {
				$actions .= '<li><a href="'.base_url('accounts/add?parent_id='.$head->id).'"><i class="fa fa-plus text-green"></i> <b>+ Add Sub-Account</b></a></li>';
			}

			if ($sub_count > 0) {
				$actions .= '<li><a href="javascript:void(0)" onclick="view_sub_accounts('.$head->id.', \''.htmlspecialchars($head->account_name, ENT_QUOTES).'\')"><i class="fa fa-sitemap text-purple"></i> View Sub-Accounts ('.$sub_count.')</a></li>';
			}

			if ($this->permissions('accounts_view')) {
				$actions .= '<li><a href="'.base_url('accounts/book/'.$head->id).'"><i class="fa fa-book text-blue"></i> Account Ledger / Book</a></li>';
			}

			if ($this->permissions('accounts_edit')) {
				$actions .= '<li><a href="javascript:void(0)" onclick="edit_parent_head('.$head->id.', \''.htmlspecialchars($head->account_name, ENT_QUOTES).'\', \''.htmlspecialchars($head->account_code, ENT_QUOTES).'\', \''.htmlspecialchars($head->note, ENT_QUOTES).'\', '.$head->status.')"><i class="fa fa-pencil text-yellow"></i> Edit Head</a></li>';
			}

			if ($this->permissions('accounts_delete') && $sub_count == 0) {
				$actions .= '<li class="divider"></li>';
				$actions .= '<li><a href="javascript:void(0)" onclick="delete_accounts('.$head->id.')" class="text-red"><i class="fa fa-trash text-red"></i> Delete Head</a></li>';
			}

			$actions .= '</ul></div>';
			$row[] = $actions;

			$data[] = $row;
		}

		$output = array(
			"draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 1,
			"recordsTotal" => $this->db->where('store_id', $store_id)->where('parent_id', 0)->where('delete_bit', 0)->count_all_results('ac_accounts'),
			"recordsFiltered" => $total_filtered,
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function ajax_get_head_subs($head_id)
	{
		$store_id = get_current_store_id();
		$subs = $this->db->where('store_id', $store_id)
			->where('parent_id', $head_id)
			->where('delete_bit', 0)
			->order_by('sort_code', 'ASC')
			->order_by('account_name', 'ASC')
			->get('ac_accounts')->result();

		$data = array();
		foreach ($subs as $s) {
			$data[] = array(
				'id' => $s->id,
				'account_code' => $s->account_code,
				'account_name' => $s->account_name,
				'balance' => store_number_format($s->balance),
				'raw_balance' => $s->balance,
				'note' => $s->note,
				'status' => $s->status,
				'book_url' => base_url('accounts/book/' . $s->id),
				'edit_url' => base_url('accounts/update/' . $s->id)
			);
		}
		echo json_encode(array('status' => 'success', 'data' => $data));
	}

	public function ajax_update_parent_head()
	{
		$this->permission_check('accounts_edit');
		$id = intval($this->input->post('head_id'));
		$name = trim($this->input->post('account_name'));
		$code = trim($this->input->post('account_code'));
		$note = trim($this->input->post('note'));
		$status = intval($this->input->post('status'));
		$store_id = get_current_store_id();

		if (empty($id) || empty($name)) {
			echo json_encode(array('status' => 'failed', 'message' => 'Head ID and Account Name are required.'));
			return;
		}

		// Check name unique among parent heads in store
		$chk = $this->db->where('store_id', $store_id)
			->where('parent_id', 0)
			->where('upper(account_name)', strtoupper($name))
			->where('id !=', $id)
			->count_all_results('ac_accounts');
		if ($chk > 0) {
			echo json_encode(array('status' => 'failed', 'message' => 'Another Account Head with this name already exists.'));
			return;
		}

		$update_data = array(
			'account_name' => $name,
			'account_code' => $code,
			'note' => $note,
			'status' => $status
		);
		$this->db->where('id', $id)->where('store_id', $store_id)->update('ac_accounts', $update_data);
		echo json_encode(array('status' => 'success', 'message' => 'Account Head updated successfully!'));
	}

	public function cash_in_hand()
	{
		$this->permission_check('accounts_view');
		$data = $this->data;
		$store_id = get_current_store_id();
		$this->load->helper('accounts');
		create_default_accounts($store_id);

		$cash_account_id = get_cash_account_id($store_id);
		$data['page_title'] = 'Cash in Hand';
		$data['cash_account_id'] = $cash_account_id;
		$data['summary'] = get_cash_summary($store_id, '', '', $cash_account_id);

		// All cash accounts if store has multiple
		$data['cash_accounts'] = $this->db->where('store_id', $store_id)
			->group_start()
				->like('upper(account_name)', 'CASH')
				->or_like('upper(account_code)', 'CASH')
				->or_where('id', $cash_account_id)
			->group_end()
			->where('status', 1)
			->get('ac_accounts')->result();

		$this->load->view('accounts/cash_in_hand', $data);
	}

	public function ajax_cash_summary()
	{
		$store_id = get_current_store_id();
		$account_id = $this->input->post('account_id');
		$from_date = system_fromatted_date($this->input->post('from_date'));
		$to_date = system_fromatted_date($this->input->post('to_date'));
		$user = $this->input->post('users');

		$this->load->helper('accounts');
		$summary = get_cash_summary($store_id, $from_date, $to_date, $account_id, $user);
		echo json_encode($summary);
	}

	public function ajax_cash_transactions()
	{
		$store_id = get_current_store_id();
		$this->load->helper('accounts');
		$account_id = $this->input->post('account_id');
		if(empty($account_id)){
			$account_id = get_cash_account_id($store_id);
		}

		$from_date = system_fromatted_date($this->input->post('from_date'));
		$to_date = system_fromatted_date($this->input->post('to_date'));
		$user = $this->input->post('users');

		// Previous balance before from_date
		$prev_balance = 0;
		if(!empty($from_date) && $from_date != '1970-01-01'){
			$credit_amt = $this->db->select("coalesce(sum(credit_amt),0) as credit_amt")
				->where("credit_account_id", $account_id)
				->where("transaction_date <", $from_date)
				->where("store_id", $store_id)
				->get("ac_transactions")->row()->credit_amt;
			$debit_amt = $this->db->select("coalesce(sum(debit_amt),0) as debit_amt")
				->where("debit_account_id", $account_id)
				->where("transaction_date <", $from_date)
				->where("store_id", $store_id)
				->get("ac_transactions")->row()->debit_amt;
			$prev_balance = $credit_amt - $debit_amt;
		}

		// Query transactions
		$this->db->from('ac_transactions as a')
			->where("a.store_id", $store_id)
			->where("(a.credit_account_id = $account_id OR a.debit_account_id = $account_id)");

		if(!empty($from_date) && $from_date != '1970-01-01'){
			$this->db->where("a.transaction_date >=", $from_date);
		}
		if(!empty($to_date) && $to_date != '1970-01-01'){
			$this->db->where("a.transaction_date <=", $to_date);
		}
		if(!empty($user)){
			$this->db->where("upper(a.created_by)", strtoupper($user));
		}

		// Search
		$search_val = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';
		if(!empty($search_val)){
			$this->db->group_start()
				->like('a.transaction_type', $search_val)
				->or_like('a.note', $search_val)
				->or_like('a.payment_code', $search_val)
				->or_like('a.created_by', $search_val)
			->group_end();
		}

		$total_filtered = $this->db->count_all_results('', false);

		// Window function to compute the exact cumulative balance for each transaction
		$this->db->select("a.*, ( $prev_balance + SUM(
			(CASE WHEN a.credit_account_id = $account_id THEN COALESCE(a.credit_amt, 0) ELSE 0 END) -
			(CASE WHEN a.debit_account_id = $account_id THEN COALESCE(a.debit_amt, 0) ELSE 0 END)
		) OVER (ORDER BY a.transaction_date ASC, a.id ASC) ) AS running_balance");

		// Order & Limit: Default is DESC (most recent first)
		if(isset($_POST['order']) && !empty($_POST['order'])){
			$col_idx = intval($_POST['order']['0']['column']);
			$col_dir = (isset($_POST['order']['0']['dir']) && strtolower($_POST['order']['0']['dir']) === 'asc') ? 'ASC' : 'DESC';
			$columns_map = array(
				1 => 'a.transaction_date',
				2 => 'a.transaction_type',
				3 => 'a.payment_code',
				4 => 'a.credit_amt',
				5 => 'a.debit_amt',
				6 => 'running_balance',
				7 => 'a.note'
			);
			if(isset($columns_map[$col_idx])){
				$this->db->order_by($columns_map[$col_idx], $col_dir)->order_by('a.id', $col_dir);
			} else {
				$this->db->order_by('a.transaction_date', 'DESC')->order_by('a.id', 'DESC');
			}
		} else {
			$this->db->order_by('a.transaction_date', 'DESC')->order_by('a.id', 'DESC');
		}

		if(isset($_POST['length']) && $_POST['length'] != -1){
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$records = $this->db->get()->result();

		$data = array();
		$no = isset($_POST['start']) ? $_POST['start'] : 0;

		foreach($records as $rec){
			$no++;
			$is_credit = ($rec->credit_account_id == $account_id);
			$is_debit = ($rec->debit_account_id == $account_id);

			$inflow = ($is_credit) ? floatval($rec->credit_amt) : 0;
			$outflow = ($is_debit) ? floatval($rec->debit_amt) : 0;
			$rec_balance = isset($rec->running_balance) ? floatval($rec->running_balance) : 0;

			// Badge for type
			$badge_class = 'label-info';
			$icon = 'fa-exchange';
			$type_upper = strtoupper($rec->transaction_type);
			if(strpos($type_upper, 'SALES PAYMENT') !== false){
				$badge_class = 'label-success';
				$icon = 'fa-shopping-cart';
			} else if(strpos($type_upper, 'PURCHASE') !== false){
				$badge_class = 'label-danger';
				$icon = 'fa-truck';
			} else if(strpos($type_upper, 'EXPENSE') !== false){
				$badge_class = 'label-warning';
				$icon = 'fa-money';
			} else if(strpos($type_upper, 'OPENING') !== false){
				$badge_class = 'label-primary';
				$icon = 'fa-hourglass-start';
			} else if(strpos($type_upper, 'DEPOSIT') !== false){
				$badge_class = 'label-info';
				$icon = 'fa-arrow-down';
			} else if(strpos($type_upper, 'TRANSFER') !== false){
				$badge_class = 'label-purple';
				$icon = 'fa-exchange';
			}

			$type_badge = '<span class="label '.$badge_class.'"><i class="fa '.$icon.'"></i> '.$rec->transaction_type.'</span>';

			// Reference Link
			$ref_link = '-';
			if(!empty($rec->ref_salespayments_id)){
				$sales_row = $this->db->select("a.sales_code, a.id")
					->from("db_sales a")
					->join("db_salespayments b", "a.id=b.sales_id")
					->where("b.id", $rec->ref_salespayments_id)->get()->row();
				if($sales_row){
					$ref_link = '<a data-toggle="tooltip" title="View Sales Invoice" class="text-bold text-blue" href="'.base_url('sales/invoice/'.$sales_row->id).'"><i class="fa fa-file-text-o"></i> '.$sales_row->sales_code.'</a>';
				}
			} else if(!empty($rec->ref_purchasepayments_id)){
				$pur_row = $this->db->select("a.purchase_code, a.id")
					->from("db_purchase a")
					->join("db_purchasepayments b", "a.id=b.purchase_id")
					->where("b.id", $rec->ref_purchasepayments_id)->get()->row();
				if($pur_row){
					$ref_link = '<a data-toggle="tooltip" title="View Purchase Invoice" class="text-bold text-red" href="'.base_url('purchase/invoice/'.$pur_row->id).'"><i class="fa fa-truck"></i> '.$pur_row->purchase_code.'</a>';
				}
			} else if(!empty($rec->ref_expense_id)){
				$exp_row = $this->db->select("expense_code, id")->where("id", $rec->ref_expense_id)->get("db_expense")->row();
				if($exp_row){
					$ref_link = '<a data-toggle="tooltip" title="View Expense" class="text-bold text-yellow" href="'.base_url('expense/update/'.$exp_row->id).'"><i class="fa fa-credit-card"></i> '.$exp_row->expense_code.'</a>';
				}
			} else if(!empty($rec->ref_salespaymentsreturn_id)){
				$ret_row = $this->db->select("a.return_code, a.id")
					->from("db_salesreturn a")
					->join("db_salespaymentsreturn b", "a.id=b.return_id")
					->where("b.id", $rec->ref_salespaymentsreturn_id)->get()->row();
				if($ret_row){
					$ref_link = '<a data-toggle="tooltip" title="View Sales Return" class="text-bold text-purple" href="'.base_url('sales_return/invoice/'.$ret_row->id).'"><i class="fa fa-undo"></i> '.$ret_row->return_code.'</a>';
				}
			} else if(!empty($rec->ref_moneytransfer_id)){
				$ref_link = '<a data-toggle="tooltip" title="View Transfer" href="'.base_url('money_transfer/update/'.$rec->ref_moneytransfer_id).'"><i class="fa fa-exchange"></i> TR-'.$rec->ref_moneytransfer_id.'</a>';
			} else if(!empty($rec->ref_moneydeposits_id)){
				$ref_link = '<a data-toggle="tooltip" title="View Deposit" href="'.base_url('money_deposit/update/'.$rec->ref_moneydeposits_id).'"><i class="fa fa-arrow-circle-down"></i> DP-'.$rec->ref_moneydeposits_id.'</a>';
			} else if(!empty($rec->payment_code)){
				$ref_link = $rec->payment_code;
			}

			$row = array();
			$row[] = $no;
			$row[] = show_date($rec->transaction_date);
			$row[] = $type_badge;
			$row[] = $ref_link;
			$row[] = ($inflow > 0) ? '<span class="text-green text-bold">+ ' . store_number_format($inflow) . '</span>' : '<span class="text-muted">-</span>';
			$row[] = ($outflow > 0) ? '<span class="text-red text-bold">- ' . store_number_format($outflow) . '</span>' : '<span class="text-muted">-</span>';
			$row[] = '<b>' . store_number_format($rec_balance) . '</b>';
			$row[] = !empty($rec->note) ? htmlspecialchars($rec->note, ENT_QUOTES) : '<span class="text-muted">-</span>';
			$row[] = $rec->created_by;

			$data[] = $row;
		}

		$output = array(
			"draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 1,
			"recordsTotal" => $this->db->where("store_id", $store_id)->where("(credit_account_id = $account_id OR debit_account_id = $account_id)")->count_all_results('ac_transactions'),
			"recordsFiltered" => $total_filtered,
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function update_cash_opening_balance()
	{
		$this->permission_check('accounts_edit');
		$account_id = $this->input->post('account_id');
		$amount = $this->input->post('amount');
		$note = $this->input->post('note');

		if(empty($account_id)){
			echo json_encode(array('status' => 'failed', 'message' => 'Account ID is required.'));
			return;
		}

		$this->accounts->update_opening_balance($account_id, $amount, $note);
		echo json_encode(array('status' => 'success', 'message' => 'Cash in Hand Opening Balance updated successfully!'));
	}

	public function save_parent_head()
	{
		$this->permission_check('accounts_add');
		echo $this->accounts->save_parent_head();
	}

	public function add()
	{
		$this->permission_check('accounts_add');
		$data=$this->data;
		$data['page_title']=$this->lang->line('add_account');
		$this->load->view('accounts/accounts',$data);
	}
	
	
	public function newaccounts(){
		$this->permission_check('accounts_add');
		$this->form_validation->set_rules('account_code', 'Account Code', 'trim|required');
		$this->form_validation->set_rules('account_name', 'Account Name', 'trim|required');
		$this->form_validation->set_rules('opening_balance', 'Opening Balance', 'trim');
		
		if ($this->form_validation->run() == TRUE) {
			$result=$this->accounts->verify_and_save();
			echo $result;
		} else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}
	public function update($id){
		$this->permission_check('accounts_edit');
		$this->belong_to('ac_accounts',$id);
		$data=$this->data;
		$result=$this->accounts->get_details($id,$data);
		$data=array_merge($data,$result);
		$data['page_title']=$this->lang->line('accounts');
		$this->load->view('accounts/accounts', $data);
	}
	public function update_accounts(){
		$this->form_validation->set_rules('account_code', 'Account Code', 'trim|required');
		$this->form_validation->set_rules('account_name', 'Account Name', 'trim|required');
		$this->form_validation->set_rules('opening_balance', 'Opening Balance', 'trim');

		if ($this->form_validation->run() == TRUE) {
			$result=$this->accounts->update_accounts();
			echo $result;
		} else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}

	public function ajax_list()
	{
		$this->load->helper('accounts');
		$list = $this->accounts->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $accounts) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$accounts->id.' class="checkbox column_checkbox" >';
			$row[] = '<b>'.$accounts->account_code.'</b>';
			
			if($accounts->parent_id == 0){
				$sub_info = get_sub_accounts_info($accounts->id, $accounts->store_id);
				$sub_badge = ($sub_info['count'] > 0) ? ' <span class="badge bg-purple" title="Sub-Accounts"><i class="fa fa-sitemap"></i> '.$sub_info['count'].' Subs</span>' : '';
				$row[] = '<span style="font-weight:bold; font-size:13px;"><i class="fa fa-folder-open text-yellow"></i> '.$accounts->account_name.'</span>'.$sub_badge;
				$row[] = '<span class="label label-primary" style="font-size:11px;"><i class="fa fa-star"></i> Parent Account Head</span>';
				
				$bal_text = '<b>'.store_number_format($accounts->balance).'</b>';
				if($sub_info['count'] > 0){
					$bal_text .= '<br><small class="text-muted"><i class="fa fa-sitemap"></i> Subs Total: <b>'.store_number_format($sub_info['total_balance']).'</b></small>';
				}
				$row[] = $bal_text;
			} else {
				$row[] = '<span style="padding-left:15px;"><i class="fa fa-level-up fa-rotate-90 text-muted"></i> <b>'.$accounts->account_name.'</b></span>';
				$row[] = '<span class="label label-default" style="font-size:11px;"><i class="fa fa-folder text-yellow"></i> '.get_account_name($accounts->parent_id).'</span>';
				$row[] = store_number_format($accounts->balance);
			}
			
			$row[] = ($accounts->created_by);			
			$str2 = '<div class="btn-group" title="View Account">
						<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
							Action <span class="caret"></span>
						</a>
						<ul role="menu" class="dropdown-menu dropdown-light pull-right">';

			if($accounts->parent_id == 0 && $this->permissions('accounts_add')){
				$str2 .= '<li>
					<a data-toggle="tooltip" title="Add Sub-Account under this Head" href="'.base_url().'accounts/add?parent_id='.$accounts->id.'">
						<i class="fa fa-fw fa-plus text-green"></i><b>Add Sub-Account</b>
					</a>
				</li>
				<li class="divider"></li>';
			}

			if($this->permissions('accounts_edit'))
			$str2.='<li>
				<a data-toggle="tooltip" title="Edit Record ?" href="'.base_url().'accounts/update/'.$accounts->id.'">
					<i class="fa fa-fw fa-edit text-blue"></i>Edit
				</a>
			</li>';

			if($this->permissions('accounts_view'))
			$str2.='<li>
				<a data-toggle="tooltip" title="Click to check Account!" href="'.base_url().'accounts/book/'.$accounts->id.'">
					<i class="fa fa-fw fa-book text-blue"></i>Account Book
				</a>
			</li>';

			if($this->permissions('accounts_delete'))
			$str2.='<li>
				<a style="cursor:pointer" data-toggle="tooltip" title="Delete Record ?" onclick="delete_accounts('.$accounts->id.')">
					<i class="fa fa-fw fa-trash text-red"></i>Delete
				</a>
			</li>';
			
			$str2.='</ul>
			</div>';			
			$row[] = $str2;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->accounts->count_all(),
			"recordsFiltered" => $this->accounts->count_filtered(),
			"data" => $data,
		);
		echo json_encode($output);
	}
	
	public function delete_accounts(){
		$this->permission_check_with_msg('accounts_delete');
		$id=$this->input->post('q_id');
		echo $this->accounts->delete_accounts_from_table($id);
	}
	public function multi_delete_accounts(){
		$this->permission_check_with_msg('accounts_delete');
		$ids=implode (",",$_POST['checkbox']);
		echo $this->accounts->delete_accounts_from_table($ids);
	}
	


}
