<!DOCTYPE html>
<html>
<head>
<!-- TABLES CSS CODE -->
<?php $this->load->view('comman/code_css.php');?>
<style>
.history-item {
  position: relative;
  background: #ffffff;
  border-radius: 8px;
  border: 1px solid #e2e8f0;
  padding: 18px 20px;
  margin-bottom: 20px;
  box-shadow: 0 1px 4px rgba(0,0,0,0.06);
}
.history-header {
  border-bottom: 1px dashed #cbd5e1;
  padding-bottom: 10px;
  margin-bottom: 12px;
}
.badge-count {
  background: #3b82f6;
  color: #fff;
  padding: 4px 10px;
  border-radius: 12px;
  font-size: 12px;
  font-weight: 700;
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
        <i class="fa fa-history text-primary"></i> <?= $page_title; ?>
        <small>Complete historical service & repair records of products</small>
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
          <div class="box box-primary">
            <div class="box-body" style="padding: 20px;">
              <div class="row">
                <div class="col-md-9">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                    <input type="text" id="history_search_input" class="form-control input-lg" placeholder="Search by Serial Number, IMEI, Job Code, Customer Mobile or Name..." autofocus>
                  </div>
                </div>
                <div class="col-md-3">
                  <button type="button" class="btn btn-primary btn-block btn-lg" onclick="search_history()">
                    <i class="fa fa-search"></i> Search History
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Loading -->
          <div id="history_loading" class="text-center" style="display:none; padding: 25px;">
            <i class="fa fa-spinner fa-spin fa-2x text-primary"></i>
            <p class="text-muted" style="margin-top:8px;">Loading product service history...</p>
          </div>

          <!-- Results -->
          <div id="history_results"></div>

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
  $('#history_search_input').on('keypress', function(e) {
    if (e.which === 13) {
      search_history();
    }
  });

  // Load all initial history records
  search_history('');
});

function search_history(query) {
  var q = (query !== undefined) ? query : $('#history_search_input').val().trim();

  $('#history_loading').show();
  $('#history_results').html('');

  $.ajax({
    url: "<?= base_url('warranty/ajax_history'); ?>",
    type: "POST",
    data: { 
      search: q,
      '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
    },
    dataType: "json",
    success: function(list) {
      $('#history_loading').hide();

      if (!list || list.length === 0) {
        var html = '<div class="alert alert-info text-center" style="border-radius:8px;">' +
          '<h4><i class="fa fa-info-circle"></i> No Service History Found</h4>' +
          '<p>No service records matched your query.</p>' +
          '</div>';
        $('#history_results').html(html);
        return;
      }

      var html = '<div class="margin-bottom" style="font-size:16px; font-weight:700;">' +
        '<i class="fa fa-list-alt text-primary"></i> Total ' + list.length + ' Service Record(s) Found' +
        '</div>';

      $.each(list, function(idx, item) {
        var badge = 'label-info';
        if (item.status === 'Received') { badge = 'label-primary'; }
        else if (item.status === 'Under Repair') { badge = 'label-warning'; }
        else if (item.status === 'Ready for Delivery') { badge = 'label-info'; }
        else if (item.status === 'Delivered') { badge = 'label-success'; }
        else if (item.status === 'Rejected') { badge = 'label-danger'; }

        html += '<div class="history-item">' +
          '<div class="history-header">' +
          '<div class="row">' +
          '<div class="col-sm-8">' +
          '<span class="badge-count">Record #' + (list.length - idx) + '</span> ' +
          '<strong class="text-primary" style="font-size:16px; margin-left:8px;">' + htmlEscape(item.warranty_code) + '</strong> &nbsp;-&nbsp; ' +
          '<strong style="font-size:16px;">' + htmlEscape(item.item_name) + '</strong>' +
          (item.serial_no ? '<br><small class="text-muted"><i class="fa fa-barcode"></i> Serial/IMEI: <strong>' + htmlEscape(item.serial_no) + '</strong></small>' : '') +
          '</div>' +
          '<div class="col-sm-4 text-right">' +
          '<span class="label ' + badge + '" style="font-size:13px; padding:4px 10px;">' + htmlEscape(item.status) + '</span>' +
          '<div style="margin-top:6px; font-size:12px; color:#64748b;">Intake Date: ' + htmlEscape(item.claim_date) + '</div>' +
          '</div>' +
          '</div>' +
          '</div>' +

          '<div class="row" style="font-size:13px;">' +
          '<div class="col-md-6">' +
          '<p><strong>Customer:</strong> ' + htmlEscape(item.customer_name) + ' (' + htmlEscape(item.customer_mobile) + ')</p>' +
          '<p><strong>Reported Problem:</strong><br><span style="color:#b91c1c;">' + htmlEscape(item.problem_description) + '</span></p>' +
          (item.accessories_received ? '<p><strong>Accessories:</strong> ' + htmlEscape(item.accessories_received) + '</p>' : '') +
          '</div>' +

          '<div class="col-md-6">' +
          '<p><strong>Technical Action / Work Done:</strong><br>' +
          (item.action_taken ? '<span style="color:#15803d; font-weight:600;">' + htmlEscape(item.action_taken) + '</span>' : '<span class="text-muted">None recorded</span>') +
          '</p>' +
          '<p><strong>Total Charges:</strong> Tk ' + parseFloat(item.total_charge || 0).toFixed(2) + ' &nbsp;|&nbsp; ' +
          '<strong>Delivery Date:</strong> ' + (item.delivery_date ? htmlEscape(item.delivery_date) : '<span class="text-muted">Pending</span>') +
          '</p>' +
          '</div>' +
          '</div>' +

          '<hr style="margin:10px 0;">' +
          '<div class="text-right">' +
          '<a href="<?= base_url('warranty/view/'); ?>' + item.id + '" class="btn btn-default btn-sm"><i class="fa fa-eye"></i> View Job Card</a> ' +
          '<a href="<?= base_url('warranty/print_slip/'); ?>' + item.id + '/receiving" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i> Receiving Slip</a> ' +
          (item.status === 'Delivered' || item.total_charge > 0 ? '<a href="<?= base_url('warranty/print_slip/'); ?>' + item.id + '/delivery" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-print"></i> Delivery Slip</a>' : '') +
          '</div>' +

          '</div>';
      });

      $('#history_results').html(html);
    },
    error: function() {
      $('#history_loading').hide();
      toastr.error('Failed to load history.', 'Error');
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
<script>$(".warranty_history-active-li").addClass("active");</script>
</body>
</html>
