<?php
  $CI =& get_instance();
  
  // Purchase and Supplier details
  $q_purchase = $this->db->query("SELECT b.*, a.supplier_name, a.mobile as supplier_mobile, a.phone as supplier_phone, a.address as supplier_address,
                                  a.city as supplier_city, a.state_id as supplier_state_id, a.country_id as supplier_country_id,
                                  a.postcode as supplier_postcode, a.email as supplier_email, a.gstin as supplier_gst_no, a.tax_number as supplier_tax_number
                                FROM db_purchase b
                                LEFT JOIN db_suppliers a ON a.id = b.supplier_id
                                WHERE b.id = '$purchase_id'");
  $res_purchase = $q_purchase->row();
  
  // Store details
  $store_id = (!empty($res_purchase) && !empty($res_purchase->store_id)) ? $res_purchase->store_id : get_current_store_id();
  $q_store = $this->db->query("SELECT * FROM db_store WHERE id='$store_id'");
  $res_store = $q_store->row();
  $store_name = !empty($res_store->store_name) ? $res_store->store_name : 'Supper Shop';
  $company_address = !empty($res_store->address) ? $res_store->address : '';
  if(!empty($res_store->city)) {
    $company_address = !empty($company_address) ? $company_address . ', ' . $res_store->city : $res_store->city;
  }
  $company_mobile = !empty($res_store->mobile) ? $res_store->mobile : '';
  $company_email = !empty($res_store->email) ? $res_store->email : '';
  $store_logo = !empty($res_store->store_logo) ? $res_store->store_logo : '';
  
  // Determine Store Logo image source (prioritize store's uploaded logo)
  $logo_src = '';
  if(!empty($store_logo) && file_exists(FCPATH . $store_logo)){
    $ext = pathinfo(FCPATH . $store_logo, PATHINFO_EXTENSION);
    $logo_src = 'data:image/' . ($ext == 'svg' ? 'svg+xml' : $ext) . ';base64,' . base64_encode(file_get_contents(FCPATH . $store_logo));
  } else if(!empty($store_logo) && file_exists(FCPATH . 'uploads/store/' . $store_logo)){
    $ext = pathinfo(FCPATH . 'uploads/store/' . $store_logo, PATHINFO_EXTENSION);
    $logo_src = 'data:image/' . ($ext == 'svg' ? 'svg+xml' : $ext) . ';base64,' . base64_encode(file_get_contents(FCPATH . 'uploads/store/' . $store_logo));
  } else if(file_exists(FCPATH . 'uploads/store/oky_logo.png')){
    $logo_src = 'data:image/png;base64,' . base64_encode(file_get_contents(FCPATH . 'uploads/store/oky_logo.png'));
  } else if(file_exists(FCPATH . 'uploads/company/company_logo.png')){
    $logo_src = 'data:image/png;base64,' . base64_encode(file_get_contents(FCPATH . 'uploads/company/company_logo.png'));
  }

  // Determine Store Signature image source (if uploaded)
  $signature_src = '';
  if(!empty($res_store->signature)){
    $signature_src = get_store_signature_uri($res_store->signature, $store_id);
  }

  $purchase_code = $res_purchase->purchase_code;
  $purchase_date = !empty($res_purchase->purchase_date) ? show_date($res_purchase->purchase_date) : '';
  $created_time = !empty($res_purchase->created_time) ? show_time($res_purchase->created_time) : '';
  $created_by = !empty($res_purchase->created_by) ? get_user_fullname($res_purchase->created_by) : 'Admin';
  $supplier_name = !empty($res_purchase->supplier_name) ? $res_purchase->supplier_name : 'Supplier';
  $supplier_mobile = !empty($res_purchase->supplier_mobile) ? $res_purchase->supplier_mobile : '';
  $supplier_full_address = !empty($res_purchase->supplier_address) ? $res_purchase->supplier_address : '';
  if(!empty($res_purchase->supplier_city)) {
    $supplier_full_address = !empty($supplier_full_address) ? $supplier_full_address . ', ' . $res_purchase->supplier_city : $res_purchase->supplier_city;
  }
  $reference_no = !empty($res_purchase->reference_no) ? $res_purchase->reference_no : '';
  $purchase_status = !empty($res_purchase->purchase_status) ? $res_purchase->purchase_status : '';
  $payment_status = !empty($res_purchase->payment_status) ? $res_purchase->payment_status : '';
  $purchase_note = !empty($res_purchase->purchase_note) ? $res_purchase->purchase_note : '';
  $invoice_terms = !empty($res_store->purchase_terms_and_conditions) ? $res_store->purchase_terms_and_conditions : '';

  $subtotal = (float)$res_purchase->subtotal;
  $tot_discount_to_all_amt = (float)$res_purchase->tot_discount_to_all_amt;
  $other_charges_amt = (float)$res_purchase->other_charges_amt;
  $round_off = (float)$res_purchase->round_off;
  $grand_total = (float)$res_purchase->grand_total;
  $paid_amount = (float)$res_purchase->paid_amount;
  $due_amount = ($grand_total > $paid_amount) ? ($grand_total - $paid_amount) : 0;
  $change_return = ($paid_amount > $grand_total) ? ($paid_amount - $grand_total) : 0;

  // Barcode Data URI (C128 Barcode of invoice number)
  $barcode_base64 = generate_invoice_barcode_uri($purchase_code, 1.0, 26);

  // QR Code Data URI (links to public invoice verification)
  $qr_base64 = generate_invoice_qr_uri(base_url('verify/invoice?code=' . urlencode($purchase_code)));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $page_title ?? 'Purchase Invoice'; ?> - <?= $purchase_code ?? ''; ?></title>
  <style>
    @page {
      size: A4 portrait;
      margin: 12mm 15mm 12mm 15mm;
    }
    * {
      box-sizing: border-box;
      -webkit-print-color-adjust: exact !important;
      print-color-adjust: exact !important;
    }
    body {
      margin: 0;
      padding: 0;
      background: #ffffff;
      color: #0f172a;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 13px;
      line-height: 1.45;
    }
    .invoice-wrapper {
      width: 100%;
      margin: 0 auto;
      background: #ffffff;
      padding: 0;
    }
    .no-print {
      margin-bottom: 12px;
      text-align: right;
    }
    .btn {
      display: inline-block;
      padding: 7px 16px;
      font-size: 13px;
      font-weight: 600;
      border-radius: 6px;
      text-decoration: none;
      cursor: pointer;
      border: 1px solid transparent;
    }
    .btn-print {
      background: #006837;
      color: #ffffff;
    }
    .btn-close {
      background: #e2e8f0;
      color: #334155;
      margin-left: 6px;
    }
    @media print {
      .no-print {
        display: none !important;
      }
      body {
        background: #ffffff;
      }
      .invoice-wrapper {
        padding: 0;
        max-width: 100%;
      }
    }
    
    /* Pad Header Layout */
    .pad-header-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 6px;
    }
    .pad-header-table td {
      vertical-align: top;
      border: none;
      padding: 0;
    }
    
    .store-logo-img {
      max-height: 65px;
      max-width: 135px;
      object-fit: contain;
      display: block;
    }
    .store-center-box {
      text-align: center;
      padding: 0 10px;
    }
    .store-title {
      font-size: 23px;
      font-weight: 800;
      color: #006837;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      margin: 0 0 2px 0;
      line-height: 1.15;
    }
    .store-meta {
      font-size: 12px;
      color: #334155;
      line-height: 1.35;
    }
    
    .invoice-right-box {
      text-align: right;
    }
    .invoice-badge {
      display: inline-block;
      background-color: #d1fae5;
      color: #006837;
      font-size: 13.5px;
      font-weight: 800;
      padding: 3px 14px;
      border-radius: 12px;
      border: 1px solid #a7f3d0;
      margin-bottom: 4px;
      text-transform: uppercase;
    }
    .invoice-no {
      font-size: 13.5px;
      font-weight: 700;
      color: #0f172a;
      margin-bottom: 2px;
    }
    .invoice-meta-item {
      font-size: 12px;
      color: #475569;
      line-height: 1.3;
    }
    .barcode-img {
      height: 26px;
      max-width: 220px;
      width: auto;
      margin-top: 3px;
      display: inline-block;
      image-rendering: pixelated;
      image-rendering: crisp-edges;
    }

    .pad-divider {
      border-bottom: 2px solid #006837;
      margin: 8px 0 10px 0;
    }

    /* Supplier and Meta Section */
    .bill-meta-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 10px;
    }
    .bill-meta-table td {
      vertical-align: top;
      border: none;
      padding: 0;
    }

    /* Items Table */
    .items-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 10px;
    }
    .items-table th {
      background-color: #006837;
      color: #ffffff;
      font-size: 12px;
      font-weight: 700;
      padding: 7px 8px;
      border: 1px solid #006837;
      letter-spacing: 0.5px;
    }
    .items-table td {
      padding: 7px 8px;
      font-size: 12px;
      border: 1px solid #cbd5e1;
      color: #0f172a;
    }
    .items-table tbody tr:nth-child(even) {
      background-color: #f8fafc;
    }
    .items-table tfoot td {
      background-color: #f1f5f9;
      font-weight: 700;
      border: 1px solid #cbd5e1;
    }

    .text-center { text-align: center; }
    .text-left { text-align: left; }
    .text-right { text-align: right; }
    
    /* Summary Section */
    .summary-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 12px;
    }
    .summary-table td {
      vertical-align: top;
      border: none;
      padding: 0;
    }
    .in-word-box {
      font-size: 12px;
      font-weight: 700;
      color: #006837;
      margin-bottom: 6px;
      background: #f0fdf4;
      padding: 6px 9px;
      border-radius: 4px;
      border: 1px solid #bbf7d0;
    }
    .in-word-text {
      color: #0f172a;
      font-weight: 600;
    }
    .note-box {
      font-size: 12px;
      color: #334155;
      margin-bottom: 6px;
    }
    .terms-box {
      font-size: 11px;
      color: #64748b;
      line-height: 1.35;
    }

    /* Totals Box Table */
    .totals-box-table {
      width: 100%;
      border-collapse: collapse;
    }
    .totals-box-table td {
      padding: 4px 6px;
      font-size: 12px;
    }
    .totals-box-table td.lbl {
      text-align: right;
      color: #475569;
      font-weight: 600;
      width: 60%;
    }
    .totals-box-table td.val {
      text-align: right;
      color: #0f172a;
      font-weight: 700;
      width: 40%;
    }
    .totals-box-table tr.grand-row td {
      background: #f8fafc;
      border-top: 1px solid #cbd5e1;
      border-bottom: 1px solid #cbd5e1;
      font-size: 13.5px;
      font-weight: 800;
      color: #006837;
      padding: 6px 6px;
    }

    /* Signatures */
    .signatures-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 55px;
      margin-bottom: 8px;
    }
    .signatures-table td {
      vertical-align: bottom;
      border: none;
      padding: 0;
    }
    .sig-line {
      border-top: 1.5px solid #0f172a;
      display: inline-block;
      width: 190px;
      padding-top: 4px;
      font-size: 11px;
      font-weight: 600;
      color: #0f172a;
    }
    
    /* Footer & Centered QR Code */
    .footer-section {
      border-top: 1px solid #e2e8f0;
      padding-top: 8px;
      margin-top: 10px;
      text-align: center;
    }
    .dev-credit {
      font-size: 11px;
      color: #475569;
      margin-bottom: 6px;
    }
    .dev-credit strong {
      color: #006837;
      font-weight: 800;
    }
    .qr-wrap {
      display: inline-block;
      text-align: center;
      margin-top: 2px;
    }
    .qr-img {
      height: 75px;
      width: 75px;
      display: block;
      margin: 0 auto;
    }
    .qr-label {
      font-size: 10px;
      color: #64748b;
      margin-top: 3px;
    }
  </style>
</head>
<body <?= !isset($is_pdf) ? 'onload="window.print();"' : ''; ?>>


<div class="invoice-wrapper">

  <?php if(!isset($is_pdf)): ?>
  <div class="no-print">
    <button type="button" class="btn btn-print" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
    <a href="javascript:window.close();" class="btn btn-close">Close</a>
  </div>
  <?php endif; ?>

  <!-- Pad Style Header Section -->
  <table class="pad-header-table">
    <tr>
      <!-- Left: Store Logo (Pad style) -->
      <td style="width: 25%; text-align: left;">
        <?php if(!empty($logo_src)): ?>
          <img src="<?= $logo_src; ?>" class="store-logo-img" alt="Store Logo">
        <?php endif; ?>
      </td>

      <!-- Middle: Store Name & Details (Centered, large and clear) -->
      <td style="width: 50%;" class="store-center-box">
        <div class="store-title"><?= htmlspecialchars($store_name); ?></div>
        <div class="store-meta">
          <?php if(!empty($company_address)): ?><div><?= htmlspecialchars($company_address); ?></div><?php endif; ?>
          <div>
            <?php if(!empty($company_mobile)): ?>Phone: <?= htmlspecialchars($company_mobile); ?><?php endif; ?>
            <?php if(!empty($company_email)): ?> | Email: <?= htmlspecialchars($company_email); ?><?php endif; ?>
          </div>
        </div>
      </td>

      <!-- Right: Invoice Pill Badge, Number, Date, Barcode -->
      <td style="width: 25%;" class="invoice-right-box">
        <div class="invoice-badge">Purchase Invoice</div>
        <div class="invoice-no">Invoice No: <?= htmlspecialchars($purchase_code); ?></div>
        <?php if(!empty($barcode_base64)): ?>
          <div><img src="<?= $barcode_base64; ?>" class="barcode-img" alt="Barcode"></div>
        <?php endif; ?>
        <div class="invoice-meta-item">Date: <?= $purchase_date . ' ' . $created_time; ?></div>
        <div class="invoice-meta-item">Created By: <?= htmlspecialchars($created_by); ?></div>
      </td>
    </tr>
  </table>

  <!-- Official Pad Divider -->
  <div class="pad-divider"></div>

  <!-- Supplier & Meta Section -->
  <table class="bill-meta-table">
    <tr>
      <td style="width: 60%; text-align: left;">
        <span style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">Supplier:</span><br>
        <strong style="font-size: 14.5px; color: #0f172a;"><?= htmlspecialchars($supplier_name); ?></strong>
        <?php if(!empty($supplier_mobile)): ?><br><span style="font-size: 12px; color: #475569;">Phone: <?= htmlspecialchars($supplier_mobile); ?></span><?php endif; ?>
        <?php if(!empty($supplier_full_address)): ?><br><span style="font-size: 12px; color: #475569;">Address: <?= htmlspecialchars($supplier_full_address); ?></span><?php endif; ?>
        <?php if(!empty($res_purchase->supplier_gst_no)): ?><br><span style="font-size: 12px; color: #475569;">GST/Tax No: <?= htmlspecialchars($res_purchase->supplier_gst_no); ?></span><?php endif; ?>
      </td>
      <td style="width: 40%; text-align: right; font-size: 12px; color: #475569;">
        <?php if(!empty($reference_no)): ?>
          <div><strong>Reference No:</strong> <?= htmlspecialchars($reference_no); ?></div>
        <?php endif; ?>
        <?php if(!empty($purchase_status)): ?>
          <div><strong>Purchase Status:</strong> <span style="font-weight: 700; color: #006837;"><?= htmlspecialchars($purchase_status); ?></span></div>
        <?php endif; ?>
        <div><strong>Payment Status:</strong> <span style="font-weight: 700; color: <?= $payment_status == 'Paid' ? '#006837' : '#ea7916'; ?>;"><?= htmlspecialchars($payment_status); ?></span></div>
        <div><strong>Purchased By:</strong> <?= htmlspecialchars($created_by); ?></div>
      </td>
    </tr>
  </table>

  <!-- Items Table (Item Box) -->
  <table class="items-table">
    <thead>
      <tr>
        <th class="text-center" style="width: 6%;">SL</th>
        <th class="text-left" style="width: 52%;">PRODUCT</th>
        <th class="text-center" style="width: 14%;">QTY</th>
        <th class="text-right" style="width: 14%;">PRICE</th>
        <th class="text-right" style="width: 14%;">TOTAL</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $sl = 1;
        $total_qty = 0;
        $q_items = $this->db->query("SELECT a.*, c.item_name, c.custom_barcode, c.item_code, c.description as item_description, d.unit_name
                                      FROM db_purchaseitems a
                                      LEFT JOIN db_items c ON c.id = a.item_id
                                      LEFT JOIN db_units d ON d.id = c.unit_id
                                      WHERE a.purchase_id = '$purchase_id'
                                      ORDER BY a.id ASC");
        foreach($q_items->result() as $row_item):
          $total_qty += (float)$row_item->purchase_qty;
          $unit = !empty($row_item->unit_name) ? $row_item->unit_name : 'Pcs';
          $item_price = (float)$row_item->price_per_unit;
          $item_total = (float)$row_item->total_cost;
      ?>
      <tr>
        <td class="text-center"><?= $sl++; ?></td>
        <td class="text-left">
          <strong style="font-size: 13px; color: #0f172a;"><?= htmlspecialchars($row_item->item_name); ?></strong>
          <?php if(!empty(trim($row_item->item_description ?? ''))): ?>
            <div style="font-size: 10.5px; color: #475569; line-height: 1.3; margin-top: 2px;"><?= nl2br(htmlspecialchars($row_item->item_description)); ?></div>
          <?php endif; ?>
          <?php if(!empty($row_item->description)): 
            $d = htmlspecialchars($row_item->description);
            if(stripos($d, 'SN:') === 0){
              $d = '<strong>Serial:</strong> ' . substr($d, 3);
            }
          ?>
            <div style="font-size: 11px; color: #006837; font-weight: 600; margin-top: 2px;"><?= $d; ?></div>
          <?php endif; ?>
          <?php if((float)($row_item->tax_amt ?? 0) > 0): ?>
            <div style="font-size: 10.5px; color: #64748b; margin-top: 1px;">Tax: <?= store_number_format($row_item->tax_amt); ?> (<?= htmlspecialchars($row_item->tax_type); ?>)</div>
          <?php endif; ?>
        </td>
        <td class="text-center" style="font-size: 12px;"><?= format_qty($row_item->purchase_qty) . ' ' . htmlspecialchars($unit); ?></td>
        <td class="text-right" style="font-size: 12px;"><?= store_number_format($item_price); ?></td>
        <td class="text-right" style="font-size: 12px;"><?= store_number_format($item_total); ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2" class="text-left" style="font-weight: 700;">Total</td>
        <td class="text-center" style="font-weight: 700;"><?= format_qty($total_qty); ?></td>
        <td></td>
        <td class="text-right" style="font-weight: 700; color: #006837;"><?= store_number_format($subtotal); ?></td>
      </tr>
    </tfoot>
  </table>

  <!-- Summary Section -->
  <table class="summary-table">
    <tr>
      <!-- Left: In Word, Notes, Terms -->
      <td style="width: 58%; padding-right: 15px;">
        <div class="in-word-box">
          IN Word: <span class="in-word-text"><?= amount_in_words_bd($grand_total, 'Taka'); ?></span>
        </div>

        <?php if(!empty($purchase_note)): ?>
        <div class="note-box">
          <strong>Note:</strong> <?= nl2br(htmlspecialchars($purchase_note)); ?>
        </div>
        <?php endif; ?>

        <?php if(!empty($invoice_terms)): ?>
        <div class="terms-box">
          <strong>Terms & Conditions:</strong><br>
          <?= nl2br(htmlspecialchars($invoice_terms)); ?>
        </div>
        <?php endif; ?>
      </td>

      <!-- Right: Totals Stack -->
      <td style="width: 42%;">
        <table class="totals-box-table">
          <tr>
            <td class="lbl">Total:</td>
            <td class="val"><?= store_number_format($subtotal); ?> Tk</td>
          </tr>
          <?php if($tot_discount_to_all_amt > 0): ?>
          <tr>
            <td class="lbl">Discount:</td>
            <td class="val">-<?= store_number_format($tot_discount_to_all_amt); ?> Tk</td>
          </tr>
          <?php endif; ?>
          <?php if($other_charges_amt > 0): ?>
          <tr>
            <td class="lbl">Other Charges:</td>
            <td class="val"><?= store_number_format($other_charges_amt); ?> Tk</td>
          </tr>
          <?php endif; ?>
          <?php if($round_off != 0): ?>
          <tr>
            <td class="lbl">Round Off:</td>
            <td class="val"><?= store_number_format($round_off); ?> Tk</td>
          </tr>
          <?php endif; ?>
          <?php if($tot_discount_to_all_amt > 0 || $other_charges_amt > 0 || $round_off != 0): ?>
          <tr class="grand-row">
            <td class="lbl">Grand Total:</td>
            <td class="val"><?= store_number_format($grand_total); ?> Tk</td>
          </tr>
          <?php endif; ?>
          <tr>
            <td class="lbl">Paid:</td>
            <td class="val"><?= store_number_format($paid_amount); ?> Tk</td>
          </tr>
          <?php if($due_amount > 0): ?>
          <tr>
            <td class="lbl" style="color: #dc2626;">Due:</td>
            <td class="val" style="color: #dc2626;"><?= store_number_format($due_amount); ?> Tk</td>
          </tr>
          <?php endif; ?>
          <?php if($change_return > 0): ?>
          <tr>
            <td class="lbl">Change:</td>
            <td class="val"><?= store_number_format($change_return); ?> Tk</td>
          </tr>
          <?php endif; ?>
        </table>
      </td>
    </tr>
  </table>

  <!-- Signatures Section -->
  <table class="signatures-table">
    <tr>
      <td style="width: 50%; text-align: left; vertical-align: bottom;">
        <div style="display: inline-block; text-align: center; width: 190px;">
          <div style="height: 48px;"></div>
          <div class="sig-line" style="text-align: center; width: 100%;">Supplier Signature</div>
        </div>
      </td>
      <td style="width: 50%; text-align: right; vertical-align: bottom;">
        <div style="display: inline-block; text-align: center; width: 190px;">
          <?php if(!empty($signature_src)): ?>
            <div style="height: 48px; text-align: center; margin-bottom: 3px;">
              <img src="<?= $signature_src; ?>" style="max-height: 46px; max-width: 150px; vertical-align: bottom; display: inline-block;" alt="Authorized Signature">
            </div>
          <?php else: ?>
            <div style="height: 48px;"></div>
          <?php endif; ?>
          <div class="sig-line" style="text-align: center; width: 100%;">Authorized Signature</div>
        </div>
      </td>
    </tr>
  </table>

  <!-- Footer Section: Centered QR Code with Software Developed by JAAS BD as footer below QR -->
  <div class="footer-section">
    <?php if(!empty($qr_base64)): ?>
    <div class="qr-wrap">
      <a href="<?= base_url('verify/invoice/' . urlencode($purchase_code)); ?>" target="_blank" style="text-decoration:none; color:inherit;">
        <img src="<?= $qr_base64; ?>" class="qr-img" alt="Invoice QR Code">
        <div class="qr-label">Scan / Click to Verify Invoice</div>
      </a>
    </div>
    <?php endif; ?>
    <div class="dev-credit" style="margin-top: 6px;">
      Software Developed by <strong>JAAS BD</strong>
    </div>
  </div>

</div>

</body>
</html>
