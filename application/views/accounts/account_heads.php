<!DOCTYPE html>
<html>
<head>
<!-- TABLES CSS CODE -->
<?php $this->load->view('comman/code_css.php');?>
<style>
.kpi-card {
  border-radius: 8px;
  padding: 15px 20px;
  color: #fff;
  margin-bottom: 20px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.08);
  position: relative;
  overflow: hidden;
}
.kpi-card .kpi-num {
  font-size: 26px;
  font-weight: 700;
  margin: 4px 0;
}
.kpi-card .kpi-label {
  font-size: 13px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  opacity: 0.9;
}
.kpi-card .kpi-icon {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 44px;
  opacity: 0.22;
}
.bg-gradient-blue { background: linear-gradient(135deg, #2563eb, #1d4ed8); }
.bg-gradient-purple { background: linear-gradient(135deg, #7c3aed, #6d28d9); }
.bg-gradient-green { background: linear-gradient(135deg, #059669, #047857); }
.bg-gradient-teal { background: linear-gradient(135deg, #0d9488, #0f766e); }
.pointer { cursor: pointer; }
</style>
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
        <i class="fa fa-folder-open text-yellow"></i> <?= $page_title; ?>
        <small>Manage main account heads (Bank, bKash, MFS, Cash, POS) & their sub-accounts</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $base_url; ?>accounts"><?= $this->lang->line('accounts'); ?></a></li>
        <li class="active"><?= $page_title; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- ********** ALERT MESSAGE START******* -->
      <?php $this->load->view('comman/code_flashdata');?>
      <!-- ********** ALERT MESSAGE END******* -->

      <!-- KPI Summary Cards -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="kpi-card bg-gradient-blue">
            <div class="kpi-label">Account Heads</div>
            <div class="kpi-num"><?= $total_heads; ?></div>
            <small>Main Parent Categories</small>
            <i class="fa fa-folder-open kpi-icon"></i>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="kpi-card bg-gradient-purple">
            <div class="kpi-label">Sub-Accounts</div>
            <div class="kpi-num"><?= $total_sub_accounts; ?></div>
            <small>Under Parent Heads</small>
            <i class="fa fa-sitemap kpi-icon"></i>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="kpi-card bg-gradient-green">
            <div class="kpi-label">Consolidated Total</div>
            <div class="kpi-num"><?= store_number_format($consolidated_balance); ?></div>
            <small>Total Balance Across Accounts</small>
            <i class="fa fa-university kpi-icon"></i>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="kpi-card bg-gradient-teal">
            <div class="kpi-label">Cash in Hand</div>
            <div class="kpi-num"><?= store_number_format($cash_balance); ?></div>
            <small>Active Liquid Cash</small>
            <i class="fa fa-money kpi-icon"></i>
          </div>
        </div>
      </div>

      <!-- Table Section -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-list text-aqua"></i> Account Heads Directory</h3>
              <div class="box-tools pull-right" style="display:flex; gap:8px;">
                <?php if($CI->permissions('accounts_add')) { ?>
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_add_account_head">
                  <i class="fa fa-plus-circle"></i> + New Account Head
                </button>
                <a class="btn btn-primary btn-sm" href="<?php echo $base_url; ?>accounts/add">
                  <i class="fa fa-plus"></i> + Add Sub-Account
                </a>
                <?php } ?>
                <a class="btn btn-info btn-sm" href="<?php echo $base_url; ?>accounts/cash_in_hand">
                  <i class="fa fa-money"></i> Cash in Hand
                </a>
              </div>
            </div>

            <div class="box-body">
              <div class="alert alert-info alert-dismissible" style="margin-bottom:15px; font-size:13px; border-radius:6px;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="fa fa-info-circle"></i> <b>How Account Heads Work:</b>
                Create main Heads here (e.g. <b>Bank</b>, <b>bKash</b>, <b>MFS</b>, <b>POS Terminal</b>, <b>Cash</b>). Then click <b>+ Add Sub-Account</b> to create accounts under that head (e.g. <i>Dutch Bangla Bank</i> and <i>City Bank</i> under Bank; <i>bKash Merchant</i> under bKash).
                In <b>Money Transfer</b>, <b>Money Deposit</b>, and <b>POS Payments</b>, all accounts are neatly grouped under their respective Heads!
              </div>

              <div class="table-responsive">
                <table id="account_heads_table" class="table table-bordered table-striped table-hover custom_hover" width="100%">
                  <thead class="bg-gray">
                    <tr>
                      <th style="width:20px;"><input type="checkbox" class="check-all"></th>
                      <th style="width:120px;">Head Code</th>
                      <th>Account Head Name & Note</th>
                      <th style="width:150px; text-align:center;">Sub-Accounts</th>
                      <th style="width:170px; text-align:right;">Total Balance</th>
                      <th style="width:90px; text-align:center;">Status</th>
                      <th style="width:100px; text-align:center;">Action</th>
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
  </div>

  <!-- Modal: Add New Account Head -->
  <div class="modal fade" id="modal_add_account_head" tabindex="-1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content" style="border-radius:8px;">
        <div class="modal-header header-custom" style="background:#2563eb; color:#fff; border-radius:8px 8px 0 0;">
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:0.9;">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title"><i class="fa fa-folder-open"></i> Create New Account Head</h4>
        </div>
        <form id="form_add_account_head" method="POST">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
          <div class="modal-body">
            <div class="alert alert-info" style="font-size:12.5px;">
              <i class="fa fa-lightbulb-o"></i> <b>Examples of Account Heads:</b> <code>Bank Accounts</code>, <code>bKash / Mobile Banking</code>, <code>Nagad</code>, <code>Rocket</code>, <code>POS / Card Terminal</code>, <code>Petty Cash</code>.
            </div>

            <div class="form-group">
              <label for="head_name">Account Head Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control input-lg" id="head_name" name="account_name" placeholder="e.g. Bank Accounts / bKash / MFS / POS Terminal" required autofocus>
              <p class="help-block text-muted" style="margin-bottom:0; font-size:12px;">This will be the parent group under which multiple sub-accounts can be created.</p>
            </div>

            <div class="form-group">
              <label for="head_code">Head Code (Optional)</label>
              <input type="text" class="form-control" id="head_code" name="account_code" placeholder="Leave blank to auto-generate (e.g. BANK-01, BKASH-01)">
            </div>

            <div class="form-group">
              <label for="head_opening_bal">Initial Opening Balance (Optional)</label>
              <input type="text" class="form-control only_currency" id="head_opening_bal" name="opening_balance" placeholder="0.00" value="0.00">
              <p class="help-block text-muted" style="margin-bottom:0; font-size:12px;">Usually 0.00 if balance is tracked in individual sub-accounts.</p>
            </div>

            <div class="form-group">
              <label for="head_note">Note / Description (Optional)</label>
              <textarea class="form-control" id="head_note" name="note" rows="2" placeholder="e.g. Master category for all company bank accounts"></textarea>
            </div>
          </div>
          <div class="modal-footer" style="background:#f8fafc; border-radius:0 0 8px 8px;">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success" id="btn_save_head"><i class="fa fa-check"></i> Create Account Head</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal: Edit Account Head -->
  <div class="modal fade" id="modal_edit_account_head" tabindex="-1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content" style="border-radius:8px;">
        <div class="modal-header header-custom" style="background:#1e293b; color:#fff; border-radius:8px 8px 0 0;">
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:0.9;">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title"><i class="fa fa-pencil"></i> Edit Account Head</h4>
        </div>
        <form id="form_edit_account_head" method="POST">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
          <input type="hidden" id="edit_head_id" name="head_id" value="">
          <div class="modal-body">
            <div class="form-group">
              <label for="edit_head_name">Account Head Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control input-lg" id="edit_head_name" name="account_name" required>
            </div>

            <div class="form-group">
              <label for="edit_head_code">Head Code</label>
              <input type="text" class="form-control" id="edit_head_code" name="account_code">
            </div>

            <div class="form-group">
              <label for="edit_head_note">Note / Description</label>
              <textarea class="form-control" id="edit_head_note" name="note" rows="2"></textarea>
            </div>

            <div class="form-group">
              <label for="edit_head_status">Status</label>
              <select class="form-control" id="edit_head_status" name="status">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
              </select>
            </div>
          </div>
          <div class="modal-footer" style="background:#f8fafc; border-radius:0 0 8px 8px;">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" id="btn_update_head"><i class="fa fa-check"></i> Update Account Head</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal: View Sub-Accounts under Head -->
  <div class="modal fade" id="modal_view_subs" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="border-radius:8px;">
        <div class="modal-header header-custom" style="background:#4f46e5; color:#fff; border-radius:8px 8px 0 0;">
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:0.9;">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="subs_modal_title"><i class="fa fa-sitemap"></i> Sub-Accounts</h4>
        </div>
        <div class="modal-body" style="padding:20px;">
          <div id="subs_loading" class="text-center" style="display:none; padding:20px;">
            <i class="fa fa-spinner fa-spin fa-2x text-primary"></i>
            <p class="text-muted" style="margin-top:8px;">Loading accounts...</p>
          </div>
          <div id="subs_content">
            <div class="table-responsive">
              <table class="table table-bordered table-striped" id="subs_table" width="100%">
                <thead class="bg-gray">
                  <tr>
                    <th style="width:120px;">Account Code</th>
                    <th>Account Name</th>
                    <th style="width:160px; text-align:right;">Balance</th>
                    <th>Note</th>
                    <th style="width:90px; text-align:center;">Status</th>
                    <th style="width:140px; text-align:center;">Actions</th>
                  </tr>
                </thead>
                <tbody id="subs_tbody">
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background:#f8fafc; border-radius:0 0 8px 8px; display:flex; justify-content:space-between;">
          <a href="#" id="btn_modal_add_sub" class="btn btn-success"><i class="fa fa-plus-circle"></i> + Add New Sub-Account under this Head</a>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <?php $this->load->view('footer');?>
  <div class="control-sidebar-bg"></div>
</div>

<!-- TABLES CODE -->
<?php $this->load->view('comman/code_js.php');?>

<script type="text/javascript">
var table;
var base_url = "<?= base_url(); ?>";

$(document).ready(function() {
  // Highlight sidebar
  $(".account_heads-active-li").addClass("active");
  $(".accounts_list-active-li").closest(".treeview").addClass("active");

  // Initialize DataTable
  table = $('#account_heads_table').DataTable({
    "processing": true,
    "serverSide": true,
    "order": [],
    "ajax": {
      "url": "<?= base_url('accounts/ajax_account_heads_list'); ?>",
      "type": "POST",
      "data": {
        '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
      }
    },
    "columnDefs": [
      { "targets": [0, 6], "orderable": false },
      { "targets": [3, 5, 6], "className": "text-center" },
      { "targets": [4], "className": "text-right" }
    ],
    "language": {
      "emptyTable": "No Account Heads found. Click '+ New Account Head' to create Bank, bKash, Cash, etc."
    }
  });

  // Submit Add Account Head
  $('#form_add_account_head').on('submit', function(e) {
    e.preventDefault();
    var name = $('#head_name').val().trim();
    if (!name) {
      toastr.warning('Please enter Account Head Name.', 'Notice');
      return;
    }

    $('#btn_save_head').attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

    $.ajax({
      url: "<?= base_url('accounts/save_parent_head'); ?>",
      type: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function(res) {
        $('#btn_save_head').attr('disabled', false).html('<i class="fa fa-check"></i> Create Account Head');
        if (res.status === 'success') {
          toastr.success(res.message, 'Success!');
          $('#modal_add_account_head').modal('hide');
          $('#form_add_account_head')[0].reset();
          table.ajax.reload(null, false);
          // Reload KPI counts
          setTimeout(function() { window.location.reload(); }, 1200);
        } else {
          toastr.error(res.message, 'Error!');
        }
      },
      error: function() {
        $('#btn_save_head').attr('disabled', false).html('<i class="fa fa-check"></i> Create Account Head');
        toastr.error('Failed to communicate with server.', 'Error!');
      }
    });
  });

  // Submit Edit Account Head
  $('#form_edit_account_head').on('submit', function(e) {
    e.preventDefault();
    $('#btn_update_head').attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Updating...');

    $.ajax({
      url: "<?= base_url('accounts/ajax_update_parent_head'); ?>",
      type: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function(res) {
        $('#btn_update_head').attr('disabled', false).html('<i class="fa fa-check"></i> Update Account Head');
        if (res.status === 'success') {
          toastr.success(res.message, 'Success!');
          $('#modal_edit_account_head').modal('hide');
          table.ajax.reload(null, false);
        } else {
          toastr.error(res.message, 'Error!');
        }
      },
      error: function() {
        $('#btn_update_head').attr('disabled', false).html('<i class="fa fa-check"></i> Update Account Head');
        toastr.error('Failed to update Account Head.', 'Error!');
      }
    });
  });
});

function edit_parent_head(id, name, code, note, status) {
  $('#edit_head_id').val(id);
  $('#edit_head_name').val(name);
  $('#edit_head_code').val(code);
  $('#edit_head_note').val(note);
  $('#edit_head_status').val(status);
  $('#modal_edit_account_head').modal('show');
}

function view_sub_accounts(head_id, head_name) {
  $('#subs_modal_title').html('<i class="fa fa-sitemap"></i> Sub-Accounts under: <b>' + head_name + '</b>');
  $('#btn_modal_add_sub').attr('href', base_url + 'accounts/add?parent_id=' + head_id);
  $('#subs_loading').show();
  $('#subs_tbody').html('');
  $('#modal_view_subs').modal('show');

  $.ajax({
    url: base_url + 'accounts/ajax_get_head_subs/' + head_id,
    type: "GET",
    dataType: "json",
    success: function(res) {
      $('#subs_loading').hide();
      if (res.status === 'success' && res.data.length > 0) {
        var html = '';
        $.each(res.data, function(idx, item) {
          var statusBadge = (item.status == 1)
            ? '<span class="label label-success">Active</span>'
            : '<span class="label label-danger">Inactive</span>';

          html += '<tr>' +
            '<td><b>' + item.account_code + '</b></td>' +
            '<td><span style="font-weight:700; color:#1e293b;">' + item.account_name + '</span></td>' +
            '<td class="text-right"><b>' + item.balance + '</b></td>' +
            '<td>' + (item.note ? item.note : '<span class="text-muted">-</span>') + '</td>' +
            '<td class="text-center">' + statusBadge + '</td>' +
            '<td class="text-center">' +
              '<a href="' + item.book_url + '" class="btn btn-xs btn-info" style="margin-right:5px;"><i class="fa fa-book"></i> Book</a>' +
              '<a href="' + item.edit_url + '" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i> Edit</a>' +
            '</td>' +
            '</tr>';
        });
        $('#subs_tbody').html(html);
      } else {
        $('#subs_tbody').html('<tr><td colspan="6" class="text-center text-muted" style="padding:25px;">No sub-accounts found under this head. Click "+ Add New Sub-Account under this Head" below to create one!</td></tr>');
      }
    },
    error: function() {
      $('#subs_loading').hide();
      toastr.error('Failed to load sub-accounts.', 'Error!');
    }
  });
}

function delete_accounts(q_id) {
  if (confirm("Do you really want to delete this Account Head?")) {
    $.post(base_url + "accounts/delete_accounts", {
      q_id: q_id,
      '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
    }, function(result) {
      if (result == "success") {
        toastr.success("Record Deleted Successfully!", "Success");
        table.ajax.reload(null, false);
      } else if (result == "failed") {
        toastr.error("Sorry! Failed to delete record.", "Failed");
      } else {
        toastr.error(result, "Notice");
      }
    });
  }
}
</script>
</body>
</html>
