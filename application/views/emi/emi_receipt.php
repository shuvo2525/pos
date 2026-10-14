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
  .receipt-box {
    max-width: 720px;
    margin: 0 auto;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 24px;
  }
  .header-table {
    width: 100%;
    border-bottom: 2px solid #3b82f6;
    padding-bottom: 15px;
    margin-bottom: 15px;
  }
  .store-title {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 4px;
  }
  .receipt-badge {
    display: inline-block;
    background: #3b82f6;
    color: #ffffff;
    font-size: 14px;
    font-weight: 700;
    padding: 6px 14px;
    border-radius: 4px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .info-table {
    width: 100%;
    margin-bottom: 15px;
  }
  .info-table td {
    padding: 4px 6px;
    vertical-align: top;
  }
  .payment-box {
    background: #f8fafc;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    padding: 14px;
    margin-bottom: 15px;
  }
  .amount-highlight {
    font-size: 24px;
    font-weight: 800;
    color: #15803d;
  }
  .summary-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
  }
  .summary-table th, .summary-table td {
    border: 1px solid #e2e8f0;
    padding: 8px 10px;
  }
  .summary-table th {
    background: #f1f5f9;
    font-weight: 700;
    text-align: left;
  }
  .signatures {
    margin-top: 50px;
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
  .btn-print {
    background: #3b82f6;
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
    .receipt-box { border: none; max-width: 100%; padding: 0; }
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
<div class="no-print" style="max-width: 720px; margin: 0 auto 15px auto; text-align: right;">
  <button class="btn-print" onclick="window.print()">Print Receipt</button>
  <a href="<?= base_url('emi/pdf_receipt/' . $receipt->id); ?>" target="_blank" style="background:#ef4444; color:#fff; padding:8px 16px; text-decoration:none; border-radius:4px; font-weight:600; margin-left: 8px;">Download PDF</a>
</div>
<?php } ?>

<div class="receipt-box">
  <!-- Store & Receipt Header -->
  <table class="header-table" cellpadding="0" cellspacing="0">
    <tr>
      <td width="60%" valign="top">
        <?php if (!empty($logo)) { ?>
          <img src="<?= $logo; ?>" style="max-height: 48px; max-width: 180px; margin-bottom: 6px;"><br>
        <?php } ?>
        <div class="store-title"><?= html_escape($store->store_name); ?></div>
        <div style="font-size: 12px; color: #475569; line-height: 1.4;">
          <?= html_escape($store->address); ?><?= !empty($store->city) ? ', ' . html_escape($store->city) : ''; ?><br>
          Phone: <?= html_escape($store->mobile); ?><?= !empty($store->phone) ? ', ' . html_escape($store->phone) : ''; ?>
          <?= !empty($store->email) ? ' | Email: ' . html_escape($store->email) : ''; ?><br>
          <?= (!empty($store->vat_no) && vat_number()) ? 'VAT Reg: ' . html_escape($store->vat_no) : ''; ?>
        </div>
      </td>
      <td width="40%" align="right" valign="top">
        <div class="receipt-badge">MONEY RECEIPT</div>
        <div style="margin-top: 10px; font-size: 13px;">
          <strong>Receipt No:</strong> <span style="color:#3b82f6; font-weight:800;"><?= $receipt->receipt_no; ?></span><br>
          <strong>Date:</strong> <?= show_date($receipt->payment_date); ?><br>
          <strong>Time:</strong> <?= $receipt->created_time; ?><br>
          <strong>Issued By:</strong> <?= html_escape($receipt->created_by); ?>
        </div>
      </td>
    </tr>
  </table>

  <!-- Customer & Plan Info -->
  <table class="info-table" cellpadding="0" cellspacing="0">
    <tr>
      <td width="55%" style="border-right: 1px dashed #cbd5e1;">
        <strong style="color: #3b82f6; text-transform: uppercase; font-size: 11px;">Customer Information</strong><br>
        <strong style="font-size: 15px;"><?= html_escape($receipt->customer_name); ?></strong><br>
        Mobile: <?= html_escape($receipt->customer_mobile); ?><br>
        Address: <?= html_escape($receipt->customer_address); ?><?= !empty($receipt->customer_city) ? ', ' . html_escape($receipt->customer_city) : ''; ?>
      </td>
      <td width="45%" style="padding-left: 15px;">
        <strong style="color: #3b82f6; text-transform: uppercase; font-size: 11px;">EMI Plan Details</strong><br>
        <strong>Plan ID:</strong> <?= $receipt->emi_code; ?><br>
        <strong>Product:</strong> <?= html_escape($receipt->item_details); ?><br>
        <strong>Installments:</strong> <?= $receipt->total_installments; ?> (<?= $receipt->emi_frequency; ?>)
      </td>
    </tr>
  </table>

  <!-- Payment Details Box -->
  <div class="payment-box">
    <table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td>
          <div style="font-size: 12px; color: #475569; font-weight: 600;">
            <?php if ($receipt->installment_id == 0) { ?>
              PAYMENT PURPOSE: <strong style="color: #0f172a;">DOWN PAYMENT</strong>
            <?php } else { ?>
              PAYMENT PURPOSE: <strong style="color: #0f172a;">INSTALLMENT #<?= $receipt->installment_no; ?> (DUE: <?= show_date($receipt->due_date); ?>)</strong>
            <?php } ?>
          </div>
          <div style="font-size: 13px; margin-top: 4px;">
            Payment Method: <strong><?= html_escape($receipt->payment_type); ?></strong>
            <?php if (!empty($receipt->payment_note)) { ?>
              &nbsp;|&nbsp; Ref / Note: <em><?= html_escape($receipt->payment_note); ?></em>
            <?php } ?>
          </div>
        </td>
        <td align="right" valign="middle">
          <div style="font-size: 12px; color: #64748b;">AMOUNT RECEIVED</div>
          <div class="amount-highlight">Tk <?= store_number_format($receipt->payment_amount); ?></div>
        </td>
      </tr>
    </table>
    <div style="margin-top: 8px; font-size: 12px; font-style: italic; color: #334155;">
      In Words: <strong><?= ucwords(no_to_words($receipt->payment_amount)); ?> Taka Only</strong>
    </div>
  </div>

  <!-- Plan Balance Summary Table -->
  <table class="summary-table">
    <thead>
      <tr>
        <th>Total Plan Amount</th>
        <th>Total Paid to Date</th>
        <th>Remaining Balance</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><strong>Tk <?= store_number_format($receipt->total_payable); ?></strong></td>
        <td style="color: #15803d;"><strong>Tk <?= store_number_format($receipt->emi_paid_amount); ?></strong></td>
        <td style="color: #b91c1c; font-weight: 800;">Tk <?= store_number_format($receipt->emi_due_amount); ?></td>
      </tr>
    </tbody>
  </table>

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

  <div style="margin-top: 25px; text-align: center; font-size: 11px; color: #94a3b8; border-top: 1px dotted #e2e8f0; padding-top: 8px;">
    Thank you for your business. Please preserve this money receipt for future reference.
  </div>
</div>

</body>
</html>
