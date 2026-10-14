<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends CI_Model {

	var $table = 'db_employees as a';
	var $column_order = array(
		'a.id',
		'a.photo',
		'a.employee_code',
		'a.first_name',
		'a.mobile',
		'a.designation',
		'a.department',
		'a.joining_date',
		'a.monthly_salary',
		'a.status',
		'a.id'
	);
	var $column_search = array(
		'a.id',
		'a.employee_code',
		'a.first_name',
		'a.last_name',
		'a.mobile',
		'a.email',
		'a.designation',
		'a.department',
		'a.nid_number'
	);
	var $order = array('a.id' => 'desc');

	public function __construct()
	{
		parent::__construct();
	}

	private function _get_datatables_query()
	{
		$this->db->select("a.*");
		$this->db->from($this->table);
		if(!is_admin()){
			$this->db->where("a.store_id", get_current_store_id());
		}

		$i = 0;
		foreach ($this->column_search as $item)
		{
			if(isset($_POST['search']['value']) && !empty($_POST['search']['value']))
			{
				if($i === 0)
				{
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	public function get_datatables()
	{
		$this->_get_datatables_query();
		if(isset($_POST['length']) && $_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		if(!is_admin()){
			$this->db->where("a.store_id", get_current_store_id());
		}
		return $this->db->count_all_results();
	}

	public function get_next_employee_code()
	{
		$store_id = get_current_store_id();
		$row = $this->db->select_max('id', 'max_id')->where('store_id', $store_id)->get('db_employees')->row();
		$max_id = (!empty($row) && isset($row->max_id)) ? $row->max_id : 0;
		$next = $max_id + 1;
		return 'EMP-' . str_pad($next, 4, '0', STR_PAD_LEFT);
	}

	public function get_details($id)
	{
		$this->db->where('id', $id);
		if(!is_admin()){
			$this->db->where('store_id', get_current_store_id());
		}
		$query = $this->db->get('db_employees');
		if($query->num_rows() == 0){
			return false;
		}
		return $query->row();
	}

	public function save_or_update($data, $q_id = '')
	{
		$store_id = get_current_store_id();
		$cur_date = date("Y-m-d");
		$cur_time = date("h:i:s a");
		$cur_user = $this->session->userdata('inv_username') ? $this->session->userdata('inv_username') : 'Admin';

		if(empty($q_id)){
			// Insert
			$data['store_id'] = $store_id;
			$data['created_date'] = $cur_date;
			$data['created_time'] = $cur_time;
			$data['created_by'] = $cur_user;

			$query = $this->db->insert('db_employees', $data);
			if($query){
				return array('status' => 'success', 'id' => $this->db->insert_id(), 'msg' => 'Employee Added Successfully!');
			}
			return array('status' => 'failed', 'msg' => 'Failed to add employee!');
		} else {
			// Update
			$this->db->where('id', $q_id);
			if(!is_admin()){
				$this->db->where('store_id', $store_id);
			}
			$query = $this->db->update('db_employees', $data);
			if($query){
				return array('status' => 'success', 'id' => $q_id, 'msg' => 'Employee Updated Successfully!');
			}
			return array('status' => 'failed', 'msg' => 'Failed to update employee!');
		}
	}

	public function update_status($id, $status)
	{
		$this->db->where('id', $id);
		if(!is_admin()){
			$this->db->where('store_id', get_current_store_id());
		}
		$query = $this->db->update('db_employees', array('status' => $status));
		return ($query) ? 'success' : 'failed';
	}

	public function delete_employee($id)
	{
		$emp = $this->get_details($id);
		if(!$emp){
			return 'Employee not found!';
		}

		// Delete associated files
		if(!empty($emp->photo) && file_exists(FCPATH . $emp->photo)){
			@unlink(FCPATH . $emp->photo);
		}
		if(!empty($emp->nid_photo) && file_exists(FCPATH . $emp->nid_photo)){
			@unlink(FCPATH . $emp->nid_photo);
		}
		if(!empty($emp->cv_file) && file_exists(FCPATH . $emp->cv_file)){
			@unlink(FCPATH . $emp->cv_file);
		}

		$this->db->where('id', $id);
		if(!is_admin()){
			$this->db->where('store_id', get_current_store_id());
		}
		$query = $this->db->delete('db_employees');
		return ($query) ? 'success' : 'failed';
	}

	public function get_employee_stats()
	{
		$store_id = get_current_store_id();
		$this->db->where('store_id', $store_id);
		$total = $this->db->count_all_results('db_employees');

		$this->db->where('store_id', $store_id);
		$this->db->where('status', 1);
		$active = $this->db->count_all_results('db_employees');

		$this->db->where('store_id', $store_id);
		$this->db->where('status', 0);
		$inactive = $this->db->count_all_results('db_employees');

		$this->db->select_sum('monthly_salary', 'total_payroll');
		$this->db->where('store_id', $store_id);
		$this->db->where('status', 1);
		$payroll_row = $this->db->get('db_employees')->row();
		$payroll = (!empty($payroll_row) && isset($payroll_row->total_payroll)) ? $payroll_row->total_payroll : 0;

		return array(
			'total' => $total,
			'active' => $active,
			'inactive' => $inactive,
			'payroll' => (!empty($payroll)) ? $payroll : 0
		);
	}
}
