<!DOCTYPE html>
<html>
<head>
  <!-- TABLES CSS CODE -->
  <?php $this->load->view('comman/code_css.php'); ?>
  <style type="text/css">
    .emp-stat-box {
      background: #ffffff;
      border-radius: 12px;
      padding: 16px 20px;
      margin-bottom: 20px;
      border: 1px solid #e2e8f0;
      box-shadow: 0 4px 14px rgba(0,0,0,0.04);
      display: flex;
      align-items: center;
      gap: 16px;
      transition: all 0.2s;
    }
    .emp-stat-box:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    }
    .emp-stat-icon {
      width: 48px;
      height: 48px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 22px;
      color: #fff;
      flex-shrink: 0;
    }
    .emp-stat-val {
      font-size: 22px;
      font-weight: 800;
      color: #1e293b;
      margin: 0;
      line-height: 1.2;
    }
    .emp-stat-label {
      font-size: 12px;
      color: #64748b;
      margin: 0;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .btn-add-emp {
      background: linear-gradient(135deg, #00c0ef, #0097bc);
      color: #fff;
      font-weight: 700;
      padding: 8px 20px;
      border-radius: 8px;
      border: none;
      box-shadow: 0 3px 10px rgba(0, 192, 239, 0.35);
    }
    .btn-add-emp:hover {
      color: #fff;
      background: linear-gradient(135deg, #00b0dc, #0081a1);
    }
    #employee_table td {
      vertical-align: middle;
    }
    #employee_table thead th {
      background-color: #f8fafc;
      color: #334155;
      font-weight: 700;
      border-bottom: 2px solid #e2e8f0;
    }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php $this->load->view('sidebar'); ?>
  <?php $CI =& get_instance(); ?>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <?= $page_title; ?>
        <small>Human Resources / Employees</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?= $page_title; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <?php $this->load->view('comman/code_flashdata'); ?>
        </div>
      </div>

      <!-- Quick KPI Stats -->
      <div class="row">
        <div class="col-md-3 col-sm-6">
          <div class="emp-stat-box">
            <div class="emp-stat-icon" style="background: linear-gradient(135deg, #0284c7, #0369a1);"><i class="fa fa-users"></i></div>
            <div>
              <p class="emp-stat-label">Total Employees</p>
              <h3 class="emp-stat-val"><?= $stats['total']; ?></h3>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="emp-stat-box">
            <div class="emp-stat-icon" style="background: linear-gradient(135deg, #10b981, #059669);"><i class="fa fa-user-circle"></i></div>
            <div>
              <p class="emp-stat-label">Active Staff</p>
              <h3 class="emp-stat-val"><?= $stats['active']; ?></h3>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="emp-stat-box">
            <div class="emp-stat-icon" style="background: linear-gradient(135deg, #ef4444, #dc2626);"><i class="fa fa-user-times"></i></div>
            <div>
              <p class="emp-stat-label">Inactive Staff</p>
              <h3 class="emp-stat-val"><?= $stats['inactive']; ?></h3>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="emp-stat-box">
            <div class="emp-stat-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);"><i class="fa fa-money"></i></div>
            <div>
              <p class="emp-stat-label">Monthly Payroll</p>
              <h3 class="emp-stat-val"><?= $CI->currency($stats['payroll']); ?></h3>
            </div>
          </div>
        </div>
      </div>

      <!-- Employees DataTable Box -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box" style="border-radius:12px; border:1px solid #e2e8f0; box-shadow:0 4px 18px rgba(0,0,0,0.05); overflow:hidden;">
            <div class="box-header with-border" style="background:#ffffff; padding:16px 20px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
              <div>
                <h3 class="box-title" style="font-weight:700; color:#1e293b; font-size:17px;">
                  <i class="fa fa-id-badge text-aqua"></i> Employee Directory
                </h3>
              </div>
              <?php if($CI->permissions('employee_add')) { ?>
              <div class="box-tools pull-right" style="position:static;">
                <a href="<?php echo $base_url; ?>employee/add" class="btn btn-add-emp">
                  <i class="fa fa-plus"></i> Add New Employee
                </a>
              </div>
              <?php } ?>
            </div>

            <div class="box-body" style="padding:20px;">
              <table id="employee_table" class="table table-bordered table-striped custom_hover" width="100%">
                <thead>
                  <tr>
                    <th style="width:50px;" class="text-center">Photo</th>
                    <th style="width:90px;">Employee ID</th>
                    <th>Name & Email</th>
                    <th>Mobile</th>
                    <th>Role & Dept</th>
                    <th>Joining Date</th>
                    <th>Salary</th>
                    <th style="width:80px;" class="text-center">Status</th>
                    <th style="width:90px;" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Employee Full Profile Modal -->
  <div class="modal fade" id="employee_profile_modal" tabindex="-1" role="dialog" aria-labelledby="empProfileModalLabel">
    <div class="modal-dialog modal-lg" role="document" style="width:85%; max-width:1050px;">
      <div class="modal-content" style="border-radius:14px; overflow:hidden; border:none; box-shadow:0 10px 40px rgba(0,0,0,0.25);">
        <div class="modal-header" style="background:linear-gradient(135deg, #00c0ef, #0073b7); color:#fff; padding:16px 22px;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:0.9; font-size:24px;">&times;</button>
          <h4 class="modal-title" id="empProfileModalLabel" style="font-weight:700;">
            <i class="fa fa-id-card-o"></i> Complete Employee Profile & CV
          </h4>
        </div>
        <div class="modal-body" id="employee_profile_content" style="padding:24px; max-height:80vh; overflow-y:auto; background:#f8fafc;">
          <div class="text-center" style="padding:40px;"><i class="fa fa-spinner fa-spin fa-2x text-aqua"></i><br>Loading details...</div>
        </div>
      </div>
    </div>
  </div>

  <input type="hidden" id="base_url" value="<?= $base_url; ?>">

  <?php $this->load->view('footer'); ?>
</div>

<!-- TABLES CODE -->
<?php $this->load->view('comman/code_js.php'); ?>

<script type="text/javascript">
  var employeeTable;

  function load_employee_datatable() {
    employeeTable = $('#employee_table').DataTable({
      dom: '<"row margin-bottom-12"<"col-sm-12"<"pull-left"l><"pull-right"fr><"pull-right margin-left-10"B>>>tip',
      buttons: {
        buttons: [
          { extend: 'copy', className: 'btn bg-teal color-palette btn-flat', exportOptions: { columns: [1,2,3,4,5,6,7]} },
          { extend: 'excel', className: 'btn bg-teal color-palette btn-flat', exportOptions: { columns: [1,2,3,4,5,6,7]} },
          { extend: 'pdf', className: 'btn bg-teal color-palette btn-flat', exportOptions: { columns: [1,2,3,4,5,6,7]} },
          { extend: 'print', className: 'btn bg-teal color-palette btn-flat', exportOptions: { columns: [1,2,3,4,5,6,7]} },
          { extend: 'csv', className: 'btn bg-teal color-palette btn-flat', exportOptions: { columns: [1,2,3,4,5,6,7]} },
          { extend: 'colvis', className: 'btn bg-teal color-palette btn-flat', text: 'Columns' }
        ]
      },
      "processing": true,
      "serverSide": true,
      "order": [[1, "desc"]],
      "responsive": true,
      language: {
        processing: '<div class="text-primary bg-primary" style="position:relative; z-index:100; padding:4px 10px; border-radius:4px;">Processing...</div>'
      },
      "ajax": {
        "url": "<?php echo site_url('employee/ajax_list'); ?>",
        "type": "POST",
        "data": function(d) {
          d['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
        }
      },
      "columnDefs": [
        { "targets": [0, 8], "orderable": false },
        { "targets": [0, 1, 7, 8], "className": "text-center" }
      ]
    });
  }

  $(document).ready(function() {
    load_employee_datatable();
    $(".employee-list-active-li").addClass("active");
  });

  function update_status(id, status) {
    var base_url = $("#base_url").val();
    $.post(base_url + "employee/update_status", { id: id, status: status }, function(res) {
      if (res.trim() === 'success') {
        toastr["success"]("Employee status updated successfully!");
        employeeTable.ajax.reload(null, false);
      } else {
        toastr["error"]("Failed to update status!");
      }
    });
  }

  function delete_employee(id) {
    if (confirm("Are you sure you want to delete this employee? All related files and records will be removed.")) {
      var base_url = $("#base_url").val();
      $.post(base_url + "employee/delete_employee", { q_id: id }, function(res) {
        if (res.trim() === 'success') {
          toastr["success"]("Employee deleted successfully!");
          employeeTable.ajax.reload(null, false);
        } else {
          toastr["error"](res);
        }
      });
    }
  }

  function view_profile(id) {
    var base_url = $("#base_url").val();
    $("#employee_profile_modal").modal('show');
    $("#employee_profile_content").html('<div class="text-center" style="padding:40px;"><i class="fa fa-spinner fa-spin fa-2x text-aqua"></i><br>Loading details...</div>');

    $.get(base_url + "employee/view_profile/" + id + "?modal=1", function(html) {
      $("#employee_profile_content").html(html);
    });
  }
</script>
</body>
</html>
