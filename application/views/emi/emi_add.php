<!DOCTYPE html>
<html>
<head>
<!-- TABLES CSS CODE -->
<?php $this->load->view('comman/code_css.php');?>
<style>
.schedule-table th {
  background-color: #f4f6f9;
  font-weight: 600;
}
.highlight-box {
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 6px;
  padding: 15px;
  margin-bottom: 20px;
}
.calc-label {
  font-size: 13px;
  color: #64748b;
  text-transform: uppercase;
  margin-bottom: 4px;
}
.calc-value {
  font-size: 20px;
  font-weight: 700;
  color: #0f172a;
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
        <small>Create equal installment plan (Monthly / Weekly)</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $base_url; ?>emi"><?= $this->lang->line('emi_list'); ?></a></li>
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
          <form id="emi_form" class="form-horizontal" method="POST">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-edit"></i> EMI Plan Details</h3>
                <div class="box-tools pull-right">
                  <a href="<?= base_url('emi'); ?>" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back to List</a>
                </div>
              </div>
              <div class="box-body">

                <!-- Row 1: Customer & Product Details -->
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Customer <span class="text-danger">*</span></label>
                      <div class="col-sm-8">
                        <select class="form-control select2" id="customer_id" name="customer_id" required style="width: 100%;">
                          <option value="">-- Select Customer --</option>
                          <?php
                          $q_cust = $this->db->query("SELECT id, customer_name, mobile, address FROM db_customers WHERE status=1 AND store_id=" . get_current_store_id());
                          foreach ($q_cust->result() as $c) {
                            echo "<option value='" . $c->id . "'>" . html_escape($c->customer_name) . " (" . html_escape($c->mobile) . ")</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Item / Product Details <span class="text-danger">*</span></label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" id="item_details" name="item_details" placeholder="e.g. Samsung Galaxy A54 (Serial/IMEI: 8652...)" required>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Row 2: Sales Reference (Optional) & Start Date -->
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-sm-4 control-label">Sales Invoice Ref</label>
                      <div class="col-sm-8">
                        <select class="form-control select2" id="sales_id" name="sales_id" style="width: 100%;">
                          <option value="0">-- Direct / None (Optional) --</option>
                          <?php
                          $q_sales = $this->db->query("SELECT id, sales_code, grand_total, sales_date FROM db_sales WHERE store_id=" . get_current_store_id() . " ORDER BY id DESC LIMIT 50");
                          foreach ($q_sales->result() as $s) {
                            echo "<option value='" . $s->id . "'>" . html_escape($s->sales_code) . " - Tk " . store_number_format($s->grand_total) . " (" . show_date($s->sales_date) . ")</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="col-sm-4 control-label">First Due Date <span class="text-danger">*</span></label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control datepicker" id="start_date" name="start_date" value="<?= date('d-m-Y'); ?>" required onchange="calculate_schedule()">
                      </div>
                    </div>
                  </div>
                </div>

                <hr>

                <!-- Row 3: Financial Calculations -->
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group" style="margin-left: 0; margin-right: 0;">
                      <label>Total Product Price (Tk) <span class="text-danger">*</span></label>
                      <input type="number" step="0.01" min="1" class="form-control" id="total_amount" name="total_amount" placeholder="0.00" required oninput="calculate_schedule()">
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group" style="margin-left: 0; margin-right: 0;">
                      <label>Down Payment (Tk)</label>
                      <input type="number" step="0.01" min="0" class="form-control" id="down_payment" name="down_payment" value="0.00" oninput="calculate_schedule()">
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group" style="margin-left: 0; margin-right: 0;">
                      <label>Installment Frequency <span class="text-danger">*</span></label>
                      <select class="form-control select2" id="emi_frequency" name="emi_frequency" style="width: 100%;" onchange="calculate_schedule()">
                        <option value="Monthly" selected>Monthly Installment</option>
                        <option value="Weekly">Weekly Installment</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group" style="margin-left: 0; margin-right: 0;">
                      <label>Total Installments <span class="text-danger">*</span></label>
                      <input type="number" min="1" max="120" class="form-control" id="total_installments" name="total_installments" value="6" required oninput="calculate_schedule()">
                    </div>
                  </div>
                </div>

                <!-- Row 4: Interest Rate & Down Payment Mode -->
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group" style="margin-left: 0; margin-right: 0;">
                      <label>Interest Rate (% Optional)</label>
                      <input type="number" step="0.01" min="0" class="form-control" id="interest_rate" name="interest_rate" value="0.00" oninput="calculate_schedule()">
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group" style="margin-left: 0; margin-right: 0;">
                      <label>Down Payment Mode</label>
                      <select class="form-control select2" id="payment_type" name="payment_type" style="width: 100%;">
                        <?php
                        $q_pt = $this->db->query("SELECT * FROM db_paymenttypes WHERE status=1 AND store_id=" . get_current_store_id());
                        foreach ($q_pt->result() as $pt) {
                          echo "<option value='" . html_escape($pt->payment_type) . "'>" . html_escape($pt->payment_type) . "</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group" style="margin-left: 0; margin-right: 0;">
                      <label>Deposit To Account</label>
                      <select class="form-control select2" id="account_id" name="account_id" style="width: 100%;">
                        <?php
                        $q_acc = $this->db->query("SELECT * FROM ac_accounts WHERE status=1 AND parent_id=0 AND store_id=" . get_current_store_id() . " ORDER BY id ASC");
                        foreach ($q_acc->result() as $acc) {
                          echo "<option value='" . $acc->id . "'>" . html_escape($acc->account_name) . "</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group" style="margin-left: 0; margin-right: 0;">
                      <label>Notes / Terms</label>
                      <input type="text" class="form-control" id="notes" name="notes" placeholder="Guarantor, agreement ref, etc.">
                    </div>
                  </div>
                </div>

                <!-- Live Summary KPI Cards -->
                <div class="row" style="margin-top: 15px;">
                  <div class="col-md-3">
                    <div class="highlight-box text-center">
                      <div class="calc-label">Financed Amount</div>
                      <div class="calc-value text-primary" id="disp_financed">Tk 0.00</div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="highlight-box text-center">
                      <div class="calc-label">Interest Amount</div>
                      <div class="calc-value text-warning" id="disp_interest">Tk 0.00</div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="highlight-box text-center">
                      <div class="calc-label">Total Payable</div>
                      <div class="calc-value text-danger" id="disp_total_payable">Tk 0.00</div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="highlight-box text-center">
                      <div class="calc-label">Per Installment Amount</div>
                      <div class="calc-value text-success" id="disp_installment_amount">Tk 0.00</div>
                    </div>
                  </div>
                </div>

                <!-- Live Schedule Preview Table -->
                <div class="row">
                  <div class="col-md-12">
                    <h4 class="text-bold"><i class="fa fa-calendar-check-o text-green"></i> Auto-Generated Installment Schedule Preview</h4>
                    <p class="text-muted small">The installment schedule with exact due dates and amounts calculated below will be registered upon saving.</p>
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped schedule-table" id="schedule_table">
                        <thead>
                          <tr>
                            <th class="text-center" width="10%">#</th>
                            <th width="30%">Due Date</th>
                            <th width="30%">Installment Amount</th>
                            <th width="30%">Cumulative Payable</th>
                          </tr>
                        </thead>
                        <tbody id="schedule_tbody">
                          <tr>
                            <td colspan="4" class="text-center text-muted">Enter product price and installments above to view schedule.</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

              </div>
              <!-- /.box-body -->
              <div class="box-footer text-right">
                <a href="<?= base_url('emi'); ?>" class="btn btn-default"><i class="fa fa-times"></i> Cancel</a>
                <button type="submit" class="btn btn-success btn-lg" id="btn_save_emi">
                  <i class="fa fa-check-circle"></i> Create EMI Plan
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

  calculate_schedule();

  $('#emi_form').on('submit', function(e) {
    e.preventDefault();

    var tot = parseFloat($('#total_amount').val()) || 0;
    var down = parseFloat($('#down_payment').val()) || 0;
    if (tot <= 0) {
      toastr.error('Please enter valid product total amount.', 'Validation Error');
      return;
    }
    if (down > tot) {
      toastr.error('Down payment cannot exceed total amount.', 'Validation Error');
      return;
    }

    $('#btn_save_emi').attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving Plan...');

    $.ajax({
      url: "<?= base_url('emi/save'); ?>",
      type: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function(res) {
        $('#btn_save_emi').attr('disabled', false).html('<i class="fa fa-check-circle"></i> Create EMI Plan');
        if (res.status === 'success') {
          toastr.success(res.message, 'Success!');
          if (res.receipt_id > 0) {
            if (confirm('EMI Plan created successfully! Down payment recorded. Would you like to print the Down Payment Money Receipt now?')) {
              window.open("<?= base_url('emi/print_receipt/'); ?>" + res.receipt_id, "_blank", "scrollbars=1,resizable=1,height=650,width=800");
            }
          }
          window.location.href = "<?= base_url('emi/details/'); ?>" + res.emi_id;
        } else {
          toastr.error(res.message, 'Error!');
        }
      },
      error: function() {
        $('#btn_save_emi').attr('disabled', false).html('<i class="fa fa-check-circle"></i> Create EMI Plan');
        toastr.error('Server error saving EMI plan.', 'Error!');
      }
    });
  });
});

function parseDate(str) {
  if (!str) return new Date();
  var parts = str.split('-');
  if (parts.length === 3) {
    return new Date(parts[2], parts[1] - 1, parts[0]);
  }
  return new Date();
}

function formatDate(d) {
  var day = ('0' + d.getDate()).slice(-2);
  var month = ('0' + (d.getMonth() + 1)).slice(-2);
  var year = d.getFullYear();
  return day + '-' + month + '-' + year;
}

function calculate_schedule() {
  var total_amount = parseFloat($('#total_amount').val()) || 0;
  var down_payment = parseFloat($('#down_payment').val()) || 0;
  var interest_rate = parseFloat($('#interest_rate').val()) || 0;
  var emi_frequency = $('#emi_frequency').val();
  var total_installments = parseInt($('#total_installments').val()) || 1;
  var start_date_str = $('#start_date').val();

  var financed = Math.max(0, total_amount - down_payment);
  var interest = (financed * interest_rate) / 100;
  var total_payable = financed + interest;
  var installment_amount = (total_installments > 0) ? (total_payable / total_installments) : 0;

  $('#disp_financed').text('Tk ' + financed.toFixed(2));
  $('#disp_interest').text('Tk ' + interest.toFixed(2));
  $('#disp_total_payable').text('Tk ' + total_payable.toFixed(2));
  $('#disp_installment_amount').text('Tk ' + installment_amount.toFixed(2));

  if (total_payable <= 0 || total_installments <= 0) {
    $('#schedule_tbody').html('<tr><td colspan="4" class="text-center text-muted">Enter product price and installments above to view schedule.</td></tr>');
    return;
  }

  var tbody = '';
  var curDate = parseDate(start_date_str);
  var cumulative = 0;

  for (var i = 1; i <= total_installments; i++) {
    cumulative += installment_amount;
    var dueStr = formatDate(curDate);

    tbody += '<tr>' +
      '<td class="text-center text-bold">' + i + '</td>' +
      '<td><i class="fa fa-calendar text-muted"></i> ' + dueStr + '</td>' +
      '<td class="text-bold text-success">Tk ' + installment_amount.toFixed(2) + '</td>' +
      '<td class="text-muted">Tk ' + cumulative.toFixed(2) + '</td>' +
      '</tr>';

    if (emi_frequency === 'Weekly') {
      curDate.setDate(curDate.getDate() + 7);
    } else {
      curDate.setMonth(curDate.getMonth() + 1);
    }
  }

  $('#schedule_tbody').html(tbody);
}
</script>
<script>$(".emi_add-active-li").addClass("active");</script>
</body>
</html>
