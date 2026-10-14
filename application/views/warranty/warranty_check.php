<!DOCTYPE html>
<html>
<head>
<!-- TABLES CSS CODE -->
<?php $this->load->view('comman/code_css.php');?>
<style>
.search-container {
  background: #ffffff;
  padding: 30px;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.08);
  margin-bottom: 25px;
}
.warranty-card {
  background: #ffffff;
  border-radius: 8px;
  border: 1px solid #e2e8f0;
  box-shadow: 0 1px 4px rgba(0,0,0,0.06);
  padding: 20px;
  margin-bottom: 20px;
  transition: transform 0.2s ease;
}
.warranty-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.badge-valid {
  background: #dcfce7;
  color: #15803d;
  font-size: 14px;
  font-weight: 700;
  padding: 6px 14px;
  border-radius: 20px;
  display: inline-block;
}
.badge-expired {
  background: #fee2e2;
  color: #b91c1c;
  font-size: 14px;
  font-weight: 700;
  padding: 6px 14px;
  border-radius: 20px;
  display: inline-block;
}
.claim-count-pill {
  background: #eff6ff;
  color: #1d4ed8;
  font-weight: 600;
  padding: 4px 10px;
  border-radius: 12px;
  font-size: 12px;
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
        <i class="fa fa-shield text-primary"></i> <?= $page_title; ?>
        <small>Verify product warranty validity and service eligibility</small>
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
        <div class="col-md-10 col-md-offset-1">
          <!-- Search box -->
          <div class="search-container text-center">
            <h3 style="margin-top:0; font-weight:700; color:#1e293b;">Check Product Warranty</h3>
            <p class="text-muted">Search by Product Serial Number, IMEI, Invoice Number, or Customer Mobile</p>
            <div class="input-group input-group-lg" style="max-width: 650px; margin: 20px auto 10px auto;">
              <input type="text" id="warranty_search_input" class="form-control" placeholder="Enter Serial No / IMEI / Invoice No / Mobile..." autofocus>
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary btn-flat" id="btn_search_warranty" onclick="perform_search()">
                  <i class="fa fa-search"></i> Check Warranty
                </button>
              </span>
            </div>
            <div style="margin-top: 10px;">
              <small class="text-muted">Press Enter to search. E.g. Serial: 86523..., Invoice: SL-2026-..., Phone: 017...</small>
            </div>
          </div>

          <!-- Loading indicator -->
          <div id="search_loading" class="text-center" style="display:none; padding: 20px;">
            <i class="fa fa-spinner fa-spin fa-2x text-primary"></i>
            <p class="text-muted" style="margin-top:8px;">Searching warranty records...</p>
          </div>

          <!-- Search Results Container -->
          <div id="search_results"></div>

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

<script type="text/javascript">
$(document).ready(function() {
  $('#warranty_search_input').on('keypress', function(e) {
    if (e.which === 13) {
      perform_search();
    }
  });
});

function perform_search() {
  var q = $('#warranty_search_input').val().trim();
  if (!q) {
    toastr.warning('Please enter serial number, IMEI, invoice, or phone to search.', 'Notice');
    return;
  }

  $('#search_loading').show();
  $('#search_results').html('');

  $.ajax({
    url: "<?= base_url('warranty/ajax_check'); ?>",
    type: "POST",
    data: { 
      search: q,
      '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
    },
    dataType: "json",
    success: function(data) {
      $('#search_loading').hide();

      if (!data || data.length === 0) {
        var html = '<div class="alert alert-warning text-center" style="border-radius:8px;">' +
          '<h4><i class="fa fa-info-circle"></i> No Warranty Records Found</h4>' +
          '<p>No warranty claim or sales invoice matched "<strong>' + htmlEscape(q) + '</strong>".</p>' +
          '<div style="margin-top:15px;">' +
          '<a href="<?= base_url('warranty/add'); ?>?serial_no=' + encodeURIComponent(q) + '" class="btn btn-primary"><i class="fa fa-plus"></i> Register New Warranty Claim</a>' +
          '</div>' +
          '</div>';
        $('#search_results').html(html);
        return;
      }

      var html = '<h4 class="text-bold margin-bottom"><i class="fa fa-check-circle text-green"></i> Found ' + data.length + ' Matching Record(s):</h4>';

      $.each(data, function(idx, item) {
        var statusBadge;
        if (item.source === 'in_stock') {
          statusBadge = '<span class="badge" style="background:#16a34a; color:#fff; font-size:13px; font-weight:700; padding:6px 14px; border-radius:20px; display:inline-block;"><i class="fa fa-cubes"></i> ' + htmlEscape(item.status_text) + '</span>';
        } else if (item.is_under_warranty) {
          statusBadge = '<span class="badge-valid"><i class="fa fa-check-circle"></i> ' + htmlEscape(item.status_text) + '</span>';
        } else {
          statusBadge = '<span class="badge-expired"><i class="fa fa-times-circle"></i> ' + htmlEscape(item.status_text) + '</span>';
        }

        var claimCountBadge = (item.source === 'in_stock')
          ? '<span class="claim-count-pill" style="background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0;"><i class="fa fa-check-circle"></i> In Inventory (Not Sold Yet)</span>'
          : '<span class="claim-count-pill"><i class="fa fa-wrench"></i> Serviced: ' + item.total_claims + ' time(s)</span>';

        var claimUrl = "<?= base_url('warranty/add'); ?>?item_name=" + encodeURIComponent(item.item_name) +
          "&item_id=" + (item.item_id || 0) +
          "&customer_id=" + (item.customer_id || 0) +
          "&serial_no=" + encodeURIComponent(item.serial_no || '') +
          "&sales_code=" + encodeURIComponent(item.sales_code || '') +
          "&purchase_date=" + encodeURIComponent(item.purchase_date || '') +
          "&warranty_period_days=" + (item.warranty_period_days || 0) +
          "&warranty_expiry_date=" + encodeURIComponent(item.warranty_expiry_date || '');

        var actionBtn = (item.source === 'in_stock')
          ? '<a href="<?= base_url('pos'); ?>" class="btn btn-primary btn-block" style="font-weight:600;"><i class="fa fa-shopping-cart"></i> Sell Item in POS</a>'
          : '<a href="' + claimUrl + '" class="btn btn-success btn-block" style="font-weight:600;"><i class="fa fa-plus-circle"></i> Create Warranty Claim</a>';

        html += '<div class="warranty-card">' +
          '<div class="row">' +
          '<div class="col-md-8">' +
          '<h3 style="margin-top:0; font-weight:700; color:#0f172a;">' + htmlEscape(item.item_name) + '</h3>' +
          '<p class="text-muted" style="margin-bottom:8px;">' +
          (item.serial_no ? '<strong class="text-primary"><i class="fa fa-barcode"></i> Serial / IMEI: ' + htmlEscape(item.serial_no) + '</strong> &nbsp;|&nbsp; ' : '') +
          (item.sales_code ? '<strong>Invoice:</strong> ' + htmlEscape(item.sales_code) + ' &nbsp;|&nbsp; ' : '') +
          (item.warranty_code ? '<strong>Job Code:</strong> ' + htmlEscape(item.warranty_code) : '') +
          '</p>' +
          '<table style="width:100%; margin-top:10px; font-size:13px;">' +
          '<tr>' +
          '<td width="50%"><strong>' + (item.source === 'in_stock' ? 'Inventory Status' : 'Customer') + ':</strong> ' + htmlEscape(item.customer_name) + (item.customer_mobile && item.customer_mobile !== '-' ? ' (' + htmlEscape(item.customer_mobile) + ')' : '') + '</td>' +
          '<td width="50%"><strong>' + (item.source === 'in_stock' ? 'Stock Availability' : 'Purchase Date') + ':</strong> ' + htmlEscape(item.purchase_date) + '</td>' +
          '</tr>' +
          '<tr>' +
          '<td><strong>Original Warranty:</strong> <span class="badge" style="background:#0284c7; color:#fff; font-size:12px; font-weight:700; padding:3px 8px; border-radius:4px;"><i class="fa fa-shield"></i> ' + item.warranty_period_days + ' Days</span>' + (item.source === 'in_stock' ? ' (Starts on Sale Date)' : '') + '</td>' +
          '<td><strong>Warranty Expiry:</strong> ' + htmlEscape(item.warranty_expiry_date) + '</td>' +
          '</tr>' +
          '</table>' +
          '</div>' +
          '<div class="col-md-4 text-right">' +
          '<div style="margin-bottom:12px;">' + statusBadge + '</div>' +
          '<div style="margin-bottom:15px;">' + claimCountBadge + '</div>' +
          actionBtn +
          '</div>' +
          '</div>' +
          '</div>';
      });

      $('#search_results').html(html);
    },
    error: function() {
      $('#search_loading').hide();
      toastr.error('Error contacting server.', 'Error');
    }
  });
}

function htmlEscape(str) {
  if (!str) return '';
  return String(str).replace(/[&<>"']/g, function(s) {
    return {
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#39;'
    }[s];
  });
}
</script>
<script>$(".warranty_check-active-li").addClass("active");</script>
</body>
</html>
