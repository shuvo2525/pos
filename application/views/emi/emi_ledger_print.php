<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?= $page_title; ?></title>
<style type="text/css">
  body {
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    font-size: 12px;
    color: #1e293b;
    margin: 0;
    padding: 20px;
    background: #ffffff;
  }
  .statement-box {
    max-width: 800px;
    margin: 0 auto;
    border: 1px solid #e2e8f0;
    padding: 20px;
  }
  .header-table {
    width: 100%;
    border-bottom: 2px solid #3b82f6;
    padding-bottom: 12px;
    margin-bottom: 12px;
  }
  .store-title {
    font-size: 20px;
    font-weight: 800;
    color: #0f172a;
  }
  .badge-title {
    background: #3b82f6;
    color: #ffffff;
    font-size: 13px;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 4px;
    display: inline-block;
  }
  .kpi-row {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 15px;
  }
  .kpi-row td {
    border: 1px solid #cbd5e1;
    padding: 8px 10px;
    text-align: center;
    background: #f8fafc;
  }
  .kpi-row .val {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
  }
  .kpi-row .lbl {
    font-size: 10px;
    color: #64748b;
    text-transform: uppercase;
  }
  .table-data {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 15px;
  }
  .table-data th, .table-data td {
    border: 1px solid #e2e8f0;
    padding: 6px 8px;
  }
  .table-data th {
    background: #f1f5f9;
    font-weight: 700;
  }
  .signatures {
    margin-top: 40px;
    width: 100%;
  }
  .sig-line {
    border-top: 1px solid #94a3b8;
    width: 180px;
    padding-top: 4px;
    font-size: 11px;
    font-weight: 600;
    text-align: center;
  }
  @media print {
    .no-print { display: none !important; }
    body { padding: 0; }
    .statement-box { border: none; max-width: 100%; padding: 0; }
  }
</style>
</head>
<body <?= (!isset($is_pdf) || !$is_pdf) ? 'onload="window.print()"' : ''; ?>>

<?php
$CI =& get_instance();
$store = get_store_details();
$logo = (!empty($store->store_logo)) ? base_url($store->store_logo) : '';
?>

<?php if (!isset($is_pdf) || !$is_pdf) { ?>
<div class="no-print" style="max-width: 800px; margin: 0 auto 15px auto; text-align: right;">
  <button onclick="window.print()" style="background:#3b82f6; color:#fff; padding:6px 14px; border:none; border-radius:4px; cursor:pointer; font-weight:600;">Print Statement</button>
  <a href="<?= base_url('emi/pdf_ledger/' . $emi->id); ?>" target="_blank" style="background:#ef4444; color:#fff; padding:6px 14px; text-decoration:none; border-radius:4px; font-weight:600; margin-left: 8px;">Download PDF</a>
</div>
<?php } ?>

<div class="statement-box">
  <table class="header-table" cellpadding="0" cellspacing="0">
    <tr>
      <td width="65%" valign="top">
        <div class="store-title"><?= html_escape($store->store_name); ?></div>
        <div style="font-size: 11px; color: #475569; line-height: 1.4;">
          <?= html_escape($store->address); ?><?= !empty($store->city) ? ', ' . html_escape($store->city) : ''; ?><br>
          Phone: <?= html_escape($store->mobile); ?> | Email: <?= html_escape($store->email); ?>
        </div>
      </td>
      <td width="35%" align="right" valign="top">
        <div class="badge-title">CUSTOMER INSTALLMENT BOOK</div>
        <div style="margin-top: 8px; font-size: 11px;">
          <strong>Plan Code:</strong> <?= $emi->emi_code; ?><br>
          <strong>Date Generated:</strong> <?= date('d-m-Y'); ?>
        </div>
      </td>
    </tr>
  </table>

  <!-- Customer & Plan details -->
  <table width="100%" style="margin-bottom: 12px; font-size: 12px;">
    <tr>
      <td width="55%" valign="top">
        <strong>Customer:</strong> <?= html_escape($emi->customer_name); ?><br>
        <strong>Mobile:</strong> <?= html_escape($emi->customer_mobile); ?><br>
        <strong>Address:</strong> <?= html_escape($emi->customer_address); ?>
      </td>
      <td width="45%" valign="top">
        <strong>Product:</strong> <?= html_escape($emi->item_details); ?><br>
        <strong>Frequency:</strong> <?= $emi->emi_frequency; ?> (<?= $emi->total_installments; ?> Installments)<br>
        <strong>Status:</strong> <?= ($emi->due_amount <= 0) ? '<span style="color:#15803d; font-weight:bold;">Completed</span>' : '<span style="color:#b45309; font-weight:bold;">Active</span>'; ?>
      </td>
    </tr>
  </table>

  <!-- Financial KPI summary -->
  <table class="kpi-row" cellpadding="0" cellspacing="0">
    <tr>
      <td>
        <div class="lbl">Total Price</div>
        <div class="val">Tk <?= store_number_format($emi->total_amount); ?></div>
      </td>
      <td>
        <div class="lbl">Down Payment</div>
        <div class="val">Tk <?= store_number_format($emi->down_payment); ?></div>
      </td>
      <td>
        <div class="lbl">Total Payable</div>
        <div class="val">Tk <?= store_number_format($emi->total_payable); ?></div>
      </td>
      <td>
        <div class="lbl">Total Paid</div>
        <div class="val" style="color: #15803d;">Tk <?= store_number_format($emi->paid_amount); ?></div>
      </td>
      <td>
        <div class="lbl">Balance Due</div>
        <div class="val" style="color: #b91c1c;">Tk <?= store_number_format($emi->due_amount); ?></div>
      </td>
    </tr>
  </table>

  <!-- Schedule Table -->
  <div style="font-weight: 700; margin-bottom: 4px; font-size: 12px;">Installment Schedule & Status</div>
  <table class="table-data" cellpadding="0" cellspacing="0">
    <thead>
      <tr>
        <th width="5%" align="center">#</th>
        <th width="15%">Due Date</th>
        <th width="15%">Due Amount</th>
        <th width="15%">Paid Amount</th>
        <th width="15%">Paid Date</th>
        <th width="15%">Method</th>
        <th width="20%">Status</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($installments as $inst) { ?>
      <tr>
        <td align="center"><strong><?= $inst->installment_no; ?></strong></td>
        <td><?= show_date($inst->due_date); ?></td>
        <td>Tk <?= store_number_format($inst->amount); ?></td>
        <td style="color:#15803d; font-weight:bold;">Tk <?= store_number_format($inst->paid_amount); ?></td>
        <td><?= !empty($inst->payment_date) ? show_date($inst->payment_date) : '-'; ?></td>
        <td><?= !empty($inst->payment_type) ? html_escape($inst->payment_type) : '-'; ?></td>
        <td>
          <?php if($inst->status == 'Paid') { ?>
            <span style="color:#15803d; font-weight:bold;">Paid</span>
          <?php } else if($inst->status == 'Partial') { ?>
            <span style="color:#b45309; font-weight:bold;">Partial</span>
          <?php } else { ?>
            <span style="color:#64748b;">Pending</span>
          <?php } ?>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>

  <!-- Signatures -->
  <table class="signatures" cellpadding="0" cellspacing="0">
    <tr>
      <td width="50%" align="left">
        <div class="sig-line">Customer Signature</div>
      </td>
      <td width="50%" align="right">
        <div class="sig-line" style="margin-left: auto;">Authorized Signature</div>
      </td>
    </tr>
  </table>
</div>

</body>
</html>
