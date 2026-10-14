<!DOCTYPE html>
<html>
<head>
	<title>Default Invoice Format</title>
<!-- TABLES CSS CODE -->
<?php include"comman/code_css.php"; ?>
<style type="text/css">
	@page {
		size: auto;
		margin: 0mm;
	}
	* {
		box-sizing: border-box;
		-webkit-print-color-adjust: exact !important;
		print-color-adjust: exact !important;
	}
	html, body {
		margin: 0;
		padding: 0;
		background: #f1f5f9;
		color: #0f172a;
		font-family: Arial, Helvetica, sans-serif;
		font-size: 10.5px;
		line-height: 1.3;
	}
	.pos-wrapper {
		width: 100%;
		max-width: 80mm;
		margin: 15px auto;
		background: #ffffff;
		padding: 8px 10px;
		box-shadow: 0 4px 15px rgba(0,0,0,0.08);
		border-radius: 4px;
		transition: max-width 0.2s ease, font-size 0.2s ease, padding 0.2s ease;
	}
	table {
		width: 100%;
		border-collapse: collapse;
	}
	img {
		max-width: 100%;
		height: auto;
	}
	.store-header-box {
		text-align: center;
		margin-bottom: 4px;
	}
	.store-name-title {
		font-size: 15.5px;
		font-weight: 800;
		color: #006837;
		line-height: 1.15;
		text-transform: uppercase;
		letter-spacing: 0.3px;
		margin: 0 0 2px 0;
		text-align: center;
	}
	.store-meta-text {
		font-size: 9.5px;
		color: #334155;
		line-height: 1.3;
		text-align: center;
	}
	.pad-divider {
		border-bottom: 1.5px solid #006837;
		margin: 5px 0 6px 0;
	}
	.dashed-divider {
		border-bottom: 1px dashed #64748b;
		margin: 4px 0 5px 0;
	}

	/* Top Toolbar */
	.pos-toolbar {
		background: #0f172a;
		color: #fff;
		padding: 8px 15px;
		display: flex;
		justify-content: center;
		align-items: center;
		gap: 12px;
		box-shadow: 0 2px 8px rgba(0,0,0,0.25);
		position: sticky;
		top: 0;
		z-index: 9999;
		flex-wrap: wrap;
	}
	.pos-toolbar .tool-label {
		font-size: 12px;
		font-weight: 600;
		color: #94a3b8;
		margin-right: 2px;
	}
	.pos-toolbar .paper-btn-group {
		display: inline-flex;
		border: 1px solid #334155;
		border-radius: 4px;
		overflow: hidden;
	}
	.pos-toolbar .paper-btn {
		background: #1e293b;
		color: #cbd5e1;
		border: none;
		padding: 5px 12px;
		font-size: 11.5px;
		font-weight: 600;
		cursor: pointer;
		outline: none;
		transition: all 0.15s ease;
	}
	.pos-toolbar .paper-btn:not(:last-child) {
		border-right: 1px solid #334155;
	}
	.pos-toolbar .paper-btn:hover {
		background: #334155;
		color: #fff;
	}
	.pos-toolbar .paper-btn.active {
		background: #006837;
		color: #ffffff;
		font-weight: 700;
	}
	.pos-toolbar .btn-print-action {
		background: #16a34a;
		color: #ffffff;
		border: none;
		padding: 5px 16px;
		font-size: 12px;
		font-weight: 700;
		border-radius: 4px;
		cursor: pointer;
		display: inline-flex;
		align-items: center;
		gap: 5px;
	}
	.pos-toolbar .btn-print-action:hover {
		background: #15803d;
	}
	.pos-toolbar .btn-back-action {
		background: #dc2626;
		color: #fff;
		border: none;
		padding: 5px 14px;
		font-size: 12px;
		font-weight: 600;
		border-radius: 4px;
		text-decoration: none;
	}

	/* Paper Size Modes (Preview & Explicit Print) */
	/* 58mm Roll Mode */
	body.mode-58mm .pos-wrapper {
		max-width: 58mm !important;
		padding: 2mm 2.5mm !important;
		font-size: 8.5px !important;
	}
	body.mode-58mm .store-name-title {
		font-size: 13px !important;
	}
	body.mode-58mm .store-meta-text {
		font-size: 8px !important;
	}
	body.mode-58mm table th,
	body.mode-58mm table td {
		font-size: 8px !important;
		padding: 2px 1px !important;
	}
	body.mode-58mm .pos-barcode-img {
		height: 18px !important;
	}

	/* 80mm Roll Mode */
	body.mode-80mm .pos-wrapper {
		max-width: 80mm !important;
		padding: 6px 8px !important;
		font-size: 10.5px !important;
	}
	body.mode-80mm .store-name-title {
		font-size: 15.5px !important;
	}
	body.mode-80mm .store-meta-text {
		font-size: 9.5px !important;
	}
	body.mode-80mm table th,
	body.mode-80mm table td {
		font-size: 10px !important;
		padding: 3px 2px !important;
	}
	body.mode-80mm .pos-barcode-img {
		height: 22px !important;
	}

	/* A4 Page Mode: Perfectly scales POS receipt layout to fill A4 sheet cleanly */
	body.mode-a4 .pos-wrapper {
		max-width: 190mm !important;
		padding: 10mm 14mm !important;
		font-size: 13px !important;
		margin: 20px auto !important;
	}
	body.mode-a4 .store-name-title {
		font-size: 22px !important;
	}
	body.mode-a4 .store-meta-text {
		font-size: 12px !important;
	}
	body.mode-a4 table th,
	body.mode-a4 table td {
		font-size: 12px !important;
		padding: 5px 6px !important;
	}
	body.mode-a4 .pos-barcode-img {
		height: 28px !important;
	}

	/* PRINT MEDIA STYLES (Smart Auto Fit on any selected paper) */
	@media print {
		.no-print, .pos-toolbar {
			display: none !important;
		}
		html, body {
			background: #ffffff !important;
			margin: 0 !important;
			padding: 0 !important;
			width: 100% !important;
		}
		.pos-wrapper {
			box-shadow: none !important;
			border-radius: 0 !important;
			margin: 0 auto !important;
		}

		/* Auto-fit based on detected printer paper width: */
		/* Auto Fit: 58mm Printer (<= 65mm) */
		@media (max-width: 65mm) {
			@page {
				size: 58mm auto;
				margin: 1mm;
			}
			.pos-wrapper {
				width: 100% !important;
				max-width: 58mm !important;
				padding: 1mm 1.5mm !important;
				font-size: 8.5px !important;
			}
			.store-name-title {
				font-size: 12.5px !important;
			}
			.store-meta-text {
				font-size: 8px !important;
			}
			table th, table td {
				font-size: 8px !important;
				padding: 2px 1px !important;
			}
			.pos-barcode-img {
				height: 18px !important;
			}
		}

		/* Auto Fit: 80mm Printer (65.1mm - 95mm) */
		@media (min-width: 65.1mm) and (max-width: 95mm) {
			@page {
				size: 80mm auto;
				margin: 1.5mm;
			}
			.pos-wrapper {
				width: 100% !important;
				max-width: 80mm !important;
				padding: 2mm 3mm !important;
				font-size: 10px !important;
			}
			.store-name-title {
				font-size: 15.5px !important;
			}
			.store-meta-text {
				font-size: 9.5px !important;
			}
			table th, table td {
				font-size: 10px !important;
				padding: 3px 2px !important;
			}
			.pos-barcode-img {
				height: 22px !important;
			}
		}

		/* Auto Fit: A4 / Standard Page (> 95mm) */
		@media (min-width: 95.1mm) {
			@page {
				size: A4 portrait;
				margin: 8mm 10mm;
			}
			.pos-wrapper {
				width: 100% !important;
				max-width: 190mm !important;
				padding: 6mm 10mm !important;
				font-size: 12.5px !important;
			}
			.store-name-title {
				font-size: 22px !important;
			}
			.store-meta-text {
				font-size: 12px !important;
			}
			table th, table td {
				font-size: 12px !important;
				padding: 5px 6px !important;
			}
			.pos-barcode-img {
				height: 28px !important;
			}
		}

		/* Overrides if user explicitly selected paper mode */
		body.mode-58mm {
			@page { size: 58mm auto; margin: 1mm; }
		}
		body.mode-58mm .pos-wrapper {
			width: 100% !important;
			max-width: 58mm !important;
			padding: 1mm 1.5mm !important;
			font-size: 8.5px !important;
		}
		body.mode-80mm {
			@page { size: 80mm auto; margin: 1.5mm; }
		}
		body.mode-80mm .pos-wrapper {
			width: 100% !important;
			max-width: 80mm !important;
			padding: 2mm 3mm !important;
			font-size: 10px !important;
		}
		body.mode-a4 {
			@page { size: A4 portrait; margin: 8mm 10mm; }
		}
		body.mode-a4 .pos-wrapper {
			width: 100% !important;
			max-width: 190mm !important;
			padding: 6mm 10mm !important;
			font-size: 12.5px !important;
		}
	}
</style>
<style id="dynamic_page_style"></style>
</head>
<body onload="window.print();"><!--  -->
	<?php
	$CI =& get_instance();
	
    
  	$q3=$this->db->query("SELECT b.coupon_id,b.coupon_amt, b.created_by, b.customer_previous_due,b.customer_total_due,b.store_id,a.customer_name,a.mobile,a.phone,a.gstin,a.tax_number,a.email,a.delete_bit,b.invoice_terms,
                           a.opening_balance,a.country_id,a.state_id,
                           a.postcode,a.address,b.sales_date,b.created_time,b.reference_no,
                           b.sales_code,b.sales_note,a.sales_due,
                           coalesce(b.grand_total,0) as grand_total,
                           coalesce(b.subtotal,0) as subtotal,
                           coalesce(b.paid_amount,0) as paid_amount,
                           coalesce(b.other_charges_input,0) as other_charges_input,
                           other_charges_tax_id,
                           coalesce(b.other_charges_amt,0) as other_charges_amt,
                           discount_to_all_input,
                           b.discount_to_all_type,
                           coalesce(b.tot_discount_to_all_amt,0) as tot_discount_to_all_amt,
                           coalesce(b.round_off,0) as round_off,
                           b.payment_status

                           FROM db_customers a,
                           db_sales b 
                           WHERE 
                           a.`id`=b.`customer_id` AND 
                           b.`id`='$sales_id' 
                           ");
                        
    
    $res3=$q3->row();
    $customer_name=$res3->customer_name;
    $customer_mobile=$res3->mobile;
    $customer_phone=$res3->phone;
    $customer_email=$res3->email;
    $customer_country=$res3->country_id;
    $customer_state=$res3->state_id;
    $customer_address=$res3->address;
    $customer_postcode=$res3->postcode;
    $customer_gst_no=$res3->gstin;
    $customer_tax_number=$res3->tax_number;
    $customer_opening_balance=$res3->opening_balance;
    $sales_date=show_date($res3->sales_date);
    $reference_no=$res3->reference_no;
    $created_time=show_time($res3->created_time);
    $sales_code=$res3->sales_code;
    $sales_note=$res3->sales_note;
    $customer_delete_bit=$res3->delete_bit;
   // $invoice_terms=nl2br($res3->invoice_terms);

    $previous_due=$res3->sales_due-($res3->grand_total-$res3->paid_amount);//$res3->customer_previous_due;
    $previous_due = ($previous_due>0) ? $previous_due : 0;
    $total_due=$res3->sales_due;//$res3->customer_total_due;

    $coupon_id=$res3->coupon_id;
    $coupon_amt=$res3->coupon_amt;

    $coupon_code = '';
    $coupon_type = '';
    $coupon_value=0;
    if(!empty($coupon_id)){
    	$coupon_details =get_customer_coupon_details($coupon_id);
    	$coupon_code =$coupon_details->code;
    	$coupon_value =$coupon_details->value;
    	$coupon_type =$coupon_details->type;
    } 

    
    $subtotal=$res3->subtotal;
    $grand_total=$res3->grand_total;
    $other_charges_input=$res3->other_charges_input;
    $other_charges_tax_id=$res3->other_charges_tax_id;
    $other_charges_amt=$res3->other_charges_amt;
    $paid_amount=$res3->paid_amount;
    $discount_to_all_input=$res3->discount_to_all_input;
    $discount_to_all_type=$res3->discount_to_all_type;
    //$discount_to_all_type = ($discount_to_all_type=='in_percentage') ? '%' : 'Fixed';
    $tot_discount_to_all_amt=$res3->tot_discount_to_all_amt;
    $round_off=$res3->round_off;
    $payment_status=$res3->payment_status;
    
    if($discount_to_all_input>0){
    	$str="($discount_to_all_input%)";
    }else{
    	$str="(Fixed)";
    }


    if(!empty($customer_state)){
      $q6 = $this->db->query("select state from db_states where id='$customer_state'");
      if($q6->num_rows()>0){
      	$customer_state = $q6->row()->state;
      }
    }

    $overall_discounted = $tot_discount_to_all_amt + $coupon_amt;

    $q1=$this->db->query("select * from db_store where id=".$res3->store_id." ");
    $res1=$q1->row();
    $store_name		=$res1->store_name;
    $company_mobile		=$res1->mobile;
    $company_phone		=$res1->phone;
    $company_email		=$res1->email;
    $company_country	=$res1->country;
    $company_state		=$res1->state;
    $company_city		=$res1->city;
    $company_address	=$res1->address;
    $company_postcode	=$res1->postcode;
    $company_gst_no		=$res1->gst_no;//Goods and Service Tax Number (issued by govt.)
    $company_vat_number		=$res1->vat_no;//Goods and Service Tax Number (issued by govt.)
    $store_logo=(!empty($res1->store_logo)) ? $res1->store_logo : store_demo_logo();
    $store_website		=$res1->store_website;
    $mrp_column		=$res1->mrp_column;
    $previous_balance_bit	=$res1->previous_balance_bit;
    $pos_invoice_format_id	=$res1->pos_invoice_format_id;
    $t_and_c_status_pos	=$res1->t_and_c_status_pos;

    $pos_logo = '';
    if(!empty($res1->store_logo) && file_exists(FCPATH . $res1->store_logo)){
      $ext = pathinfo(FCPATH . $res1->store_logo, PATHINFO_EXTENSION);
      $pos_logo = 'data:image/' . ($ext == 'svg' ? 'svg+xml' : $ext) . ';base64,' . base64_encode(file_get_contents(FCPATH . $res1->store_logo));
    } else if(!empty($res1->store_logo) && file_exists(FCPATH . 'uploads/store/' . $res1->store_logo)){
      $ext = pathinfo(FCPATH . 'uploads/store/' . $res1->store_logo, PATHINFO_EXTENSION);
      $pos_logo = 'data:image/' . ($ext == 'svg' ? 'svg+xml' : $ext) . ';base64,' . base64_encode(file_get_contents(FCPATH . 'uploads/store/' . $res1->store_logo));
    } else if(file_exists(FCPATH . 'uploads/store/oky_logo.png')){
      $pos_logo = 'data:image/png;base64,' . base64_encode(file_get_contents(FCPATH . 'uploads/store/oky_logo.png'));
    } else if(file_exists(FCPATH . 'uploads/company/company_logo.png')){
      $pos_logo = 'data:image/png;base64,' . base64_encode(file_get_contents(FCPATH . 'uploads/company/company_logo.png'));
    }

    // Barcode Data URI for POS (C128 Barcode of invoice number)
    $pos_barcode_img = generate_invoice_barcode_uri($sales_code, 1.0, 22);

    // QR Code Data URI for POS (links to public invoice verification)
    $pos_qr_img = generate_invoice_qr_uri(base_url('verify/invoice?code=' . urlencode($sales_code)));

    // Store Signature Data URI (if uploaded)
    $pos_signature_img = get_store_signature_uri($res1->signature ?? '', $res3->store_id);

    ?>
	<!-- Sticky Top Toolbar (Screen Only) for Paper Size Selection & Print -->
	<div class="pos-toolbar no-print">
		<button type="button" class="btn-print-action" onclick="window.print();" title="Print Invoice">
			<i class="fa fa-print"></i> Print
		</button>
		<span class="tool-label">Paper Size:</span>
		<div class="paper-btn-group">
			<button type="button" class="paper-btn active" id="btn_paper_auto" onclick="setPaperMode('auto')">Auto Fit</button>
			<button type="button" class="paper-btn" id="btn_paper_58" onclick="setPaperMode('58mm')">58mm</button>
			<button type="button" class="paper-btn" id="btn_paper_80" onclick="setPaperMode('80mm')">80mm</button>
			<button type="button" class="paper-btn" id="btn_paper_a4" onclick="setPaperMode('a4')">A4</button>
		</div>
		<?php if(isset($_GET['redirect'])){ ?>
			<a href="<?= base_url().$_GET['redirect'];?>" class="btn-back-action" title="Back"><i class="fa fa-arrow-left"></i> Back</a>
		<?php } ?>
	</div>

	<div class="pos-wrapper" id="pos_print_wrapper">

		<!-- Store Header: Centered layout with logo, store name, and address/mobile centered in middle -->
		<div class="store-header-box">
			<?php if(!empty($pos_logo)): ?>
				<div style="text-align: center; margin-bottom: 3px;">
					<img src="<?= $pos_logo; ?>" style="max-height: 48px; max-width: 140px; display: inline-block; object-fit: contain;" alt="Store Logo">
				</div>
			<?php endif; ?>
			<div class="store-name-title"><?= htmlspecialchars($store_name); ?></div>
			<div class="store-meta-text">
				<?php if(!empty(trim($company_address))): ?>
					<div style="text-align: center;"><?= htmlspecialchars($company_address); ?><?= !empty(trim($company_city)) ? ', ' . htmlspecialchars($company_city) : ''; ?><?= !empty($company_postcode) ? '-' . $company_postcode : ''; ?></div>
				<?php endif; ?>
				<div style="text-align: center;">
					<?php if(!empty(trim($company_mobile))): ?><strong>Mobile:</strong> <?= htmlspecialchars($company_mobile); ?><?php endif; ?>
					<?php if(!empty(trim($company_phone))): ?>, <?= htmlspecialchars($company_phone); ?><?php endif; ?>
					<?php if(!empty(trim($company_email))): ?> | <?= htmlspecialchars($company_email); ?><?php endif; ?>
				</div>
			</div>
		</div>

		<!-- Official Pad Divider -->
		<div class="pad-divider"></div>

		<!-- Bill To & Meta Section (Matches PDF Invoice Layout) -->
		<table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 4px;">
			<tr>
				<!-- Left Side: Bill To -->
				<td width="50%" valign="top" style="text-align: left; padding-right: 4px;">
					<div style="font-size: 9px; font-weight: bold; color: #475569; text-transform: uppercase;">BILL TO:</div>
					<div style="font-size: 11px; font-weight: bold; color: #0f172a; line-height: 1.2; word-break: break-word;"><?= htmlspecialchars($customer_name); ?></div>
					<?php if(!empty(trim($customer_mobile))): ?>
						<div style="font-size: 9.5px; color: #334155;">Ph: <?= htmlspecialchars($customer_mobile); ?></div>
					<?php endif; ?>
					<?php if(!empty(trim($customer_address))): ?>
						<div style="font-size: 9px; color: #475569; line-height: 1.2; word-break: break-word;"><?= htmlspecialchars($customer_address); ?></div>
					<?php endif; ?>
				</td>
				<!-- Right Side: Invoice No & Barcode (same width) -->
				<td width="50%" valign="top" style="text-align: right;">
					<div style="display: inline-block; text-align: center; vertical-align: top;">
						<div style="font-size: 11px; font-weight: 800; color: #0f172a; white-space: nowrap; line-height: 1.2;">Inv: <?= htmlspecialchars($sales_code); ?></div>
						<?php if(!empty($pos_barcode_img)): ?>
							<div style="margin: 2px 0; width: 100%;">
								<img src="<?= $pos_barcode_img; ?>" class="pos-barcode-img" style="height: 20px; width: 100%; display: block; object-fit: fill;" alt="Barcode">
							</div>
						<?php endif; ?>
						<div style="font-size: 8.5px; color: #475569; white-space: nowrap;">Date: <?= $sales_date . ' ' . $created_time; ?></div>
						<div style="font-size: 8.5px; color: #0f172a; font-weight: bold; white-space: nowrap;">By: <?= htmlspecialchars(get_user_fullname($res3->created_by ?? 'Admin')); ?></div>
					</div>
				</td>
			</tr>
		</table>

				<table width="100%" cellpadding="0" cellspacing="0"  >
					<thead>
					<tr style="border-top: 1px dashed #334155; border-bottom: 1px dashed #334155;">
						<th style="font-size: 10px; text-align: left; padding: 3px 2px; width: 6%;">#</th>
						<th style="font-size: 10px; text-align: left; padding: 3px 2px;"><?= $this->lang->line('description'); ?></th>
						<th style="font-size: 10px; text-align: center; padding: 3px 2px; width: 14%;"><?= $this->lang->line('quantity'); ?></th>
						<?php if($mrp_column){ ?>
						<th style="font-size: 10px; text-align: right; padding: 3px 2px; width: 14%;"><?= $this->lang->line('mrp'); ?></th>
						<?php  } ?>
						<th style="font-size: 10px; text-align: right; padding: 3px 2px; width: 16%;"><?= $this->lang->line('rate'); ?></th>
						<th style="font-size: 10px; text-align: right; padding: 3px 2px; width: <?= $mrp_column ? '16%' : '20%'; ?>;"><?= $this->lang->line('total'); ?></th>
					</tr>
					</thead>
					<tbody style="border-bottom: 1px dashed #334155;">
						<?php
			              $i=0;
			              $tot_qty=0;
			              $subtotal=0;
			              $tax_amt=0;
			              $this->db->select(" a.description, c.description as item_description, c.mrp, c.item_name, c.custom_barcode, c.item_code, COALESCE(NULLIF(a.warranty_days, 0), c.warranty_days, 0) as warranty_days, a.sales_qty, a.tax_type,
                                  a.price_per_unit, b.tax, b.tax_name, a.tax_amt,
                                  a.discount_input, a.discount_amt, a.unit_total_cost,
                                  a.total_cost, d.unit_name, c.sku, c.hsn
                              ");
			              $this->db->where("a.sales_id",$sales_id);
			              $this->db->from("db_salesitems a");
			              $this->db->join("db_tax b","b.id=a.tax_id","left");
			              $this->db->join("db_items c","c.id=a.item_id","left");
			              $this->db->join("db_units d","d.id = c.unit_id","left");
			              $q2=$this->db->get();
			              foreach ($q2->result() as $res2) {
			                  echo "<tr>";  
			                  echo "<td style='padding: 3px 2px; font-size: 10px;' valign='top'>".++$i."</td>";
			                  echo "<td style='padding: 3px 2px; font-size: 10px; word-break: break-word;'><strong>".htmlspecialchars($res2->item_name)."</strong>";
			                  if(!empty(trim($res2->item_description ?? ''))){
			                      echo "<div style='font-size: 9px; color: #475569; line-height: 1.25; margin-top: 1px;'>".nl2br(htmlspecialchars($res2->item_description))."</div>";
			                  }
			                  if(!empty($res2->description)){
			                      $d = htmlspecialchars($res2->description);
			                      if(stripos($d, 'SN:') === 0){
			                          $d = '<strong>Serial:</strong> ' . substr($d, 3);
			                      }
			                      echo "<div style='font-size: 9px; color: #006837; font-weight: 600; margin-top: 1px;'>".$d."</div>";
			                  }
			                  $w_days = intval($res2->warranty_days ?? 0);
			                  if($w_days > 0){
			                      echo "<div style='font-size: 9px; color: #0284c7; font-weight: 600; margin-top: 1px;'><strong>Warranty:</strong> ".$w_days." Days</div>";
			                  }
			                  echo "</td>";
			                  echo "<td style='text-align: center; padding: 3px 2px; font-size: 10px;' valign='top'>".format_qty($res2->sales_qty)."</td>";
			                  if($mrp_column){
			                  	echo "<td style='text-align: right; padding: 3px 2px; font-size: 10px;' valign='top'>".store_number_format($res2->mrp)."</td>";
			                  }
			                  echo "<td style='text-align: right; padding: 3px 2px; font-size: 10px;' valign='top'>".store_number_format($res2->unit_total_cost)."</td>";
			                  echo "<td style='text-align: right; padding: 3px 2px; font-size: 10px;' valign='top'>".store_number_format($res2->total_cost)."</td>";
			                  echo "</tr>";  
			                  //$tot_qty+=$res2->sales_qty;
			                  $subtotal+=($res2->total_cost);
			                  $tax_amt+=$res2->tax_amt;
			                  $overall_discounted+=$res2->discount_amt;
			              }
			              $before_tax = $subtotal-$tax_amt;
			              ?>
					
				   </tbody>
					<tfoot>
					 <!-- <tr><td colspan="5"><hr></td></tr>    -->
					 <tr >
						<td style=" padding-left: 2px; padding-right: 2px;" colspan="<?=$mrp_column+4?>" align="right"><?= $this->lang->line('before_tax'); ?></td>
						<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= store_number_format($before_tax);?></td>
					</tr>
					
					<!-- Show GST Details -->
					<?php
						if(get_store_details()->pos_invoice_format_id == 1){
							?>
							<tr >
								<td style=" padding-left: 2px; padding-right: 2px;" colspan="<?=$mrp_column+4?>" align="right"><?= $this->lang->line('tax_amount'); ?></td>
								<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= store_number_format($tax_amt);?></td>
							</tr>
							
							<?php
						}
						else{
						$this->db->select(" 
                                b.tax,
                                b.tax_name,
                                COALESCE(SUM(a.tax_amt),0) AS sum_of_tax_amt,
                                c.tax_type
                             ");
            $this->db->where("a.sales_id",$sales_id);
            $this->db->from("db_salesitems a");
            $this->db->join("db_tax b","b.id=a.tax_id","left");
            $this->db->join("db_items c","c.id=a.item_id","left");
            $this->db->group_by("a.tax_id");
            $q5=$this->db->get();

            if($q5->num_rows()>0){
            	foreach($q5->result() as $row){
            			$tax_per = $row->tax;
            			$sum_of_tax_amt = $row->sum_of_tax_amt;

            		if( $customer_delete_bit==1 || (strtoupper($customer_state) == strtoupper($company_state))){
            				
                    $sgst_per = $cgst_per = ($tax_per/2)."%";
                    $sgst_amt = $cgst_amt = $sum_of_tax_amt / 2;
                    $igst_per = $igst_amt = '';
                    ?>
                    	<tr>
												<td style=" padding-left: 2px; padding-right: 2px;" colspan="<?=$mrp_column+4?>" align="right">
													<?= $this->lang->line('cgst'); ?> 
													<?= $sgst_per ?>
													</td>
												<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= store_number_format($cgst_amt); ?></td>
											</tr>
											<tr>
												<td style=" padding-left: 2px; padding-right: 2px;" colspan="<?=$mrp_column+4?>" align="right">
													<?= $this->lang->line('sgst'); ?> 
													<?= $cgst_per ?>
													</td>
												<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= store_number_format($sgst_amt); ?></td>
											</tr>

                    <?php
                  }else{
                    $sgst_per = $cgst_per = '';
                    $sgst_amt = $cgst_amt = '';
                    $igst_per = $tax_per."%";
                    $igst_amt = $sum_of_tax_amt;

                    ?>
                    	<tr>
												<td style=" padding-left: 2px; padding-right: 2px;" colspan="<?=$mrp_column+4?>" align="right">
													<?= $this->lang->line('igst'); ?> 
													<?= $igst_per ?>
													</td>
												<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= store_number_format($igst_amt); ?></td>
											</tr>
                    <?php

                  }


            		?>
            			
            		<?php
            	}
            }
            else{

            }

          }//pos_invoice_format_id else
					?>
					<!-- End -->
					<!-- <tr >
						<td style=" padding-left: 2px; padding-right: 2px;" colspan="<?=$mrp_column+4?>" align="right"><?= $this->lang->line('subtotal'); ?></td>
						<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= store_number_format($subtotal);?></td>
					</tr> -->
					<!-- <tr>
	                     <td style=' padding-left: 2px; padding-right: 2px;' colspan='<?=$mrp_column+4?>' align='right'>Tax Amt</td>
	                      <td style=' padding-left: 2px; padding-right: 2px;' align='right'><?= store_number_format($tax_amt);?></td>
	                </tr> -->
	        <?php if(!empty($coupon_code)) {?>
					<tr>
						<td style=" padding-left: 2px; padding-right: 2px;" colspan="<?=$mrp_column+4?>" align="right"><?= $this->lang->line('couponDiscount'); ?> <?= ($coupon_type=='Percentage') ? $coupon_value .'%' : '[Fixed]' ;?></td>
						<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= store_number_format($coupon_amt); ?></td>
					</tr>
					<?php } ?>

	        <?php if(!empty($tot_discount_to_all_amt) && $tot_discount_to_all_amt!=0) {?>
					<tr>
						<td style=" padding-left: 2px; padding-right: 2px;" colspan="<?=$mrp_column+4?>" align="right"><?= $this->lang->line('discount'); ?> <?= ($discount_to_all_type=='in_percentage') ? $discount_to_all_input .'%' : '[Fixed]' ;?></td>
						<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= store_number_format($tot_discount_to_all_amt); ?></td>
					</tr>
					<?php } ?>
					

					<!-- <tr><td style="border-bottom-style: dashed;border-width: 0.1px;" colspan="5"></td></tr>   -->

					

					<tr>
						<td style=" padding-left: 2px; padding-right: 2px;" colspan="<?=$mrp_column+4?>" align="right"><?= $this->lang->line('total'); ?></td>
						<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= store_number_format($grand_total); ?></td>
					</tr>
					<tr>
						<td style=" padding-left: 2px; padding-right: 2px;" colspan="<?=$mrp_column+4?>" align="right"><?= $this->lang->line('tot_discounted_amt'); ?></td>
						<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= store_number_format($overall_discounted); ?></td>
					</tr>
					
					<!-- change_return_status -->
					<?php if(change_return_status()) {
						$change_return_amount = get_change_return_amount($sales_id); ?>
						<tr>
							<td style=" padding-left: 2px; padding-right: 2px;" colspan="<?=$mrp_column+4?>" align="right"><?= $this->lang->line('paid_amount'); ?></td>
							<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= store_number_format($paid_amount+$change_return_amount); ?></td>
						</tr>
						<tr>
							<td style=" padding-left: 2px; padding-right: 2px;" colspan="<?=$mrp_column+4?>" align="right"><?= $this->lang->line('refund'); ?></td>
							<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= store_number_format($change_return_amount); ?></td>
						</tr>
					<?php }
					else{ ?>
						<tr>
						<td style=" padding-left: 2px; padding-right: 2px;" colspan="<?=$mrp_column+4?>" align="right"><?= $this->lang->line('paid_amount'); ?></td>
						<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= store_number_format($paid_amount); ?></td>
					</tr>
					
					<?php } ?>

					<?php if($previous_balance_bit==1) {?>
					<tr>
						<td style=" padding-left: 2px; padding-right: 2px;" colspan="<?=$mrp_column+4?>" align="right"><?= $this->lang->line('previous_due'); ?></td>
						<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= store_number_format($previous_due); ?></td>
					</tr>
					<tr>
						<td style=" padding-left: 2px; padding-right: 2px;" colspan="<?=$mrp_column+4?>" align="right"><?= $this->lang->line('total_due_amount'); ?></td>
						<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= store_number_format($total_due); ?></td>
					</tr>
					<?php } ?>
					<?php if(!empty($coupon_code)) {?>
					<tr>
						<td colspan="<?=$mrp_column+5?>" align="left">
							<b><?= $this->lang->line('couponCode'); ?>:</b> <i><?=getTruncatedCCNumber($coupon_code);?></i>
						</td>
					</tr>
					<?php }?>

					<tr>
						<td colspan="<?=$mrp_column+5?>" align="left" style="padding-top: 4px; padding-bottom: 4px; font-size: 11px;">
							<b>IN Word:</b> <i><?= (function_exists('amount_in_words_bd') ? amount_in_words_bd($grand_total, 'Taka') : no_to_words($grand_total)); ?></i>
						</td>
					</tr>

					<tr>
						<td colspan="<?=$mrp_column+5?>" align="left">
							<b><u>Note:</u></b> <i><?=$sales_note;?></i>
						</td>
					</tr>

					

					<tr>
						<td colspan="<?=$mrp_column+5?>" align="left">
							<table style="border:1px solid;border-collapse:collapse;" width="100%" cellpadding="0" cellspacing="0">
								<tr>
									<th style="border:1px solid;text-align:center;font-weight:bold;">#</th>
									<th style="border:1px solid;text-align:center;"><?= $this->lang->line('payment_type'); ?></th>
									<th style="border:1px solid;text-align:center;"><?= $this->lang->line('amount'); ?></th>
								</tr>
								<?php 
                            if(isset($sales_id)){
                              $q4 = $this->db->query("select * from db_salespayments where sales_id=$sales_id");
                              if($q4->num_rows()>0){
                                $i=1;
                                $total_paid = 0;
                                foreach ($q4->result() as $res4) {
                                  echo "<tr>";
                                  echo '<td style="border:1px solid;padding-left:2px;">'.$i++."</td>";
                                  echo '<td style="border:1px solid;padding-left:2px;">';
                                    echo $res4->payment_type;
                                  echo '</td>';
                                  echo '<td style="border:1px solid;text-align: right;padding-right:2px;">'.store_number_format($res4->payment).'</td>';
                                  echo "</tr>";
                                  $total_paid +=$res4->payment;
                                }
                                echo '<tr>';
                                	echo '<td colspan="2" style="border:1px solid;" class="text-center">';
                                			echo $this->lang->line('total');
                                	echo '</td>';
                                	echo '<td class="text-right">';
                                			echo store_number_format($total_paid);
                                	echo '</td>';
                                echo '</tr>';

                                
                              }
                              else{
                                echo "<tr><td colspan='3' class='text-center text-bold'>Unpaid!!</td></tr>";
                              }

                            }
                            else{
                              echo "<tr><td colspan='3' class='text-center text-bold'>Payments Pending!!</td></tr>";
                            }
                          ?>
							
							</table>
						</td>
					</tr>
					
					<?php
						if($t_and_c_status_pos){ ?>
							<tr>
								<td colspan="<?=$mrp_column+5?>" align="left">
									&nbsp;
								</td>
							</tr>
							<tr style='border:1px solid;'>
						<td colspan="<?=$mrp_column+5?>" align="left">
							<b><u><?= $this->lang->line('invoiceTerms'); ?>:</u></b> <i><?=nl2br(get_invoice_terms_for_pos());?></i>
						</td>
					</tr>
						<?php }
					 ?>
					<tr>
						<td colspan="<?=$mrp_column+5?>" style="padding-top: 40px; padding-bottom: 8px;">
							<table width="100%">
								<tr>
									<td width="48%" align="center" style="vertical-align: bottom;">
										<div style="height: 35px;"></div>
										<div style="border-top: 1px dashed #333; font-size: 11px; padding-top: 4px;">Customer Signature</div>
									</td>
									<td width="4%"></td>
									<td width="48%" align="center" style="vertical-align: bottom;">
										<?php if(!empty($pos_signature_img)): ?>
											<div style="height: 35px; line-height: 35px; text-align: center; margin-bottom: 2px;">
												<img src="<?= $pos_signature_img; ?>" style="max-height: 34px; max-width: 110px; vertical-align: bottom; display: inline-block;" alt="Authorized Signature">
											</div>
										<?php else: ?>
											<div style="height: 35px;"></div>
										<?php endif; ?>
										<div style="border-top: 1px dashed #333; font-size: 11px; padding-top: 4px;">Authorized Signature</div>
									</td>
								</tr>
							</table>
						</td>
					</tr>

					<tr>
						<td colspan="<?=$mrp_column+5?>" align="center" style="padding-top: 8px;">----------<?= $this->lang->line('thanks_you_visit_again'); ?>----------</td>
					</tr>

					<tr>
						<td colspan="<?=$mrp_column+5?>" align="center" style="padding-top: 6px;">
							<?php if(!empty($pos_qr_img)): ?>
							<a href="<?= base_url('verify/invoice/' . urlencode($sales_code)); ?>" target="_blank" style="text-decoration:none; display:inline-block;">
								<img src="<?= $pos_qr_img; ?>" style="height: 70px; width: 70px; display: block; margin: 0 auto;" alt="QR Code">
								<div style="font-size: 10px; color: #006837; font-weight: bold; margin-top: 2px;">Scan / Click to Verify</div>
							</a>
							<?php endif; ?>
						</td>
					</tr>

					<tr>
						<td colspan="<?=$mrp_column+5?>" align="center" style="font-size: 11px; color: #444; padding-top: 8px; border-top: 1px dashed #ccc; margin-top: 6px;">
							Software Developed by <b>JAAS BD</b>
						</td>
					</tr>

					</tfoot>
				</table>
	</div> <!-- /.pos-wrapper -->
	<center class="no-print" style="margin: 15px 0 30px 0;">
		<div style="display: inline-flex; gap: 10px;">
			<button type="button" class="btn btn-success btn-sm" onclick="window.print();" title="Print"><i class="fa fa-print"></i> Print</button>
			<?php if(isset($_GET['redirect'])){ ?>
				<a href="<?= base_url().$_GET['redirect'];?>" class="btn btn-danger btn-sm" title="Back"><i class="fa fa-arrow-left"></i> Back</a>
			<?php } ?>
		</div>
	</center>

<script type="text/javascript">
function setPaperMode(mode) {
	var btns = document.querySelectorAll('.paper-btn');
	for (var i = 0; i < btns.length; i++) {
		btns[i].classList.remove('active');
	}

	document.body.classList.remove('mode-58mm', 'mode-80mm', 'mode-a4', 'mode-auto');

	var styleEl = document.getElementById('dynamic_page_style');

	if (mode === '58mm') {
		document.body.classList.add('mode-58mm');
		var el = document.getElementById('btn_paper_58');
		if(el) el.classList.add('active');
		if(styleEl) styleEl.innerHTML = '@media print { @page { size: 58mm auto; margin: 1mm; } body { width: 58mm !important; } }';
		localStorage.setItem('pos_preferred_paper', '58mm');
	} else if (mode === '80mm') {
		document.body.classList.add('mode-80mm');
		var el = document.getElementById('btn_paper_80');
		if(el) el.classList.add('active');
		if(styleEl) styleEl.innerHTML = '@media print { @page { size: 80mm auto; margin: 1.5mm; } body { width: 80mm !important; } }';
		localStorage.setItem('pos_preferred_paper', '80mm');
	} else if (mode === 'a4') {
		document.body.classList.add('mode-a4');
		var el = document.getElementById('btn_paper_a4');
		if(el) el.classList.add('active');
		if(styleEl) styleEl.innerHTML = '@media print { @page { size: A4 portrait; margin: 8mm 10mm; } body { width: 100% !important; } }';
		localStorage.setItem('pos_preferred_paper', 'a4');
	} else {
		// Auto fit
		document.body.classList.add('mode-auto');
		var el = document.getElementById('btn_paper_auto');
		if(el) el.classList.add('active');
		if(styleEl) styleEl.innerHTML = '@media print { @page { size: auto; margin: 0mm; } }';
		localStorage.setItem('pos_preferred_paper', 'auto');
	}
}

// Auto detect URL parameter or saved preference
(function() {
	var urlParams = new URLSearchParams(window.location.search);
	var paramPaper = urlParams.get('paper');
	var savedPaper = localStorage.getItem('pos_preferred_paper');

	if (paramPaper === '58' || paramPaper === '58mm') {
		setPaperMode('58mm');
	} else if (paramPaper === '80' || paramPaper === '80mm') {
		setPaperMode('80mm');
	} else if (paramPaper === 'a4' || paramPaper === 'A4') {
		setPaperMode('a4');
	} else if (savedPaper && savedPaper !== 'auto') {
		setPaperMode(savedPaper);
	} else {
		setPaperMode('auto');
	}
})();
</script>
</body>
</html>