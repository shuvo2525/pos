<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?= $page_title; ?></title>
<style type="text/css">
  body {
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    font-size: 13px;
    color: #1e293b;
    margin: 0;
    padding: 20px;
    background: #ffffff;
  }
  .slip-box {
    max-width: 760px;
    margin: 0 auto;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 24px;
  }
  .header-table {
    width: 100%;
    border-bottom: 2px solid #0284c7;
    padding-bottom: 12px;
    margin-bottom: 15px;
  }
  .store-title {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 3px;
  }
  .badge-slip {
    display: inline-block;
    background: #0284c7;
    color: #ffffff;
    font-size: 13px;
    font-weight: 700;
    padding: 6px 14px;
    border-radius: 4px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .badge-delivery {
    background: #16a34a !important;
  }
  .section-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 15px;
  }
  .section-table th, .section-table td {
    border: 1px solid #e2e8f0;
    padding: 8px 10px;
    font-size: 12px;
  }
  .section-table th {
    background: #f8fafc;
    font-weight: 700;
    color: #334155;
    text-align: left;
  }
  .highlight-block {
    background: #f8fafc;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    padding: 12px;
    margin-bottom: 15px;
  }
  .signatures {
    margin-top: 45px;
    width: 100%;
  }
  .sig-line {
    border-top: 1px solid #94a3b8;
    width: 200px;
    padding-top: 6px;
    font-size: 12px;
    font-weight: 600;
    text-align: center;
  }
  .terms-box {
    font-size: 10.5px;
    color: #64748b;
    border-top: 1px dashed #cbd5e1;
    padding-top: 10px;
    margin-top: 20px;
    line-height: 1.4;
  }
  .btn-print {
    background: #0284c7;
    color: #fff;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 600;
  }
  @media print {
    .no-print { display: none !important; }
    body { padding: 0; }
    .slip-box { border: none; max-width: 100%; padding: 0; }
  }
</style>
</head>
<body <?= (!isset($is_pdf) || !$is_pdf) ? 'onload="window.print()"' : ''; ?>>

<?php
$CI =& get_instance();
$store = get_store_details();
$logo = (!empty($store->store_logo)) ? base_url($store->store_logo) : '';
$is_delivery = (isset($slip_type) && $slip_type == 'delivery');
?>

<?php if (!isset($is_pdf) || !$is_pdf) { ?>
<div class="no-print" style="max-width: 760px; margin: 0 auto 15px auto; text-align: right;">
  <button class="btn-print" onclick="window.print()">Print Slip</button>
  <a href="<?= base_url('warranty/pdf_slip/' . $claim->id . '/' . ($is_delivery ? 'delivery' : 'receiving')); ?>" target="_blank" style="background:#ef4444; color:#fff; padding:8px 16px; text-decoration:none; border-radius:4px; font-weight:600; margin-left: 8px;">Download PDF</a>
</div>
<?php } ?>

<div class="slip-box">
  <!-- Store & Title Header -->
  <table class="header-table" cellpadding="0" cellspacing="0">
    <tr>
      <td width="60%" valign="top">
        <?php if (!empty($logo)) { ?>
          <img src="<?= $logo; ?>" style="max-height: 48px; max-width: 180px; margin-bottom: 6px;"><br>
        <?php } ?>
        <div class="store-title"><?= html_escape($store->store_name); ?></div>
        <div style="font-size: 11.5px; color: #475569; line-height: 1.4;">
          <?= html_escape($store->address); ?><?= !empty($store->city) ? ', ' . html_escape($store->city) : ''; ?><br>
          Phone: <?= html_escape($store->mobile); ?><?= !empty($store->phone) ? ', ' . html_escape($store->phone) : ''; ?>
          <?= !empty($store->email) ? ' | Email: ' . html_escape($store->email) : ''; ?>
        </div>
      </td>
      <td width="40%" align="right" valign="top">
        <div class="badge-slip <?= $is_delivery ? 'badge-delivery' : ''; ?>">
          <?= $is_delivery ? 'SERVICE DELIVERY SLIP' : 'WARRANTY RECEIVING SLIP'; ?>
        </div>
        <div style="margin-top: 10px; font-size: 12.5px;">
          <strong>Job / Claim No:</strong> <span style="color:#0284c7; font-weight:800; font-size:14px;"><?= $claim->warranty_code; ?></span><br>
          <strong>Intake Date:</strong> <?= show_date($claim->claim_date); ?><br>
          <?php if ($is_delivery) { ?>
            <strong>Delivery Date:</strong> <?= !empty($claim->delivery_date) ? show_date($claim->delivery_date) : date('d-m-Y'); ?><br>
          <?php } else { ?>
            <strong>Expected Delivery:</strong> <?= !empty($claim->expected_delivery_date) ? show_date($claim->expected_delivery_date) : '-'; ?><br>
          <?php } ?>
          <strong>Received By:</strong> <?= html_escape($claim->created_by); ?>
        </div>
      </td>
    </tr>
  </table>

  <!-- Customer & Product Information Table -->
  <table class="section-table">
    <tr>
      <th width="50%">Customer Details</th>
      <th width="50%">Product & Warranty Details</th>
    </tr>
    <tr>
      <td valign="top">
        <strong style="font-size: 14px; color: #0f172a;"><?= html_escape($claim->customer_name); ?></strong><br>
        Mobile: <strong><?= html_escape($claim->customer_mobile); ?></strong><br>
        <?php if(!empty($claim->customer_email)) { ?>
          Email: <?= html_escape($claim->customer_email); ?><br>
        <?php } ?>
        Address: <?= html_escape($claim->customer_address); ?>
      </td>
      <td valign="top">
        <strong>Product:</strong> <?= html_escape($claim->item_name); ?><br>
        <strong>Serial / IMEI:</strong> <?= !empty($claim->serial_no) ? html_escape($claim->serial_no) : '-'; ?><br>
        <strong>Invoice No:</strong> <?= !empty($claim->sales_code) ? html_escape($claim->sales_code) : '-'; ?><br>
        <strong>Purchase Date:</strong> <?= !empty($claim->purchase_date) ? show_date($claim->purchase_date) : '-'; ?><br>
        <strong>Warranty Expiry:</strong> <?= !empty($claim->warranty_expiry_date) ? show_date($claim->warranty_expiry_date) : '-'; ?>
      </td>
    </tr>
  </table>

  <!-- Problem Description & Accessories -->
  <div class="highlight-block">
    <div style="font-weight: 700; color: #b91c1c; text-transform: uppercase; font-size: 11px; margin-bottom: 4px;">
      Customer Reported Problem / Fault Description:
    </div>
    <div style="font-size: 13px; color: #0f172a; font-weight: 500; margin-bottom: 8px;">
      <?= nl2br(html_escape($claim->problem_description)); ?>
    </div>
    <div style="font-size: 12px; color: #475569;">
      <strong>Accessories Kept:</strong> <?= !empty($claim->accessories_received) ? html_escape($claim->accessories_received) : 'None'; ?> &nbsp;|&nbsp;
      <strong>Intake Physical Condition:</strong> <?= !empty($claim->product_condition) ? html_escape($claim->product_condition) : 'Good condition'; ?>
    </div>
  </div>

  <?php if ($is_delivery || !empty($claim->action_taken) || $claim->total_charge > 0) { ?>
  <!-- Delivery & Work Done Details -->
  <table class="section-table">
    <tr>
      <th colspan="2">Service & Repair Report</th>
    </tr>
    <tr>
      <td width="65%" valign="top">
        <strong>Technical Action Taken:</strong><br>
        <?= !empty($claim->action_taken) ? nl2br(html_escape($claim->action_taken)) : 'Product serviced and verified.'; ?>
      </td>
      <td width="35%" valign="top">
        <table width="100%" style="font-size: 12px;">
          <tr>
            <td>Service Charge:</td>
            <td align="right">Tk <?= store_number_format($claim->service_charge); ?></td>
          </tr>
          <tr>
            <td>Parts Charge:</td>
            <td align="right">Tk <?= store_number_format($claim->parts_charge); ?></td>
          </tr>
          <tr style="border-top: 1px solid #cbd5e1; font-weight: bold; font-size: 13px;">
            <td>Total Charge:</td>
            <td align="right" style="color: #15803d;">Tk <?= store_number_format($claim->total_charge); ?></td>
          </tr>
          <?php if (!empty($claim->payment_type)) { ?>
          <tr>
            <td>Payment Mode:</td>
            <td align="right"><?= html_escape($claim->payment_type); ?></td>
          </tr>
          <?php } ?>
        </table>
      </td>
    </tr>
  </table>
  <?php } ?>

  <!-- Terms & Conditions -->
  <div class="terms-box">
    <strong>Terms & Conditions:</strong><br>
    1. This receipt slip must be produced at the time of collecting the repaired/serviced product.<br>
    2. The shop is not responsible for any data loss during repair/service. Customers are advised to backup data.<br>
    3. Products must be collected within 30 days of notification. The shop is not responsible for unclaimed products thereafter.<br>
    4. Physical and liquid damages are excluded from standard free warranty.
  </div>

  <!-- Signatures -->
  <table class="signatures" cellpadding="0" cellspacing="0">
    <tr>
      <td width="50%" align="left">
        <div class="sig-line">Customer Signature</div>
      </td>
      <td width="50%" align="right">
        <div class="sig-line" style="margin-left: auto;">Authorized Signature & Seal</div>
      </td>
    </tr>
  </table>

</div>

</body>
</html>
