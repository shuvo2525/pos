<!DOCTYPE html>
<html>
<head>
<!-- TABLES CSS CODE -->
<?php $this->load->view('comman/code_css.php');?>
<style>
.modal-header-custom {
  background-color: #3c8dbc;
  color: #fff;
  border-top-left-radius: 4px;
  border-top-right-radius: 4px;
}
.modal-header-custom .close {
  color: #fff;
  opacity: 0.8;
}
</style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Left side column. contains the logo and sidebar -->
  <?php $this->load->view('sidebar');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-calculator text-primary"></i> <?= $page_title; ?>
        <small>Manage customer installment & EMI plans</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?= $page_title; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- ********** ALERT MESSAGE START******* -->
      <?php $this->load->view('comman/code_flashdata.php');?>
      <!-- ********** ALERT MESSAGE END******* -->

      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-list"></i> EMI / Installment Plans</h3>
              <div class="box-tools pull-right">
                <?php $CI =& get_instance(); ?>
                <?php if ($CI->permissions('emi_add')) { ?>
                <a class="btn btn-primary btn-sm" href="<?php echo $base_url; ?>emi/add">
                  <i class="fa fa-plus"></i> <?= $this->lang->line('new_emi_plan'); ?>
                </a>
                <?php } ?>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row margin-bottom">
                <div class="col-md-3">
                  <label>Status Filter</label>
                  <select id="status_filter" class="form-control select2" onchange="reload_table()">
                    <option value="">All Status</option>
                    <option value="Active">Active</option>
                    <option value="Completed">Completed</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <label>Customer</label>
                  <select id="customer_filter" class="form-control select2" onchange="reload_table()">
                    <option value="">All Customers</option>
                    <?php
                    $q_cust = $this->db->query("SELECT id, customer_name, mobile FROM db_customers WHERE status=1 AND store_id=" . get_current_store_id());
                    foreach ($q_cust->result() as $c) {
                      echo "<option value='" . $c->id . "'>" . html_escape($c->customer_name) . " (" . html_escape($c->mobile) . ")</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="table-responsive">
                <table id="emi_table" class="table table-bordered table-striped table-hover" width="100%">
                  <thead class="bg-gray">
                    <tr>
                      <th>Plan Code</th>
                      <th>Start Date</th>
                      <th>Customer</th>
                      <th>Product / Details</th>
                      <th>Total Payable</th>
                      <th>Down Payment</th>
                      <th>Paid</th>
                      <th>Due</th>
                      <th>Installments</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->

  <!-- Quick Pay Modal -->
  <div class="modal fade" id="quickPayModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form id="quick_pay_form" method="POST">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
          <div class="modal-header modal-header-custom">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-money"></i> Pay EMI Installment</h4>
          </div>
          <div class="modal-body">
            <input type="hidden" name="emi_id" id="modal_emi_id" value="">
            <div class="form-group">
              <label>Select Installment <span class="text-danger">*</span></label>
              <select name="installment_id" id="modal_installment_id" class="form-control" required onchange="on_installment_change()">
                <option value="">-- Select Installment --</option>
              </select>
            </div>
            <div class="form-group">
              <label>Due Amount (Tk)</label>
              <input type="text" id="modal_due_display" class="form-control" readonly value="0.00">
            </div>
            <div class="form-group">
              <label>Payment Amount (Tk) <span class="text-danger">*</span></label>
              <input type="number" step="0.01" min="1" name="payment_amount" id="modal_payment_amount" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Payment Date <span class="text-danger">*</span></label>
              <input type="text" name="payment_date" id="modal_payment_date" class="form-control datepicker" value="<?= date('d-m-Y'); ?>" required>
            </div>
            <div class="form-group">
              <label>Payment Method <span class="text-danger">*</span></label>
              <select name="payment_type" id="modal_payment_type" class="form-control select2" required style="width:100%;">
                <?php
                $q_pt = $this->db->query("SELECT * FROM db_paymenttypes WHERE status=1 AND store_id=" . get_current_store_id());
                foreach ($q_pt->result() as $pt) {
                  echo "<option value='" . html_escape($pt->payment_type) . "'>" . html_escape($pt->payment_type) . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label>Deposit To Account (Cash Box / Bank) <span class="text-danger">*</span></label>
              <select name="account_id" id="modal_account_id" class="form-control select2" required style="width:100%;">
                <?php
                $q_acc = $this->db->query("SELECT * FROM ac_accounts WHERE status=1 AND parent_id=0 AND store_id=" . get_current_store_id() . " ORDER BY id ASC");
                foreach ($q_acc->result() as $acc) {
                  echo "<option value='" . $acc->id . "'>" . html_escape($acc->account_name) . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label>Payment Note / Reference</label>
              <textarea name="payment_note" id="modal_payment_note" class="form-control" rows="2" placeholder="e.g. Bank Trx ID, Cheque No, etc."></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success" id="btn_submit_pay"><i class="fa fa-check"></i> Submit Payment</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php $this->load->view('footer');?>
  <div class="control-sidebar-bg"></div>
</div>

<!-- SOUND CODE -->
<?php $this->load->view('comman/code_js_sound.php');?>
<!-- TABLES CODE -->
<?php $this->load->view('comman/code_js.php');?>
<script src="<?php echo $theme_link; ?>plugins/datepicker/bootstrap-datepicker.js"></script>

<script type="text/javascript">
var table;
$(document).ready(function() {
  $('.datepicker').datepicker({
    autoclose: true,
    format: 'dd-mm-yyyy',
    todayHighlight: true
  });
  $('.select2').select2();

  table = $('#emi_table').DataTable({
    "processing": true,
    "serverSide": true,
    "order": [],
    "responsive": true,
    "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
    "ajax": {
      "url": "<?= base_url('emi/ajax_list'); ?>",
      "type": "POST",
      "data": function(d) {
        d['<?= $this->security->get_csrf_token_name(); ?>'] = '<?= $this->security->get_csrf_hash(); ?>';
        d.status = $('#status_filter').val();
        d.customer_id = $('#customer_filter').val();
      }
    },
    "columnDefs": [
      { "targets": [10], "orderable": false }
    ]
  });

  // Handle quick pay submit
  $('#quick_pay_form').on('submit', function(e) {
    e.preventDefault();
    $('#btn_submit_pay').attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');

    $.ajax({
      url: "<?= base_url('emi/pay_installment'); ?>",
      type: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function(res) {
        $('#btn_submit_pay').attr('disabled', false).html('<i class="fa fa-check"></i> Submit Payment');
        if (res.status === 'success') {
          $('#quickPayModal').modal('hide');
          toastr.success(res.message, 'Success!');
          table.ajax.reload(null, false);
          // Prompt print receipt
          if (confirm('Payment recorded successfully! Would you like to print the Money Receipt now?')) {
            window.open("<?= base_url('emi/print_receipt/'); ?>" + res.receipt_id, "_blank", "scrollbars=1,resizable=1,height=650,width=800");
          }
        } else {
          toastr.error(res.message, 'Error!');
        }
      },
      error: function() {
        $('#btn_submit_pay').attr('disabled', false).html('<i class="fa fa-check"></i> Submit Payment');
        toastr.error('Failed to process payment.', 'Error!');
      }
    });
  });
});

function reload_table() {
  table.ajax.reload(null, false);
}

function quick_pay_modal(emi_id) {
  $('#modal_emi_id').val(emi_id);
  $('#modal_installment_id').html('<option value="">Loading installments...</option>');
  $('#modal_due_display').val('0.00');
  $('#modal_payment_amount').val('');
  $('#quickPayModal').modal('show');

  // Load installments for this EMI
  $.ajax({
    url: "<?= base_url('emi/details/'); ?>" + emi_id,
    type: "GET",
    dataType: "html",
    success: function() {
      // Fetch json installments
      $.getJSON("<?= base_url('emi/details/'); ?>" + emi_id, function() {});
    }
  });

  // Fetch pending installments via direct call
  $.ajax({
    url: "<?= base_url('emi/get_installment_info/'); ?>0",
    type: "POST",
    data: { emi_id: emi_id },
    complete: function() {
      // Alternative: fetch from details page or redirect
      window.location.href = "<?= base_url('emi/details/'); ?>" + emi_id + "#pay";
    }
  });
}

function delete_emi(id) {
  if (confirm("Are you sure you want to delete this EMI plan and all its installments and payment records? This action cannot be undone.")) {
    $.ajax({
      url: "<?= base_url('emi/delete'); ?>",
      type: "POST",
      data: { 
        id: id,
        '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
      },
      success: function(res) {
        if (res === 'success') {
          toastr.success('EMI plan deleted successfully', 'Success!');
          table.ajax.reload(null, false);
        } else {
          toastr.error('Failed to delete EMI plan', 'Error!');
        }
      }
    });
  }
}
</script>
<script>$(".emi_list-active-li").addClass("active");</script>
</body>
</html>
