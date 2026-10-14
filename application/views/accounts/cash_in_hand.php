<!DOCTYPE html>
<html>
<head>
<!-- TABLES CSS CODE -->
<?php $this->load->view('comman/code_css.php');?>
<style>
  .kpi-card {
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    transition: transform .2s ease-in-out;
  }
  .kpi-card:hover {
    transform: translateY(-2px);
  }
  .kpi-title {
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    opacity: 0.9;
  }
  .kpi-amount {
    font-size: 24px;
    font-weight: 700;
    margin: 4px 0;
  }
  .quick-filter-btn {
    margin-right: 5px;
    margin-bottom: 5px;
  }
</style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Left side column -->
  <?php $this->load->view('sidebar');?>
  <?php $CI =& get_instance(); ?>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
      <h1>
        <i class="fa fa-money text-green"></i> <?= $this->lang->line('cash_in_hand') ? $this->lang->line('cash_in_hand') : 'Cash in Hand'; ?>
        <small>Real-time Balance &amp; Transaction Ledger</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $base_url; ?>accounts"><?= $this->lang->line('accounts'); ?></a></li>
        <li class="active">Cash in Hand</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- ALERT MESSAGE -->
      <?php $this->load->view('comman/code_flashdata');?>

      <!-- TOP KPI SUMMARY ROW -->
      <div class="row">
        <!-- Available Cash in Hand -->
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green kpi-card">
            <div class="inner">
              <div class="kpi-title">Cash in Hand (Available)</div>
              <div class="kpi-amount" id="kpi_current_balance">
                <?= $CI->currency(store_number_format($summary['current_balance'])); ?>
              </div>
              <p style="margin-bottom:0; font-size:12px;">
                <i class="fa fa-check-circle"></i> Live Account Balance
              </p>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>
            <span class="small-box-footer" style="padding:4px 0; font-size:12px;">
              Account: <b><?= htmlspecialchars($summary['account_name']); ?></b>
            </span>
          </div>
        </div>

        <!-- Opening Balance -->
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua kpi-card">
            <div class="inner">
              <div class="kpi-title">Opening Balance</div>
              <div class="kpi-amount" id="kpi_opening_balance">
                <?= $CI->currency(store_number_format($summary['opening_balance'])); ?>
              </div>
              <p style="margin-bottom:0; font-size:12px;">
                <i class="fa fa-hourglass-start"></i> Initial Starting Cash
              </p>
            </div>
            <div class="icon">
              <i class="fa fa-clock-o"></i>
            </div>
            <a href="#" class="small-box-footer" data-toggle="modal" data-target="#modal_edit_opening_balance" title="Change Opening Balance">
              <i class="fa fa-pencil"></i> Set / Edit Opening Balance <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- Cash Inflow (Cash In) -->
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-teal kpi-card">
            <div class="inner">
              <div class="kpi-title">Total Cash In (Inflow)</div>
              <div class="kpi-amount" id="kpi_total_inflow">
                <?= $CI->currency(store_number_format($summary['total_inflow'])); ?>
              </div>
              <p style="margin-bottom:0; font-size:12px;">
                <i class="fa fa-arrow-down"></i> Sales, Receipts &amp; Deposits
              </p>
            </div>
            <div class="icon">
              <i class="fa fa-arrow-circle-down"></i>
            </div>
            <span class="small-box-footer" style="padding:4px 0; font-size:12px;">
              Period Receipts
            </span>
          </div>
        </div>

        <!-- Cash Outflow (Cash Out) -->
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-red kpi-card">
            <div class="inner">
              <div class="kpi-title">Total Cash Out (Outflow)</div>
              <div class="kpi-amount" id="kpi_total_outflow">
                <?= $CI->currency(store_number_format($summary['total_outflow'])); ?>
              </div>
              <p style="margin-bottom:0; font-size:12px;">
                <i class="fa fa-arrow-up"></i> Purchases, Expenses &amp; Returns
              </p>
            </div>
            <div class="icon">
              <i class="fa fa-arrow-circle-up"></i>
            </div>
            <span class="small-box-footer" style="padding:4px 0; font-size:12px;">
              Period Payments
            </span>
          </div>
        </div>
      </div>
      <!-- /.row -->

      <!-- FILTER BOX -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-filter"></i> Filters &amp; Ledger Options</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="row">
                <!-- Cash Account Selector (if multiple) -->
                <?php if(count($cash_accounts) > 1) { ?>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="filter_account_id">Cash Account</label>
                    <select class="form-control select2" id="filter_account_id" name="filter_account_id" style="width: 100%;">
                      <?php foreach($cash_accounts as $ca) { 
                        $sel = ($ca->id == $cash_account_id) ? 'selected' : '';
                      ?>
                        <option value="<?= $ca->id; ?>" <?= $sel; ?>>
                          <?= $ca->account_name; ?> (<?= store_number_format($ca->balance); ?>)
                        </option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <?php } else { ?>
                  <input type="hidden" id="filter_account_id" value="<?= $cash_account_id; ?>">
                <?php } ?>

                <!-- From Date -->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="from_date"><?= $this->lang->line('from_date'); ?></label>
                    <div class="input-group date">
                      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                      <input type="text" class="form-control pull-right datepicker" id="from_date" name="from_date" placeholder="DD-MM-YYYY">
                    </div>
                  </div>
                </div>

                <!-- To Date -->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="to_date"><?= $this->lang->line('to_date'); ?></label>
                    <div class="input-group date">
                      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                      <input type="text" class="form-control pull-right datepicker" id="to_date" name="to_date" placeholder="DD-MM-YYYY">
                    </div>
                  </div>
                </div>

                <!-- Users -->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="filter_users"><?= $this->lang->line('users'); ?></label>
                    <select class="form-control select2" id="filter_users" name="filter_users" style="width: 100%;">
                      <?= get_users_select_list($this->session->userdata("role_id"), get_current_store_id()); ?>
                    </select>
                  </div>
                </div>
              </div>

              <!-- Quick Date Presets & Action Buttons -->
              <div class="row">
                <div class="col-md-8">
                  <label style="display:block; font-size:12px; margin-bottom:4px; color:#777;">Quick Presets:</label>
                  <button type="button" class="btn btn-default btn-sm quick-filter-btn" onclick="setQuickDate('today')"><i class="fa fa-clock-o"></i> Today</button>
                  <button type="button" class="btn btn-default btn-sm quick-filter-btn" onclick="setQuickDate('yesterday')">Yesterday</button>
                  <button type="button" class="btn btn-default btn-sm quick-filter-btn" onclick="setQuickDate('this_week')">This Week</button>
                  <button type="button" class="btn btn-default btn-sm quick-filter-btn" onclick="setQuickDate('this_month')">This Month</button>
                  <button type="button" class="btn btn-default btn-sm quick-filter-btn" onclick="setQuickDate('all')">All Time</button>
                </div>
                <div class="col-md-4 text-right" style="padding-top:18px;">
                  <button type="button" class="btn btn-primary" onclick="applyFilter()"><i class="fa fa-search"></i> Apply Filter</button>
                  <button type="button" class="btn btn-default" onclick="resetFilter()"><i class="fa fa-refresh"></i> Reset</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- TRANSACTION LEDGER TABLE -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-list-alt"></i> Cash in Hand Transaction Ledger</h3>
              <div class="box-tools pull-right">
                <a href="<?= base_url('accounts/book/' . $cash_account_id); ?>" class="btn btn-sm btn-info" title="Full Standard Account Book">
                  <i class="fa fa-book"></i> Standard Account Book
                </a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="cash_table" class="table table-bordered table-striped custom_hover" width="100%">
                <thead class="bg-gray">
                  <tr>
                    <th width="4%">#</th>
                    <th width="12%">Date &amp; Time</th>
                    <th width="15%">Transaction Type</th>
                    <th width="18%">Reference / Voucher</th>
                    <th width="12%" class="text-right">Cash In (+)</th>
                    <th width="12%" class="text-right">Cash Out (-)</th>
                    <th width="13%" class="text-right">Running Balance</th>
                    <th width="14%">Note</th>
                    <th>User</th>
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
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- MODAL: SET / EDIT OPENING BALANCE -->
  <div class="modal fade" id="modal_edit_opening_balance" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header header-custom" style="background-color:#3c8dbc; color:#fff;">
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:0.9;">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title"><i class="fa fa-hourglass-start"></i> Set / Update Cash in Hand Opening Balance</h4>
        </div>
        <form id="form_edit_opening_balance">
          <div class="modal-body">
            <div class="alert alert-info" style="font-size:13px; margin-bottom:15px;">
              <i class="fa fa-info-circle"></i> Opening balance is the starting amount in your cash drawer/hand before new daily transactions. Changing this will recalculate your total Cash in Hand balance accurately.
            </div>
            <input type="hidden" id="ob_account_id" name="account_id" value="<?= $cash_account_id; ?>">
            <div class="form-group">
              <label for="ob_amount">Opening Balance Amount <span class="text-danger">*</span></label>
              <input type="text" class="form-control only_currency text-bold text-green" id="ob_amount" name="amount" value="<?= store_number_format($summary['opening_balance'], 0); ?>" placeholder="0.00" style="font-size:18px;">
            </div>
            <div class="form-group">
              <label for="ob_note">Reason / Note</label>
              <textarea class="form-control" id="ob_note" name="note" rows="2" placeholder="e.g. Initial cash starting balance">Updated Cash in Hand Opening Balance</textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="btn_save_ob" onclick="saveOpeningBalance()"><i class="fa fa-check"></i> Save Opening Balance</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php $this->load->view('footer.php');?>
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- JS SCRIPTS -->
<?php $this->load->view('comman/code_js_sound.php');?>
<?php $this->load->view('comman/code_js.php');?>

<script type="text/javascript">
var base_url = "<?= $base_url; ?>";
var cash_table;

$(document).ready(function() {
  loadDatatable();

  // If filter account changes
  $('#filter_account_id').on('change', function() {
    $('#ob_account_id').val($(this).val());
    applyFilter();
  });
});

function loadDatatable() {
  if ($.fn.DataTable.isDataTable('#cash_table')) {
    $('#cash_table').DataTable().destroy();
  }

  cash_table = $('#cash_table').DataTable({
    "aLengthMenu": [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
    dom: '<"row margin-bottom-12"<"col-sm-12"<"pull-left"l><"pull-right"fr><"pull-right margin-left-10"B>>>tip',
    buttons: [
      { extend: 'copy', className: 'btn bg-teal color-palette btn-flat' },
      { extend: 'excel', className: 'btn bg-teal color-palette btn-flat' },
      { extend: 'pdf', className: 'btn bg-teal color-palette btn-flat' },
      { extend: 'print', className: 'btn bg-teal color-palette btn-flat' },
      { extend: 'csv', className: 'btn bg-teal color-palette btn-flat' },
      { extend: 'colvis', className: 'btn bg-teal color-palette btn-flat', text: 'Columns' }
    ],
    "processing": true,
    "serverSide": true,
    "order": [[1, "desc"]],
    "responsive": true,
    "ajax": {
      "url": base_url + "accounts/ajax_cash_transactions",
      "type": "POST",
      "data": function(d) {
        d.account_id = $('#filter_account_id').val();
        d.from_date  = $('#from_date').val();
        d.to_date    = $('#to_date').val();
        d.users      = $('#filter_users').val();
      }
    },
    "columnDefs": [
      { "targets": [0, 8], "orderable": false },
      { "targets": [4, 5, 6], "className": "text-right" }
    ],
    language: {
      processing: '<div class="text-primary bg-primary" style="position:relative; z-index:100; padding:5px 10px; border-radius:3px;">Processing...</div>'
    }
  });
}

function applyFilter() {
  refreshKpis();
  if (cash_table) {
    cash_table.ajax.reload();
  }
}

function resetFilter() {
  $('#from_date').val('');
  $('#to_date').val('');
  $('#filter_users').val('').trigger('change');
  applyFilter();
}

function setQuickDate(type) {
  var today = new Date();
  var formatDate = function(d) {
    var dd = String(d.getDate()).padStart(2, '0');
    var mm = String(d.getMonth() + 1).padStart(2, '0');
    var yyyy = d.getFullYear();
    return dd + '-' + mm + '-' + yyyy;
  };

  if (type === 'today') {
    var str = formatDate(today);
    $('#from_date').val(str);
    $('#to_date').val(str);
  } else if (type === 'yesterday') {
    var y = new Date(today);
    y.setDate(today.getDate() - 1);
    var str = formatDate(y);
    $('#from_date').val(str);
    $('#to_date').val(str);
  } else if (type === 'this_week') {
    var first = new Date(today.setDate(today.getDate() - today.getDay()));
    var last = new Date();
    $('#from_date').val(formatDate(first));
    $('#to_date').val(formatDate(last));
  } else if (type === 'this_month') {
    var first = new Date(today.getFullYear(), today.getMonth(), 1);
    var last = new Date();
    $('#from_date').val(formatDate(first));
    $('#to_date').val(formatDate(last));
  } else if (type === 'all') {
    $('#from_date').val('');
    $('#to_date').val('');
  }
  applyFilter();
}

function refreshKpis() {
  $.ajax({
    type: 'POST',
    url: base_url + 'accounts/ajax_cash_summary',
    data: {
      account_id: $('#filter_account_id').val(),
      from_date:  $('#from_date').val(),
      to_date:    $('#to_date').val(),
      users:      $('#filter_users').val()
    },
    dataType: 'json',
    success: function(res) {
      if (res) {
        $('#kpi_current_balance').text(formatCurrency(res.current_balance));
        $('#kpi_opening_balance').text(formatCurrency(res.opening_balance));
        $('#kpi_total_inflow').text(formatCurrency(res.total_inflow));
        $('#kpi_total_outflow').text(formatCurrency(res.total_outflow));
      }
    }
  });
}

function formatCurrency(val) {
  var num = parseFloat(val) || 0;
  return num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function saveOpeningBalance() {
  var account_id = $('#ob_account_id').val();
  var amount     = $('#ob_amount').val();
  var note       = $('#ob_note').val();

  if (!amount || $.trim(amount) === '') {
    toastr["warning"]("Please enter a valid Opening Balance amount!");
    return;
  }

  $('#btn_save_ob').attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
  $.ajax({
    type: 'POST',
    url: base_url + 'accounts/update_cash_opening_balance',
    data: {
      account_id: account_id,
      amount: amount,
      note: note
    },
    dataType: 'json',
    success: function(res) {
      $('#btn_save_ob').attr('disabled', false).html('<i class="fa fa-check"></i> Save Opening Balance');
      if (res && res.status === 'success') {
        toastr["success"](res.message);
        $('#modal_edit_opening_balance').modal('hide');
        applyFilter();
      } else {
        toastr["error"](res.message || "Failed to update opening balance.");
      }
    },
    error: function() {
      $('#btn_save_ob').attr('disabled', false).html('<i class="fa fa-check"></i> Save Opening Balance');
      toastr["error"]("Network or server error while updating opening balance.");
    }
  });
}
</script>
</body>
</html>
