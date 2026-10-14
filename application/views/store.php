<!DOCTYPE html>
<html>
   
   <head>
  <!-- TABLES CSS CODE -->
  <?php $this->load->view('comman/code_css.php');?>
  <!-- </copy> -->  
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo $theme_link; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  </head>

   <body class="hold-transition skin-blue sidebar-mini">
      <div class="wrapper">
         <?php $this->load->view('sidebar');?>
          <?php
              if(!isset($q_id)){
                
                $store_name=$logo=$currency_id=$currency_placement=$timezone=
                $date_format=$time_format=
                $round_off='';
                $mobile=$phone=$email=$country=$state=$city=
                $postcode=$address=$gst_no=$vat_no=
                $store_website=$pan_no=$bank_details=
                $sidebar_color=$sidebar_font_color=$sidebar_active_color=$sidebar_submenu_color=$sidebar_submenu_hover_color=
                $store_logo=
                $signature='';

                $decimals=2;
                $qty_decimals=2;
                $invoice_terms = '';
                $default_account_id='';
                
               
                
              }
          ?>

         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <h1>
                  <?= $page_title; ?>
               </h1>
               <ol class="breadcrumb">
                  <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                  <li class="active"><?= $page_title; ?></li>
               </ol>
            </section>
            
            <!-- Main content -->
  <?= form_open('#', array('class' => 'form-horizontal', 'id' => 'store-form', 'enctype'=>'multipart/form-data', 'method'=>'POST'));?>
            <section class="content">
               <div class="row">
                  <!-- ********** ALERT MESSAGE START******* -->
                <?php $this->load->view('comman/code_flashdata');?>
                  <!-- ********** ALERT MESSAGE END******* -->

                  <div class="col-md-12">
                     <!-- Custom Tabs -->
                     <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                           <li class="active"><a href="#tab_4" id='tab_4_btn' data-toggle="tab"><?= $this->lang->line('store'); ?></a></li>
                           <li><a href="#tab_1" id='tab_1_btn' data-toggle="tab"><?= $this->lang->line('system'); ?></a></li>
                           <?php if(!is_user()){?>
                           <li><a href="#tab_2" id='tab_2_btn' data-toggle="tab"><?= $this->lang->line('sales'); ?></a></li>
                           <li><a href="#tab_3" id='tab_3_btn' data-toggle="tab"><?= $this->lang->line('prefixes'); ?></a></li>
                          <?php }?>
                         <?php if(isset($q_id)){ ?>
                           <li><a href="#tab_backup" id='tab_backup_btn' data-toggle="tab"><i class="fa fa-database text-primary"></i> Backup & Restore</a></li>
                         <?php } ?>
                           
                        </ul>
                        <div class="tab-content">
                          <div class="tab-pane active" id="tab_4">
                              <div class="row">
                                 <!-- right column -->
                                 <div class="col-md-12">
                                    <!-- form start -->
                                       <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                                       <div class="box-body">
                                          <div class="row">
                                             <div class="col-md-5">
                                                <div class="form-group">
                                                   <label for="store_code" class="col-sm-4 control-label"><?= $this->lang->line('store_code'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="store_code" name="store_code" readonly=""  placeholder="" onkeyup="shift_cursor(event,'mobile')" value="<?php print $store_code; ?>" >
                                                      <span id="store_code_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                                <div class="form-group">
                                                   <label for="store_name" class="col-sm-4 control-label"><?= $this->lang->line('store_name'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="store_name" name="store_name" placeholder="" onkeyup="shift_cursor(event,'mobile')" value="<?php print $store_name; ?>" >
                                                      <span id="store_name_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                                <div class="form-group">
                                                   <label for="mobile" class="col-sm-4 control-label"><?= $this->lang->line('mobile'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control no_special_char_no_space" id="mobile" name="mobile" placeholder="" value="<?php print $mobile; ?>" onkeyup="shift_cursor(event,'email')" >
                                                      <span id="mobile_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                                <div class="form-group">
                                                   <label for="email" class="col-sm-4 control-label"><?= $this->lang->line('email'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="email" name="email" placeholder="" value="<?php print $email; ?>" onkeyup="shift_cursor(event,'phone')">
                                                      <span id="email_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                                <div class="form-group">
                                                   <label for="phone" class="col-sm-4 control-label"><?= $this->lang->line('phone'); ?></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control no_special_char_no_space" id="phone" name="phone" placeholder="" value="<?php print $phone; ?>" onkeyup="shift_cursor(event,'gst_no')" >
                                                      <span id="phone_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>

                                                <?php if(gst_number()){ ?>
                                                <div class="form-group">
                                                   <label for="gst_no" class="col-sm-4 control-label"><?= $this->lang->line('gst_number'); ?></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="gst_no" name="gst_no" placeholder="" value="<?php print $gst_no; ?>" onkeyup="shift_cursor(event,'vat_no')">
                                                      <span id="gstin_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                                <?php } ?>

                                                <?php if(vat_number()){ ?>
                                                <div class="form-group">
                                                   <label for="vat_no" class="col-sm-4 control-label"><?= $this->lang->line('vat_number'); ?></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="vat_no" name="vat_no" placeholder="" value="<?php print $vat_no; ?>" onkeyup="shift_cursor(event,'store_website')">
                                                      <span id="vat_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                                <?php } ?>
                                                <?php if(pan_number()){ ?>
                                                <div class="form-group">
                                                   <label for="pan_no" class="col-sm-4 control-label"><?= $this->lang->line('pan_number'); ?></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="pan_no" name="pan_no" placeholder="" value="<?php print $pan_no; ?>" onkeyup="shift_cursor(event,'store_website')">
                                                      <span id="pan_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                                <?php } ?>
                                                <div class="form-group">
                                                   <label for="store_website" class="col-sm-4 control-label"><?= $this->lang->line('store_website'); ?></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="store_website" name="store_website" placeholder="" value="<?php print $store_website; ?>" onkeyup="shift_cursor(event,'country')">
                                                      <span id="website_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>

                                                <?php
                                                //Signature Checkbox
                                                   $show_signature_checkbox ='';
                                                   if($show_signature==1){
                                                    $show_signature_checkbox='checked';
                                                   }
                                                ?>
                                                <div class="form-group">
                                                   <label for="show_signature" class="col-sm-4 control-label"><?= $this->lang->line('show_signature'); ?></label>
                                                   <div class="col-sm-8">
                                                      <input type="checkbox" <?=$show_signature_checkbox;?> class="form-control" id="show_signature" name="show_signature" >
                                                      <span id="show_signature_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                                <div class="form-group">

                                                   <label for="signature" class="col-sm-4 control-label"><?= $this->lang->line('signature'); ?></label>
                                                   <div class="col-sm-8">
                                                      <input type="file" id="signature" name="signature">
                                                      <span id="signature_msg" style="display:block;" class="text-danger">Max Width/Height: 1000px * 1000px & Size: 1024kb </span>
                                                   </div>

                                                </div>
                                                <?php 
                                                if(empty($signature)){
                                                  $signature = base_url('uploads/no_logo/noimage.png');
                                                }
                                                else{
                                                  $signature = base_url($signature);
                                                }
                                                ?>
                                                <div class="form-group">
                                                   <div class="col-sm-8 col-sm-offset-4">
                                                      <img class='img-responsive' style='border:3px solid #d2d6de;' src="<?=$signature;?>">
                                                   </div>
                                                </div>




                                                

<!-- ########### -->
                                             </div>
                                             <div class="col-md-5">
                                                <div class="form-group">
                                                   <label for="bank_details" class="col-sm-4 control-label"><?= $this->lang->line('bank_details'); ?></label>
                                                   <div class="col-sm-8">
                                                      <textarea type="text" class="form-control" id="bank_details" name="bank_details" placeholder="" ><?php print $bank_details; ?></textarea>
                                                      <span id="bank_details_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                                <div class="form-group">
                                                   <label for="country" class="col-sm-4 control-label"><?= $this->lang->line('country'); ?></label>
                                                   <div class="col-sm-8">
                                                      <select class="form-control select2" id="country" name="country"  style="width: 100%;" onkeyup="shift_cursor(event,'state')" value="<?php print $country; ?>">
                                                         <?php
                                                            $query1="select * from db_country where status=1";
                                                            $q1=$this->db->query($query1);
                                                            if($q1->num_rows($q1)>0)
                                                             {
                                                              //echo '<option value="">-Select-</option>'; 
                                                                 foreach($q1->result() as $res1)
                                                               {
                                                                 $selected = ($res1->country ==$country) ? 'selected' : '';
                                                                 echo "<option $selected value='".$res1->country."'>".$res1->country."</option>";
                                                               }
                                                             }
                                                             else
                                                             {
                                                                ?>
                                                         <option value="">No Records Found</option>
                                                         <?php
                                                            }
                                                            ?>
                                                      </select>
                                                      <span id="country_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                                <div class="form-group">
                                                   <label for="state" class="col-sm-4 control-label"><?= $this->lang->line('state'); ?></label>
                                                   <div class="col-sm-8">
                                                      <select class="form-control select2" id="state" name="state"  style="width: 100%;" onkeyup="shift_cursor(event,'city')">
                                                         <?php
                                                            $query2="select * from db_states where status=1";
                                                            $q2=$this->db->query($query2);
                                                            if($q2->num_rows()>0)
                                                             {
                                                              echo '<option value="">-Select-</option>'; 
                                                              foreach($q2->result() as $res1)
                                                               {
                                                                 $selected = ($res1->state ==$state) ? 'selected' : '';
                                                                 echo "<option $selected value='".$res1->state."'>".$res1->state."</option>";
                                                               }
                                                             }
                                                             else
                                                             {
                                                                ?>
                                                         <option value="">No Records Found</option>
                                                         <?php
                                                            }
                                                            ?>
                                                      </select>
                                                      <span id="state_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>

                                                <div class="form-group">
                                                   <label for="city" class="col-sm-4 control-label"><?= $this->lang->line('city'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="city" name="city" placeholder="" value="<?php print $city; ?>" onkeyup="shift_cursor(event,'postcode')" >
                                                      <span id="city_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                                <div class="form-group">
                                                   <label for="postcode" class="col-sm-4 control-label"><?= $this->lang->line('postcode'); ?></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control no_special_char_no_space" id="postcode" name="postcode" placeholder="" value="<?php print $postcode; ?>" onkeyup="shift_cursor(event,'address')">
                                                      <span id="postcode_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                                <div class="form-group">
                                                   <label for="address" class="col-sm-4 control-label"><?= $this->lang->line('address'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <textarea type="text" class="form-control" id="address" name="address" placeholder="" ><?php print $address; ?></textarea>
                                                      <span id="address_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                                <div class="form-group">
                                                   <label for="store_logo" class="col-sm-4 control-label"><?= $this->lang->line('store_logo'); ?></label>
                                                   <div class="col-sm-8">
                                                      <input type="file" id="store_logo" name="store_logo">
                                                      <span id="store_logo_msg" style="display:block;" class="text-danger">Max Width/Height: 1000px * 1000px & Size: 1024kb </span>
                                                   </div>
                                                </div>
                                                <?php 
                                                if(empty($store_logo)){
                                                  $logo = base_url('uploads/no_logo/nologo.png');
                                                }
                                                else{
                                                  $logo = base_url($store_logo);
                                                }
                                                ?>
                                                <div class="form-group">
                                                   <div class="col-sm-8 col-sm-offset-4">
                                                      <img class='img-responsive' style='border:3px solid #d2d6de;' src="<?=$logo;?>">
                                                   </div>
                                                 
                                             </div>
                                             <!-- ########### -->
                                          </div>
                                        </div>

<div class="row">
<!-- START: SIDEBAR & SUBMENU THEME CUSTOMIZER -->
<div class="col-md-12" style="margin-top: 15px; margin-bottom: 20px;">
   <div style="border: 1px solid #cbd5e1; border-radius: 10px; background: #ffffff; box-shadow: 0 2px 8px rgba(0,0,0,0.04); overflow: hidden;">
      <div style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: #ffffff; padding: 12px 18px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
         <div style="display:flex; align-items:center; gap:10px;">
            <i class="fa fa-paint-brush text-cyan" style="font-size:17px; color:#38bdf8;"></i>
            <h4 style="margin:0; font-size:15px; font-weight:700; letter-spacing:0.3px; color:#ffffff;">Sidebar & Submenu Appearance</h4>
         </div>
         <span style="font-size:11.5px; color:#94a3b8; font-weight:500;">Header, Sidebar, Submenu & Hover Controls</span>
      </div>

      <div style="padding: 18px 20px;">
         <div class="row">
            <!-- 1. Background Color -->
            <div class="col-md-4" style="border-right: 1px solid #f1f5f9; padding-right: 15px; margin-bottom: 15px;">
               <div class="form-group" style="margin-bottom: 10px;">
                  <label style="font-weight:700; font-size:13px; color:#1e293b; display:block; margin-bottom:6px;">
                     1. Sidebar Background Color <span style="font-size:11px; font-weight:normal; color:#64748b;">(Navigation background)</span>
                  </label>
                  <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                     <input type="color" id="sidebar_color_picker" value="<?php echo !empty($sidebar_color) ? $sidebar_color : '#ffffff'; ?>" style="width:44px; height:38px; padding:2px; border:1px solid #cbd5e1; border-radius:6px; cursor:pointer;" oninput="updateSidebarBg(this.value);">
                     <input type="text" class="form-control" id="sidebar_color" name="sidebar_color" value="<?php echo !empty($sidebar_color) ? $sidebar_color : '#ffffff'; ?>" style="width:125px; font-weight:700; text-transform:uppercase; font-size:13px;" oninput="updateSidebarBg(this.value);" placeholder="#ffffff">
                  </div>
                  <div style="font-size:11px; color:#64748b; margin-bottom:6px; font-weight:600;">Quick Presets:</div>
                  <div style="display:flex; gap:5px; flex-wrap:wrap;">
                     <button type="button" class="btn btn-xs" style="background:#ffffff; color:#111; border:1px solid #cbd5e1; font-weight:700;" onclick="updateSidebarBg('#ffffff')">White</button>
                     <button type="button" class="btn btn-xs" style="background:#0f172a; color:#fff;" onclick="updateSidebarBg('#0f172a')">Navy</button>
                     <button type="button" class="btn btn-xs" style="background:#1e293b; color:#fff;" onclick="updateSidebarBg('#1e293b')">Slate</button>
                     <button type="button" class="btn btn-xs" style="background:#1e3a8a; color:#fff;" onclick="updateSidebarBg('#1e3a8a')">Blue</button>
                     <button type="button" class="btn btn-xs" style="background:#064e3b; color:#fff;" onclick="updateSidebarBg('#064e3b')">Green</button>
                     <button type="button" class="btn btn-xs" style="background:#4c1d95; color:#fff;" onclick="updateSidebarBg('#4c1d95')">Purple</button>
                     <button type="button" class="btn btn-xs" style="background:#831843; color:#fff;" onclick="updateSidebarBg('#831843')">Wine</button>
                     <button type="button" class="btn btn-xs" style="background:#0a0a0a; color:#fff;" onclick="updateSidebarBg('#0a0a0a')">Black</button>
                  </div>
               </div>
            </div>

            <!-- 2. Font / Text Color -->
            <div class="col-md-4" style="border-right: 1px solid #f1f5f9; padding-right: 15px; margin-bottom: 15px;">
               <div class="form-group" style="margin-bottom: 10px;">
                  <label style="font-weight:700; font-size:13px; color:#1e293b; display:block; margin-bottom:6px;">
                     2. Menu Font Color <span style="font-size:11px; font-weight:normal; color:#64748b;">(Navigation text color)</span>
                  </label>
                  <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                     <input type="color" id="sidebar_font_color_picker" value="<?php echo !empty($sidebar_font_color) ? $sidebar_font_color : '#1e293b'; ?>" style="width:44px; height:38px; padding:2px; border:1px solid #cbd5e1; border-radius:6px; cursor:pointer;" oninput="updateSidebarFont(this.value);">
                     <input type="text" class="form-control" id="sidebar_font_color" name="sidebar_font_color" value="<?php echo !empty($sidebar_font_color) ? $sidebar_font_color : '#1e293b'; ?>" style="width:125px; font-weight:700; text-transform:uppercase; font-size:13px;" oninput="updateSidebarFont(this.value);" placeholder="#1e293b">
                  </div>
                  <div style="font-size:11px; color:#64748b; margin-bottom:6px; font-weight:600;">Quick Presets:</div>
                  <div style="display:flex; gap:5px; flex-wrap:wrap;">
                     <button type="button" class="btn btn-xs" style="background:#ffffff; color:#111; border:1px solid #cbd5e1; font-weight:700;" onclick="updateSidebarFont('#ffffff')">Pure White</button>
                     <button type="button" class="btn btn-xs" style="background:#f8fafc; color:#111; border:1px solid #cbd5e1; font-weight:700;" onclick="updateSidebarFont('#f8fafc')">Off White</button>
                     <button type="button" class="btn btn-xs" style="background:#1e293b; color:#fff;" onclick="updateSidebarFont('#1e293b')">Dark Slate</button>
                     <button type="button" class="btn btn-xs" style="background:#334155; color:#fff;" onclick="updateSidebarFont('#334155')">Charcoal</button>
                     <button type="button" class="btn btn-xs" style="background:#facc15; color:#111; font-weight:700;" onclick="updateSidebarFont('#facc15')">Amber</button>
                     <button type="button" class="btn btn-xs" style="background:#38bdf8; color:#111; font-weight:700;" onclick="updateSidebarFont('#38bdf8')">Cyan</button>
                     <button type="button" class="btn btn-xs" style="background:#4ade80; color:#111; font-weight:700;" onclick="updateSidebarFont('#4ade80')">Green</button>
                  </div>
               </div>
            </div>

            <!-- 3. Selector / Active Highlight Color -->
            <div class="col-md-4" style="margin-bottom: 15px;">
               <div class="form-group" style="margin-bottom: 10px;">
                  <label style="font-weight:700; font-size:13px; color:#1e293b; display:block; margin-bottom:6px;">
                     3. Main Active Color <span style="font-size:11px; font-weight:normal; color:#64748b;">(Active menu item highlight)</span>
                  </label>
                  <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                     <input type="color" id="sidebar_active_color_picker" value="<?php echo !empty($sidebar_active_color) ? $sidebar_active_color : '#0284c7'; ?>" style="width:44px; height:38px; padding:2px; border:1px solid #cbd5e1; border-radius:6px; cursor:pointer;" oninput="updateSidebarActive(this.value);">
                     <input type="text" class="form-control" id="sidebar_active_color" name="sidebar_active_color" value="<?php echo !empty($sidebar_active_color) ? $sidebar_active_color : '#0284c7'; ?>" style="width:125px; font-weight:700; text-transform:uppercase; font-size:13px;" oninput="updateSidebarActive(this.value);" placeholder="#0284c7">
                  </div>
                  <div style="font-size:11px; color:#64748b; margin-bottom:6px; font-weight:600;">Quick Presets:</div>
                  <div style="display:flex; gap:5px; flex-wrap:wrap;">
                     <button type="button" class="btn btn-xs" style="background:#0284c7; color:#fff;" onclick="updateSidebarActive('#0284c7')">Sky Blue</button>
                     <button type="button" class="btn btn-xs" style="background:#00c2cb; color:#fff;" onclick="updateSidebarActive('#00c2cb')">Cyan</button>
                     <button type="button" class="btn btn-xs" style="background:#ff6b00; color:#fff;" onclick="updateSidebarActive('#ff6b00')">Orange</button>
                     <button type="button" class="btn btn-xs" style="background:#10b981; color:#fff;" onclick="updateSidebarActive('#10b981')">Emerald</button>
                     <button type="button" class="btn btn-xs" style="background:#8b5cf6; color:#fff;" onclick="updateSidebarActive('#8b5cf6')">Purple</button>
                     <button type="button" class="btn btn-xs" style="background:#ec4899; color:#fff;" onclick="updateSidebarActive('#ec4899')">Pink</button>
                     <button type="button" class="btn btn-xs" style="background:#ef4444; color:#fff;" onclick="updateSidebarActive('#ef4444')">Red</button>
                  </div>
               </div>
            </div>
         </div>

         <!-- Row 2: Submenu Background & Submenu Hover / Pointer Color -->
         <div class="row" style="border-top: 1px dashed #e2e8f0; padding-top: 15px; margin-top: 5px;">
            <!-- 4. Submenu Background Color -->
            <div class="col-md-6" style="border-right: 1px solid #f1f5f9; padding-right: 15px; margin-bottom: 10px;">
               <div class="form-group" style="margin-bottom: 10px;">
                  <label style="font-weight:700; font-size:13px; color:#1e293b; display:block; margin-bottom:6px;">
                     4. Submenu Background Color <span style="font-size:11px; font-weight:normal; color:#64748b;">(Submenu dropdown background)</span>
                  </label>
                  <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                     <input type="color" id="sidebar_submenu_color_picker" value="<?php echo !empty($sidebar_submenu_color) ? $sidebar_submenu_color : '#0f172a'; ?>" style="width:44px; height:38px; padding:2px; border:1px solid #cbd5e1; border-radius:6px; cursor:pointer;" oninput="updateSidebarSubmenu(this.value);">
                     <input type="text" class="form-control" id="sidebar_submenu_color" name="sidebar_submenu_color" value="<?php echo !empty($sidebar_submenu_color) ? $sidebar_submenu_color : ''; ?>" style="width:140px; font-weight:700; text-transform:uppercase; font-size:13px;" oninput="updateSidebarSubmenu(this.value);" placeholder="e.g. #0F172A">
                  </div>
                  <div style="font-size:11px; color:#64748b; margin-bottom:6px; font-weight:600;">Quick Presets:</div>
                  <div style="display:flex; gap:5px; flex-wrap:wrap;">
                     <button type="button" class="btn btn-xs" style="background:#0f172a; color:#fff;" onclick="updateSidebarSubmenu('#0f172a')">Deep Navy</button>
                     <button type="button" class="btn btn-xs" style="background:#1e293b; color:#fff;" onclick="updateSidebarSubmenu('#1e293b')">Dark Slate</button>
                     <button type="button" class="btn btn-xs" style="background:#022c22; color:#fff;" onclick="updateSidebarSubmenu('#022c22')">Dark Pine</button>
                     <button type="button" class="btn btn-xs" style="background:#172554; color:#fff;" onclick="updateSidebarSubmenu('#172554')">Midnight Blue</button>
                     <button type="button" class="btn btn-xs" style="background:#2e1065; color:#fff;" onclick="updateSidebarSubmenu('#2e1065')">Dark Violet</button>
                     <button type="button" class="btn btn-xs" style="background:#f1f5f9; color:#111; border:1px solid #cbd5e1;" onclick="updateSidebarSubmenu('#f1f5f9')">Light Grey</button>
                     <button type="button" class="btn btn-xs" style="background:#ffffff; color:#111; border:1px solid #cbd5e1;" onclick="updateSidebarSubmenu('#ffffff')">Pure White</button>
                  </div>
               </div>
            </div>

            <!-- 5. Submenu Hover / Pointer Color -->
            <div class="col-md-6" style="margin-bottom: 10px;">
               <div class="form-group" style="margin-bottom: 10px;">
                  <label style="font-weight:700; font-size:13px; color:#1e293b; display:block; margin-bottom:6px;">
                     5. Submenu Hover / Pointer Color <span style="font-size:11px; font-weight:normal; color:#64748b;">(Submenu hover / active pointer color)</span>
                  </label>
                  <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                     <input type="color" id="sidebar_submenu_hover_color_picker" value="<?php echo !empty($sidebar_submenu_hover_color) ? $sidebar_submenu_hover_color : '#0284c7'; ?>" style="width:44px; height:38px; padding:2px; border:1px solid #cbd5e1; border-radius:6px; cursor:pointer;" oninput="updateSidebarSubmenuHover(this.value);">
                     <input type="text" class="form-control" id="sidebar_submenu_hover_color" name="sidebar_submenu_hover_color" value="<?php echo !empty($sidebar_submenu_hover_color) ? $sidebar_submenu_hover_color : ''; ?>" style="width:140px; font-weight:700; text-transform:uppercase; font-size:13px;" oninput="updateSidebarSubmenuHover(this.value);" placeholder="e.g. #0284C7">
                  </div>
                  <div style="font-size:11px; color:#64748b; margin-bottom:6px; font-weight:600;">Quick Presets:</div>
                  <div style="display:flex; gap:5px; flex-wrap:wrap;">
                     <button type="button" class="btn btn-xs" style="background:#38bdf8; color:#111; font-weight:700;" onclick="updateSidebarSubmenuHover('#38bdf8')">Sky Cyan</button>
                     <button type="button" class="btn btn-xs" style="background:#4ade80; color:#111; font-weight:700;" onclick="updateSidebarSubmenuHover('#4ade80')">Mint Green</button>
                     <button type="button" class="btn btn-xs" style="background:#fbbf24; color:#111; font-weight:700;" onclick="updateSidebarSubmenuHover('#fbbf24')">Bright Amber</button>
                     <button type="button" class="btn btn-xs" style="background:#0284c7; color:#fff;" onclick="updateSidebarSubmenuHover('#0284c7')">Sky Blue</button>
                     <button type="button" class="btn btn-xs" style="background:#ff6b00; color:#fff;" onclick="updateSidebarSubmenuHover('#ff6b00')">Orange</button>
                     <button type="button" class="btn btn-xs" style="background:#a855f7; color:#fff;" onclick="updateSidebarSubmenuHover('#a855f7')">Purple</button>
                     <button type="button" class="btn btn-xs" style="background:#f43f5e; color:#fff;" onclick="updateSidebarSubmenuHover('#f43f5e')">Rose</button>
                  </div>
               </div>
            </div>
         </div>

         <!-- Live Preview Box -->
         <div style="margin-top: 15px; padding: 14px 18px; border-radius: 8px; border: 1px solid #cbd5e1; transition: all 0.2s ease;" id="sb_live_preview_box">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px; border-bottom:1px dashed rgba(128,128,128,0.25); padding-bottom:8px;">
               <div style="display:flex; align-items:center; gap:8px;">
                  <i class="fa fa-eye" style="font-size:15px;" id="sb_preview_eye"></i>
                  <span style="font-weight:700; font-size:12px; text-transform:uppercase; letter-spacing:0.6px;" id="sb_preview_heading">Live Interactive Preview:</span>
               </div>
               <span style="font-size:11px; color:#94a3b8;">Move your mouse over the submenu to preview hover</span>
            </div>

            <div style="display:flex; align-items:flex-start; gap:16px; flex-wrap:wrap;">
               <!-- Shop Name preview (Top seamless header) -->
               <div style="padding: 9px 18px; border-radius: 6px; font-weight: 700; font-size: 13.5px; display: inline-flex; align-items: center; gap: 8px; border-right: 2px solid rgba(2, 132, 199, 0.4);" id="sb_preview_shop">
                  <i class="fa fa-shopping-bag"></i> <span>Shop Name (Top Bar Seamless)</span>
               </div>

               <!-- Normal item preview -->
               <div style="padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 13px; display: inline-flex; align-items: center; gap: 8px;" id="sb_preview_normal">
                  <i class="fa fa-dashboard" style="color:#00c2cb;"></i> <span>Dashboard (Normal)</span>
               </div>

               <!-- Active Main Item preview -->
               <div style="padding: 8px 16px; border-radius: 6px; font-weight: 700; font-size: 13px; display: inline-flex; align-items: center; gap: 8px;" id="sb_preview_active">
                  <i class="fa fa-user-plus" id="sb_preview_active_icon"></i> <span>Users (Active Menu)</span>
               </div>

               <!-- Submenu preview box -->
               <div style="padding: 8px 10px; border-radius: 8px; min-width: 250px; border: 1px solid rgba(0,0,0,0.12); display: flex; flex-direction: column; gap: 4px;" id="sb_preview_sub_box">
                  <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.7; margin-bottom: 2px;" id="sb_preview_sub_lbl">Submenu Items:</div>
                  <div style="padding: 6px 10px; border-radius: 5px; font-size: 12.5px; font-weight: 500; display: flex; align-items: center; gap: 8px; cursor: default; transition: all 0.15s ease;" id="sb_preview_sub_item1">
                     <i class="fa fa-list" id="sb_preview_sub_i1"></i> <span>Users List (Normal)</span>
                  </div>
                  <div style="padding: 6px 10px; border-radius: 5px; font-size: 12.5px; font-weight: 700; display: flex; align-items: center; gap: 8px; cursor: pointer; transition: all 0.15s ease;" id="sb_preview_sub_item2">
                     <i class="fa fa-plus-square" id="sb_preview_sub_i2"></i> <span>Roles List (Mouse Hover / Pointer)</span>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script type="text/javascript">
function sbHexToRgb(hex) {
   var c = (hex || '').replace('#', '');
   if (c.length === 3) c = c[0] + c[0] + c[1] + c[1] + c[2] + c[2];
   if (c.length === 6) {
      return {
         r: parseInt(c.substring(0, 2), 16),
         g: parseInt(c.substring(2, 4), 16),
         b: parseInt(c.substring(4, 6), 16)
      };
   }
   return { r: 2, g: 132, b: 199 };
}

function refreshSidebarLivePreview() {
   var bg = $('#sidebar_color').val() || '#ffffff';
   var font = $('#sidebar_font_color').val() || '#1e293b';
   var act = $('#sidebar_active_color').val() || '#0284c7';
   var subBg = $('#sidebar_submenu_color').val() || '';
   var subHover = $('#sidebar_submenu_hover_color').val() || act;

   var actRgb = sbHexToRgb(act);

   if (!subBg) {
      var bgClean = bg.replace('#', '');
      var lum = 255;
      if (bgClean.length === 6) {
         lum = 0.299 * parseInt(bgClean.substring(0,2),16) + 0.587 * parseInt(bgClean.substring(2,4),16) + 0.114 * parseInt(bgClean.substring(4,6),16);
      }
      subBg = (lum < 150) ? 'rgba(0, 0, 0, 0.22)' : 'rgba(0, 0, 0, 0.05)';
   }
   var subHoverRgb = sbHexToRgb(subHover);

   $('#sb_live_preview_box').css('background-color', bg);
   $('#sb_preview_eye').css('color', font);
   $('#sb_preview_heading').css('color', font);

   // Shop Name Preview
   $('#sb_preview_shop').css({
      'background-color': bg,
      'color': font,
      'border-right': '2px solid ' + act
   });
   $('#sb_preview_shop span, #sb_preview_shop i').css('color', font);

   // Normal Menu Item
   $('#sb_preview_normal').css('color', font);
   $('#sb_preview_normal span').css('color', font);

   // Active Main Menu Item
   $('#sb_preview_active').css({
      'background-color': 'rgba(' + actRgb.r + ',' + actRgb.g + ',' + actRgb.b + ', 0.22)',
      'color': font,
      'border-left': '4px solid ' + act
   });
   $('#sb_preview_active span').css('color', font);
   $('#sb_preview_active_icon').css('color', act);

   // Submenu Container
   $('#sb_preview_sub_box').css({
      'background-color': subBg,
      'border-color': 'rgba(' + subHoverRgb.r + ',' + subHoverRgb.g + ',' + subHoverRgb.b + ', 0.25)'
   });
   $('#sb_preview_sub_lbl').css('color', font);

   // Submenu Item 1 (Normal)
   $('#sb_preview_sub_item1').css({
      'background-color': 'transparent',
      'color': font,
      'border-left': '3px solid transparent'
   });
   $('#sb_preview_sub_item1 span').css('color', font);
   $('#sb_preview_sub_i1').css('color', subHover);

   // Submenu Item 2 (Hover / Pointer)
   $('#sb_preview_sub_item2').css({
      'background-color': 'rgba(' + subHoverRgb.r + ',' + subHoverRgb.g + ',' + subHoverRgb.b + ', 0.22)',
      'color': subHover,
      'border-left': '3px solid ' + subHover
   });
   $('#sb_preview_sub_item2 span').css('color', subHover);
   $('#sb_preview_sub_i2').css('color', subHover);
}

function updateSidebarBg(val) {
   $('#sidebar_color').val(val);
   $('#sidebar_color_picker').val(val);
   refreshSidebarLivePreview();
}

function updateSidebarFont(val) {
   $('#sidebar_font_color').val(val);
   $('#sidebar_font_color_picker').val(val);
   refreshSidebarLivePreview();
}

function updateSidebarActive(val) {
   $('#sidebar_active_color').val(val);
   $('#sidebar_active_color_picker').val(val);
   refreshSidebarLivePreview();
}

function updateSidebarSubmenu(val) {
   $('#sidebar_submenu_color').val(val);
   $('#sidebar_submenu_color_picker').val(val);
   refreshSidebarLivePreview();
}

function updateSidebarSubmenuHover(val) {
   $('#sidebar_submenu_hover_color').val(val);
   $('#sidebar_submenu_hover_color_picker').val(val);
   refreshSidebarLivePreview();
}

$(document).ready(function() {
   refreshSidebarLivePreview();
});
</script>
<!-- END: SIDEBAR & SUBMENU THEME CUSTOMIZER -->
</div>
<?php if(!isset($q_id)){ 
    $packages = isset($package_list) ? $package_list : $this->db->where('status', 1)->order_by('id', 'asc')->get('db_package')->result();
    $package_json = array();
    $free_pkgs = array();
    $trial_pkgs = array();
    $paid_pkgs = array();

    foreach($packages as $pkg){
        $monthly = floatval($pkg->monthly_price);
        $annual = (floatval($pkg->annual_price) > 0) ? floatval($pkg->annual_price) : ($monthly * 12);
        $package_json[$pkg->id] = array(
            'id' => $pkg->id,
            'name' => $pkg->package_name,
            'type' => $pkg->package_type,
            'plan_type' => $pkg->plan_type,
            'monthly_price' => $monthly,
            'annual_price' => $annual,
            'trial_days' => intval($pkg->trial_days),
            'max_warehouses' => ($pkg->max_warehouses == -1) ? 'Unlimited' : $pkg->max_warehouses,
            'max_users' => ($pkg->max_users == -1) ? 'Unlimited' : $pkg->max_users,
            'max_items' => ($pkg->max_items == -1) ? 'Unlimited' : $pkg->max_items,
            'max_invoices' => ($pkg->max_invoices == -1) ? 'Unlimited' : $pkg->max_invoices,
            'description' => $pkg->description,
        );

        if($pkg->package_type == 'Free'){
            $free_pkgs[] = $pkg;
        } else if($pkg->package_type == 'Trial'){
            $trial_pkgs[] = $pkg;
        } else {
            $paid_pkgs[] = $pkg;
        }
    }

    $default_free = !empty($free_pkgs) ? $free_pkgs[0] : null;
    $default_trial = !empty($trial_pkgs) ? $trial_pkgs[0] : null;
    $default_paid = !empty($paid_pkgs) ? $paid_pkgs[0] : null;
?>
<!-- SUBSCRIPTION PACKAGE BOX START -->
<div class="row" style="margin-top: 25px;">
   <div class="col-md-12">
      <div style="background: #ffffff; border: 1.5px solid #0899a4; border-radius: 16px; box-shadow: 0 4px 20px rgba(8, 153, 164, 0.08); overflow: hidden; margin-bottom: 20px;">
         <div style="background: linear-gradient(135deg, #07252a 0%, #0899a4 100%); padding: 14px 22px; color: #ffffff; display: flex; align-items: center; justify-content: space-between;">
            <div style="display:flex; align-items:center; gap:10px;">
               <i class="fa fa-cubes" style="font-size: 20px; color: #0ed2be;"></i>
               <div>
                  <h4 style="margin: 0; font-weight: 700; font-size: 16px; color: #ffffff;">Subscription Package Setup</h4>
                  <small style="color: #cbe0e4;">Configure plan type, billing duration, package and setup charge</small>
               </div>
            </div>
            <span class="label" style="background: rgba(14,210,190,0.2); color:#0ed2be; border: 1px solid rgba(14,210,190,0.4); font-size: 12px; padding: 5px 12px; border-radius: 20px;">JAAS BD POS</span>
         </div>

         <div style="padding: 22px;">
            <input type="hidden" name="pay_via_gateway" id="pay_via_gateway" value="0">
            <input type="hidden" name="package_charge" id="package_charge" value="0.00">

            <!-- Row 1: Plan Type, Duration, Package -->
            <div class="row">
               <!-- Box 1: Plan Type Dropdown (Free / Trial / Paid) -->
               <div class="col-md-4 col-sm-6">
                  <div class="form-group" style="margin: 0 0 16px 0;">
                     <label for="store_package_type" style="font-size: 13px; font-weight: 700; color: #07252a;">
                        1. Plan Type <span class="text-danger">*</span>
                     </label>
                     <select name="store_package_type" id="store_package_type" class="form-control select2" style="width: 100%;" onchange="on_plan_type_change()">
                        <option value="Paid" selected>Paid</option>
                        <option value="Free">Free</option>
                        <option value="Trial">Trial</option>
                     </select>
                     <small class="text-muted" style="font-size: 11px;">Select Free, Trial, or Paid package plan</small>
                  </div>
               </div>

               <!-- Box 2: Duration / Billing Cycle Dropdown (Monthly / Yearly) -->
               <div class="col-md-4 col-sm-6" id="box_cycle_wrapper">
                  <div class="form-group" style="margin: 0 0 16px 0;">
                     <label for="billing_cycle" style="font-size: 13px; font-weight: 700; color: #07252a;">
                        2. Duration / Billing Cycle <span class="text-danger">*</span>
                     </label>
                     <select name="billing_cycle" id="billing_cycle" class="form-control select2" style="width: 100%;" onchange="on_billing_cycle_change()">
                        <option value="monthly" selected>Monthly</option>
                        <option value="yearly">Yearly (12 Months)</option>
                     </select>
                     <small class="text-muted" style="font-size: 11px;">Monthly or Annual package pricing</small>
                  </div>
               </div>

               <!-- Box 3: Package Dropdown -->
               <div class="col-md-4 col-sm-12">
                  <div class="form-group" style="margin: 0 0 16px 0;">
                     <label for="selected_package_id" style="font-size: 13px; font-weight: 700; color: #07252a;">
                        3. Package <span class="text-danger">*</span>
                     </label>
                     <select name="selected_package_id" id="selected_package_id" class="form-control select2" style="width: 100%;" onchange="on_package_change()">
                        <!-- Dynamic options loaded via JS -->
                     </select>
                     <small id="pkg_cycle_hint" class="text-muted" style="font-size: 11px;">Package loaded based on duration</small>
                  </div>
               </div>
            </div>

            <!-- Row 2: Setup Charge, Package Charge, Total Charge -->
            <div class="row" style="margin-top: 6px;">
               <!-- Box 4: Setup Charge (Mandatory, 0 if free) -->
               <div class="col-md-4 col-sm-6">
                  <div class="form-group" style="margin: 0 0 16px 0;">
                     <label for="setup_charge" style="font-size: 13px; font-weight: 700; color: #07252a;">
                        4. Setup Charge (BDT) <span class="text-danger">* (Mandatory, 0 if free)</span>
                     </label>
                     <div class="input-group">
                        <span class="input-group-addon" style="font-weight: 700; background: #f8fafc; color: #0899a4;">Tk</span>
                        <input type="number" step="0.01" min="0" name="setup_charge" id="setup_charge" class="form-control" value="0.00" required placeholder="0.00" onkeyup="recalculate_charges()" onchange="recalculate_charges()">
                     </div>
                     <span id="setup_charge_msg" style="display:none" class="text-danger">Setup charge is mandatory (enter 0 if no setup fee)</span>
                     <small class="text-muted" style="font-size: 11px;">Mandatory field: Enter 0 or required setup charge</small>
                  </div>
               </div>

               <!-- Box 5: Package Base Rate -->
               <div class="col-md-4 col-sm-6">
                  <div class="form-group" style="margin: 0 0 16px 0;">
                     <label style="font-size: 13px; font-weight: 700; color: #07252a;">
                        Package Charge (BDT)
                     </label>
                     <div class="input-group">
                        <span class="input-group-addon" style="font-weight: 700; background: #f8fafc; color: #475569;">Tk</span>
                        <input type="text" id="display_pkg_charge" class="form-control" readonly value="0.00" style="background-color: #f8fafc; font-weight: 700; color: #0f172a;">
                     </div>
                     <small id="pkg_rate_note" class="text-muted" style="font-size: 11px;">Current package rate</small>
                  </div>
               </div>

               <!-- Box 6: Total Charge (Package + Setup) -->
               <div class="col-md-4 col-sm-12">
                  <div class="form-group" style="margin: 0 0 16px 0;">
                     <label for="total_charge" style="font-size: 13px; font-weight: 700; color: #065f46;">
                        5. Total Charge (Package + Setup) (BDT)
                     </label>
                     <div class="input-group">
                        <span class="input-group-addon" style="font-weight: 800; background: #dcfce7; color: #166534;">Total Tk</span>
                        <input type="text" name="total_charge" id="total_charge" class="form-control" readonly value="0.00" style="background-color: #f0fdf4; border: 1.5px solid #86efac; font-weight: 800; font-size: 17px; color: #15803d;">
                     </div>
                     <small class="text-success" style="font-size: 11px; font-weight: 600;">Package Charge + Setup Charge combined</small>
                  </div>
               </div>
            </div>

            <!-- Dynamic Package Limits Chips & Live Total Banner -->
            <div style="margin-top: 10px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 18px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
               <div id="pkg_limits_wrap" style="display:flex; flex-wrap:wrap; gap:8px;">
                  <!-- Dynamic limit badges -->
               </div>
               <div style="font-size: 13.5px; color: #334155;">
                  Calculation: <span id="summary_pkg_price" style="font-weight:700; color:#0899a4;">0.00</span> Tk (Package) + 
                  <span id="summary_setup_price" style="font-weight:700; color:#ea7916;">0.00</span> Tk (Setup) = 
                  <strong id="summary_total_price" style="font-size:15px; color:#15803d;">0.00 BDT</strong>
               </div>
            </div>

            <!-- Activation & Policy Notice -->
            <div style="margin-top: 14px; background: #fff8f2; border: 1.5px solid #fed7aa; border-radius: 12px; padding: 14px 18px;">
               <div style="display:flex; align-items:flex-start; gap:12px;">
                  <div style="width: 32px; height: 32px; border-radius: 8px; background: #ea7916; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0; margin-top: 2px;">
                     <i class="fa fa-shield"></i>
                  </div>
                  <div>
                     <h5 style="margin:0 0 4px; font-weight:700; color:#9a3412; font-size: 14px;">Activation Policy:</h5>
                     <ul style="margin:0; padding-left:18px; font-size:12.5px; color:#7c2d12; line-height:1.6;">
                        <li><strong>Direct Save (Free / Trial / Paid):</strong> Saving directly saves the store as <em>Pending Super Admin Approval</em>. The shop requires Super Admin permission/authorization to become active.</li>
                        <li><strong>Paid Plan via Payment Gateway:</strong> Paying online through the gateway activates the store <em>directly & immediately</em>.</li>
                     </ul>
                  </div>
               </div>
            </div>

         </div>
      </div>
   </div>
</div>

<script type="text/javascript">
var allPackages = <?= json_encode($package_json); ?>;

function on_plan_type_change(){
    var planType = $("#store_package_type").val();
    if(planType == 'Free' || planType == 'Trial'){
        $("#box_cycle_wrapper").hide();
    } else {
        $("#box_cycle_wrapper").show();
    }
    populate_packages_dropdown();
}

function on_billing_cycle_change(){
    populate_packages_dropdown();
}

function on_package_change(){
    recalculate_charges();
}

function populate_packages_dropdown(){
    var planType = $("#store_package_type").val();
    var cycle = $("#billing_cycle").val();
    var $select = $("#selected_package_id");
    $select.empty();

    var firstId = null;

    if(planType == 'Free'){
        $("#pkg_cycle_hint").text("Free Plan packages");
        for(var id in allPackages){
            var p = allPackages[id];
            if(p.type == 'Free'){
                $select.append($('<option>', {
                    value: p.id,
                    text: p.name + ' - 0.00 BDT (Free Plan)'
                }));
                if(!firstId) firstId = p.id;
            }
        }
    } else if(planType == 'Trial'){
        $("#pkg_cycle_hint").text("Trial Plan packages");
        for(var id in allPackages){
            var p = allPackages[id];
            if(p.type == 'Trial'){
                $select.append($('<option>', {
                    value: p.id,
                    text: p.name + ' - 0.00 BDT (Trial ' + p.trial_days + ' Days)'
                }));
                if(!firstId) firstId = p.id;
            }
        }
    } else { // Paid
        $("#pkg_cycle_hint").text(cycle == 'yearly' ? 'Yearly Paid packages' : 'Monthly Paid packages');
        for(var id in allPackages){
            var p = allPackages[id];
            if(p.type == 'Paid'){
                var price = 0;
                var cycleSuffix = '';
                if(cycle == 'yearly'){
                    price = (parseFloat(p.annual_price) > 0) ? parseFloat(p.annual_price) : (parseFloat(p.monthly_price) * 12);
                    cycleSuffix = ' / Year';
                } else {
                    price = parseFloat(p.monthly_price);
                    cycleSuffix = ' / Month';
                }
                $select.append($('<option>', {
                    value: p.id,
                    text: p.name + ' - ' + price.toFixed(2) + ' BDT' + cycleSuffix
                }));
                if(!firstId) firstId = p.id;
            }
        }
    }

    if(firstId){
        $select.val(firstId);
    }
    if($select.hasClass("select2-hidden-accessible")){
        $select.trigger("change.select2");
    }

    recalculate_charges();
}

function recalculate_charges(){
    var planType = $("#store_package_type").val();
    var pkgId = $("#selected_package_id").val();
    var cycle = $("#billing_cycle").val();
    var pkg = (pkgId && allPackages[pkgId]) ? allPackages[pkgId] : null;

    var pkgPrice = 0.00;
    if(pkg){
        if(pkg.type == 'Free' || pkg.type == 'Trial'){
            pkgPrice = 0.00;
        } else {
            if(cycle == 'yearly'){
                pkgPrice = (parseFloat(pkg.annual_price) > 0) ? parseFloat(pkg.annual_price) : (parseFloat(pkg.monthly_price) * 12);
            } else {
                pkgPrice = parseFloat(pkg.monthly_price);
            }
        }
    }

    var setupInput = $("#setup_charge").val();
    var setupPrice = 0.00;
    if(setupInput !== '' && !isNaN(setupInput)){
        setupPrice = Math.max(0, parseFloat(setupInput));
    }

    var total = pkgPrice + setupPrice;

    $("#package_charge").val(pkgPrice.toFixed(2));
    $("#display_pkg_charge").val(pkgPrice.toFixed(2));
    $("#total_charge").val(total.toFixed(2));

    $("#summary_pkg_price").text(pkgPrice.toFixed(2));
    $("#summary_setup_price").text(setupPrice.toFixed(2));
    $("#summary_total_price").text(total.toFixed(2) + " BDT");

    if(planType == 'Paid'){
        $("#gateway_btn_wrap").show();
        $("#pkg_rate_note").text(cycle == 'yearly' ? 'Yearly package subscription' : 'Monthly package subscription');
    } else {
        $("#gateway_btn_wrap").hide();
        $("#pay_via_gateway").val(0);
        $("#pkg_rate_note").text(planType + ' package (0.00 BDT)');
    }

    // Limit chips
    if(pkg){
        var html = '';
        html += '<span class="badge" style="background:#e0f6f7; color:#0899a4; padding:6px 12px; font-weight:600;"><i class="fa fa-cubes"></i> Items: ' + pkg.max_items + '</span> ';
        html += '<span class="badge" style="background:#fff4ea; color:#ea7916; padding:6px 12px; font-weight:600;"><i class="fa fa-file-text-o"></i> Invoices: ' + pkg.max_invoices + '</span> ';
        html += '<span class="badge" style="background:#eff6ff; color:#2563eb; padding:6px 12px; font-weight:600;"><i class="fa fa-home"></i> Warehouses: ' + pkg.max_warehouses + '</span> ';
        html += '<span class="badge" style="background:#fbf2ff; color:#811ba0; padding:6px 12px; font-weight:600;"><i class="fa fa-users"></i> Users: ' + pkg.max_users + '</span> ';
        $("#pkg_limits_wrap").html(html);
    }
}

$(document).ready(function(){
    on_plan_type_change();

    $(document).on("click", "#pay_via_gateway_btn", function(e){
        e.preventDefault();
        $("#pay_via_gateway").val(1);
        $("#save").trigger("click");
    });

    $(document).on("click", "#save", function(){
        if(!window._is_gateway_click){
            $("#pay_via_gateway").val(0);
        }
        window._is_gateway_click = false;
    });

    $(document).on("mousedown", "#pay_via_gateway_btn", function(){
        window._is_gateway_click = true;
    });
});
</script>
<!-- SUBSCRIPTION PACKAGE BOX END -->
<?php } ?>

                                       </div>
                                       <!-- /.box-body -->
                                       <!-- /.box-footer -->
                                    
                                 </div>
                                 <!--/.col (right) -->
                              </div>
                              <!-- /.row -->
                           </div>
                           <div class="tab-pane" id="tab_1">
                              <div class="row">
                                 <!-- right column -->
                                 <div class="col-md-12">
                                    <!-- form start -->
                                       <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                                       <div class="box-body">
                                          <div class="row">
                                             <div class="col-md-5">
                                                
                                                <div class="form-group">
                                                   <label for="timezone" class="col-sm-4 control-label"><?= $this->lang->line('timezone'); ?><label class="text-danger">*</label> </label>
                                                   <div class="col-sm-8">
                                                      <select class="form-control select2" id="timezone" name="timezone"  style="width: 100%;">
                                                         <?php
                                                            $query2="select * from db_timezone where status=1";
                                                            $q2=$this->db->query($query2);
                                                            if($q2->num_rows()>0)
                                                             {
                                                              
                                                              foreach($q2->result() as $res1)
                                                               {
                                                                 if((isset($timezone) && !empty($timezone)) && trim($timezone)==trim($res1->timezone)){$selected='selected';}else{$selected='';}
                                                                 echo "<option ".$selected." value='".$res1->timezone."'>".$res1->timezone."</option>";
                                                               }
                                                             }
                                                             else
                                                             {
                                                                ?>
                                                         <option value="">No Records Found</option>
                                                         <?php
                                                            }
                                                            ?>
                                                      </select>
                                                      <span id="timezone_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                                <div class="form-group">
                                                   <label for="date_format" class="col-sm-4 control-label"><?= $this->lang->line('date_format'); ?><label class="text-danger">*</label> </label>
                                                   <div class="col-sm-8">
                                                      <select class="form-control select2" id="date_format" name="date_format"  style="width: 100%;">
                                                         <option value="dd-mm-yyyy">dd-mm-yyyy</option>
                                                         <!-- <option value="dd/mm/yyyy">dd/mm/yyyy</option> -->
                                                         <option value="mm/dd/yyyy">mm/dd/yyyy</option>
                                                      </select>
                                                      <span id="date_format_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                                <div class="form-group">
                                                   <label for="time_format" class="col-sm-4 control-label"><?= $this->lang->line('time_format'); ?><label class="text-danger">*</label> </label>
                                                   <div class="col-sm-8">
                                                      <select class="form-control select2" id="time_format" name="time_format"  style="width: 100%;">
                                                         <option value="12">12 Hours</option>
                                                         <option value="24">24 Hours</option>
                                                      </select>
                                                      <span id="time_format_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                                <div class="form-group">
                                                   <label for="currency" class="col-sm-4 control-label"><?= $this->lang->line('currency'); ?><label class="text-danger">*</label> </label>
                                                   <div class="col-sm-8">
                                                      <select class="form-control select2" id="currency" name="currency"  style="width: 100%;">
                                                         <?php
                                                            $query2="select * from db_currency where status=1";
                                                            $q2=$this->db->query($query2);
                                                            if($q2->num_rows()>0)
                                                             {
                                                              
                                                              foreach($q2->result() as $res1)
                                                               {
                                                                 if((isset($currency_id) && !empty($currency_id)) && $currency_id==$res1->id){$selected='selected';}else{$selected='';}
                                                                 echo "<option ".$selected." value='".$res1->id."'>".$res1->currency_name.' '.$res1->currency_code.' ('.$res1->currency.")</option>";
                                                               }
                                                             }
                                                             else
                                                             {
                                                                ?>
                                                         <option value="">No Records Found</option>
                                                         <?php
                                                            }
                                                            ?>
                                                      </select>
                                                      <span id="currency_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                                <div class="form-group">
                                                   <label for="currency_placement" class="col-sm-4 control-label"><?= $this->lang->line('currency_symbol_placement'); ?><label class="text-danger">*</label> </label>
                                                   <div class="col-sm-8">
                                                      <select class="form-control select2" id="currency_placement" name="currency_placement"  style="width: 100%;">
                                                         <option value="Right">After Amount</option>
                                                         <option value="Left">Before Amount</option>
                                                      </select>
                                                      <span id="currency_placement_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                                <div class="form-group">
                                                   <label for="decimals" class="col-sm-4 control-label"><?= $this->lang->line('decimals'); ?><label class="text-danger">*</label> </label>
                                                   <div class="col-sm-8">
                                                      <select class="form-control select2" id="decimals" name="decimals"  style="width: 100%;">
                                                         <option value="0">0</option>
                                                         <option value="1">1</option>
                                                         <option value="2">2</option>
                                                         <option value="3">3</option>
                                                         <option value="4">4</option>
                                                      </select>
                                                      <span id="decimals_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>

                                                <div class="form-group">
                                                   <label for="qty_decimals" class="col-sm-4 control-label"><?= $this->lang->line('qty_decimals'); ?><label class="text-danger">*</label> </label>
                                                   <div class="col-sm-8">
                                                      <select class="form-control select2" id="qty_decimals" name="qty_decimals"  style="width: 100%;">
                                                         <option value="0">0</option>
                                                         <option value="1">1</option>
                                                         <option value="2">2</option>
                                                         <option value="3">3</option>
                                                         <option value="4">4</option>
                                                      </select>
                                                      <span id="qty_decimals_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>

                                                
                                             </div>
                                             <!-- ########### -->
                                             <div class="col-md-5">
                                                
                                                <div class="form-group">
                                                   <label for="language_id" class="col-sm-4 control-label"><?= $this->lang->line('language'); ?><label class="text-danger">*</label> </label>
                                                   <div class="col-sm-8">
                                                      <select class="form-control select2" id="language_id" name="language_id"  style="width: 100%;">
                                                         <?php
                                                            $query2="select * from db_languages where status=1";
                                                            $q2=$this->db->query($query2);
                                                            if($q2->num_rows()>0)
                                                             {
                                                              
                                                              foreach($q2->result() as $res1)
                                                               {
                                                                 $selected = ($res1->id ==$language_id) ? 'selected' : '';
                                                                 echo "<option ".$selected." value='".$res1->id."'>".$res1->language."</option>";
                                                               }
                                                             }
                                                             else
                                                             {
                                                                ?>
                                                         <option value="">No Records Found</option>
                                                         <?php
                                                            }
                                                            ?>
                                                      </select>
                                                      <span id="language_id_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                                
                                                <?php 
                                               $round_off_checkbox ='';
                                               if($round_off==1){
                                                $round_off_checkbox='checked';
                                               }
                                               ?>
                                                <div class="form-group">
                                                   <label for="round_off" class="col-sm-4 control-label"><?= $this->lang->line('enable_round_off'); ?> ?</label>
                                                   <div class="col-sm-4">
                                                      <input type="checkbox" <?=$round_off_checkbox;?> class="form-control" id="round_off" name="round_off" >
                                                      <span id="round_off_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                               

                                             </div>
                                          </div>
                                       </div>
                                       <!-- /.box-body -->
                                       <!-- /.box-footer -->
                                    
                                 </div>
                                 <!--/.col (right) -->
                              </div>
                              <!-- /.row -->
                           </div>
                           <!-- /.tab-pane -->
                           <?php 
                           //Change Return
                           $change_return_checkbox ='';
                           if($change_return==1){
                            $change_return_checkbox='checked';
                           }

                           //MRP Column Checkbox
                           $mrp_column_checkbox ='';
                           if($mrp_column==1){
                            $mrp_column_checkbox='checked';
                           }

                           

                           //Previous Balance Checkbox
                           $previous_balance_checkbox ='';
                           if($previous_balance_bit==1){
                            $previous_balance_checkbox='checked';
                           }
                          
                            ?>
                           <div class="tab-pane" id="tab_2">
                              <div class="row">
                                 <!-- right column -->
                                 <div class="col-md-12">
                                       <div class="box-body">
                                          <div class="row">
                                             <div class="col-md-12">
                                             <div class="form-group">
                                                   <label for="default_account_id" class="col-sm-3 control-label"><?= $this->lang->line('default_account'); ?></label>
                                                   <div class="col-sm-4">
                                                      <select class="form-control select2" id="default_account_id" name="default_account_id"  style="width: 100%;">
                                                         <option value="">-None-</option>
                                                         <?= get_accounts_select_list($default_account_id)?>
                                                      </select>
                                                      <span id="default_account_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                              </div>

                                             <div class="col-md-12">
                                                <div class="form-group">
                                                   <label for="sales_discount" class="col-sm-3 control-label"><?= $this->lang->line('default_sales_discount'); ?></label>
                                                   <div class="col-sm-4">
                                                      <input type="text" class="form-control" id="sales_discount" name="sales_discount" placeholder="" value="<?php print store_number_format($sales_discount,0); ?>" >
                                                      <span id="sales_discount_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             
                                            

                                             <div class="col-md-12">
                                             <div class="form-group">
                                                   <label for="sales_invoice_formats" class="col-sm-3 control-label"><?= $this->lang->line('sales_invoice_formats'); ?><label class="text-danger">*</label> </label>
                                                   <div class="col-sm-4">
                                                      <select class="form-control select2" id="sales_invoice_format_id" name="sales_invoice_format_id"  style="width: 100%;">
                                                         <option value="3">Default</option>
                                                         <option value="4">GST Format</option>
                                                      </select>
                                                      <span id="sales_invoice_format_id_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                              </div>
                                            <div class="col-md-12">
                                             <div class="form-group">
                                                   <label for="pos_invoice_formats" class="col-sm-3 control-label"><?= $this->lang->line('pos_invoice_formats'); ?><label class="text-danger">*</label> </label>
                                                   <div class="col-sm-4">
                                                      <select class="form-control select2" id="pos_invoice_format_id" name="pos_invoice_format_id"  style="width: 100%;">
                                                         <option value="1">Default</option>
                                                         <option value="2">GST Format</option>
                                                      </select>
                                                      <span id="pos_invoice_format_id_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                              </div>


                                              <div class="col-md-12">
                                                <div class="form-group">
                                                   <label for="mrp_column" class="col-sm-3 control-label"><?= $this->lang->line('show_mrp_column_on_pos_invoice'); ?></label>
                                                   <div class="col-sm-4">
                                                      <input type="checkbox" <?=$mrp_column_checkbox;?> class="form-control" id="mrp_column" name="mrp_column" >
                                                      <span id="mrp_column_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>

                                             <div class="col-md-12">
                                                <div class="form-group">
                                                   <label for="sales_discount" class="col-sm-3 control-label"><?= $this->lang->line('show_paid_amount_and_change_return_in_pos'); ?></label>
                                                   <div class="col-sm-4">
                                                      <input type="checkbox" <?=$change_return_checkbox;?> class="form-control" id="change_return" name="change_return" >
                                                      <span id="change_return_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>

                                             <div class="col-md-12">
                                                <div class="form-group">
                                                   <label for="mrp_column" class="col-sm-3 control-label"><?= $this->lang->line('show_previous_balance_on_invoice'); ?></label>
                                                   <div class="col-sm-4">
                                                      <input type="checkbox" <?=$previous_balance_checkbox;?> class="form-control" id="previous_balance_bit" name="previous_balance_bit" >
                                                      <span id="previous_balance_bit_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-12">
                                             <div class="form-group">
                                                   <label for="number_to_words" class="col-sm-3 control-label"><?= $this->lang->line('number_to_words_format'); ?><label class="text-danger">*</label> </label>
                                                   <div class="col-sm-4">
                                                      <select class="form-control select2" id="number_to_words" name="number_to_words"  style="width: 100%;">
                                                         <option value="Default">Default</option>
                                                         <option value="Indian">Indian</option>
                                                      </select>
                                                      <span id="number_to_words_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                              </div>
                                              <div class="col-md-12">
                                                <div class="form-group">
                                                   <label for="sales_invoice_footer_text" class="col-sm-3 control-label"><?= $this->lang->line('sales_invoice_footer_text'); ?></label>
                                                   <div class="col-sm-9">
                                                      <textarea class="form-control" id="sales_invoice_footer_text" name="sales_invoice_footer_text"><?= $sales_invoice_footer_text;?></textarea>
                                                      <span id="sales_invoice_footer_text_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-12">
                                                <div class="form-group">
                                                   
                                                     
                                                   

                                                   <label for="invoice_terms" class="col-sm-3 control-label"><?= $this->lang->line('invoiceTermsAndConditions')?></label>
                                                   <div class="col-sm-9">

                                                      <label>
                                                       <input type="radio" name="t_and_c_status" id="t_and_c_status_show" value="1" checked="">
                                                       <?= $this->lang->line('show_on_invoice')?> 
                                                     </label>
                                                   
                                                     <label for="options">
                                                       <input type="radio" name="t_and_c_status" id="t_and_c_status_hide" value="0">
                                                       <?= $this->lang->line('hide_on_invoice')?>
                                                     </label>

                                                     <br>
                                                     <label>
                                                       <input type="radio" name="t_and_c_status_pos" id="t_and_c_status_show_pos" value="1" checked="">
                                                       <?= $this->lang->line('show_on_pos_invoice')?> 
                                                     </label>
                                                   
                                                     <label for="options">
                                                       <input type="radio" name="t_and_c_status_pos" id="t_and_c_status_hide_pos" value="0">
                                                       <?= $this->lang->line('hide_on_pos_invoice')?>
                                                     </label>

                                                     <br/>
                                                     <br/>
                                                      <textarea id="invoice_terms" name="invoice_terms" class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; border: 1px solid #dddddd; padding: 10px;"><?= $invoice_terms;?></textarea>
                                                   </div>
                                                </div>
                                             </div>

                                             


                                          </div>
                                       </div>
                                 </div>
                                 <!--/.col (right) -->
                              </div>
                              <!-- /.row -->
                           </div>
                           <!-- /.tab-pane -->
                           <div class="tab-pane" id="tab_3">
                             <div class="row">
                                 <!-- right column -->
                                 <div class="col-md-12">
                                       <div class="box-body">
                                          <div class="row">
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="category_init" class="col-sm-4 control-label"><?= $this->lang->line('category'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="category_init" name="category_init" placeholder="" value="<?php print $category_init; ?>" >
                                                      <span id="category_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="item_init" class="col-sm-4 control-label"><?= $this->lang->line('item'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control no_special_no_space" id="item_init" name="item_init" placeholder="" value="<?php print $item_init; ?>" >
                                                      <span id="item_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="supplier_init" class="col-sm-4 control-label"><?= $this->lang->line('supplier'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="supplier_init" name="supplier_init" placeholder="" value="<?php print $supplier_init; ?>" >
                                                      <span id="supplier_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="purchase_init" class="col-sm-4 control-label"><?= $this->lang->line('purchase'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="purchase_init" name="purchase_init" placeholder="" value="<?php print $purchase_init; ?>" >
                                                      <span id="purchase_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="purchase_return_init" class="col-sm-4 control-label"><?= $this->lang->line('purchase_return'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="purchase_return_init" name="purchase_return_init" placeholder="" value="<?php print $purchase_return_init; ?>" >
                                                      <span id="purchase_return_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="customer_init" class="col-sm-4 control-label"><?= $this->lang->line('customer'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="customer_init" name="customer_init" placeholder="" value="<?php print $customer_init; ?>" >
                                                      <span id="customer_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="sales_init" class="col-sm-4 control-label"><?= $this->lang->line('sales'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="sales_init" name="sales_init" placeholder="" value="<?php print $sales_init; ?>" >
                                                      <span id="sales_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="sales_return_init" class="col-sm-4 control-label"><?= $this->lang->line('sales_return'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="sales_return_init" name="sales_return_init" placeholder="" value="<?php print $sales_return_init; ?>" >
                                                      <span id="sales_return_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="expense_init" class="col-sm-4 control-label"><?= $this->lang->line('expense'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="expense_init" name="expense_init" placeholder="" value="<?php print $expense_init; ?>" >
                                                      <span id="expense_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="accounts_init" class="col-sm-4 control-label"><?= $this->lang->line('accounts'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="accounts_init" name="accounts_init" placeholder="" value="<?php print $accounts_init; ?>" >
                                                      <span id="accounts_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="quotation_init" class="col-sm-4 control-label"><?= $this->lang->line('quotation'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="quotation_init" name="quotation_init" placeholder="" value="<?php print $quotation_init; ?>" >
                                                      <span id="quotation_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="money_transfer_init" class="col-sm-4 control-label"><?= $this->lang->line('money_transfer'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="money_transfer_init" name="money_transfer_init" placeholder="" value="<?php print $money_transfer_init; ?>" >
                                                      <span id="money_transfer_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="sales_payment_init" class="col-sm-4 control-label"><?= $this->lang->line('sales_payment'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="sales_payment_init" name="sales_payment_init" placeholder="" value="<?php print $sales_payment_init; ?>" >
                                                      <span id="sales_payment_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="sales_return_payment_init" class="col-sm-4 control-label"><?= $this->lang->line('sales_return_payment'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="sales_return_payment_init" name="sales_return_payment_init" placeholder="" value="<?php print $sales_return_payment_init; ?>" >
                                                      <span id="sales_return_payment_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="purchase_payment_init" class="col-sm-4 control-label"><?= $this->lang->line('purchase_payment'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="purchase_payment_init" name="purchase_payment_init" placeholder="" value="<?php print $purchase_payment_init; ?>" >
                                                      <span id="purchase_payment_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="purchase_return_payment_init" class="col-sm-4 control-label"><?= $this->lang->line('purchase_return_payment'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="purchase_return_payment_init" name="purchase_return_payment_init" placeholder="" value="<?php print $purchase_return_payment_init; ?>" >
                                                      <span id="purchase_return_payment_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>

                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="expense_payment_init" class="col-sm-4 control-label"><?= $this->lang->line('expense_payment'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="expense_payment_init" name="expense_payment_init" placeholder="" value="<?php print $expense_payment_init; ?>" >
                                                      <span id="expense_payment_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="cust_advance_init" class="col-sm-4 control-label"><?= $this->lang->line('customers_advance_payments'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="cust_advance_init" name="cust_advance_init" placeholder="" value="<?php print $cust_advance_init; ?>" >
                                                      <span id="cust_advance_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                 </div>
                                 <!--/.col (right) -->
                              </div>
                              <!-- /.row -->
                           </div>
                           <!-- /.tab-pane -->
                           <?php if(isset($q_id)){ ?>
                           <div class="tab-pane" id="tab_backup">
                              <div class="row" style="padding: 15px 10px;">
                                 <!-- Download Backup Column -->
                                 <div class="col-md-6">
                                    <div class="box box-solid box-primary" style="border-radius:10px; box-shadow:0 4px 15px rgba(0,0,0,0.06);">
                                       <div class="box-header with-border" style="border-radius:10px 10px 0 0; background:linear-gradient(135deg, #059669 0%, #10b981 100%); padding:12px 18px;">
                                          <h3 class="box-title" style="color:#fff; font-weight:700; font-size:16px;"><i class="fa fa-download"></i> Download Shop Backup</h3>
                                       </div>
                                       <div class="box-body" style="padding:22px;">
                                          <p style="font-size:14px; color:#475569; line-height:1.6;">
                                             Export and download a complete database backup of this shop. All records (products, inventory, sales, purchases, customer balances, and accounts) will be saved as a single secure <code>.sql</code> backup file.
                                          </p>
                                          <div style="margin-top:22px;">
                                             <a href="<?php echo base_url('store/download_shop_backup/'.$q_id); ?>" class="btn btn-success btn-lg" style="border-radius:8px; font-weight:700; padding:10px 24px; box-shadow:0 4px 12px rgba(16,185,129,0.3); background:#059669; border-color:#047857;">
                                                <i class="fa fa-download"></i> Download .SQL Backup
                                             </a>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <!-- Upload & Restore Backup Column -->
                                 <div class="col-md-6">
                                    <div class="box box-solid box-info" style="border-radius:10px; box-shadow:0 4px 15px rgba(0,0,0,0.06);">
                                       <div class="box-header with-border" style="border-radius:10px 10px 0 0; background:linear-gradient(135deg, #0284c7 0%, #2563eb 100%); padding:12px 18px;">
                                          <h3 class="box-title" style="color:#fff; font-weight:700; font-size:16px;"><i class="fa fa-upload"></i> Restore Shop Backup</h3>
                                       </div>
                                       <div class="box-body" style="padding:22px;">
                                          <p style="font-size:14px; color:#475569; line-height:1.6;">
                                             Upload and restore a previously saved <code>.sql</code> backup file into this shop.
                                          </p>
                                          <div class="form-group" style="margin-bottom:15px; margin-left:0; margin-right:0;">
                                             <label for="shop_profile_backup_file" style="font-weight:700;">Select Backup File (.sql): <span class="text-danger">*</span></label>
                                             <input type="file" class="form-control" id="shop_profile_backup_file" accept=".sql,.json,.txt" style="border-radius:8px; padding:6px;">
                                          </div>
                                          <div class="checkbox" style="margin-bottom:18px;">
                                             <label style="font-weight:600; cursor:pointer;">
                                                <input type="checkbox" id="clean_existing_profile" checked> Clean existing shop data before restoring (Recommended)
                                             </label>
                                          </div>
                                          <button type="button" class="btn btn-primary btn-lg" onclick="restore_shop_from_profile(<?php echo $q_id; ?>)" id="btn_profile_restore" style="border-radius:8px; font-weight:700; padding:10px 24px; box-shadow:0 4px 12px rgba(37,99,235,0.3); background:linear-gradient(135deg, #0284c7 0%, #2563eb 100%); border:0;">
                                             <i class="fa fa-upload"></i> Upload & Restore
                                          </button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <?php } ?>
                        </div>
                        <!-- /.tab-content -->
                     </div>
                     <!-- nav-tabs-custom -->
                     <div>
                        <div class="col-xs-12 text-center" style="margin: 25px 0 30px 0;">
                           <div style="display: flex; justify-content: center; align-items: center; flex-wrap: wrap; gap: 14px;">
                              <?php
                                 if(isset($q_id)){
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
                              <?php if(!isset($q_id)){ ?>
                              <button type="button" id="<?php echo $btn_id;?>" class="btn btn-success" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); border:0; border-radius: 8px; font-weight:700; font-size:14px; padding: 11px 24px; box-shadow: 0 4px 12px rgba(22,163,74,0.3); display: inline-flex; align-items: center; gap: 8px;" title="Direct Save (Manual Super Admin Authorization)">
                                 <i class="fa fa-save"></i> <?php echo $btn_name;?> (Direct Save)
                              </button>

                              <div id="gateway_btn_wrap" style="display:none;">
                                 <button type="button" id="pay_via_gateway_btn" class="btn btn-info" style="background: linear-gradient(135deg, #0899a4 0%, #0ed2be 100%) !important; border:0; border-radius: 8px; font-weight:700; font-size:14px; padding: 11px 26px; color:#ffffff !important; box-shadow: 0 4px 14px rgba(8,153,164,0.35); display: inline-flex; align-items: center; gap: 8px; white-space: nowrap;" title="Pay Online & Activate Store Immediately">
                                    <i class="fa fa-credit-card"></i> Pay via Payment Gateway
                                 </button>
                              </div>

                              <a href="<?=base_url('store/view');?>" style="text-decoration:none;">
                                 <button type="button" class="btn btn-default close_btn" style="border-radius: 8px; font-weight:600; font-size:14px; padding: 11px 22px; background: #f1f5f9; border: 1px solid #cbd5e1; color: #475569; display: inline-flex; align-items: center; gap: 6px;" title="Cancel">
                                    <i class="fa fa-times"></i> Close
                                 </button>
                              </a>
                              <?php } else { ?>
                              <button type="button" id="<?php echo $btn_id;?>" class="btn btn-success" style="background: linear-gradient(135deg, #16a34a 0%, #15803d 100%); border:0; border-radius: 8px; font-weight:700; font-size:14px; padding: 11px 28px; box-shadow: 0 4px 12px rgba(22,163,74,0.3); display: inline-flex; align-items: center; gap: 8px;" title="Save Data">
                                 <i class="fa fa-save"></i> <?php echo $btn_name;?>
                              </button>
                              <a href="<?=base_url('dashboard');?>" style="text-decoration:none;">
                                 <button type="button" class="btn btn-warning close_btn" style="border-radius: 8px; font-weight:600; font-size:14px; padding: 11px 24px; display: inline-flex; align-items: center; gap: 6px;" title="Go Dashboard">
                                    <i class="fa fa-dashboard"></i> Close
                                 </button>
                              </a>
                              <?php } ?>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- /.col -->
               </div>
               <!-- /.row -->
            </section>
            <!-- /.content -->
            <?= form_close(); ?>
         </div>
         <!-- /.content-wrapper -->
         <?php $this->load->view('footer.php');?>
         <!-- Add the sidebar's background. This div must be placed
            immediately after the control sidebar -->
         <div class="control-sidebar-bg"></div>
      </div>
      <!-- ./wrapper -->
      <?php $this->load->view('comman/code_js_language.php');?>
      <!-- SOUND CODE -->
      <?php $this->load->view('comman/code_js_sound.php');?>
      <!-- TABLES CODE -->
      <?php $this->load->view('comman/code_js.php');?>

      <script type="text/javascript">
         $(document).submit(function(event) {
           event.preventDefault();
           if($("#update").length){
             $("#update").trigger('click');
           }
         });
      </script>
      <script src="<?php echo $theme_link; ?>js/store_profile.js"></script>
      <script src="<?php echo $theme_link; ?>js/store/store.js"></script>
     


<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo $theme_link; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

     
      <script type="text/javascript">
         $("#number_to_words").val('<?= $number_to_words;?>').select2();

        <?php if(!empty($currency_placement)) {?>
         $("#currency_placement").val('<?= $currency_placement;?>').select2();
       <?php }else{ ?>
         $("#currency_placement").select2();
       <?php } ?>

       <?php if(!empty($date_format)) {?>
         $("#date_format").val('<?= $date_format;?>').select2();
       <?php }else{ ?>
         $("#date_format").select2();
       <?php } ?>

       <?php if(!empty($decimals)) {?>
         $("#decimals").val('<?= $decimals;?>').select2();
       <?php }else{ ?>
         $("#decimals").select2();
       <?php } ?>

       <?php if(!empty($qty_decimals)) {?>
         $("#qty_decimals").val('<?= $qty_decimals;?>').select2();
       <?php }else{ ?>
         $("#qty_decimals").select2();
       <?php } ?>
       
       <?php if(!empty($time_format)) {?>
         $("#time_format").val('<?= $time_format;?>').select2();
       <?php }else{ ?>
         $("#time_format").select2();
       <?php } ?>

       <?php if(!empty($sales_invoice_format_id)) {?>
         $("#sales_invoice_format_id").val('<?= $sales_invoice_format_id;?>').select2();
       <?php }else{ ?>
         $("#sales_invoice_format_id").select2();
       <?php } ?>

       <?php if(!empty($pos_invoice_format_id)) {?>
         $("#pos_invoice_format_id").val('<?= $pos_invoice_format_id;?>').select2();
       <?php }else{ ?>
         $("#pos_invoice_format_id").select2();
       <?php } ?>

       <?php if($t_and_c_status==1) {?>
         $("#t_and_c_status_show").attr("checked","checked");
       <?php }else{ ?>
         $("#t_and_c_status_hide").attr("checked","checked");
       <?php } ?>

       <?php if($t_and_c_status_pos==1) {?>
         $("#t_and_c_status_show_pos").attr("checked","checked");
       <?php }else{ ?>
         $("#t_and_c_status_hide_pos").attr("checked","checked");
       <?php } ?>

      </script>
      <!-- Make sidebar menu hughlighter/selector -->
      <?php if( isset($q_id) && !empty($q_id) && get_current_store_id()==$q_id){ ?>
        <script>$(".store_profile-active-li").addClass("active");</script>
      <?php }else{?>
        <script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
      <?php } ?>

      <script>
      function restore_shop_from_profile(store_id){
          var fileInput = document.getElementById('shop_profile_backup_file');
          if(!fileInput.files || fileInput.files.length === 0){
              toastr["warning"]("Please select a backup file (.sql) to upload!");
              return;
          }

          var formData = new FormData();
          formData.append('store_id', store_id);
          formData.append('backup_file', fileInput.files[0]);
          formData.append('clean_existing', $('#clean_existing_profile').is(':checked') ? 1 : 0);

          var csrfName = '<?=$this->security->get_csrf_token_name();?>';
          var csrfHash = '<?=$this->security->get_csrf_hash();?>';
          formData.append(csrfName, csrfHash);

          var base_url = $("#base_url").val();
          var btn = $('#btn_profile_restore');
          btn.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Restoring data, please wait...');

          $.ajax({
              url: base_url + 'store/upload_shop_backup',
              type: 'POST',
              data: formData,
              contentType: false,
              processData: false,
              dataType: 'json',
              success: function(response){
                  btn.attr('disabled', false).html('<i class="fa fa-upload"></i> Upload & Restore');
                  if(response.status == 'success'){
                      toastr["success"](response.message || "Store backup data restored successfully!");
                      setTimeout(function(){ location.reload(); }, 1500);
                  } else {
                      toastr["error"](response.message || "Restore failed");
                  }
              },
              error: function(xhr, status, error){
                  btn.attr('disabled', false).html('<i class="fa fa-upload"></i> Upload & Restore');
                  var errMsg = error;
                  try {
                      var jsonResp = JSON.parse(xhr.responseText);
                      if(jsonResp && jsonResp.message){
                          errMsg = jsonResp.message;
                      }
                  } catch(e){
                      if(xhr.status == 403){
                          errMsg = "Access Forbidden (403): Request was rejected by server security. Please reload the page.";
                      } else if(xhr.status == 413){
                          errMsg = "Uploaded file exceeds server upload size limit.";
                      }
                  }
                  toastr["error"]("Server error: " + errMsg);
              }
          });
      }
      </script>

      <script>
        $(function () {
          //bootstrap WYSIHTML5 - text editor
         // $("#invoice_terms").wysihtml5()
        })
      </script>

   </body>
</html>
