<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscribers_model extends CI_Model {

	//Datatable start
	var $table = 'db_subscription as a';
	var $column_order = array(
								'a.id',
								'a.package_name',
								'a.subscription_date',
								'a.trial_days',
								'a.expire_date',
								'a.max_warehouses',
								'a.max_users',
								'a.max_items',
								'a.max_invoices',
								'a.payment_status',
								'a.payment_type',
								'a.payment_gross',
								'a.package_status',
								'a.store_id'); //set column field database for datatable orderable
	var $column_search = array('a.id',
								'a.package_name',
								'a.subscription_date',
								'a.trial_days',
								'a.expire_date',
								'a.max_warehouses',
								'a.max_users',
								'a.max_items',
								'a.max_invoices',
								'a.payment_status',
								'a.payment_type',
								'a.payment_gross',
								'a.package_status',
								'a.store_id' ); //set column field database for datatable searchable 
	var $order = array('a.id' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
	}

	private function _get_datatables_query()
	{
    /*If account payble checked*/
		$this->db->select($this->column_order);
		$this->db->from($this->table);
		//if not admin
    //if(!is_admin()){
      $this->db->where("a.store_id",$this->input->post('store_id'));
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
	//Datatable end

	//Save Cutomers
	public function save_and_update(){
		//Filtering XSS and html escape from user inputs 
		extract($this->security->xss_clean(html_escape(array_merge($this->data,$_POST,$_GET))));
    $expire_date=system_fromatted_date($expire_date);

    $store_id=get_current_store_id();
    $info = array(
                'store_id'            => $store_id, 
                'subscription_name'         => $subscription_name,
                'description'          => $description,
                'monthly_price'         => $monthly_price,
                'annual_price'             => $annual_price,
                'trial_days'           => $trial_days,
                'expire_date'         => $expire_date,
                'max_warehouses'        => $max_warehouses,
                'max_users'        => $max_users,
                'max_items'        => $max_items,
                'max_invoices'        => $max_invoices,
                /*System Info*/
                
              );

		if($command=='save'){
      $info1 = array(
                'created_date'        => $CUR_DATE,
                'created_time'        => $CUR_TIME,
                'created_by'        => $CUR_USERNAME,
                'system_ip'         => $SYSTEM_IP,
                'system_name'         => $SYSTEM_NAME,
                'status'          => 1,
              );

      $this->db->query("ALTER TABLE db_subscription AUTO_INCREMENT = 1");
      $query1 = $this->db->insert('db_subscription', array_merge($info,$info1));
      $this->session->set_flashdata('success', 'Success!! New Subscription Added Successfully!');
    }
    else{
      $query1 = $this->db->where('id',$q_id)->update('db_subscription', $info);
      $this->session->set_flashdata('success', 'Success!! Subscription Updated Successfully!');
    }
    $this->db->set("expire_date",null)->where("expire_date",'1970-01-01')->update("db_subscription");
		if(!$query1){
		  return "failed";
		}
		return "success";
		
	}

	//Get subscription_details
	public function get_details($id,$data){
		//Validate This subscription already exist or not
		$query=$this->db->query("select * from db_subscription where upper(id)=upper('$id')");
		if($query->num_rows()==0){
			show_404();exit;
		}
		else{
			$query=$query->row();
			$data['q_id']=$query->id;
      $data['store_id']=$query->store_id;
			$data['subscription_name']=$query->subscription_name;
      $data['monthly_price']=$query->monthly_price;
      $data['annual_price']=$query->annual_price;
      $data['trial_days']=$query->trial_days;
      $expire_date = (date("d-m-Y",strtotime($query->expire_date))!='01-01-1970') ? show_date($query->expire_date) : '';
      $data['expire_date']=$expire_date;
      $data['description']=$query->description;
      $data['max_warehouses']=$query->max_warehouses;
      $data['max_users']=$query->max_users;
      $data['max_items']=$query->max_items;
      $data['max_invoices']=$query->max_invoices;
			
			return $data;
		}
	}

  public function update_status($id,$status){
       if (set_status_of_table($id,$status,'db_subscription')){
            echo "success";
        }
        else{
            echo "failed";
        }
  }

	public function authorize_subscription($id){
		$sub = $this->db->where('id', $id)->get('db_subscription')->row();
		if(empty($sub)){
			return "Subscription record not found";
		}
		$store_id = $sub->store_id;
		$today = date('Y-m-d');
		
		if(!empty($sub->expire_date) && $sub->expire_date != '1970-01-01' && $sub->expire_date >= $today){
			$expire_date = $sub->expire_date;
		} else {
			if(strtolower($sub->payment_type) == 'annual' || $sub->package_count >= 12){
				$expire_date = date('Y-m-d', strtotime('+1 year'));
			} else {
				$months = (!empty($sub->package_count) && $sub->package_count > 0) ? $sub->package_count : 1;
				$expire_date = date('Y-m-d', strtotime('+' . $months . ' month'));
			}
		}
		
		$update_data = array(
			'payment_status' => 'Paid',
			'package_status' => 'Active',
			'subscription_date' => $today,
			'expire_date' => $expire_date
		);
		$this->db->where('id', $id)->update('db_subscription', $update_data);
		
		// Update store's current subscription & ensure store is active
		$store_curr = $this->db->where('id', $store_id)->get('db_store')->row();
		$store_update = array(
			'current_subscriptionlist_id' => $id,
			'status' => 1
		);
		if(!empty($store_curr->auto_lock_day) && $store_curr->auto_lock_day > 0){
			$target_month = date('Y-m', strtotime('+1 month'));
			$max_day = intval(date('t', strtotime($target_month . '-01')));
			$day_to_use = min($store_curr->auto_lock_day, $max_day);
			$store_update['auto_lock_date'] = $target_month . '-' . sprintf('%02d', $day_to_use);
		}
		$this->db->where('id', $store_id)->update('db_store', $store_update);
		
		return "success";
	}

	public function unsubscribe_subscription($id){
		$sub = $this->db->where('id', $id)->get('db_subscription')->row();
		if(empty($sub)){
			return "Subscription record not found";
		}
		$store_id = $sub->store_id;

		$update_data = array(
			'payment_status' => 'Unsubscribed',
			'package_status' => 'Unsubscribed'
		);
		$this->db->where('id', $id)->update('db_subscription', $update_data);
		$this->db->where('id', $store_id)->update('db_store', array('status' => 0));

		return "success";
	}
	
	public function delete_subscription_from_table($ids){
      $this->db->trans_begin();
          #---------------------------------
          $id_array = explode(",", $ids);
          $stores = $this->db->select("id, current_subscriptionlist_id")->where_in("current_subscriptionlist_id", $id_array)->get("db_store")->result();
          if(!empty($stores)){
              foreach($stores as $st){
                  $prev_sub = $this->db->select("id")->where("store_id", $st->id)->where_not_in("id", $id_array)->order_by("id", "desc")->get("db_subscription")->row();
                  $new_sub_id = (!empty($prev_sub)) ? $prev_sub->id : 0;
                  $this->db->where("id", $st->id)->update("db_store", array("current_subscriptionlist_id" => $new_sub_id));
              }
          }

          $this->db->where("id in ($ids)");
          //if not admin
          if(!is_admin()){
            $this->db->where("store_id",get_current_store_id());
          }

          $query2=$this->db->delete("db_subscription");
          #---------------------------------

          if ($query2){
            $this->db->trans_commit();
              return "success";
          }
          else{
              return "failed";
          } 
	}

	

}
