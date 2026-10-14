<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gateways extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('gateways_model','gateways');
	}

	private function admin_only(){
		if(!is_admin()){
			$this->show_access_denied_page();
			exit();
		}
	}

	public function index(){
		$this->admin_only();
		$this->permission_check('gateway_view');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('payment_gateways');
		$this->load->view('gateways', $data);
	}

	public function update_gateways(){
		$this->admin_only();
		$this->permission_check_with_msg('gateway_view');
		echo $this->gateways->update_gateways();
	}

	public function update_status(){
		$this->admin_only();
		$this->permission_check_with_msg('gateway_view');
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$this->gateways->update_status($id, $status);
	}

	public function delete_gateways(){
		$this->admin_only();
		$this->permission_check_with_msg('gateway_view');
		$id = $this->input->post('q_id');
		if(method_exists($this->gateways, 'delete_gateways_from_table')){
			$this->gateways->delete_gateways_from_table($id);
			return;
		}
		echo "failed";
	}

	public function multi_delete(){
		$this->admin_only();
		$this->permission_check_with_msg('gateway_view');
		$ids = implode(",", $this->input->post('checkbox'));
		if(method_exists($this->gateways, 'delete_gateways_from_table')){
			$this->gateways->delete_gateways_from_table($ids);
			return;
		}
		echo "failed";
	}
}
