<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?= $page_title;?> - Quotation</title>
<link rel='shortcut icon' href='<?php echo $theme_link; ?>images/favicon.ico' />

<style>
@page {
    size: A4 portrait;
    margin: 6mm 10mm 6mm 10mm;
}
* {
    box-sizing: border-box;
    -webkit-print-color-adjust: exact !important;
    print-color-adjust: exact !important;
}
html, body {
    margin: 0;
    padding: 0;
    background: #fff;
    color: #000;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 10.5px;
    line-height: 1.2;
}
body {
    margin: 6mm 10mm 6mm 10mm;
}
.page-title {
    text-align: center;
    font-size: 16px;
    font-weight: bold;
    color: #0070C0;
    text-transform: uppercase;
    margin: 2px 0 4px 0;
    letter-spacing: 1px;
}
#mytable {
    width: 100%;
    border-collapse: collapse;
    border: 0.5pt solid #0070C0;
    table-layout: fixed;
    margin: 0 auto;
}
#mytable th, #mytable td {
    border: 0.5pt solid #0070C0;
    padding: 2px 4px;
    vertical-align: middle;
    font-size: 10px;
    line-height: 1.2;
}
.header-inner-table {
    width: 100%;
    border-collapse: collapse;
    border: none !important;
}
.header-inner-table td, .header-inner-table th {
    border: none !important;
    padding: 1px 3px !important;
    vertical-align: top;
    font-size: 10px;
    line-height: 1.2;
}
.style_hidden {
    border: none !important;
    border-style: hidden !important;
}
.fixed_table {
    table-layout: fixed;
}
.text-center { text-align: center; }
.text-left { text-align: left; }
.text-right { text-align: right; }
.text-bold { font-weight: bold; }
.bg-sky {
    background-color: #E8F3FD !important;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
}
.amt-in-word {
    font-size: 10px;
    line-height: 1.25;
}
.item-row td {
    padding: 2px 4px !important;
    height: auto !important;
    vertical-align: middle !important;
}
.footer-caption {
    text-align: center;
    font-size: 9.5px;
    text-transform: uppercase;
    margin-top: 4px;
    color: #555;
}
@media print {
    html, body {
        width: 100%;
        height: auto !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    #mytable {
        page-break-inside: avoid !important;
        page-break-after: avoid !important;
        height: auto !important;
    }
    tr {
        page-break-inside: avoid !important;
    }
}
</style>
</head>
<body onload="window.print();">
<?php
    $q1=$this->db->query("select * from db_store where status=1 and id=".get_current_store_id());
    $res1=$q1->row();
    $store_name=$res1->store_name;
    $company_mobile=$res1->mobile;
    $company_phone=$res1->phone;
    $company_email=$res1->email;
    $company_country=$res1->country;
    $company_state=$res1->state;
    $company_city=$res1->city;
    $company_address=$res1->address;
    $company_gst_no=$res1->gst_no;
    $company_vat_no=$res1->vat_no;
    $store_logo=(!empty($res1->store_logo)) ? $res1->store_logo : store_demo_logo();
    $store_website=$res1->store_website;
    $bank_details=$res1->bank_details;
    $upi_id=$res1->upi_id;
    $sales_invoice_footer_text=(isset($res1->sales_invoice_footer_text)) ? $res1->sales_invoice_footer_text : '';

    // Convert logo to base64 if local file exists (ensures Dompdf renders it reliably without HTTP request)
    $logo_src = base_url($store_logo);
    if(!empty($store_logo) && file_exists(FCPATH . $store_logo)) {
        $logo_type = pathinfo(FCPATH . $store_logo, PATHINFO_EXTENSION);
        $logo_data = @file_get_contents(FCPATH . $store_logo);
        if($logo_data !== false) {
            $logo_src = 'data:image/' . $logo_type . ';base64,' . base64_encode($logo_data);
        }
    }

    // Signature
    $show_signature = (!empty($res1->show_signature)) ? $res1->show_signature : 0;
    $image_file = ($show_signature && !empty($res1->signature)) ? $res1->signature : '';
    $signature_src = '';
    if(!empty($image_file) && file_exists(FCPATH . $image_file)) {
        $sig_type = pathinfo(FCPATH . $image_file, PATHINFO_EXTENSION);
        $sig_data = @file_get_contents(FCPATH . $image_file);
        if($sig_data !== false) {
            $signature_src = 'data:image/' . $sig_type . ';base64,' . base64_encode($sig_data);
        } else {
            $signature_src = base_url($image_file);
        }
    } else if(!empty($image_file)) {
        $signature_src = base_url($image_file);
    }
    
    $q3=$this->db->query("SELECT b.expire_date,b.customer_previous_due,b.customer_total_due,a.customer_name,a.mobile,a.phone,a.gstin,a.tax_number,a.email,a.shippingaddress_id,
                           a.opening_balance,a.country_id,a.state_id,a.created_by,
                           a.postcode,a.address,b.quotation_date,b.created_time,b.reference_no,
                           b.quotation_code,b.quotation_note,b.quotation_terms,b.quotation_status,
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
                           db_quotation b 
                           WHERE 
                           a.`id`=b.`customer_id` AND 
                           b.`id`='$quotation_id' 
                           ");
                         
    
    $res3=$q3->row();
    $customer_name=$res3->customer_name;
    $customer_mobile=$res3->mobile;
    $customer_phone=$res3->phone;
    $customer_email=$res3->email;
    $customer_country=(!empty($res3->country_id)) ? get_country($res3->country_id) : '';
    $customer_state=(!empty($res3->state_id)) ? get_state($res3->state_id) : '';
    $customer_address=$res3->address;
    $customer_postcode=$res3->postcode;
    $customer_gst_no=$res3->gstin;
    $customer_tax_number=$res3->tax_number;
    $customer_opening_balance=$res3->opening_balance;
    $quotation_date=$res3->quotation_date;
    $expire_date=(!empty($res3->expire_date)) ? show_date($res3->expire_date) : '';
    $created_time=$res3->created_time;
    $reference_no=$res3->reference_no;
    $quotation_code=$res3->quotation_code;
    $quotation_note=$res3->quotation_note;
    $quotation_terms=(!empty($res3->quotation_terms)) ? $res3->quotation_terms : (!empty($res1->invoice_terms) ? $res1->invoice_terms : '');
    $quotation_status=$res3->quotation_status;
    $created_by=$res3->created_by;
    $previous_due=$res3->customer_previous_due;
    $total_due=$res3->customer_total_due;

    $subtotal=$res3->subtotal;
    $grand_total=$res3->grand_total;
    $other_charges_input=$res3->other_charges_input;
    $other_charges_tax_id=$res3->other_charges_tax_id;
    $other_charges_amt=$res3->other_charges_amt;
    $paid_amount=$res3->paid_amount;
    $discount_to_all_input=$res3->discount_to_all_input;
    $discount_to_all_type=$res3->discount_to_all_type;
    $discount_to_all_type = ($discount_to_all_type=='in_percentage') ? '%' : 'Fixed';
    $tot_discount_to_all_amt=$res3->tot_discount_to_all_amt;
    $round_off=$res3->round_off;
    $payment_status=$res3->payment_status;
    
    $shipping_country='';
    $shipping_state='';
    $shipping_city='';
    $shipping_address='';
    $shipping_postcode='';
    if(!empty($res3->shippingaddress_id)){
        $Q2 = $this->db->select("c.country,s.state,a.city,a.postcode,a.address")
                        ->where("a.id",$res3->shippingaddress_id)
                        ->from("db_shippingaddress a")
                        ->join("db_country c","c.id = a.country_id",'left')
                        ->join("db_states s","s.id = a.state_id",'left')
                        ->get();                    
        if($Q2->num_rows()>0){
          $shipping_country=$Q2->row()->country;
          $shipping_state=$Q2->row()->state;
          $shipping_city=$Q2->row()->city;
          $shipping_address=$Q2->row()->address;
          $shipping_postcode=$Q2->row()->postcode;
        }
    }
?>

<div class="page-title"><?= $this->lang->line('quotation'); ?></div>

<table id='mytable' align="center" width="100%" cellpadding="0" cellspacing="0">
    <thead>
      <tr>
        <th colspan="16" style="padding: 0; border-bottom: 0.5pt solid #0070C0;">
          <table class="header-inner-table fixed_table">
              <tr>
                <!-- First Half: Store Details -->
                <td colspan="4" style="vertical-align: middle; text-align: center; padding: 4px !important;">
                  <img src="<?= $logo_src; ?>" style="max-width: 130px; max-height: 65px; width: auto; height: auto;">
                </td>

                <td colspan="4" style="padding: 4px !important;">
                  <b style="font-size: 12px; color: #111;"><?php echo $store_name; ?></b><br/>
                  <span style="font-size: 9.5px; color: #333;">
                    <?php echo $company_address; ?><br/>
                    <?php echo $this->lang->line('mob.').": ".$company_mobile; ?><br/>
                    <?php echo (!empty($company_email) && trim($company_email) != '') ? $this->lang->line('email').": ".$company_email."<br>" : '';?>
                    <?php echo (!empty($company_gst_no) && trim($company_gst_no) != '') ? $this->lang->line('gst_number').": ".$company_gst_no."<br>" : '';?>
                    <?php echo (!empty($company_vat_no) && trim($company_vat_no) != '') ? $this->lang->line('tax_number').": ".$company_vat_no."<br>" : '';?>
                  </span>
                </td>

                <!-- Second Half: Quotation Details -->
                <td colspan="8" style="padding: 4px !important;">
                  <table class="header-inner-table fixed_table">
                        <tr>
                          <td colspan="8" style="padding: 0 0 2px 0 !important;">
                            <span style="font-size: 9.5px; color: #555;"><?= $this->lang->line('quotation'); ?> No.</span><br>
                            <span style="font-size: 16px; font-weight: bold; color: #0070C0;">
                              <?php echo "$quotation_code"; ?>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="4" style="padding: 1px 0 !important;">
                            <span style="color: #555;"><?= $this->lang->line('quotation_date'); ?>:</span> 
                            <b><?php echo show_date($quotation_date); ?></b>
                          </td>
                          <td colspan="4" style="padding: 1px 0 !important;">
                            <span style="color: #555;"><?= $this->lang->line('expire_date'); ?>:</span> 
                            <b><?= (!empty($expire_date)) ? $expire_date : '-'; ?></b>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="8" style="padding: 1px 0 !important;">
                            <span style="color: #555;"><?= $this->lang->line('reference_no'); ?>:</span> 
                            <b><?= (!empty($reference_no)) ? $reference_no : '-'; ?></b>
                          </td>
                        </tr>
                        <?php if(!empty($bank_details)) { ?>
                        <tr>
                          <td colspan="8" style="padding: 1px 0 !important;">
                            <span><b><?= $this->lang->line('bank_details'); ?>:</b> <?= nl2br($bank_details); ?></span>
                          </td>
                        </tr>
                        <?php } ?>
                        <?php if(!empty($upi_id)) { ?>
                        <tr>
                          <td colspan="8" style="padding: 1px 0 !important;">
                            <span><b><?= $this->lang->line('pay_by_upi'); ?>:</b> <?= $upi_id; ?></span>
                          </td>
                        </tr>
                        <?php } ?>
                  </table>
                </td>
              </tr>

              <tr>
                <!-- Bottom Half: Customer & Shipping Address -->
                <td colspan="8" style="padding: 4px !important; border-top: 0.5pt solid #0070C0 !important;">
                  <b><?= $this->lang->line('customer_address'); ?></b><br/>
                  <span style="font-size: 9.5px;">
                      <?php echo $this->lang->line('name').": <b>".$customer_name."</b>"; ?><br/>
                      <?php echo (!empty($customer_mobile) && trim($customer_mobile) != '') ? $this->lang->line('mobile').": ".$customer_mobile."<br>" : '';?>
                      <?php 
                        if(!empty($customer_address)){
                          echo $customer_address;
                        }
                        if(!empty($customer_country)){
                          echo ", ".$customer_country;
                        }
                        if(!empty($customer_state)){
                          echo ", ".$customer_state;
                        }
                        if(!empty($customer_city)){
                          echo ", ".$customer_city;
                        }
                        if(!empty($customer_postcode)){
                          echo " - ".$customer_postcode;
                        }
                      ?>
                      <?php echo (!empty($customer_email) && trim($customer_email) != '') ? "<br>".$this->lang->line('email').": ".$customer_email : '';?>
                      <?php echo (!empty($customer_gst_no) && trim($customer_gst_no) != '') ? "<br>".$this->lang->line('gst_number').": ".$customer_gst_no : '';?>
                  </span>
                </td>

                <td colspan="8" style="padding: 4px !important; border-top: 0.5pt solid #0070C0 !important; border-left: 0.5pt solid #0070C0 !important;">
                  <b><?= $this->lang->line('shipping_address'); ?></b><br/>
                  <span style="font-size: 9.5px;">
                      <?php echo $this->lang->line('name').": <b>".$customer_name."</b>"; ?><br/>
                      <?php echo (!empty($customer_mobile) && trim($customer_mobile) != '') ? $this->lang->line('mobile').": ".$customer_mobile."<br>" : '';?>
                      <?php 
                        echo $this->lang->line('address').": ".(!empty($shipping_address) ? $shipping_address : '-');
                        if(!empty($shipping_country)){
                          echo ", ".$shipping_country;
                        }
                        if(!empty($shipping_state)){
                          echo ", ".$shipping_state;
                        }
                        if(!empty($shipping_city)){
                          echo ", ".$shipping_city;
                        }
                        if(!empty($shipping_postcode)){
                          echo " - ".$shipping_postcode;
                        }
                      ?>
                  </span>
                </td>
              </tr>
          </table>
        </th>
      </tr>

      <tr class="bg-sky">
        <th colspan='2' class="text-center" style="width: 5%;"><?= $this->lang->line('sl_no'); ?></th>
        <th colspan='4' class="text-center" style="width: 35%;"><?= $this->lang->line('description_of_goods'); ?></th>
        <th colspan='2' class="text-center" style="width: 12%;"><?= $this->lang->line('hsn'); ?></th>
        <th colspan='2' class="text-center" style="width: 12%;"><?= $this->lang->line('unit_cost'); ?></th>
        <th colspan='1' class="text-center" style="width: 8%;"><?= $this->lang->line('qty'); ?></th>
        <th colspan='1' class="text-center" style="width: 7%;"><?= $this->lang->line('tax'); ?></th>
        <th colspan='1' class="text-center" style="width: 7%;"><?= $this->lang->line('tax_amt'); ?></th>
        <th colspan='1' class="text-center" style="width: 6%;"><?= $this->lang->line('disc.'); ?></th>
        <th colspan='2' class="text-center" style="width: 8%;"><?= $this->lang->line('amount'); ?></th>
      </tr>
  </thead>

  <tbody>
 <?php
              $i=1;
              $tot_qty=0;
              $tot_quotation_price=0;
              $tot_tax_amt=0;
              $tot_discount_amt=0;
              $tot_unit_total_cost=0;
              $tot_total_cost=0;
              $tot_before_tax=0;
              
              $tot_price_per_unit=0;
              $sum_of_tot_price=0;

              $this->db->select(" a.description,c.item_name, a.quotation_qty,a.tax_type,
                                  a.price_per_unit, b.tax,b.tax_name,a.tax_amt,
                                  a.discount_input,a.discount_amt, a.unit_total_cost,
                                  a.total_cost, d.unit_name,c.sku,c.hsn
                              ");
              $this->db->where("a.quotation_id",$quotation_id);
              $this->db->from("db_quotationitems a");
              $this->db->join("db_tax b","b.id=a.tax_id","left");
              $this->db->join("db_items c","c.id=a.item_id","left");
              $this->db->join("db_units d","d.id = c.unit_id","left");
              $q2=$this->db->get();

              foreach ($q2->result() as $res2) {
                  $discount = (empty($res2->discount_input)||$res2->discount_input==0)? '0':$res2->discount_input."%";
                  $discount_amt = (empty($res2->discount_amt)||$res2->discount_input==0)? '0':$res2->discount_amt."";
                  $before_tax=$res2->unit_total_cost;
                  $tot_cost_before_tax=$before_tax * $res2->quotation_qty;

                  $price_per_unit = $res2->price_per_unit;
                  if($res2->tax_type=='Inclusive'){
                    $price_per_unit -= ($res2->tax_amt/$res2->quotation_qty);
                  }

                  $tot_price = $price_per_unit * $res2->quotation_qty;

                  echo "<tr class='item-row'>";  
                  echo "<td colspan='2' class='text-center'>".$i++."</td>";
                  echo "<td colspan='4'>";
                  echo "<b>".$res2->item_name."</b>";
                  echo (!empty($res2->description)) ? "<br><i style='font-size: 9px; line-height: 1.1;'>[".nl2br($res2->description)."]</i>" : '';
                  echo "</td>";
                  echo "<td colspan='2' class='text-left'>".(!empty($res2->hsn) ? $res2->hsn : '-')."</td>";
                  echo "<td colspan='2' class='text-right'>".store_number_format($price_per_unit)."</td>";
                  
                  echo "<td class='text-center'>".format_qty($res2->quotation_qty)."</td>";
                  echo "<td colspan='1' class='text-right'>".store_number_format($res2->tax ?? 0)."%</td>";
                  echo "<td style='text-align: right;'>".store_number_format($res2->tax_amt ?? 0)."</td>";
                  echo "<td style='text-align: right;'>".store_number_format($discount_amt ?? 0)."</td>";
 
                  echo "<td colspan='2' class='text-right'>".store_number_format($res2->total_cost)."</td>";
                  echo "</tr>";  
                  $tot_qty +=$res2->quotation_qty;
                  $tot_tax_amt +=$res2->tax_amt;
                  $tot_discount_amt +=$res2->discount_amt;
                  $tot_unit_total_cost +=$res2->unit_total_cost;
                  $tot_before_tax +=$before_tax;
                  $tot_total_cost +=$res2->total_cost;

                  $tot_price_per_unit +=$price_per_unit;
                  $sum_of_tot_price +=$tot_price;
              }
              ?>
  </tbody>

  <tfoot>
    <tr class="bg-sky">
      <td colspan="8" class='text-center text-bold'><?= $this->lang->line('total'); ?></td>
      <td colspan="2" class='text-right'><b><?php echo store_number_format($tot_price_per_unit); ?></b></td>
      <td colspan="1" class='text-bold text-center'><?=format_qty($tot_qty); ?></td>
      <td colspan="1" class='text-bold text-center'></td>
      <td colspan="1" class='text-right'><b><?php echo store_number_format($tot_tax_amt); ?></b></td>
      <td colspan="1" class='text-right'><b><?php echo store_number_format($tot_discount_amt); ?></b></td>
      <td colspan="2" class='text-right'><b><?php echo store_number_format($tot_total_cost); ?></b></td>
    </tr>
    <tr>
      <td colspan="14" class='text-right'><b><?= $this->lang->line('subtotal'); ?></b></td>
      <td colspan="2" class='text-right'><b><?php echo store_number_format($tot_total_cost); ?></b></td>
    </tr>

    <?php if(!empty($other_charges_amt) && $other_charges_amt > 0) { ?>
    <tr>
      <td colspan="14" class='text-right'><b><?= $this->lang->line('other_charges'); ?></b></td>
      <td colspan="2" class='text-right'><b><?php echo store_number_format($other_charges_amt); ?></b></td>
    </tr>
    <?php } ?>
    
    <?php if(!empty($tot_discount_to_all_amt) && $tot_discount_to_all_amt > 0) { ?>
    <tr>
      <td colspan="14" class='text-right'><b><?= $this->lang->line('discount_on_all'); ?>(<?= store_number_format($discount_to_all_input)." ".$discount_to_all_type; ?>)</b></td>
      <td colspan="2" class='text-right'><b><?php echo store_number_format($tot_discount_to_all_amt); ?></b></td>
    </tr>
    <?php } ?>

    <?php if(is_enabled_round_off() && !empty($round_off) && $round_off != 0) { ?>
    <tr>
      <td colspan="14" class='text-right'><b><?= $this->lang->line('round_off'); ?></b></td>
      <td colspan="2" class='text-right'><b><?php echo store_number_format($round_off); ?></b></td>
    </tr>
    <?php } ?>

    <tr>
      <td colspan="14" class='text-right'><b><?= $this->lang->line('grand_total'); ?></b></td>
      <td colspan="2" class='text-right'><b><?php echo store_number_format($grand_total); ?></b></td>
    </tr>

    <tr>
      <td colspan="16" style="padding: 3px 5px;">
        <span class='amt-in-word'><?= $this->lang->line('amount_in_words'); ?>: 
          <i style='font-weight:bold;'><?=$this->session->userdata('currency_code')." ".no_to_words($grand_total ?? 0)?></i>
        </span>  
      </td>
    </tr>

    <?php if(!empty($quotation_note)) { ?>
    <tr>
      <td colspan="16" style="padding: 3px 5px;">
        <span class='amt-in-word'>
          <b><?= $this->lang->line('note') .":</b> ". nl2br(htmlspecialchars($quotation_note));?>
        </span>  
      </td>
    </tr>
    <?php } ?>

    <?php if(!empty($quotation_terms)) { ?>
    <tr>
      <td colspan="16" style="padding: 3px 5px;">
        <span class='amt-in-word'>
          <b><?= $this->lang->line('terms_and_conditions') .":</b><br>". nl2br(html_entity_decode($quotation_terms));?>
        </span>  
      </td>
    </tr>
    <?php } ?>

    <!-- Signatures -->
    <tr>
      <td colspan="16" style="padding: 6px 4px 4px 4px;">
        <table width="100%" class="header-inner-table fixed_table" style="border: none;">
          <tr>
            <!-- Customer Signature on the left -->
            <td style="width: 50%; text-align: left; vertical-align: bottom; border: none; padding-left: 20px !important;">
              <table style="width: 150px; border: none;" class="header-inner-table">
                <tr>
                  <td style="text-align: center; height: 35px; vertical-align: bottom; border: none; padding: 0 0 2px 0 !important;">
                    &nbsp;
                  </td>
                </tr>
                <tr>
                  <td style="text-align: center; border-top: 1px dotted #444 !important; padding-top: 2px !important; border-left: none; border-right: none; border-bottom: none; font-size: 9.5px;">
                    <b><?= $this->lang->line('customer_signature'); ?></b>
                  </td>
                </tr>
              </table>
            </td>

            <!-- Authorised Signatory on the right with upload signature -->
            <td style="width: 50%; text-align: right; vertical-align: bottom; border: none; padding-right: 20px !important;">
              <table style="width: 150px; margin-left: auto; border: none;" class="header-inner-table">
                <tr>
                  <td style="text-align: center; height: 35px; vertical-align: bottom; border: none; padding: 0 0 2px 0 !important;">
                    <?php if(!empty($signature_src)) { ?>
                      <img src="<?= $signature_src; ?>" style="max-height: 38px; max-width: 130px; height: auto; width: auto; display: inline-block; vertical-align: bottom;" alt="Signature">
                    <?php } else { ?>
                      &nbsp;
                    <?php } ?>
                  </td>
                </tr>
                <tr>
                  <td style="text-align: center; border-top: 1px dotted #444 !important; padding-top: 2px !important; border-left: none; border-right: none; border-bottom: none; font-size: 9.5px;">
                    <b><?= $this->lang->line('authorised_signatory'); ?></b>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <!-- Signatures End -->

    <?php if(!empty($sales_invoice_footer_text)) {?>
    <tr>
      <td colspan="16" style="text-align: center; font-size: 8px; padding: 2px 4px;">
        <?= $sales_invoice_footer_text; ?>
      </td>
    </tr>
    <?php } ?>
  </tfoot>
</table>

<div class="footer-caption">
  This is Computer Generated Quotation
</div>
</body>
</html>
