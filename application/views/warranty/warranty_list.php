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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-shield text-primary"></i> <?= $page_title; ?>
        <small>Track repair status, service jobs & warranty fulfillment</small>
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
              <h3 class="box-title"><i class="fa fa-list"></i> Service & Warranty Claims</h3>
              <div class="box-tools pull-right">
                <?php $CI =& get_instance(); ?>
                <?php if ($CI->permissions('warranty_view')) { ?>
                <a class="btn btn-info btn-sm" href="<?php echo $base_url; ?>warranty/check">
                  <i class="fa fa-search"></i> <?= $this->lang->line('check_warranty'); ?>
                </a>
                <a class="btn btn-default btn-sm" href="<?php echo $base_url; ?>warranty/history">
                  <i class="fa fa-history"></i> <?= $this->lang->line('service_history'); ?>
                </a>
                <?php } ?>
                <?php if ($CI->permissions('warranty_add')) { ?>
                <a class="btn btn-primary btn-sm" href="<?php echo $base_url; ?>warranty/add">
                  <i class="fa fa-plus"></i> <?= $this->lang->line('new_warranty_claim'); ?>
                </a>
                <?php } ?>
              </div>
            </div>

            <div class="box-body">
              <!-- Filters -->
              <div class="row margin-bottom">
                <div class="col-md-3">
                  <label>Status Filter</label>
                  <select id="status_filter" class="form-control select2" onchange="reload_table()">
                    <option value="">All Statuses</option>
                    <option value="Received">Received</option>
                    <option value="Under Repair">Under Repair</option>
                    <option value="Ready for Delivery">Ready for Delivery</option>
                    <option value="Delivered">Delivered</option>
                    <option value="Rejected">Rejected</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <label>Customer Filter</label>
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
                <table id="warranty_table" class="table table-bordered table-striped table-hover" width="100%">
                  <thead class="bg-gray">
                    <tr>
                      <th>Job Code</th>
                      <th>Intake Date</th>
                      <th>Customer</th>
                      <th>Product & Serial</th>
                      <th>Expected Delivery</th>
                      <th>Status</th>
                      <th>Total Charge</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Status & Delivery Modal -->
  <div class="modal fade" id="statusModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form id="status_form" method="POST">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
          <div class="modal-header bg-primary" style="color:#fff;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff;"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-wrench"></i> Update Repair Status / Deliver: <span id="modal_code_span"></span></h4>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" id="modal_claim_id" value="">

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Status <span class="text-danger">*</span></label>
                  <select name="status" id="modal_status" class="form-control select2" required style="width:100%;" onchange="toggle_delivery_fields()">
                    <option value="Received">Received</option>
                    <option value="Under Repair">Under Repair</option>
                    <option value="Ready for Delivery">Ready for Delivery</option>
                    <option value="Delivered">Delivered</option>
                    <option value="Rejected">Rejected</option>
                  </select>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group" id="group_delivery_date" style="display:none;">
                  <label>Delivery Date</label>
                  <input type="text" name="delivery_date" id="modal_delivery_date" class="form-control datepicker" value="<?= date('d-m-Y'); ?>">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group" id="group_delivered_to" style="display:none;">
                  <label>Delivered To (Name/Mobile)</label>
                  <input type="text" name="delivered_to" id="modal_delivered_to" class="form-control" placeholder="Recipient Name / Mobile">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Action Taken / Work Done (Customer Facing)</label>
                  <textarea name="action_taken" id="modal_action_taken" class="form-control" rows="2" placeholder="e.g. Motherboard repaired, display replaced, updated firmware, cleaned internal dust..."></textarea>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Internal Technician Notes (Shop Internal)</label>
                  <textarea name="technician_notes" id="modal_technician_notes" class="form-control" rows="2" placeholder="e.g. Tested for 24h, technician signature, remarks..."></textarea>
                </div>
              </div>
            </div>

            <hr>
            <h5 class="text-bold"><i class="fa fa-money"></i> Service & Parts Charges (Leave 0 if Free Under Warranty)</h5>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Service Charge (Tk)</label>
                  <input type="number" step="0.01" min="0" name="service_charge" id="modal_service_charge" class="form-control" value="0.00" oninput="calc_modal_total()">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>Parts Charge (Tk)</label>
                  <input type="number" step="0.01" min="0" name="parts_charge" id="modal_parts_charge" class="form-control" value="0.00" oninput="calc_modal_total()">
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                  <label>Total Charge (Tk)</label>
                  <input type="text" id="modal_total_charge" class="form-control text-bold text-success" readonly value="0.00">
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                  <label>Payment Method</label>
                  <select name="payment_type" id="modal_payment_type" class="form-control select2" style="width:100%;">
                    <?php
                    $q_pt = $this->db->query("SELECT * FROM db_paymenttypes WHERE status=1 AND store_id=" . get_current_store_id());
                    foreach ($q_pt->result() as $pt) {
                      echo "<option value='" . html_escape($pt->payment_type) . "'>" . html_escape($pt->payment_type) . "</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                  <label>Deposit To Account</label>
                  <select name="account_id" id="modal_account_id" class="form-control select2" style="width:100%;">
                    <?php
                    $q_acc = $this->db->query("SELECT * FROM ac_accounts WHERE status=1 AND parent_id=0 AND store_id=" . get_current_store_id() . " ORDER BY id ASC");
                    foreach ($q_acc->result() as $acc) {
                      echo "<option value='" . $acc->id . "'>" . html_escape($acc->account_name) . "</option>";
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success" id="btn_save_status">
              <i class="fa fa-check"></i> Update Status
            </button>
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

  table = $('#warranty_table').DataTable({
    "processing": true,
    "serverSide": true,
    "order": [],
    "responsive": true,
    "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
    "ajax": {
      "url": "<?= base_url('warranty/ajax_list'); ?>",
      "type": "POST",
      "data": function(d) {
        d['<?= $this->security->get_csrf_token_name(); ?>'] = '<?= $this->security->get_csrf_hash(); ?>';
        d.status = $('#status_filter').val();
        d.customer_id = $('#customer_filter').val();
      }
    },
    "columnDefs": [
      { "targets": [7], "orderable": false }
    ]
  });

  $('#status_form').on('submit', function(e) {
    e.preventDefault();
    $('#btn_save_status').attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Updating...');

    var formStatus = $('#modal_status').val();
    var currentClaimId = $('#modal_claim_id').val();

    $.ajax({
      url: "<?= base_url('warranty/update_status'); ?>",
      type: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function(res) {
        $('#btn_save_status').attr('disabled', false).html('<i class="fa fa-check"></i> Update Status');
        if (res.status === 'success') {
          $('#statusModal').modal('hide');
          toastr.success(res.message, 'Success!');
          table.ajax.reload(null, false);

          if (formStatus === 'Delivered') {
            if (confirm('Product status updated to Delivered! Would you like to print the Delivery Slip now?')) {
              window.open("<?= base_url('warranty/print_slip/'); ?>" + currentClaimId + "/delivery", "_blank", "scrollbars=1,resizable=1,height=650,width=800");
            }
          }
        } else {
          toastr.error(res.message, 'Error!');
        }
      },
      error: function() {
        $('#btn_save_status').attr('disabled', false).html('<i class="fa fa-check"></i> Update Status');
        toastr.error('Failed to update status.', 'Error!');
      }
    });
  });
});

function reload_table() {
  table.ajax.reload(null, false);
}

function calc_modal_total() {
  var s = parseFloat($('#modal_service_charge').val()) || 0;
  var p = parseFloat($('#modal_parts_charge').val()) || 0;
  $('#modal_total_charge').val((s + p).toFixed(2));
}

function toggle_delivery_fields() {
  var st = $('#modal_status').val();
  if (st === 'Delivered') {
    $('#group_delivery_date').show();
    $('#group_delivered_to').show();
  } else {
    $('#group_delivery_date').hide();
    $('#group_delivered_to').hide();
  }
}

function open_status_modal(id, is_delivery) {
  $.getJSON("<?= base_url('warranty/get_claim_json/'); ?>" + id, function(claim) {
    if (!claim) return;
    $('#modal_claim_id').val(claim.id);
    $('#modal_code_span').text(claim.warranty_code + ' - ' + claim.item_name);
    if (is_delivery) {
      $('#modal_status').val('Delivered').trigger('change');
    } else {
      $('#modal_status').val(claim.status).trigger('change');
    }
    $('#modal_action_taken').val(claim.action_taken || '');
    $('#modal_technician_notes').val(claim.technician_notes || '');
    $('#modal_delivered_to').val(claim.delivered_to || claim.customer_name || '');
    $('#modal_delivery_date').val(claim.delivery_date ? claim.delivery_date : '<?= date('d-m-Y'); ?>');
    $('#modal_service_charge').val(parseFloat(claim.service_charge || 0).toFixed(2));
    $('#modal_parts_charge').val(parseFloat(claim.parts_charge || 0).toFixed(2));
    if (claim.payment_type) {
      $('#modal_payment_type').val(claim.payment_type).trigger('change');
    }
    if (claim.account_id) {
      $('#modal_account_id').val(claim.account_id).trigger('change');
    }
    calc_modal_total();
    toggle_delivery_fields();
    $('#statusModal').modal('show');
  });
}

function open_delivery_modal(id) {
  open_status_modal(id, true);
}

function delete_claim(id) {
  if (confirm("Are you sure you want to delete this warranty claim? This cannot be undone.")) {
    $.ajax({
      url: "<?= base_url('warranty/delete'); ?>",
      type: "POST",
      data: { id: id },
      success: function(res) {
        if (res === 'success') {
          toastr.success('Claim deleted successfully', 'Success!');
          table.ajax.reload(null, false);
        } else {
          toastr.error('Failed to delete claim', 'Error!');
        }
      }
    });
  }
}
</script>
<script>$(".warranty_list-active-li").addClass("active");</script>
</body>
</html>
