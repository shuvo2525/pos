<!DOCTYPE html>
<html>
<head>
  <!-- TABLES CSS CODE -->
  <?php $this->load->view('comman/code_css.php'); ?>
  <link rel="stylesheet" href="<?php echo $theme_link; ?>plugins/datepicker/datepicker3.css">
  <style type="text/css">
    .emp-card {
      background: #ffffff;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.06);
      border: 1px solid #e2e8f0;
      margin-bottom: 24px;
      overflow: hidden;
    }
    .emp-card-header {
      background: linear-gradient(135deg, #f8fafc, #edf2f7);
      padding: 14px 20px;
      border-bottom: 1px solid #e2e8f0;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .emp-card-header h4 {
      margin: 0;
      font-size: 15px;
      font-weight: 700;
      color: #1e293b;
    }
    .emp-card-header .emp-header-icon {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      background: #00c0ef;
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 15px;
    }
    .emp-card-body {
      padding: 22px 20px;
    }
    .form-group label {
      font-weight: 600;
      color: #334155;
      font-size: 13px;
      margin-bottom: 6px;
    }
    .form-control {
      border-radius: 6px;
      border: 1px solid #cbd5e1;
      box-shadow: none;
      height: 38px;
    }
    .form-control:focus {
      border-color: #00c0ef;
      box-shadow: 0 0 0 3px rgba(0, 192, 239, 0.15);
    }
    textarea.form-control {
      height: auto;
    }
    .photo-preview-wrap {
      width: 130px;
      height: 130px;
      border-radius: 50%;
      border: 3px solid #00c0ef;
      overflow: hidden;
      margin: 0 auto 12px;
      position: relative;
      background: #f1f5f9;
      box-shadow: 0 4px 14px rgba(0,0,0,0.1);
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .photo-preview-wrap img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .btn-emp-save {
      background: linear-gradient(135deg, #00c0ef, #0097bc);
      color: #fff;
      font-weight: 700;
      padding: 10px 30px;
      border-radius: 8px;
      border: none;
      box-shadow: 0 4px 12px rgba(0, 192, 239, 0.35);
      transition: all 0.2s;
    }
    .btn-emp-save:hover {
      background: linear-gradient(135deg, #00b0dc, #0081a1);
      color: #fff;
      transform: translateY(-1px);
    }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php $this->load->view('sidebar'); ?>

  <?php
    $emp_first_name = (isset($employee->first_name)) ? $employee->first_name : '';
    $emp_last_name = (isset($employee->last_name)) ? $employee->last_name : '';
    $emp_code = (isset($employee->employee_code)) ? $employee->employee_code : $employee_code;
    $emp_email = (isset($employee->email)) ? $employee->email : '';
    $emp_mobile = (isset($employee->mobile)) ? $employee->mobile : '';
    $emp_phone = (isset($employee->phone)) ? $employee->phone : '';
    $emp_designation = (isset($employee->designation)) ? $employee->designation : '';
    $emp_department = (isset($employee->department)) ? $employee->department : '';
    $emp_dob = (isset($employee->dob) && $employee->dob != '1970-01-01' && !empty($employee->dob)) ? date('d-m-Y', strtotime($employee->dob)) : '';
    $emp_gender = (isset($employee->gender)) ? $employee->gender : 'Male';
    $emp_marital = (isset($employee->marital_status)) ? $employee->marital_status : 'Single';
    $emp_blood = (isset($employee->blood_group)) ? $employee->blood_group : '';
    $emp_joining = (isset($employee->joining_date) && $employee->joining_date != '1970-01-01' && !empty($employee->joining_date)) ? date('d-m-Y', strtotime($employee->joining_date)) : date('d-m-Y');
    $emp_salary = (isset($employee->monthly_salary)) ? $employee->monthly_salary : '';
    $emp_nid = (isset($employee->nid_number)) ? $employee->nid_number : '';
    $emp_present_addr = (isset($employee->present_address)) ? $employee->present_address : '';
    $emp_perm_addr = (isset($employee->permanent_address)) ? $employee->permanent_address : '';
    $emp_emg_name = (isset($employee->emergency_contact_name)) ? $employee->emergency_contact_name : '';
    $emp_emg_rel = (isset($employee->emergency_contact_relation)) ? $employee->emergency_contact_relation : '';
    $emp_emg_mob = (isset($employee->emergency_contact_mobile)) ? $employee->emergency_contact_mobile : '';
    $emp_bank_name = (isset($employee->bank_name)) ? $employee->bank_name : '';
    $emp_bank_holder = (isset($employee->bank_account_holder)) ? $employee->bank_account_holder : '';
    $emp_bank_acc = (isset($employee->bank_account_number)) ? $employee->bank_account_number : '';
    $emp_bank_branch = (isset($employee->bank_branch)) ? $employee->bank_branch : '';
    $emp_bank_route = (isset($employee->bank_routing_code)) ? $employee->bank_routing_code : '';
    $emp_edu = (isset($employee->education_details)) ? $employee->education_details : '';
    $emp_exp = (isset($employee->experience_details)) ? $employee->experience_details : '';
    $emp_skills = (isset($employee->skills)) ? $employee->skills : '';
    $emp_notes = (isset($employee->notes)) ? $employee->notes : '';
    $emp_status = (isset($employee->status)) ? $employee->status : 1;
    $emp_photo = (isset($employee->photo)) ? $employee->photo : '';
    $emp_nid_photo = (isset($employee->nid_photo)) ? $employee->nid_photo : '';
    $emp_cv_file = (isset($employee->cv_file)) ? $employee->cv_file : '';
  ?>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <?= $page_title; ?>
        <small>Human Resource Management</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $base_url; ?>employee">HR / Employees</a></li>
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

      <form id="employee-form" enctype="multipart/form-data" method="post">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="q_id" id="q_id" value="<?= $q_id; ?>">
        <input type="hidden" id="base_url" value="<?= $base_url; ?>">

        <div class="row">
          <!-- Left Column (Photo & Basic Info) -->
          <div class="col-md-4">
            <!-- Profile Photo Card -->
            <div class="emp-card text-center">
              <div class="emp-card-header">
                <div class="emp-header-icon"><i class="fa fa-camera"></i></div>
                <h4>Profile Photo</h4>
              </div>
              <div class="emp-card-body">
                <div class="photo-preview-wrap">
                  <?php if(!empty($emp_photo) && file_exists(FCPATH . $emp_photo)){ ?>
                    <img id="photo_preview" src="<?= base_url($emp_photo); ?>" alt="Employee Photo">
                  <?php } else { ?>
                    <img id="photo_preview" src="<?= $theme_link; ?>images/no_image.png" alt="No Photo" style="opacity:0.4;">
                  <?php } ?>
                </div>
                <div class="form-group" style="margin-bottom:0;">
                  <label class="btn btn-default btn-sm btn-block" style="border-radius:6px; font-weight:600; cursor:pointer;">
                    <i class="fa fa-upload"></i> Choose Profile Picture
                    <input type="file" name="photo" id="photo" accept="image/*" style="display:none;" onchange="previewPhoto(this)">
                  </label>
                  <small class="text-muted" style="font-size:11px;">Supported: JPG, PNG, WEBP (Max 5MB)</small>
                </div>
              </div>
            </div>

            <!-- Employment Key Info Card -->
            <div class="emp-card">
              <div class="emp-card-header">
                <div class="emp-header-icon"><i class="fa fa-briefcase"></i></div>
                <h4>Job & Official Info</h4>
              </div>
              <div class="emp-card-body">
                <div class="form-group">
                  <label for="employee_code">Employee ID / Code <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                    <input type="text" class="form-control" name="employee_code" id="employee_code" value="<?= $emp_code; ?>" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="designation">Designation / Role</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-black-tie"></i></span>
                    <input type="text" class="form-control" name="designation" id="designation" placeholder="e.g. Sales Executive, Cashier, Manager" value="<?= $emp_designation; ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="department">Department</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                    <input type="text" class="form-control" name="department" id="department" placeholder="e.g. Sales, Accounts, Store Management" value="<?= $emp_department; ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="joining_date">Joining Date</label>
                  <div class="input-group date">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" class="form-control datepicker" name="joining_date" id="joining_date" value="<?= $emp_joining; ?>" placeholder="DD-MM-YYYY">
                  </div>
                </div>

                <div class="form-group">
                  <label for="monthly_salary">Monthly Salary (<?= $this->session->userdata('currency'); ?>)</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-money"></i></span>
                    <input type="number" step="any" class="form-control" name="monthly_salary" id="monthly_salary" placeholder="0.00" value="<?= $emp_salary; ?>">
                  </div>
                </div>

                <div class="form-group" style="margin-bottom:0;">
                  <label for="status">Employee Status</label>
                  <select class="form-control" name="status" id="status">
                    <option value="1" <?= ($emp_status == 1) ? 'selected' : ''; ?>>Active</option>
                    <option value="0" <?= ($emp_status == 0) ? 'selected' : ''; ?>>Inactive</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <!-- Right Column (Personal, Address, Bank, CV, NID) -->
          <div class="col-md-8">
            <!-- 1. Personal Information Card -->
            <div class="emp-card">
              <div class="emp-card-header">
                <div class="emp-header-icon"><i class="fa fa-user"></i></div>
                <h4>Personal Details</h4>
              </div>
              <div class="emp-card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="first_name">First Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" value="<?= $emp_first_name; ?>" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="last_name">Last Name</label>
                      <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" value="<?= $emp_last_name; ?>">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="mobile">Mobile Number <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                        <input type="text" class="form-control" name="mobile" id="mobile" placeholder="01XXXXXXXXX" value="<?= $emp_mobile; ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Email Address</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="email" class="form-control" name="email" id="email" placeholder="employee@example.com" value="<?= $emp_email; ?>">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="dob">Date of Birth</label>
                      <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-birthday-cake"></i></span>
                        <input type="text" class="form-control datepicker" name="dob" id="dob" value="<?= $emp_dob; ?>" placeholder="DD-MM-YYYY">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="gender">Gender</label>
                      <select class="form-control" name="gender" id="gender">
                        <option value="Male" <?= ($emp_gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?= ($emp_gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                        <option value="Other" <?= ($emp_gender == 'Other') ? 'selected' : ''; ?>>Other</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="blood_group">Blood Group</label>
                      <select class="form-control" name="blood_group" id="blood_group">
                        <option value="">Select Blood Group</option>
                        <?php 
                          $blood_groups = array('A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-');
                          foreach($blood_groups as $bg){
                            $selected = ($emp_blood == $bg) ? 'selected' : '';
                            echo "<option value='$bg' $selected>$bg</option>";
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group" style="margin-bottom:0;">
                      <label for="marital_status">Marital Status</label>
                      <select class="form-control" name="marital_status" id="marital_status">
                        <option value="Single" <?= ($emp_marital == 'Single') ? 'selected' : ''; ?>>Single</option>
                        <option value="Married" <?= ($emp_marital == 'Married') ? 'selected' : ''; ?>>Married</option>
                        <option value="Divorced" <?= ($emp_marital == 'Divorced') ? 'selected' : ''; ?>>Divorced</option>
                        <option value="Other" <?= ($emp_marital == 'Other') ? 'selected' : ''; ?>>Other</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group" style="margin-bottom:0;">
                      <label for="phone">Alternative Phone / Landline</label>
                      <input type="text" class="form-control" name="phone" id="phone" placeholder="Optional phone" value="<?= $emp_phone; ?>">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- 2. Present & Permanent Address Card -->
            <div class="emp-card">
              <div class="emp-card-header">
                <div class="emp-header-icon"><i class="fa fa-map-marker"></i></div>
                <h4>Address Information</h4>
              </div>
              <div class="emp-card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="present_address">Present Address</label>
                      <textarea class="form-control" rows="5" style="min-height: 110px; resize: vertical;" name="present_address" id="present_address" placeholder="House, Road, Area, Postcode, District"><?= $emp_present_address; ?></textarea>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <div style="display:flex; justify-content:space-between; align-items:center;">
                        <label for="permanent_address">Permanent Address</label>
                        <label style="font-size:12px; font-weight:normal; cursor:pointer; color:#00c0ef;">
                          <input type="checkbox" id="same_as_present" onchange="copyAddress(this)"> Same as Present
                        </label>
                      </div>
                      <textarea class="form-control" rows="5" style="min-height: 110px; resize: vertical;" name="permanent_address" id="permanent_address" placeholder="Village/House, Post, Thana, District"><?= $emp_permanent_address; ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- 3. Emergency Contact Card -->
            <div class="emp-card">
              <div class="emp-card-header">
                <div class="emp-header-icon"><i class="fa fa-phone-square"></i></div>
                <h4>Emergency Contact</h4>
              </div>
              <div class="emp-card-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="emergency_contact_name">Contact Person Name</label>
                      <input type="text" class="form-control" name="emergency_contact_name" id="emergency_contact_name" placeholder="Name" value="<?= $emp_emg_name; ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="emergency_contact_relation">Relationship</label>
                      <input type="text" class="form-control" name="emergency_contact_relation" id="emergency_contact_relation" placeholder="e.g. Father, Spouse, Brother" value="<?= $emp_emg_rel; ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="emergency_contact_mobile">Emergency Mobile</label>
                      <input type="text" class="form-control" name="emergency_contact_mobile" id="emergency_contact_mobile" placeholder="01XXXXXXXXX" value="<?= $emp_emg_mob; ?>">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- 4. Bank Account Details Card -->
            <div class="emp-card">
              <div class="emp-card-header">
                <div class="emp-header-icon"><i class="fa fa-university"></i></div>
                <h4>Bank Account Details</h4>
              </div>
              <div class="emp-card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="bank_name">Bank Name</label>
                      <input type="text" class="form-control" name="bank_name" id="bank_name" placeholder="e.g. Dutch-Bangla Bank, BRAC Bank, etc." value="<?= $emp_bank_name; ?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="bank_account_holder">Account Holder Name</label>
                      <input type="text" class="form-control" name="bank_account_holder" id="bank_account_holder" placeholder="Name as in bank book" value="<?= $emp_bank_holder; ?>">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="bank_account_number">Account Number</label>
                      <input type="text" class="form-control" name="bank_account_number" id="bank_account_number" placeholder="Account Number" value="<?= $emp_bank_acc; ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="bank_branch">Branch Name</label>
                      <input type="text" class="form-control" name="bank_branch" id="bank_branch" placeholder="Branch Name" value="<?= $emp_bank_branch; ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="bank_routing_code">Routing / Swift Code</label>
                      <input type="text" class="form-control" name="bank_routing_code" id="bank_routing_code" placeholder="Optional Routing Code" value="<?= $emp_bank_route; ?>">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- 5. National ID (NID) Card -->
            <div class="emp-card">
              <div class="emp-card-header">
                <div class="emp-header-icon"><i class="fa fa-id-card"></i></div>
                <h4>National ID (NID) Information</h4>
              </div>
              <div class="emp-card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nid_number">National ID (NID) Number</label>
                      <input type="text" class="form-control" name="nid_number" id="nid_number" placeholder="10 or 17 digit NID number" value="<?= $emp_nid; ?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nid_photo">NID Card Photo / Document</label>
                      <input type="file" class="form-control" name="nid_photo" id="nid_photo" accept="image/*,application/pdf">
                      <?php if(!empty($emp_nid_photo) && file_exists(FCPATH . $emp_nid_photo)){ ?>
                        <div style="margin-top:6px;">
                          <a href="<?= base_url($emp_nid_photo); ?>" target="_blank" class="btn btn-xs btn-info" style="border-radius:4px;">
                            <i class="fa fa-eye"></i> View Current NID Document
                          </a>
                        </div>
                      <?php } ?>
                      <small class="text-muted" style="font-size:11px;">Image or PDF (Max 10MB)</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- 6. Complete CV & Qualifications Card -->
            <div class="emp-card">
              <div class="emp-card-header">
                <div class="emp-header-icon"><i class="fa fa-file-text-o"></i></div>
                <h4>Complete CV & Qualification Details</h4>
              </div>
              <div class="emp-card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="cv_file">Upload CV / Resume File</label>
                      <input type="file" class="form-control" name="cv_file" id="cv_file" accept=".pdf,.doc,.docx,image/*">
                      <?php if(!empty($emp_cv_file) && file_exists(FCPATH . $emp_cv_file)){ ?>
                        <div style="margin-top:6px;">
                          <a href="<?= base_url($emp_cv_file); ?>" target="_blank" class="btn btn-xs btn-primary" style="border-radius:4px;">
                            <i class="fa fa-download"></i> View / Download Current CV File
                          </a>
                        </div>
                      <?php } ?>
                      <small class="text-muted" style="font-size:11px;">PDF, DOC, DOCX or Image file (Max 20MB)</small>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="education_details">Educational Qualifications</label>
                      <textarea class="form-control" rows="6" style="min-height: 140px; resize: vertical;" name="education_details" id="education_details" placeholder="e.g.&#10;• BBA in Marketing - University of Dhaka (2020)&#10;• HSC - Dhaka College (2016)"><?= $emp_edu; ?></textarea>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="experience_details">Work Experience History</label>
                      <textarea class="form-control" rows="6" style="min-height: 140px; resize: vertical;" name="experience_details" id="experience_details" placeholder="e.g.&#10;• Senior Salesman - ABC Super Shop (2 Years)&#10;• Cashier - XYZ Mart (1 Year)"><?= $emp_exp; ?></textarea>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="skills">Skills & Expertise</label>
                      <textarea class="form-control" rows="5" style="min-height: 120px; resize: vertical;" name="skills" id="skills" placeholder="e.g. POS Operation, Inventory Management, Customer Service, Cash Handling"><?= $emp_skills; ?></textarea>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="notes">Bio Summary / Additional Notes</label>
                      <textarea class="form-control" rows="5" style="min-height: 120px; resize: vertical;" name="notes" id="notes" placeholder="Any additional notes or background summary..."><?= $emp_notes; ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Submit Buttons Card -->
            <div class="emp-card" style="padding:18px 24px;">
              <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                <a href="<?= base_url('employee'); ?>" class="btn btn-default" style="font-weight:600; border-radius:8px; padding:10px 22px;">
                  <i class="fa fa-arrow-left"></i> Back to Employee List
                </a>
                <button type="submit" class="btn btn-emp-save" id="btn_save_emp">
                  <i class="fa fa-check-circle"></i> <?= (!empty($q_id)) ? 'Update Employee Information' : 'Save Employee'; ?>
                </button>
              </div>
            </div>

          </div>
        </div>
      </form>
    </section>
  </div>

  <?php $this->load->view('footer'); ?>
</div>

<!-- TABLES CODE -->
<?php $this->load->view('comman/code_js.php'); ?>
<script src="<?php echo $theme_link; ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('.datepicker').datepicker({
      autoclose: true,
      format: 'dd-mm-yyyy',
      todayHighlight: true
    });

    // Make sidebar menu active
    $(".employee-active-li").addClass("active");

    // Form Submission via AJAX
    $("#employee-form").on('submit', function(e) {
      e.preventDefault();
      var btn = $("#btn_save_emp");
      var original_text = btn.html();
      btn.html('<i class="fa fa-spinner fa-spin"></i> Saving...').prop('disabled', true);

      var formData = new FormData(this);

      $.ajax({
        url: '<?= base_url("employee/save_or_update"); ?>',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(res) {
          btn.html(original_text).prop('disabled', false);
          if (res.status === 'success') {
            toastr["success"](res.msg);
            setTimeout(function() {
              window.location.href = '<?= base_url("employee"); ?>';
            }, 1200);
          } else {
            toastr["error"](res.msg);
          }
        },
        error: function(xhr, status, err) {
          btn.html(original_text).prop('disabled', false);
          toastr["error"]("An unexpected error occurred. Please try again.");
        }
      });
    });
  });

  function previewPhoto(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#photo_preview').attr('src', e.target.result).css('opacity', '1');
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  function copyAddress(checkbox) {
    if (checkbox.checked) {
      $('#permanent_address').val($('#present_address').val());
    }
  }
</script>
</body>
</html>
