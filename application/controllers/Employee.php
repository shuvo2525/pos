<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load_global();
		if(is_admin()){
			$this->session->set_flashdata('warning', 'HR / Employee Management is designated for shop administration only.');
			redirect(base_url('dashboard'));
			exit();
		}
		$this->load->model('employee_model', 'employee');
	}

	public function index()
	{
		$this->permission_check('employee_view');
		$data = $this->data;
		$data['page_title'] = 'Employee List';
		$data['stats'] = $this->employee->get_employee_stats();
		$this->load->view('employee/employee_list', $data);
	}

	public function add()
	{
		$this->permission_check('employee_add');
		$data = $this->data;
		$data['page_title'] = 'Add Employee';
		$data['employee_code'] = $this->employee->get_next_employee_code();
		$data['employee'] = null;
		$data['q_id'] = '';
		$this->load->view('employee/employee', $data);
	}

	public function edit($id)
	{
		$this->permission_check('employee_edit');
		$emp = $this->employee->get_details($id);
		if(!$emp){
			$this->session->set_flashdata('error', 'Employee record not found!');
			redirect(base_url('employee'));
			return;
		}

		$data = $this->data;
		$data['page_title'] = 'Edit Employee';
		$data['employee'] = $emp;
		$data['q_id'] = $emp->id;
		$data['employee_code'] = $emp->employee_code;
		$this->load->view('employee/employee', $data);
	}

	public function save_or_update()
	{
		$q_id = $this->input->post('q_id');
		if(empty($q_id)){
			$this->permission_check_with_msg('employee_add');
		} else {
			$this->permission_check_with_msg('employee_edit');
		}

		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			echo json_encode(array('status' => 'failed', 'msg' => validation_errors()));
			return;
		}

		$q_id = $this->input->post('q_id');
		$existing_emp = (!empty($q_id)) ? $this->employee->get_details($q_id) : null;

		$employee_code = $this->input->post('employee_code');
		if(empty($employee_code)){
			$employee_code = $this->employee->get_next_employee_code();
		}

		// Process dates
		$dob = $this->input->post('dob');
		$dob = (!empty($dob)) ? date('Y-m-d', strtotime(str_replace('/', '-', $dob))) : null;

		$joining_date = $this->input->post('joining_date');
		$joining_date = (!empty($joining_date)) ? date('Y-m-d', strtotime(str_replace('/', '-', $joining_date))) : null;

		$salary = $this->input->post('monthly_salary');
		$salary = (!empty($salary) && is_numeric($salary)) ? $salary : 0.00;

		$data = array(
			'employee_code'             => $employee_code,
			'first_name'                => $this->input->post('first_name'),
			'last_name'                 => $this->input->post('last_name'),
			'email'                     => $this->input->post('email'),
			'mobile'                    => $this->input->post('mobile'),
			'phone'                     => $this->input->post('phone'),
			'designation'               => $this->input->post('designation'),
			'department'                => $this->input->post('department'),
			'dob'                       => $dob,
			'gender'                    => $this->input->post('gender'),
			'marital_status'            => $this->input->post('marital_status'),
			'blood_group'               => $this->input->post('blood_group'),
			'joining_date'              => $joining_date,
			'monthly_salary'            => $salary,
			'nid_number'                => $this->input->post('nid_number'),
			'present_address'           => $this->input->post('present_address'),
			'permanent_address'         => $this->input->post('permanent_address'),
			'emergency_contact_name'    => $this->input->post('emergency_contact_name'),
			'emergency_contact_relation'=> $this->input->post('emergency_contact_relation'),
			'emergency_contact_mobile'  => $this->input->post('emergency_contact_mobile'),
			'bank_name'                 => $this->input->post('bank_name'),
			'bank_account_holder'       => $this->input->post('bank_account_holder'),
			'bank_account_number'       => $this->input->post('bank_account_number'),
			'bank_branch'               => $this->input->post('bank_branch'),
			'bank_routing_code'         => $this->input->post('bank_routing_code'),
			'education_details'         => $this->input->post('education_details'),
			'experience_details'        => $this->input->post('experience_details'),
			'skills'                    => $this->input->post('skills'),
			'notes'                     => $this->input->post('notes'),
			'status'                    => ($this->input->post('status') !== null) ? $this->input->post('status') : 1
		);

		// Handle file uploads
		$upload_dir = './uploads/employees/';
		if (!is_dir($upload_dir)) {
			@mkdir($upload_dir, 0777, true);
		}

		$config = array();
		$config['upload_path']   = $upload_dir;
		$config['encrypt_name']  = TRUE;

		// 1. Profile Picture
		if(!empty($_FILES['photo']['name'])){
			$config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
			$config['max_size']      = 5120; // 5MB
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if ($this->upload->do_upload('photo')){
				$upload_data = $this->upload->data();
				$data['photo'] = 'uploads/employees/' . $upload_data['file_name'];
				if($existing_emp && !empty($existing_emp->photo) && file_exists(FCPATH . $existing_emp->photo)){
					@unlink(FCPATH . $existing_emp->photo);
				}
			} else {
				echo json_encode(array('status' => 'failed', 'msg' => 'Photo: ' . $this->upload->display_errors('', '')));
				return;
			}
		}

		// 2. NID Photo / Document
		if(!empty($_FILES['nid_photo']['name'])){
			$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|webp';
			$config['max_size']      = 10240; // 10MB
			$this->upload->initialize($config);

			if ($this->upload->do_upload('nid_photo')){
				$upload_data = $this->upload->data();
				$data['nid_photo'] = 'uploads/employees/' . $upload_data['file_name'];
				if($existing_emp && !empty($existing_emp->nid_photo) && file_exists(FCPATH . $existing_emp->nid_photo)){
					@unlink(FCPATH . $existing_emp->nid_photo);
				}
			} else {
				echo json_encode(array('status' => 'failed', 'msg' => 'NID Photo: ' . $this->upload->display_errors('', '')));
				return;
			}
		}

		// 3. CV / Resume Document
		if(!empty($_FILES['cv_file']['name'])){
			$config['allowed_types'] = 'pdf|doc|docx|jpg|png|jpeg|txt';
			$config['max_size']      = 20480; // 20MB
			$this->upload->initialize($config);

			if ($this->upload->do_upload('cv_file')){
				$upload_data = $this->upload->data();
				$data['cv_file'] = 'uploads/employees/' . $upload_data['file_name'];
				if($existing_emp && !empty($existing_emp->cv_file) && file_exists(FCPATH . $existing_emp->cv_file)){
					@unlink(FCPATH . $existing_emp->cv_file);
				}
			} else {
				echo json_encode(array('status' => 'failed', 'msg' => 'CV File: ' . $this->upload->display_errors('', '')));
				return;
			}
		}

		$result = $this->employee->save_or_update($data, $q_id);
		echo json_encode($result);
	}

	public function ajax_list()
	{
		$this->permission_check_with_msg('employee_view');
		$list = $this->employee->get_datatables();
		$data = array();
		$no = isset($_POST['start']) ? $_POST['start'] : 0;

		foreach ($list as $emp) {
			$no++;
			$row = array();

			// 1. Photo
			if(!empty($emp->photo) && file_exists(FCPATH . $emp->photo)){
				$photo_img = '<img src="' . base_url($emp->photo) . '" class="img-circle" style="width:44px; height:44px; object-fit:cover; border:2px solid #00c0ef; box-shadow:0 2px 6px rgba(0,0,0,0.15);">';
			} else {
				$initial = strtoupper(substr($emp->first_name, 0, 1));
				$photo_img = '<div style="width:44px; height:44px; border-radius:50%; background:linear-gradient(135deg, #00c0ef, #0073b7); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:18px; box-shadow:0 2px 6px rgba(0,0,0,0.15);">' . $initial . '</div>';
			}
			$row[] = '<div style="display:flex; justify-content:center;">' . $photo_img . '</div>';

			// 2. Employee Code
			$row[] = '<span class="label label-primary" style="font-size:12px; letter-spacing:0.5px;">' . htmlspecialchars($emp->employee_code) . '</span>';

			// 3. Name & Email
			$full_name = htmlspecialchars($emp->first_name . ' ' . $emp->last_name);
			$email_str = (!empty($emp->email)) ? '<br><small class="text-muted"><i class="fa fa-envelope-o"></i> ' . htmlspecialchars($emp->email) . '</small>' : '';
			$row[] = '<b>' . $full_name . '</b>' . $email_str;

			// 4. Mobile
			$row[] = '<a href="tel:' . htmlspecialchars($emp->mobile) . '" style="color:#333; font-weight:600;"><i class="fa fa-phone text-green"></i> ' . htmlspecialchars($emp->mobile) . '</a>';

			// 5. Designation & Department
			$desig = (!empty($emp->designation)) ? '<span class="label bg-purple" style="font-size:11px;">' . htmlspecialchars($emp->designation) . '</span>' : '-';
			$dept = (!empty($emp->department)) ? '<br><small class="text-muted"><i class="fa fa-building-o"></i> ' . htmlspecialchars($emp->department) . '</small>' : '';
			$row[] = $desig . $dept;

			// 6. Joining Date
			$row[] = (!empty($emp->joining_date) && $emp->joining_date != '1970-01-01') ? show_date($emp->joining_date) : '-';

			// 7. Monthly Salary
			$row[] = '<b>' . $this->currency($emp->monthly_salary) . '</b>';

			// 8. Status Toggle
			if($this->permissions('employee_edit')){
				if($emp->status == 1){
					$status_html = '<span onclick="update_status(' . $emp->id . ', 0)" class="label label-success" style="cursor:pointer;" title="Click to Deactivate"><i class="fa fa-check-circle"></i> Active</span>';
				} else {
					$status_html = '<span onclick="update_status(' . $emp->id . ', 1)" class="label label-danger" style="cursor:pointer;" title="Click to Activate"><i class="fa fa-times-circle"></i> Inactive</span>';
				}
			} else {
				$status_html = ($emp->status == 1) ? '<span class="label label-success"><i class="fa fa-check-circle"></i> Active</span>' : '<span class="label label-danger"><i class="fa fa-times-circle"></i> Inactive</span>';
			}
			$row[] = $status_html;

			// 9. Actions Dropdown
			$action_str = '<div class="btn-group pull-right">
				<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius:4px; font-weight:600;">
					Action <span class="caret"></span>
				</button>
				<ul class="dropdown-menu dropdown-menu-right" style="box-shadow:0 6px 16px rgba(0,0,0,0.15); border-radius:8px;">';

			if($this->permissions('employee_view')){
				$action_str .= '<li>
					<a href="javascript:void(0)" onclick="view_profile(' . $emp->id . ')" style="padding:7px 16px;">
						<i class="fa fa-user text-aqua"></i> View Profile
					</a>
				</li>
				<li>
					<a href="' . base_url('employee/pdf/' . $emp->id) . '" target="_blank" style="padding:7px 16px;">
						<i class="fa fa-file-pdf-o text-red"></i> Download PDF
					</a>
				</li>
				<li>
					<a href="' . base_url('employee/print_profile/' . $emp->id) . '" target="_blank" style="padding:7px 16px;">
						<i class="fa fa-print text-teal"></i> Print Profile
					</a>
				</li>';
			}

			if($this->permissions('employee_edit')){
				$action_str .= '<li role="separator" class="divider"></li>
				<li>
					<a href="' . base_url('employee/edit/' . $emp->id) . '" style="padding:7px 16px;">
						<i class="fa fa-pencil text-blue"></i> Edit Employee
					</a>
				</li>';
			}

			if($this->permissions('employee_delete')){
				$action_str .= '<li>
					<a href="javascript:void(0)" onclick="delete_employee(' . $emp->id . ')" style="padding:7px 16px;">
						<i class="fa fa-trash text-danger"></i> Delete
					</a>
				</li>';
			}

			$action_str .= '</ul></div>';
			$row[] = $action_str;

			$data[] = $row;
		}

		$output = array(
			"draw"            => isset($_POST['draw']) ? intval($_POST['draw']) : 1,
			"recordsTotal"    => $this->employee->count_all(),
			"recordsFiltered" => $this->employee->count_filtered(),
			"data"            => $data,
		);

		echo json_encode($output);
	}

	public function view_profile($id)
	{
		$this->permission_check('employee_view');
		$emp = $this->employee->get_details($id);
		if(!$emp){
			if($this->input->is_ajax_request()){
				echo '<div class="alert alert-danger">Employee not found!</div>';
				return;
			}
			$this->session->set_flashdata('error', 'Employee record not found!');
			redirect(base_url('employee'));
			return;
		}

		$data = $this->data;
		$data['employee'] = $emp;
		$data['page_title'] = 'Employee Profile - ' . $emp->first_name . ' ' . $emp->last_name;

		if($this->input->is_ajax_request() || $this->input->get('modal') == 1){
			$this->load->view('employee/employee_profile_partial', $data);
		} else {
			$this->load->view('employee/employee_profile', $data);
		}
	}

	public function pdf($id)
	{
		$this->permission_check('employee_view');
		$emp = $this->employee->get_details($id);
		if(!$emp){
			show_404();
			return;
		}

		$data = $this->data;
		$data['employee'] = $emp;
		$data['store_details'] = get_store_details();
		$html = $this->load->view('employee/employee_pdf', $data, true);
		mb_internal_encoding('UTF-8');
		$options = new \Dompdf\Options();
		$options->set('isRemoteEnabled', true);
		$dompdf = new \Dompdf\Dompdf($options);
		$dompdf->loadHtml($html, 'UTF-8');
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();

		$filename = "Employee_" . $emp->employee_code . "_" . preg_replace('/[^A-Za-z0-9_]/', '', $emp->first_name) . ".pdf";
		$dompdf->stream($filename, array("Attachment" => 1));
	}

	public function print($id)
	{
		$this->print_profile($id);
	}

	public function print_profile($id)
	{
		$this->permission_check('employee_view');
		$emp = $this->employee->get_details($id);
		if(!$emp){
			show_404();
			return;
		}

		$data = $this->data;
		$data['employee'] = $emp;
		$data['store_details'] = get_store_details();
		$data['auto_print'] = true;
		$this->load->view('employee/employee_pdf', $data);
	}

	public function update_status()
	{
		$this->permission_check_with_msg('employee_edit');
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		echo $this->employee->update_status($id, $status);
	}

	public function delete_employee()
	{
		$this->permission_check_with_msg('employee_delete');
		$id = $this->input->post('q_id');
		echo $this->employee->delete_employee($id);
	}
}
