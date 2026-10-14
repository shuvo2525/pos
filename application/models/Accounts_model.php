<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts_model extends CI_Model {

	//Datatable start
	var $table = 'ac_accounts as a';
	var $column_order = array('a.id','a.account_name','a.parent_id','a.note','a.account_code','a.balance','a.created_by','a.store_id','a.delete_bit'); //set column field database for datatable orderable
	var $column_search = array('a.id','a.account_name','a.parent_id','a.note','a.account_code','a.balance','a.created_by','a.store_id'); //set column field database for datatable searchable 
	var $order = array('a.id' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
	}

	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);
		//if(!is_admin()){
			$this->db->where("a.store_id",get_current_store_id());
		//}
		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->where("store_id",get_current_store_id());
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	//Save Cutomers
	public function verify_and_save(){
		//Filtering XSS and html escape from user inputs 
		$this->db->trans_begin();
		extract($this->security->xss_clean(html_escape(array_merge($this->data,$_POST))));
		$store_id=(store_module() && is_admin()) ? $store_id : get_current_store_id();	

		$this->load->helper('accounts');
		create_default_accounts($store_id);

		$parent_id = isset($parent_id) ? trim($parent_id) : '';

		if(empty($parent_id) || $parent_id === '0'){
			$parent_id = 0;
			$maxid = $this->db->select("coalesce(max(id),0)+1 as maxid")->where("store_id", $store_id)->get("ac_accounts")->row()->maxid;
			$sort_code = $maxid;
		}
		else if(is_numeric($parent_id) && intval($parent_id) > 0){
			$parent_row = $this->db->select("id, sort_code")->where("id", $parent_id)->where("store_id", $store_id)->get("ac_accounts")->row();
			if($parent_row){
				$parent_id = $parent_row->id;
				$parent_sort_code = $parent_row->sort_code;
				$maxid = $this->db->select("count(*)+1 as maxid")->where("parent_id", $parent_id)->where("store_id", $store_id)->get("ac_accounts")->row()->maxid;
				$sort_code = $parent_sort_code . "." . $maxid;
			} else {
				$parent_id = 0;
				$maxid = $this->db->select("coalesce(max(id),0)+1 as maxid")->where("store_id", $store_id)->get("ac_accounts")->row()->maxid;
				$sort_code = $maxid;
			}
		}
		else{
			// User TYPED a custom parent head name!
			$parent_name_trimmed = trim($parent_id);
			$existing_parent = $this->db->select("id, sort_code")
				->where("store_id", $store_id)
				->where("parent_id", 0)
				->where("upper(account_name)", strtoupper($parent_name_trimmed))
				->get("ac_accounts")->row();

			if($existing_parent){
				$parent_id = $existing_parent->id;
				$maxid = $this->db->select("count(*)+1 as maxid")->where("parent_id", $parent_id)->where("store_id", $store_id)->get("ac_accounts")->row()->maxid;
				$sort_code = $existing_parent->sort_code . "." . $maxid;
			} else {
				// Automatically create this Parent Account Head
				$max_root = $this->db->select("coalesce(max(id),0)+1 as maxid")->where("store_id", $store_id)->get("ac_accounts")->row()->maxid;
				$parent_sort_code = $max_root;
				$new_parent_code = get_init_code("accounts", $store_id);

				$parent_data = array(
					'count_id'     => get_count_id('ac_accounts', $store_id),
					'store_id'     => $store_id,
					'sort_code'    => $parent_sort_code,
					'account_code' => $new_parent_code,
					'parent_id'    => 0,
					'account_name' => $parent_name_trimmed,
					'note'         => 'Custom Parent Account Head',
					'balance'      => 0,
					'created_date' => $CUR_DATE,
					'created_time' => $CUR_TIME,
					'created_by'   => $CUR_USERNAME,
					'system_ip'    => $SYSTEM_IP,
					'system_name'  => $SYSTEM_NAME,
					'status'       => 1
				);
				$this->db->insert('ac_accounts', $parent_data);
				$parent_id = $this->db->insert_id();

				$this->db->insert('ac_transactions', array(
					'store_id'          => $store_id,
					'transaction_type'  => 'OPENING BALANCE',
					'ref_accounts_id'   => $parent_id,
					'credit_account_id' => $parent_id,
					'debit_account_id'  => null,
					'debit_amt'         => 0,
					'credit_amt'        => 0,
					'transaction_date'  => $CUR_DATE,
					'created_date'      => $CUR_DATE,
					'created_by'        => $CUR_USERNAME,
					'note'              => 'Initial Zero Opening Balance'
				));

				$sort_code = $parent_sort_code . ".1";
			}
		}

		$query = $this->db->query("select * from ac_accounts where upper(account_code)=upper(" . $this->db->escape($account_code) . ") and store_id=$store_id");
		if($query->num_rows() > 0){
			return "Sorry! This Account Code already exists.";
		}
		$this->db->where("upper(account_name)", strtoupper($account_name));
		$this->db->where("store_id", $store_id);
		$this->db->where("parent_id", $parent_id);
		$query = $this->db->count_all_results("ac_accounts");
		if($query > 0){
			return "Sorry! This Account Name already exists under this parent account.";
		}

		$opening_balance = (isset($opening_balance) && !empty($opening_balance)) ? string_to_number($opening_balance) : 0;

		$info = array(  
						'count_id' 					=> get_count_id('ac_accounts', $store_id), 
	    				'store_id' 					=> $store_id,
	    				'sort_code' 				=> $sort_code,
	    				'account_code' 				=> $account_code,
	    				'parent_id' 				=> $parent_id,
	    				'account_name' 				=> $account_name,
	    				'note' 						=> $note,
	    				/*System Info*/
	    				'created_date' 				=> $CUR_DATE,
	    				'created_time' 				=> $CUR_TIME,
	    				'created_by' 				=> $CUR_USERNAME,
	    				'system_ip' 				=> $SYSTEM_IP,
	    				'system_name' 				=> $SYSTEM_NAME,
	    				'status' 					=> 1,
	    			);
		$q1 = $this->db->insert('ac_accounts', $info);
		if(!$q1){
			return "failed";
		}
		$new_account_id = $this->db->insert_id();

		//ACCOUNT INSERT
		$insert_bit = insert_account_transaction(array(
													'store_id'              => $store_id,
													'transaction_type'  	=> 'OPENING BALANCE',
													'reference_table_id'  	=> $new_account_id,
													'debit_account_id'  	=> null,
													'credit_account_id'  	=> $new_account_id,
													'debit_amt'  			=> 0,
													'credit_amt'  			=> $opening_balance,
													'process'  				=> 'SAVE',
													'note'  				=> '',
													'transaction_date'  	=> $CUR_DATE,
													'payment_code'  		=> '',
													'customer_id'  			=> '',
													'supplier_id'  			=> '',
											));
		if(!$insert_bit){
			return "failed";
		}
		//END

		$this->session->set_flashdata('success', 'Success!! Record Added Successfully!');
		$this->db->trans_commit();
		return "success";
	}

	//Get expenses_details
	public function get_details($id,$data){
		//Validate This expenses already exist or not
		$query=$this->db->query("select * from ac_accounts where upper(id)=upper('$id')");
		if($query->num_rows()==0){
			show_404();exit;
		}
		else{
			$query=$query->row();
			$data['q_id']=$query->id;
			$data['account_code']=$query->account_code;			
			$data['parent_id']=$query->parent_id;
			$data['account_name']=$query->account_name;
			$data['note']=$query->note;
			$ob_row = $this->db->select('credit_amt')->where('ref_accounts_id', $id)->where('transaction_type', 'OPENING BALANCE')->get('ac_transactions')->row();
			$data['opening_balance'] = ($ob_row) ? $ob_row->credit_amt : $query->balance;
			$data['store_id']=$query->store_id;
			return $data;
		}
	}
	public function update_accounts(){
		//Filtering XSS and html escape from user inputs 
		extract($this->security->xss_clean(html_escape(array_merge($this->data,$_POST))));
		$store_id=(store_module() && is_admin()) ? $store_id : get_current_store_id();	

		$parent_id = isset($parent_id) ? trim($parent_id) : '';

		if(empty($parent_id) || $parent_id === '0'){
			$parent_id = 0;
			$maxid = $this->db->select("coalesce(max(id),0)+1 as maxid")->where("store_id", $store_id)->get("ac_accounts")->row()->maxid;
			$sort_code = $maxid;
		}
		else if(is_numeric($parent_id) && intval($parent_id) > 0){
			$parent_row = $this->db->select("id, sort_code")->where("id", $parent_id)->where("store_id", $store_id)->get("ac_accounts")->row();
			if($parent_row){
				$parent_id = $parent_row->id;
				$parent_sort_code = $parent_row->sort_code;
				$maxid = $this->db->select("count(*)+1 as maxid")->where("parent_id", $parent_id)->where("store_id", $store_id)->get("ac_accounts")->row()->maxid;
				$sort_code = $parent_sort_code . "." . $maxid;
			} else {
				$parent_id = 0;
				$maxid = $this->db->select("coalesce(max(id),0)+1 as maxid")->where("store_id", $store_id)->get("ac_accounts")->row()->maxid;
				$sort_code = $maxid;
			}
		}
		else{
			// User TYPED a custom parent head name!
			$parent_name_trimmed = trim($parent_id);
			$existing_parent = $this->db->select("id, sort_code")
				->where("store_id", $store_id)
				->where("parent_id", 0)
				->where("upper(account_name)", strtoupper($parent_name_trimmed))
				->get("ac_accounts")->row();

			if($existing_parent){
				$parent_id = $existing_parent->id;
				$maxid = $this->db->select("count(*)+1 as maxid")->where("parent_id", $parent_id)->where("store_id", $store_id)->get("ac_accounts")->row()->maxid;
				$sort_code = $existing_parent->sort_code . "." . $maxid;
			} else {
				$max_root = $this->db->select("coalesce(max(id),0)+1 as maxid")->where("store_id", $store_id)->get("ac_accounts")->row()->maxid;
				$parent_sort_code = $max_root;
				$new_parent_code = get_init_code("accounts", $store_id);

				$parent_data = array(
					'count_id'     => get_count_id('ac_accounts', $store_id),
					'store_id'     => $store_id,
					'sort_code'    => $parent_sort_code,
					'account_code' => $new_parent_code,
					'parent_id'    => 0,
					'account_name' => $parent_name_trimmed,
					'note'         => 'Custom Parent Account Head',
					'balance'      => 0,
					'created_date' => $CUR_DATE,
					'created_time' => $CUR_TIME,
					'created_by'   => $CUR_USERNAME,
					'system_ip'    => $SYSTEM_IP,
					'system_name'  => $SYSTEM_NAME,
					'status'       => 1
				);
				$this->db->insert('ac_accounts', $parent_data);
				$parent_id = $this->db->insert_id();

				$this->db->insert('ac_transactions', array(
					'store_id'          => $store_id,
					'transaction_type'  => 'OPENING BALANCE',
					'ref_accounts_id'   => $parent_id,
					'credit_account_id' => $parent_id,
					'debit_account_id'  => null,
					'debit_amt'         => 0,
					'credit_amt'        => 0,
					'transaction_date'  => $CUR_DATE,
					'created_date'      => $CUR_DATE,
					'created_by'        => $CUR_USERNAME,
					'note'              => 'Initial Zero Opening Balance'
				));

				$sort_code = $parent_sort_code . ".1";
			}
		}

		$query=$this->db->query("select * from ac_accounts where upper(account_code)=upper(" . $this->db->escape($account_code) . ") and id!=$q_id and store_id=$store_id");
		if($query->num_rows()>0){
			return "Sorry! This Account Code already exists.";
		}
		$this->db->where("upper(account_name)",strtoupper($account_name));
		$this->db->where("store_id",$store_id);
		$this->db->where("parent_id",$parent_id);
		$this->db->where("id!=",$q_id);
		$query=$this->db->count_all_results("ac_accounts");
		if($query>0){
			return "Sorry! This Account Name already exists under this parent account.";
		}

		$info = array(
	    				'sort_code' 		=> $sort_code,
	    				'store_id' 			=> $store_id,
	    				'parent_id' 		=> $parent_id,
	    				'account_name' 		=> $account_name,
	    				'account_code' 		=> $account_code,
	    				'note' 				=> $note,
	    			);

		$q1 = $this->db->where('id',$q_id)->update('ac_accounts', $info);
		if ($q1){
				if(isset($opening_balance)){
					$opening_balance = (!empty($opening_balance)) ? string_to_number($opening_balance) : 0;
					$existing_ob = $this->db->where('ref_accounts_id', $q_id)
						->where('transaction_type', 'OPENING BALANCE')
						->get('ac_transactions');
					if($existing_ob->num_rows() > 0){
						$this->db->where('id', $existing_ob->row()->id)
							->update('ac_transactions', array(
								'credit_amt' => $opening_balance,
								'credit_account_id' => $q_id
							));
					} else {
						$this->db->insert('ac_transactions', array(
							'store_id'          => $store_id,
							'transaction_type'  => 'OPENING BALANCE',
							'ref_accounts_id'   => $q_id,
							'credit_account_id' => $q_id,
							'debit_account_id'  => null,
							'debit_amt'         => 0,
							'credit_amt'        => $opening_balance,
							'transaction_date'  => $CUR_DATE,
							'created_date'      => $CUR_DATE,
							'created_by'        => $CUR_USERNAME,
							'note'              => 'Opening Balance'
						));
					}
					update_account_balance($q_id);
				}

				$this->session->set_flashdata('success', 'Success!! Record Updated Successfully!');
		        return "success";
		}
		else{
		        return "failed";
		}
	}

	public function save_parent_head(){
		$this->db->trans_begin();
		extract($this->security->xss_clean(html_escape(array_merge($this->data,$_POST))));
		$store_id=(store_module() && is_admin()) ? $store_id : get_current_store_id();

		if(empty($account_name)){
			return json_encode(array('status' => 'failed', 'message' => 'Parent Head Name is required.'));
		}

		$account_name = trim($account_name);
		$existing = $this->db->where("upper(account_name)", strtoupper($account_name))
			->where("parent_id", 0)
			->where("store_id", $store_id)
			->count_all_results("ac_accounts");
		if($existing > 0){
			return json_encode(array('status' => 'failed', 'message' => 'This Parent Account Head already exists.'));
		}

		if(empty($account_code)){
			$account_code = get_init_code("accounts", $store_id);
		} else {
			$code_exist = $this->db->where("upper(account_code)", strtoupper(trim($account_code)))
				->where("store_id", $store_id)
				->count_all_results("ac_accounts");
			if($code_exist > 0){
				return json_encode(array('status' => 'failed', 'message' => 'This Account Code already exists.'));
			}
		}

		$max_root = $this->db->select("coalesce(max(id),0)+1 as maxid")->where("store_id", $store_id)->get("ac_accounts")->row()->maxid;
		$opening_balance = (isset($opening_balance) && !empty($opening_balance)) ? string_to_number($opening_balance) : 0;
		$note = isset($note) ? trim($note) : 'Parent Account Head';

		$parent_data = array(
			'count_id'     => get_count_id('ac_accounts', $store_id),
			'store_id'     => $store_id,
			'sort_code'    => $max_root,
			'account_code' => $account_code,
			'parent_id'    => 0,
			'account_name' => $account_name,
			'note'         => $note,
			'balance'      => $opening_balance,
			'created_date' => $CUR_DATE,
			'created_time' => $CUR_TIME,
			'created_by'   => $CUR_USERNAME,
			'system_ip'    => $SYSTEM_IP,
			'system_name'  => $SYSTEM_NAME,
			'status'       => 1
		);
		$this->db->insert('ac_accounts', $parent_data);
		$parent_id = $this->db->insert_id();

		$this->db->insert('ac_transactions', array(
			'store_id'          => $store_id,
			'transaction_type'  => 'OPENING BALANCE',
			'ref_accounts_id'   => $parent_id,
			'credit_account_id' => $parent_id,
			'debit_account_id'  => null,
			'debit_amt'         => 0,
			'credit_amt'        => $opening_balance,
			'transaction_date'  => $CUR_DATE,
			'created_date'      => $CUR_DATE,
			'created_by'        => $CUR_USERNAME,
			'note'              => 'Initial Opening Balance'
		));
		update_account_balance($parent_id);

		$this->db->trans_commit();
		return json_encode(array(
			'status' => 'success',
			'message' => 'Parent Account Head created successfully!',
			'id' => $parent_id,
			'name' => $account_name,
			'code' => $account_code
		));
	}

	public function update_opening_balance($account_id, $amount, $note = ''){
		$store_id = get_current_store_id();
		$amount = string_to_number($amount);

		$existing = $this->db->where('ref_accounts_id', $account_id)
			->where('transaction_type', 'OPENING BALANCE')
			->get('ac_transactions');

		if($existing->num_rows() > 0){
			$this->db->where('id', $existing->row()->id)
				->update('ac_transactions', array(
					'credit_amt' => $amount,
					'credit_account_id' => $account_id,
					'note' => (!empty($note) ? $note : $existing->row()->note)
				));
		} else {
			$this->db->insert('ac_transactions', array(
				'store_id'          => $store_id,
				'transaction_type'  => 'OPENING BALANCE',
				'ref_accounts_id'   => $account_id,
				'credit_account_id' => $account_id,
				'debit_account_id'  => null,
				'debit_amt'         => 0,
				'credit_amt'        => $amount,
				'transaction_date'  => date('Y-m-d'),
				'created_date'      => date('Y-m-d'),
				'created_by'        => $this->session->userdata('inv_username'),
				'note'              => (!empty($note) ? $note : 'Opening Balance')
			));
		}

		update_account_balance($account_id);
		return true;
	}
	
	
	public function delete_accounts_from_table($ids){
		$this->db->trans_begin();
		

		$reset_accounts = $this->db->select("debit_account_id,credit_account_id")
							 ->where("ref_accounts_id in ($ids)")
							 ->where("ref_moneytransfer_id in ($ids)")
							 ->where("ref_moneydeposits_id in ($ids)")
							 ->group_by("debit_account_id,credit_account_id")->get("ac_transactions");

		$id_arr = array_filter(array_map('intval', explode(',', $ids)));
		if(!empty($id_arr)){
			$this->db->where_in('parent_id', $id_arr)->set('parent_id', 0)->update('ac_accounts');
		}

		$this->db->where("id in ($ids)");
		//if not admin
		if(!is_admin()){
			$this->db->where("store_id",get_current_store_id());
		}

		$query1=$this->db->delete("ac_accounts");
        if (!$query1){
            return "failed";
        }

        if($reset_accounts->num_rows()>0){
        	foreach ($reset_accounts->result() as $res1) {
        		if(!update_account_balance($res1->debit_account_id)){
					return 'failed';
				}

				if(!update_account_balance($res1->credit_account_id)){
					return 'failed';
				}

        	}
        }

        $this->db->trans_commit();
        return "success";
        
	}
}
