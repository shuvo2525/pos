<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('store_model','store');
	}

	public function add(){
		$this->permission_check('store_add');
		$data=array_merge($this->data,$this->store->store_making_codes());
		$data['page_title']=$this->lang->line('store');
		$data['package_list'] = $this->db->where('status', 1)->order_by('id', 'asc')->get('db_package')->result();
		$this->load->view('store', $data);
	}
	public function newstore(){
		$result=$this->store->verify_and_save();
		echo $result;	
	}
	
	
	
	public function view(){
		$this->permission_check('store_view');
		$data=array_merge($this->data);
		$data['page_title']=$this->lang->line('store_list');
		$this->load->view('store/store_list', $data);
	}

	public function ajax_list()
	{
		$list = $this->store->get_datatables();
		//echo "<pre>";print_r($list);exit;
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $store) {
			$no++;
			$row = array();
			$disable = ($store->id==1) ? 'disabled' : '';

			$row[] = ($store->id==1) ? '<span data-toggle="tooltip" title="Resticted" class="text-danger fa fa-fw fa-ban"></span>' : '<input type="checkbox" name="checkbox[]" '.$disable.' value='.$store->id.' class="checkbox column_checkbox" >';

			$row[] = $store->store_code;
			$row[] = $store->store_name;
			$row[] = $store->mobile;
			$row[] = $store->address;

			$row[] = $store->created_date;
			$row[] = $store->created_by;
			
			$is_unsub = (isset($store->package_status) && strtolower($store->package_status) == 'unsubscribed') || (isset($store->payment_status) && strtolower($store->payment_status) == 'unsubscribed');
			$is_paid = (isset($store->payment_status) && (strtolower($store->payment_status) == 'paid' || strtolower($store->payment_status) == 'success'));
			$is_pending = (isset($store->package_status) && strtolower($store->package_status) == 'pending') || ($store->status == 0 && $store->id != 1);

			$pkg_name = (!empty($store->package_name)) ? $store->package_name : '-';
			if($store->id == 1){
				$pkg_name = "<b>Unlimited Lifetime</b><br><span class='label label-success' style='font-size:10px;'>Active (Unlimited)</span>";
			} else if($is_unsub){
				$pkg_name .= "<br><span class='label label-danger' style='font-size:10px;'>Unsubscribed & Locked</span>";
			} else if($is_pending){
				$pkg_name .= "<br><span class='label label-warning' style='font-size:10px;'>Pending Approval</span>";
			} else if(isset($store->package_type) && $store->package_type == 'Paid' && !$is_paid){
				$pkg_name .= "<br><span class='label label-warning' style='font-size:10px;'>Pending Payment</span>";
			}
			$row[] = $pkg_name;

					$auto_lock_day = intval($store->auto_lock_day ?? 0);
					$auto_lock_date = !empty($store->auto_lock_date) ? $store->auto_lock_date : '';
					$escaped_name = htmlspecialchars(addslashes($store->store_name), ENT_QUOTES);
					$escaped_code = htmlspecialchars(addslashes($store->store_code ?? ''), ENT_QUOTES);
					$escaped_note = htmlspecialchars(addslashes($store->auto_lock_note ?? ''), ENT_QUOTES);
					$store_status = intval($store->status);

					$is_auto_locked = (!empty($auto_lock_date) && $auto_lock_date <= date('Y-m-d') && $auto_lock_day > 0 && $store->id != 1);

					if($store->id == 1){
						$exp_col = "<span class='label label-success' style='font-size:11px; font-weight:700; background:linear-gradient(135deg, #10b981 0%, #059669 100%); padding:4px 8px; border-radius:4px;'><i class='fa fa-infinity'></i> Unlimited</span>";
					} else {
						$exp_str = ($store->expire_date < date("Y-m-d") && !empty($store->expire_date)) ?  "<br><span  class='label label-default label-danger' disabled='disabled' style='cursor:disabled'>Expired</span>" : '';
						$exp_col = (!empty($store->expire_date)) ? show_date($store->expire_date).$exp_str : '-';
						if($auto_lock_day > 0){
							$exp_col .= "<br><span class='label' style='background:#7c3aed; color:#fff; font-size:10px;' title='Monthly Auto-Lock on day ".$auto_lock_day."'><i class='fa fa-clock-o'></i> Lock: Day ".$auto_lock_day."</span>";
							if(!empty($auto_lock_date)){
								$due_cls = ($auto_lock_date <= date('Y-m-d')) ? 'text-danger' : 'text-primary';
								$exp_col .= "<br><small class='".$due_cls."' style='font-size:10px; font-weight:600;'><i class='fa fa-calendar-check-o'></i> Due: ".show_date($auto_lock_date)."</small>";
							}
						}
					}
			$row[] = $exp_col;

					$is_locked = ($store->id != 1) ? is_store_locked_or_expired($store->id) : false;

					if($store->id==1){ 
						$str= "<span class='label label-success' style='background:linear-gradient(135deg, #2563eb 0%, #7c3aed 100%); font-size:11px; padding:4px 8px; border-radius:4px;'><i class='fa fa-shield'></i> Super Admin (SaaS)</span>"; 
					}
					else if($is_auto_locked){
						$str = "<span onclick=\"unlock_store_direct(".$store->id.")\" class='label label-danger' style='cursor:pointer; font-size:11px; padding:4px 10px; border-radius:4px; display:inline-block;' title='Auto-Locked: Monthly Payment Due on ".show_date($auto_lock_date).". Click to Authorise & Unlock.'><i class='fa fa-lock'></i> Auto-Locked (Click to Unlock)</span>";
					}
			 		else if($is_locked || $is_unsub){
						$str = "<span onclick=\"unlock_store_direct(".$store->id.")\" class='label label-danger' style='cursor:pointer; font-size:11px; padding:4px 10px; border-radius:4px; display:inline-block;' title='Store is Locked or Subscription Inactive. Click to Authorise & Unlock.'><i class='fa fa-lock'></i> Locked (Click to Unlock)</span>";
					}
			 		else if($store->status==1){ 
			 			$str= "<span onclick='lock_store_direct(".$store->id.")' id='span_".$store->id."' class='label label-success' style='cursor:pointer; font-size:11px; padding:4px 10px; border-radius:4px; display:inline-block;' title='Store is Active. Click to Lock Store.'><i class='fa fa-check-circle'></i> Active (Click to Lock)</span>";
					}
					else{ 
						$str = "<span onclick=\"unlock_store_direct(".$store->id.")\" id='span_".$store->id."' class='label label-warning' style='cursor:pointer; font-size:11px; padding:4px 10px; border-radius:4px; display:inline-block;' title='Inactive / Pending. Click to Authorise & Unlock.'><i class='fa fa-lock'></i> Inactive (Click to Unlock)</span>";
					}
			$row[] = $str;			

					$str2 = '<div style="display:inline-flex; align-items:center; gap:5px; flex-wrap:nowrap;">';
					if(is_admin() && $store->id != 1){
						if($is_locked){
							$str2 .= '<button type="button" class="btn btn-xs btn-success" onclick="unlock_store_direct('.$store->id.')" title="Authorise & Unlock Store" style="font-weight:700; padding:5px 12px; border-radius:4px; box-shadow:none; background:#059669; border-color:#047857; color:#fff; white-space:nowrap;">
								<i class="fa fa-unlock"></i> Authorise & Unlock
							</button>';
						} else {
							$str2 .= '<button type="button" class="btn btn-xs btn-danger" onclick="lock_store_direct('.$store->id.')" title="Lock Store" style="font-weight:700; padding:5px 12px; border-radius:4px; box-shadow:none; background:#dc2626; border-color:#b91c1c; color:#fff; white-space:nowrap;">
								<i class="fa fa-lock"></i> Lock Store
							</button>';
						}
					}

					$str2 .= '<div class="btn-group" title="More Actions">
										<a class="btn btn-xs btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#" style="border-radius:4px; font-weight:600; padding:5px 10px;">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right" style="border-radius:8px; box-shadow:0 8px 24px rgba(0,0,0,0.15); min-width:215px; padding:6px 0;">';

											if(is_admin() && $store->id != 1){
												$str2.='<li>
													<a style="cursor:pointer" title="Set Monthly Subscription & Auto-Lock Date" onclick="open_sub_date_modal('.$store->id.', \''.$escaped_name.'\', \''.$escaped_code.'\', \''.$auto_lock_date.'\')">
														<i class="fa fa-fw fa-calendar-check-o text-purple" style="color:#7c3aed;"></i> Subscription Lock Date
													</a>
												</li>';

												if($is_locked){
													$str2.='<li>
														<a style="cursor:pointer" title="Manually Authorise & Unlock Store for Next Month" onclick="unlock_store_direct('.$store->id.')">
															<i class="fa fa-fw fa-unlock text-green" style="color:#059669;"></i> Authorise & Unlock
														</a>
													</li>';
												} else {
													$str2.='<li>
														<a style="cursor:pointer" title="Lock Store" onclick="lock_store_direct('.$store->id.')">
															<i class="fa fa-fw fa-lock text-red" style="color:#dc2626;"></i> Lock Store
														</a>
													</li>';
												}
											}

											if(store_module() && is_admin())
											$str2.='<li>
												<a title="View Subscription List" data-toggle="tooltip" href="'.base_url('subscribers/list/'.$store->id).'">
													<i class="fa fa-fw fa-list-alt text-blue"></i>Subscription List
												</a>
											</li>';

											if($this->permissions('store_edit'))
											$str2.='<li>
												<a title="Edit Record ?" data-toggle="tooltip" href="'.base_url('store_profile/update/'.$store->id).'">
													<i class="fa fa-fw fa-pencil text-blue"></i>Edit
												</a>
											</li>';

											// Shop-wise Database Operations (Backup, Upload, Delete Data)
											if(is_admin() || special_access()){
												$str2.='<li class="divider" style="margin:4px 0;"></li>';
												$str2.='<li class="dropdown-header text-muted" style="font-weight:700; text-transform:uppercase; font-size:10px; padding:3px 15px;">Shop Database</li>';
												
												$str2.='<li>
													<a style="cursor:pointer" title="Download database backup of this shop" href="'.base_url('store/download_shop_backup/'.$store->id).'">
														<i class="fa fa-fw fa-download text-green" style="color:#059669;"></i> Download Backup
													</a>
												</li>';

												$str2.='<li>
													<a style="cursor:pointer" title="Upload and restore database backup into this shop" onclick="open_upload_shop_backup_modal('.$store->id.', \''.$escaped_name.'\', \''.$escaped_code.'\')">
														<i class="fa fa-fw fa-upload text-blue" style="color:#2563eb;"></i> Upload & Restore Backup
													</a>
												</li>';

												if($store->id != 1){
													$str2.='<li>
														<a style="cursor:pointer" title="Delete all operational/database records of this shop" onclick="confirm_delete_shop_data('.$store->id.', \''.$escaped_name.'\', \''.$escaped_code.'\')">
															<i class="fa fa-fw fa-trash-o text-red" style="color:#dc2626;"></i> Delete Shop Data
														</a>
													</li>';
												}
											}

											if($this->permissions('store_delete') && $store->id!=1)
											$str2.='<li>
												<a style="cursor:pointer" data-toggle="tooltip" title="Delete Record ?" onclick="delete_store('.$store->id.')">
													<i class="fa fa-fw fa-trash text-red"></i>Delete Store
												</a>
											</li>';
											
										$str2 .= '</ul>
									</div>';			

			$row[] = $str2;
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->store->count_all(),
						"recordsFiltered" => $this->store->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function update_status(){
		$this->permission_check_with_msg('store_edit');
		$id=$this->input->post('id');
		$status=$this->input->post('status');

		
		$result=$this->store->update_status($id,$status);
		return $result;
	}
	
	public function delete_store(){
		$this->permission_check_with_msg('store_delete');
		$id=$this->input->post('q_id');
		return $this->store->delete_store_from_table($id);
	}
	public function multi_delete(){
		$this->permission_check_with_msg('store_delete');
		$ids=implode (",",$_POST['checkbox']);
		return $this->store->delete_store_from_table($ids);
	}

	public function update_auto_lock(){
		$this->permission_check_with_msg('store_edit');
		$store_id = $this->input->post('store_id');
		$auto_lock_day = $this->input->post('auto_lock_day');
		$auto_lock_date = $this->input->post('auto_lock_date');
		$auto_lock_note = $this->input->post('auto_lock_note');
		$activate_store = $this->input->post('activate_store');

		$result = $this->store->update_auto_lock($store_id, $auto_lock_day, $auto_lock_date, $auto_lock_note, $activate_store);
		echo $result;
	}

	public function lock_store(){
		$this->permission_check_with_msg('store_edit');
		$store_id = $this->input->post('store_id');
		if(empty($store_id) || $store_id == 1){
			echo "Invalid store ID"; return;
		}
		$store = $this->db->where('id', $store_id)->get('db_store')->row();
		if(empty($store)){
			echo "Store not found"; return;
		}

		$this->db->where('id', $store_id)->update('db_store', array('status' => 0));

		$sub_id = !empty($store->current_subscriptionlist_id) ? $store->current_subscriptionlist_id : 0;
		if(empty($sub_id)){
			$sub = $this->db->where('store_id', $store_id)->order_by('id', 'desc')->get('db_subscription')->row();
			if(!empty($sub)){
				$sub_id = $sub->id;
			}
		}
		if(!empty($sub_id)){
			$this->db->where('id', $sub_id)->update('db_subscription', array(
				'package_status' => 'Unsubscribed',
				'payment_status' => 'Unsubscribed'
			));
		}
		echo "success";
	}

	public function unlock_store(){
		$this->permission_check_with_msg('store_edit');
		$store_id = $this->input->post('store_id');
		if(empty($store_id) || $store_id == 1){
			echo "Invalid store ID"; return;
		}
		$store = $this->db->where('id', $store_id)->get('db_store')->row();
		if(empty($store)){
			echo "Store not found"; return;
		}
		
		$auto_lock_day = (!empty($store->auto_lock_day) && $store->auto_lock_day > 0) ? intval($store->auto_lock_day) : intval(date('j'));
		$cur_day = intval(date('j'));
		if($auto_lock_day > $cur_day){
			$target_month = date('Y-m');
		} else {
			$target_month = date('Y-m', strtotime('+1 month'));
		}
		$max_day = intval(date('t', strtotime($target_month . '-01')));
		$day_to_use = min($auto_lock_day, $max_day);
		$next_lock_date = $target_month . '-' . sprintf('%02d', $day_to_use);

		$update_store = array(
			'status' => 1,
			'auto_lock_day' => $auto_lock_day,
			'auto_lock_date' => $next_lock_date
		);

		// Ensure valid subscription record exists
		$sub_id = $store->current_subscriptionlist_id;
		$sub_rec = !empty($sub_id) ? $this->db->where('id', $sub_id)->get('db_subscription')->row() : null;
		if(empty($sub_rec)){
			$sub_rec = $this->db->where('store_id', $store_id)->order_by('id', 'desc')->get('db_subscription')->row();
		}

		if(!empty($sub_rec)){
			$this->db->where('id', $sub_rec->id)->update('db_subscription', array(
				'package_status' => 'Active',
				'payment_status' => 'Paid',
				'expire_date'    => $next_lock_date
			));
			$update_store['current_subscriptionlist_id'] = $sub_rec->id;
		} else {
			$sub_data = array(
				'store_id'          => $store_id,
				'package_id'        => 3,
				'package_name'      => 'Starter 100',
				'package_type'      => 'Paid',
				'payment_type'      => 'Monthly',
				'subscription_date' => date('Y-m-d'),
				'expire_date'       => $next_lock_date,
				'payment_status'    => 'Paid',
				'package_status'    => 'Active',
				'created_date'      => date('Y-m-d'),
				'created_time'      => date('h:i:s a'),
				'created_by'        => $this->session->userdata('inv_username') ?: 'admin',
				'system_ip'         => $this->input->ip_address(),
				'system_name'       => gethostbyaddr($this->input->ip_address()) ?: 'POS'
			);
			$this->db->insert('db_subscription', $sub_data);
			$update_store['current_subscriptionlist_id'] = $this->db->insert_id();
		}

		$this->db->where('id', $store_id)->update('db_store', $update_store);
		
		echo "success";
	}

	public function save_subscription_date(){
		$this->permission_check_with_msg('store_edit');
		$store_id = $this->input->post('store_id');
		$sub_date = $this->input->post('sub_date');
		$result = $this->store->save_subscription_date($store_id, $sub_date);
		echo $result;
	}

	public function download_shop_backup($store_id){
		if(empty($store_id)){
			$store_id = get_current_store_id();
		}
		
		$allowed = false;
		if(is_admin() || special_access()){
			$allowed = true;
		} else if(is_store_admin() && $store_id == get_current_store_id()){
			$allowed = true;
		} else if($this->permissions('store_edit') && $store_id == get_current_store_id()){
			$allowed = true;
		}
		
		if(!$allowed){
			echo "Access Denied: You do not have permission to download this shop backup"; exit;
		}
		$store = $this->db->where('id', $store_id)->get('db_store')->row();
		if(empty($store)){
			echo "Store not found!"; exit;
		}
		@ini_set('max_execution_time', 300);
		@ini_set('memory_limit', '512M');
		$sql = $this->store->generate_shop_backup_sql($store_id);
		if(empty($sql)){
			echo "Failed to generate backup!"; exit;
		}
		$this->load->helper('download');
		$store_code = !empty($store->store_code) ? preg_replace('/[^a-zA-Z0-9_-]/', '', $store->store_code) : 'shop_'.$store_id;
		$filename = 'shop_backup_' . $store_code . '_' . date('Y-m-d_His') . '.sql';
		force_download($filename, $sql);
	}

	public function upload_shop_backup(){
		$store_id = $this->input->post('store_id');
		if(empty($store_id)){
			$store_id = get_current_store_id();
		}

		$allowed = false;
		if(is_admin() || special_access()){
			$allowed = true;
		} else if(is_store_admin() && $store_id == get_current_store_id()){
			$allowed = true;
		} else if($this->permissions('store_edit') && $store_id == get_current_store_id()){
			$allowed = true;
		}

		if(!$allowed){
			echo json_encode(array('status' => 'failed', 'message' => 'Access Denied: You do not have permission to restore this shop data')); exit;
		}

		if(empty($store_id)){
			echo json_encode(array('status' => 'failed', 'message' => 'Invalid store ID')); exit;
		}
		if(!isset($_FILES['backup_file']['name']) || empty($_FILES['backup_file']['name'])){
			echo json_encode(array('status' => 'failed', 'message' => 'Please select a backup file (.sql or .json)')); exit;
		}

		$file_ext = strtolower(pathinfo($_FILES['backup_file']['name'], PATHINFO_EXTENSION));
		if(!in_array($file_ext, array('sql', 'json', 'txt'))){
			echo json_encode(array('status' => 'failed', 'message' => 'Only .sql, .json or .txt backup files are supported!')); exit;
		}

		$content = file_get_contents($_FILES['backup_file']['tmp_name']);
		if(empty($content)){
			echo json_encode(array('status' => 'failed', 'message' => 'The uploaded file is empty!')); exit;
		}

		@ini_set('max_execution_time', 600);
		@ini_set('memory_limit', '512M');

		$clean = $this->input->post('clean_existing') ? 1 : 0;
		$result = $this->store->restore_shop_backup_sql($store_id, $content, $clean);

		if($result === 'success'){
			echo json_encode(array('status' => 'success', 'message' => 'Shop data restored successfully!'));
		} else {
			echo json_encode(array('status' => 'failed', 'message' => $result));
		}
	}

	public function delete_shop_data(){
		if(!is_admin() && !special_access()){
			echo "Access Denied"; exit;
		}
		$store_id = $this->input->post('store_id');
		if(empty($store_id) || $store_id == 1){
			echo "Super Admin store data cannot be deleted"; exit;
		}
		$result = $this->store->delete_shop_data($store_id);
		echo $result;
	}

}


