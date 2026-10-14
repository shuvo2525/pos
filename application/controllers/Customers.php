<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('customers_model','customers');
	}

	public function index()
	{
		$this->permission_check('customers_view');
		$data=$this->data;
		$data['page_title']=$this->lang->line('customers_list');
		$this->load->view('customers-view',$data);
	}
	public function add()
	{
		$this->permission_check('customers_add');
		$data=$this->data;
		$data['page_title']=$this->lang->line('customers');
		$this->load->view('customers',$data);
	}

	public function newcustomers(){
		$this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|required');
		
		
		if ($this->form_validation->run() == TRUE) {
			$result=$this->customers->verify_and_save();
			echo $result;
		} else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}
	public function update($id){
		$this->belong_to('db_customers',$id);
		$this->permission_check('customers_edit');
		$data=$this->data;
		$result=$this->customers->get_details($id,$data);
		$data=array_merge($data,$result);
		$data['page_title']=$this->lang->line('customers');
		$this->load->view('customers', $data);
	}
	public function update_customers(){
		$this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {			
			$result=$this->customers->update_customers();
			echo $result;
		} else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}


	public function ajax_list()
	{
		$list = $this->customers->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $customers) {

			$opening_balance =(!empty($customers->opening_balance)) ? $customers->opening_balance : 0;
			$opening_balance -=get_paid_cob($customers->id);
			$sales_due =(!empty($customers->sales_due)) ? $customers->sales_due : 0;
			$sales_return_due =(!empty($customers->sales_return_due)) ? $customers->sales_return_due : 0;
			$total = ($opening_balance)+$sales_due-$sales_return_due;
			
			$no++;
			$row = array();
			$disable = ($customers->delete_bit==1) ? 'disabled' : '';
			
			$row[] = ($customers->delete_bit==1) ? '<span data-toggle="tooltip" title="Resticted" class="text-danger fa fa-fw fa-ban"></span>' : '<input type="checkbox" name="checkbox[]" '.$disable.' value='.$customers->id.' class="checkbox column_checkbox" >';
			
			
			$row[] = $customers->customer_code;
			$row[] = $customers->customer_name;
			$row[] = $customers->mobile;
			$row[] = $customers->email;
			$row[] = (!empty($customers->location_link)) ? '<a target="_blank" title="Click to View Location!" href="'.$customers->location_link.'"><i class="fa fa-fw fa-map-marker"></i> Link</a>' : '';
			$row[] = ($customers->credit_limit==-1) ? "<span class='badge'>No Limit</span>" :store_number_format($customers->credit_limit);
			$row[] = store_number_format($opening_balance+$sales_due);
			
			$row[] = store_number_format($sales_return_due);
			$row[] = store_number_format($customers->tot_advance);
			

			 		if($customers->status==1){ 
			 			$str= "<span onclick='update_status(".$customers->id.",0)' id='span_".$customers->id."'  class='label label-success' style='cursor:pointer'>Active </span>";}
					else{ 
						$str = "<span onclick='update_status(".$customers->id.",1)' id='span_".$customers->id."'  class='label label-danger' style='cursor:pointer'> Inactive </span>";
					}
			$row[] = $str;			
					$str2 = '<div class="btn-group" title="View Account">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light dropdown-menu-right">
											<li>
												<a title="Customer Book" href="'.base_url('customers/book/'.$customers->id).'">
													<i class="fa fa-fw fa-book text-blue"></i>Customer Book
												</a>
											</li>';

											if(is_store_admin())
											$str2.='<li>
												<a title="Discount Coupon" href="'.base_url().'customer_coupon/generate/'.$customers->id.'">
													<i class="fa fa-fw fa-tags text-blue"></i>Generate Discount Coupon
												</a>
											</li>';

											if($this->permissions('customers_edit')&& $customers->delete_bit!=1)
											$str2.='<li>
												<a title="Edit Record ?" href="'.base_url().'customers/update/'.$customers->id.'">
													<i class="fa fa-fw fa-edit text-blue"></i>Edit
												</a>
											</li>';

											if($this->permissions('cust_adv_payments_view'))
											$str2.='<li>
												<a title="Advance Payments View" href="'.base_url().'customers_advance">
													<i class="fa fa-fw fa-edit text-blue"></i>Advance Payments
												</a>
											</li>';

											if($this->permissions('sales_payment_view'))
											$str2.='<li>
												<a title="Pay" class="pointer" onclick="view_payments('.$customers->id.')" >
													<i class="fa fa-fw fa-money text-blue"></i>View Payments
												</a>
											</li>';

											if($this->permissions('sales_payment_add'))
											$str2.='<li>
												<a title="Receive Previous Balance & Sales Due Payments" class="pointer" onclick="pay_now('.$customers->id.')" >
													<i class="fa fa-fw fa-money text-blue"></i>Receive Due Payments
												</a>
											</li>';
											if($this->permissions('sales_return_payment_add'))
											$str2.='<li>
												<a title="Pay Return Due" class="pointer" onclick="pay_return_due('.$customers->id.')" >
													<i class="fa fa-fw fa-money text-blue"></i>Pay Return Due
												</a>
											</li>';
											if($this->permissions('customers_delete') && $customers->delete_bit!=1)
											$str2.='<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_customers('.$customers->id.')">
													<i class="fa fa-fw fa-trash text-red"></i>Delete
												</a>
											</li>
											
										</ul>
									</div>';			
			$row[] =  $str2;
			

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->customers->count_all(),
						"recordsFiltered" => $this->customers->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function update_status(){
		$this->permission_check_with_msg('customers_edit');
		$id=$this->input->post('id');
		$status=$this->input->post('status');

		$result=$this->customers->update_status($id,$status);
		return $result;
	}
	
	public function delete_customers(){
		$this->permission_check_with_msg('customers_delete');
		$id=$this->input->post('q_id');
		return $this->customers->delete_customers_from_table($id);
	}
	public function multi_delete(){
		$this->permission_check_with_msg('customers_delete');
		$ids=implode (",",$_POST['checkbox']);
		return $this->customers->delete_customers_from_table($ids);
	}
	public function show_pay_now_modal(){
		$this->permission_check_with_msg('sales_payment_add');
		$customer_id=$this->input->post('customer_id');
		echo $this->customers->show_pay_now_modal($customer_id);
	}
	public function save_payment(){
		$this->permission_check_with_msg('sales_payment_add');
		echo $this->customers->save_payment();
	}
	public function show_pay_return_due_modal(){
		$this->permission_check_with_msg('sales_return_payment_add');
		$customer_id=$this->input->post('customer_id');
		echo $this->customers->show_pay_return_due_modal($customer_id);
	}
	public function save_return_due_payment(){
		$this->permission_check_with_msg('sales_payment_add');
		echo $this->customers->save_return_due_payment();
	}
	public function delete_opening_balance_entry(){
		$this->permission_check_with_msg('sales_payment_delete');
		$entry_id = $this->input->post('entry_id');
		echo $this->customers->delete_opening_balance_entry($entry_id);
	}
	/*27-06-2020*/
	public function view_payment_list_modal(){
		$this->permission_check_with_msg('sales_payment_add');
		$customer_id=$this->input->post('customer_id');
		echo $this->customers->view_payment_list_modal($customer_id);
	}
	/*28-06-2020*/
	//Print Customer Bulk Payment Receipt
	public function print_show_receipt($payment_id){
		if(!$this->permissions('sales_add') && !$this->permissions('sales_edit')){
			$this->show_access_denied_page();
		}
		$data=$this->data;
		$data['page_title']=$this->lang->line('payment_receipt');
		$data=array_merge($data,array('payment_id'=>$payment_id));
		$this->load->view('print-cust-payment-receipt',$data);
	}

	public function restore_customer_list(){
		echo get_customers_select_list($this->input->post('customer_id'),get_current_store_id());
	}

	public function getCustomers($id=''){
		echo $this->customers->getCustomersJson($id);
	}

	public function book($customer_id)
	{
		$this->belong_to('db_customers', $customer_id);
		$this->permission_check('customers_view');
		$data = $this->data;
		$data['page_title'] = 'Customer Book';
		$data['customer_id'] = $customer_id;
		$this->load->view('customer_book', $data);
	}

	public function book_ajax_list()
	{
		$customer_id = $this->input->post('customer_id');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$store_id = get_current_store_id();

		$from_date = !empty($from_date) ? system_fromatted_date($from_date) : '';
		$to_date = !empty($to_date) ? system_fromatted_date($to_date) : '';

		// Get customer details
		$cust = $this->db->where('id', $customer_id)->where('store_id', $store_id)->get('db_customers')->row();
		if(!$cust){
			echo json_encode(array("draw" => isset($_POST['draw']) ? $_POST['draw'] : 1, "recordsTotal" => 0, "recordsFiltered" => 0, "data" => array()));
			return;
		}

		$transactions = array();

		// 1. Opening Balance
		$cust_created = !empty($cust->created_date) ? $cust->created_date : date('Y-m-d');
		if(!empty($cust->opening_balance) && $cust->opening_balance > 0){
			$transactions[] = array(
				'date' => $cust_created,
				'created_time' => '00:00:00',
				'type' => 'Opening Balance',
				'ref' => '-',
				'ref_url' => '',
				'debit' => (float)$cust->opening_balance,
				'credit' => 0,
				'note' => 'Initial Opening Balance',
				'created_by' => $cust->created_by,
			);
		}

		// 2. Sales Invoices (Debit)
		$sales_q = $this->db->select('id, sales_code, sales_date, created_time, grand_total, created_by')
			->where('customer_id', $customer_id)
			->where('store_id', $store_id)
			->get('db_sales');
		foreach($sales_q->result() as $s){
			$transactions[] = array(
				'date' => $s->sales_date,
				'created_time' => !empty($s->created_time) ? $s->created_time : '00:00:00',
				'type' => 'Sales Invoice',
				'ref' => $s->sales_code,
				'ref_url' => base_url('sales/invoice/'.$s->id),
				'debit' => (float)$s->grand_total,
				'credit' => 0,
				'note' => 'Sales Invoice',
				'created_by' => $s->created_by,
			);
		}

		// 3. Sales Payments (Credit)
		$payments_q = $this->db->select('id, payment_code, sales_id, payment_date, created_time, payment, payment_type, payment_note, created_by')
			->where('customer_id', $customer_id)
			->where('store_id', $store_id)
			->get('db_salespayments');
		foreach($payments_q->result() as $p){
			$transactions[] = array(
				'date' => $p->payment_date,
				'created_time' => !empty($p->created_time) ? $p->created_time : '00:00:00',
				'type' => 'Payment Received ('.$p->payment_type.')',
				'ref' => !empty($p->payment_code) ? $p->payment_code : ('PAY#'.$p->id),
				'ref_url' => '',
				'debit' => 0,
				'credit' => (float)$p->payment,
				'note' => $p->payment_note,
				'created_by' => $p->created_by,
			);
		}

		// 4. Sales Returns (Credit)
		$returns_q = $this->db->select('id, return_code, return_date, created_time, grand_total, created_by')
			->where('customer_id', $customer_id)
			->where('store_id', $store_id)
			->get('db_salesreturn');
		foreach($returns_q->result() as $r){
			$transactions[] = array(
				'date' => $r->return_date,
				'created_time' => !empty($r->created_time) ? $r->created_time : '00:00:00',
				'type' => 'Sales Return',
				'ref' => $r->return_code,
				'ref_url' => base_url('sales_return/invoice/'.$r->id),
				'debit' => 0,
				'credit' => (float)$r->grand_total,
				'note' => 'Sales Return',
				'created_by' => $r->created_by,
			);
		}

		// 5. Sales Return Payments / Refunds (Debit)
		$ret_payments_q = $this->db->select('id, payment_code, return_id, payment_date, created_time, payment, payment_type, payment_note, created_by')
			->where('customer_id', $customer_id)
			->where('store_id', $store_id)
			->get('db_salespaymentsreturn');
		foreach($ret_payments_q->result() as $rp){
			$transactions[] = array(
				'date' => $rp->payment_date,
				'created_time' => !empty($rp->created_time) ? $rp->created_time : '00:00:00',
				'type' => 'Return Refund Paid ('.$rp->payment_type.')',
				'ref' => !empty($rp->payment_code) ? $rp->payment_code : ('RPAY#'.$rp->id),
				'ref_url' => '',
				'debit' => (float)$rp->payment,
				'credit' => 0,
				'note' => $rp->payment_note,
				'created_by' => $rp->created_by,
			);
		}

		// 6. Customer Advance Payments (Credit)
		$advance_q = $this->db->select('id, payment_code, payment_date, created_time, amount, payment_type, note, created_by')
			->where('customer_id', $customer_id)
			->where('store_id', $store_id)
			->get('db_custadvance');
		foreach($advance_q->result() as $adv){
			$transactions[] = array(
				'date' => $adv->payment_date,
				'created_time' => !empty($adv->created_time) ? $adv->created_time : '00:00:00',
				'type' => 'Customer Advance ('.$adv->payment_type.')',
				'ref' => !empty($adv->payment_code) ? $adv->payment_code : ('ADV#'.$adv->id),
				'ref_url' => '',
				'debit' => 0,
				'credit' => (float)$adv->amount,
				'note' => $adv->note,
				'created_by' => $adv->created_by,
			);
		}

		// Sort all chronologically
		usort($transactions, function($a, $b) {
			$t1 = strtotime($a['date'] . ' ' . $a['created_time']);
			$t2 = strtotime($b['date'] . ' ' . $b['created_time']);
			return $t1 <=> $t2;
		});

		// Compute running balance & filter by dates if supplied
		$running_balance = 0;
		$filtered_data = array();

		foreach($transactions as $t){
			$running_balance += ($t['debit'] - $t['credit']);

			if(!empty($from_date) && $t['date'] < $from_date){
				continue;
			}
			if(!empty($to_date) && $t['date'] > $to_date){
				continue;
			}

			$ref_html = !empty($t['ref_url']) ? '<a href="'.$t['ref_url'].'" target="_blank"><b>'.$t['ref'].'</b></a>' : $t['ref'];

			$filtered_data[] = array(
				show_date($t['date']),
				$t['type'],
				$ref_html,
				($t['debit'] > 0) ? store_number_format($t['debit']) : '-',
				($t['credit'] > 0) ? store_number_format($t['credit']) : '-',
				store_number_format($running_balance),
				$t['note'],
				$t['created_by']
			);
		}

		$output = array(
			"draw" => isset($_POST['draw']) ? (int)$_POST['draw'] : 1,
			"recordsTotal" => count($transactions),
			"recordsFiltered" => count($filtered_data),
			"data" => $filtered_data,
		);
		echo json_encode($output);
	}
}
