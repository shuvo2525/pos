<?php
  $CI =& get_instance();
  $full_name = htmlspecialchars($employee->first_name . ' ' . $employee->last_name);
?>
<div class="emp-profile-wrap">
  <!-- Top Profile Card -->
  <div style="background:#ffffff; border-radius:12px; padding:20px 24px; margin-bottom:20px; border:1px solid #e2e8f0; box-shadow:0 4px 14px rgba(0,0,0,0.04); display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px;">
    <div style="display:flex; align-items:center; gap:20px;">
      <div style="width:84px; height:84px; border-radius:50%; border:3px solid #00c0ef; overflow:hidden; flex-shrink:0; box-shadow:0 4px 12px rgba(0,0,0,0.1); background:#f1f5f9; display:flex; align-items:center; justify-content:center;">
        <?php if(!empty($employee->photo) && file_exists(FCPATH . $employee->photo)){ ?>
          <img src="<?= base_url($employee->photo); ?>" alt="<?= $full_name; ?>" style="width:100%; height:100%; object-fit:cover;">
        <?php } else { ?>
          <span style="font-size:32px; font-weight:700; color:#00c0ef;"><?= strtoupper(substr($employee->first_name, 0, 1)); ?></span>
        <?php } ?>
      </div>
      <div>
        <h3 style="margin:0 0 6px; font-weight:800; color:#1e293b; font-size:22px;">
          <?= $full_name; ?>
          <span class="label label-primary" style="font-size:12px; vertical-align:middle; margin-left:8px;"><?= htmlspecialchars($employee->employee_code); ?></span>
          <?php if($employee->status == 1){ ?>
            <span class="label label-success" style="font-size:11px; vertical-align:middle;">Active</span>
          <?php } else { ?>
            <span class="label label-danger" style="font-size:11px; vertical-align:middle;">Inactive</span>
          <?php } ?>
        </h3>
        <p style="margin:0; color:#64748b; font-size:14px; font-weight:600;">
          <?php if(!empty($employee->designation)){ ?>
            <i class="fa fa-black-tie text-purple"></i> <?= htmlspecialchars($employee->designation); ?>
          <?php } ?>
          <?php if(!empty($employee->department)){ ?>
            &bull; <i class="fa fa-building-o text-blue"></i> <?= htmlspecialchars($employee->department); ?>
          <?php } ?>
        </p>
      </div>
    </div>

    <!-- Quick Action Buttons -->
    <div style="display:flex; gap:8px; flex-wrap:wrap;">
      <a href="<?= base_url('employee/pdf/' . $employee->id); ?>" target="_blank" class="btn btn-danger btn-sm" style="border-radius:6px; font-weight:600; padding:7px 14px;">
        <i class="fa fa-file-pdf-o"></i> Download PDF
      </a>
      <a href="<?= base_url('employee/print_profile/' . $employee->id); ?>" target="_blank" class="btn btn-info btn-sm" style="border-radius:6px; font-weight:600; padding:7px 14px;">
        <i class="fa fa-print"></i> Print Profile
      </a>
      <a href="<?= base_url('employee/edit/' . $employee->id); ?>" class="btn btn-default btn-sm" style="border-radius:6px; font-weight:600; padding:7px 14px;">
        <i class="fa fa-pencil text-blue"></i> Edit
      </a>
    </div>
  </div>

  <div class="row">
    <!-- 1. Personal & Contact Information -->
    <div class="col-md-6">
      <div style="background:#ffffff; border-radius:12px; padding:18px 20px; margin-bottom:20px; border:1px solid #e2e8f0;">
        <h4 style="margin:0 0 14px; font-size:15px; font-weight:700; color:#0f172a; border-bottom:1.5px solid #f1f5f9; padding-bottom:8px;">
          <i class="fa fa-user text-aqua"></i> Personal & Contact Info
        </h4>
        <table class="table table-sm table-striped" style="margin-bottom:0;">
          <tr>
            <td style="width:38%; font-weight:600; color:#64748b;">Mobile:</td>
            <td><b><a href="tel:<?= $employee->mobile; ?>"><?= htmlspecialchars($employee->mobile); ?></a></b></td>
          </tr>
          <tr>
            <td style="font-weight:600; color:#64748b;">Alternative Phone:</td>
            <td><?= (!empty($employee->phone)) ? htmlspecialchars($employee->phone) : '-'; ?></td>
          </tr>
          <tr>
            <td style="font-weight:600; color:#64748b;">Email:</td>
            <td><?= (!empty($employee->email)) ? '<a href="mailto:' . $employee->email . '">' . htmlspecialchars($employee->email) . '</a>' : '-'; ?></td>
          </tr>
          <tr>
            <td style="font-weight:600; color:#64748b;">Date of Birth:</td>
            <td><?= (!empty($employee->dob) && $employee->dob != '1970-01-01') ? show_date($employee->dob) : '-'; ?></td>
          </tr>
          <tr>
            <td style="font-weight:600; color:#64748b;">Gender:</td>
            <td><?= (!empty($employee->gender)) ? htmlspecialchars($employee->gender) : '-'; ?></td>
          </tr>
          <tr>
            <td style="font-weight:600; color:#64748b;">Marital Status:</td>
            <td><?= (!empty($employee->marital_status)) ? htmlspecialchars($employee->marital_status) : '-'; ?></td>
          </tr>
          <tr>
            <td style="font-weight:600; color:#64748b;">Blood Group:</td>
            <td><?= (!empty($employee->blood_group)) ? '<span class="label label-danger">' . htmlspecialchars($employee->blood_group) . '</span>' : '-'; ?></td>
          </tr>
          <tr>
            <td style="font-weight:600; color:#64748b;">Joining Date:</td>
            <td><?= (!empty($employee->joining_date) && $employee->joining_date != '1970-01-01') ? show_date($employee->joining_date) : '-'; ?></td>
          </tr>
          <tr>
            <td style="font-weight:600; color:#64748b;">Monthly Salary:</td>
            <td><b style="color:#059669; font-size:15px;"><?= $CI->currency($employee->monthly_salary); ?></b></td>
          </tr>
        </table>
      </div>
    </div>

    <!-- 2. Address & Emergency Contact -->
    <div class="col-md-6">
      <!-- Addresses -->
      <div style="background:#ffffff; border-radius:12px; padding:18px 20px; margin-bottom:20px; border:1px solid #e2e8f0;">
        <h4 style="margin:0 0 14px; font-size:15px; font-weight:700; color:#0f172a; border-bottom:1.5px solid #f1f5f9; padding-bottom:8px;">
          <i class="fa fa-map-marker text-red"></i> Address Details
        </h4>
        <div style="margin-bottom:12px;">
          <div style="font-weight:600; color:#64748b; font-size:12px; text-transform:uppercase;">Present Address:</div>
          <div style="color:#1e293b; font-size:14px; margin-top:2px;">
            <?= (!empty($employee->present_address)) ? nl2br(htmlspecialchars($employee->present_address)) : '<span class="text-muted">Not provided</span>'; ?>
          </div>
        </div>
        <div>
          <div style="font-weight:600; color:#64748b; font-size:12px; text-transform:uppercase;">Permanent Address:</div>
          <div style="color:#1e293b; font-size:14px; margin-top:2px;">
            <?= (!empty($employee->permanent_address)) ? nl2br(htmlspecialchars($employee->permanent_address)) : '<span class="text-muted">Not provided</span>'; ?>
          </div>
        </div>
      </div>

      <!-- Emergency Contact -->
      <div style="background:#ffffff; border-radius:12px; padding:18px 20px; margin-bottom:20px; border:1px solid #e2e8f0;">
        <h4 style="margin:0 0 14px; font-size:15px; font-weight:700; color:#0f172a; border-bottom:1.5px solid #f1f5f9; padding-bottom:8px;">
          <i class="fa fa-phone-square text-orange"></i> Emergency Contact
        </h4>
        <table class="table table-sm table-striped" style="margin-bottom:0;">
          <tr>
            <td style="width:38%; font-weight:600; color:#64748b;">Contact Name:</td>
            <td><b><?= (!empty($employee->emergency_contact_name)) ? htmlspecialchars($employee->emergency_contact_name) : '-'; ?></b></td>
          </tr>
          <tr>
            <td style="font-weight:600; color:#64748b;">Relationship:</td>
            <td><?= (!empty($employee->emergency_contact_relation)) ? htmlspecialchars($employee->emergency_contact_relation) : '-'; ?></td>
          </tr>
          <tr>
            <td style="font-weight:600; color:#64748b;">Emergency Mobile:</td>
            <td>
              <?php if(!empty($employee->emergency_contact_mobile)){ ?>
                <b><a href="tel:<?= $employee->emergency_contact_mobile; ?>" class="text-danger"><i class="fa fa-phone"></i> <?= htmlspecialchars($employee->emergency_contact_mobile); ?></a></b>
              <?php } else { echo '-'; } ?>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>

  <div class="row">
    <!-- 3. Bank Account Details -->
    <div class="col-md-6">
      <div style="background:#ffffff; border-radius:12px; padding:18px 20px; margin-bottom:20px; border:1px solid #e2e8f0;">
        <h4 style="margin:0 0 14px; font-size:15px; font-weight:700; color:#0f172a; border-bottom:1.5px solid #f1f5f9; padding-bottom:8px;">
          <i class="fa fa-university text-green"></i> Bank Account Information
        </h4>
        <table class="table table-sm table-striped" style="margin-bottom:0;">
          <tr>
            <td style="width:38%; font-weight:600; color:#64748b;">Bank Name:</td>
            <td><b><?= (!empty($employee->bank_name)) ? htmlspecialchars($employee->bank_name) : '-'; ?></b></td>
          </tr>
          <tr>
            <td style="font-weight:600; color:#64748b;">Account Holder:</td>
            <td><?= (!empty($employee->bank_account_holder)) ? htmlspecialchars($employee->bank_account_holder) : '-'; ?></td>
          </tr>
          <tr>
            <td style="font-weight:600; color:#64748b;">Account Number:</td>
            <td><b><?= (!empty($employee->bank_account_number)) ? htmlspecialchars($employee->bank_account_number) : '-'; ?></b></td>
          </tr>
          <tr>
            <td style="font-weight:600; color:#64748b;">Branch:</td>
            <td><?= (!empty($employee->bank_branch)) ? htmlspecialchars($employee->bank_branch) : '-'; ?></td>
          </tr>
          <tr>
            <td style="font-weight:600; color:#64748b;">Routing / Swift Code:</td>
            <td><?= (!empty($employee->bank_routing_code)) ? htmlspecialchars($employee->bank_routing_code) : '-'; ?></td>
          </tr>
        </table>
      </div>
    </div>

    <!-- 4. National ID (NID) Details -->
    <div class="col-md-6">
      <div style="background:#ffffff; border-radius:12px; padding:18px 20px; margin-bottom:20px; border:1px solid #e2e8f0;">
        <h4 style="margin:0 0 14px; font-size:15px; font-weight:700; color:#0f172a; border-bottom:1.5px solid #f1f5f9; padding-bottom:8px;">
          <i class="fa fa-id-card text-blue"></i> National ID (NID) Details
        </h4>
        <table class="table table-sm table-striped" style="margin-bottom:14px;">
          <tr>
            <td style="width:38%; font-weight:600; color:#64748b;">NID Number:</td>
            <td><b style="font-size:15px; color:#1e293b;"><?= (!empty($employee->nid_number)) ? htmlspecialchars($employee->nid_number) : '-'; ?></b></td>
          </tr>
        </table>
        <div>
          <div style="font-weight:600; color:#64748b; font-size:12px; margin-bottom:6px;">NID Card Document:</div>
          <?php if(!empty($employee->nid_photo) && file_exists(FCPATH . $employee->nid_photo)){ 
            $ext = strtolower(pathinfo($employee->nid_photo, PATHINFO_EXTENSION));
          ?>
            <?php if(in_array($ext, array('jpg','jpeg','png','gif','webp'))){ ?>
              <div style="max-height:160px; overflow:hidden; border-radius:8px; border:1px solid #cbd5e1; margin-bottom:8px;">
                <img src="<?= base_url($employee->nid_photo); ?>" alt="NID Photo" style="width:100%; height:auto; object-fit:contain;">
              </div>
            <?php } ?>
            <a href="<?= base_url($employee->nid_photo); ?>" target="_blank" class="btn btn-xs btn-primary" style="border-radius:4px; font-weight:600;">
              <i class="fa fa-external-link"></i> View / Download Full NID Document
            </a>
          <?php } else { ?>
            <span class="text-muted" style="font-size:13px;">No NID document uploaded</span>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>

  <!-- 5. Complete CV & Qualifications Section -->
  <div class="row">
    <div class="col-md-12">
      <div style="background:#ffffff; border-radius:12px; padding:20px 24px; border:1px solid #e2e8f0;">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; border-bottom:1.5px solid #f1f5f9; padding-bottom:10px; margin-bottom:16px;">
          <h4 style="margin:0; font-size:16px; font-weight:700; color:#0f172a;">
            <i class="fa fa-graduation-cap text-teal"></i> Complete CV & Professional Qualifications
          </h4>
          <?php if(!empty($employee->cv_file) && file_exists(FCPATH . $employee->cv_file)){ ?>
            <a href="<?= base_url($employee->cv_file); ?>" target="_blank" class="btn btn-success btn-sm" style="border-radius:6px; font-weight:600;">
              <i class="fa fa-download"></i> Download Original CV Document
            </a>
          <?php } ?>
        </div>

        <div class="row">
          <div class="col-md-6" style="margin-bottom:16px;">
            <div style="font-weight:700; color:#334155; font-size:13px; margin-bottom:6px;">
              <i class="fa fa-book text-blue"></i> Educational Qualifications:
            </div>
            <div style="background:#f8fafc; border-radius:8px; padding:12px 14px; border:1px solid #e2e8f0; font-size:13px; line-height:1.6; min-height:80px;">
              <?= (!empty($employee->education_details)) ? nl2br(htmlspecialchars($employee->education_details)) : '<span class="text-muted">No education records provided</span>'; ?>
            </div>
          </div>

          <div class="col-md-6" style="margin-bottom:16px;">
            <div style="font-weight:700; color:#334155; font-size:13px; margin-bottom:6px;">
              <i class="fa fa-briefcase text-orange"></i> Work Experience History:
            </div>
            <div style="background:#f8fafc; border-radius:8px; padding:12px 14px; border:1px solid #e2e8f0; font-size:13px; line-height:1.6; min-height:80px;">
              <?= (!empty($employee->experience_details)) ? nl2br(htmlspecialchars($employee->experience_details)) : '<span class="text-muted">No work experience records provided</span>'; ?>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6" style="margin-bottom:16px;">
            <div style="font-weight:700; color:#334155; font-size:13px; margin-bottom:6px;">
              <i class="fa fa-cogs text-purple"></i> Skills & Expertise:
            </div>
            <div style="background:#f8fafc; border-radius:8px; padding:12px 14px; border:1px solid #e2e8f0; font-size:13px; line-height:1.6; min-height:60px;">
              <?= (!empty($employee->skills)) ? nl2br(htmlspecialchars($employee->skills)) : '<span class="text-muted">No skills listed</span>'; ?>
            </div>
          </div>

          <div class="col-md-6" style="margin-bottom:16px;">
            <div style="font-weight:700; color:#334155; font-size:13px; margin-bottom:6px;">
              <i class="fa fa-info-circle text-gray"></i> Bio Summary & Notes:
            </div>
            <div style="background:#f8fafc; border-radius:8px; padding:12px 14px; border:1px solid #e2e8f0; font-size:13px; line-height:1.6; min-height:60px;">
              <?= (!empty($employee->notes)) ? nl2br(htmlspecialchars($employee->notes)) : '<span class="text-muted">No additional notes</span>'; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
