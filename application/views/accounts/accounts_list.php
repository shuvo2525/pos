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
        <?= $this->lang->line('accounts_list'); ?>
        <small>View/Search Accounts</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?= $this->lang->line('accounts_list'); ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <?= form_open('#', array('class' => '', 'id' => 'table_form')); ?>
    <input type="hidden" id='base_url' value="<?=$base_url;?>">
    <section class="content">
      <div class="row">
        <!-- ********** ALERT MESSAGE START******* -->
          <?php $this->load->view('comman/code_flashdata');?>
            <!-- ********** ALERT MESSAGE END******* -->
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-sitemap text-aqua"></i> <?= $this->lang->line('accounts_list'); ?></h3>
              <?php if($CI->permissions('accounts_add')) { ?>
              <div class="box-tools pull-right" style="display:flex; gap:8px;">
                <a class="btn btn-warning" href="<?php echo $base_url; ?>accounts/account_heads">
                  <i class="fa fa-folder-open"></i> Account Heads
                </a>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_add_parent_head">
                  <i class="fa fa-plus-circle"></i> + Add Head
                </button>
                <a class="btn btn-info" href="<?php echo $base_url; ?>accounts/add">
                  <i class="fa fa-plus"></i> <?= $this->lang->line('create_account'); ?>
                </a>
              </div>
              <?php } ?>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="alert alert-info alert-dismissible" style="margin-bottom:15px; font-size:13px;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="fa fa-info-circle"></i> <b>Account Structure Tip:</b> <b>Parent Account Heads</b> (e.g. Bank Accounts, Mobile Banking, Cash in Hand) group multiple sub-accounts. Click <b>+ Add Parent Head</b> to create a head, or click <b>Action &gt; Add Sub-Account</b> on any parent head to add sub-accounts under it (e.g. multiple bank accounts under Bank, multiple bKash accounts under Mobile Banking).
              </div>
              <table id="example2" class="table table-bordered custom_hover" width="100%">
                <thead class="bg-gray ">
                <tr>
                  <th class="text-center">
                    <input type="checkbox" class="group_check checkbox" >
                  </th>
                  <!-- <th><?= $this->lang->line('store_name'); ?></th> -->
                  <th><?= $this->lang->line('account_code'); ?></th>
                  <th><?= $this->lang->line('account_name'); ?></th>
                  <th><?= $this->lang->line('parent_account_name'); ?></th>
                  <th><?= $this->lang->line('balance'); ?></th>
                  <th><?= $this->lang->line('created_by'); ?></th>
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

  <!-- MODAL: ADD PARENT HEAD -->
  <div class="modal fade" id="modal_add_parent_head" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header header-custom" style="background-color:#3c8dbc; color:#fff;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:0.9;">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title"><i class="fa fa-folder-open"></i> Add New Parent Account Head</h4>
        </div>
        <form id="form_add_parent_head">
          <div class="modal-body">
            <p class="text-muted" style="font-size:13px; margin-bottom:15px;">
              Create a main parent category (e.g. <b>Bank Accounts</b>, <b>Mobile Banking (bKash/Nagad)</b>, <b>Cash in Hand</b>, <b>Card Terminal</b>). You can then add multiple specific accounts under this head.
            </p>
            <div class="form-group">
              <label for="head_account_name">Parent Head Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="head_account_name" name="account_name" placeholder="e.g. Bank Accounts, Mobile Banking, Cash in Hand" required>
            </div>
            <div class="form-group">
              <label for="head_account_code">Account Code (Optional)</label>
              <input type="text" class="form-control" id="head_account_code" name="account_code" placeholder="Leave blank to auto-generate (e.g. BANK-2, MBANK-2)">
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
            <button type="button" class="btn btn-success" id="btn_save_parent_head" onclick="saveParentHead()"><i class="fa fa-check"></i> Save Parent Head</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php $this->load->view('footer.php');?>
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
      "aLengthMenu": [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
      /* FOR EXPORT BUTTONS START*/
  dom:'<"row margin-bottom-12"<"col-sm-12"<"pull-left"l><"pull-right"fr><"pull-right margin-left-10 "B>>>tip',
      buttons: {
        buttons: [
            {
                className: 'btn bg-red color-palette btn-flat hidden delete_btn pull-left',
                text: 'Delete',
                action: function ( e, dt, node, config ) {
                    multi_delete();
                }
            },
            { extend: 'copy', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [1,2,3,4,5]} },
            { extend: 'excel', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [1,2,3,4,5]} },
            { extend: 'pdf', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [1,2,3,4,5]} },
            { extend: 'print', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [1,2,3,4,5]} },
            { extend: 'csv', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [1,2,3,4,5]} },
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
            "url": "<?php echo site_url('accounts/ajax_list')?>",
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
            "targets": [ 0,6 ], //first column / numbering column
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

function saveParentHead() {
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
        $('#example2').DataTable().ajax.reload();
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

<script src="<?php echo $theme_link; ?>js/accounts/accounts.js"></script>
<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
		
</body>
</html>
