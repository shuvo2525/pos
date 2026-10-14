<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Updates_model extends CI_Model {

	public $app_version = null;
	public $db_version = null;
	public $version_check = array();

	public function __construct()
	{
		parent::__construct();
		//Do your magic here

		//$this->app_version = (float)app_version();

		//$this->version_check =array(2.8);

		$this->db_version = $this->get_current_version_of_db();

	}

	public function get_current_version_of_db(){

      return $this->db->select('version')->from('db_sitesettings')->get()->row()->version;

    }

	public function index()
	{	
		if($this->db_version <=2.8){
			
			$result = $this->db->query("SHOW COLUMNS FROM `db_store` LIKE 'qty_decimals'");

            if(!$result->num_rows()){
            	//Update for 2.8 version only
				$q1 = $this->db->query("ALTER TABLE `db_store` ADD COLUMN `qty_decimals` INT(5) DEFAULT 2 NULL");if(!$q1){ echo "failed"; exit();}
            }
			

		}

		// Ensure plan_type column exists in db_package
		$check_col = $this->db->query("SHOW COLUMNS FROM `db_package` LIKE 'plan_type'");
		if(!$check_col->num_rows()){
			$this->db->query("ALTER TABLE `db_package` ADD COLUMN `plan_type` VARCHAR(100) DEFAULT 'Both' NULL");
		} else {
			$this->db->query("UPDATE `db_package` SET `plan_type` = 'Both' WHERE `plan_type` IS NULL OR `plan_type` = ''");
		}

		// Ensure setup_charge and package_charge exist in db_subscription
		$check_setup = $this->db->query("SHOW COLUMNS FROM `db_subscription` LIKE 'setup_charge'");
		if(!$check_setup->num_rows()){
			$this->db->query("ALTER TABLE `db_subscription` ADD COLUMN `setup_charge` DOUBLE(10,2) DEFAULT 0.00 AFTER `payment_gross`");
		}
		$check_pkg = $this->db->query("SHOW COLUMNS FROM `db_subscription` LIKE 'package_charge'");
		if(!$check_pkg->num_rows()){
			$this->db->query("ALTER TABLE `db_subscription` ADD COLUMN `package_charge` DOUBLE(10,2) DEFAULT 0.00 AFTER `payment_gross`");
		}

		// Ensure auto_lock columns exist in db_store
		$check_auto_lock_day = $this->db->query("SHOW COLUMNS FROM `db_store` LIKE 'auto_lock_day'");
		if(!$check_auto_lock_day->num_rows()){
			$this->db->query("ALTER TABLE `db_store` ADD COLUMN `auto_lock_day` INT(2) DEFAULT 0 NULL AFTER `status`");
		}
		$check_auto_lock_date = $this->db->query("SHOW COLUMNS FROM `db_store` LIKE 'auto_lock_date'");
		if(!$check_auto_lock_date->num_rows()){
			$this->db->query("ALTER TABLE `db_store` ADD COLUMN `auto_lock_date` DATE DEFAULT NULL NULL AFTER `auto_lock_day`");
		}
		$check_auto_lock_note = $this->db->query("SHOW COLUMNS FROM `db_store` LIKE 'auto_lock_note'");
		if(!$check_auto_lock_note->num_rows()){
			$this->db->query("ALTER TABLE `db_store` ADD COLUMN `auto_lock_note` VARCHAR(255) DEFAULT NULL NULL AFTER `auto_lock_date`");
		}

		// Ensure sidebar submenu customizer columns exist in db_sitesettings and db_store
		$check_sb_sub1 = $this->db->query("SHOW COLUMNS FROM `db_sitesettings` LIKE 'sidebar_submenu_color'");
		if(!$check_sb_sub1->num_rows()){
			$this->db->query("ALTER TABLE `db_sitesettings` ADD COLUMN `sidebar_submenu_color` VARCHAR(20) DEFAULT NULL NULL AFTER `sidebar_active_color`");
		}
		$check_sb_subh1 = $this->db->query("SHOW COLUMNS FROM `db_sitesettings` LIKE 'sidebar_submenu_hover_color'");
		if(!$check_sb_subh1->num_rows()){
			$this->db->query("ALTER TABLE `db_sitesettings` ADD COLUMN `sidebar_submenu_hover_color` VARCHAR(20) DEFAULT NULL NULL AFTER `sidebar_submenu_color`");
		}
		$check_sb_sub2 = $this->db->query("SHOW COLUMNS FROM `db_store` LIKE 'sidebar_submenu_color'");
		if(!$check_sb_sub2->num_rows()){
			$this->db->query("ALTER TABLE `db_store` ADD COLUMN `sidebar_submenu_color` VARCHAR(20) DEFAULT NULL NULL AFTER `sidebar_active_color`");
		}
		$check_sb_subh2 = $this->db->query("SHOW COLUMNS FROM `db_store` LIKE 'sidebar_submenu_hover_color'");
		if(!$check_sb_subh2->num_rows()){
			$this->db->query("ALTER TABLE `db_store` ADD COLUMN `sidebar_submenu_hover_color` VARCHAR(20) DEFAULT NULL NULL AFTER `sidebar_submenu_color`");
		}

		// Ensure default packages exist (100 to 5000 Tk, Free, Trial)
		$default_packages = array(
			array(
				'package_type'   => 'Free',
				'package_name'   => 'Free Plan',
				'description'    => 'Free plan for new businesses',
				'monthly_price'  => 0.00,
				'annual_price'   => 0.00,
				'trial_days'     => 30,
				'max_warehouses' => 1,
				'max_users'      => 1,
				'max_items'      => 50,
				'max_invoices'   => 50,
				'plan_type'      => 'Both',
				'status'         => 1,
			),
			array(
				'package_type'   => 'Trial',
				'package_name'   => 'Trial 14 Days',
				'description'    => '14-Day Full Access Free Trial',
				'monthly_price'  => 0.00,
				'annual_price'   => 0.00,
				'trial_days'     => 14,
				'max_warehouses' => 2,
				'max_users'      => 3,
				'max_items'      => 200,
				'max_invoices'   => 200,
				'plan_type'      => 'Both',
				'status'         => 1,
			),
			array(
				'package_type'   => 'Paid',
				'package_name'   => 'Starter 100',
				'description'    => 'Monthly 100 Tk, Annual 1200 Tk (12x)',
				'monthly_price'  => 100.00,
				'annual_price'   => 1200.00,
				'trial_days'     => 0,
				'max_warehouses' => 1,
				'max_users'      => 2,
				'max_items'      => 100,
				'max_invoices'   => 100,
				'plan_type'      => 'Both',
				'status'         => 1,
			),
			array(
				'package_type'   => 'Paid',
				'package_name'   => 'Basic 200',
				'description'    => 'Monthly 200 Tk, Annual 2400 Tk (12x)',
				'monthly_price'  => 200.00,
				'annual_price'   => 2400.00,
				'trial_days'     => 0,
				'max_warehouses' => 2,
				'max_users'      => 3,
				'max_items'      => 300,
				'max_invoices'   => 300,
				'plan_type'      => 'Both',
				'status'         => 1,
			),
			array(
				'package_type'   => 'Paid',
				'package_name'   => 'Standard 300',
				'description'    => 'Monthly 300 Tk, Annual 3600 Tk (12x)',
				'monthly_price'  => 300.00,
				'annual_price'   => 3600.00,
				'trial_days'     => 0,
				'max_warehouses' => 3,
				'max_users'      => 5,
				'max_items'      => 500,
				'max_invoices'   => 500,
				'plan_type'      => 'Both',
				'status'         => 1,
			),
			array(
				'package_type'   => 'Paid',
				'package_name'   => 'Business 500',
				'description'    => 'Monthly 500 Tk, Annual 6000 Tk (12x)',
				'monthly_price'  => 500.00,
				'annual_price'   => 6000.00,
				'trial_days'     => 0,
				'max_warehouses' => 5,
				'max_users'      => 10,
				'max_items'      => 1000,
				'max_invoices'   => 1000,
				'plan_type'      => 'Both',
				'status'         => 1,
			),
			array(
				'package_type'   => 'Paid',
				'package_name'   => 'Professional 1000',
				'description'    => 'Monthly 1000 Tk, Annual 12000 Tk (12x)',
				'monthly_price'  => 1000.00,
				'annual_price'   => 12000.00,
				'trial_days'     => 0,
				'max_warehouses' => 10,
				'max_users'      => 20,
				'max_items'      => 5000,
				'max_invoices'   => 5000,
				'plan_type'      => 'Both',
				'status'         => 1,
			),
			array(
				'package_type'   => 'Paid',
				'package_name'   => 'Advanced 1500',
				'description'    => 'Monthly 1500 Tk, Annual 18000 Tk (12x)',
				'monthly_price'  => 1500.00,
				'annual_price'   => 18000.00,
				'trial_days'     => 0,
				'max_warehouses' => 20,
				'max_users'      => 30,
				'max_items'      => 10000,
				'max_invoices'   => 10000,
				'plan_type'      => 'Both',
				'status'         => 1,
			),
			array(
				'package_type'   => 'Paid',
				'package_name'   => 'Premium 2000',
				'description'    => 'Monthly 2000 Tk, Annual 24000 Tk (12x)',
				'monthly_price'  => 2000.00,
				'annual_price'   => 24000.00,
				'trial_days'     => 0,
				'max_warehouses' => 50,
				'max_users'      => 50,
				'max_items'      => 25000,
				'max_invoices'   => 25000,
				'plan_type'      => 'Both',
				'status'         => 1,
			),
			array(
				'package_type'   => 'Paid',
				'package_name'   => 'Enterprise 5000',
				'description'    => 'Monthly 5000 Tk, Annual 60000 Tk (12x) - Unlimited',
				'monthly_price'  => 5000.00,
				'annual_price'   => 60000.00,
				'trial_days'     => 0,
				'max_warehouses' => -1,
				'max_users'      => -1,
				'max_items'      => -1,
				'max_invoices'   => -1,
				'plan_type'      => 'Both',
				'status'         => 1,
			),
		);

		foreach ($default_packages as $pkg) {
			$exists = $this->db->where('package_name', $pkg['package_name'])->count_all_results('db_package');
			if (!$exists) {
				$pkg['store_id']     = 1;
				$pkg['created_date'] = date('Y-m-d');
				$pkg['created_time'] = date('h:i:s a');
				$pkg['created_by']   = 'admin';
				$pkg['system_ip']    = '127.0.0.1';
				$pkg['system_name']  = 'localhost';
				$this->db->insert('db_package', $pkg);
			}
		}

		// Ensure db_employees table exists
		$check_emp = $this->db->query("SHOW TABLES LIKE 'db_employees'");
		if(!$check_emp->num_rows()){
			$this->db->query("CREATE TABLE IF NOT EXISTS `db_employees` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `store_id` int(11) DEFAULT 1,
			  `employee_code` varchar(50) DEFAULT NULL,
			  `first_name` varchar(100) DEFAULT NULL,
			  `last_name` varchar(100) DEFAULT NULL,
			  `email` varchar(150) DEFAULT NULL,
			  `mobile` varchar(30) DEFAULT NULL,
			  `phone` varchar(30) DEFAULT NULL,
			  `designation` varchar(100) DEFAULT NULL,
			  `department` varchar(100) DEFAULT NULL,
			  `dob` date DEFAULT NULL,
			  `gender` varchar(20) DEFAULT NULL,
			  `marital_status` varchar(30) DEFAULT NULL,
			  `blood_group` varchar(10) DEFAULT NULL,
			  `joining_date` date DEFAULT NULL,
			  `monthly_salary` decimal(15,2) DEFAULT '0.00',
			  `photo` text DEFAULT NULL,
			  `nid_number` varchar(50) DEFAULT NULL,
			  `nid_photo` text DEFAULT NULL,
			  `present_address` text DEFAULT NULL,
			  `permanent_address` text DEFAULT NULL,
			  `emergency_contact_name` varchar(100) DEFAULT NULL,
			  `emergency_contact_relation` varchar(50) DEFAULT NULL,
			  `emergency_contact_mobile` varchar(30) DEFAULT NULL,
			  `bank_name` varchar(100) DEFAULT NULL,
			  `bank_account_holder` varchar(100) DEFAULT NULL,
			  `bank_account_number` varchar(50) DEFAULT NULL,
			  `bank_branch` varchar(100) DEFAULT NULL,
			  `bank_routing_code` varchar(50) DEFAULT NULL,
			  `cv_file` text DEFAULT NULL,
			  `education_details` text DEFAULT NULL,
			  `experience_details` text DEFAULT NULL,
			  `skills` text DEFAULT NULL,
			  `notes` text DEFAULT NULL,
			  `status` int(1) DEFAULT 1,
			  `created_date` date DEFAULT NULL,
			  `created_time` varchar(30) DEFAULT NULL,
			  `created_by` varchar(100) DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  KEY `idx_store_id` (`store_id`),
			  KEY `idx_employee_code` (`employee_code`),
			  KEY `idx_status` (`status`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8");
		}

		// Ensure db_warranty table exists
		$check_war = $this->db->query("SHOW TABLES LIKE 'db_warranty'");
		if(!$check_war->num_rows()){
			$this->db->query("CREATE TABLE IF NOT EXISTS `db_warranty` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `store_id` int(11) NOT NULL DEFAULT 1,
			  `warranty_code` varchar(50) NOT NULL,
			  `customer_id` int(11) NOT NULL,
			  `sales_id` int(11) DEFAULT 0,
			  `sales_code` varchar(50) DEFAULT NULL,
			  `item_id` int(11) DEFAULT NULL,
			  `item_name` varchar(255) NOT NULL,
			  `serial_no` varchar(100) DEFAULT NULL,
			  `purchase_date` date DEFAULT NULL,
			  `warranty_period_days` int(11) DEFAULT 0,
			  `warranty_expiry_date` date DEFAULT NULL,
			  `problem_description` text DEFAULT NULL,
			  `accessories_received` text DEFAULT NULL,
			  `product_condition` text DEFAULT NULL,
			  `claim_date` date DEFAULT NULL,
			  `expected_delivery_date` date DEFAULT NULL,
			  `delivery_date` date DEFAULT NULL,
			  `delivered_to` varchar(255) DEFAULT NULL,
			  `account_id` int(11) DEFAULT 0,
			  `status` varchar(50) DEFAULT 'Received',
			  `technician_notes` text DEFAULT NULL,
			  `action_taken` text DEFAULT NULL,
			  `service_charge` double(20,4) DEFAULT 0.0000,
			  `parts_charge` double(20,4) DEFAULT 0.0000,
			  `total_charge` double(20,4) DEFAULT 0.0000,
			  `payment_type` varchar(50) DEFAULT NULL,
			  `created_by` varchar(100) DEFAULT NULL,
			  `created_date` date DEFAULT NULL,
			  `created_time` varchar(50) DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  KEY `store_id` (`store_id`),
			  KEY `customer_id` (`customer_id`),
			  KEY `warranty_code` (`warranty_code`),
			  KEY `serial_no` (`serial_no`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
		}

		// Ensure db_emi table exists
		$check_emi = $this->db->query("SHOW TABLES LIKE 'db_emi'");
		if(!$check_emi->num_rows()){
			$this->db->query("CREATE TABLE IF NOT EXISTS `db_emi` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `store_id` int(11) NOT NULL DEFAULT 1,
			  `emi_code` varchar(50) NOT NULL,
			  `customer_id` int(11) NOT NULL,
			  `sales_id` int(11) DEFAULT 0,
			  `item_details` text NOT NULL,
			  `total_amount` double(20,4) NOT NULL DEFAULT 0.0000,
			  `down_payment` double(20,4) NOT NULL DEFAULT 0.0000,
			  `financed_amount` double(20,4) NOT NULL DEFAULT 0.0000,
			  `interest_rate` double(10,2) NOT NULL DEFAULT 0.00,
			  `interest_amount` double(20,4) NOT NULL DEFAULT 0.0000,
			  `total_payable` double(20,4) NOT NULL DEFAULT 0.0000,
			  `emi_frequency` varchar(20) NOT NULL DEFAULT 'Monthly',
			  `total_installments` int(11) NOT NULL DEFAULT 0,
			  `installment_amount` double(20,4) NOT NULL DEFAULT 0.0000,
			  `paid_amount` double(20,4) NOT NULL DEFAULT 0.0000,
			  `due_amount` double(20,4) NOT NULL DEFAULT 0.0000,
			  `start_date` date NOT NULL,
			  `end_date` date DEFAULT NULL,
			  `status` varchar(50) NOT NULL DEFAULT 'Active',
			  `notes` text DEFAULT NULL,
			  `created_by` varchar(100) DEFAULT NULL,
			  `created_date` date DEFAULT NULL,
			  `created_time` varchar(50) DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  KEY `store_id` (`store_id`),
			  KEY `customer_id` (`customer_id`),
			  KEY `emi_code` (`emi_code`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
		}

		// Ensure db_emi_installments table exists
		$check_inst = $this->db->query("SHOW TABLES LIKE 'db_emi_installments'");
		if(!$check_inst->num_rows()){
			$this->db->query("CREATE TABLE IF NOT EXISTS `db_emi_installments` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `emi_id` int(11) NOT NULL,
			  `store_id` int(11) NOT NULL DEFAULT 1,
			  `installment_no` int(11) NOT NULL,
			  `due_date` date NOT NULL,
			  `amount` double(20,4) NOT NULL DEFAULT 0.0000,
			  `paid_amount` double(20,4) NOT NULL DEFAULT 0.0000,
			  `payment_date` date DEFAULT NULL,
			  `payment_type` varchar(50) DEFAULT NULL,
			  `payment_note` text DEFAULT NULL,
			  `status` varchar(50) NOT NULL DEFAULT 'Pending',
			  PRIMARY KEY (`id`),
			  KEY `emi_id` (`emi_id`),
			  KEY `store_id` (`store_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
		}

		// Ensure db_emi_payments table exists
		$check_pmt = $this->db->query("SHOW TABLES LIKE 'db_emi_payments'");
		if(!$check_pmt->num_rows()){
			$this->db->query("CREATE TABLE IF NOT EXISTS `db_emi_payments` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `emi_id` int(11) NOT NULL,
			  `installment_id` int(11) NOT NULL DEFAULT 0,
			  `store_id` int(11) NOT NULL DEFAULT 1,
			  `receipt_no` varchar(50) NOT NULL,
			  `payment_date` date NOT NULL,
			  `payment_amount` double(20,4) NOT NULL DEFAULT 0.0000,
			  `payment_type` varchar(50) NOT NULL DEFAULT 'Cash',
			  `account_id` int(11) DEFAULT 0,
			  `payment_note` text DEFAULT NULL,
			  `created_by` varchar(100) DEFAULT NULL,
			  `created_date` date DEFAULT NULL,
			  `created_time` varchar(50) DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  KEY `emi_id` (`emi_id`),
			  KEY `store_id` (`store_id`),
			  KEY `receipt_no` (`receipt_no`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
		}

		// Ensure warranty_days column exists in db_items
		$check_wday = $this->db->query("SHOW COLUMNS FROM `db_items` LIKE 'warranty_days'");
		if(!$check_wday->num_rows()){
			$this->db->query("ALTER TABLE `db_items` ADD COLUMN `warranty_days` INT(11) DEFAULT 0 NULL");
		}

		// Ensure item_serials column exists in db_items
		$check_iserials = $this->db->query("SHOW COLUMNS FROM `db_items` LIKE 'item_serials'");
		if(!$check_iserials->num_rows()){
			$this->db->query("ALTER TABLE `db_items` ADD COLUMN `item_serials` TEXT DEFAULT NULL");
		}

		// Ensure db_item_serials table exists
		$check_serials_tbl = $this->db->query("SHOW TABLES LIKE 'db_item_serials'");
		if(!$check_serials_tbl->num_rows()){
			$this->db->query("CREATE TABLE IF NOT EXISTS `db_item_serials` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `store_id` int(11) NOT NULL DEFAULT 1,
			  `item_id` int(11) NOT NULL,
			  `serial_code` varchar(100) NOT NULL,
			  `status` varchar(20) NOT NULL DEFAULT 'Available',
			  `sales_id` int(11) DEFAULT 0,
			  `sales_item_id` int(11) DEFAULT 0,
			  `created_date` date DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  KEY `item_store` (`store_id`, `item_id`),
			  KEY `serial_code` (`serial_code`),
			  KEY `status` (`status`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
		}

		// Ensure permissions for warranty and emi
		$perms = array(
			'warranty_view', 'warranty_add', 'warranty_edit', 'warranty_delete',
			'emi_view', 'emi_add', 'emi_payment', 'emi_delete'
		);
		$roles = $this->db->query("SELECT id, store_id FROM db_roles WHERE id IN (1, 2, 32)")->result();
		foreach ($roles as $r) {
			foreach ($perms as $p) {
				$chk = $this->db->where('role_id', $r->id)->where('store_id', $r->store_id)->where('permissions', $p)->count_all_results('db_permissions');
				if (!$chk) {
					$this->db->insert('db_permissions', array(
						'role_id'     => $r->id,
						'store_id'    => $r->store_id,
						'permissions' => $p
					));
				}
			}
		}

		// Ensure warranty_days column in db_salesitems
		$col_check = $this->db->query("SHOW COLUMNS FROM `db_salesitems` LIKE 'warranty_days'");
		if (!$col_check->num_rows()) {
			$this->db->query("ALTER TABLE `db_salesitems` ADD COLUMN `warranty_days` INT(11) DEFAULT 0 AFTER `description`");
			$this->db->query("UPDATE db_salesitems si JOIN db_items i ON i.id = si.item_id SET si.warranty_days = i.warranty_days");
		}
	}

}
