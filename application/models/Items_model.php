<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items_model extends CI_Model {

	//Datatable start
	var $table = 'db_items as a';
	var $column_order = array( 
								'a.id',
								'a.item_image',
								'a.item_code',
								'a.item_name',
								'e.brand_name',
								'b.category_name',
								'c.unit_name',
								'a.stock',
								'a.alert_qty',
								'a.sales_price',
								'd.tax_name',
								'a.service_bit',
								'd.tax',
								'a.status',
								'a.store_id',
								'a.sku',
								'a.hsn',
								'a.sac',
								'a.item_group',
								'a.warranty_days',
								); //set column field database for datatable orderable
	var $column_search = array( 
								'a.id',
								'a.item_image',
								'a.item_code',
								'a.item_name',
								'e.brand_name',
								'b.category_name',
								'c.unit_name',
								'a.stock',
								'a.alert_qty',
								'a.sales_price',
								'd.tax_name',
								'a.service_bit',
								'd.tax',
								'a.status',
								'a.store_id',
								'a.sku',
								'a.hsn',
								'a.sac',
								'a.item_group',
								); //set column field database for datatable searchable 
	var $order = array('a.id' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
	}
	
	private function _get_datatables_query()
	{	
		

		$this->db->select($this->column_order);
		$this->db->from($this->table);
		$this->db->join('db_category as b',"b.id=a.category_id","left");
		$this->db->join('db_units as c',"c.id=a.unit_id","left");
		$this->db->join('db_tax as d',"d.id=a.tax_id","left");
		$this->db->select("CASE WHEN e.brand_name IS NULL THEN '' ELSE e.brand_name END AS brand_name");
		$this->db->join('db_brands as e','e.id=a.brand_id','left');
		

		/*If warehouse selected*/
		$warehouse_id = $this->input->post('warehouse_id');
		$item_type = $this->input->post('item_type');

		if(!empty($warehouse_id)){
			/*$this->db->from('db_warehouseitems as w');
			$this->db->where('a.id=w.item_id');
			$this->db->where('w.warehouse_id',$warehouse_id);*/
		}
		if($item_type=='Items'){
			$this->db->where('a.service_bit=0');
		}
		if($item_type=='Services'){
			$this->db->where('a.service_bit=1');
		}

		//if not admin
		//if(!is_admin()){
			$this->db->where("a.store_id",get_current_store_id());
		//}
		
		//$this->db->where("a.child_bit=0");
		//$this->db->where("a.item_group!='Variants'");
			$this->db->where("(a.item_group is NULL || a.item_group = 'Single')");
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

	public function log_details(){
		$data = $this->data;
		return array(
    				'created_date' 				=> $data['CUR_DATE'],
    				'created_time' 				=> $data['CUR_TIME'],
    				'created_by' 				=> $data['CUR_USERNAME'],
    				'system_ip' 				=> $data['SYSTEM_IP'],
    				'system_name' 				=> $data['SYSTEM_NAME']
			    );
	}
	
	//Save Record
	public function save_record($modal_post=array()){
		//Filtering XSS and html escape from user inputs 
		extract($this->security->xss_clean(html_escape(array_merge($this->data,$_POST,$_GET,$modal_post))));
		
		//varify max sales usage of the package subscription
		validate_package_offers('max_items','db_items');
		//END

		$this->db->trans_begin();
		$this->db->trans_strict(TRUE);

		$file_name='';
		if(!empty($_FILES['item_image']['name'])){

			$new_name = time();
			$config['file_name'] = $new_name;
			$config['upload_path']          = './uploads/items/';
	        $config['allowed_types']        = 'jpg|png|jpeg';
	        $config['max_size']             = 1024;
	        $config['max_width']            = 1500;
	        $config['max_height']           = 1500;
	       
	        $this->load->library('upload', $config);

	        if ( ! $this->upload->do_upload('item_image'))
	        {	
	                $error = array('error' => $this->upload->display_errors());
	                print($error['error']);
	                exit();
	        }
	        else
	        {		
	        	$file_name=$this->upload->data('file_name');
	        	/*Create Thumbnail*/
	        	$config['image_library'] = 'gd2';
				$config['source_image'] = 'uploads/items/'.$file_name;
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['width']         = 75;
				$config['height']       = 50;
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
				//end

	        	
	        }
		}


		
		//Validate This items already exist or not
		$store_id=(store_module() && is_admin()) ? $store_id : get_current_store_id();
		/*$query=$this->db->query("select * from db_items where upper(item_name)=upper('$item_name') and store_id=$store_id");
		if($query->num_rows()>0){
			return "Sorry! This Items Name already Exist.";
		}*/
		
		//Create items unique Number
		$this->db->query("ALTER TABLE db_items AUTO_INCREMENT = 1");
		//end

		
		//$stock = $current_opening_stock + $new_opening_stock;

		$alert_qty = empty(trim($alert_qty)) ? '0' : $alert_qty;

		if($item_group=='Single'){
			$initial = array();
			if ( $command == 'save' ) {
				$initial = array(
			    				'store_id' 					=> $store_id,
								'count_id' 					=> get_count_id('db_items'), 
			    				//'item_code' 				=> get_init_code('item'), 
			    				'status' 					=> 1,
			    			);
				$initial = array_merge($initial,$this->log_details());

			}//Command SAVE
			$profit_margin = (empty(trim($profit_margin)) || $profit_margin === 'null') ? NULL : floatval($profit_margin);
			$brand_id = (!empty($brand_id)) ? intval($brand_id) : NULL;
			$tax_id = (!empty($tax_id)) ? intval($tax_id) : NULL;
			$mrp = (!empty($mrp)) ? floatval($mrp) : NULL;
			$discount = (!empty($discount)) ? floatval($discount) : 0;
			$seller_points = (!empty($seller_points)) ? floatval($seller_points) : 0;
			$warranty_days = (isset($warranty_days) && $warranty_days !== '') ? intval($warranty_days) : 0;
			$item_serials = isset($_POST['item_serials']) ? trim($_POST['item_serials']) : '';
			$custom_barcode = (empty(trim($custom_barcode))) ? generate_unique_barcode($store_id) : substr(trim($custom_barcode), 0, 20);
			$info = array(
			    				'item_name' 				=> $item_name,
			    				'brand_id' 					=> $brand_id,
			    				'category_id' 				=> $category_id,
			    				'sku' 						=> $sku,
			    				'hsn' 						=> $hsn,
			    				'unit_id' 					=> $unit_id,
			    				'alert_qty' 				=> $alert_qty,
			    				
			    				'price' 					=> $price,
			    				'tax_id' 					=> $tax_id,
			    				'purchase_price' 			=> $purchase_price,
			    				'tax_type' 					=> $tax_type,
			    				'profit_margin' 			=> $profit_margin,
			    				'sales_price' 				=> $sales_price,
			    				
			    				'seller_points'				=> $seller_points,
			    				'custom_barcode'			=> $custom_barcode,
			    				'description'				=> $description,
			    				'item_group'				=> $item_group,
			    				'discount_type'				=> $discount_type,
			    				'discount'					=> $discount,
			    				'mrp'						=> $mrp,
			    				'warranty_days'				=> $warranty_days,
			    				'item_serials'				=> $item_serials,

			    				'item_code' 				=> $item_code,
			    				
			    			);
			if(!empty($file_name)){
								$info['item_image'] = 'uploads/items/'.$file_name;
							}
							
			if ( $command == 'save' ){
				$query1 = $this->db->insert('db_items', array_merge($info,$initial));
				$item_id = $this->db->insert_id();
			}
			else{
				$item_id = $q_id;
				$query1 = $this->db->where('id',$q_id)->update('db_items', array_merge($info,$initial));
			}
			
			if(!$query1){
				return "failed";
			}

			// Sync serials into db_item_serials
			if(!empty($item_serials)){
				$raw_serials = preg_split('/[\r\n,]+/', $item_serials);
				$clean_serials = array();
				foreach($raw_serials as $s_code){
					$s_code = trim($s_code);
					if(!empty($s_code) && !in_array($s_code, $clean_serials)){
						$clean_serials[] = $s_code;
					}
				}
				foreach($clean_serials as $s_code){
					$chk = $this->db->where('store_id', $store_id)
									->where('item_id', $item_id)
									->where('serial_code', $s_code)
									->count_all_results('db_item_serials');
					if(!$chk){
						$this->db->insert('db_item_serials', array(
							'store_id'     => $store_id,
							'item_id'      => $item_id,
							'serial_code'  => $s_code,
							'status'       => 'Available',
							'sales_id'     => 0,
							'created_date' => date('Y-m-d')
						));
					}
				}
			}
			
			

			//Opening Stock Exist
			if($adjustment_qty>0){
				$array_params = array(  'store_id'			=> 	$store_id,
                                        'item_id'			=>	$item_id, 
                                        'warehouse_id'		=>	$warehouse_id, 
                                        'adjustment_qty'	=> 	$adjustment_qty, 
                                   	);
                $q2 = $this->add_opening_stock($array_params); 
                if(!$q2){
                    return "failed";
                }
            }

		}//Single END

		//Insert Variants in db_items table
		if( $item_group =='Variants'){
			if($existing_row_count>0){
				for($i=1;$i<=$existing_row_count;$i++){
					if(isset($_REQUEST['tr_variant_id_'.$i]) && !empty($_REQUEST['tr_variant_id_'.$i])){

						$variant_id 		=$this->xss_html_filter(trim($_REQUEST['tr_variant_id_'.$i]));
						$sku				=$this->xss_html_filter(trim($_REQUEST['td_data_'.$i.'_2']));
						$hsn				=$this->xss_html_filter(trim($_REQUEST['td_data_'.$i.'_9']));
						$custom_barcode 	=$this->xss_html_filter(trim($_REQUEST['td_data_'.$i.'_8']));
						$custom_barcode 	=(empty(trim($custom_barcode))) ? generate_unique_barcode($store_id) : substr(trim($custom_barcode), 0, 20);
						$price 			 	=$this->xss_html_filter(trim($_REQUEST['td_data_'.$i.'_3']));
						$purchase_price	 	=$this->xss_html_filter(trim($_REQUEST['td_data_'.$i.'_4']));
						$profit_margin	 	=$this->xss_html_filter(trim($_REQUEST['td_data_'.$i.'_5']));
						$sales_price	 	=$this->xss_html_filter(trim($_REQUEST['td_data_'.$i.'_6']));
						$item_mrp	 		=$this->xss_html_filter(trim($_REQUEST['td_data_'.$i.'_10']));
						$opening_stock	 	=$this->xss_html_filter(trim($_REQUEST['td_data_'.$i.'_11']));
						
						$variant_details = $this->db->select("*")->where("id",$variant_id)->get("db_variants")->row();
						$variant_name = $variant_details->variant_name;

						
						$initial = array();
						if ( $command == 'save' ) {
							$initial = array(
						    				'store_id' 					=> $store_id,
											'count_id' 					=> get_count_id('db_items'), 
						    				'item_code' 				=> get_init_code('item'), 
						    				'status' 					=> 1,
						    			);
							$initial = array_merge($initial,$this->log_details());

						}//Command SAVE
						else{
							$count_id 			=$this->xss_html_filter(trim($_REQUEST['count_id_'.$i]));
							$item_code 			=$this->xss_html_filter(trim($_REQUEST['item_code_'.$i]));
							$initial = array(
											'count_id' 					=> $count_id, 
						    				'item_code' 				=> $item_code,
						    			);
						}

						$info = array(
			    				'item_name' 				=> $item_name."-".$variant_name,
			    				'brand_id' 					=> $brand_id,
			    				'category_id' 				=> $category_id,
			    				'sku' 						=> $sku,
			    				'hsn' 						=> $hsn,
			    				'unit_id' 					=> $unit_id,
			    				'alert_qty' 				=> $alert_qty,
			    				
			    				'price' 					=> $price,
			    				'tax_id' 					=> $tax_id,
			    				'purchase_price' 			=> $purchase_price,
			    				'tax_type' 					=> $tax_type,
			    				'profit_margin' 			=> $profit_margin,
			    				'sales_price' 				=> $sales_price,
			    				'mrp' 						=> $item_mrp,
			    				'warranty_days'				=> $warranty_days,
			    				
			    				'seller_points'				=> $seller_points,
			    				'custom_barcode'			=> $custom_barcode,
			    				'description'				=> $description,
			    				'item_group'				=> 'Single',
			    				//'parent_id'					=> $item_id,
			    				'child_bit'					=> 1,
			    				'variant_id'				=> $variant_id,
			    				'discount_type'				=> $discount_type,
			    				'discount'					=> $discount,
			    			
			    			);
							
							if(!empty($file_name)){
								$info['item_image'] = 'uploads/items/'.$file_name;
							}
							/*echo "<pre>";
							print_r($info);
							exit;*/
							$info = array_merge($info,$initial);
							if ( $command == 'save'){
								$query1 = $this->db->insert('db_items', $info);
							}
							else{
								//FIND THE THIS VARIANT SAVED IN DB_ITEMS OT NOT
								$q3 = $this->db->select("id")->where('variant_id',$variant_id)->where('parent_id',$item_id)->get("db_items");
								if($q3->num_rows()>0){
									//YES ITEM ALREADY EXIST
									$query1 = $this->db->where("id",$q3->row()->id)->update('db_items', $info);	
								}
								else{
									$query1 = $this->db->insert('db_items', $info);
								}
							}
							#------------------------------------
							if(!$query1){
								return "failed";
							}
							$variant_item_id = $this->db->insert_id();

							//Opening Stock Exist
							if($opening_stock>0){
								$array_params = array(  'store_id'			=> 	$store_id,
		                                                'item_id'			=>	$variant_item_id, 
		                                                'warehouse_id'		=>	$warehouse_id, 
		                                                'adjustment_qty'	=> 	$opening_stock, 
		                                           	);
		                        $q2 = $this->add_opening_stock($array_params); 
		                        if(!$q2){
		                            return "failed";
		                        }
		                    }


					}
				
				}//for end
			}//existing_row_count END
		}//Variant END

		
		if ($query1){
				$this->db->trans_commit();
				if ($command=='save') {
					$this->session->set_flashdata('success', 'Success!! New Item Added Successfully!');
				}
				else{
					$this->session->set_flashdata('success', 'Success!! Item Updated Successfully!');
				}
				
		        return "success";
		}
		else{
				$this->db->trans_rollback();
				//unlink('uploads/items/'.$file_name);
		        return "failed";
		}
		
	}

	//Get items_details
	public function get_details($id,$data){
		//Validate This items already exist or not
		$query=$this->db->query("select * from db_items where upper(id)=upper('$id')");
		if($query->num_rows()==0){
			show_404();exit;
		}
		else{
			$query=$query->row();
			$data['q_id']=$query->id;
			$data['store_id']=$query->store_id;
			$data['item_code']=$query->item_code;
			$data['item_name']=$query->item_name;
			$data['brand_id']=$query->brand_id;
			$data['category_id']=$query->category_id;
			$data['sku']=$query->sku;
			$data['hsn']=$query->hsn;
			$data['sac']=$query->sac;
			$data['unit_id']=$query->unit_id;
			$data['alert_qty']=$query->alert_qty;
			$data['price']=store_number_format($query->price,0);
			$data['tax_id']=$query->tax_id;
			$data['purchase_price']=store_number_format($query->purchase_price,0);
			$data['tax_type']=$query->tax_type;
			$data['profit_margin']=$query->profit_margin;
			$data['sales_price']=store_number_format($query->sales_price,0);
			$data['stock']=$query->stock;
			
			$data['seller_points']=$query->seller_points;
			$data['custom_barcode']=$query->custom_barcode;
			$data['description']=$query->description;
			$data['item_group']=$query->item_group;
			$data['discount']=$query->discount;
			$data['discount_type']=$query->discount_type;
			$data['child_bit']=$query->child_bit;
			$data['mrp']=store_number_format($query->mrp,0);
			$data['warranty_days']=isset($query->warranty_days) ? $query->warranty_days : 0;
			$data['item_serials']=isset($query->item_serials) ? $query->item_serials : '';
			if(empty($data['item_serials'])){
				$sq = $this->db->select('serial_code')->where('item_id', $id)->get('db_item_serials');
				if($sq->num_rows() > 0){
					$s_arr = array();
					foreach($sq->result() as $sr){ $s_arr[] = $sr->serial_code; }
					$data['item_serials'] = implode("\n", $s_arr);
				}
			}
			
			return $data;
		}
	}
	
	public function update_status($id,$status){
       if (set_status_of_table($id,$status,'db_items')){
            echo "success";
        }
        else{
            echo "failed";
        }
	}

	public function delete_items_from_table($ids){
		$this->db->trans_begin();
		//find the this item has the Purchase Return 
		$purchase_ret_rec = $this->db->select("*")->where("store_id",get_current_store_id())->where("item_id in($ids)")->group_by('item_id')->get("db_purchaseitemsreturn");
		if($purchase_ret_rec->num_rows()>0){
			$i=1;
			echo "Can't Delete!<br>These Items List Have the Purchase Returns Records!";
			foreach($purchase_ret_rec->result() as $res1){
				echo "<br>".$i++.". ".get_item_name($res1->item_id);
			}
			exit;
		}

		//find the this item has the Purchase
		$purchase_rec = $this->db->select("*")->where("store_id",get_current_store_id())->where("item_id in($ids)")->group_by('item_id')->get("db_purchaseitems");
		if($purchase_rec->num_rows()>0){
			$i=1;
			echo "Can't Delete!<br>These Items List Have the Purchase Records!";
			foreach($purchase_rec->result() as $res1){
				echo "<br>".$i++.". ".get_item_name($res1->item_id);
			}
			exit;
		}

		//find the this item has the Sales Return 
		$sales_ret_rec = $this->db->select("*")->where("store_id",get_current_store_id())->where("item_id in($ids)")->group_by('item_id')->get("db_salesitemsreturn");
		if($sales_ret_rec->num_rows()>0){
			$i=1;
			echo "Can't Delete!<br>These Items List Have the Sales Returns Records!";
			foreach($sales_ret_rec->result() as $res1){
				echo "<br>".$i++.". ".get_item_name($res1->item_id);
			}
			exit;
		}

		//find the this item has the sales
		$sales_rec = $this->db->select("*")->where("store_id",get_current_store_id())->where("item_id in($ids)")->group_by('item_id')->get("db_salesitems");
		if($sales_rec->num_rows()>0){
			$i=1;
			echo "Can't Delete!<br>These Items List Have the Sales Records!";
			foreach($sales_rec->result() as $res1){
				echo "<br>".$i++.". ".get_item_name($res1->item_id);
			}
			exit;
		}

		//find the this item has the quotation
		$quotation_rec = $this->db->select("*")->where("store_id",get_current_store_id())->where("item_id in($ids)")->group_by('item_id')->get("db_quotationitems");
		if($quotation_rec->num_rows()>0){
			$i=1;
			echo "Can't Delete!<br>These Items List Have the Quotation Records!";
			foreach($quotation_rec->result() as $res1){
				echo "<br>".$i++.". ".get_item_name($res1->item_id);
			}
			exit;
		}
	
		//find the this item has the stock adjustment entries
		/*$quotation_rec = $this->db->select("*")->where("store_id",get_current_store_id())->where("item_id in($ids)")->group_by('item_id')->get("db_stockadjustmentitems");
		if($quotation_rec->num_rows()>0){
			$i=1;
			echo "Can't Delete!<br>These Items List Have the Stock Adjustment Records!";
			foreach($quotation_rec->result() as $res1){
				echo "<br>".$i++.". ".get_item_name($res1->item_id);
			}
			exit;
		}		*/


		
		$q1=$this->db->query("delete from db_items where id in($ids)");
		$q1=$this->db->query("delete from db_items where parent_id in($ids)");
		
		/*Update items in all warehouses of the item*/
		$q7=update_warehousewise_items_qty_by_store(null,$ids);
		if(!$q7){
			return "failed";
		}

        if($q1 && $q7){
        	$this->db->trans_commit();
            echo "success";
        }
        else{
            echo "failed";
        }	
	}


	public function inclusive($price=0, $tax_per=0){
		return $price/(($tax_per/100)+1)/10;
	}

	//GET Labels from Purchase Invoice
	public function get_purchase_items_info($rowcount,$item_id,$purchase_qty){
		$q1=$this->db->select('*')->from('db_items')->where("id=$item_id")->get();
		$row = $q1->row();

		$info['item_id'] = $row->id;
		$info['item_name'] = $row->item_name;
		$info['item_available_qty'] = $row->stock;
		$info['item_sales_qty'] = $purchase_qty;
		
		$sales_price = (float)$row->sales_price;
		$mrp = (float)$row->mrp;
		$discount = (float)$row->discount;
		$discount_type = $row->discount_type;

		$info['sales_price'] = $sales_price;
		$info['mrp'] = $mrp;
		$info['discount'] = $discount;
		$info['discount_type'] = $discount_type;

		$default_offer = '';
		if (!empty($mrp) && $mrp > $sales_price && $sales_price > 0) {
			$info['regular_price'] = $mrp;
			$default_offer = $sales_price;
		} elseif (!empty($discount) && $discount > 0 && $sales_price > 0) {
			$info['regular_price'] = $sales_price;
			$default_offer = ($discount_type == 'Percentage') ? ($sales_price - ($sales_price * $discount / 100)) : ($sales_price - $discount);
		} else {
			$info['regular_price'] = $sales_price;
			$default_offer = '';
		}
		$info['default_offer'] = (!empty($default_offer)) ? store_number_format($default_offer, 2) : '';
		$info['regular_price'] = store_number_format($info['regular_price'], 2);

	    return $this->return_row_with_data($rowcount,$info);
	}

	public function get_items_info($rowcount,$item_id){
		$q1=$this->db->select('*')->from('db_items')->where("id=$item_id")->get();
		$row = $q1->row();

		$info['item_id'] = $row->id;
		$info['item_name'] = $row->item_name;
		$info['item_available_qty'] = $row->stock;
		$info['item_sales_qty'] = 1;

		$sales_price = (float)$row->sales_price;
		$mrp = (float)$row->mrp;
		$discount = (float)$row->discount;
		$discount_type = $row->discount_type;

		$info['sales_price'] = $sales_price;
		$info['mrp'] = $mrp;
		$info['discount'] = $discount;
		$info['discount_type'] = $discount_type;

		$default_offer = '';
		if (!empty($mrp) && $mrp > $sales_price && $sales_price > 0) {
			$info['regular_price'] = $mrp;
			$default_offer = $sales_price;
		} elseif (!empty($discount) && $discount > 0 && $sales_price > 0) {
			$info['regular_price'] = $sales_price;
			$default_offer = ($discount_type == 'Percentage') ? ($sales_price - ($sales_price * $discount / 100)) : ($sales_price - $discount);
		} else {
			$info['regular_price'] = $sales_price;
			$default_offer = '';
		}
		$info['default_offer'] = (!empty($default_offer)) ? number_format((float)$default_offer, 2, '.', '') : '';
		$info['regular_price'] = number_format((float)$info['regular_price'], 2, '.', '');

		$this->return_row_with_data($rowcount,$info);
	}
	

	public function return_row_with_data($rowcount,$info){
		extract($info);

		$reg_price = isset($regular_price) ? $regular_price : '0.00';
		$def_offer = isset($default_offer) ? $default_offer : '';

		?>
            <tr id="row_<?=$rowcount;?>" data-row='<?=$rowcount;?>'>
               <td id="td_<?=$rowcount;?>_1">
                  <!-- item name  -->
                  <input type="text" style="font-weight: bold;" id="td_data_<?=$rowcount;?>_1" class="form-control no-padding" value='<?=$item_name;?>' readonly >
               </td>
               <!-- Regular Price -->
               <td id="td_<?=$rowcount;?>_price_col" style="text-align: center;">
                  <input type="text" style="font-weight: bold; text-align: center;" id="td_data_<?=$rowcount;?>_regular_price" name="td_data_<?=$rowcount;?>_regular_price" class="form-control no-padding" value='<?=$reg_price;?>' readonly >
               </td>
               <!-- Offer Price (Optional) -->
               <td id="td_<?=$rowcount;?>_offer_col" style="text-align: center;">
                  <input type="text" style="text-align: center;" id="td_data_<?=$rowcount;?>_offer_price" name="td_data_<?=$rowcount;?>_offer_price" class="form-control no-padding only_currency" placeholder="Offer price (optional)" value='<?=$def_offer;?>'>
               </td>
               <!-- Qty -->
               <td id="td_<?=$rowcount;?>_3">
                  <div class="input-group ">
                     <span class="input-group-btn">
                     <button onclick="decrement_qty(<?=$rowcount;?>)" type="button" class="btn btn-default btn-flat"><i class="fa fa-minus text-danger"></i></button></span>
                     <input type="text" value="<?=$item_sales_qty;?>" class="form-control no-padding text-center" onkeyup="calculate_tax(<?=$rowcount;?>)" id="td_data_<?=$rowcount;?>_3" name="td_data_<?=$rowcount;?>_3">
                     <span class="input-group-btn">
                     <button onclick="increment_qty(<?=$rowcount;?>)" type="button" class="btn btn-default btn-flat"><i class="fa fa-plus text-success"></i></button></span>
                  </div>
               </td>
               
               <!-- Remove button -->
               <td id="td_<?=$rowcount;?>_16" style="text-align: center;">
                  <a class=" fa fa-fw fa-minus-square text-red" style="cursor: pointer;font-size: 34px;" onclick="removerow(<?=$rowcount;?>)" title="Delete ?" name="td_data_<?=$rowcount;?>_16" id="td_data_<?=$rowcount;?>_16"></a>
               </td>
               <input type="hidden" id="tr_available_qty_<?=$rowcount;?>_13" value="<?=$item_available_qty;?>">
               <input type="hidden" id="tr_item_id_<?=$rowcount;?>" name="tr_item_id_<?=$rowcount;?>" value="<?=$item_id;?>">
            </tr>
		<?php

	}
	public function xss_html_filter($input){
		return $this->security->xss_clean(html_escape($input));
	}

	public function preview_labels(){
		$CI =& get_instance();
		//Filtering XSS and html escape from user inputs 
		$store_name = $this->db->query("select store_name from db_store where id=".get_current_store_id())->row()->store_name;
		$rowcount = $this->input->post('hidden_rowcount');

		?>
		<div class="labels_outer_wrap" style="width:100%; margin:0 auto; padding:0;">
			<div class="labels_container" id="labels_container" style="display: flex; flex-direction: column; align-items: center; gap: 14px; width: 100%; margin: 0 auto; padding: 10px 0;">

					<?php
					//Import post data from form
					for($i=1;$i<=$rowcount;$i++){
					
						if(isset($_POST['tr_item_id_'.$i]) && !empty($_POST['tr_item_id_'.$i])){

							$item_id 		= $this->xss_html_filter(trim($_POST['tr_item_id_'.$i]));
							$item_count 	= (int) $this->xss_html_filter(trim($_POST['td_data_'.$i."_3"]));
							$res1 = $this->db->query("select * from db_items where id=$item_id")->row();

							$item_name = $res1->item_name;
							$raw_barcode = (!empty($res1->custom_barcode)) ? trim($res1->custom_barcode) : trim($res1->item_code);
							
							// Support 12-digit numeric auto or up to 20-char custom barcode
							$serial_code = substr($raw_barcode, 0, 20);
							$serial_len = strlen($serial_code);
							if ($serial_len <= 6) {
								$serial_font_size = '8px';
								$serial_spacing = '9.5px';
							} elseif ($serial_len <= 8) {
								$serial_font_size = '8px';
								$serial_spacing = '7px';
							} elseif ($serial_len <= 10) {
								$serial_font_size = '8px';
								$serial_spacing = '5.2px';
							} elseif ($serial_len <= 12) {
								$serial_font_size = '8px';
								$serial_spacing = '3.8px';
							} elseif ($serial_len <= 14) {
								$serial_font_size = '7.5px';
								$serial_spacing = '2.4px';
							} elseif ($serial_len <= 16) {
								$serial_font_size = '7.5px';
								$serial_spacing = '1.4px';
							} elseif ($serial_len <= 18) {
								$serial_font_size = '7px';
								$serial_spacing = '0.6px';
							} else {
								$serial_font_size = '6.5px';
								$serial_spacing = '0.2px';
							}

							// Prices & Offer calculation
							$item_sales_price = (float)$res1->sales_price;
							$item_mrp = (float)$res1->mrp;
							$item_discount = (float)$res1->discount;
							$item_discount_type = $res1->discount_type;

							// Check form input values with thorough comma removal
							$raw_regular = isset($_POST['td_data_'.$i.'_regular_price']) ? str_replace(',', '', trim($_POST['td_data_'.$i.'_regular_price'])) : '';
							$input_regular = (is_numeric($raw_regular)) ? (float)$raw_regular : 0;

							$raw_offer = (isset($_POST['td_data_'.$i.'_offer_price']) && trim($_POST['td_data_'.$i.'_offer_price']) !== '') ? str_replace(',', '', trim($_POST['td_data_'.$i.'_offer_price'])) : null;
							$input_offer = ($raw_offer !== null && is_numeric($raw_offer)) ? (float)$raw_offer : null;

							$has_offer = false;
							$old_price = 0;
							$new_price = 0;

							if($input_offer !== null && $input_offer > 0 && $input_regular > 0 && $input_offer < $input_regular){
								// User manually provided an offer in the labels table
								$has_offer = true;
								$old_price = $input_regular;
								$new_price = $input_offer;
							} elseif(!empty($item_mrp) && $item_mrp > $item_sales_price && $item_sales_price > 0){
								// Item has MRP > sales_price
								$has_offer = true;
								$old_price = $item_mrp;
								$new_price = $item_sales_price;
							} elseif(!empty($item_discount) && $item_discount > 0 && $item_sales_price > 0){
								// Item has a discount % or fixed
								$has_offer = true;
								$old_price = $item_sales_price;
								$new_price = ($item_discount_type == 'Percentage') ? ($item_sales_price - ($item_sales_price * $item_discount / 100)) : ($item_sales_price - $item_discount);
							} else {
								// Regular price
								$old_price = ($input_regular > 0) ? $input_regular : $item_sales_price;
								$new_price = $old_price;
							}

							for($j=1;$j<=$item_count;$j++){
							?>
							<div class="label_item" style="display: flex; justify-content: center; align-items: center; width: 100%; margin: 6px auto;">
								<div class="label_border">
									<!-- 1. Header: Shop Name & Product Name close together -->
									<div class="label-header">
										<div class="label-store-name">
											<?= htmlspecialchars($store_name); ?>
										</div>
										<div class="label-item-name">
											<?= htmlspecialchars($item_name); ?>
										</div>
									</div>

									<!-- 2. Barcode (Taller) & Serial Number (tightly positioned) -->
									<div class="label-barcode-block">
										<img class="label-barcode-img" src="<?php echo base_url();?>barcode/index/<?php echo urlencode($serial_code);?>?drawText=0" alt="Barcode">
										<div class="barcode-serial" style="letter-spacing: <?= $serial_spacing; ?>; font-size: <?= $serial_font_size; ?>;">
											<?= htmlspecialchars($serial_code); ?>
										</div>
									</div>

									<!-- 3. Product Price & Offer Price -->
									<div class="label-price">
										<b>Price: </b>
										<?php if($has_offer): ?>
											<del><?= $CI->currency($old_price);?></del>
											<b><?= $CI->currency($new_price);?></b>
										<?php else: ?>
											<b><?= $CI->currency($old_price);?></b>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<?php
							}
						}
					
					}//for end
					?>
					
			</div>
		</div>
		<?php
		
	}



	public function return_variant_data_in_row($rowcount,$variant_id){
		extract($_POST);

		$res1=$this->db->select('*')->from('db_variants')->where("id=$variant_id")->get()->row();
		
		$info = array(
							'item_id'					=> '', 
							'variant_id' 				=> $res1->id, 
							'variant_name' 				=> $res1->variant_name,
							'item_price' 				=> '',
							'item_sales_price' 			=> '',
							'variant_item_sku' 			=> '',
							'variant_item_hsn' 			=> '',
							'variant_profit_margin' 	=> '',
							'variant_purchase_price' 	=> '',
							'barcode'				 	=> generate_unique_barcode(),
							'count_id'				 	=> '',
							'item_code'				 	=> '',
							'item_mrp'				 	=> '',
							'opening_stock'				=> '0',
						);

		$this->return_variant_data_in_html_row($rowcount,$info);
	}
	public function get_variants_list_in_row($parent_id){
		$q1=$this->db->select('*')->from('db_items')->where("parent_id=$parent_id")->get();
		$rowcount =1;
		foreach ($q1->result() as $res1) {

			$res2=$this->db->select('*')->from('db_variants')->where("id",$res1->variant_id)->get()->row();
			
			$info = array(
							'item_id'					=> $res1->id, 
							'variant_id' 				=> $res2->id, 
							'variant_name' 				=> $res2->variant_name,
							'item_price' 				=> '',
							'item_sales_price' 			=> store_number_format($res1->sales_price,0),
							'variant_item_sku' 			=> $res1->sku,
							'variant_item_hsn' 			=> $res1->hsn,
							'variant_profit_margin' 	=> $res1->profit_margin,
							'variant_purchase_price' 	=> store_number_format($res1->price,0),
							'barcode'				 	=> $res1->custom_barcode,
							'count_id'				 	=> $res1->count_id,
							'item_code'				 	=> $res1->item_code,
							'item_mrp'				 	=> store_number_format($res1->mrp,0),
							'opening_stock'				=> 0,
						);
			
			$result = $this->return_variant_data_in_html_row($rowcount++,$info);
		}
		return $result;
	}

	public function return_variant_data_in_html_row($rowcount,$info){
		extract($info);
		?>
            <tr id="row_<?=$rowcount;?>" data-row='<?=$rowcount;?>'>
               <td id="td_<?=$rowcount;?>_1">
                  <label class='form-control' style='height:auto;' >
                  <a id="td_data_<?=$rowcount;?>_1" href="javascript:" title=""><?=$variant_name;?></a>
                  	</label>
               </td>
  
               <!-- SKU-->
               <td id="td_<?=$rowcount;?>_2"><input type="text" name="td_data_<?=$rowcount;?>_2" id="td_data_<?=$rowcount;?>_2" class="form-control text-center no-padding" value="<?=$variant_item_sku;?>" placeholder='Optional'></td>

               <!-- HSN-->
               <td id="td_<?=$rowcount;?>_9"><input type="text" name="td_data_<?=$rowcount;?>_9" id="td_data_<?=$rowcount;?>_9" class="form-control text-center no-padding" value="<?=$variant_item_hsn;?>" placeholder='Optional'></td>

               <!-- Barcode-->
               <td id="td_<?=$rowcount;?>_8"><input type="text" name="td_data_<?=$rowcount;?>_8" id="td_data_<?=$rowcount;?>_8" class="form-control text-center no-padding" value="<?=$barcode;?>" placeholder='Optional'></td>

               <!-- Price-->
               <td id="td_<?=$rowcount;?>_3"><input type="text" name="td_data_<?=$rowcount;?>_3" id="td_data_<?=$rowcount;?>_3" class="form-control text-right no-padding only_currency text-center" onkeyup='calculate_purchase_price_of_all_row()' placeholder='Required' style="border-color: #f39c12;" value="<?=$variant_purchase_price;?>"></td>

               <!-- Purchase Price-->
               <td id="td_<?=$rowcount;?>_4"><input type="text" name="td_data_<?=$rowcount;?>_4" id="td_data_<?=$rowcount;?>_4" class="form-control text-right no-padding only_currency text-center" placeholder='Required' style="border-color: #f39c12;" value="" readonly></td>

               <!-- Profit Margin-->
               <td id="td_<?=$rowcount;?>_5"><input type="text" name="td_data_<?=$rowcount;?>_5" id="td_data_<?=$rowcount;?>_5" class="form-control text-right no-padding only_currency text-center" placeholder='Required' onchange='calculate_sales_price_of_all_row()' style="border-color: #f39c12;" value="<?=$variant_profit_margin;?>"></td>

               <!-- Sales Price -->
               <td id="td_<?=$rowcount;?>_6"><input type="text" name="td_data_<?=$rowcount;?>_6" id="td_data_<?=$rowcount;?>_6" class="form-control text-right no-padding only_currency text-center" placeholder='Required' onchange='calculate_profit_margin_of_all_row()' style="border-color: #f39c12;" value="<?=$item_sales_price;?>"></td>

               <!-- MRP -->
               <td id="td_<?=$rowcount;?>_10"><input type="text" name="td_data_<?=$rowcount;?>_10" id="td_data_<?=$rowcount;?>_10" class="form-control text-right no-padding only_currency text-center" placeholder='Optional' value="<?=$item_mrp;?>"></td>

               <!-- Opening Stock -->
               <td id="td_<?=$rowcount;?>_11"><input type="text" name="td_data_<?=$rowcount;?>_11" id="td_data_<?=$rowcount;?>_11" class="form-control text-right no-padding only_currency text-center" placeholder='Optional' value="<?=$opening_stock;?>"></td>

               
               <!-- Delete button -->
               <td id="td_<?=$rowcount;?>_7" style="text-align: center;">
                  <a class=" fa fa-fw fa-minus-square text-red" style="cursor: pointer;font-size: 34px;" onclick="removerow_also_delete_from_database('<?=$item_id;?>',<?=$rowcount;?>)" title="Delete ?" name="td_data_<?=$rowcount;?>_7" id="td_data_<?=$rowcount;?>_7"></a>
               </td>
               <input type="hidden" id="tr_variant_id_<?=$rowcount;?>" name="tr_variant_id_<?=$rowcount;?>" value="<?=$variant_id;?>">
               <input type="hidden" id="count_id_<?=$rowcount;?>" name="count_id_<?=$rowcount;?>" value="<?=$count_id;?>">
               <input type="hidden" id="item_code_<?=$rowcount;?>" name="item_code_<?=$rowcount;?>" value="<?=$item_code;?>">
            </tr>
		<?php

	}

	public function add_opening_stock(array $info){
			//From MyController
			$data = $this->data;

			$stock_adjustment = array(
                'store_id'              	=> $info['store_id'], 
                'warehouse_id'              => $info['warehouse_id'], 
                'adjustment_date'           => $data['CUR_DATE'],
                //System Info
                'created_date'              => $data['CUR_DATE'],
                'created_time'              => $data['CUR_TIME'],
                'created_by'                => $data['CUR_USERNAME'],
                'system_ip'                 => $data['SYSTEM_IP'],
                'system_name'               => $data['SYSTEM_NAME'],
                'status'                    => 1,
            );


            $q1 = $this->db->insert('db_stockadjustment', $stock_adjustment);
            $adjustment_id = $this->db->insert_id();


            $adjustment_entry = array(
                        'store_id'              => $info['store_id'], 
                        'warehouse_id'          => $info['warehouse_id'], 
                        'adjustment_id'         => $adjustment_id,
                        'item_id'           	=> $info['item_id'],
                        'adjustment_qty'        => $info['adjustment_qty'],
                        'status'            => 1,
                    );
            
            
            try{
            	$insert = $this->db->insert('db_stockadjustmentitems', $adjustment_entry);
            	if($insert){
            		//Update Item Master stock
            		
            		//UPDATE itemS QUANTITY IN itemS TABLE
					$this->load->model('pos_model');				
					$query2=$this->pos_model->update_items_quantity($info['item_id']);
					if($query2){
						//update warehouse stock
						$q7=update_warehouse_items(array(array($info['item_id'])));
						if(!$q7){
							return false;
						}
						return true;
					}
					else{
						return false;
					}

            		return true;
            	}
            	else{
            		return false;
            	}
            }//try
            catch(Exception $e){
            	return false;
            }//catch

	}

	public function getItemsArray($id=''){

		$store_id = (isset($_REQUEST['store_id'])) ? $_REQUEST['store_id'] : get_current_store_id();

		

		$q = '';
		
		$this->db->select("id, item_name, item_code")->from('db_items');
		$this->db->where("store_id",$store_id);

		if(isset($_REQUEST['category_id']) && !empty($_REQUEST['category_id'])){
			$this->db->where("category_id",$_REQUEST['category_id']);
		}

		if(isset($_REQUEST['brand_id']) && !empty($_REQUEST['brand_id'])){
			$this->db->where("brand_id",$_REQUEST['brand_id']);
		}

		if(isset($_REQUEST['item_type']) && !empty($_REQUEST['item_type'])){
			$service_bit = ($_REQUEST['item_type'] == 'Services') ? 1 : 0;
			$this->db->where("service_bit",$service_bit);
		}

		if(!empty($id)){

			$this->db->where("id",$id);
			
		}else{

			$q = (isset($_POST['searchTerm'])) ? strtoupper($_POST['searchTerm']) : '';

			$this->db->where("(upper(item_name) like '%$q%' or upper(item_code) like '%$q%' or upper(custom_barcode) like '%$q%')");
		}
		$this->db->limit(10);
		//echo $this->db->get_compiled_select();exit;
		$query = $this->db->get();

		$display_json = array();

		if($query->num_rows()>0){
			foreach($query->result() as $res){


				$json_arr["id"] 					 = $res->id;
			  	$json_arr["text"] 					 = $res->item_name;
			  	$json_arr["item_code"] 					 = $res->item_code;
			  	
			  	array_push($display_json, $json_arr);
			}
		}
		return $display_json;
	}
	public function getItemsJson($id){
		return json_encode($this->getItemsArray($id));
	}
}
