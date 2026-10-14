<!DOCTYPE html>
<html>
<head>
  <?php $CI =& get_instance(); ?>
  <meta charset="utf-8">
  <title>Employee_<?= $employee->employee_code; ?>_<?= $employee->first_name; ?></title>
  <style type="text/css">
    @page {
      margin: 15mm 15mm 15mm 15mm;
    }
    body {
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
      font-size: 11px;
      color: #1e293b;
      line-height: 1.4;
      margin: 0;
      padding: 0;
    }
    .header-table {
      width: 100%;
      border-bottom: 2px solid #00c0ef;
      padding-bottom: 10px;
      margin-bottom: 14px;
    }
    .header-table td {
      vertical-align: middle;
    }
    .store-name {
      font-size: 20px;
      font-weight: bold;
      color: #0073b7;
      margin: 0 0 3px;
    }
    .store-sub {
      font-size: 10px;
      color: #64748b;
      margin: 0;
    }
    .doc-title {
      font-size: 14px;
      font-weight: bold;
      color: #334155;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      text-align: right;
    }
    .profile-hero {
      width: 100%;
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 6px;
      margin-bottom: 14px;
    }
    .profile-hero td {
      padding: 10px 12px;
      vertical-align: middle;
    }
    .emp-name {
      font-size: 16px;
      font-weight: bold;
      color: #0f172a;
      margin: 0 0 2px;
    }
    .emp-role {
      font-size: 12px;
      font-weight: 600;
      color: #0284c7;
      margin: 0;
    }
    .section-title {
      background: #f1f5f9;
      border-left: 3px solid #00c0ef;
      padding: 4px 8px;
      font-size: 11px;
      font-weight: bold;
      color: #0f172a;
      text-transform: uppercase;
      margin: 12px 0 6px;
    }
    .data-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 10px;
    }
    .data-table td {
      padding: 4px 6px;
      border: 1px solid #e2e8f0;
      font-size: 10px;
      vertical-align: top;
    }
    .data-table .label-col {
      background: #f8fafc;
      font-weight: bold;
      color: #475569;
      width: 22%;
    }
    .text-box {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 4px;
      padding: 6px 8px;
      font-size: 10px;
      line-height: 1.5;
      min-height: 38px;
      margin-bottom: 10px;
    }
    .footer-sign-table {
      width: 100%;
      margin-top: 30px;
    }
    .footer-sign-table td {
      text-align: center;
      vertical-align: bottom;
      font-size: 10px;
      padding-top: 35px;
      border-top: 1px dashed #cbd5e1;
    }
    @media print {
      .no-print { display: none !important; }
    }
  </style>
</head>
<body>

<?php if(isset($auto_print) && $auto_print){ ?>
<div class="no-print" style="background:#00c0ef; color:#fff; padding:10px 20px; margin-bottom:15px; display:flex; justify-content:space-between; align-items:center;">
  <span><b>Print Preview:</b> Employee CV Document</span>
  <div>
    <button onclick="window.print()" style="padding:5px 15px; font-weight:bold; background:#fff; color:#0073b7; border:none; border-radius:4px; cursor:pointer;">
      <i class="fa fa-print"></i> Print Now
    </button>
  </div>
</div>
<?php } ?>

<!-- Header -->
<table class="header-table">
  <tr>
    <td style="width:60%;">
      <h1 class="store-name"><?= (!empty($store_details->store_name)) ? $store_details->store_name : 'Shopkeeper POS'; ?></h1>
      <p class="store-sub">
        <?= (!empty($store_details->address)) ? $store_details->address : ''; ?>
        <?= (!empty($store_details->mobile)) ? ' &bull; Phone: ' . $store_details->mobile : ''; ?>
        <?= (!empty($store_details->email)) ? ' &bull; Email: ' . $store_details->email : ''; ?>
      </p>
    </td>
    <td style="width:40%;">
      <div class="doc-title">Employee Curriculum Vitae</div>
      <div style="text-align:right; font-size:10px; color:#64748b;">
        Print Date: <?= date('d-m-Y'); ?>
      </div>
    </td>
  </tr>
</table>

<!-- Profile Hero Block -->
<table class="profile-hero">
  <tr>
    <?php
      $photo_src = '';
      if(!empty($employee->photo) && file_exists(FCPATH . $employee->photo)){
        $photo_data = file_get_contents(FCPATH . $employee->photo);
        $photo_type = pathinfo(FCPATH . $employee->photo, PATHINFO_EXTENSION);
        $photo_src = 'data:image/' . $photo_type . ';base64,' . base64_encode($photo_data);
      }
    ?>
    <?php if(!empty($photo_src)){ ?>
    <td style="width:75px; text-align:center;">
      <img src="<?= $photo_src; ?>" style="width:68px; height:68px; border-radius:50%; border:2px solid #00c0ef; object-fit:cover;">
    </td>
    <?php } ?>
    <td>
      <div class="emp-name"><?= htmlspecialchars($employee->first_name . ' ' . $employee->last_name); ?></div>
      <div class="emp-role">
        <?= (!empty($employee->designation)) ? htmlspecialchars($employee->designation) : 'Employee'; ?>
        <?= (!empty($employee->department)) ? ' | ' . htmlspecialchars($employee->department) : ''; ?>
      </div>
      <div style="font-size:10px; color:#64748b; margin-top:2px;">
        Employee ID: <b><?= htmlspecialchars($employee->employee_code); ?></b> &bull;
        Joining Date: <b><?= (!empty($employee->joining_date) && $employee->joining_date != '1970-01-01') ? show_date($employee->joining_date) : '-'; ?></b> &bull;
        Status: <b><?= ($employee->status == 1) ? 'Active' : 'Inactive'; ?></b>
      </div>
    </td>
    <td style="text-align:right; width:130px;">
      <div style="font-size:10px; color:#64748b;">Monthly Salary</div>
      <div style="font-size:15px; font-weight:bold; color:#059669;">
        <?= $CI->currency($employee->monthly_salary); ?>
      </div>
    </td>
  </tr>
</table>

<!-- 1. Personal & Contact Information -->
<div class="section-title">1. Personal & Contact Details</div>
<table class="data-table">
  <tr>
    <td class="label-col">Full Name:</td>
    <td><?= htmlspecialchars($employee->first_name . ' ' . $employee->last_name); ?></td>
    <td class="label-col">Mobile Number:</td>
    <td><b><?= htmlspecialchars($employee->mobile); ?></b></td>
  </tr>
  <tr>
    <td class="label-col">Email Address:</td>
    <td><?= (!empty($employee->email)) ? htmlspecialchars($employee->email) : '-'; ?></td>
    <td class="label-col">Alternative Phone:</td>
    <td><?= (!empty($employee->phone)) ? htmlspecialchars($employee->phone) : '-'; ?></td>
  </tr>
  <tr>
    <td class="label-col">Date of Birth:</td>
    <td><?= (!empty($employee->dob) && $employee->dob != '1970-01-01') ? show_date($employee->dob) : '-'; ?></td>
    <td class="label-col">Gender:</td>
    <td><?= (!empty($employee->gender)) ? htmlspecialchars($employee->gender) : '-'; ?></td>
  </tr>
  <tr>
    <td class="label-col">Marital Status:</td>
    <td><?= (!empty($employee->marital_status)) ? htmlspecialchars($employee->marital_status) : '-'; ?></td>
    <td class="label-col">Blood Group:</td>
    <td><b><?= (!empty($employee->blood_group)) ? htmlspecialchars($employee->blood_group) : '-'; ?></b></td>
  </tr>
  <tr>
    <td class="label-col">National ID (NID):</td>
    <td><b><?= (!empty($employee->nid_number)) ? htmlspecialchars($employee->nid_number) : '-'; ?></b></td>
    <td class="label-col">Designation / Role:</td>
    <td><?= (!empty($employee->designation)) ? htmlspecialchars($employee->designation) : '-'; ?></td>
  </tr>
</table>

<!-- 2. Address & Emergency Contact -->
<div class="section-title">2. Address & Emergency Information</div>
<table class="data-table">
  <tr>
    <td class="label-col">Present Address:</td>
    <td><?= (!empty($employee->present_address)) ? nl2br(htmlspecialchars($employee->present_address)) : '-'; ?></td>
    <td class="label-col">Permanent Address:</td>
    <td><?= (!empty($employee->permanent_address)) ? nl2br(htmlspecialchars($employee->permanent_address)) : '-'; ?></td>
  </tr>
  <tr>
    <td class="label-col">Emergency Contact:</td>
    <td><?= (!empty($employee->emergency_contact_name)) ? htmlspecialchars($employee->emergency_contact_name) : '-'; ?></td>
    <td class="label-col">Relationship:</td>
    <td><?= (!empty($employee->emergency_contact_relation)) ? htmlspecialchars($employee->emergency_contact_relation) : '-'; ?></td>
  </tr>
  <tr>
    <td class="label-col">Emergency Mobile:</td>
    <td colspan="3"><b><?= (!empty($employee->emergency_contact_mobile)) ? htmlspecialchars($employee->emergency_contact_mobile) : '-'; ?></b></td>
  </tr>
</table>

<!-- 3. Bank Account Information -->
<div class="section-title">3. Bank Account Details</div>
<table class="data-table">
  <tr>
    <td class="label-col">Bank Name:</td>
    <td><b><?= (!empty($employee->bank_name)) ? htmlspecialchars($employee->bank_name) : '-'; ?></b></td>
    <td class="label-col">Account Holder:</td>
    <td><?= (!empty($employee->bank_account_holder)) ? htmlspecialchars($employee->bank_account_holder) : '-'; ?></td>
  </tr>
  <tr>
    <td class="label-col">Account Number:</td>
    <td><b><?= (!empty($employee->bank_account_number)) ? htmlspecialchars($employee->bank_account_number) : '-'; ?></b></td>
    <td class="label-col">Branch & Routing:</td>
    <td>
      <?= (!empty($employee->bank_branch)) ? htmlspecialchars($employee->bank_branch) : '-'; ?>
      <?= (!empty($employee->bank_routing_code)) ? ' (Routing: ' . htmlspecialchars($employee->bank_routing_code) . ')' : ''; ?>
    </td>
  </tr>
</table>

<!-- 4. Complete CV & Qualifications -->
<div class="section-title">4. Educational Qualifications</div>
<div class="text-box">
  <?= (!empty($employee->education_details)) ? nl2br(htmlspecialchars($employee->education_details)) : 'No education records specified'; ?>
</div>

<div class="section-title">5. Work Experience History</div>
<div class="text-box">
  <?= (!empty($employee->experience_details)) ? nl2br(htmlspecialchars($employee->experience_details)) : 'No work experience records specified'; ?>
</div>

<div class="section-title">6. Skills & Specialization</div>
<div class="text-box">
  <?= (!empty($employee->skills)) ? nl2br(htmlspecialchars($employee->skills)) : 'No skills specified'; ?>
</div>

<?php if(!empty($employee->notes)){ ?>
<div class="section-title">7. Bio Summary / Remarks</div>
<div class="text-box">
  <?= nl2br(htmlspecialchars($employee->notes)); ?>
</div>
<?php } ?>

<!-- Signatures -->
<table class="footer-sign-table">
  <tr>
    <td style="width:30%;">Employee Signature</td>
    <td style="width:30%;">Prepared By</td>
    <td style="width:30%;">Authorized Signature</td>
  </tr>
</table>

<?php if(isset($auto_print) && $auto_print){ ?>
<script type="text/javascript">
  window.onload = function() {
    window.print();
  }
</script>
<?php } ?>

</body>
</html>
