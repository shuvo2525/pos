<!DOCTYPE html>
<html>
<head>
<!-- TABLES CSS CODE -->
<?php $this->load->view('comman/code_css.php');?>
<style>
.modal-header-custom {
  background-color: #00a65a;
  color: #fff;
  border-top-left-radius: 4px;
  border-top-right-radius: 4px;
}
.modal-header-custom .close {
  color: #fff;
  opacity: 0.8;
}
.kpi-card {
  border-radius: 6px;
  padding: 15px;
  margin-bottom: 20px;
  color: #fff;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.kpi-card .kpi-num {
  font-size: 22px;
  font-weight: 700;
}
.kpi-card .kpi-label {
  font-size: 13px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  opacity: 0.9;
}
.kpi-card .kpi-icon {
  font-size: 36px;
  opacity: 0.3;
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
        <i class="fa fa-money text-success"></i> <?= $page_title; ?>
        <small>Receive installments, track monthly payments & overdue schedules</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $base_url; ?>emi"><?= $this->lang->line('emi_list'); ?></a></li>
        <li class="active"><?= $this->lang->line('emi_collection'); ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- ********** ALERT MESSAGE START******* -->
      <?php $this->load->view('comman/code_flashdata.php');?>
      <!-- ********** ALERT MESSAGE END******* -->

      <!-- Top KPI Summary Cards -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="kpi-card bg-green">
            <div>
              <div class="kpi-label">Total Collected</div>
              <div class="kpi-num"><?= $CI->currency($kpis['total_collected']); ?></div>
            </div>
            <div class="kpi-icon"><i class="fa fa-check-circle"></i></div>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="kpi-card bg-aqua">
            <div>
              <div class="kpi-label">Total Outstanding Due</div>
              <div class="kpi-num"><?= $CI->currency($kpis['total_due']); ?></div>
            </div>
            <div class="kpi-icon"><i class="fa fa-hourglass-half"></i></div>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="kpi-card bg-red">
            <div>
              <div class="kpi-label">Overdue (<?= $kpis['overdue_count']; ?> Installments)</div>
              <div class="kpi-num"><?= $CI->currency($kpis['overdue_amount']); ?></div>
            </div>
            <div class="kpi-icon"><i class="fa fa-exclamation-triangle"></i></div>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="kpi-card bg-yellow">
            <div>
              <div class="kpi-label">Today's Due (<?= $kpis['today_count']; ?> Inst.)</div>
              <div class="kpi-num"><?= $CI->currency($kpis['today_amount']); ?></div>
            </div>
            <div class="kpi-icon"><i class="fa fa-calendar-check-o"></i></div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-list"></i> Installment Collection Schedules</h3>
              <div class="box-tools pull-right">
                <a class="btn btn-primary btn-sm" href="<?php echo $base_url; ?>emi/add">
                  <i class="fa fa-plus"></i> <?= $this->lang->line('new_emi_plan'); ?>
                </a>
                <a class="btn btn-default btn-sm" href="<?php echo $base_url; ?>emi">
                  <i class="fa fa-list"></i> <?= $this->lang->line('emi_list'); ?>
                </a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- Filter Row -->
              <div class="row margin-bottom">
                <div class="col-md-3">
                  <label>Status Filter</label>
                  <select id="status_filter" class="form-control select2" onchange="reload_table()">
                    <option value="">All Installments</option>
                    <option value="Due">All Unpaid / Due</option>
                    <option value="Overdue" selected>Overdue Only</option>
                    <option value="Pending">Upcoming / Pending</option>
                    <option value="Paid">Paid Only</option>
                  </select>
                </div>

                <div class="col-md-4">
                  <label>Customer Filter</label>
                  <select id="customer_filter" class="form-control select2" onchange="reload_table()">
                    <option value="">All Customers</option>
                    <?php
                    $q_cust = $this->db->query("SELECT id, customer_name, mobile FROM db_customers WHERE status=1 AND store_id=" . get_current_store_id() . " ORDER BY customer_name ASC");
                    foreach ($q_cust->result() as $c) {
                      echo "<option value='" . $c->id . "'>" . html_escape($c->customer_name) . " (" . html_escape($c->mobile) . ")</option>";
                    }
                    ?>
                  </select>
                </div>

                <div class="col-md-3">
                  <label>Due Month</label>
                  <input type="month" id="month_filter" class="form-control" onchange="reload_table()">
                </div>

                <div class="col-md-2" style="margin-top: 25px;">
                  <button type="button" class="btn btn-default btn-block" onclick="reset_filters()">
                    <i class="fa fa-refresh"></i> Reset Filters
                  </button>
                </div>
              </div>

              <!-- Data Table -->
              <div class="table-responsive">
                <table id="collection_table" class="table table-bordered table-striped" width="100%">
                  <thead>
                    <tr class="bg-gray">
                      <th>Plan / Product</th>
                      <th>Customer Info</th>
                      <th>Inst. #</th>
                      <th>Due Date</th>
                      <th>Amount</th>
                      <th>Paid</th>
                      <th>Due Balance</th>
                      <th>Months Progress</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Receive Installment Modal -->
  <div class="modal fade" id="collectionPayModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form id="collection_pay_form" method="POST">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
          <input type="hidden" name="emi_id" id="modal_emi_id" value="">
          <input type="hidden" name="installment_id" id="modal_installment_id" value="">

          <div class="modal-header modal-header-custom">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-money"></i> Receive EMI Installment</h4>
          </div>
          <div class="modal-body">
            
            <div class="callout callout-info" style="margin-bottom: 15px; padding: 10px;">
              <div class="row">
                <div class="col-sm-6">
                  <strong>Plan Ref:</strong> <span id="span_plan_code" class="text-bold"></span><br>
                  <strong>Customer:</strong> <span id="span_customer_name"></span>
                </div>
                <div class="col-sm-6 text-right">
                  <strong>Installment:</strong> #<span id="span_inst_no" class="badge bg-purple"></span><br>
                  <strong>Due Date:</strong> <span id="span_due_date" class="text-bold"></span>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label>Current Due Balance (Tk)</label>
              <input type="text" id="modal_due_display" class="form-control text-bold text-red" readonly value="0.00">
            </div>

            <div class="form-group">
              <label>Received Amount (Tk) <span class="text-danger">*</span></label>
              <input type="number" step="0.01" min="1" name="payment_amount" id="modal_payment_amount" class="form-control text-bold text-green" required>
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
              <textarea name="payment_note" id="modal_payment_note" class="form-control" rows="2" placeholder="e.g. Received via bKash / Bank Trx ID / Cash Box"></textarea>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success" id="btn_submit_pay">
              <i class="fa fa-check"></i> Confirm Payment Receive
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

  table = $('#collection_table').DataTable({
    "processing": true,
    "serverSide": true,
    "order": [[3, "asc"]],
    "responsive": true,
    "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
    "ajax": {
      "url": "<?= base_url('emi/ajax_collection'); ?>",
      "type": "POST",
      "data": function(d) {
        d['<?= $this->security->get_csrf_token_name(); ?>'] = '<?= $this->security->get_csrf_hash(); ?>';
        d.status = $('#status_filter').val();
        d.customer_id = $('#customer_filter').val();
        d.month_year = $('#month_filter').val();
      }
    },
    "columnDefs": [
      { "targets": [7, 9], "orderable": false }
    ]
  });

  // Handle pay submit
  $('#collection_pay_form').on('submit', function(e) {
    e.preventDefault();
    $('#btn_submit_pay').attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');

    $.ajax({
      url: "<?= base_url('emi/pay_installment'); ?>",
      type: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function(res) {
        $('#btn_submit_pay').attr('disabled', false).html('<i class="fa fa-check"></i> Confirm Payment Receive');
        if (res.status === 'success') {
          $('#collectionPayModal').modal('hide');
          toastr.success(res.message, 'Success!');
          reload_table();
          // Optionally reload page after 1.5s to refresh top KPI cards
          setTimeout(function() {
            location.reload();
          }, 1200);
        } else {
          toastr.error(res.message, 'Payment Error!');
        }
      },
      error: function() {
        $('#btn_submit_pay').attr('disabled', false).html('<i class="fa fa-check"></i> Confirm Payment Receive');
        toastr.error('Server error processing payment.', 'Error!');
      }
    });
  });
});

function reload_table() {
  table.ajax.reload(null, false);
}

function reset_filters() {
  $('#status_filter').val('').trigger('change');
  $('#customer_filter').val('').trigger('change');
  $('#month_filter').val('');
  reload_table();
}

function open_collection_pay_modal(instId, emiId, emiCode, custName, instNo, dueAmt, dueDate) {
  $('#modal_installment_id').val(instId);
  $('#modal_emi_id').val(emiId);
  $('#span_plan_code').text(emiCode);
  $('#span_customer_name').text(custName);
  $('#span_inst_no').text(instNo);
  $('#span_due_date').text(dueDate);
  $('#modal_due_display').val(parseFloat(dueAmt).toFixed(2));
  $('#modal_payment_amount').val(parseFloat(dueAmt).toFixed(2));
  $('#modal_payment_note').val('');
  $('#collectionPayModal').modal('show');
}
</script>
<script>$(".emi_collection-active-li").addClass("active");</script>
</body>
</html>
