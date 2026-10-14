<!DOCTYPE html>
<html>
   <head>
      <!-- TABLES CSS CODE -->
      <?php include"comman/code_css.php"; ?>
      <!-- </copy> -->  
   </head>
   <body class="hold-transition skin-blue sidebar-mini">
      <div class="wrapper">
         <?php include"sidebar.php"; ?>
         <?php
            if(!isset($package_name)){
               $package_name=
               $description='';
               $total='';
               $payment_type='';
               $status='Active';
               
            }
            ?>
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <h1>
                  <?=$page_title;?>
                  <small>Add/Update Package</small>
               </h1>
               <ol class="breadcrumb">
                  <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                  <li><a href="<?php echo $base_url; ?>store/view"><?= $this->lang->line('store_list'); ?></a></li>
                  <li><a href="<?php echo $base_url; ?>subscribers/list/<?=$store_id?>"><?= $this->lang->line('my_subscription_list'); ?></a></li>
                  <li class="active"><?=$page_title;?></li>
               </ol>
            </section>
            <!-- Main content -->
            <section class="content">
               <div class="row">
                  <!-- ********** ALERT MESSAGE START******* -->
                  <?php include"comman/code_flashdata.php"; ?>
                  <!-- ********** ALERT MESSAGE END******* -->
                  <!-- right column -->
                  <div class="col-md-12">
                     <!-- Horizontal Form -->
                     <div class="box box-primary ">
                        <!-- form start -->
                        <?= form_open('#', array('class' => 'form-horizontal', 'id' => 'package-form', 'enctype'=>'multipart/form-data', 'method'=>'POST', 'accept-charset'=>'UTF-8', 'novalidate'=>'novalidate' ));?>
                        <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                        <div class="box-body">
                            <div class="row">
                              <div class="col-md-6 col-md-offset-3">
                                <div style="background:#f8fafc; border:1px solid #cbd5e1; border-radius:8px; padding:12px 18px; margin-bottom:15px; display:flex; justify-content:space-between; align-items:center;">
                                  <div>
                                    <span style="font-size:11px; text-transform:uppercase; font-weight:700; color:#64748b; display:block;">Target Store</span>
                                    <strong style="font-size:16px; color:#1e293b;"><?= isset($store_details->store_name) ? $store_details->store_name : 'Store #'.$store_id; ?></strong>
                                    <span style="font-size:12px; color:#64748b; margin-left:8px;">(Code: <?= isset($store_details->store_code) ? $store_details->store_code : '-'; ?>)</span>
                                  </div>
                                  <div>
                                    <?php if(isset($store_details->status) && $store_details->status == 1): ?>
                                      <span class="label label-success" style="font-size:11px; padding:4px 8px;">Active</span>
                                    <?php else: ?>
                                      <span class="label label-danger" style="font-size:11px; padding:4px 8px;">Locked / Inactive</span>
                                    <?php endif; ?>
                                  </div>
                                </div>
                                <input type="hidden" id="store_id" name="store_id" value="<?=$store_id?>">
                              </div>
                            </div>
                           <div class="row">
                              <div class="col-md-5">
                                 <div class="form-group">
                                    <label for="package_id" class="col-sm-4 control-label"><?= $this->lang->line('package'); ?><label class="text-danger">*</label></label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" id="package_id" name="package_id"  style="width: 100%;"  >
                                             <?= get_packages_select_list(isset($selected_package_id) ? $selected_package_id : '') ?>
                                          </select>
                                          <span id="package_id_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label for="category" class="col-sm-4 control-label"><?= $this->lang->line('category'); ?><label class="text-danger">*</label></label>
                                    <div class="col-sm-8">
                                       <select class="form-control select2" id="category" name="category"  style="width: 100%;"  >
                                             <option value="">Select</option>
                                          </select>
                                          <span id="category_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label for="package_count" class="col-sm-4 control-label"><?= $this->lang->line('package_count'); ?><label class="text-danger">*</label></label>
                                    <div class="col-sm-8">
                                       <select class="form-control select2" id="package_count" name="package_count"  style="width: 100%;"  >
                                             <?php
                                             for($i = 1; $i <= 12; $i++ ){
                                                echo "<option value='".$i."'>".$i."</option>";
                                             }
                                             ?>
                                          </select>
                                          <span id="package_count_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                                 
                                 <div class="form-group">
                                    <label for="description" class="col-sm-4 control-label"><?= $this->lang->line('description'); ?></label>
                                    <div class="col-sm-8">
                                       <textarea type="text" class="form-control" id="description" name="description" placeholder="" ><?php print $description; ?></textarea>
                                       <span id="description_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>

                                 <div class="form-group">
                                    <label for="total" class="col-sm-4 control-label"><?= $this->lang->line('total'); ?><label class="text-danger">*</label></label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control" id="total" name="total" placeholder="" value="<?php print $total; ?>" >
                                       <span id="total_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label for="payment_type" class="col-sm-4 control-label"><?= $this->lang->line('payment_type'); ?></label>
                                    <div class="col-sm-8">
                                       <input type="text" class="form-control" id="payment_type" name="payment_type" placeholder="e.g. Cash, Bank Transfer, bKash" value="<?php print $payment_type; ?>" >
                                       <span id="payment_type_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                 </div>

                                 <!-- Monthly Lock Day -->                                 <div class="form-group">                                    <label for="auto_lock_day" class="col-sm-4 control-label">                                      Monthly Auto-Lock Day <label class="text-danger">*</label>                                    </label>                                    <div class="col-sm-8">                                       <select class="form-control select2" id="auto_lock_day" name="auto_lock_day" style="width: 100%;" onchange="calculate_lock_date()">                                          <option value="0">❌ Disable Auto-Lock</option>                                          <?php                                           $current_lock_day = isset($store_details->auto_lock_day) && $store_details->auto_lock_day > 0 ? intval($store_details->auto_lock_day) : intval(date('j'));                                          for($i = 1; $i <= 31; $i++ ){                                             $sel = ($i == $current_lock_day) ? "selected" : "";                                             echo "<option value='".$i."' ".$sel.">Day ".$i." of every month</option>";                                          }                                          ?>                                       </select>                                       <small class="text-muted" style="display:block; margin-top:3px;">                                         The store will be automatically locked on this day each month if subscription is unpaid.                                       </small>                                    </div>                                 </div>                                 <!-- Next Lock Date -->                                 <div class="form-group" id="grp_lock_date">                                    <label for="auto_lock_date" class="col-sm-4 control-label">                                      Next Lock Date <label class="text-danger">*</label>                                    </label>                                    <div class="col-sm-8">                                       <input type="date" class="form-control" id="auto_lock_date" name="auto_lock_date" value="<?= isset($store_details->auto_lock_date) && !empty($store_details->auto_lock_date) ? $store_details->auto_lock_date : ''; ?>">                                       <small class="text-muted" style="display:block; margin-top:3px;">                                         Calculated automatically based on the selected day, or select manually.                                       </small>                                    </div>                                 </div>                                 <div class="form-group">                                    <div class="col-sm-8 col-sm-offset-4">                                       <div style="background:#ecfdf5; border:1px solid #a7f3d0; border-radius:6px; padding:8px 12px;">                                          <label style="margin:0; font-weight:600; color:#065f46; cursor:pointer;">                                             <input type="checkbox" id="activate_store" name="activate_store" value="1" checked style="margin-right:6px;">                                             Unlock & Activate Store Immediately                                          </label>                                       </div>                                    </div>                                 </div>                                 </div>


                                 <!-- <div class="form-group">
                                    <label for="status" class="col-sm-4 control-label"><?= $this->lang->line('status'); ?><label class="text-danger">*</label></label>
                                    <div class="col-sm-8">
                                       <select class="form-control select2" id="status" name="status"  style="width: 100%;"  >
                                             <option value="Active">Active</option>
                                             <option value="Inactive">Inactive</option>
                                          </select>
                                    </div>
                                 </div> -->
                                 
                                
                                 <!-- ########### -->
                              </div>
                           
                             
                           </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                           <div class="col-sm-8 col-sm-offset-2 text-center">
                              <!-- <div class="col-sm-4"></div> -->
                              <?php
                                 if($package_name!=""){
                                      $btn_name="Update";
                                      $btn_id="update";
                                      ?>
                              <input type="hidden" name="q_id" id="q_id" value="<?php echo $q_id;?>"/>
                              <?php
                                 }
                                           else{
                                               $btn_name="Save";
                                               $btn_id="save";
                                           }
                                 
                                           ?>
                              <div class="col-md-3 col-md-offset-3">
                                 <button type="button" id="<?php echo $btn_id;?>" class=" btn btn-block btn-success" title="Save Data"><?php echo $btn_name;?></button>
                              </div>
                              <div class="col-sm-3">
                                    <a href="<?=base_url('dashboard');?>">
                                    <button type="button" class="col-sm-3 btn btn-block btn-warning close_btn" title="Go Dashboard">Close</button>
                                    </a>
                                 </div>
                           </div>
                        </div>
                        <!-- /.box-footer -->
                        <?= form_close(); ?>
                     </div>
                     <!-- /.box -->
                  </div>
                  <!--/.col (right) -->
                  
               </div>
               <!-- /.row -->
            </section>
            <!-- /.content -->
         </div>
         <!-- /.content-wrapper -->
         <?php include"footer.php"; ?>
         <!-- Add the sidebar's background. This div must be placed
            immediately after the control sidebar -->
         <div class="control-sidebar-bg"></div>
      </div>
      <!-- ./wrapper -->
      <!-- SOUND CODE -->
      <?php include"comman/code_js_sound.php"; ?>
      <!-- TABLES CODE -->
      <?php include"comman/code_js.php"; ?>
      <script src="<?php echo $theme_link; ?>js/manual-subscription.js"></script>
      <script type="text/javascript">
        <?php if(isset($q_id)){ ?>
          $("#store_id").attr('readonly',true);
        <?php }?>
         // $("#status").val("<?=$status?>").select2();
      </script>
      <script type="text/javascript">
        var base_url=$("#base_url").val();
        var store_id=$("#store_id").val();

        $("#package_id").on("change",function(){
          load_category();
        });
        $(document).ready(function(){
          load_category();
        });
        $("#category,#package_count").on("change",function(){
          calculate_total();
        });

        function load_category(){
          var package_id = $("#package_id").val();
          if(!package_id){
              $("#category").html('<option value="">Select</option>').select2();
              return;
          }
          $.post(base_url+"subscribers/get_category",{package_id:package_id},function(json){
              var options='<option value="">Select</option>';
              json=$.parseJSON(json);
              var p_type = json.package_type;
              var monthly = parseFloat(json.monthly_price) || 0;
              var annual = parseFloat(json.annual_price) || 0;
              var trial_days = parseInt(json.trial_days) || 0;

              if(p_type == 'Trial'){
                  options += "<option data-amount='0' data-type='trial' value='trial'>Trial ("+trial_days+" Days) - 0.00</option>";
              } else if(p_type == 'Free'){
                  options += "<option data-amount='0' data-type='free' value='free'>Free Plan - 0.00</option>";
              } else {
                  if(monthly > 0 || (monthly == 0 && annual == 0)){
                      options += "<option data-amount='"+monthly+"' data-type='month' value='monthly_price'>"+monthly+" Monthly Price</option>";
                  }
                  if(annual > 0){
                      options += "<option data-amount='"+annual+"' data-type='year' value='annual_price'>"+annual+" Annual Price (12x)</option>";
                  }
              }
              $("#category").html('').append(options).select2();

              if($("#category option").length == 2){
                  $("#category").val($("#category option:eq(1)").val()).trigger('change');
              } else {
                  calculate_total();
              }
          });
        }

        function calculate_total(){
            var sel = $('option:selected', "#category");
            var package_amount = parseFloat(sel.attr('data-amount'));
            package_amount = (isNaN(package_amount)) ? 0 : package_amount;
            
            var package_count = parseFloat($("#package_count").val());
            package_count = (isNaN(package_count)) ? 1 : package_count;

            var total = package_amount * package_count;

            $("#total").val(to_Fixed(total));
        }

        function calculate_lock_date(){
            var day = parseInt($("#auto_lock_day").val());
            if(!day || day === 0){
                $("#grp_lock_date").slideUp();
                return;
            }
            $("#grp_lock_date").slideDown();

            var today = new Date();
            var curYear = today.getFullYear();
            var curMonth = today.getMonth(); // 0-indexed
            var curDay = today.getDate();

            var monthsToAdd = 1;
            var cat = $("#category").val();
            var pCount = parseInt($("#package_count").val()) || 1;
            if(cat === 'annual_price'){
                monthsToAdd = 12 * pCount;
            } else if(cat === 'monthly_price'){
                monthsToAdd = pCount;
            }

            var targetDate = new Date(curYear, curMonth + monthsToAdd, 1);
            var maxDays = new Date(targetDate.getFullYear(), targetDate.getMonth() + 1, 0).getDate();
            var finalDay = Math.min(day, maxDays);

            var y = targetDate.getFullYear();
            var m = targetDate.getMonth() + 1;
            var mStr = (m < 10 ? '0' : '') + m;
            var dStr = (finalDay < 10 ? '0' : '') + finalDay;
            var formatted = y + '-' + mStr + '-' + dStr;

            $("#auto_lock_date").val(formatted);
        }

        $("#auto_lock_day").on("change", function(){
            calculate_lock_date();
        });

        $(document).ready(function(){
            if(!$("#auto_lock_date").val()){
                calculate_lock_date();
            }
        });

      </script>
      <!-- Make sidebar menu hughlighter/selector -->
      <script>$(".store_list-active-li").addClass("active");</script>
 </body>
</html>
