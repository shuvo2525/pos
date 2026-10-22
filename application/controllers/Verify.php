<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verify extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('session'));
        $this->load->helper(array('url', 'custom', 'date', 'form'));
        
        $default_lang = ($this->session->has_userdata('language')) ? $this->session->userdata('language') : "English";
        $this->lang->load($default_lang, $default_lang);
    }

    /**
     * Public invoice verification page
     * Can be accessed via: base_url('verify/invoice/SALES_CODE') or base_url('verify/invoice/SALES_ID')
     */
    public function invoice($sales_code_or_id = '') {
        $sales_code_or_id = urldecode(trim($sales_code_or_id));
        if (empty($sales_code_or_id)) {
            $sales_code_or_id = trim($this->input->get('code') ?? $this->input->get('inv') ?? '');
        }

        if (empty($sales_code_or_id)) {
            $data = array(
                'page_title' => 'Invoice Verification',
                'found'      => false,
                'query_code' => '',
                'searched'   => false
            );
            $this->load->view('verify_invoice', $data);
            return;
        }

        // Query sale from database
        $this->db->select("s.*, c.customer_name, c.mobile as customer_mobile, c.address as customer_address, 
                           st.store_name, st.mobile as store_mobile, st.phone as store_phone, st.email as store_email, 
                           st.address as store_address, st.city as store_city, st.postcode as store_postcode, 
                           st.store_logo, st.pos_invoice_format_id, st.signature, st.store_website");
        $this->db->from("db_sales s");
        $this->db->join("db_customers c", "c.id = s.customer_id", "left");
        $this->db->join("db_store st", "st.id = s.store_id", "left");
        $this->db->group_start();
        $this->db->where("s.sales_code", $sales_code_or_id);
        if (is_numeric($sales_code_or_id)) {
            $this->db->or_where("s.id", intval($sales_code_or_id));
        }
        $this->db->group_end();
        $this->db->limit(1);

        $q_sales = $this->db->get();

        if ($q_sales->num_rows() == 0) {
            // Check db_purchase
            $this->db->select("id, store_id");
            $this->db->from("db_purchase");
            $this->db->group_start();
            $this->db->where("purchase_code", $sales_code_or_id);
            if (is_numeric($sales_code_or_id)) {
                $this->db->or_where("id", intval($sales_code_or_id));
            }
            $this->db->group_end();
            $this->db->limit(1);

            $q_pur = $this->db->get();
            if ($q_pur->num_rows() > 0) {
                $pur = $q_pur->row();
                if (!$this->session->has_userdata('store_id') || empty($this->session->userdata('store_id'))) {
                    $this->session->set_userdata('store_id', $pur->store_id);
                }
                $data = array(
                    'purchase_id' => $pur->id,
                    'page_title'  => 'Purchase Invoice'
                );
                $this->load->view('print-purchase-invoice-3', $data);
                return;
            }

            $data = array(
                'page_title' => 'Invoice Not Found',
                'found'      => false,
                'query_code' => $sales_code_or_id,
                'searched'   => true
            );
            $this->load->view('verify_invoice', $data);
            return;
        }

        $sale = $q_sales->row();
        $sales_id = $sale->id;

        // Ensure session store_id is populated for helper lookups
        if (!$this->session->has_userdata('store_id') || empty($this->session->userdata('store_id'))) {
            $this->session->set_userdata('store_id', $sale->store_id);
        }

        // Query items for this sale
        $this->db->select("si.*, i.item_name, i.custom_barcode, i.description as item_description, COALESCE(NULLIF(si.warranty_days, 0), i.warranty_days, 0) as warranty_days, u.unit_name");
        $this->db->from("db_salesitems si");
        $this->db->join("db_items i", "i.id = si.item_id", "left");
        $this->db->join("db_units u", "u.id = i.unit_id", "left");
        $this->db->where("si.sales_id", $sales_id);
        $this->db->order_by("si.id", "asc");
        $q_items = $this->db->get();

        $items = $q_items->result();

        // Query payments
        $q_payments = $this->db->where("sales_id", $sales_id)->get("db_salespayments");
        $payments = $q_payments->result();

        $data = array(
            'page_title' => 'Official Invoice Verification - ' . $sale->sales_code,
            'found'      => true,
            'searched'   => true,
            'query_code' => $sales_code_or_id,
            'sale'       => $sale,
            'sales_id'   => $sales_id,
            'items'      => $items,
            'payments'   => $payments
        );

        $this->load->view('verify_invoice', $data);
    }

    /**
     * Public view / print of full A4 invoice
     */
    public function print_original($sales_code_or_id = '') {
        $sales_code_or_id = urldecode(trim($sales_code_or_id));
        if (empty($sales_code_or_id)) {
            $sales_code_or_id = trim($this->input->get('code') ?? $this->input->get('inv') ?? '');
        }
        if (empty($sales_code_or_id)) {
            show_404();
        }

        $this->db->select("id, store_id");
        $this->db->from("db_sales");
        $this->db->group_start();
        $this->db->where("sales_code", $sales_code_or_id);
        if (is_numeric($sales_code_or_id)) {
            $this->db->or_where("id", intval($sales_code_or_id));
        }
        $this->db->group_end();
        $this->db->limit(1);

        $q = $this->db->get();
        if ($q->num_rows() == 0) {
            $this->db->select("id, store_id");
            $this->db->from("db_purchase");
            $this->db->group_start();
            $this->db->where("purchase_code", $sales_code_or_id);
            if (is_numeric($sales_code_or_id)) {
                $this->db->or_where("id", intval($sales_code_or_id));
            }
            $this->db->group_end();
            $this->db->limit(1);
            $qp = $this->db->get();
            if ($qp->num_rows() > 0) {
                $row = $qp->row();
                if (!$this->session->has_userdata('store_id') || empty($this->session->userdata('store_id'))) {
                    $this->session->set_userdata('store_id', $row->store_id);
                }
                $data = array(
                    'purchase_id' => $row->id,
                    'page_title'  => 'Purchase Invoice'
                );
                $this->load->view('print-purchase-invoice-3', $data);
                return;
            }
            show_404();
        }

        $row = $q->row();
        $sales_id = $row->id;

        if (!$this->session->has_userdata('store_id') || empty($this->session->userdata('store_id'))) {
            $this->session->set_userdata('store_id', $row->store_id);
        }

        $data = array(
            'sales_id'   => $sales_id,
            'page_title' => 'Sales Invoice'
        );

        $this->load->view('print-sales-invoice-3', $data);
    }

    /**
     * Public view / print of POS Thermal Receipt
     */
    public function pos_receipt($sales_code_or_id = '') {
        $sales_code_or_id = urldecode(trim($sales_code_or_id));
        if (empty($sales_code_or_id)) {
            $sales_code_or_id = trim($this->input->get('code') ?? $this->input->get('inv') ?? '');
        }
        if (empty($sales_code_or_id)) {
            show_404();
        }

        $this->db->select("id, store_id");
        $this->db->from("db_sales");
        $this->db->group_start();
        $this->db->where("sales_code", $sales_code_or_id);
        if (is_numeric($sales_code_or_id)) {
            $this->db->or_where("id", intval($sales_code_or_id));
        }
        $this->db->group_end();
        $this->db->limit(1);

        $q = $this->db->get();
        if ($q->num_rows() == 0) {
            show_404();
        }

        $row = $q->row();
        $sales_id = $row->id;

        if (!$this->session->has_userdata('store_id') || empty($this->session->userdata('store_id'))) {
            $this->session->set_userdata('store_id', $row->store_id);
        }

        $data = array(
            'sales_id'   => $sales_id,
            'page_title' => 'POS Sales Invoice'
        );

        $this->load->view('sal-invoice-pos', $data);
    }
}
