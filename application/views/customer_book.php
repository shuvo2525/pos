<!DOCTYPE html>
<html>
<head>
<!-- TABLES CSS CODE -->
<?php $this->load->view('comman/code_css.php');?>
<style>
.cb-card {
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  padding: 16px 20px;
  margin-bottom: 20px;
  border-left: 4px solid #0899a4;
}
.cb-label {
  font-size: 11px;
  text-transform: uppercase;
  color: #666;
  font-weight: 600;
  margin-bottom: 2px;
}
.cb-val {
  font-size: 15px;
  font-weight: 700;
  color: #222;
}
</style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <?php
  if(isset($customer_id)){
      $q2 = $this->db->query("select * from db_customers where id=$customer_id and store_id=".get_current_store_id());
      if($q2->num_rows() > 0){
        $cust_row = $q2->row();
        $customer_code = $cust_row->customer_code;
        $customer_name = $cust_row->customer_name;
        $mobile = $cust_row->mobile;
        $email = $cust_row->email;
        $opening_balance = (float)$cust_row->opening_balance;
        $sales_due = (float)$cust_row->sales_due;
        $sales_return_due = (float)$cust_row->sales_return_due;
        $tot_advance = (float)$cust_row->tot_advance;
        $current_due = ($opening_balance + $sales_due) - $sales_return_due;
      }
    }
  ?>

  <!-- Left side column. contains the logo and sidebar -->
  <?php $this->load->view('sidebar');?>
  <?php $CI =& get_instance(); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-book text-blue"></i> <?= $this->lang->line('customer_book'); ?>
        <small>Customer Transaction Ledger</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $base_url; ?>customers"><?= $this->lang->line('customers_list'); ?></a></li>
        <li class="active"><?= $this->lang->line('customer_book'); ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- ********** ALERT MESSAGE START******* -->
        <?php $this->load->view('comman/code_flashdata');?>
        <!-- ********** ALERT MESSAGE END******* -->

        <div class="col-md-12">
          <!-- Customer Profile Summary Header -->
          <div class="box box-primary">
            <div class="box-body">
              <div class="row">
                <div class="col-md-3 col-sm-6">
                  <div class="cb-label">Customer Name</div>
                  <div class="cb-val text-primary"><?= htmlspecialchars($customer_name); ?></div>
                  <div style="font-size:12px; color:#555;"><i class="fa fa-barcode"></i> <?= htmlspecialchars($customer_code); ?></div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="cb-label">Contact Details</div>
                  <div class="cb-val"><i class="fa fa-phone text-muted"></i> <?= !empty($mobile) ? htmlspecialchars($mobile) : '-'; ?></div>
                  <div style="font-size:12px; color:#555;"><i class="fa fa-envelope-o text-muted"></i> <?= !empty($email) ? htmlspecialchars($email) : '-'; ?></div>
                </div>
                <div class="col-md-2 col-sm-4">
                  <div class="cb-label">Opening Balance</div>
                  <div class="cb-val"><?= store_number_format($opening_balance); ?> Tk</div>
                </div>
                <div class="col-md-2 col-sm-4">
                  <div class="cb-label">Total Advance</div>
                  <div class="cb-val text-green"><?= store_number_format($tot_advance); ?> Tk</div>
                </div>
                <div class="col-md-2 col-sm-4">
                  <div class="cb-label">Current Due Balance</div>
                  <div class="cb-val text-danger" style="font-size:17px;"><?= store_number_format($current_due); ?> Tk</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xs-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-list"></i> Customer Transactions</h3>
              <div class="box-tools pull-right">
                <a href="<?= base_url('customers'); ?>" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back to Customers</a>
              </div>
            </div>
            
            <div class="box-body">
              <!-- Filter Row -->
              <div class="row" style="margin-bottom:15px;">
                <div class="col-md-3 col-sm-6">
                  <div class="form-group" style="margin-bottom:0;">
                    <label for="from_date"><?= $this->lang->line('from_date'); ?></label>
                    <div class="input-group date">
                      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                      <input type="text" class="form-control datepicker" id="from_date" name="from_date" placeholder="DD-MM-YYYY">
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="form-group" style="margin-bottom:0;">
                    <label for="to_date"><?= $this->lang->line('to_date'); ?></label>
                    <div class="input-group date">
                      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                      <input type="text" class="form-control datepicker" id="to_date" name="to_date" placeholder="DD-MM-YYYY">
                    </div>
                  </div>
                </div>
                <div class="col-md-2 col-sm-4" style="margin-top:25px;">
                  <button type="button" id="btn_reset_filter" class="btn btn-default btn-flat btn-block"><i class="fa fa-refresh"></i> Reset</button>
                </div>
              </div>

              <!-- Transactions Table -->
              <div class="table-responsive">
                <table id="customer_book_table" class="table table-bordered table-striped custom_hover" width="100%">
                  <thead class="bg-gray">
                    <tr>
                      <th style="width:10%; text-align:center;"><?= $this->lang->line('date'); ?></th>
                      <th style="width:20%;"><?= $this->lang->line('description'); ?></th>
                      <th style="width:12%; text-align:center;">Ref / Invoice #</th>
                      <th style="width:13%; text-align:right;">Debit (Tk)</th>
                      <th style="width:13%; text-align:right;">Credit (Tk)</th>
                      <th style="width:14%; text-align:right;">Balance (Tk)</th>
                      <th style="width:10%;"><?= $this->lang->line('note'); ?></th>
                      <th style="width:8%;"><?= $this->lang->line('created_by'); ?></th>
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

  <?php $this->load->view('footer.php');?>
  <div class="control-sidebar-bg"></div>
</div>

<!-- SOUND CODE -->
<?php $this->load->view('comman/code_js_sound.php');?>
<!-- TABLES CODE -->
<?php $this->load->view('comman/code_js.php');?>

<script type="text/javascript">
function load_datatable(){
    var table = $('#customer_book_table').DataTable({ 
      dom: '<"row margin-bottom-12"<"col-sm-12"<"pull-left"l><"pull-right"fr><"pull-right margin-left-10 "B>>>tip',
      buttons: {
        buttons: [
            { extend: 'copy', className: 'btn bg-teal color-palette btn-flat', exportOptions: { columns: [0,1,2,3,4,5,6,7]} },
            { extend: 'excel', className: 'btn bg-teal color-palette btn-flat', exportOptions: { columns: [0,1,2,3,4,5,6,7]} },
            { extend: 'pdf', className: 'btn bg-teal color-palette btn-flat', exportOptions: { columns: [0,1,2,3,4,5,6,7]} },
            { extend: 'print', className: 'btn bg-teal color-palette btn-flat', exportOptions: { columns: [0,1,2,3,4,5,6,7]} },
            { extend: 'csv', className: 'btn bg-teal color-palette btn-flat', exportOptions: { columns: [0,1,2,3,4,5,6,7]} },
            { extend: 'colvis', className: 'btn bg-teal color-palette btn-flat', text:'Columns' },  
        ]
      },
      "processing": true,
      "serverSide": true,
      "order": [],
      "responsive": true,
      "searching": false,
      language: {
          processing: '<div class="text-primary bg-primary" style="position: relative;z-index:100;overflow: visible;">Processing...</div>'
      },
      "ajax": {
          "url": "<?php echo site_url('customers/book_ajax_list')?>",
          "type": "POST",
          "data": {
              customer_id: '<?=$customer_id?>',
              from_date: $("#from_date").val(),
              to_date: $("#to_date").val(),
              '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
          }
      },
      "columnDefs": [
        { "targets": [ 0, 1, 2, 3, 4, 5, 6, 7 ], "orderable": false },
        { "targets": [ 0, 2 ], "className": "text-center" },
        { "targets": [ 3, 4, 5 ], "className": "text-right" },
      ],
    });
    new $.fn.dataTable.FixedHeader( table );
}

$(document).ready(function() {
    load_datatable();

    $("#from_date, #to_date").on("change", function(){
        $('#customer_book_table').DataTable().destroy();
        load_datatable();
    });

    $("#btn_reset_filter").on("click", function(){
        $("#from_date").val('');
        $("#to_date").val('');
        $('#customer_book_table').DataTable().destroy();
        load_datatable();
    });
});
</script>
<script>$(".customers_view-active-li").addClass("active");</script>		
</body>
</html>
