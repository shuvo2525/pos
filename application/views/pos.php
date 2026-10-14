<!DOCTYPE html>
<html>

<head>
<!-- TABLES CSS CODE -->
<?php include"comman/code_css.php"; ?>
<!-- iCheck -->
  <link rel="stylesheet" href="<?php echo $theme_link; ?>plugins/iCheck/square/blue.css">
  <link rel="stylesheet" href="<?= base_url('theme/css/pos.css') ?>">
</head>

<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
  <?php $CI =& get_instance(); ?>
<div class="wrapper">
  
  
  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <?php
          $curr_store_id = get_current_store_id();
          if(empty($curr_store_id)){
            $curr_store_id = 1;
          }
          $store_logo_url = '';
          $store_name = $this->session->userdata('store_name');
          if(!empty($curr_store_id)){
            $q_store = $this->db->select("store_name, store_logo")->where("id", $curr_store_id)->get("db_store");
            if($q_store->num_rows() > 0) {
              $s_row = $q_store->row();
              if(!empty($s_row->store_name)) {
                $store_name = $s_row->store_name;
              }
              $s_logo = $s_row->store_logo;
              if(!empty($s_logo) && file_exists(FCPATH . $s_logo)) {
                $store_logo_url = base_url($s_logo);
              } else if(!empty($s_logo) && file_exists(FCPATH . 'uploads/store/' . $s_logo)) {
                $store_logo_url = base_url('uploads/store/' . $s_logo);
              }
            }
          }
          if(empty($store_logo_url) && file_exists(FCPATH . 'uploads/store/company_logo.png')){
            $store_logo_url = base_url('uploads/store/company_logo.png');
          }
        ?>
        <div class="navbar-header" style="display:flex; align-items:center;">
          <a href="<?php echo $base_url; ?>dashboard" class="navbar-brand pos-navbar-brand" title="Go to Dashboard!">
            <?php if(!empty($store_logo_url)) { ?>
              <img src="<?= $store_logo_url; ?>" alt="Store Logo" class="pos-store-logo">
            <?php } ?>
            <b class="hidden-xs pos-store-title"><?= html_escape($store_name); ?></b>
            <b class="hidden-lg hidden-md hidden-sm">POS</b>
          </a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <?php if($CI->permissions('sales_view')) { ?>
            <li class=""><a href="<?php echo $base_url; ?>sales" title="View Sales List!"><i class="fa fa-list text-yellow" ></i> <span><?= $this->lang->line('sales_list'); ?></span></a></li>
            <?php } ?>
            
            <?php if($CI->permissions('customers_view')) { ?>
            <li class=""><a href="<?php echo $base_url; ?>customers/" title="View Customers List"><i class="fa  fa-group  text-yellow " ></i> <span><?= $this->lang->line('customers_list'); ?></span></a></li>
            <?php } ?>
            <?php if($CI->permissions('items_view')) { ?>
            <li class=""><a href="<?php echo $base_url; ?>items/" title="View Items List"><i class="fa  fa-cubes text-yellow " ></i> <span><?= $this->lang->line('items_list'); ?></span></a></li>
            <?php } ?>
            <?php if($CI->permissions('sales_add')) { ?>
            <li class=""><a href="<?php echo $base_url; ?>pos" title="Create New POS Invoice"><i class="fa fa-calculator text-yellow " ></i> <span><?= $this->lang->line('new_invoice'); ?></span></a></li>
            <?php } ?>
          </ul>
        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Click To View Hold Invoices">
             
              <span class=""><?= $this->lang->line('hold_list'); ?></span>
              <span class="label label-danger hold_invoice_list_count"><?=$tot_count?></span>
            </a>

            <ul class="dropdown-menu dropdown-width-lg">
              
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-12 text-center " style="max-height:300px;overflow-y: scroll;">
                    <table class="table table-bordered" width="100%">
                      <thead>
                      <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Ref.ID</th>
                        <th>Action</th>
                      </tr>
                      </thead>
                      <tbody id="hold_invoice_list" >
                       <?=$result?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- /.row -->
              <!--</li>-->
            </ul>
          </li>

            <!-- Messages: style can be found in dropdown.less-->
            <li class="hidden-xs" id="fullscreen"><a title="Fullscreen On/Off"><i class="fa fa-tv text-muted" ></i> </a></li>
            <li class="text-center" id="">
            <a title="Dashboard" href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard text-yellow" ></i><b class="hidden-xs"><?= $this->lang->line('dashboard'); ?></b></a>
          </li>

            <!-- User Account Menu (Matches Dashboard Design) -->
            <?php
              $header_uid = $this->session->userdata('inv_userid');
              $header_user = get_user_details($header_uid);
              $header_full_name = (!empty($header_user)) ? trim(($header_user->first_name ?? '') . ' ' . ($header_user->last_name ?? '')) : '';
              if(empty($header_full_name)){
                $header_full_name = $this->session->userdata('full_name') ?: $this->session->userdata('inv_username');
              }
              $header_username = (!empty($header_user) && !empty($header_user->username)) ? $header_user->username : $this->session->userdata('inv_username');
              $header_designation = ($header_uid == 1 || is_admin()) ? 'Super Admin' : (!empty($this->session->userdata('role_name')) ? $this->session->userdata('role_name') : 'Store Admin');
              $header_profile_pic = get_profile_picture();
            ?>
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="display:inline-flex; align-items:center; height:50px; padding:0 12px;">
                <img src="<?php echo $header_profile_pic; ?>" class="user-image" alt="User Image" style="float:none; margin:0 8px 0 0; width:30px; height:30px; border-radius:50%; object-fit:cover;">
                <span class="hidden-xs" style="font-weight:600; font-size:13.5px;"><?php echo htmlspecialchars($header_full_name); ?></span>
              </a>

              <ul class="dropdown-menu" style="width:280px; border-radius:12px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.18); border:1px solid #e2e8f0; padding:0;">
                <!-- User header -->
                <li class="user-header" style="height:auto; min-height:190px; padding:20px 16px 16px; background:linear-gradient(135deg, #1e293b 0%, #0f172a 100%); text-align:center; color:#ffffff;">
                  <div style="position:relative; display:inline-block; margin-bottom:10px;">
                    <img src="<?php echo $header_profile_pic; ?>" class="img-circle" alt="User Image" style="width:72px; height:72px; object-fit:cover; border:3px solid rgba(255,255,255,0.9); box-shadow:0 4px 12px rgba(0,0,0,0.3);">
                    <span style="position:absolute; bottom:2px; right:2px; width:13px; height:13px; background:#22c55e; border:2px solid #0f172a; border-radius:50%;" title="Online"></span>
                  </div>

                  <h4 style="margin:0 0 3px 0; font-weight:800; font-size:16px; color:#ffffff;">
                    <?php echo htmlspecialchars($header_full_name); ?>
                  </h4>

                  <div style="font-size:12px; color:#94a3b8; margin-bottom:8px; font-weight:500;">
                    <i class="fa fa-user-o" style="font-size:11px;"></i> <?php echo htmlspecialchars($header_username); ?>
                  </div>

                  <div style="display:flex; justify-content:center; align-items:center; gap:6px; flex-wrap:wrap;">
                    <span style="background:rgba(14,165,233,0.22); color:#38bdf8; border:1px solid rgba(56,189,248,0.4); font-size:11px; font-weight:700; padding:3px 10px; border-radius:20px; display:inline-flex; align-items:center; gap:4px;">
                      <i class="fa fa-id-badge"></i> <?php echo htmlspecialchars($header_designation); ?>
                    </span>
                    <span style="background:rgba(255,255,255,0.1); color:#cbd5e1; font-size:11px; font-weight:600; padding:3px 8px; border-radius:20px;">
                      Year <?=date("Y");?>
                    </span>
                  </div>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer" style="background:#f8fafc; border-top:1px solid #e2e8f0; padding:14px 18px;">
                  <div style="display:flex; justify-content:space-between; align-items:center; width:100%;">
                    <a href="<?php echo $base_url; ?>users/edit/<?= $header_uid; ?>" class="btn" style="background:linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color:#ffffff !important; font-weight:700; font-size:13px; border-radius:6px; border:0; padding:7px 18px; box-shadow:0 2px 6px rgba(2,132,199,0.35); text-decoration:none;">
                      <i class="fa fa-user"></i> Profile
                    </a>
                    <a href="<?php echo $base_url; ?>logout" class="btn" style="background:linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color:#ffffff !important; font-weight:700; font-size:13px; border-radius:6px; border:0; padding:7px 18px; box-shadow:0 2px 6px rgba(239,68,68,0.35); text-decoration:none;">
                      <i class="fa fa-sign-out"></i> Sign out
                    </a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>

  <?php $css = ($this->session->userdata('language')=='Arabic' || $this->session->userdata('language')=='Urdu') ? 'margin-right: 0 !important;': '';?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="<?=$css;?>">
    <!-- Content Header (Page header) -->
   <!--  <section class="content-header">
      <h1>
        General Form Elements
        <small>Preview</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">General Elements</li>
      </ol>
    </section> -->

    <!-- **********************MODALS***************** -->
    <?php include"modals/modal_customer.php"; ?>
    <?php include"modals/modal_sales_item.php"; ?>
    <?php include"modals/modal_item.php"; ?>
    <?php include"modals/modal_item_or_service.php"; ?>
    <?php include"modals/modal_pos_serial.php"; ?>
    
    <?php /*include"modals/modal_service.php";*/ ?>

    
    <!-- **********************MODALS END***************** -->
    <!-- Main content -->
    <section class="content">
      <!-- Mobile / Tablet Segmented Switcher -->
      <div class="pos-mobile-tabs hidden-lg hidden-md">
        <button type="button" class="pos-mobile-tab-btn active" id="btn_pos_tab_cart" onclick="switch_pos_mobile_tab('cart'); return false;">
          <i class="fa fa-shopping-cart"></i> Cart / Bill
        </button>
        <button type="button" class="pos-mobile-tab-btn" id="btn_pos_tab_products" onclick="switch_pos_mobile_tab('products'); return false;">
          <i class="fa fa-th-large"></i> Products Catalog
        </button>
      </div>

      <div class="row">
        <!-- left column -->
        <div class="col-md-7 col-xs-12" id="pos-left-panel" style="transition: all 0.3s ease;">
         
          <!-- general form elements -->
          <div class="box box-primary">
            <!-- form start -->
            <form class="form-horizontal" id="pos-form" >
            
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
              <input type="hidden" value='0' id="hidden_rowcount" name="hidden_rowcount">
              <input type="hidden" value='' id="hidden_invoice_id" name="hidden_invoice_id">
              <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
              <input type="hidden" class="scroll_or_not" value="true">

              
              <input type="hidden" value='' id="walk_in_customer_name" value="<?=get_walk_in_customer_name();?>">
              
              <!-- **********************MODALS***************** -->
             <?php include"modals_pos_payment/modal_payments_multi.php"; ?>

             <?php include"modals/modal_terms.php"; ?>

              <!-- **********************MODALS END***************** -->
              <!-- **********************MODALS***************** -->
              <div class="modal fade" id="discount-modal" tabindex='-1'>
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Set Discount</h4>
                    </div>
                    <div class="modal-body">
                      
                        <div class="row">
                          <div class="col-md-6">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="discount_input">Discount</label>
                                <input type="text" class="form-control" id="discount_input" name="discount_input" placeholder="" value="0">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="discount_type">Discount Type</label>
                                <select class="form-control" id='discount_type' name="discount_type">
                                  <option value='in_percentage'>Per%</option>
                                  <option value='in_fixed'>Fixed</option>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                     
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary discount_update">Update</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->
              <!-- **********************MODALS END***************** -->
              <div class="box-body">                
              <!-- Store Code -->
              <?php $store_id=''; ?>
            <?php 
             /*if(store_module() && is_admin()) {$this->load->view('store/store_code',array('show_store_select_box_2'=>true,'store_id'=>$store_id)); }else{*/
                echo "<input type='hidden' name='store_id' id='store_id' value='".get_current_store_id()."'>";
              /*}*/
              ?>
            <!-- Store Code end -->


              <!-- Show Products Catalog Button when catalog is hidden -->
              <div id="pos-left-unhide-btn" style="display:none; margin-bottom: 8px; text-align: right;">
                <button type="button" onclick="toggle_pos_product_catalog('show'); return false;" class="btn btn-xs" style="background:#008080; color:#fff; font-weight:700; border-radius:4px; padding:4px 12px; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
                  <i class="fa fa-th-large"></i> Show Products Catalog
                </button>
              </div>

              <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="input-group" data-toggle="tooltip" title="Warehouse">
                    <span class="input-group-addon" ><i class="fa fa-building text-red"></i></span>
                     <select class="form-control select2" id="warehouse_id" name="warehouse_id"  style="width: 100%;"  >
                          <?= get_warehouse_select_list($warehouse_id,get_current_store_id()); ?>
                      </select>
                   
                  </div>
                  
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6">
                  <div class="input-group" data-toggle="tooltip" title="Invoice Initial Code">
                    <span class="input-group-addon"><i class="fa fa-th-list"></i></span>
                     <input type="text" class="form-control" placeholder="Invioce Initial Code" id="init_code" name="init_code" value="<?= $init_code ?>">
                  </div>
                </div> 
                <div class="col-md-2 col-sm-2 col-xs-6">
                     <input type="text" class="form-control" data-toggle="tooltip" title="Invoice Count ID" placeholder="Invioce Number" id="count_id" name="count_id" value="<?= $count_id ?>">
                </div> 

              </div><!-- row end -->
              <div style="height: 6px;"></div>

              <div class="row">
                <div class="col-md-6">
                  <div class="input-group" data-toggle="tooltip" title="Customer">
                    <span class="input-group-addon" ><i class="fa fa-user"></i></span>
                     <select class="form-control select2" id="customer_id" name="customer_id"  style="width: 100%;"  >
                      </select>
                    <span class="input-group-addon pointer" data-toggle="modal" data-target="#customer-modal" title="New Customer?"><i class="fa fa-user-plus text-primary fa-lg"></i></span>
                  </div>
                    <span class="customer_points text-success" style="display: none;"></span>
                    <lable><?= $this->lang->line('previous_due'); ?> :<label class="customer_previous_due text-red" style="font-size: 18px;"><?=store_number_format(0)?></label></lable>
                  
                  
                </div>
                <div class="col-md-6">
                  <div class="input-group" data-toggle="tooltip" title="Select Items">
                    <span class="input-group-addon" ><i class="fa fa-barcode"></i></span>
                     <input type="text" class="form-control" placeholder="Item name/Barcode/Itemcode" id="item_search">
                     <span class="input-group-addon pointer show_item_service" title="New Item?"><i class="fa fa-plus text-primary fa-lg"></i></span>
                  </div>
                </div>                
              </div><!-- row end -->
             
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <div class="col-sm-12" style="overflow-y:auto; overflow-x:auto; -webkit-overflow-scrolling: touch; min-height: 260px; max-height: 400px; border:1px solid #e2e8f0; border-radius:8px;" >
                      <table class="table table-condensed table-bordered  table-responsive items_table" style="">
                        <thead class="bg-gray">
                          <th width="26%" style="vertical-align:middle;"><?= $this->lang->line('item_name'); ?></th>
                          <th width="7%" class="text-center" style="vertical-align:middle;"><?= $this->lang->line('stock'); ?></th>
                          <th width="15%" class="text-center" style="vertical-align:middle;"><?= $this->lang->line('quantity'); ?></th>
                          <th width="12%" class="text-center" style="vertical-align:middle;"><?= $this->lang->line('price'); ?></th>
                          <th width="9%" class="text-center" style="vertical-align:middle;"><?= $this->lang->line('discount'); ?>(<?=$CI->currency()?>)</th>
                          <th width="9%" class="text-center" style="vertical-align:middle;"><?= $this->lang->line('tax'); ?></th>
                          <th width="18%" class="text-center" style="vertical-align:middle;"><?= $this->lang->line('subtotal'); ?></th>
                          <th width="4%" class="text-center" style="vertical-align:middle;"><i class="fa fa-close"></i></th>
                        </thead>
                        <tbody id="pos-form-tbody" style="font-size: 16px;font-weight: bold;overflow: scroll;">
                          <!-- body code -->
                        </tbody>        
                        <tfoot>
                          <!-- footer code -->
                        </tfoot>              
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                 <!-- SMS Sender while saving -->
                      <?php 
                         //Change Return
                          $send_sms_checkbox='disabled';
                          if($CI->is_sms_enabled()){
                            if(!isset($sales_id)){
                              $send_sms_checkbox='checked';  
                            }else{
                              $send_sms_checkbox='';
                            }
                          }

                    ?>
                   
                    <div class="col-xs-4 ">
                           <div class="checkbox icheck">
                            <label>
                              <input type="checkbox" <?=$send_sms_checkbox;?> class="form-control" id="send_sms" name="send_sms" > <label for="sales_discount" class=" control-label"><?= $this->lang->line('send_sms_to_customer'); ?>
                                <i class="hover-q " data-container="body" data-toggle="popover" data-placement="top" data-content="If checkbox is Disabled! You need to enable it from SMS -> SMS API <br><b>Note:<i>Walk-in Customer will not receive SMS!</i></b>" data-html="true" data-trigger="hover" data-original-title="" title="Do you wants to send SMS ?">
                                  <i class="fa fa-info-circle text-maroon text-black hover-q"></i>
                                </i>
                              </label>
                            </label>
                          </div>
                    </div> 
                    
                    <div class="col-md-6">
                        <label class="control-label pull-right hide div2 text-blue">
                          <?= $this->lang->line('couponApplied'); ?>: <span class="coupon_value">0.00 </span> <span class="coupon_type"></span>
                        </label>
                      </div>

                      <div class="col-md-2">
                      <label class="control-label pull-left text-blue pointer" toggle="tooltip" title="<?= $this->lang->line('edit_invoice_tc')?>" data-toggle="modal" data-target="#terms-modal">
                         <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> T&C
                        </label>
                    </div>
                </div>
           
              </div>
              <!-- /.box-body -->

              <div class="box-footer bg-gray">
                <div class="row">
                  <div class="col-xs-6 col-sm-3 col-md-3 text-right" style="margin-bottom: 5px;">
                          <label> <?= $this->lang->line('quantity'); ?>:</label><br>
                          <span class="text-bold tot_qty"></span>
                  </div>
                  <div class="col-xs-6 col-sm-3 col-md-3 text-right" style="margin-bottom: 5px;">
                          <label><?= $this->lang->line('total_amount'); ?>:</label><br>
                          <?= $CI->currency('<span style="font-size: 19px;" class="tot_amt text-bold"></span>');?>
                  </div>
                  <div class="col-xs-6 col-sm-3 col-md-3 text-right" style="margin-bottom: 5px;">
                          <label><?= $this->lang->line('total_discount'); ?>:<a class="fa fa-pencil-square-o cursor-pointer" data-toggle="modal" data-target="#discount-modal"></a></label><br>
                          <?= $CI->currency('<span style="font-size: 19px;" class="tot_disc text-bold"></span>');?>
                  </div>
                  <div class="col-xs-6 col-sm-3 col-md-3 text-right" style="margin-bottom: 5px;">
                          <label><?= $this->lang->line('grand_total'); ?>:</label><br>
                          <?= $CI->currency('<span style="font-size: 19px;" class="tot_grand text-bold"></span>');?>
                  </div>
                </div>
               
               <div class="row">
                
                  <?php if(isset($sales_id)){ $btn_id='update';$btn_name="Cash"; ?>
                    <input type="hidden" name="sales_id" id="sales_id" value="<?php echo $sales_id;?>"/>
                  <?php } else{ $btn_id='save';$btn_name="Cash";} ?>

                  <div class="col-md-12 text-right">

                    <div class="col-xs-6 col-sm-3 col-md-3" style="margin-bottom: 8px;">
                      <button type="button" id="hold_invoice" name="" class="btn bg-maroon btn-block btn-flat btn-lg btnhold" title="Hold Invoice [Alt+H]" tabindex="0" style="">
                      <i class="fa fa-hand-paper-o" aria-hidden="true"></i>
                       Hold
                    </button>
                    </div>
                    <div class="col-xs-6 col-sm-3 col-md-3" style="margin-bottom: 8px;">
                      <button type="button" id="show_payments_modal" name="" class="btn btn-primary btnhold btn-block btn-flat btn-lg show_payments_modal" title="Multiple Payments [Alt+M]" tabindex="0" style="">
                            <i class="fa fa-credit-card" aria-hidden="true"></i>
                             Multiple
                          </button>
                    </div>
                    <div class="col-xs-6 col-sm-3 col-md-3" style="margin-bottom: 8px;">
                      <button type="button" id="<?php echo "show_cash_modal";?>" name="" class="btn btnhold btn-success btn-block btn-flat btn-lg Alt_c" title="By Cash & Save [Alt+C]" tabindex="0" style="">
                            <i class="fa fa-money" aria-hidden="true"></i>
                             <?php echo $btn_name;?>
                          </button>
                    </div>

                    <div class="col-xs-6 col-sm-3 col-md-3" style="margin-bottom: 8px;">
                      <button type="button" id="pay_all" name="" class="btn bg-purple btnhold btn-block btn-flat btn-lg Alt_a" title="By Cash & Save [Alt+A]" tabindex="0" style="">
                            <i class="fa fa-money" aria-hidden="true"></i>
                             Pay All
                          </button>
                    </div>
                    

                          
                  </div>
                </div>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-5 col-xs-12" id="pos-right-panel" style="transition: all 0.3s ease;">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <!-- form start -->
            <div class="box-body">
                
              <!-- Clean Hide Button on Right-Side Product Bar -->
              <div class="row" style="margin-bottom: 6px;">
                <div class="col-xs-12 text-right">
                  <button type="button" onclick="toggle_pos_product_catalog('hide'); return false;" class="btn btn-default btn-xs" id="btn_hide_product_bar" style="background:#ffffff; border:1px solid #cbd5e1; border-radius:4px; font-weight:700; color:#dc2626; padding:2px 8px; font-size:12px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);" title="Hide Product Bar">
                    <i class="fa fa-chevron-right text-red"></i> Hide Products
                  </button>
                </div>
              </div>
                
              <div class="row">

                <div class="col-md-6">
                  <div class="input-group input-group-md">
                      <select class="form-control select2" id="category_id" name="category_id"  style="width: 100%;"  >
                        <option value="">-All Categories-</option>
                        <?= get_categories_select_list();  ?>
                      </select>
                          <span class="input-group-btn">
                            <button type="button" class="btn text-blue btn-flat reset_categories" title="Reset Categories" data-toggle="tooltip" data-placement="top">
                              <i class="fa fa-undo"></i>
                            </button>
                          </span>
                    </div>
                </div>


                <div class="col-md-6">
                  <div class="input-group input-group-md">
                      <select class="form-control select2" id="brand_id" name="brand_id"  style="width: 100%;"  >
                        <option value="">-All Brands-</option>
                        <?= get_brands_select_list();  ?>
                      </select>
                          <span class="input-group-btn">
                            <button type="button" class="btn text-blue btn-flat reset_brands" title="Reset Brand" data-toggle="tooltip" data-placement="top">
                              <i class="fa fa-undo"></i>
                            </button>
                          </span>
                    </div>
                </div>                

              </div><!-- row end -->

              <br>
              <div class="row">

                <div class="col-md-12">
                  <div class="input-group input-group-md">
                   
                      <input type="text" class="form-control" data-toggle="tooltip" title="Enter Item Name" placeholder="Item Name" id="item_name" name="item_name">

                          <span class="input-group-btn">
                            <button type="button" class="btn text-blue btn-flat reset_item_name" title="Reset Item Name" data-toggle="tooltip" data-placement="top">
                              <i class="fa fa-undo"></i>
                            </button>
                          </span>
                    </div>
                </div>               

              </div><!-- row end -->


             
              <div class="row">
                <div class="col-md-12">
                  <!-- <div class="form-group"> -->
                   <!--  <div class="col-sm-12"> -->
                      <!-- <style type="text/css">
                        
                      </style> -->
                     

                            <section class="content .sec_div" >
                              <div class="row search_div" style="overflow-y: scroll;min-height: 100px;height: 550px">
                              </div>
                              <h4 class='text-danger text-center error_div' style="display: none;">No More Records Found</h4>
                            </section>
                            <div class="ajax-load text-center" style="display:none;">
                                <button type="button" class="btn btn-default btn-lrg ajax" title="Ajax Request">
                                <i class="fa fa-spin fa-refresh"></i>&nbsp; Loading More Data
                              </button>
                              </div>
                      
                         
                    <!-- </div> -->
                  <!-- </div> -->
                </div>
              </div>
           
              </div>
              <!-- /.box-body -->

              
           
          </div>
          <!-- /.box -->
          
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include"footer.php";?>
</div>
<!-- ./wrapper -->

<!-- SOUND CODE -->
<?php include"comman/code_js_sound.php"; ?>
<!-- GENERAL CODE -->
<?php include"comman/code_js.php"; ?>

<!-- iCheck -->
<script src="<?php echo $theme_link; ?>plugins/iCheck/icheck.min.js"></script>

<script src="<?php echo $theme_link; ?>js/fullscreen.js"></script>
<script src="<?php echo $theme_link; ?>js/modals.js"></script>
<script src="<?php echo $theme_link; ?>js/modals/modal_item.js"></script>
<script src="<?php echo $theme_link; ?>js/ajaxselect/customer_select_ajax.js"></script>  

<!-- DROP DOWN -->
<script src="<?php echo $theme_link; ?>dist/js/bootstrap3-typeahead.min.js"></script>  
<!-- DROP DOWN END-->

<script type="text/javascript">
  
  var warehouse_module=false;
  <?php if(warehouse_module() && warehouse_count()>1){ ?> 
    warehouse_module=true;
  <?php } ?>

  var store_module=false;
  <?php if(store_module()){ ?> 
    store_module=true;
  <?php } ?>

</script>
<script src="<?php echo $theme_link; ?>js/pos.js"></script>
<script>

        //Customer Selection Box Search
         function getCustomerSelectionId() {
           return '#customer_id';
         }

         $(document).ready(function () {

            // var customer_id = "<?= (!empty($customer_id)) ? $customer_id : '';  ?>";

            // autoLoadFirstCustomer(customer_id);

         });
         //Customer Selection Box Search - END


    var base_url=$("#base_url").val();
    /*$("#store_id").on("change",function(){
      var store_id=$(this).val();
      $.post(base_url+"sales/get_customers_select_list",{store_id:store_id},function(result){
          $("#customer_id").html('').append(result).select2();
          <?php if(isset($sales_id) && empty($sales_id)){ ?>
            $(".items_table > tbody").empty();
          <?php } ?>
          final_total();
      });
    });*/

     $(".close_btn").on("click",function(){
       if(confirm('Are you sure you want to navigate away from this page?')){
           window.location='<?php echo $base_url; ?>dashboard';
         }
     });


  /*Warehouse*/
    $("#warehouse_id").on("change",function(){
      var warehouse_id=$(this).val();
      $(".items_table > tbody").empty();
      get_details(null,true);
      final_total();
    });
    /*Warehouse end*/

  //RIGHT SIT DIV:-> FILTER ITEM INTO THE ITEMS LIST
  function search_it(){
  
  /*var input = $("#search_it").val();
  var item_count=$(".search_div .search_item").length;
  var error_count=item_count;
  for(i=0; i<item_count; i++){
    console.log("item_count ->"+i+" =>"+$("#item_"+i).html());
    console.log($("#item_"+i).html().toUpperCase().indexOf(input.toUpperCase()));
    if($("#item_"+i).html().toUpperCase().indexOf(input.toUpperCase())>-1){
      console.log("found");
      $("#item_"+i).show();
      $("#item_parent_"+i).show();
    }
    else{
     console.log("not-found"); 
     $("#item_"+i).hide();
     $("#item_parent_"+i).hide();
     error_count--;
    }
    if(error_count==0){
      $(".error_div").show();
    }
    else{
      $(".error_div").hide();
    }
    
  }*/
  }




//LEFT SIDE: ON CLICK ITEM ADD TO INVOICE LIST
function addrow(id='',item_obj=''){

    var item_id = (item_obj=='') ? $('#div_'+id).attr('data-item-id') : item_obj.item_id; 
    var matched_serial = (item_obj!='' && item_obj.matched_serial) ? item_obj.matched_serial : '';

    //CHECK SAME ITEM ALREADY EXIST IN ITEMS TABLE 
    var item_check=check_same_item(item_id, matched_serial);
    if(!item_check){return false;}
    var rowcount        =$("#hidden_rowcount").val();//0,1,2...
    var item_name = (item_obj=='') ? $('#div_'+id).attr('data-item-name') : item_obj.item_name; 

    var stock   =(item_obj=='') ? $('#div_'+id).attr('data-item-available-qty') : item_obj.stock;
        stock     =(parseFloat(stock)).toFixed(2);

    var tax_type   =(item_obj=='') ? $('#div_'+id).attr('data-item-tax-type') : item_obj.tax_type;  
    var tax_id   =(item_obj=='') ? $('#div_'+id).attr('data-item-tax-id') : item_obj.tax_id;  
    var tax_value   =(item_obj=='') ? $('#div_'+id).attr('data-item-tax-value') : item_obj.tax;
    
    var tax_name   =(item_obj=='') ? $('#div_'+id).attr('data-item-tax-name'):item_obj.tax_name;  
    var tax_amt   =(item_obj=='') ? $('#div_'+id).attr('data-item-tax-amt') : item_obj.item_tax_amt; 
    var discount_type   =(item_obj=='') ? $('#div_'+id).attr('data-discount_type') :item_obj.discount_type; 
    var discount   =(item_obj=='') ? $('#div_'+id).attr('data-discount') : item_obj.discount; 
 
    var service_bit   =(item_obj=='') ? $('#div_'+id).attr('data-service_bit') : item_obj.service_bit; 

    var item_cost     =(item_obj=='') ? $('#div_'+id).attr('data-item-cost') : item_obj.purchase_price;  
    var sales_price     =(item_obj=='') ? $('#div_'+id).attr('data-item-sales-price') : item_obj.sales_price ; 
    var sales_price_temp=sales_price;
        sales_price     =to_Fixed(sales_price);

    var available_serials = (item_obj!='' && item_obj.available_serials) ? item_obj.available_serials : [];
    var initial_desc = '';
    if(matched_serial != ''){
      initial_desc = 'SN: ' + matched_serial;
    } else if(available_serials && available_serials.length > 0){
      initial_desc = 'SN: ' + available_serials[0];
    }

    var quantity        ='<div class="input-group input-group-sm" style="max-width:110px; margin:0 auto;"><span class="input-group-btn"><button onclick="decrement_qty('+item_id+','+rowcount+')" type="button" class="btn btn-default btn-flat" style="padding:2px 6px; height:28px;"><i class="fa fa-minus text-danger"></i></button></span>';
        quantity       +='<input type="text" value="'+format_qty(1)+'" class="form-control no-padding text-center" style="height:28px; font-weight:bold; font-size:13px;" onchange="item_qty_input('+item_id+','+rowcount+')" id="item_qty_'+item_id+'" name="item_qty_'+item_id+'">';
        quantity       +='<span class="input-group-btn"><button onclick="increment_qty('+item_id+','+rowcount+')" type="button" class="btn btn-default btn-flat" style="padding:2px 6px; height:28px;"><i class="fa fa-plus text-success"></i></button></span></div>';
    var sub_total       =(to_Fixed(1)*to_Fixed(sales_price));//Initial
    var remove_btn      ='<a class="fa fa-fw fa-trash-o text-red" style="cursor: pointer;font-size: 18px;" onclick="removerow('+rowcount+')" title="Delete Item?"></a>';

    var safe_serials_json = JSON.stringify(available_serials).replace(/"/g, '&quot;');
    var str=' <tr id="row_'+rowcount+'" data-row="0" data-item-id="'+item_id+'" data-available-serials="'+safe_serials_json+'">';/*item id*/
        str+='<td id="td_'+rowcount+'_0" style="vertical-align:middle;">';
        str+='  <a data-toggle="tooltip" title="Click to Change Tax" class="pointer" id="td_data_'+rowcount+'_0" onclick="show_sales_item_modal('+rowcount+')">'+ item_name     +'</a> <i onclick="show_sales_item_modal('+rowcount+')" class="fa fa-edit pointer text-primary"></i>';
        var show_badge = (initial_desc != '') ? 'block' : 'none';
        str+='  <div id="serial_badge_wrap_'+rowcount+'" style="display:'+show_badge+'; margin-top:3px;">';
        str+='    <span class="badge bg-green pointer" onclick="open_serial_picker('+rowcount+')" style="font-weight:600; font-size:10px; padding:3px 6px; white-space:normal; text-align:left; display:inline-block; max-width:220px;" title="Click to select or edit serial numbers">';
        str+='      <i class="fa fa-barcode"></i> <span id="serial_badge_text_'+rowcount+'">'+initial_desc+'</span> <i class="fa fa-pencil" style="font-size:9px; margin-left:3px;"></i>';
        str+='    </span>';
        str+='  </div>';
        str+='</td>';/* td_0_0 item name*/ 
        str+='<td id="td_'+rowcount+'_1" class="text-center" style="vertical-align:middle; font-weight:600;">'+ stock +'</td>';/* td_0_1 item available qty*/
        str+='<td id="td_'+rowcount+'_2" class="text-center" style="vertical-align:middle;">'+ quantity      +'</td>';/* td_0_2 item available qty*/
            info='<input id="sales_price_'+rowcount+'" onblur="set_to_original('+rowcount+','+item_cost+')" onkeyup="update_price('+rowcount+','+item_cost+')" name="sales_price_'+rowcount+'" type="text" class="form-control no-padding text-center" style="height:28px; font-weight:600; font-size:13px; text-align:center;" value="'+sales_price+'">';
        str+='<td id="td_'+rowcount+'_3" class="text-center" style="vertical-align:middle;">'+ info   +'</td>';/* td_0_3 item sales price*/

        /*Discount*/
         info='<input data-toggle="tooltip" title="Click to Change" onclick="show_sales_item_modal('+rowcount+')" id="item_discount_'+rowcount+'" readonly name="item_discount_'+rowcount+'" type="text" class="form-control no-padding text-center pointer" style="height:28px; font-weight:600; font-size:13px; text-align:center;" value="0">';
         
        str+='<td id="td_'+rowcount+'_6" class="text-center" style="vertical-align:middle;">'+ info   +'</td>';

        /*Tax amt*/
        str+='<td id="td_'+rowcount+'_11" class="text-center" style="vertical-align:middle;"><input data-toggle="tooltip" title="Click to Change" id="td_data_'+rowcount+'_11" onclick="show_sales_item_modal('+rowcount+')" name="td_data_'+rowcount+'_11" type="text" class="form-control no-padding pointer text-center" style="height:28px; font-weight:600; font-size:13px; text-align:center;" readonly value="'+tax_amt+'"></td>';

        str+='<td id="td_'+rowcount+'_4" class="text-center" style="vertical-align:middle;"><input data-toggle="tooltip" title="Total" id="td_data_'+rowcount+'_4" name="td_data_'+rowcount+'_4" type="text" class="form-control no-padding pointer text-center" style="height:28px; font-weight:bold; font-size:14px; background:#f8fafc; color:#0f172a; width:100%; border:1px solid #cbd5e1; text-align:center;" readonly value="'+to_Fixed(sub_total)+'"></td>';/* td_0_4 item sub_total */
        str+='<td id="td_'+rowcount+'_5" class="text-center" style="vertical-align:middle;">'+ remove_btn    +'</td>';/* td_0_5 item gst_amt */

        str+='<input type="hidden" name="tr_item_id_'+rowcount+'" id="tr_item_id_'+rowcount+'" value="'+item_id+'">';
        str+='<input type="hidden" id="tr_sales_price_temp_'+rowcount+'" name="tr_sales_price_temp_'+rowcount+'" value="'+sales_price_temp+'">';
        str+='<input type="hidden" id="tr_tax_type_'+rowcount+'" name="tr_tax_type_'+rowcount+'" value="'+tax_type+'">';
        str+='<input type="hidden" id="tr_tax_id_'+rowcount+'" name="tr_tax_id_'+rowcount+'" value="'+tax_id+'">';
        str+='<input type="hidden" id="tr_tax_value_'+rowcount+'" name="tr_tax_value_'+rowcount+'" value="'+tax_value+'">';
        str+='<input type="hidden" id="description_'+rowcount+'" name="description_'+rowcount+'" value="'+initial_desc+'">';
        str+='<input type="hidden" id="service_bit_'+rowcount+'" name="service_bit_'+rowcount+'" value="'+service_bit+'">';
        str+='<input id="item_discount_type_'+rowcount+'" name="item_discount_type_'+rowcount+'" type="hidden" value="'+discount_type+'">';
        str+='<input id="item_discount_input_'+rowcount+'" name="item_discount_input_'+rowcount+'" type="hidden" value="'+discount+'">';
        str+='</tr>';   

    //LEFT SIDE: ADD OR APPEND TO SALES INVOICE TERMINAL
    $('#pos-form-tbody').append(str);

    //LEFT SIDE: INCREMANT ROW COUNT
    $("#hidden_rowcount").val(parseFloat($("#hidden_rowcount").val())+1);
    failed.currentTime = 0;
    failed.play();
    //CALCULATE FINAL TOTAL AND OTHER OPERATIONS
    make_subtotal(item_id,rowcount);
}

function update_price(row_id,item_cost){
  make_subtotal($("#tr_item_id_"+row_id).val(),row_id);
}

function set_to_original(row_id,item_cost) {
  return true;
}

// Auto-sync serial numbers when item quantity changes
function auto_sync_serials_on_qty_change(rowcount, target_qty){
  var row = $("#row_" + rowcount);
  var raw_serials = row.attr('data-available-serials');
  if(!raw_serials) return;
  var available = [];
  try {
    available = JSON.parse(raw_serials);
  } catch(e) {
    available = [];
  }
  if(!available || available.length == 0) return;

  var curr_desc = ($("#description_" + rowcount).val() || '').trim();
  var clean = curr_desc.replace(/^SN:\s*/i, '');
  var curr_list = clean ? clean.split(/\s*,\s*/) : [];

  target_qty = parseInt(target_qty) || 0;
  if(curr_list.length < target_qty){
    for(var i = 0; i < available.length && curr_list.length < target_qty; i++){
      if(curr_list.indexOf(available[i]) === -1){
        curr_list.push(available[i]);
      }
    }
  } else if(curr_list.length > target_qty && target_qty > 0){
    curr_list = curr_list.slice(0, target_qty);
  }

  if(curr_list.length > 0){
    var new_desc = 'SN: ' + curr_list.join(', ');
    $("#description_" + rowcount).val(new_desc);
    $("#serial_badge_text_" + rowcount).text(new_desc);
    $("#serial_badge_wrap_" + rowcount).show();
  } else {
    $("#description_" + rowcount).val('');
    $("#serial_badge_wrap_" + rowcount).hide();
  }
}

// Open modal for serial number selection
function open_serial_picker(rowcount){
  var item_id = $("#tr_item_id_" + rowcount).val();
  var item_name = $("#td_data_" + rowcount + "_0").text().trim();
  var item_qty = parseFloat($("#item_qty_" + item_id).val()) || 1;
  var curr_desc = ($("#description_" + rowcount).val() || '').trim();
  var clean = curr_desc.replace(/^SN:\s*/i, '');
  var curr_selected = clean ? clean.split(/\s*,\s*/) : [];

  $("#pos_serial_row_id").val(rowcount);
  $("#pos_serial_item_id").val(item_id);
  $("#pos_serial_item_name").text(item_name);
  $("#pos_serial_target_qty").text(format_qty(item_qty));
  $("#pos_serial_manual_text").val(curr_selected.join(', '));
  $("#pos_serial_search_filter").val('');

  var row = $("#row_" + rowcount);
  var raw_serials = row.attr('data-available-serials');
  var available = [];
  try {
    available = JSON.parse(raw_serials);
  } catch(e) {
    available = [];
  }

  render_pos_serial_checkboxes(available, curr_selected);
  update_pos_serial_counts();

  $('#modal_pos_serial').modal('show');
}

function render_pos_serial_checkboxes(available, selected){
  var html = '';
  if(!available || available.length == 0){
    html = '<div class="text-muted text-center" style="padding:10px 0;"><i class="fa fa-info-circle"></i> No registered serial numbers found in stock. You can type custom serials below.</div>';
  } else {
    html = '<div class="row" style="margin:0;">';
    for(var i = 0; i < available.length; i++){
      var s = available[i];
      var is_chk = (selected.indexOf(s) !== -1) ? 'checked' : '';
      html += '<div class="col-xs-6 col-sm-4 pos-serial-col" data-serial="'+s.toLowerCase()+'" style="padding:4px 6px;">';
      html += '  <label style="font-weight:normal; cursor:pointer; width:100%; border:1px solid #e2e8f0; border-radius:4px; padding:4px 8px; margin:0; background:#f8fafc; font-size:12px; display:flex; align-items:center; gap:6px;">';
      html += '    <input type="checkbox" class="pos_serial_chk" value="'+s+'" '+is_chk+' onchange="pos_serial_chk_changed()" style="cursor:pointer; margin:0;">';
      html += '    <span style="font-family:monospace; font-weight:600; color:#0f172a; word-break:break-all;">'+s+'</span>';
      html += '  </label>';
      html += '</div>';
    }
    html += '</div>';
  }
  $("#pos_serial_checkbox_container").html(html);
}

function pos_serial_chk_changed(){
  var selected = [];
  $(".pos_serial_chk:checked").each(function(){
    selected.push($(this).val());
  });
  $("#pos_serial_manual_text").val(selected.join(', '));
  update_pos_serial_counts();
}

function update_pos_serial_counts(){
  var raw = $("#pos_serial_manual_text").val().trim();
  var list = raw ? raw.split(/[\r\n,]+/) : [];
  var valid_count = 0;
  for(var i = 0; i < list.length; i++){
    if(list[i].trim() != '') valid_count++;
  }
  $("#pos_serial_selected_count").text(valid_count);

  var target = parseFloat($("#pos_serial_target_qty").text()) || 0;
  if(valid_count == target){
    $("#pos_serial_selected_count").removeClass('text-danger text-warning').addClass('text-success');
  } else if(valid_count < target){
    $("#pos_serial_selected_count").removeClass('text-success text-warning').addClass('text-danger');
  } else {
    $("#pos_serial_selected_count").removeClass('text-success text-danger').addClass('text-warning');
  }
}

function pos_serial_auto_pick_first_n(){
  var target = parseInt($("#pos_serial_target_qty").text()) || 1;
  var count = 0;
  $(".pos_serial_chk").each(function(){
    if(count < target){
      $(this).prop('checked', true);
      count++;
    } else {
      $(this).prop('checked', false);
    }
  });
  pos_serial_chk_changed();
}

function pos_serial_clear_selection(){
  $(".pos_serial_chk").prop('checked', false);
  $("#pos_serial_manual_text").val('');
  update_pos_serial_counts();
}

function pos_serial_apply_selection(){
  var rowcount = $("#pos_serial_row_id").val();
  var item_id = $("#tr_item_id_" + rowcount).val();
  var raw = $("#pos_serial_manual_text").val().trim();
  var list = raw ? raw.split(/[\r\n,]+/) : [];
  var clean_list = [];
  for(var i = 0; i < list.length; i++){
    var s = list[i].trim();
    if(s && clean_list.indexOf(s) === -1){
      clean_list.push(s);
    }
  }

  if(clean_list.length > 0){
    var new_desc = 'SN: ' + clean_list.join(', ');
    $("#description_" + rowcount).val(new_desc);
    $("#serial_badge_text_" + rowcount).text(new_desc);
    $("#serial_badge_wrap_" + rowcount).show();
    // Auto sync quantity with number of selected serials
    if(item_id){
      $("#item_qty_" + item_id).val(format_qty(clean_list.length));
      make_subtotal(item_id, rowcount);
    }
  } else {
    $("#description_" + rowcount).val('');
    $("#serial_badge_wrap_" + rowcount).hide();
  }

  $('#modal_pos_serial').modal('hide');
  toastr["success"]("Serials updated for item!");
}

//INCREMENT ITEM
function increment_qty(item_id,rowcount){
  var service_bit=$("#service_bit_"+rowcount).val();
  var item_qty=$("#item_qty_"+item_id).val();
  var stock=$("#td_"+rowcount+"_1").html();
  if(service_bit==1 || parseFloat(item_qty)<parseFloat(stock)){
    item_qty=parseFloat(item_qty)+1;
    $("#item_qty_"+item_id).val(format_qty(item_qty));
    auto_sync_serials_on_qty_change(rowcount, item_qty);
  }
  make_subtotal(item_id,rowcount);
}
//DECREMENT ITEM
function decrement_qty(item_id,rowcount){
  var item_qty=$("#item_qty_"+item_id).val();
  if(item_qty<=1){
    $("#item_qty_"+item_id).val(format_qty(1));
    return;
  }
  item_qty=parseFloat(item_qty)-1;
  $("#item_qty_"+item_id).val(format_qty(item_qty));
  auto_sync_serials_on_qty_change(rowcount, item_qty);
  make_subtotal(item_id,rowcount);
}
//LEFT SIDE: IF ITEM QTY CHANGED MANUALLY
function item_qty_input(item_id,rowcount){
  var item_qty=$("#item_qty_"+item_id).val();
  var service_bit=$("#service_bit_"+rowcount).val();
  var stock=$("#td_"+rowcount+"_1").html();

  if(service_bit!=1){
    if(stock==0){
      toastr["warning"]("item Not Available in stock!");
    }
    if(parseFloat(item_qty)>parseFloat(stock)){
      $("#item_qty_"+item_id).val(format_qty(stock));
      toastr["warning"]("Oops! You have only "+stock+" items in Stock");
      item_qty = stock;
    }
    if(item_qty<=0){
      $("#item_qty_"+item_id).val(format_qty(1));
      toastr["warning"]("You must have at least one Quantity");
      item_qty = 1;
    }
  }

  auto_sync_serials_on_qty_change(rowcount, parseFloat(item_qty));
  make_subtotal(item_id,rowcount);
}

function zero_stock(){
  toastr["error"]("Out of Stock!");
  return;
}
//LEFT SIDE: REMOVE ROW 
function removerow(id){//id=Rowid  
    $("#row_"+id).remove();
    failed.currentTime = 0;
    failed.play();
    final_total();
}

//MAKE SUBTOTAL


function make_subtotal(item_id,rowcount){
  set_tax_value(rowcount);

   //Find the Tax type and Tax amount
   var tax_type = $("#tr_tax_type_"+rowcount).val();
   var tax_amount = $("#td_data_"+rowcount+"_11").val();

  var sales_price     =$("#sales_price_"+rowcount).val();
  //var gst_per         =$("#tr_item_per_"+rowcount).val();
  var item_qty        =$("#item_qty_"+item_id).val();

  var tot_sales_price =parseFloat(item_qty)*parseFloat(sales_price);
  //var gst_amt=(tot_sales_price * gst_per)/100;

  var subtotal        =parseFloat(tot_sales_price);
  /*Discounr*/
  var discount_amt    =$("#item_discount_"+rowcount).val();

  subtotal = (tax_type=='Inclusive') ? subtotal : parseFloat(subtotal) + parseFloat(tax_amount);

  subtotal -= parseFloat(discount_amt);
  
  $("#td_data_"+rowcount+"_4").val(to_Fixed(subtotal));
  final_total();
}


function calulate_discount(discount_input,discount_type,total){
  if(discount_type=='in_percentage'){
    return parseFloat((total*discount_input)/100);
  }
  else{//in_fixed
    return parseFloat(discount_input);
  }
}
//LEFT SIDE: FINAL TOTAL


function final_total(){
  var total=0;
  var item_qty=0;
  var rowcount=$("#hidden_rowcount").val();
  var discount_input=$("#discount_input").val();
  var discount_type=$("#discount_type").val();
  /*var other_charges=parseFloat($("#other_charges").val());
      other_charges = (isNaN(other_charges)) ? parseFloat(0) :other_charges;*/

  if($(".items_table tr").length>1){
    for(i=0;i<rowcount;i++){
      if(document.getElementById('tr_item_id_'+i)){
       // set_tax_value(i);
      //var tax_amt = parseFloat($("#td_data_"+i+"_11").val());
      item_id=$("#tr_item_id_"+i).val();
      
      total=parseFloat(total)+parseFloat($("#td_data_"+i+"_4").val());
      //console.log("==>total="+total);
      //console.log("==>tax_amt="+tax_amt);
     // total+=tax_amt;
      //console.log("==>total="+total);
      item_qty=parseFloat(item_qty)+parseFloat($("#item_qty_"+item_id).val());
      item_qty = format_qty(item_qty);
      }
    }//for end
  }//items_table
  
  //total+=other_charges;
  //total =round_off(total);
  
  var discount_amt=0;
  if(total>0){
    var discount_amt=calulate_discount(discount_input,discount_type,total);//return value 
  }

  var subtotal = total-discount_amt;

  var coupon_amt = discount_coupon_tot(subtotal);
      subtotal -=coupon_amt;
    
  set_total(item_qty,total,discount_amt,subtotal);
}
function set_total(tot_qty=0, tot_amt=0, tot_disc=0, tot_grand=0){
  $(".tot_qty   ").html(tot_qty);
  $(".tot_amt   ").html(to_Fixed(tot_amt));
  $(".tot_disc  ").html(to_Fixed(tot_disc));
  $(".tot_grand ").html(to_Fixed(round_off(tot_grand)));
}

//LEFT SIDE: FINAL TOTAL
function adjust_payments(){
  var total=0;
  var item_qty=parseFloat(0);
  var rowcount=$("#hidden_rowcount").val();
  var discount_input=$("#discount_input").val();
  var discount_type=$("#discount_type").val();
  //var discount_amt = parseFloat($(".tot_disc").html());

  if($(".items_table tr").length>1){
    for(i=0;i<rowcount;i++){
      if(document.getElementById('tr_item_id_'+i)){
      total=parseFloat(total)+parseFloat($("#td_data_"+i+"_4").val());
      item_id=$("#tr_item_id_"+i).val();

      row_wise_item_qty = get_float_type_data("#item_qty_"+item_id);

      item_qty+=row_wise_item_qty;

      }
    }//for end
  }//items_table


  //total =round_off(total);
  //Find customers payment

  var payments_row =get_id_value("payment_row_count");
  console.log("payments_row="+payments_row);
  var paid_amount =parseFloat(0);
  for (var i = 1; i <=payments_row; i++) {
    if(document.getElementById("amount_"+i)){
      var amount = parseFloat(get_id_value("amount_"+i));
          amount = isNaN(amount) ? 0 : amount;
          console.log("amount_"+i+"="+amount);
      paid_amount += amount;
    }
  }
  
  //RIGHT SIDE DIV
  var discount_amt=calulate_discount(discount_input,discount_type,total);//return value


  var change_return = 0;
  var subtotal = total-discount_amt;
  var coupon_amt = discount_coupon_tot(subtotal);
      subtotal -= coupon_amt;

  var balance = subtotal-paid_amount;

  if(balance < 0){
    //console.log("Negative");
    change_return = Math.abs(parseFloat(balance));
    balance = 0;
  }
  
  balance =round_off(balance);
  $(".sales_div_tot_qty").html(format_qty(item_qty));
  $(".sales_div_tot_amt").html((to_Fixed(total)));
  $(".sales_div_tot_discount").html((to_Fixed(discount_amt))); 
  $(".coupon_discount_div_amt").html((to_Fixed(coupon_amt))); 
  $("#coupon_discount_amt").val(coupon_amt); 
  $(".sales_div_tot_payble").html(round_off(subtotal)); 
  $(".sales_div_tot_paid").html(round_off(paid_amount));
  $(".sales_div_tot_balance ").html(round_off(balance)); 
  
  /**/
  $(".sales_div_change_return").html(to_Fixed(change_return)); 
  
}

$(document).ready(function(){
  get_coupon_details();
});
function check_same_item(item_id, matched_serial=''){

  if($(".items_table tr").length>1){
    var rowcount=$("#hidden_rowcount").val();
    for(i=0;i<rowcount;i++){
            if($("#tr_item_id_"+i).val()==item_id){
              if(matched_serial != ''){
                var curr_desc = ($("#description_"+i).val() || '').trim();
                var clean = curr_desc.replace(/^SN:\s*/i, '');
                var curr_list = clean ? clean.split(/\s*,\s*/) : [];
                if(curr_list.indexOf(matched_serial) !== -1){
                  toastr["warning"]("Serial '"+matched_serial+"' is already added in cart!");
                  return false;
                } else {
                  curr_list.push(matched_serial);
                  var new_desc = 'SN: ' + curr_list.join(', ');
                  $("#description_"+i).val(new_desc);
                  $("#serial_badge_text_"+i).text(new_desc);
                  $("#serial_badge_wrap_"+i).show();
                }
              }
              increment_qty(item_id,i);
              failed.currentTime = 0;
              failed.play();
              return false;
            }
      }//end for
  }
  return true;
}




$(document).ready(function(){
  
  $("#store_id").trigger('change');

  var customer_id = "<?= (!empty($customer_id)) ? $customer_id : '';  ?>";

  autoLoadFirstCustomer(customer_id);

  //FIRST TIME: LOAD
  //get_details();

  var first_div= parseFloat($(".content-wrapper").height());
  var second_div= parseFloat($("section").height());
  var items_table= parseFloat($(".items_table").height());
  $(".items_table").parent().css("height",(first_div-second_div)+items_table+230);/**/
  $(".search_div").height(((parseFloat(second_div)-parseFloat(items_table))>500) ? 500 : (second_div-items_table) );/**/
  $(".sec_div").height(((parseFloat(second_div)-parseFloat(items_table))>500) ? (parseFloat(second_div)-parseFloat(items_table)) : (second_div-items_table) );/**/

  



  //FIRST TIME: SET TOTAL ZERO
  set_total();

  //RIGHT DIV: FILTER INPUT BOX
 /* $("#search_it").on("keyup",function(){
    search_it();
  });*/

  //CATEGORY WISE ITEM FETCH FROM SERVER
  var show_only_searched=true;
  $("#category_id,#brand_id").on("change",function () {
      get_details(null,show_only_searched);
  });

  //DISCOUNT UPDATE
  $(".discount_update").on("click",function () {
      final_total();
      $('#discount-modal').modal('toggle');    
  });

  $("#item_name").on("keyup",function () {
      get_details(null,show_only_searched);
  });

  //RIGHT SIDE: CLEAR SEARCH BOX
 /* $(".show_all").on("click",function(){
    $("#search_it").val('').trigger("keyup");
    $("#category_id").val('').trigger("change");
  });*/

  //Reset Category & brand
  $(".reset_categories").on("click",function(){
      $("#category_id").val('').trigger("change");
  });
  $(".reset_brands").on("click",function(){
      $("#brand_id").val('').trigger("change");
  });
  $(".reset_item_name").on("click",function(){
      $("#item_name").val('');
      $("#brand_id").val('').trigger("change");
  });
  
  //UPDATE PROCESS START
 <?php if(isset($sales_id) && !empty($sales_id)){ ?>
    $("#store_id").attr('readonly',true);
    $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    $.get("<?php echo $base_url ?>pos/fetch_sales/<?php echo $sales_id ?>",{},function(result){
      console.log(result);

      result=result.split("<<<###>>>");
      $('#pos-form-tbody').append(result[0]);
      $('#discount_input').val(result[1]);
      $('#discount_type').val(result[2]);

      $('#invoice_terms').text(result[7]);
      /*if(store_module){
        $('#store_id').val(result[4]).select2();
      }
      else{*/
        $('#store_id').val(result[4]);
      /*}*/
      console.log("warehouse = "+result[5]);
      if(warehouse_module){
        $('#warehouse_id').val(result[5]).select2();
      }
      else{
        $('#warehouse_id').val(result[5]);
      }

      //$('#customer_id').val(result[3]).select2();
      //$("#customer_id").trigger("change");
      
      
      $("#hidden_rowcount").val(parseInt($(".items_table tr").length)-1);
      final_total();
      get_details();
      $(".overlay").remove();
      
      if(result[5]==1){
        $( "#binvoice" ).prop( "checked", true );
        $('#binvoice').parent('div').addClass('checked');
      }
    });
      //DISABLE THE HOLD BUTTON
      $("#hold_invoice,#show_cash_modal,#pay_all").attr('disabled',true).removeAttr('id');

 <?php } else{?>
  get_details();
 <?php } ?>
  //UPDATE PROCESS END


});//ready() end



//DATEPICKER INITIALIZATION
$('#order_date,#delivery_date,#cheque_date').datepicker({
      autoclose: true,
      format: 'dd-mm-yyyy',
      todayHighlight: true
    });
    $('#customer_dob,#birthday_person_dob').datepicker({
      calendarWeeks: true,
      todayHighlight: true,
      autoclose: true,
      format: 'dd-mm-yyyy',
      startView: 2
    });
    
    //Datemask dd-mm-yyyy
    //$("#customer_dob,#birthday_person_dob").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});

    //Timepicker
    /*$('.timepicker').timepicker({
      showInputs: false,
    });*/

    //Sale Items Modal Operations Start
    function show_sales_item_modal(row_id){
      $('#sales_item').modal('toggle');
      //$("#popup_tax_id").select2();

      //Find the item details
      var item_name = $("#td_data_"+row_id+"_0").html();
      var tax_type = $("#tr_tax_type_"+row_id).val();
      var tax_id = $("#tr_tax_id_"+row_id).val();
      var description = $("#description_"+row_id).val();

      /*Discount*/
      var item_discount_input = $("#item_discount_input_"+row_id).val();
      var item_discount_type = $("#item_discount_type_"+row_id).val();

      //Set to Popup
      $("#item_discount_input").val(item_discount_input);
      $("#item_discount_type").val(item_discount_type).select2();

      $("#popup_item_name").html(item_name);
      $("#popup_tax_type").val(tax_type).select2();
      $("#popup_tax_id").val(tax_id).select2();
      $("#popup_row_id").val(row_id);
      $("#popup_description").val(description);
    }

    function set_info(){
      var row_id = $("#popup_row_id").val();
      var tax_type = $("#popup_tax_type").val();
      var tax_id = $("#popup_tax_id").val();
      var description = $("#popup_description").val();
      var tax_name = ($('option:selected', "#popup_tax_id").attr('data-tax-value'));
      var tax = parseFloat($('option:selected', "#popup_tax_id").attr('data-tax'));

      /*Discounr*/
      var item_discount_input = $("#item_discount_input").val();
      var item_discount_type = $("#item_discount_type").val();

      //Set it into row 
      $("#item_discount_input_"+row_id).val(item_discount_input);
      $("#item_discount_type_"+row_id).val(item_discount_type);

      $("#tr_tax_type_"+row_id).val(tax_type);
      $("#tr_tax_id_"+row_id).val(tax_id);
      $("#description_"+row_id).val(description);
      if(description && description.trim() != ''){
        $("#serial_badge_text_"+row_id).text(description.trim());
        $("#serial_badge_wrap_"+row_id).show();
      } else {
        $("#serial_badge_wrap_"+row_id).hide();
      }
      $("#tr_tax_value_"+row_id).val(tax);//%
      //$("#td_data_"+row_id+"_12").html(tax_type+" "+tax_name);
      
      var item_id=$("#tr_item_id_"+row_id).val();
      make_subtotal(item_id,row_id);
      //calculate_tax(row_id);
      $('#sales_item').modal('toggle');
    }
    function set_tax_value(row_id){
      //get the sales price of the item
      var tax_type = $("#tr_tax_type_"+row_id).val();
      var tax = $("#tr_tax_value_"+row_id).val(); //%
      var item_id=$("#tr_item_id_"+row_id).val();
      var qty=($("#item_qty_"+item_id).val());
          qty = (isNaN(qty)) ? 0 :qty;

      var sales_price = parseFloat($("#sales_price_"+row_id).val());
          sales_price = (isNaN(sales_price)) ? 0 :sales_price;
          sales_price = sales_price * qty;

      /*Discount*/
      var item_discount_type = $("#item_discount_type_"+row_id).val();
      var item_discount_input = parseFloat($("#item_discount_input_"+row_id).val());
          item_discount_input = (isNaN(item_discount_input)) ? 0 :item_discount_input;
      
      //Calculate discount      
      var discount_amt=(item_discount_type=='Percentage') ? ((sales_price) * item_discount_input)/100 : (item_discount_input*qty);
     
      sales_price-=parseFloat(discount_amt);

      var tax_amount = (tax_type=='Inclusive') ? calculate_inclusive(sales_price,tax) : calculate_exclusive(sales_price,tax);
      
      $("#item_discount_"+row_id).val(to_Fixed(discount_amt));
      $("#td_data_"+row_id+"_11").val(to_Fixed(tax_amount));
    }
    //Sale Items Modal Operations End


</script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });

</script>
<script type="text/javascript">
  shortcut.add("Alt+m",function(e) {
        e.preventDefault();
        $(".show_payments_modal").trigger('click');
    },{
        'type':'keydown',
        'propagate':true,
        'target':document
      });

  shortcut.add("Alt+h",function(e) {
        e.preventDefault();
        $("#hold_invoice").trigger('click');
    },{
        'type':'keydown',
        'propagate':true,
        'target':document
      });
  shortcut.add("Alt+c",function(e) {
        e.preventDefault();
        $(".Alt_c").trigger('click');
    },{
        'type':'keydown',
        'propagate':true,
        'target':document
      });
  shortcut.add("Alt+a",function(e) {
        e.preventDefault();
        $(".Alt_a").trigger('click');
    },{
        'type':'keydown',
        'propagate':true,
        'target':document
      });

</script>

<script>

//Reset Tooltip
function reset_tooltip() {
  $('[data-toggle="tooltip"]').tooltip("destroy");
  $('[data-toggle="tooltip"]').tooltip(); // re-enabling 
}
$('.search_div').on('scroll', function() {
    if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {

      if($(".scroll_or_not").val()=="true"){

        //Scroll Restriction Enabled
        $(".scroll_or_not").val("false");
        //Ajax Loader
        $('.ajax-load').show();

        setTimeout(function() {
          //Ajax Request
          load_next_details();  
          //Scroll Restriction Disabled
          $(".scroll_or_not").val("true");
          //Ajax Loader End
          $('.ajax-load').hide();    
        }, 1000);
        
        
      }
      
    }
});

function load_next_details(){
  var last_id = $(".item_box:last").attr("data-item-id");
  get_details(last_id);
}



function get_details(last_id='',show_only_searched=false){

  warehouse_id = $("#warehouse_id").val();

  $.ajax({
      url: '<?php echo $base_url; ?>pos/get_details',
      type: "post",
      data:{
        last_id       : (!show_only_searched) ? last_id : '',
        customer_id   : $("#customer_id").val(),
        id            : $("#category_id").val(),
        store_id      : $("#store_id").val(),
        warehouse_id  : $("#warehouse_id").val(),
        item_name     : $("#item_name").val(),
        //search_it  : $("#search_it").val(),
        brand_id  : $("#brand_id").val(),

      },
      beforeSend: function(){
          $('.ajax-load').show();
      }
  }).done(function(data){
      $('.ajax-load').hide();
      
      if(data=='') {
        $(".error_div").show();
      }
      else{
        $(".error_div").hide();
      }


      if(show_only_searched){
        $(".search_div").html('');
      }
      $(".search_div").append(data);
      reset_tooltip();
  }).fail(function(jqXHR, ajaxOptions, thrownError){
      alert('server not responding...');
  });
}



// Collapsible POS Product Bar Logic
function toggle_pos_product_catalog(action) {
  var $left = $("#pos-left-panel");
  var $right = $("#pos-right-panel");
  var $leftUnhideBtn = $("#pos-left-unhide-btn");
  
  var is_visible = $right.is(":visible") && $right.css("display") !== "none";
  
  var do_hide;
  if (action === "hide" || action === true) {
    do_hide = true;
  } else if (action === "show" || action === false) {
    do_hide = false;
  } else {
    do_hide = is_visible;
  }

  if (do_hide) {
    $right.hide().css("display", "none");
    $left.removeClass("col-md-7").addClass("col-md-12");
    $leftUnhideBtn.show().css("display", "block");
    try { localStorage.setItem("pos_product_catalog_collapsed", "1"); } catch(e){}
  } else {
    $leftUnhideBtn.hide().css("display", "none");
    $left.removeClass("col-md-12").addClass("col-md-7");
    $right.show().css("display", "block");
    try { localStorage.setItem("pos_product_catalog_collapsed", "0"); } catch(e){}
  }
}

function switch_pos_mobile_tab(tab) {
  if (window.innerWidth >= 992) {
    $("#pos-left-panel").show();
    if (localStorage.getItem("pos_product_catalog_collapsed") !== "1") {
      $("#pos-right-panel").show();
    }
    return;
  }
  if (tab === 'cart') {
    $("#pos-left-panel").show();
    $("#pos-right-panel").hide();
    $("#btn_pos_tab_cart").addClass("active");
    $("#btn_pos_tab_products").removeClass("active");
  } else {
    $("#pos-left-panel").hide();
    $("#pos-right-panel").show();
    $("#btn_pos_tab_products").addClass("active");
    $("#btn_pos_tab_cart").removeClass("active");
  }
}

$(window).on("resize", function() {
  if (window.innerWidth >= 992) {
    $("#pos-left-panel").show();
    if (localStorage.getItem("pos_product_catalog_collapsed") !== "1") {
      $("#pos-right-panel").show();
    }
  } else {
    if ($("#btn_pos_tab_products").hasClass("active")) {
      $("#pos-left-panel").hide();
      $("#pos-right-panel").show();
    } else {
      $("#pos-left-panel").show();
      $("#pos-right-panel").hide();
    }
  }
});

$(document).ready(function() {
  try {
    var saved = localStorage.getItem("pos_product_catalog_collapsed");
    if (saved === "1" && window.innerWidth >= 992) {
      toggle_pos_product_catalog("hide");
    }
  } catch(e){}

  if (window.innerWidth < 992) {
    switch_pos_mobile_tab('cart');
  }
});

</script> 
</body>
</html>
