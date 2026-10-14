<!DOCTYPE html>
<html>
<head>
<!-- FORM CSS CODE -->
<?php $this->load->view('comman/code_css.php'); ?>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
<style type="text/css">
  .locked-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #fee2e2;
    box-shadow: 0 10px 30px rgba(220, 38, 38, 0.08);
    overflow: hidden;
    max-width: 780px;
    margin: 30px auto;
  }
  .locked-header {
    background: linear-gradient(135deg, #7f1d1d 0%, #b91c1c 50%, #dc2626 100%);
    padding: 24px 30px;
    color: #ffffff;
    text-align: center;
  }
  .locked-icon-wrap {
    width: 70px;
    height: 70px;
    background: rgba(255, 255, 255, 0.15);
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    margin: 0 auto 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    color: #ffffff;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  }
  .locked-body {
    padding: 30px 35px;
    text-align: center;
  }
  .locked-badge-box {
    background: #fff8f8;
    border: 1.5px dashed #fca5a5;
    border-radius: 12px;
    padding: 16px 20px;
    margin: 20px 0;
    text-align: left;
  }
</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php $this->load->view('sidebar'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-lock text-red"></i> <?= !empty($page_title) ? $page_title : 'Access Restricted'; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Access Restricted</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          
          <?php
            $st_id = get_current_store_id();
            $st_rec = $this->db->where('id', $st_id)->get('db_store')->row();
            $sub_rec = (!empty($st_rec) && !empty($st_rec->current_subscriptionlist_id)) ? $this->db->where('id', $st_rec->current_subscriptionlist_id)->get('db_subscription')->row() : null;
            if(empty($sub_rec)){
              $sub_rec = $this->db->where('store_id', $st_id)->order_by('id', 'desc')->get('db_subscription')->row();
            }
            $pay_pkg_id = (!empty($sub_rec) && !empty($sub_rec->package_id)) ? $sub_rec->package_id : 3;
            $direct_gateway_url = base_url('subscription/plan/' . $pay_pkg_id);
            $is_due_lock = (!empty($st_rec) && !empty($st_rec->auto_lock_day) && $st_rec->auto_lock_day > 0 && !empty($st_rec->auto_lock_date) && $st_rec->auto_lock_date <= date('Y-m-d'));
          ?>
          <div class="locked-card">
            <div class="locked-header">
              <div class="locked-icon-wrap">
                <i class="fa fa-lock"></i>
              </div>
              <h2 style="margin: 0 0 6px; font-weight: 800; font-size: 24px; color: #ffffff;">
                Store Access Restricted
              </h2>
              <p style="margin: 0; font-size: 14px; color: #fecaca;">
                Access is temporarily restricted until subscription payment is completed
              </p>
            </div>
            <div class="locked-body">
              <p style="font-size: 15px; color: #374151; line-height: 1.7; margin-bottom: 16px;">
                Your store has been locked due to pending monthly subscription payment or administrative review. Click the button below to complete payment via our secure online payment gateway. Once payment is confirmed, your store will <strong>automatically unlock immediately</strong> without requiring manual Super Admin intervention.
              </p>

              <div class="locked-badge-box">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                  <div>
                    <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #991b1b; display: block;">Store Name:</span>
                    <strong style="font-size: 16px; color: #111827;"><?= $this->session->userdata('store_name'); ?></strong>
                  </div>
                  <div>
                    <span class="label label-danger" style="font-size: 13px; padding: 6px 16px; border-radius: 20px; font-weight: 700;">
                      <i class="fa fa-lock"></i> Status: Locked
                    </span>
                  </div>
                </div>

                <?php if($is_due_lock){ ?>
                <div style="margin-top: 14px; padding-top: 12px; border-top: 1px solid #fecaca; font-size: 13.5px; color: #7f1d1d;">
                  <i class="fa fa-clock-o text-red"></i> <strong>Lock Reason:</strong> Monthly auto-lock was scheduled for day <strong><?= $st_rec->auto_lock_day; ?></strong> of the month (Due date: <?= show_date($st_rec->auto_lock_date); ?>). Store is locked due to pending subscription fee.
                  <?= !empty($st_rec->auto_lock_note) ? '<br><i class="fa fa-info-circle text-primary"></i> <strong>Admin Note:</strong> '.htmlspecialchars($st_rec->auto_lock_note) : ''; ?>
                </div>
                <?php } else { ?>
                <div style="margin-top: 14px; padding-top: 12px; border-top: 1px solid #fecaca; font-size: 13.5px; color: #7f1d1d;">
                  <i class="fa fa-shield text-red"></i> <strong>Lock Reason:</strong> Store locked or pending authorization by Super Admin.
                </div>
                <?php } ?>
              </div>

              <!-- Prominent Click Here to Pay Online Button -->
              <div style="margin: 28px 0 16px; text-align: center;">
                <a href="<?= $direct_gateway_url; ?>" class="btn btn-lg btn-danger" style="background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%); border: none; border-radius: 12px; font-weight: 800; font-size: 16.5px; padding: 15px 36px; box-shadow: 0 8px 24px rgba(220, 38, 38, 0.4); text-transform: uppercase; letter-spacing: 0.6px; display: inline-flex; align-items: center; gap: 10px; transition: transform 0.2s ease;">
                  <i class="fa fa-credit-card" style="font-size: 20px;"></i>
                  Click Here to Pay Online & Auto-Unlock
                </a>
                <div style="margin-top: 10px; font-size: 13px; color: #059669; font-weight: 700;">
                  <i class="fa fa-check-circle"></i> Your store will automatically unlock immediately upon payment confirmation!
                </div>
              </div>

              <div style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; margin-top: 20px; border-top: 1px solid #f1f5f9; padding-top: 18px;">
                <a href="<?= base_url('subscription'); ?>" class="btn btn-default" style="border-radius: 8px; font-weight: 600; padding: 9px 22px;">
                  <i class="fa fa-list"></i> Select Package / View Plans
                </a>
                <a href="<?= base_url('dashboard'); ?>" class="btn btn-default" style="border-radius: 8px; font-weight: 600; padding: 9px 22px;">
                  <i class="fa fa-dashboard"></i> Go to Dashboard
                </a>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->

  <?php $this->load->view('footer.php'); ?>
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- SOUND CODE -->
<?php $this->load->view('comman/code_js_sound.php'); ?>
<!-- TABLES CODE -->
<?php $this->load->view('comman/code_js.php'); ?>

</body>
</html>
