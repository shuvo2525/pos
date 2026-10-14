<!DOCTYPE html>
<html>
   <head>
      <!-- TABLES CSS CODE -->
      <?php $this->load->view('comman/code_css.php');?>
   </head>
   <body class="hold-transition skin-blue sidebar-mini">
      <div class="wrapper">
         <?php $this->load->view('sidebar');?>
         <?php
            $is_edit = isset($q_id);
            if(!isset($q_id)){
               $parent_id =$account_name=$note=$q_id=$store_id='';
               $account_code = get_init_code("accounts");
               $opening_balance=0;
               if(isset($_GET['parent_id']) && !empty($_GET['parent_id'])){
                  $parent_id = intval($_GET['parent_id']);
               }
            }
            $is_parent_head = ($is_edit && (empty($parent_id) || $parent_id == 0));
         ?>
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <h1>
                  <?= $this->lang->line('accounts'); ?>
                  <small><?= $is_edit ? 'Update Account' : 'Add New Account'; ?></small>
               </h1>
               <ol class="breadcrumb">
                  <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                  <li><a href="<?php echo $base_url; ?>accounts"><?= $this->lang->line('accounts_list'); ?></a></li>
                  <li class="active"><?= $this->lang->line('accounts'); ?></li>
               </ol>
            </section>
            <!-- Main content -->
            <section class="content">
               <div class="row">
                  <!-- ********** ALERT MESSAGE START******* -->
                  <?php $this->load->view('comman/code_flashdata');?>
                  <!-- ********** ALERT MESSAGE END******* -->
                  <!-- right column -->
                  <div class="col-md-12">
                     <!-- Horizontal Form -->
                     <div class="box box-primary">
                        <div class="box-header with-border">
                           <h3 class="box-title"><i class="fa fa-pencil-square-o text-primary"></i> <?= $is_edit ? 'Edit Account Details' : 'Create Account / Parent Head'; ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-horizontal" id="accounts-form">
                           <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                           <input type="hidden" id="base_url" value="<?php echo $base_url; ?>">
                           <div class="box-body">
                              <div class="row">
                                 <div class="col-md-7">
                                    <!-- Store Code -->
                                    <input type='hidden' name='store_id' id='store_id' value='<?= get_current_store_id(); ?>'>

                                    <!-- Account Level Selector -->
                                    <div class="form-group">
                                       <label class="col-sm-4 control-label">Account Level <label class="text-danger">*</label></label>
                                       <div class="col-sm-8">
                                          <label class="radio-inline" style="font-weight:600; cursor:pointer;">
                                             <input type="radio" name="account_level" id="level_head" value="head" <?= $is_parent_head ? 'checked' : '' ?> onchange="toggleAccountLevel()">
                                             <i class="fa fa-folder text-yellow"></i> Parent Account Head
                                          </label>
                                          &nbsp;&nbsp;
                                          <label class="radio-inline" style="font-weight:600; cursor:pointer;">
                                             <input type="radio" name="account_level" id="level_sub" value="sub" <?= !$is_parent_head ? 'checked' : '' ?> onchange="toggleAccountLevel()">
                                             <i class="fa fa-sitemap text-blue"></i> Sub-Account
                                          </label>
                                          <p class="help-block text-muted" style="margin-top:5px; margin-bottom:0px; font-size:12px;">
                                             Choose <b>Parent Account Head</b> to create a main category (e.g. Bank, bKash, Cash). Choose <b>Sub-Account</b> to create an account under a head (e.g. EBL Bank under Bank, bKash Merchant under bKash).
                                          </p>
                                       </div>
                                    </div>

                                    <!-- Parent Account Selection (Shown only when Sub-Account is selected) -->
                                    <div class="form-group" id="parent_account_group" style="<?= $is_parent_head ? 'display:none;' : '' ?>">
                                       <label for="parent_id" class="col-sm-4 control-label"><?= $this->lang->line('parent_account'); ?> <label class="text-danger">*</label></label>
                                       <div class="col-sm-8">
                                          <div class="input-group">
                                             <select class="form-control" id="parent_id" name="parent_id" style="width: 100%;">
                                                <option value="0">-- Select Parent Head --</option>
                                                <?= get_parent_accounts_select_list($parent_id); ?>
                                             </select>
                                             <span class="input-group-btn">
                                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal_add_parent_head" title="Add New Parent Head">
                                                   <i class="fa fa-plus text-green"></i> + Head
                                                </button>
                                             </span>
                                          </div>
                                          <span id="parent_id_msg" style="display:none" class="text-danger"></span>
                                       </div>
                                    </div>

                                    <div class="form-group">
                                       <label for="account_code" class="col-sm-4 control-label"><?= $this->lang->line('account_code'); ?> <label class="text-danger">*</label></label>
                                       <div class="col-sm-8">
                                          <input type="text" class="form-control" id="account_code" name="account_code" placeholder="e.g. BANK-01 / 108059345444" value="<?php print $account_code; ?>">
                                          <span id="account_code_msg" style="display:none" class="text-danger"></span>
                                       </div>
                                    </div>

                                    <div class="form-group">
                                       <label for="account_name" class="col-sm-4 control-label"><?= $this->lang->line('account_name'); ?> <label class="text-danger">*</label></label>
                                       <div class="col-sm-8">
                                          <input type="text" class="form-control" id="account_name" name="account_name" placeholder="e.g. Bank Accounts, Dutch Bangla Bank, bKash Merchant" value="<?php print $account_name; ?>">
                                          <span id="account_name_msg" style="display:none" class="text-danger"></span>
                                       </div>
                                    </div>

                                    <div class="form-group">
                                       <label for="opening_balance" class="col-sm-4 control-label"><?= $this->lang->line('opening_balance'); ?></label>
                                       <div class="col-sm-8">
                                          <input type="text" class="form-control only_currency" id="opening_balance" name="opening_balance" placeholder="0.00" value="<?php print store_number_format($opening_balance, 0); ?>">
                                          <span id="opening_balance_msg" style="display:none" class="text-danger"></span>
                                          <p class="help-block text-muted" style="margin-top:4px; margin-bottom:0; font-size:12px;">
                                             <i class="fa fa-info-circle text-primary"></i> Initial starting balance for this account. Setting/updating this will recalculate the running balance.
                                          </p>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="col-md-5">
                                    <div class="form-group">
                                       <label for="note" class="col-sm-3 control-label"><?= $this->lang->line('note'); ?></label>
                                       <div class="col-sm-9">
                                          <textarea class="form-control" id="note" name="note" rows="5" placeholder="Additional notes or account description"><?php print $note; ?></textarea>
                                          <span id="note_msg" style="display:none" class="text-danger"></span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- /.box-body -->
                           <div class="box-footer">
                              <div class="col-sm-8 col-sm-offset-2 text-center">
                                 <?php
                                    if($q_id!=""){
                                       $btn_name="Update";
                                       $btn_id="update";
                                       echo '<input type="hidden" name="q_id" id="q_id" value="'.$q_id.'"/>';
                                    } else {
                                       $btn_name="Save";
                                       $btn_id="save";
                                    }
                                 ?>
                                 <div class="col-md-3 col-md-offset-3">
                                    <button type="button" id="<?php echo $btn_id;?>" class="btn btn-block btn-success" title="Save Data"><?php echo $btn_name;?></button>
                                 </div>
                                 <div class="col-sm-3">
                                    <a href="<?=base_url('accounts');?>">
                                       <button type="button" class="btn btn-block btn-warning close_btn" title="Back to Accounts">Close</button>
                                    </a>
                                 </div>
                              </div>
                           </div>
                           <!-- /.box-footer -->
                        </form>
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

         <!-- MODAL: ADD PARENT HEAD -->
         <div class="modal fade" id="modal_add_parent_head" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header header-custom" style="background-color:#3c8dbc; color:#fff;">
                     <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:0.9;">
                        <span aria-hidden="true">&times;</span>
                     </button>
                     <h4 class="modal-title"><i class="fa fa-folder-open"></i> Add New Parent Account Head</h4>
                  </div>
                  <form id="form_add_parent_head">
                     <div class="modal-body">
                        <p class="text-muted" style="font-size:13px; margin-bottom:15px;">
                           Create a parent category (e.g. <b>Bank Accounts</b>, <b>Mobile Banking (bKash/Nagad)</b>, <b>Cash in Hand</b>).
                        </p>
                        <div class="form-group">
                           <label for="head_account_name">Parent Head Name <span class="text-danger">*</span></label>
                           <input type="text" class="form-control" id="head_account_name" name="account_name" placeholder="e.g. Bank Accounts, Mobile Banking, Cash in Hand" required>
                        </div>
                        <div class="form-group">
                           <label for="head_account_code">Account Code (Optional)</label>
                           <input type="text" class="form-control" id="head_account_code" name="account_code" placeholder="Leave blank to auto-generate">
                        </div>
                        <div class="form-group">
                           <label for="head_opening_balance">Opening Balance</label>
                           <input type="text" class="form-control only_currency" id="head_opening_balance" name="opening_balance" placeholder="0.00" value="0">
                        </div>
                        <div class="form-group">
                           <label for="head_note">Note / Description</label>
                           <textarea class="form-control" id="head_note" name="note" rows="2" placeholder="Description of this parent category"></textarea>
                        </div>
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" id="btn_save_parent_head" onclick="saveParentHeadInline()"><i class="fa fa-check"></i> Save Parent Head</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>

         <?php $this->load->view('footer.php');?>
         <div class="control-sidebar-bg"></div>
      </div>
      <!-- ./wrapper -->

      <!-- SOUND CODE -->
      <?php $this->load->view('comman/code_js_sound.php');?>
      <!-- TABLES CODE -->
      <?php $this->load->view('comman/code_js.php');?>
      <script src="<?php echo $theme_link; ?>js/accounts/accounts.js"></script>
      <script type="text/javascript">
         <?php if(isset($q_id)){ ?>
           $("#store_id").attr('readonly',true);
         <?php } ?>

         function toggleAccountLevel() {
            var isSub = $('#level_sub').is(':checked');
            if(isSub) {
               $('#parent_account_group').slideDown(200);
            } else {
               $('#parent_account_group').slideUp(200);
               $('#parent_id').val('0');
            }
         }

         function saveParentHeadInline() {
            var name = $('#head_account_name').val();
            var code = $('#head_account_code').val();
            var ob   = $('#head_opening_balance').val();
            var note = $('#head_note').val();

            if(!name || $.trim(name) === '') {
               toastr["warning"]("Please enter Parent Head Name!");
               return;
            }

            $('#btn_save_parent_head').attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
            $.ajax({
               type: 'POST',
               url: '<?= base_url('accounts/save_parent_head'); ?>',
               data: {
                  account_name: name,
                  account_code: code,
                  opening_balance: ob,
                  note: note
               },
               dataType: 'json',
               success: function(res) {
                  $('#btn_save_parent_head').attr('disabled', false).html('<i class="fa fa-check"></i> Save Parent Head');
                  if(res && res.status === 'success') {
                     toastr["success"](res.message);
                     $('#modal_add_parent_head').modal('hide');
                     $('#form_add_parent_head')[0].reset();
                     // Append new option to parent dropdown and select it
                     var newOption = new Option(res.name + ' (' + res.code + ')', res.id, true, true);
                     $('#parent_id').append(newOption).trigger('change');
                     $('#level_sub').prop('checked', true);
                     $('#parent_account_group').show();
                  } else {
                     toastr["error"](res.message || "Failed to create Parent Account Head.");
                  }
               },
               error: function() {
                  $('#btn_save_parent_head').attr('disabled', false).html('<i class="fa fa-check"></i> Save Parent Head');
                  toastr["error"]("Network/server error while creating Parent Account Head.");
               }
            });
         }
      </script>
      <!-- Make sidebar menu hughlighter/selector -->
      <script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
   </body>
</html>
