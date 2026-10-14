<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title><?= htmlspecialchars($page_title ?? 'Invoice Verification'); ?></title>
  <link rel="stylesheet" href="<?= base_url('theme/bootstrap/css/bootstrap.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('theme/css/font-awesome-4.7.0/css/font-awesome.min.css'); ?>">
  <style>
    * { box-sizing: border-box; }
    body {
      background: #f1f5f9;
      color: #0f172a;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      padding: 15px 10px 40px 10px;
      margin: 0;
    }
    .verify-container {
      max-width: 680px;
      margin: 0 auto;
      background: #ffffff;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.08);
      overflow: hidden;
      border: 1px solid #e2e8f0;
    }
    .verify-banner {
      background: linear-gradient(135deg, #006837 0%, #047857 100%);
      color: #ffffff;
      padding: 24px 20px;
      text-align: center;
      position: relative;
    }
    .verify-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: rgba(255,255,255,0.2);
      border: 1px solid rgba(255,255,255,0.4);
      padding: 5px 14px;
      border-radius: 20px;
      font-size: 13px;
      font-weight: 700;
      letter-spacing: 0.5px;
      margin-bottom: 10px;
      text-transform: uppercase;
    }
    .store-title {
      font-size: 22px;
      font-weight: 800;
      margin: 0 0 4px 0;
      letter-spacing: 0.3px;
    }
    .store-sub {
      font-size: 12.5px;
      opacity: 0.92;
      margin: 0;
      line-height: 1.4;
    }
    .content-body {
      padding: 20px;
    }
    .card-box {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 14px 16px;
      margin-bottom: 16px;
    }
    .card-title {
      font-size: 12px;
      font-weight: 700;
      color: #64748b;
      text-transform: uppercase;
      letter-spacing: 0.6px;
      margin-bottom: 8px;
      border-bottom: 1px dashed #cbd5e1;
      padding-bottom: 5px;
    }
    .meta-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 4px 0;
      font-size: 13px;
    }
    .meta-row .lbl { color: #64748b; font-weight: 500; }
    .meta-row .val { color: #0f172a; font-weight: 700; text-align: right; }
    .status-badge {
      display: inline-block;
      padding: 3px 10px;
      border-radius: 12px;
      font-size: 12px;
      font-weight: 700;
    }
    .status-paid { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
    .status-partial { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
    .status-unpaid { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }

    /* Items table */
    .items-list-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 8px;
    }
    .items-list-table th {
      background: #f1f5f9;
      color: #475569;
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      padding: 8px 10px;
      border-bottom: 2px solid #cbd5e1;
    }
    .items-list-table td {
      padding: 10px;
      border-bottom: 1px solid #e2e8f0;
      font-size: 12.5px;
      vertical-align: top;
    }
    .item-name-bold {
      font-weight: 700;
      color: #0f172a;
      font-size: 13.5px;
      margin-bottom: 2px;
    }
    .item-barcode {
      font-size: 11px;
      color: #475569;
      margin-top: 2px;
    }
    .item-serial-box {
      font-size: 11.5px;
      color: #006837;
      background: #f0fdf4;
      border: 1px solid #bbf7d0;
      border-radius: 4px;
      padding: 3px 8px;
      margin-top: 4px;
      display: inline-block;
      font-weight: 600;
      word-break: break-word;
    }
    .item-warranty-box {
      font-size: 11px;
      color: #0369a1;
      background: #f0f9ff;
      border: 1px solid #bae6fd;
      border-radius: 4px;
      padding: 2px 7px;
      margin-top: 4px;
      display: inline-block;
      font-weight: 600;
    }

    /* Buttons */
    .action-btn-group {
      display: flex;
      gap: 10px;
      margin-top: 20px;
      flex-wrap: wrap;
    }
    .action-btn {
      flex: 1;
      min-width: 180px;
      text-align: center;
      padding: 12px 16px;
      font-size: 13.5px;
      font-weight: 700;
      border-radius: 8px;
      text-decoration: none !important;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: all 0.2s ease;
      border: none;
      cursor: pointer;
    }
    .btn-pos {
      background: #0284c7;
      color: #ffffff !important;
    }
    .btn-pos:hover { background: #0369a1; }
    .btn-original {
      background: #006837;
      color: #ffffff !important;
    }
    .btn-original:hover { background: #004d28; }

    .not-found-box {
      text-align: center;
      padding: 40px 20px;
    }
    .footer-note {
      text-align: center;
      font-size: 11.5px;
      color: #94a3b8;
      margin-top: 22px;
      padding-top: 14px;
      border-top: 1px dashed #e2e8f0;
    }
  </style>
</head>
<body>

<div class="verify-container">

  <?php if(empty($found)): ?>
    <div class="verify-banner" style="background: linear-gradient(135deg, #b91c1c 0%, #dc2626 100%);">
      <div class="verify-badge"><i class="fa fa-times-circle"></i> Verification Failed</div>
      <h1 class="store-title">Invoice Not Found</h1>
      <p class="store-sub">The requested invoice reference could not be verified in the system.</p>
    </div>

    <div class="content-body not-found-box">
      <i class="fa fa-search text-muted" style="font-size: 48px; margin-bottom: 16px;"></i>
      <h4 style="color: #475569; font-weight: 700;">No Record Found for "<?= htmlspecialchars($query_code); ?>"</h4>
      <p style="color: #64748b; font-size: 13px; max-width: 400px; margin: 0 auto 20px auto;">
        Please double check the invoice number or scan the QR code printed directly on your official receipt.
      </p>
      <form action="<?= base_url('verify/invoice'); ?>" method="get" style="max-width: 320px; margin: 0 auto;">
        <div class="input-group">
          <input type="text" name="code" class="form-control" placeholder="Enter Invoice No..." required>
          <span class="input-group-btn">
            <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Verify</button>
          </span>
        </div>
      </form>
    </div>

  <?php else: ?>

    <!-- Verification Header Banner -->
    <div class="verify-banner">
      <div class="verify-badge"><i class="fa fa-check-circle"></i> Officially Verified Invoice</div>
      <h1 class="store-title"><?= htmlspecialchars($sale->store_name ?? 'POS Store'); ?></h1>
      <div class="store-sub">
        <?php if(!empty($sale->store_address)): ?><div><?= htmlspecialchars($sale->store_address . (!empty($sale->store_city) ? ', ' . $sale->store_city : '')); ?></div><?php endif; ?>
        <div>
          <?php if(!empty($sale->store_mobile)): ?>Ph: <?= htmlspecialchars($sale->store_mobile); ?><?php endif; ?>
          <?php if(!empty($sale->store_email)): ?> | <?= htmlspecialchars($sale->store_email); ?><?php endif; ?>
        </div>
      </div>
    </div>

    <div class="content-body">

      <!-- Invoice Overview Card -->
      <div class="card-box">
        <div class="card-title"><i class="fa fa-file-text-o"></i> Invoice Overview</div>
        <div class="meta-row">
          <span class="lbl">Invoice Number:</span>
          <span class="val" style="color: #006837; font-size: 15px; font-weight: 800;"><?= htmlspecialchars($sale->sales_code); ?></span>
        </div>
        <div class="meta-row">
          <span class="lbl">Invoice Date & Time:</span>
          <span class="val"><?= show_date($sale->sales_date) . ' ' . show_time($sale->created_time); ?></span>
        </div>
        <div class="meta-row">
          <span class="lbl">Customer Name:</span>
          <span class="val"><?= htmlspecialchars($sale->customer_name ?? 'Walk-in Customer'); ?></span>
        </div>
        <?php if(!empty($sale->customer_mobile)): ?>
        <div class="meta-row">
          <span class="lbl">Customer Mobile:</span>
          <span class="val"><?= htmlspecialchars($sale->customer_mobile); ?></span>
        </div>
        <?php endif; ?>
        <div class="meta-row">
          <span class="lbl">Payment Status:</span>
          <span class="val">
            <?php
              $p_status = strtolower($sale->payment_status);
              $cls = ($p_status == 'paid') ? 'status-paid' : (($p_status == 'partial') ? 'status-partial' : 'status-unpaid');
            ?>
            <span class="status-badge <?= $cls; ?>"><?= ucfirst($sale->payment_status); ?></span>
          </span>
        </div>
        <div class="meta-row">
          <span class="lbl">Created By:</span>
          <span class="val"><?= htmlspecialchars(get_user_fullname($sale->created_by ?? 'Admin')); ?></span>
        </div>
      </div>

      <!-- Items Section -->
      <div class="card-box" style="padding: 10px 12px;">
        <div class="card-title"><i class="fa fa-cubes"></i> Purchased Items (<?= count($items); ?>)</div>
        <table class="items-list-table">
          <thead>
            <tr>
              <th style="width: 55%;">Product</th>
              <th style="width: 15%; text-align: center;">Qty</th>
              <th style="width: 30%; text-align: right;">Total</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($items as $row): 
              $warranty_days = intval($row->warranty_days ?? 0);
              $has_warranty = ($warranty_days > 0);
              $expiry_date = '';
              if ($has_warranty && !empty($sale->sales_date)) {
                $expiry_date = date('d-m-Y', strtotime("+$warranty_days days", strtotime($sale->sales_date)));
              }
            ?>
            <tr>
              <td>
                <div class="item-name-bold"><?= htmlspecialchars($row->item_name); ?></div>
                <?php if(!empty(trim($row->item_description ?? ''))): ?>
                  <div style="font-size: 11.5px; color: #64748b; line-height: 1.25; margin-top: 2px;"><?= nl2br(htmlspecialchars($row->item_description)); ?></div>
                <?php endif; ?>
                <?php if(!empty($row->description)): ?>
                  <div class="item-serial-box"><i class="fa fa-tag"></i> <?= htmlspecialchars($row->description); ?></div>
                <?php endif; ?>
                <?php if($has_warranty): ?>
                  <br><div class="item-warranty-box"><i class="fa fa-shield"></i> Warranty: <?= $warranty_days; ?> Days <?= !empty($expiry_date) ? '(Until ' . $expiry_date . ')' : ''; ?></div>
                <?php endif; ?>
              </td>
              <td style="text-align: center; font-weight: 700;"><?= format_qty($row->sales_qty); ?></td>
              <td style="text-align: right; font-weight: 700; color: #0f172a;"><?= store_number_format($row->total_cost); ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Financial Totals Card -->
      <div class="card-box">
        <div class="card-title"><i class="fa fa-calculator"></i> Payment Summary</div>
        <div class="meta-row">
          <span class="lbl">Subtotal:</span>
          <span class="val"><?= store_number_format($sale->subtotal); ?></span>
        </div>
        <?php if($sale->tot_discount_to_all_amt > 0 || $sale->coupon_amt > 0): ?>
        <div class="meta-row">
          <span class="lbl">Total Discount:</span>
          <span class="val" style="color: #dc2626;">-<?= store_number_format($sale->tot_discount_to_all_amt + $sale->coupon_amt); ?></span>
        </div>
        <?php endif; ?>
        <div class="meta-row" style="border-top: 1px solid #cbd5e1; padding-top: 6px; margin-top: 4px;">
          <span class="lbl" style="font-size: 14px; font-weight: 800; color: #006837;">Grand Total:</span>
          <span class="val" style="font-size: 16px; font-weight: 800; color: #006837;"><?= store_number_format($sale->grand_total); ?></span>
        </div>
        <div class="meta-row">
          <span class="lbl">Paid Amount:</span>
          <span class="val" style="color: #15803d;"><?= store_number_format($sale->paid_amount); ?></span>
        </div>
        <?php 
          $due = max(0, $sale->grand_total - $sale->paid_amount);
          if($due > 0):
        ?>
        <div class="meta-row">
          <span class="lbl" style="color: #b91c1c; font-weight: 700;">Balance Due:</span>
          <span class="val" style="color: #b91c1c;"><?= store_number_format($due); ?></span>
        </div>
        <?php endif; ?>
      </div>

      <!-- Action Buttons to View / Print Original Invoices Publicly -->
      <div class="action-btn-group">
        <a href="<?= base_url('verify/pos_receipt?code=' . urlencode($sale->sales_code)); ?>" target="_blank" class="action-btn btn-pos">
          <i class="fa fa-receipt"></i> View POS Thermal Receipt
        </a>
        <a href="<?= base_url('verify/print_original?code=' . urlencode($sale->sales_code)); ?>" target="_blank" class="action-btn btn-original">
          <i class="fa fa-file-text-o"></i> View / Print Full Invoice
        </a>
      </div>

      <div class="footer-note">
        <i class="fa fa-lock text-success"></i> This official document is registered and cryptographically verified in the system registry.
      </div>

    </div>

  <?php endif; ?>

</div>

</body>
</html>
