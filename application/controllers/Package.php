<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Package extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('package_model','package');
	}

	private function admin_only(){
		if(!is_admin()){
			$this->show_access_denied_page();
			exit();
		}
	}

	public function index(){
		$this->admin_only();
		$this->permission_check('package_view');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('package_list');
		$this->load->view('package-list', $data);
	}

	public function add(){
		$this->admin_only();
		$this->permission_check('package_add');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('package');
		$this->load->view('package', $data);
	}

	public function update($id){
		$this->admin_only();
		$this->permission_check('package_edit');
		$data = $this->data;
		$result = $this->package->get_details($id, $data);
		$data = array_merge($data, $result);
		$data['page_title'] = $this->lang->line('package');
		$this->load->view('package', $data);
	}

	public function save_update_package(){
		$this->admin_only();
		$command = $this->input->get('command');
		if($command == 'save'){
			$this->permission_check_with_msg('package_add');
		}
		else{
			$this->permission_check_with_msg('package_edit');
		}

		$this->form_validation->set_rules('package_name', 'Package Name', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			echo $this->package->save_and_update();
		}
		else {
			echo "Please Enter Compulsory(*) Fields!";
		}
	}

	public function ajax_list(){
		$this->admin_only();
		$this->permission_check_with_msg('package_view');

		$list = $this->package->get_datatables();
		$data = array();
		$no = isset($_POST['start']) ? $_POST['start'] : 0;

		foreach ($list as $package) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$package->id.' class="checkbox column_checkbox" >';
			$row[] = $package->package_type;
			$row[] = $package->package_name;
			$row[] = $this->currency($package->monthly_price, true);
			$row[] = $this->currency($package->annual_price, true);
			$row[] = $package->trial_days;
			$row[] = ($package->max_warehouses == '-1') ? '∞' : $package->max_warehouses;
			$row[] = ($package->max_users == '-1') ? '∞' : $package->max_users;
			$row[] = ($package->max_items == '-1') ? '∞' : $package->max_items;
			$row[] = ($package->max_invoices == '-1') ? '∞' : $package->max_invoices;

			$expire = '';
			if(!empty($package->expire_date) && $package->expire_date != '1970-01-01' && $package->expire_date != '0000-00-00'){
				$expire = show_date($package->expire_date);
			}
			$row[] = $expire;

			if($package->status == 1){
				$str = "<span onclick='update_status(".$package->id.",0)' id='span_".$package->id."'  class='label label-success' style='cursor:pointer'>Active </span>";
			}
			else{
				$str = "<span onclick='update_status(".$package->id.",1)' id='span_".$package->id."'  class='label label-danger' style='cursor:pointer'> Inactive </span>";
			}
			$row[] = $str;

			$str2 = '<div class="btn-group" title="View Account">
						<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
							Action <span class="caret"></span>
						</a>
						<ul role="menu" class="dropdown-menu dropdown-light pull-right">';

			if($this->permissions('package_edit')){
				$str2 .= '<li>
							<a title="Edit Record ?" href="'.base_url('package/update/'.$package->id).'">
								<i class="fa fa-fw fa-edit text-blue"></i>Edit
							</a>
						</li>';
			}

			if($this->permissions('package_delete')){
				$str2 .= '<li>
							<a style="cursor:pointer" title="Delete Record ?" onclick="delete_package('.$package->id.')">
								<i class="fa fa-fw fa-trash text-red"></i>Delete
							</a>
						</li>';
			}

			$str2 .= '</ul></div>';
			$row[] = $str2;
			$data[] = $row;
		}

		$output = array(
			"draw" => isset($_POST['draw']) ? $_POST['draw'] : 0,
			"recordsTotal" => $this->package->count_all(),
			"recordsFiltered" => $this->package->count_filtered(),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function update_status(){
		$this->admin_only();
		$this->permission_check_with_msg('package_edit');
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$this->package->update_status($id, $status);
	}

	public function delete_package(){
		$this->admin_only();
		$this->permission_check_with_msg('package_delete');
		$id = $this->input->post('q_id');
		$this->package->delete_package_from_table($id);
	}

	public function multi_delete(){
		$this->admin_only();
		$this->permission_check_with_msg('package_delete');
		$ids = implode(",", $this->input->post('checkbox'));
		$this->package->delete_package_from_table($ids);
	}
}
