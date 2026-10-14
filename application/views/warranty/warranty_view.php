<!DOCTYPE html>
<html>
<head>
<!-- TABLES CSS CODE -->
<?php $this->load->view('comman/code_css.php');?>
<style>
.detail-card {
  background: #ffffff;
  border-radius: 8px;
  border: 1px solid #e2e8f0;
  padding: 18px;
  margin-bottom: 20px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.06);
}
.detail-title {
  font-size: 14px;
  font-weight: 700;
  text-transform: uppercase;
  color: #3b82f6;
  border-bottom: 1px solid #e2e8f0;
  padding-bottom: 8px;
  margin-bottom: 12px;
}
.kpi-stat {
  font-size: 20px;
  font-weight: 700;
  color: #0f172a;
}
</style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<?php $CI =& get_instance(); ?>
<div class="wrapper">

  <!-- Left side column. contains the logo and sidebar -->
  <?php $this->load->view('sidebar');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-id-card-o text-primary"></i> <?= $page_title; ?>
        <small>Product repair job card & warranty claim record</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $base_url; ?>warranty"><?= $this->lang->line('warranty_list'); ?></a></li>
        <li class="active"><?= $claim->warranty_code; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- ********** ALERT MESSAGE START******* -->
      <?php $this->load->view('comman/code_flashdata.php');?>
      <!-- ********** ALERT MESSAGE END******* -->

      <!-- Action buttons -->
      <div class="row margin-bottom">
        <div class="col-md-12 text-right">
          <a href="<?= base_url('warranty'); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Claims List</a>
          <?php if($claim->status != 'Delivered') { ?>
          <button type="button" class="btn btn-success" onclick="open_delivery_modal()"><i class="fa fa-truck"></i> Deliver Product</button>
          <?php } ?>
          <button type="button" class="btn btn-warning" onclick="open_status_modal(<?= $claim->id; ?>)"><i class="fa fa-refresh"></i> Update Status / Charges</button>
          <a href="<?= base_url('warranty/print_slip/' . $claim->id . '/receiving'); ?>" target="_blank" class="btn btn-info"><i class="fa fa-print"></i> Print Receiving Slip</a>
          <a href="<?= base_url('warranty/pdf_slip/' . $claim->id . '/receiving'); ?>" target="_blank" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> PDF Receiving Slip</a>

          <?php if($claim->status == 'Delivered' || $claim->total_charge > 0) { ?>
          <a href="<?= base_url('warranty/print_slip/' . $claim->id . '/delivery'); ?>" target="_blank" class="btn btn-success"><i class="fa fa-print"></i> Print Delivery Slip</a>
          <a href="<?= base_url('warranty/pdf_slip/' . $claim->id . '/delivery'); ?>" target="_blank" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> PDF Delivery Slip</a>
          <?php } ?>
        </div>
      </div>

      <div class="row">
        <!-- Column 1: Customer & Product Info -->
        <div class="col-md-6">
          <div class="detail-card">
            <div class="detail-title"><i class="fa fa-user"></i> Customer Information</div>
            <table class="table table-bordered table-striped" style="margin-bottom: 0;">
              <tr>
                <td width="35%"><strong>Customer Name</strong></td>
                <td><strong class="text-primary"><?= html_escape($claim->customer_name); ?></strong></td>
              </tr>
              <tr>
                <td><strong>Mobile / Phone</strong></td>
                <td><?= html_escape($claim->customer_mobile); ?></td>
              </tr>
              <?php if(!empty($claim->customer_email)) { ?>
              <tr>
                <td><strong>Email</strong></td>
                <td><?= html_escape($claim->customer_email); ?></td>
              </tr>
              <?php } ?>
              <tr>
                <td><strong>Address</strong></td>
                <td><?= html_escape($claim->customer_address); ?><?= !empty($claim->customer_city) ? ', ' . html_escape($claim->customer_city) : ''; ?></td>
              </tr>
            </table>
          </div>

          <div class="detail-card">
            <div class="detail-title"><i class="fa fa-cube"></i> Product & Warranty Information</div>
            <table class="table table-bordered table-striped" style="margin-bottom: 0;">
              <tr>
                <td width="35%"><strong>Product Name</strong></td>
                <td><strong><?= html_escape($claim->item_name); ?></strong></td>
              </tr>
              <tr>
                <td><strong>Serial / IMEI No</strong></td>
                <td><strong class="text-primary"><i class="fa fa-barcode"></i> <?= !empty($claim->serial_no) ? html_escape($claim->serial_no) : '-'; ?></strong></td>
              </tr>
              <tr>
                <td><strong>Sales Invoice Ref</strong></td>
                <td><?= !empty($claim->sales_code) ? html_escape($claim->sales_code) : '-'; ?></td>
              </tr>
              <tr>
                <td><strong>Purchase Date</strong></td>
                <td><?= !empty($claim->purchase_date) ? show_date($claim->purchase_date) : '-'; ?></td>
              </tr>
              <tr>
                <td><strong>Warranty Period</strong></td>
                <td><?= $claim->warranty_period_days; ?> Days</td>
              </tr>
              <tr>
                <td><strong>Warranty Expiry</strong></td>
                <td>
                  <?php if(!empty($claim->warranty_expiry_date)) {
                    $is_valid = (strtotime($claim->warranty_expiry_date) >= strtotime(date('Y-m-d')));
                    echo show_date($claim->warranty_expiry_date) . ' ' . ($is_valid ? '<span class="label label-success">Under Warranty</span>' : '<span class="label label-danger">Expired</span>');
                  } else { echo '-'; } ?>
                </td>
              </tr>
            </table>
          </div>
        </div>

        <!-- Column 2: Job Card Details & Status -->
        <div class="col-md-6">
          <div class="detail-card">
            <div class="detail-title"><i class="fa fa-wrench"></i> Repair Job Status <button type="button" class="btn btn-xs btn-warning pull-right" style="margin-top: -3px;" onclick="open_status_modal(<?= $claim->id; ?>)"><i class="fa fa-refresh"></i> Update Status</button></div>
            <div class="row text-center margin-bottom">
              <div class="col-xs-6">
                <small class="text-muted text-uppercase">Job Status</small><br>
                <?php
                $badge = 'label-info';
                if ($claim->status == 'Received') { $badge = 'label-primary'; }
                else if ($claim->status == 'Under Repair') { $badge = 'label-warning'; }
                else if ($claim->status == 'Ready for Delivery') { $badge = 'label-info'; }
                else if ($claim->status == 'Delivered') { $badge = 'label-success'; }
                else if ($claim->status == 'Rejected') { $badge = 'label-danger'; }
                ?>
                <span class="label <?= $badge; ?>" style="font-size: 15px; padding: 6px 14px;"><?= $claim->status; ?></span>
              </div>
              <div class="col-xs-6">
                <small class="text-muted text-uppercase">Total Service Charge</small>
                <div class="kpi-stat text-green"><?= $CI->currency($claim->total_charge); ?></div>
              </div>
            </div>

            <table class="table table-bordered table-striped" style="margin-bottom: 0;">
              <tr>
                <td width="40%"><strong>Job Code</strong></td>
                <td><strong class="text-primary"><?= $claim->warranty_code; ?></strong></td>
              </tr>
              <tr>
                <td><strong>Intake Date</strong></td>
                <td><?= show_date($claim->claim_date); ?> <small class="text-muted"><?= $claim->created_time; ?></small></td>
              </tr>
              <tr>
                <td><strong>Expected Delivery</strong></td>
                <td><?= !empty($claim->expected_delivery_date) ? show_date($claim->expected_delivery_date) : '-'; ?></td>
              </tr>
              <tr>
                <td><strong>Actual Delivery Date</strong></td>
                <td><?= !empty($claim->delivery_date) ? show_date($claim->delivery_date) : '<span class="text-muted">Not Delivered</span>'; ?></td>
              </tr>
              <?php if($claim->status == 'Delivered') { ?>
              <tr>
                <td><strong>Delivered To</strong></td>
                <td><strong class="text-success"><i class="fa fa-user-check"></i> <?= !empty($claim->delivered_to) ? html_escape($claim->delivered_to) : 'Customer'; ?></strong></td>
              </tr>
              <?php } ?>
              <?php if($claim->total_charge > 0 && !empty($claim->account_name)) { ?>
              <tr>
                <td><strong>Credited Account</strong></td>
                <td><span class="label label-info"><i class="fa fa-bank"></i> <?= html_escape($claim->account_name); ?></span></td>
              </tr>
              <?php } ?>
              <tr>
                <td><strong>Received By</strong></td>
                <td><?= html_escape($claim->created_by); ?></td>
              </tr>
            </table>
          </div>

          <div class="detail-card">
            <div class="detail-title"><i class="fa fa-exclamation-triangle text-danger"></i> Problem & Condition</div>
            <p><strong>Customer Complaint / Problem:</strong></p>
            <div style="background: #fff1f2; border: 1px solid #fecdd3; border-radius: 4px; padding: 10px; margin-bottom: 12px; color: #9f1239;">
              <?= nl2br(html_escape($claim->problem_description)); ?>
            </div>

            <p style="margin-bottom: 4px;"><strong>Accessories Received:</strong> <?= !empty($claim->accessories_received) ? html_escape($claim->accessories_received) : '<span class="text-muted">None</span>'; ?></p>
            <p style="margin-bottom: 0;"><strong>Physical Condition:</strong> <?= !empty($claim->product_condition) ? html_escape($claim->product_condition) : '<span class="text-muted">Good</span>'; ?></p>
          </div>
        </div>
      </div>

      <!-- Row 2: Repair Action Taken & Charges -->
      <div class="row">
        <div class="col-md-12">
          <div class="detail-card">
            <div class="detail-title"><i class="fa fa-check-square-o"></i> Technical Service Work Done & Charges <button type="button" class="btn btn-xs btn-primary pull-right" style="margin-top: -3px;" onclick="open_status_modal(<?= $claim->id; ?>)"><i class="fa fa-edit"></i> Edit Work Done / Charges</button></div>
            <div class="row">
              <div class="col-md-6">
                <p><strong>Work Done / Action Taken:</strong></p>
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 4px; padding: 12px; min-height: 70px;">
                  <?= !empty($claim->action_taken) ? nl2br(html_escape($claim->action_taken)) : '<span class="text-muted">No action recorded yet.</span>'; ?>
                </div>
              </div>

              <div class="col-md-6">
                <p><strong>Technician Notes (Internal):</strong></p>
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 4px; padding: 12px; min-height: 70px;">
                  <?= !empty($claim->technician_notes) ? nl2br(html_escape($claim->technician_notes)) : '<span class="text-muted">No internal notes.</span>'; ?>
                </div>
              </div>
            </div>

            <hr>
            <div class="row">
              <div class="col-sm-3 text-center">
                <small class="text-muted">SERVICE CHARGE</small>
                <h4><?= $CI->currency($claim->service_charge); ?></h4>
              </div>
              <div class="col-sm-3 text-center">
                <small class="text-muted">PARTS CHARGE</small>
                <h4><?= $CI->currency($claim->parts_charge); ?></h4>
              </div>
              <div class="col-sm-3 text-center">
                <small class="text-muted">TOTAL CHARGE</small>
                <h4 class="text-success text-bold"><?= $CI->currency($claim->total_charge); ?></h4>
              </div>
              <div class="col-sm-3 text-center">
                <small class="text-muted">PAYMENT METHOD</small>
                <h4><span class="label label-default"><?= !empty($claim->payment_type) ? html_escape($claim->payment_type) : 'N/A'; ?></span></h4>
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
            <h4 class="modal-title"><i class="fa fa-wrench"></i> Update Repair Status / Deliver: <?= $claim->warranty_code; ?></h4>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" value="<?= $claim->id; ?>">

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Status <span class="text-danger">*</span></label>
                  <select name="status" id="modal_status" class="form-control select2" required style="width:100%;" onchange="toggle_delivery_fields()">
                    <option value="Received" <?= ($claim->status == 'Received') ? 'selected' : ''; ?>>Received</option>
                    <option value="Under Repair" <?= ($claim->status == 'Under Repair') ? 'selected' : ''; ?>>Under Repair</option>
                    <option value="Ready for Delivery" <?= ($claim->status == 'Ready for Delivery') ? 'selected' : ''; ?>>Ready for Delivery</option>
                    <option value="Delivered" <?= ($claim->status == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
                    <option value="Rejected" <?= ($claim->status == 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
                  </select>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group" id="group_delivery_date" style="<?= ($claim->status == 'Delivered') ? '' : 'display:none;'; ?>">
                  <label>Delivery Date</label>
                  <input type="text" name="delivery_date" id="modal_delivery_date" class="form-control datepicker" value="<?= !empty($claim->delivery_date) ? show_date($claim->delivery_date) : date('d-m-Y'); ?>">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group" id="group_delivered_to" style="<?= ($claim->status == 'Delivered') ? '' : 'display:none;'; ?>">
                  <label>Delivered To (Name/Mobile)</label>
                  <input type="text" name="delivered_to" id="modal_delivered_to" class="form-control" placeholder="Recipient Name / Mobile" value="<?= html_escape($claim->delivered_to ? $claim->delivered_to : $claim->customer_name); ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Action Taken / Work Done (Customer Facing)</label>
                  <textarea name="action_taken" id="modal_action_taken" class="form-control" rows="2" placeholder="e.g. Replaced display, fixed charging port..."><?= html_escape($claim->action_taken); ?></textarea>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Internal Technician Notes (Shop Internal)</label>
                  <textarea name="technician_notes" id="modal_technician_notes" class="form-control" rows="2" placeholder="e.g. Technician name, quality check notes..."><?= html_escape($claim->technician_notes); ?></textarea>
                </div>
              </div>
            </div>

            <hr>
            <h5 class="text-bold"><i class="fa fa-money"></i> Service & Parts Charges (Leave 0 if Free Under Warranty)</h5>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Service Charge (Tk)</label>
                  <input type="number" step="0.01" min="0" name="service_charge" id="modal_service_charge" class="form-control" value="<?= floatval($claim->service_charge); ?>" oninput="calc_modal_total()">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>Parts Charge (Tk)</label>
                  <input type="number" step="0.01" min="0" name="parts_charge" id="modal_parts_charge" class="form-control" value="<?= floatval($claim->parts_charge); ?>" oninput="calc_modal_total()">
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                  <label>Total Charge (Tk)</label>
                  <input type="text" id="modal_total_charge" class="form-control text-bold text-success" readonly value="<?= floatval($claim->total_charge); ?>">
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                  <label>Payment Method</label>
                  <select name="payment_type" id="modal_payment_type" class="form-control select2" style="width:100%;">
                    <?php
                    $q_pt = $this->db->query("SELECT * FROM db_paymenttypes WHERE status=1 AND store_id=" . get_current_store_id());
                    foreach ($q_pt->result() as $pt) {
                      $sel = ($claim->payment_type == $pt->payment_type) ? 'selected' : '';
                      echo "<option value='" . html_escape($pt->payment_type) . "' $sel>" . html_escape($pt->payment_type) . "</option>";
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
                      $sel = ($claim->account_id == $acc->id) ? 'selected' : '';
                      echo "<option value='" . $acc->id . "' $sel>" . html_escape($acc->account_name) . "</option>";
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
              <i class="fa fa-check"></i> Save Changes
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
$(document).ready(function() {
  $('.datepicker').datepicker({
    autoclose: true,
    format: 'dd-mm-yyyy',
    todayHighlight: true
  });
  $('.select2').select2();

  $('#status_form').on('submit', function(e) {
    e.preventDefault();
    $('#btn_save_status').attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

    $.ajax({
      url: "<?= base_url('warranty/update_status'); ?>",
      type: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function(res) {
        $('#btn_save_status').attr('disabled', false).html('<i class="fa fa-check"></i> Save Changes');
        if (res.status === 'success') {
          $('#statusModal').modal('hide');
          toastr.success(res.message, 'Success!');
          setTimeout(function() {
            location.reload();
          }, 600);
        } else {
          toastr.error(res.message, 'Error!');
        }
      },
      error: function() {
        $('#btn_save_status').attr('disabled', false).html('<i class="fa fa-check"></i> Save Changes');
        toastr.error('Server error updating status.', 'Error!');
      }
    });
  });
});

function calc_modal_total() {
  var s = parseFloat($('#modal_service_charge').val()) || 0;
  var p = parseFloat($('#modal_parts_charge').val()) || 0;
  $('#modal_total_charge').val((s + p).toFixed(2));
}

function toggle_delivery_fields() {
  var st = $('#modal_status').val();
  if (st === 'Delivered') {
    $('#group_delivery_date').slideDown();
    $('#group_delivered_to').slideDown();
  } else {
    $('#group_delivery_date').slideUp();
    $('#group_delivered_to').slideUp();
  }
}

function open_delivery_modal() {
  $('#modal_status').val('Delivered').trigger('change');
  toggle_delivery_fields();
  calc_modal_total();
  $('#statusModal').modal('show');
}

function open_status_modal(id) {
  toggle_delivery_fields();
  calc_modal_total();
  $('#statusModal').modal('show');
}
</script>
<script>$(".warranty_list-active-li").addClass("active");</script>
</body>
</html>
