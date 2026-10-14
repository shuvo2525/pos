<!DOCTYPE html>
<html>
<head>
<!-- TABLES CSS CODE -->
<?php $this->load->view('comman/code_css.php');?>
<style>
.kpi-card {
  background: #ffffff;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  padding: 16px;
  margin-bottom: 20px;
  border-left: 4px solid #3c8dbc;
}
.kpi-title {
  font-size: 12px;
  text-transform: uppercase;
  color: #64748b;
  font-weight: 600;
  margin-bottom: 6px;
}
.kpi-value {
  font-size: 22px;
  font-weight: 700;
  color: #1e293b;
}
.customer-card {
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  padding: 16px;
  margin-bottom: 20px;
}
.status-pill {
  padding: 4px 12px;
  border-radius: 20px;
  font-weight: 700;
  font-size: 13px;
  display: inline-block;
}
.status-paid { background: #dcfce7; color: #15803d; }
.status-pending { background: #e0f2fe; color: #0369a1; }
.status-overdue { background: #fee2e2; color: #b91c1c; }
.status-partial { background: #fef9c3; color: #854d0e; }
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
        <i class="fa fa-book text-primary"></i> <?= $page_title; ?>
        <small>Customer Installment Ledger & Book</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $base_url; ?>emi"><?= $this->lang->line('emi_list'); ?></a></li>
        <li class="active"><?= $emi->emi_code; ?></li>
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
          <a href="<?= base_url('emi'); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> EMI List</a>
          <a href="<?= base_url('emi/print_ledger/' . $emi->id); ?>" target="_blank" class="btn btn-info"><i class="fa fa-print"></i> Print Statement</a>
          <a href="<?= base_url('emi/pdf_ledger/' . $emi->id); ?>" target="_blank" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Download PDF</a>
        </div>
      </div>

      <!-- Top Row: Customer & Plan Details -->
      <div class="row">
        <div class="col-md-5">
          <div class="customer-card">
            <h4 class="text-bold" style="margin-top: 0; color: #1e293b;">
              <i class="fa fa-user-circle text-primary"></i> <?= html_escape($emi->customer_name); ?>
            </h4>
            <p class="text-muted" style="margin-bottom: 4px;">
              <i class="fa fa-phone text-muted"></i> <strong>Mobile:</strong> <?= html_escape($emi->customer_mobile); ?>
            </p>
            <?php if(!empty($emi->customer_email)) { ?>
            <p class="text-muted" style="margin-bottom: 4px;">
              <i class="fa fa-envelope text-muted"></i> <strong>Email:</strong> <?= html_escape($emi->customer_email); ?>
            </p>
            <?php } ?>
            <p class="text-muted" style="margin-bottom: 4px;">
              <i class="fa fa-map-marker text-muted"></i> <strong>Address:</strong> <?= html_escape($emi->customer_address); ?><?= !empty($emi->customer_city) ? ', ' . html_escape($emi->customer_city) : ''; ?>
            </p>
            <hr style="margin: 10px 0;">
            <p style="margin-bottom: 4px;">
              <strong>Product / Item:</strong> <span class="text-primary text-bold"><?= html_escape($emi->item_details); ?></span>
            </p>
            <p style="margin-bottom: 4px;">
              <strong>Frequency:</strong> <span class="label label-info"><?= $emi->emi_frequency; ?></span> | 
              <strong>Installments:</strong> <?= $emi->total_installments; ?>
            </p>
            <p style="margin-bottom: 0;">
              <strong>Plan Status:</strong> 
              <?php if($emi->status == 'Completed' || $emi->due_amount <= 0) { ?>
                <span class="status-pill status-paid"><i class="fa fa-check-circle"></i> Completed</span>
              <?php } else { ?>
                <span class="status-pill status-pending"><i class="fa fa-clock-o"></i> Active</span>
              <?php } ?>
            </p>
          </div>
        </div>

        <div class="col-md-7">
          <div class="row">
            <div class="col-sm-4">
              <div class="kpi-card" style="border-left-color: #3b82f6;">
                <div class="kpi-title">Total Product Price</div>
                <div class="kpi-value text-primary"><?= $CI->currency($emi->total_amount); ?></div>
                <small class="text-muted">Down: <?= $CI->currency($emi->down_payment); ?></small>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="kpi-card" style="border-left-color: #10b981;">
                <div class="kpi-title">Total Paid to Date</div>
                <div class="kpi-value text-green"><?= $CI->currency($emi->paid_amount); ?></div>
                <small class="text-muted"><?php
                  $pct = ($emi->total_payable > 0) ? round(($emi->paid_amount / $emi->total_payable) * 100, 1) : 0;
                  echo $pct . '% Paid';
                ?></small>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="kpi-card" style="border-left-color: #ef4444;">
                <div class="kpi-title">Current Due Balance</div>
                <div class="kpi-value text-red"><?= $CI->currency($emi->due_amount); ?></div>
                <small class="text-muted">Total Payable: <?= $CI->currency($emi->total_payable); ?></small>
              </div>
            </div>
          </div>

          <!-- Progress bar -->
          <div class="box box-solid">
            <div class="box-body" style="padding: 10px 15px;">
              <label class="small text-muted" style="margin-bottom: 4px;">Installment Repayment Progress (<?= $pct; ?>%)</label>
              <div class="progress" style="height: 18px; margin-bottom: 0; border-radius: 4px;">
                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="<?= $pct; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= min(100, $pct); ?>%; line-height: 18px; font-size: 11px; font-weight: bold;">
                  <?= $pct; ?>%
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Schedule Table -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-calendar-check-o text-primary"></i> Installment Schedule (<?= count($installments); ?> Installments)</h3>
            </div>
            <div class="box-body table-responsive no-padding">
              <table class="table table-bordered table-hover">
                <thead class="bg-gray">
                  <tr>
                    <th class="text-center" width="5%">#</th>
                    <th width="12%">Due Date</th>
                    <th width="12%">Amount</th>
                    <th width="12%">Paid Amount</th>
                    <th width="12%">Paid Date</th>
                    <th width="12%">Payment Mode</th>
                    <th width="15%">Note / Ref</th>
                    <th width="10%">Status</th>
                    <th width="10%" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $today = date('Y-m-d');
                  foreach($installments as $inst) { 
                    $due_amount = $inst->amount - $inst->paid_amount;
                    $is_overdue = ($due_amount > 0 && $inst->due_date < $today);
                  ?>
                  <tr>
                    <td class="text-center text-bold"><?= $inst->installment_no; ?></td>
                    <td>
                      <i class="fa fa-calendar text-muted"></i> <?= show_date($inst->due_date); ?>
                      <?php if($is_overdue) { ?>
                        <br><small class="text-danger"><i class="fa fa-exclamation-triangle"></i> Overdue</small>
                      <?php } ?>
                    </td>
                    <td class="text-bold"><?= $CI->currency($inst->amount); ?></td>
                    <td class="text-green text-bold"><?= $CI->currency($inst->paid_amount); ?></td>
                    <td><?= !empty($inst->payment_date) ? show_date($inst->payment_date) : '-'; ?></td>
                    <td><?= !empty($inst->payment_type) ? '<span class="label label-default">' . html_escape($inst->payment_type) . '</span>' : '-'; ?></td>
                    <td><small class="text-muted"><?= html_escape($inst->payment_note); ?></small></td>
                    <td>
                      <?php if($inst->status == 'Paid') { ?>
                        <span class="status-pill status-paid"><i class="fa fa-check"></i> Paid</span>
                      <?php } else if($inst->status == 'Partial') { ?>
                        <span class="status-pill status-partial"><i class="fa fa-adjust"></i> Partial</span>
                      <?php } else if($is_overdue) { ?>
                        <span class="status-pill status-overdue"><i class="fa fa-clock-o"></i> Overdue</span>
                      <?php } else { ?>
                        <span class="status-pill status-pending"><i class="fa fa-hourglass-start"></i> Pending</span>
                      <?php } ?>
                    </td>
                    <td class="text-center">
                      <?php 
                      $CI =& get_instance();
                      if($CI->permissions('emi_payment') && $inst->status != 'Paid') { ?>
                        <button type="button" class="btn btn-xs btn-success" onclick="open_pay_modal(<?= $inst->id; ?>, <?= $inst->installment_no; ?>, <?= $due_amount; ?>, '<?= show_date($inst->due_date); ?>')">
                          <i class="fa fa-money"></i> Pay
                        </button>
                      <?php } else { ?>
                        <span class="text-muted"><i class="fa fa-check text-green"></i></span>
                      <?php } ?>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Payment History Transactions Table -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-history text-info"></i> Payment Receipts / Transaction History (<?= count($payments); ?> Records)</h3>
            </div>
            <div class="box-body table-responsive no-padding">
              <table class="table table-bordered table-striped">
                <thead class="bg-gray">
                  <tr>
                    <th>Receipt No</th>
                    <th>Date</th>
                    <th>Amount Paid</th>
                    <th>Payment Method</th>
                    <th>Notes / Purpose</th>
                    <th>Received By</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(empty($payments)) { ?>
                    <tr><td colspan="7" class="text-center text-muted">No payment records yet.</td></tr>
                  <?php } else { 
                    foreach($payments as $pmt) { ?>
                    <tr>
                      <td class="text-bold text-primary"><?= $pmt->receipt_no; ?></td>
                      <td><?= show_date($pmt->payment_date); ?> <small class="text-muted"><?= $pmt->created_time; ?></small></td>
                      <td class="text-green text-bold"><?= $CI->currency($pmt->payment_amount); ?></td>
                      <td><span class="label label-info"><?= html_escape($pmt->payment_type); ?></span></td>
                      <td><?= html_escape($pmt->payment_note); ?></td>
                      <td><small class="text-muted"><?= html_escape($pmt->created_by); ?></small></td>
                      <td class="text-center">
                        <a href="javascript:void(0)" onclick="print_receipt(<?= $pmt->id; ?>)" class="btn btn-xs btn-default" title="Print Receipt">
                          <i class="fa fa-print text-primary"></i> Print
                        </a>
                        <a href="<?= base_url('emi/pdf_receipt/' . $pmt->id); ?>" target="_blank" class="btn btn-xs btn-default" title="Download PDF">
                          <i class="fa fa-file-pdf-o text-danger"></i> PDF
                        </a>
                      </td>
                    </tr>
                  <?php } } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </section>
  </div>

  <!-- Pay Installment Modal -->
  <div class="modal fade" id="payModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form id="pay_form" method="POST">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
          <div class="modal-header bg-primary" style="color:#fff;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff;"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-money"></i> Pay Installment #<span id="span_inst_no"></span></h4>
          </div>
          <div class="modal-body">
            <input type="hidden" name="emi_id" value="<?= $emi->id; ?>">
            <input type="hidden" name="installment_id" id="input_installment_id" value="">
            
            <div class="form-group">
              <label>Installment Due Date</label>
              <input type="text" id="disp_due_date" class="form-control" readonly>
            </div>
            <div class="form-group">
              <label>Current Due Balance (Tk)</label>
              <input type="text" id="disp_due_amount" class="form-control" readonly>
            </div>
            <div class="form-group">
              <label>Payment Amount (Tk) <span class="text-danger">*</span></label>
              <input type="number" step="0.01" min="1" name="payment_amount" id="input_payment_amount" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Payment Date <span class="text-danger">*</span></label>
              <input type="text" name="payment_date" class="form-control datepicker" value="<?= date('d-m-Y'); ?>" required>
            </div>
            <div class="form-group">
              <label>Payment Method <span class="text-danger">*</span></label>
              <select name="payment_type" class="form-control select2" required style="width: 100%;">
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
              <select name="account_id" class="form-control select2" required style="width: 100%;">
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
              <textarea name="payment_note" class="form-control" rows="2" placeholder="e.g. Trx ID, Cheque No, Bank details..."></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success" id="btn_submit_installment_pay">
              <i class="fa fa-check"></i> Confirm Payment
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

  $('#pay_form').on('submit', function(e) {
    e.preventDefault();
    $('#btn_submit_installment_pay').attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');

    $.ajax({
      url: "<?= base_url('emi/pay_installment'); ?>",
      type: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function(res) {
        $('#btn_submit_installment_pay').attr('disabled', false).html('<i class="fa fa-check"></i> Confirm Payment');
        if (res.status === 'success') {
          $('#payModal').modal('hide');
          toastr.success(res.message, 'Success!');
          // Prompt print receipt
          if (confirm('Payment received! Would you like to print the Money Receipt now?')) {
            print_receipt(res.receipt_id);
          }
          setTimeout(function() {
            location.reload();
          }, 800);
        } else {
          toastr.error(res.message, 'Error!');
        }
      },
      error: function() {
        $('#btn_submit_installment_pay').attr('disabled', false).html('<i class="fa fa-check"></i> Confirm Payment');
        toastr.error('Failed to submit payment.', 'Error!');
      }
    });
  });
});

function open_pay_modal(inst_id, inst_no, due_amt, due_date) {
  $('#input_installment_id').val(inst_id);
  $('#span_inst_no').text(inst_no);
  $('#disp_due_date').val(due_date);
  $('#disp_due_amount').val(due_amt.toFixed(2));
  $('#input_payment_amount').val(due_amt.toFixed(2));
  $('#payModal').modal('show');
}

function print_receipt(id) {
  window.open("<?= base_url('emi/print_receipt/'); ?>" + id, "_blank", "scrollbars=1,resizable=1,height=650,width=800");
}
</script>
<script>$(".emi_list-active-li").addClass("active");</script>
</body>
</html>
