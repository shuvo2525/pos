<?php
function create_default_accounts($store_id = '') {
	$CI =& get_instance();
	if (empty($store_id)) {
		$store_id = get_current_store_id();
	}
	if (empty($store_id)) {
		return false;
	}

	// Check if this store already has accounts configured
	$count = $CI->db->where("store_id", $store_id)->count_all_results("ac_accounts");
	if ($count > 0) {
		return true;
	}

	$default_heads = array(
		array(
			'account_name' => 'Cash in Hand',
			'account_code' => 'CASH-' . $store_id,
			'note'         => 'Default Cash Account Head',
			'sort_code'    => '1'
		),
		array(
			'account_name' => 'Bank Accounts',
			'account_code' => 'BANK-' . $store_id,
			'note'         => 'Default Bank Accounts Head',
			'sort_code'    => '2'
		),
		array(
			'account_name' => 'Mobile Banking',
			'account_code' => 'MBANK-' . $store_id,
			'note'         => 'Default Mobile Banking Head (bKash/Nagad/Rocket)',
			'sort_code'    => '3'
		),
		array(
			'account_name' => 'Card / POS Terminal',
			'account_code' => 'CARD-' . $store_id,
			'note'         => 'Default Card / POS Terminal Head',
			'sort_code'    => '4'
		)
	);

	$cur_date = date("Y-m-d");
	$cur_time = date("h:i:s a");
	$first_id = 0;

	foreach ($default_heads as $head) {
		$count_id = get_count_id('ac_accounts', $store_id);
		$data = array(
			'count_id'     => $count_id,
			'store_id'     => $store_id,
			'sort_code'    => $head['sort_code'],
			'account_code' => $head['account_code'],
			'parent_id'    => 0,
			'account_name' => $head['account_name'],
			'note'         => $head['note'],
			'balance'      => 0,
			'created_date' => $cur_date,
			'created_time' => $cur_time,
			'created_by'   => 'system',
			'system_ip'    => (!empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1',
			'system_name'  => 'system',
			'status'       => 1
		);
		$CI->db->insert('ac_accounts', $data);
		$acc_id = $CI->db->insert_id();
		if (!$first_id) {
			$first_id = $acc_id;
		}

		$CI->db->insert('ac_transactions', array(
			'store_id'          => $store_id,
			'transaction_type'  => 'OPENING BALANCE',
			'ref_accounts_id'   => $acc_id,
			'credit_account_id' => $acc_id,
			'debit_account_id'  => null,
			'debit_amt'         => 0,
			'credit_amt'        => 0,
			'transaction_date'  => $cur_date,
			'created_date'      => $cur_date,
			'created_by'        => 'system',
			'note'              => 'Initial Zero Opening Balance'
		));
	}

	if ($first_id > 0) {
		$CI->db->set('default_account_id', $first_id)
			->where('id', $store_id)
			->where("(default_account_id IS NULL OR default_account_id = '' OR default_account_id = 0)")
			->update('db_store');
	}

	return true;
}

function get_accounts_select_list($select_id = '', $parent_id = 0) {
	$CI =& get_instance();
	$store_id = get_current_store_id();

	// Ensure default accounts exist for this store
	create_default_accounts($store_id);

	$CI->db->where("store_id", $store_id);
	$CI->db->select("*")->where("status=1")->from("ac_accounts");
	$CI->db->order_by("parent_id", "ASC")->order_by("sort_code", "ASC")->order_by("account_name", "ASC");
	$q1 = $CI->db->get();

	if ($q1->num_rows() == 0) {
		return '';
	}

	$all_accounts = $q1->result();

	// Group into parents and children
	$parents = array();
	$children = array();
	foreach ($all_accounts as $acc) {
		if ($acc->parent_id == 0) {
			$parents[$acc->id] = $acc;
		} else {
			$children[$acc->parent_id][] = $acc;
		}
	}

	$str = '';

	// Process each Parent Head
	foreach ($parents as $head_id => $head) {
		$has_children = isset($children[$head_id]) && count($children[$head_id]) > 0;
		$head_bal = store_number_format($head->balance);
		$icon = '📁 ';
		$head_name_upper = strtoupper($head->account_name);
		if (strpos($head_name_upper, 'BANK') !== false) {
			$icon = '🏦 ';
		} elseif (strpos($head_name_upper, 'CASH') !== false) {
			$icon = '💵 ';
		} elseif (strpos($head_name_upper, 'BKASH') !== false || strpos($head_name_upper, 'BAKSH') !== false || strpos($head_name_upper, 'MOBILE') !== false || strpos($head_name_upper, 'NAGAD') !== false || strpos($head_name_upper, 'NAGOD') !== false || strpos($head_name_upper, 'ROCKET') !== false) {
			$icon = '📱 ';
		} elseif (strpos($head_name_upper, 'CARD') !== false || strpos($head_name_upper, 'POS') !== false) {
			$icon = '💳 ';
		}

		$optgroup_label = $icon . $head->account_name . ($has_children ? ' (' . count($children[$head_id]) . ' Accounts)' : '');

		$str .= '<optgroup label="' . htmlspecialchars($optgroup_label, ENT_QUOTES) . '">';

		if ($has_children) {
			// Sub-accounts under this Head
			foreach ($children[$head_id] as $child) {
				$selected = ($select_id == $child->id) ? 'selected' : '';
				$child_bal = store_number_format($child->balance);
				$display = $child->account_name . (!empty($child->account_code) ? ' (' . $child->account_code . ')' : '') . ' [Bal: ' . $child_bal . ']';

				$str .= "<option $selected data-parent-id='{$head_id}' data-parent-name='" . htmlspecialchars($head->account_name, ENT_QUOTES) . "' data-account-name='" . htmlspecialchars($child->account_name, ENT_QUOTES) . "' data-code='" . htmlspecialchars($child->account_code, ENT_QUOTES) . "' data-balance='{$child_bal}' data-raw-balance='{$child->balance}' value='{$child->id}'>";
				$str .= htmlspecialchars($display, ENT_QUOTES);
				$str .= "</option>";
			}
			// Also include parent head itself as a selectable general account
			$head_selected = ($select_id == $head->id) ? 'selected' : '';
			$str .= "<option $head_selected style='font-style:italic;' data-parent-id='0' data-parent-name='' data-account-name='" . htmlspecialchars($head->account_name, ENT_QUOTES) . "' data-code='" . htmlspecialchars($head->account_code, ENT_QUOTES) . "' data-balance='{$head_bal}' data-raw-balance='{$head->balance}' value='{$head->id}'>";
			$str .= "— " . htmlspecialchars($head->account_name . ' (General / Head) [Bal: ' . $head_bal . ']', ENT_QUOTES) . " —";
			$str .= "</option>";
		} else {
			// Standalone head (e.g. Cash in Hand or a newly added head with no subs yet)
			$selected = ($select_id == $head->id) ? 'selected' : '';
			$display = $head->account_name . (!empty($head->account_code) ? ' (' . $head->account_code . ')' : '') . ' [Bal: ' . $head_bal . ']';
			$str .= "<option $selected data-parent-id='0' data-parent-name='' data-account-name='" . htmlspecialchars($head->account_name, ENT_QUOTES) . "' data-code='" . htmlspecialchars($head->account_code, ENT_QUOTES) . "' data-balance='{$head_bal}' data-raw-balance='{$head->balance}' value='{$head->id}'>";
			$str .= htmlspecialchars($display, ENT_QUOTES);
			$str .= "</option>";
		}

		$str .= '</optgroup>';
	}

	// Any orphaned children whose parent_id is not found
	foreach ($children as $pid => $c_list) {
		if (!isset($parents[$pid])) {
			$str .= '<optgroup label="Other Accounts">';
			foreach ($c_list as $child) {
				$selected = ($select_id == $child->id) ? 'selected' : '';
				$child_bal = store_number_format($child->balance);
				$display = $child->account_name . ' [Bal: ' . $child_bal . ']';
				$str .= "<option $selected value='{$child->id}' data-balance='{$child_bal}'>" . htmlspecialchars($display, ENT_QUOTES) . "</option>";
			}
			$str .= '</optgroup>';
		}
	}

	return $str;
}

function get_parent_accounts_select_list($select_id = '') {
	$CI =& get_instance();
	$store_id = get_current_store_id();
	create_default_accounts($store_id);

	$q1 = $CI->db->where('store_id', $store_id)
		->where('parent_id', 0)
		->where('status', 1)
		->where('delete_bit', 0)
		->order_by('sort_code', 'ASC')
		->order_by('account_name', 'ASC')
		->get('ac_accounts');

	$str = '';
	if ($q1->num_rows() > 0) {
		foreach ($q1->result() as $res1) {
			$selected = ($select_id == $res1->id) ? 'selected' : '';
			$icon = '📁 ';
			$h_upper = strtoupper($res1->account_name);
			if (strpos($h_upper, 'BANK') !== false) {
				$icon = '🏦 ';
			} elseif (strpos($h_upper, 'CASH') !== false) {
				$icon = '💵 ';
			} elseif (strpos($h_upper, 'BKASH') !== false || strpos($h_upper, 'BAKSH') !== false || strpos($h_upper, 'MOBILE') !== false || strpos($h_upper, 'NAGAD') !== false || strpos($h_upper, 'ROCKET') !== false) {
				$icon = '📱 ';
			} elseif (strpos($h_upper, 'CARD') !== false || strpos($h_upper, 'POS') !== false) {
				$icon = '💳 ';
			}
			$str .= "<option $selected value='{$res1->id}' data-code='{$res1->account_code}' data-name='" . htmlspecialchars($res1->account_name, ENT_QUOTES) . "'>{$icon}{$res1->account_name} ({$res1->account_code})</option>";
		}
	}
	return $str;
}

function get_cash_account_id($store_id = '') {
	$CI =& get_instance();
	if (empty($store_id)) {
		$store_id = get_current_store_id();
	}
	// 1. Check default_account_id in db_store
	$store = $CI->db->select('default_account_id')->where('id', $store_id)->get('db_store')->row();
	if ($store && !empty($store->default_account_id)) {
		$acc = $CI->db->where('id', $store->default_account_id)->where('store_id', $store_id)->get('ac_accounts')->row();
		if ($acc) {
			return $acc->id;
		}
	}
	// 2. Check for account with name or code containing 'cash'
	$acc = $CI->db->where('store_id', $store_id)
		->group_start()
			->like('upper(account_name)', 'CASH')
			->or_like('upper(account_code)', 'CASH')
		->group_end()
		->order_by('id', 'ASC')
		->get('ac_accounts')->row();
	if ($acc) {
		return $acc->id;
	}
	// 3. Fallback to first account in store
	$acc = $CI->db->where('store_id', $store_id)->order_by('id', 'ASC')->get('ac_accounts')->row();
	if ($acc) {
		return $acc->id;
	}
	return 0;
}

function get_cash_summary($store_id = '', $from_date = '', $to_date = '', $account_id = '', $user = '') {
	$CI =& get_instance();
	if (empty($store_id)) {
		$store_id = get_current_store_id();
	}
	if (empty($account_id)) {
		$account_id = get_cash_account_id($store_id);
	}

	$account = $CI->db->where('id', $account_id)->get('ac_accounts')->row();
	$current_balance = $account ? floatval($account->balance) : 0;
	$account_name = $account ? $account->account_name : 'Cash in Hand';
	$account_code = $account ? $account->account_code : '';

	// Opening balance from ac_transactions
	$ob_row = $CI->db->select('credit_amt')
		->where('ref_accounts_id', $account_id)
		->where('transaction_type', 'OPENING BALANCE')
		->get('ac_transactions')->row();
	$opening_balance = $ob_row ? floatval($ob_row->credit_amt) : 0;

	// Inflows (credits to this account)
	$CI->db->select('coalesce(sum(credit_amt), 0) as total_inflow')
		->where('credit_account_id', $account_id)
		->where('store_id', $store_id)
		->where("transaction_type != 'OPENING BALANCE'");
	if (!empty($from_date) && $from_date != '1970-01-01') {
		$CI->db->where('transaction_date >=', $from_date);
	}
	if (!empty($to_date) && $to_date != '1970-01-01') {
		$CI->db->where('transaction_date <=', $to_date);
	}
	if (!empty($user)) {
		$CI->db->where('upper(created_by)', strtoupper($user));
	}
	$total_inflow = floatval($CI->db->get('ac_transactions')->row()->total_inflow);

	// Outflows (debits from this account)
	$CI->db->select('coalesce(sum(debit_amt), 0) as total_outflow')
		->where('debit_account_id', $account_id)
		->where('store_id', $store_id);
	if (!empty($from_date) && $from_date != '1970-01-01') {
		$CI->db->where('transaction_date >=', $from_date);
	}
	if (!empty($to_date) && $to_date != '1970-01-01') {
		$CI->db->where('transaction_date <=', $to_date);
	}
	if (!empty($user)) {
		$CI->db->where('upper(created_by)', strtoupper($user));
	}
	$total_outflow = floatval($CI->db->get('ac_transactions')->row()->total_outflow);

	return array(
		'account_id'      => $account_id,
		'account_name'    => $account_name,
		'account_code'    => $account_code,
		'current_balance' => $current_balance,
		'opening_balance' => $opening_balance,
		'total_inflow'    => $total_inflow,
		'total_outflow'   => $total_outflow,
		'net_change'      => ($total_inflow - $total_outflow)
	);
}

function get_sub_accounts_info($parent_id, $store_id = '') {
	$CI =& get_instance();
	if (empty($store_id)) {
		$store_id = get_current_store_id();
	}
	$row = $CI->db->select("count(*) as total_subs, coalesce(sum(balance),0) as subs_balance")
		->where("parent_id", $parent_id)
		->where("store_id", $store_id)
		->get("ac_accounts")->row();
	return array(
		'count' => ($row) ? intval($row->total_subs) : 0,
		'total_balance' => ($row) ? floatval($row->subs_balance) : 0
	);
}

 function add_dash($value,$parent_id,$sort_code){
 	if($parent_id==0){
 		return $value;
 	}
 	else{
 		$dash='';
 		$count = count(explode(".", $sort_code));
 		for ($i=0; $i < $count-2; $i++) { 
 			$dash .= "&nbsp;&nbsp;&nbsp;";
 		}
 		return $dash."--".$value;
 	}
 	
 }


function insert_account_transaction($data=array()){
	
		$transaction_type 			= (empty($data['transaction_type'])) ? '' : $data['transaction_type'];
		$reference_table_id			= $data['reference_table_id'];
		$debit_account_id 			= (empty($data['debit_account_id'])) ? NULL : $data['debit_account_id'];
		$credit_account_id 			= (empty($data['credit_account_id'])) ? NULL : $data['credit_account_id'];
		$debit_amt 					= (empty($data['debit_amt'])) ? 0 : $data['debit_amt'];
		$credit_amt 				= (empty($data['credit_amt'])) ? 0 : $data['credit_amt'];
		$process 					= (empty($data['process'])) ? 'SAVE' : $data['process'];
		$note 						= (empty($data['note'])) ? '' : $data['note'];
		$transaction_date			= $data['transaction_date'];
		$payment_code 				= (empty($data['payment_code'])) ? '' : $data['payment_code'];
		$customer_id 				= (empty($data['customer_id'])) ? NULL : $data['customer_id'];
		$supplier_id 				= (empty($data['supplier_id'])) ? NULL : $data['supplier_id'];
	

	$CI =& get_instance();

	$transaction = array();
	if($transaction_type=='EXPENSE PAYMENT'){
		if($process=='UPDATE'){
			//delete previouse data of the transactions
			$CI->db->where("ref_expense_id",$reference_table_id)->delete("ac_transactions");
		}
		$transaction = array( 
								"transaction_type" 		=> $transaction_type,
								"ref_expense_id" 	=> $reference_table_id,
								"debit_account_id" 		=> $debit_account_id,
								"debit_amt"		 		=> $debit_amt,
							);
	}
	else if($transaction_type=='PURCHASE PAYMENT RETURN'){
		$transaction = array( 
								"transaction_type" 		=> $transaction_type,
								"ref_purchasepaymentsreturn_id" 	=> $reference_table_id,
								"credit_account_id" 	=> $credit_account_id,
								"credit_amt"		 	=> $credit_amt,
							);
	}
	else if($transaction_type=='PURCHASE PAYMENT'){
		$transaction = array( 
								"transaction_type" 		=> $transaction_type,
								"ref_purchasepayments_id" 	=> $reference_table_id,
								"debit_account_id" 		=> $debit_account_id,
								"debit_amt"		 		=> $debit_amt,
							);
	}
	else if($transaction_type=='SALES PAYMENT RETURN'){
		$transaction = array( 
								"transaction_type" 		=> $transaction_type,
								"ref_salespaymentsreturn_id" 	=> $reference_table_id,
								"debit_account_id" 		=> $debit_account_id,
								"debit_amt"		 		=> $debit_amt,
							);
	}
	else if($transaction_type=='SALES PAYMENT' || $transaction_type=='SALES PAYMENT & OB'){
		//CUSTOMER BULK PAYMENT INCLUDES OB PAYMENT
		$transaction = array( 
								"transaction_type" 		=> $transaction_type,
								"ref_salespayments_id" 	=> $reference_table_id,
								"credit_account_id" 	=> $credit_account_id,
								"credit_amt"		 	=> $credit_amt,
							);
	}
	else if($transaction_type=='EMI PAYMENT' || $transaction_type=='WARRANTY SERVICE'){
		$transaction = array( 
								"transaction_type" 		=> $transaction_type,
								"short_code" 			=> $reference_table_id,
								"credit_account_id" 	=> $credit_account_id,
								"credit_amt"		 	=> $credit_amt,
							);
	}
	else if($transaction_type=='OPENING BALANCE PAID' && !empty($supplier_id)){
		$transaction = array( 
								"transaction_type" 		=> $transaction_type,
								"ref_purchasepayments_id" 		=> $reference_table_id,
								"debit_account_id" 		=> $debit_account_id,
								"debit_amt"		 		=> $debit_amt,
							);
	}
	
	else if($transaction_type=='OPENING BALANCE PAID' && !empty($customer_id)){
		//SALES PAYMENTS
		$transaction = array( 
								"transaction_type" 		=> $transaction_type,
								"ref_salespayments_id" 		=> $reference_table_id,
								"credit_account_id" 	=> $credit_account_id,
								"credit_amt"		 	=> $credit_amt,
							);
	}
	
	else if($transaction_type=='OPENING BALANCE' && empty($customer_id) && empty($supplier_id)){
		//WHILE CREATING ACCOUNT
		$transaction = array( 
								"transaction_type" 		=> $transaction_type,
								"ref_accounts_id" 		=> $reference_table_id,
								"credit_account_id" 	=> $credit_account_id,
								"credit_amt"		 	=> $credit_amt,
							);
	}
	
	else if($transaction_type=='DEPOSIT'){
		if($process=='UPDATE'){
			//delete previouse data of the transactions
			$CI->db->where("ref_moneydeposits_id",$reference_table_id)->delete("ac_transactions");
		}
		$transaction = array( 
								"transaction_type" 		=> $transaction_type,
								"ref_moneydeposits_id" 	=> $reference_table_id,
								"debit_account_id" 		=> $debit_account_id,
								"credit_account_id" 	=> $credit_account_id,
								"debit_amt"		 		=> $debit_amt,
								"credit_amt"		 	=> $credit_amt,
							);
	}
	else if($transaction_type=='TRANSFER'){
		if($process=='UPDATE'){
			//delete previouse data of the transactions
			$CI->db->where("ref_moneytransfer_id",$reference_table_id)->delete("ac_transactions");
		}
		$transaction = array( 
								"transaction_type" 		=> $transaction_type,
								"ref_moneytransfer_id" 	=> $reference_table_id,
								"debit_account_id" 		=> $debit_account_id,
								"credit_account_id" 	=> $credit_account_id,
								"debit_amt"		 		=> $debit_amt,
								"credit_amt"		 	=> $credit_amt,
							);
	}
	else{
		//"Invalid Transaction Type";
		return false;
	}

	$transaction['store_id'] = (!empty($data['store_id'])) ? $data['store_id'] : get_current_store_id();
	$transaction['created_by'] = $CI->session->userdata('inv_username');
	$transaction['created_date'] = date("Y-m-d");
	$transaction['transaction_date'] = $transaction_date;
	$transaction['note'] = $note;
	$transaction['payment_code'] = $payment_code;
	$transaction['customer_id'] = $customer_id;
	$transaction['supplier_id'] = $supplier_id;

	if($CI->db->insert("ac_transactions",$transaction)){

		if(!empty($debit_account_id)){
			if(!update_account_balance($debit_account_id)){
				return false;
			}
		}

		if(!empty($credit_account_id)){
			if(!update_account_balance($credit_account_id)){
				return false;
			}
		}


		return true;
	}
	return false;
}



function get_account_balance($account_id){
	$CI =& get_instance();
	$debit = $CI->db->select("coalesce(sum(debit_amt),0) as debit")->where('debit_account_id',$account_id)->get("ac_transactions")->row()->debit;
	$credit = $CI->db->select("coalesce(sum(credit_amt),0) as credit")->where('credit_account_id',$account_id)->get("ac_transactions")->row()->credit;
	$balance = $credit-$debit;
	return $balance;
}
function update_account_balance($account_id){
	$CI =& get_instance();
	$balance = get_account_balance($account_id);
	$q1=$CI->db->set('balance',$balance)->where("id",$account_id)->update("ac_accounts");
	if(!$q1){
		return false;
	}
	return true;
}
