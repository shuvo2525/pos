<!DOCTYPE html>
<html>
<head>
  <!-- TABLES CSS CODE -->
  <?php $this->load->view('comman/code_css.php'); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php $this->load->view('sidebar'); ?>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <?= $page_title; ?>
        <small>Employee Bio & Qualifications</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $base_url; ?>employee">HR / Employees</a></li>
        <li class="active">Profile</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <?php $this->load->view('comman/code_flashdata'); ?>
        </div>
      </div>

      <?php $this->load->view('employee/employee_profile_partial'); ?>
    </section>
  </div>

  <?php $this->load->view('footer'); ?>
</div>

<!-- TABLES CODE -->
<?php $this->load->view('comman/code_js.php'); ?>
<script type="text/javascript">
  $(".employee-list-active-li").addClass("active");
</script>
</body>
</html>
