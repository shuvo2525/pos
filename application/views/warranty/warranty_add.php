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

  <?php
  // Pre-fill parameters if redirected from check page
  $p_customer_id = $this->input->get('customer_id');
  $p_item_id = $this->input->get('item_id');
  $p_item_name = $this->input->get('item_name');
  $p_serial_no = $this->input->get('serial_no');
  $p_sales_code = $this->input->get('sales_code');
  $p_purchase_date = $this->input->get('purchase_date');
  $p_warranty_days = $this->input->get('warranty_period_days') ? $this->input->get('warranty_period_days') : 365;
  $p_expiry_date = $this->input->get('warranty_expiry_date');
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-shield text-primary"></i> <?= $page_title; ?>
        <small>Intake product for service, repair, or warranty claim</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $base_url; ?>warranty"><?= $this->lang->line('warranty_list'); ?></a></li>
        <li class="active"><?= $page_title; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- ********** ALERT MESSAGE START******* -->
      <?php $this->load->view('comman/code_flashdata.php');?>
      <!-- ********** ALERT MESSAGE END******* -->

      <div class="row">
        <div class="col-md-12">
          <form id="warranty_form" class="form-horizontal" method="POST">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-pencil-square-o"></i> Claim & Product Details</h3>
                <div class="box-tools pull-right">
                  <a href="<?= base_url('warranty'); ?>" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back to List</a>
                </div>
              </div>

              <div class="box-body">

                <!-- Row 1: Customer & Invoice -->
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Customer <span class="text-danger">*</span></label>
                      <div class="col-sm-8">
                        <select class="form-control select2" id="customer_id" name="customer_id" required style="width: 100%;">
                          <option value="">-- Select Customer --</option>
                          <?php
                          $q_cust = $this->db->query("SELECT id, customer_name, mobile FROM db_customers WHERE status=1 AND store_id=" . get_current_store_id());
                          foreach ($q_cust->result() as $c) {
                            $sel = ($p_customer_id == $c->id) ? 'selected' : '';
                            echo "<option value='" . $c->id . "' $sel>" . html_escape($c->customer_name) . " (" . html_escape($c->mobile) . ")</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Sales Invoice No</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" id="sales_code" name="sales_code" placeholder="e.g. SL-2026-0001 (Optional)" value="<?= html_escape($p_sales_code); ?>">
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Row 2: Product Name & Serial No -->
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Product / Item <span class="text-danger">*</span></label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" id="item_name" name="item_name" placeholder="e.g. Walton Primo RM4 / HP Laptop" value="<?= html_escape($p_item_name); ?>" required>
                        <input type="hidden" name="item_id" value="<?= intval($p_item_id); ?>">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Serial / IMEI No</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" id="serial_no" name="serial_no" placeholder="e.g. 865239045612345" value="<?= html_escape($p_serial_no); ?>">
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Row 3: Purchase Date, Warranty Period & Expiry -->
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group" style="margin-left: 0; margin-right: 0;">
                      <label>Purchase Date</label>
                      <input type="text" class="form-control datepicker" id="purchase_date" name="purchase_date" value="<?= html_escape($p_purchase_date); ?>" placeholder="dd-mm-yyyy" onchange="auto_calc_expiry()">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group" style="margin-left: 0; margin-right: 0;">
                      <label>Warranty Duration (Days)</label>
                      <input type="number" min="0" class="form-control" id="warranty_period_days" name="warranty_period_days" value="<?= intval($p_warranty_days); ?>" oninput="auto_calc_expiry()">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group" style="margin-left: 0; margin-right: 0;">
                      <label>Warranty Expiry Date</label>
                      <input type="text" class="form-control datepicker" id="warranty_expiry_date" name="warranty_expiry_date" value="<?= html_escape($p_expiry_date); ?>" placeholder="dd-mm-yyyy">
                    </div>
                  </div>
                </div>

                <hr>

                <!-- Row 4: Problem Description -->
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group" style="margin-left: 0; margin-right: 0;">
                      <label class="text-danger">Problem Description (Customer Complaint) <span class="text-danger">*</span></label>
                      <textarea class="form-control" id="problem_description" name="problem_description" rows="3" placeholder="Describe the fault reported by customer in detail. e.g. Display not working, battery draining fast, no power, etc." required></textarea>
                    </div>
                  </div>
                </div>

                <!-- Row 5: Accessories Received & Physical Condition -->
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group" style="margin-left: 0; margin-right: 0;">
                      <label>Accessories Received with Product</label>
                      <input type="text" class="form-control" id="accessories_received" name="accessories_received" placeholder="e.g. Original Charger, Box, USB Cable, None">
                      <small class="text-muted">List items kept by the shop for service.</small>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group" style="margin-left: 0; margin-right: 0;">
                      <label>Physical Condition / Remarks at Intake</label>
                      <input type="text" class="form-control" id="product_condition" name="product_condition" placeholder="e.g. Scratches on back cover, screen intact, no water damage">
                      <small class="text-muted">Document device physical state before accepting.</small>
                    </div>
                  </div>
                </div>

                <!-- Row 6: Dates -->
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group" style="margin-left: 0; margin-right: 0;">
                      <label>Intake Date</label>
                      <input type="text" class="form-control datepicker" id="claim_date" name="claim_date" value="<?= date('d-m-Y'); ?>" required>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group" style="margin-left: 0; margin-right: 0;">
                      <label>Expected Delivery Date</label>
                      <input type="text" class="form-control datepicker" id="expected_delivery_date" name="expected_delivery_date" value="<?= date('d-m-Y', strtotime('+3 days')); ?>">
                    </div>
                  </div>
                </div>

              </div>

              <div class="box-footer text-right">
                <a href="<?= base_url('warranty'); ?>" class="btn btn-default"><i class="fa fa-times"></i> Cancel</a>
                <button type="submit" class="btn btn-success btn-lg" id="btn_save_claim">
                  <i class="fa fa-check-circle"></i> Save & Generate Receiving Slip
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
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

  $('#warranty_form').on('submit', function(e) {
    e.preventDefault();

    $('#btn_save_claim').attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

    $.ajax({
      url: "<?= base_url('warranty/save'); ?>",
      type: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function(res) {
        $('#btn_save_claim').attr('disabled', false).html('<i class="fa fa-check-circle"></i> Save & Generate Receiving Slip');
        if (res.status === 'success') {
          toastr.success(res.message, 'Success!');
          // Prompt print receiving slip
          if (confirm('Warranty claim registered! Would you like to print the Product Receiving Slip now?')) {
            window.open("<?= base_url('warranty/print_slip/'); ?>" + res.claim_id + "/receiving", "_blank", "scrollbars=1,resizable=1,height=650,width=800");
          }
          window.location.href = "<?= base_url('warranty/view/'); ?>" + res.claim_id;
        } else {
          toastr.error(res.message, 'Error!');
        }
      },
      error: function() {
        $('#btn_save_claim').attr('disabled', false).html('<i class="fa fa-check-circle"></i> Save & Generate Receiving Slip');
        toastr.error('Failed to save warranty claim.', 'Error!');
      }
    });
  });
});

function auto_calc_expiry() {
  var pDateStr = $('#purchase_date').val();
  var days = parseInt($('#warranty_period_days').val()) || 0;
  if (!pDateStr || days <= 0) return;

  var parts = pDateStr.split(/[\/\-\.]/);
  var pDate;
  if (parts.length === 3) {
    if (parts[0].length === 4) {
      // YYYY-MM-DD
      pDate = new Date(parseInt(parts[0], 10), parseInt(parts[1], 10) - 1, parseInt(parts[2], 10));
    } else {
      // DD-MM-YYYY
      pDate = new Date(parseInt(parts[2], 10), parseInt(parts[1], 10) - 1, parseInt(parts[0], 10));
    }
    pDate.setDate(pDate.getDate() + days);

    var day = ('0' + pDate.getDate()).slice(-2);
    var month = ('0' + (pDate.getMonth() + 1)).slice(-2);
    var year = pDate.getFullYear();
    $('#warranty_expiry_date').val(day + '-' + month + '-' + year);
  }
}
</script>
<script>$(".warranty_add-active-li").addClass("active");</script>
</body>
</html>
