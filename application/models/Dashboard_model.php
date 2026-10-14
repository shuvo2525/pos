<?php

class Dashboard_model extends CI_Model
{

	//Datatable start
		var $table = 'db_items a';
		var $column_order = array(
									'a.item_code',
									'a.item_name',
									'b.category_name',
									'c.brand_name',
									'a.stock'
									); //set column field database for datatable orderable
		var $column_search = array( 
									'a.item_code',
									'a.item_name',
									'b.category_name',
									'c.brand_name',
									'a.stock'
									); //set column field database for datatable searchable 
		var $order = array('a.id' => 'desc'); // default order 

	
		
		private function _get_datatables_query()
		{	
			$this->db->select($this->column_order);
			$this->db->from($this->table);
			$this->db->where('a.store_id',get_current_store_id());
	        $this->db->where('(a.stock<=a.alert_qty or a.stock is null)');
	        $this->db->where('a.service_bit',0);
	        
	        $this->db->where('a.status=1');
	        $this->db->join('db_category b','b.id=a.category_id','left');
	        $this->db->join('db_brands c','c.id=a.brand_id','left');

	     

			//	echo $this->db->get_compiled_select();exit();
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

	public function get_subscription_chart()
	{
		$sub_chart = array();
		for ($i=6; $i >= 0; $i--) {
			//Date
            $sub_chart['date'][$i] = date("Y-m-d",strtotime("-".$i." months"));
            $sub_chart['sub_year'][$i] = date("Y",strtotime($sub_chart['date'][$i]));
            $sub_chart['sub_month'][$i] = date("M",strtotime($sub_chart['date'][$i]));

            $this->db->select("count(*) as tot_subscribes");
            $this->db->from("db_subscription");
            $this->db->where("month(subscription_date)",date("m",strtotime($sub_chart['date'][$i])));
            $q3=$this->db->get();
            $sub_chart['tot_subscribes'][$i] = $q3->row()->tot_subscribes;
        }
        return $sub_chart;
	}

	public function get_pie_chart($value='')
	{
		
            $this->db->where("c.store_id",get_current_store_id());
            /*if(!is_admin() && !is_store_admin()){
              $this->db->where("c.created_by",$this->session->userdata('inv_username'));  
            }*/
            $this->db->select("COALESCE(SUM(b.sales_qty),0) AS sales_qty, a.item_name");
            $this->db->from("db_items AS a, db_salesitems AS b ,db_sales AS c");
            $this->db->where("a.id=b.`item_id` AND b.sales_id=c.`id` AND c.`sales_status`='Final'");
            $this->db->group_by("a.id");
            $this->db->limit("10");
            $this->db->order_by("sales_qty","asc");

            $q3=$this->db->get();
            $pie_chart=array();
            $i=0;
            if($q3->num_rows() >0){
              foreach($q3->result() as $res3){
                  if($res3->sales_qty>0){
                  	++$i;
                  	$pie_chart['tranding_item'][$i]['name'] = $res3->item_name;
                  	$pie_chart['tranding_item'][$i]['sales_qty'] = $res3->sales_qty;
                  }
              }
            }
            $pie_chart['tranding_item']['tot_rec'] = $i;
            return $pie_chart;
	}
	public function get_bar_chart(){
		$bar_chart=array();
          for ($i=6; $i >= 0; $i--) { 

              //Date
              $bar_chart['date'][$i] = date("Y-m-d",strtotime("-".$i." months"));
              $bar_chart['month'][$i] = date("M",strtotime($bar_chart['date'][$i])).",".date("Y",strtotime($bar_chart['date'][$i]));

              //Find purchase total
              $this->db->where("store_id",get_current_store_id());
              if(!is_admin() && !is_store_admin()){
                $this->db->where("created_by",$this->session->userdata('inv_username'));  
              }
              $this->db->select("COALESCE(SUM(grand_total),0) AS pur_total");
              $this->db->from("db_purchase");
              $this->db->where("purchase_status='Received'");
              $this->db->where("month(purchase_date)",date("m",strtotime($bar_chart['date'][$i])));
              $this->db->where("year(purchase_date)",date("Y",strtotime($bar_chart['date'][$i])));
              $q1=$this->db->get()->row();
              $this->db->get_compiled_select();
              $bar_chart['purchase'][$i]=$q1->pur_total;
              
              //Find sales total
              $this->db->where("store_id",get_current_store_id());
              if(!is_admin() && !is_store_admin()){
                $this->db->where("created_by",$this->session->userdata('inv_username'));  
              }
              $this->db->select("COALESCE(SUM(grand_total),0) AS sal_total");
              $this->db->from("db_sales");
              $this->db->where("sales_status='Final'");
              $this->db->where("month(sales_date)",date("m",strtotime($bar_chart['date'][$i])));
              $this->db->where("year(sales_date)",date("Y",strtotime($bar_chart['date'][$i])));
              $q1=$this->db->get()->row();
              $bar_chart['sales'][$i]=$q1->sal_total;

              //Find expense total
              $this->db->where("store_id",get_current_store_id());
              if(!is_admin() && !is_store_admin()){
                $this->db->where("created_by",$this->session->userdata('inv_username'));  
              }
              $this->db->select("COALESCE(SUM(expense_amt),0) AS expense_amt");
              $this->db->from("db_expense");
              $this->db->where("month(expense_date)",date("m",strtotime($bar_chart['date'][$i])));
              $this->db->where("year(expense_date)",date("Y",strtotime($bar_chart['date'][$i])));
              $q1=$this->db->get()->row();
              $bar_chart['expense'][$i]=$q1->expense_amt;
          }
          return $bar_chart;
	}
	public function get_by_date($table_date)
	{
		$dates = $this->input->post('dates');
		if($dates=='Today'){
      		//$this->db->where("$table_date > DATE_SUB(NOW(), INTERVAL 1 DAY)");
      		$this->db->where("$table_date",date("Y-m-d"));
      	}
      	if($dates=='Weekly'){
      		$this->db->where("$table_date > DATE_SUB(NOW(), INTERVAL 1 WEEK)");
      	}
      	if($dates=='Monthly'){
      		$this->db->where("$table_date > DATE_SUB(NOW(), INTERVAL 1 MONTH)");
      	}
      	if($dates=='Yearly'){
      		$this->db->where("$table_date > DATE_SUB(NOW(), INTERVAL 1 YEAR)");
      	}
	}
	public function breadboard_values()
	{	
		$dates = $this->input->post('dates');
		//$store_id=$this->input->post('store_id');
		$CI =& get_instance();
		$info=array();

		// If store is locked by Super Admin or subscription is expired, do not expose sales/purchase metrics
		if(!is_admin() && is_store_locked_or_expired()){
			return array(
				'tot_sup' => 0,
				'tot_pro' => 0,
				'tot_cust' => 0,
				'tot_pur' => '0.00',
				'tot_sal' => '0.00',
				'tot_sal_grand_total' => '0.00',
				'sal_return_total' => '0.00',
				'pur_return_total' => '0.00',
				'tot_exp' => '0.00'
			);
		}

		///Find total suppliers
		/*if(store_module() && is_admin()){if(!empty($store_id)){ 
					$this->db->where("store_id",$store_id);}
				}else{ */
					$this->db->where("store_id",get_current_store_id());	
			/*}*/
		$this->db->select("coalesce(count(*),0) as tot_sup");
		$this->db->from("db_suppliers");
		$this->db->where("status=1");
		
		$tot_sup=$this->db->get()->row()->tot_sup;	
		$info['tot_sup']=$tot_sup;

		///Find total Products
		/*if(store_module() && is_admin()){if(!empty($store_id)){ 
					$this->db->where("store_id",$store_id);}
				}else{ */
					$this->db->where("store_id",get_current_store_id());	
			/*}*/
		$this->db->select("coalesce(count(*),0) as tot_pro");
		$this->db->from("db_items");
		$this->db->where("status=1");
		$tot_pro=$this->db->get()->row()->tot_pro;	
		$info['tot_pro']=$tot_pro;

		//Total Customers
		/*if(store_module() && is_admin()){if(!empty($store_id)){ 
					$this->db->where("store_id",$store_id);}
				}else{ */
					$this->db->where("store_id",get_current_store_id());	
			/*}*/
		$this->db->select("coalesce(count(*),0) as tot_cust");
		$this->db->from("db_customers");
		$this->db->where("status=1");
		$tot_cust=$this->db->get()->row()->tot_cust;	
		$info['tot_cust']=$tot_cust;

  		//Total Purchases Active
  		/*if(store_module() && is_admin()){if(!empty($store_id)){ 
					$this->db->where("store_id",$store_id);}
				}else{ */
					$this->db->where("store_id",get_current_store_id());	
			/*}*/
		if(!is_admin() && !is_store_admin()){
			$this->db->where("created_by",$this->session->userdata('inv_username'));	
		}
      	$this->get_by_date('purchase_date');//DATES FUNCTION
		$this->db->select("coalesce(count(*),0) as tot_pur");
		$this->db->from("db_purchase");
		$this->db->where("purchase_status='Received'");
		//echo $this->db->get_compiled_select();exit();
		$tot_pur=$this->db->get()->row()->tot_pur;	
		$info['tot_pur']=$tot_pur;

  		//Total SAles Active
  		/*if(store_module() && is_admin()){if(!empty($store_id)){ 
					$this->db->where("store_id",$store_id);}
				}else{ */
					$this->db->where("store_id",get_current_store_id());	
			/*}*/
		if(!is_admin() && !is_store_admin()){
			$this->db->where("created_by",$this->session->userdata('inv_username'));	
		}
		$this->get_by_date('sales_date');//DATES FUNCTION
		$this->db->select("coalesce(count(*),0) as tot_sal");
		$this->db->from("db_sales");
		$this->db->where("`sales_status`= 'Final'");
		$tot_sal=$this->db->get()->row()->tot_sal;
		$info['tot_sal']=$tot_sal;


		//Total SAles return amount
		/*if(store_module() && is_admin()){if(!empty($store_id)){ 
					$this->db->where("store_id",$store_id);}
				}else{ */
					$this->db->where("store_id",get_current_store_id());	
			/*}*/
		if(!is_admin() && !is_store_admin()){
			$this->db->where("created_by",$this->session->userdata('inv_username'));	
		}
		$this->get_by_date('return_date');//DATES FUNCTION
		$this->db->select("COALESCE(sum(grand_total),0) AS tot_sal_ret_grand_total");
		$this->db->from("db_salesreturn");
		$tot_sal_ret_grand_total=$this->db->get()->row()->tot_sal_ret_grand_total;
		$info['tot_sal_ret_grand_total']=$CI->currency(kmb($tot_sal_ret_grand_total));

		//Total SAles amount
		/*if(store_module() && is_admin()){if(!empty($store_id)){ 
					$this->db->where("store_id",$store_id);}
				}else{ */
					$this->db->where("store_id",get_current_store_id());	
			/*}*/
		if(!is_admin() && !is_store_admin()){
			$this->db->where("created_by",$this->session->userdata('inv_username'));	
		}
		$this->get_by_date('sales_date');//DATES FUNCTION
		$this->db->select("COALESCE(sum(grand_total),0) AS tot_sal_grand_total");
		$this->db->from("db_sales");
		$this->db->where("`sales_status`= 'Final'");
		$tot_sal_grand_total=$this->db->get()->row()->tot_sal_grand_total;
		$info['tot_sal_grand_total']=$CI->currency(kmb($tot_sal_grand_total-$tot_sal_ret_grand_total));

		


		//Total expense amount
		/*if(store_module() && is_admin()){if(!empty($store_id)){ 
					$this->db->where("store_id",$store_id);}
				}else{ */
					$this->db->where("store_id",get_current_store_id());	
			/*}*/
		if(!is_admin() && !is_store_admin()){
			$this->db->where("created_by",$this->session->userdata('inv_username'));	
		}
		$this->get_by_date('expense_date');//DATES FUNCTION
		$this->db->select("COALESCE(sum(expense_amt),0) AS tot_exp");
		$this->db->from("db_expense");
		$tot_exp=$this->db->get()->row()->tot_exp;
		$info['tot_exp']=$CI->currency(kmb($tot_exp,2));

		//Total SAles Due
		/*if(store_module() && is_admin()){if(!empty($store_id)){ 
					$this->db->where("store_id",$store_id);}
				}else{ */
					$this->db->where("store_id",get_current_store_id());	
			/*}*/
		if(!is_admin() && !is_store_admin()){
			$this->db->where("created_by",$this->session->userdata('inv_username'));	
		}
		$this->get_by_date('sales_date');//DATES FUNCTION
		$this->db->select("(COALESCE(sum(grand_total),0)-COALESCE(sum(paid_amount),0)) as sales_due");
		$this->db->from("db_sales");
		$this->db->where("`sales_status`= 'Final'");
		$sales_due=$this->db->get()->row()->sales_due;
		$info['sales_due']=$CI->currency(kmb($sales_due));

		//Total Purchase  Due
		/*if(store_module() && is_admin()){if(!empty($store_id)){ 
					$this->db->where("store_id",$store_id);}
				}else{ */
					$this->db->where("store_id",get_current_store_id());	
			/*}*/
		if(!is_admin() && !is_store_admin()){
			$this->db->where("created_by",$this->session->userdata('inv_username'));	
		}
		$this->get_by_date('purchase_date');//DATES FUNCTION
		$this->db->select("(COALESCE(sum(grand_total),0)-COALESCE(sum(paid_amount),0)) as purchase_due");
		$this->db->from("db_purchase");
		$this->db->where("`purchase_status`= 'Received'");
		$purchase_due=$this->db->get()->row()->purchase_due;
		$info['purchase_due']=$CI->currency(kmb($purchase_due));

		return $info;
	}

	public function get_store_health_metrics($store_id = ''){
		$CI =& get_instance();
		$store_id = (!empty($store_id)) ? $store_id : get_current_store_id();

		// 1. Total Sales (Final)
		$sales_q = $CI->db->select("COALESCE(SUM(grand_total),0) as tot_sales, COALESCE(SUM(paid_amount),0) as tot_paid")
		                  ->where('store_id', $store_id)
		                  ->where("sales_status", 'Final')
		                  ->get('db_sales')->row();
		$tot_sales = floatval($sales_q->tot_sales);
		$tot_paid = floatval($sales_q->tot_paid);
		$sales_due = max(0, $tot_sales - $tot_paid);

		// 2. Cost of Goods Sold (COGS)
		$cogs_q = $CI->db->query("SELECT COALESCE(SUM(si.sales_qty * COALESCE(NULLIF(si.purchase_price,0), i.purchase_price, 0)), 0) as tot_cogs 
			FROM db_salesitems si 
			JOIN db_sales s ON s.id = si.sales_id 
			LEFT JOIN db_items i ON i.id = si.item_id 
			WHERE s.store_id = $store_id AND s.sales_status = 'Final'");
		$tot_cogs = ($cogs_q && $cogs_q->num_rows() > 0) ? floatval($cogs_q->row()->tot_cogs) : 0;

		// 3. Total Purchases (Received)
		$pur_q = $CI->db->select("COALESCE(SUM(grand_total),0) as tot_pur")
		                 ->where('store_id', $store_id)
		                 ->where("purchase_status", 'Received')
		                 ->get('db_purchase')->row();
		$tot_pur = floatval($pur_q->tot_pur);

		// 4. Total Expenses
		$exp_q = $CI->db->select("COALESCE(SUM(expense_amt),0) as tot_exp")
		                ->where('store_id', $store_id)
		                ->get('db_expense')->row();
		$tot_exp = floatval($exp_q->tot_exp);

		// 5. Items and Stock Health
		$tot_items = $CI->db->where('store_id', $store_id)->where('status', 1)->count_all_results('db_items');
		$low_stock = $CI->db->where('store_id', $store_id)->where('status', 1)->where('(stock <= alert_qty OR stock IS NULL)')->where('service_bit', 0)->count_all_results('db_items');

		// 6. Invoices Count
		$tot_invoices = $CI->db->where('store_id', $store_id)->count_all_results('db_sales');

		// Profitability / Margin Health (35%)
		if($tot_sales > 0){
			$gross_profit = ($tot_cogs > 0) ? ($tot_sales - $tot_cogs) : $tot_sales;
			$net_profit = $gross_profit - $tot_exp;
			$profit_ratio = ($net_profit / $tot_sales);
			$net_margin = round($profit_ratio * 100);

			if($profit_ratio >= 0.20){
				$score_finance = 35;
			} else if($profit_ratio >= 0){
				$score_finance = 18 + ($profit_ratio / 0.20) * 17;
			} else {
				$score_finance = max(5, 18 + ($profit_ratio * 20));
			}
		} else {
			$score_finance = 25;
			$net_margin = 0;
		}

		// Debt Collection Health (25%)
		if($tot_sales > 0){
			$collection_rate = min(100, round(($tot_paid / $tot_sales) * 100));
			$score_collection = ($collection_rate / 100) * 25;
		} else {
			$score_collection = 25;
			$collection_rate = 100;
		}

		// Stock Health (25%)
		if($tot_items > 0){
			$healthy_items = max(0, $tot_items - $low_stock);
			$stock_ratio = min(100, round(($healthy_items / $tot_items) * 100));
			$score_stock = ($stock_ratio / 100) * 25;
		} else {
			$score_stock = 20;
			$stock_ratio = 100;
		}

		// Activity & Setup Health (15%)
		$score_activity = ($tot_invoices > 0) ? 15 : 10;

		$overall_health = round($score_finance + $score_collection + $score_stock + $score_activity);
		$overall_health = min(100, max(10, $overall_health));

		if($overall_health >= 85){
			$health_status = 'Excellent';
			$health_color = '#059669';
			$health_bg = '#ecfdf5';
		} else if($overall_health >= 70){
			$health_status = 'Good / Stable';
			$health_color = '#0899a4';
			$health_bg = '#e0f6f7';
		} else if($overall_health >= 50){
			$health_status = 'Moderate';
			$health_color = '#ea7916';
			$health_bg = '#fff4ea';
		} else {
			$health_status = 'Needs Attention';
			$health_color = '#e11d48';
			$health_bg = '#fff1f2';
		}

		return array(
			'overall_health' => $overall_health,
			'health_status' => $health_status,
			'health_color' => $health_color,
			'health_bg' => $health_bg,
			'tot_sales' => $tot_sales,
			'tot_paid' => $tot_paid,
			'sales_due' => $sales_due,
			'tot_pur' => $tot_pur,
			'tot_exp' => $tot_exp,
			'tot_cogs' => $tot_cogs,
			'tot_items' => $tot_items,
			'low_stock' => $low_stock,
			'stock_ratio' => $stock_ratio,
			'collection_rate' => $collection_rate,
			'net_margin' => $net_margin,
		);
	}

	public function get_total_stock_metrics($store_id = ''){
		$CI =& get_instance();
		$store_id = (!empty($store_id)) ? $store_id : get_current_store_id();

		$q = $CI->db->query("SELECT 
			count(*) as total_products,
			coalesce(sum(case when stock > 0 then stock else 0 end), 0) as total_stock_qty,
			coalesce(sum(case when stock > 0 then stock * coalesce(nullif(price, 0), purchase_price, 0) else 0 end), 0) as total_purchase_value,
			coalesce(sum(case when stock > 0 then stock * sales_price else 0 end), 0) as total_sales_value,
			coalesce(sum(case when stock <= alert_qty or stock is null then 1 else 0 end), 0) as low_stock_items
			FROM db_items 
			WHERE store_id = $store_id AND status = 1 AND service_bit = 0 AND item_group != 'Variants'");

		$res = ($q && $q->num_rows() > 0) ? $q->row() : null;

		$total_products = $res ? intval($res->total_products) : 0;
		$total_stock_qty = $res ? floatval($res->total_stock_qty) : 0;
		$total_purchase_val = $res ? floatval($res->total_purchase_value) : 0;
		$total_sales_val = $res ? floatval($res->total_sales_value) : 0;
		$low_stock_items = $res ? intval($res->low_stock_items) : 0;
		$potential_profit = max(0, $total_sales_val - $total_purchase_val);

		return array(
			'total_products'       => $total_products,
			'total_stock_qty'      => $total_stock_qty,
			'total_purchase_val'   => $total_purchase_val,
			'total_sales_val'      => $total_sales_val,
			'potential_profit'     => $potential_profit,
			'low_stock_items'      => $low_stock_items,
			'purchase_val_format'  => $CI->currency(kmb($total_purchase_val)),
			'sales_val_format'     => $CI->currency(kmb($total_sales_val)),
		);
	}
}