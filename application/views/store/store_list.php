<!DOCTYPE html>
<html>

<head>
<!-- TABLES CSS CODE -->
<?php $this->load->view('comman/code_css.php');?>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Left side column. contains the logo and sidebar -->
  <?php $this->load->view('sidebar');?>
  <?php $CI =& get_instance(); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$page_title;?>
        <small>View/Search Items Store</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?=$page_title;?></li>
      </ol>
    </section>

    <!-- Main content -->
    <?= form_open('#', array('class' => '', 'id' => 'table_form')); ?>
    <input type="hidden" id='base_url' value="<?=$base_url;?>">
    <section class="content">
      <div class="row">
        <!-- ********** ALERT MESSAGE START******* -->
        <?php $this->load->view('comman/code_flashdata.php');?>
        <!-- ********** ALERT MESSAGE END******* -->
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?=$page_title;?></h3>
              <?php if($CI->permissions('store_add')) { ?>
              <div class="box-tools">
                <a class="btn btn-block btn-info" href="<?php echo $base_url; ?>store/add">
                <i class="fa fa-plus"></i> <?= $this->lang->line('add_store'); ?></a>
              </div>
              <?php } ?>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered custom_hover" width="100%">
                <thead class="bg-gray ">
                <tr>
                  <th class="text-center">
                    <input type="checkbox" class="group_check checkbox" >
                  </th>
                  <th><?= $this->lang->line('store_code'); ?></th>
                  <th><?= $this->lang->line('store_name'); ?></th>
                  <th><?= $this->lang->line('mobile'); ?></th>
                  <th><?= $this->lang->line('address'); ?></th>
                  <th><?= $this->lang->line('created_date'); ?></th>
                  <th><?= $this->lang->line('created_by'); ?></th>
                  <th><?= $this->lang->line('package_name'); ?></th>
                  <th><?= $this->lang->line('expire_date'); ?></th>
                  <th><?= $this->lang->line('status'); ?></th>
                  <th><?= $this->lang->line('action'); ?></th>
                </tr>
                </thead>
                <tbody>
        
                </tbody>
               
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    <?= form_close();?>
  </div>
  <!-- /.content-wrapper -->

  <!-- Simplified Subscription Calendar Date Modal -->
  <div class="modal fade" id="sub_date_modal" role="dialog" aria-labelledby="subDateModalLabel" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content" style="border-radius:12px; overflow:hidden; box-shadow:0 15px 35px rgba(0,0,0,0.2);">
        <div class="modal-header" style="background:linear-gradient(135deg, #2563eb 0%, #7c3aed 100%); color:#fff; padding:18px 24px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:0.8; font-size:24px;">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="subDateModalLabel" style="font-weight:700; font-size:18px;">
            <i class="fa fa-calendar-check-o"></i> Store Monthly Subscription & Auto-Lock Date
          </h4>
          <small style="color:#e0e7ff; font-size:12px;">Set Monthly Subscription & Auto-Lock Date</small>
        </div>

        <form id="sub_date_form" method="POST">
          <input type="hidden" name="store_id" id="modal_sub_store_id" value="">

          <div class="modal-body" style="padding:22px 24px;">
            <!-- Store info card -->
            <div class="modal-store-info-box" style="border-radius:10px; padding:12px 18px; margin-bottom:18px;">
              <span style="font-size:11px; text-transform:uppercase; font-weight:700; opacity:0.8; display:block;">Selected Store</span>
              <strong id="modal_sub_store_name" style="font-size:16px;"></strong>
              <span id="modal_sub_store_code" class="label label-primary" style="margin-left:8px; font-size:11px;"></span>
            </div>

            <!-- Single Calendar Date Picker -->
            <div class="form-group" style="margin-bottom:12px;">
              <label for="modal_sub_date" style="font-weight:700; font-size:14px;">
                <i class="fa fa-calendar text-primary"></i> Select Subscription Expiry / Monthly Due Date:
                <span class="text-danger">*</span>
              </label>
              <div class="input-group">
                <span class="input-group-addon" style="border-radius:8px 0 0 8px; font-size:16px;"><i class="fa fa-calendar-check-o text-primary"></i></span>
                <input type="date" class="form-control input-lg" id="modal_sub_date" name="sub_date" style="border-radius:0 8px 8px 0; font-weight:700; font-size:15px;" required>
              </div>
              <p class="help-block" style="font-size:12.5px; margin-top:8px; line-height:1.5;">
                <i class="fa fa-info-circle text-primary"></i> The store will be automatically locked each month on this day if subscription payment is not received.
              </p>
            </div>

          </div>

          <div class="modal-footer modal-footer-themed" style="padding:14px 24px;">
            <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius:6px; font-weight:600; padding:8px 18px;">
              Cancel
            </button>
            <button type="button" class="btn btn-primary" onclick="save_sub_date()" id="btn_save_sub_date" style="background:linear-gradient(135deg, #2563eb 0%, #7c3aed 100%); border:0; border-radius:6px; font-weight:700; padding:8px 24px; box-shadow:0 4px 12px rgba(124,58,237,0.3);">
              <i class="fa fa-check"></i> Save Date
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Upload Shop Backup Modal -->
  <div class="modal fade" id="upload_shop_backup_modal" role="dialog" aria-labelledby="uploadShopBackupModalLabel" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content" style="border-radius:12px; overflow:hidden; box-shadow:0 15px 35px rgba(0,0,0,0.2);">
        <div class="modal-header" style="background:linear-gradient(135deg, #0284c7 0%, #2563eb 100%); color:#fff; padding:18px 24px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:0.8; font-size:24px;">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="uploadShopBackupModalLabel" style="font-weight:700; font-size:18px;">
            <i class="fa fa-upload"></i> Upload & Restore Store Database Backup
          </h4>
          <small style="color:#e0e7ff; font-size:12px;">Upload & Restore Shop-Specific Database Backup</small>
        </div>

        <form id="upload_shop_backup_form" enctype="multipart/form-data">
          <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
          <input type="hidden" name="store_id" id="modal_upload_store_id" value="">

          <div class="modal-body" style="padding:22px 24px;">
            <!-- Store info card -->
            <div class="modal-store-info-box" style="border-radius:10px; padding:12px 18px; margin-bottom:18px;">
              <span style="font-size:11px; text-transform:uppercase; font-weight:700; opacity:0.8; display:block;">Target Store</span>
              <strong id="modal_upload_store_name" style="font-size:16px;"></strong>
              <span id="modal_upload_store_code" class="label label-info" style="margin-left:8px; font-size:11px;"></span>
            </div>

            <!-- File Input -->
            <div class="form-group">
              <label for="shop_backup_file" style="font-weight:700;">
                <i class="fa fa-file-text-o text-primary"></i> Select Backup File (.sql):
                <span class="text-danger">*</span>
              </label>
              <input type="file" class="form-control" id="shop_backup_file" name="backup_file" accept=".sql,.json,.txt" required style="padding:6px; border-radius:8px;">
              <p class="help-block" style="font-size:12px; margin-top:4px;">
                Upload a previously downloaded backup file (.sql). The data will be safely mapped and restored into this store.
              </p>
            </div>

            <!-- Clean existing data checkbox -->
            <div class="form-group modal-warning-box" style="border-radius:8px; padding:10px 14px; margin-bottom:10px;">
              <label style="margin:0; font-weight:600; cursor:pointer;">
                <input type="checkbox" id="clean_existing_data" name="clean_existing" value="1" checked style="margin-right:6px;">
                Clean existing store data before restoring (Recommended)
              </label>
            </div>

          </div>

          <div class="modal-footer modal-footer-themed" style="padding:14px 24px;">
            <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius:6px; font-weight:600; padding:8px 18px;">
              Cancel
            </button>
            <button type="button" class="btn btn-primary" onclick="submit_upload_shop_backup()" id="btn_upload_shop_backup" style="background:linear-gradient(135deg, #0284c7 0%, #2563eb 100%); border:0; border-radius:6px; font-weight:700; padding:8px 24px; box-shadow:0 4px 12px rgba(2,132,199,0.3);">
              <i class="fa fa-upload"></i> Upload & Restore
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php $this->load->view('footer');?>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- SOUND CODE -->
<?php $this->load->view('comman/code_js_sound.php');?>
<!-- TABLES CODE -->
<?php $this->load->view('comman/code_js.php');?>

<script type="text/javascript">
$(document).ready(function() {
    //datatables
   var table = $('#example2').DataTable({ 

      /* FOR EXPORT BUTTONS START*/
  dom:'<"row margin-bottom-12"<"col-sm-12"<"pull-left"l><"pull-right"fr><"pull-right margin-left-10 "B>>>tip',
 /* dom:'<"row"<"col-sm-12"<"pull-left"B><"pull-right">>> <"row margin-bottom-12"<"col-sm-12"<"pull-left"l><"pull-right"fr>>>tip',*/
      buttons: {
        buttons: [
            {
                className: 'btn bg-red color-palette btn-flat hidden delete_btn pull-left',
                text: 'Delete',
                action: function ( e, dt, node, config ) {
                    multi_delete();
                }
            },
            { extend: 'copy', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [1,2,3,4,5,6,7,8]} },
            { extend: 'excel', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [1,2,3,4,5,6,7,8]} },
            { extend: 'pdf', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [1,2,3,4,5,6,7,8]} },
            { extend: 'print', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [1,2,3,4,5,6,7,8]} },
            { extend: 'csv', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [1,2,3,4,5,6,7,8]} },
            { extend: 'colvis', className: 'btn bg-teal color-palette btn-flat',text:'Columns' },  

            ]
        },
        /* FOR EXPORT BUTTONS END */

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "responsive": true,
        language: {
            processing: '<div class="text-primary bg-primary" style="position: relative;z-index:100;overflow: visible;">Processing...</div>'
        },
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('store/ajax_list')?>",
            "type": "POST",
            
            complete: function (data) {
             $('.column_checkbox').iCheck({
                checkboxClass: 'icheckbox_square-orange',
                /*uncheckedClass: 'bg-white',*/
                radioClass: 'iradio_square-orange',
                increaseArea: '10%' // optional
              });
             call_code();
              //$(".delete_btn").hide();
             },

        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0,9,10 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        {
            "targets" :[0],
            "className": "text-center",
        },
        
        ],
    });
    new $.fn.dataTable.FixedHeader( table );
});
</script>
<script type="text/javascript">
function lock_store_direct(store_id){
    if(confirm("Do you want to lock this store? Access to the store will be restricted until unlocked or payment is received.")){
        var base_url = $("#base_url").val();
        $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
        $.post(base_url + "store/lock_store", {store_id: store_id}, function(result){
            $(".overlay").remove();
            if(result.trim() == "success"){
                toastr["success"]("Store locked successfully!");
                $('#example2').DataTable().ajax.reload();
            } else {
                toastr["error"](result);
            }
        }).fail(function(xhr, status, error){
            $(".overlay").remove();
            toastr["error"]("Request failed: " + error);
        });
    }
}

function unlock_store_direct(store_id){
    if(confirm("Do you want to authorize and unlock this store? It will be activated and the next month's lock date will be scheduled automatically.")){
        var base_url = $("#base_url").val();
        $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
        $.post(base_url + "store/unlock_store", {store_id: store_id}, function(result){
            $(".overlay").remove();
            if(result.trim() == "success"){
                toastr["success"]("Store authorized & unlocked successfully! Next month's lock date has been scheduled.");
                $('#example2').DataTable().ajax.reload();
            } else {
                toastr["error"](result);
            }
        }).fail(function(xhr, status, error){
            $(".overlay").remove();
            toastr["error"]("Request failed: " + error);
        });
    }
}

function authorize_subscription(id){
    if(confirm("Do you want to authorize and activate this store's subscription?")){
        var base_url = $("#base_url").val();
        $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
        $.post(base_url + "subscribers/authorize_subscription", {id: id}, function(result){
            $(".overlay").remove();
            if(result.trim() == "success"){
                toastr["success"]("Store Subscription Authorized & Activated Successfully!");
                $('#example2').DataTable().ajax.reload();
            } else {
                toastr["error"](result);
            }
        });
    }
}

function unsubscribe_subscription(id){
    if(confirm("Do you want to Unsubscribe and Lock this store's subscription? The store owner will be locked from adding new records until reactivated or renewed.")){
        var base_url = $("#base_url").val();
        $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
        $.post(base_url + "subscribers/unsubscribe_subscription", {id: id}, function(result){
            $(".overlay").remove();
            if(result.trim() == "success"){
                toastr["success"]("Store Subscription Unsubscribed & Locked Successfully!");
                $('#example2').DataTable().ajax.reload();
            } else {
                toastr["error"](result);
            }
        });
    }
}

function open_sub_date_modal(store_id, store_name, store_code, auto_lock_date){
    $('#modal_sub_store_id').val(store_id);
    $('#modal_sub_store_name').text(store_name);
    $('#modal_sub_store_code').text('Code: ' + (store_code || '-'));

    if(auto_lock_date && auto_lock_date != '0000-00-00' && auto_lock_date != 'null' && auto_lock_date != ''){
        $('#modal_sub_date').val(auto_lock_date);
    } else {
        // Default to 1 month from now or current date + 30 days
        var d = new Date();
        d.setMonth(d.getMonth() + 1);
        var yyyy = d.getFullYear();
        var mm = String(d.getMonth() + 1).padStart(2, '0');
        var dd = String(d.getDate()).padStart(2, '0');
        $('#modal_sub_date').val(yyyy + '-' + mm + '-' + dd);
    }

    $('#sub_date_modal').modal('show');
}

function save_sub_date(){
    var store_id = $('#modal_sub_store_id').val();
    var sub_date = $('#modal_sub_date').val();

    if(!sub_date || sub_date.trim() === ''){
        toastr["warning"]("Please select a date from the calendar!");
        return;
    }

    var base_url = $("#base_url").val();
    var btn = $('#btn_save_sub_date');
    btn.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

    $.ajax({
        url: base_url + 'store/save_subscription_date',
        type: 'POST',
        data: {
            store_id: store_id,
            sub_date: sub_date
        },
        success: function(result){
            btn.attr('disabled', false).html('<i class="fa fa-check"></i> Save Date');
            if(result.trim() == 'success'){
                toastr["success"]("Store monthly subscription and auto-lock date saved successfully!");
                $('#sub_date_modal').modal('hide');
                $('#example2').DataTable().ajax.reload();
            } else {
                toastr["error"](result);
            }
        },
        error: function(xhr, status, error){
            btn.attr('disabled', false).html('<i class="fa fa-check"></i> Save Date');
            toastr["error"]("Request failed: " + error);
        }
    });
}

function open_upload_shop_backup_modal(store_id, store_name, store_code){
    $('#modal_upload_store_id').val(store_id);
    $('#modal_upload_store_name').text(store_name);
    $('#modal_upload_store_code').text('Code: ' + (store_code || '-'));
    $('#shop_backup_file').val('');
    $('#clean_existing_data').prop('checked', true);
    $('#upload_shop_backup_modal').modal('show');
}

function submit_upload_shop_backup(){
    var fileInput = document.getElementById('shop_backup_file');
    if(!fileInput.files || fileInput.files.length === 0){
        toastr["warning"]("Please select a backup file (.sql) to upload!");
        return;
    }

    var form = document.getElementById('upload_shop_backup_form');
    var formData = new FormData(form);
    var base_url = $("#base_url").val();
    var btn = $('#btn_upload_shop_backup');
    btn.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Restoring data, please wait...');

    // Explicitly append CSRF token if not already present
    var csrfName = '<?=$this->security->get_csrf_token_name();?>';
    var csrfHash = '<?=$this->security->get_csrf_hash();?>';
    if(!formData.has(csrfName)){
        formData.append(csrfName, csrfHash);
    }

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
                $('#upload_shop_backup_modal').modal('hide');
                $('#example2').DataTable().ajax.reload();
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

function confirm_delete_shop_data(store_id, store_name, store_code){
    var msg = "⚠️ Are you sure you want to delete all operational data (items, stock, sales, purchases, customers, suppliers, and accounts) for store '" + store_name + " (" + store_code + ")'?\n\nWARNING: Once deleted, this data cannot be recovered unless restored from a backup file.\n\nDo you want to proceed?";
    if(confirm(msg)){
        if(confirm("Final Confirmation: Are you absolutely sure you want to reset and delete all operational data for '" + store_name + "'?")){
            var base_url = $("#base_url").val();
            $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
            $.post(base_url + "store/delete_shop_data", {store_id: store_id}, function(result){
                $(".overlay").remove();
                if(result.trim() == "success"){
                    toastr["success"]("All operational data for '" + store_name + "' has been deleted successfully!");
                    $('#example2').DataTable().ajax.reload();
                } else {
                    toastr["error"](result);
                }
            }).fail(function(xhr, status, error){
                $(".overlay").remove();
                toastr["error"]("Request failed: " + error);
            });
        }
    }
}
</script>
<script src="<?php echo $theme_link; ?>js/store/store.js"></script>
<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
</body>
</html>

