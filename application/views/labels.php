<!DOCTYPE html>
<html>

<head>
<!-- FORM CSS CODE -->
<?php include"comman/code_css.php"; ?>
<!-- </copy> -->  
<style type="text/css">
  #preview_data {
    background: #f4f6f9;
    border: 1px solid #d2d6de;
    border-radius: 6px;
    padding: 15px;
    text-align: center;
    min-height: 120px;
    max-height: 520px;
    overflow-y: auto;
  }
  .labels_outer_wrap {
    width: 100%;
    margin: 0 auto;
    padding: 0;
  }
  .labels_container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 14px;
    width: 100%;
    margin: 0 auto;
    padding: 10px 0;
  }
  .label_item {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    margin: 6px auto;
  }
  .label_border {
    width: 38mm;
    max-width: 38mm;
    height: 24mm;
    max-height: 24mm;
    box-sizing: border-box;
    padding: 0.6mm 1.2mm;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    text-align: center;
    overflow: hidden;
    background: #fff;
    border: 1px dashed #0899a4;
    border-radius: 4px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  }
  .label-header {
    width: 100%;
    max-width: 36mm;
    text-align: center;
    margin: 0 auto;
    line-height: 1;
  }
  .label-store-name {
    font-weight: 900;
    font-size: 11px;
    text-transform: uppercase;
    color: #000;
    line-height: 12.5px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    width: 100%;
    max-width: 36mm;
    margin: 0;
  }
  .label-item-name {
    font-size: 8px;
    font-weight: 600;
    color: #111;
    line-height: 9.5px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    width: 100%;
    max-width: 36mm;
    margin-top: 0.5px;
    margin-bottom: 0;
  }
  .label-barcode-block {
    width: 100%;
    max-width: 36mm;
    text-align: center;
    margin: 0 auto;
    line-height: 0;
  }
  .label-barcode-img {
    height: 29px;
    max-height: 30px;
    width: 95%;
    max-width: 36mm;
    display: block;
    margin: 0 auto;
    image-rendering: -webkit-optimize-contrast;
  }
  .barcode-serial {
    font-family: 'Courier New', Courier, monospace;
    font-weight: bold;
    color: #000;
    line-height: 9.5px;
    margin-top: 1px;
    margin-bottom: 0px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    width: 100%;
    max-width: 36mm;
    text-align: center;
  }
  .label-price {
    font-size: 8.5px;
    line-height: 10px;
    color: #000;
    white-space: nowrap;
    margin: 0;
  }
  .label-price del {
    color: #666;
    font-size: 7.5px;
    text-decoration: line-through;
    margin-right: 2px;
  }
</style>
</head>


<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
 
 
 <?php include"sidebar.php"; ?>
 


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
         <h1>
            <?=$page_title;?>
            <small>Add/Update Sales</small>
         </h1>
         <ol class="breadcrumb">
            <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?=$page_title;?></li>
         </ol>
      </section>

    <!-- Main content -->
     <section class="content">
               <div class="row">
               
                  <!-- right column -->
                  <div class="col-md-12">
                     <!-- Horizontal Form -->
                     
                        <!-- style="background: #68deac;" -->
                        
                        <!-- form start -->
                         <!-- OK START -->
                        <?= form_open('#', array('class' => 'form-horizontal', 'id' => 'labels-form', 'enctype'=>'multipart/form-data', 'method'=>'POST'));?>
                           <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                           <input type="hidden" value='1' id="hidden_rowcount" name="hidden_rowcount">
                           <input type="hidden" value='0' id="hidden_update_rowid" name="hidden_update_rowid">

                           <div class="row">
                              <div class="col-xs-12 ">
                                 
                                    <div class="box box-primary">
                                       <!-- /.box-header -->
                                       <div class="box-body ">
                                        <!-- <div class="form-group">
                                 <label for="label_type" class="col-sm-2 control-label"><?= $this->lang->line('label_settings'); ?><label class="text-danger">*</label></label>
                                 <div class="col-sm-3">
                                       <select class="form-control select2" id="label_type" name="label_type"  style="width: 100%;" onkeyup="shift_cursor(event,'mobile')">
                                          <option value='20'>20 Lables 8"x11"</option>
                                          <option value='30'>30 Lables 8"x11"</option>
                                       </select>
                                   
                                    <span id="customer_id_msg" style="display:none" class="text-danger"></span>
                                 </div>
                                 
                              </div> -->
                              <div class="row">
                              <div class="col-md-12">
                                <!-- Store Code -->
                                <?php $store_id=''; ?>
                                <?php /*if(store_module() && is_admin()) {$this->load->view('store/store_code',array('show_store_select_box'=>true,'store_id'=>$store_id,'label_length'=>'col-sm-2','div_length'=>'col-sm-4')); }else{*/
                                echo "<input type='hidden' name='store_id' id='store_id' value='".get_current_store_id()."'>";
                              /*}*/ ?>
                                <!-- Store Code end -->
                                <!-- Warehouse Code -->
                              <?php
                              
                               /*if(warehouse_module() && warehouse_count()>1) {$this->load->view('warehouse/warehouse_code',array('show_warehouse_select_box'=>true,'warehouse_id'=>
                                get_store_warehouse_id(),'label_length'=>'col-sm-2','div_length'=>'col-sm-3')); }else{
                                echo "<input type='hidden' name='warehouse_id' id='warehouse_id' value='".get_store_warehouse_id()."'>";
                               }*/
                              ?>
                              <!-- Warehouse Code end -->
                              </div>
                            </div>

                                          
                                          
                                            <div class="col-md-8 col-md-offset-2 d-flex justify-content" >
                                              <div class="input-group">
                                                <span class="input-group-addon" title="Select Items"><i class="fa fa-barcode"></i></span>
                                                 <input type="text" class="form-control " placeholder="Item name/Barcode/Itemcode" id="item_search">
                                              </div>
                                            </div>
                                            <br>
                                            <br>
                                          
                                          <style type="text/css">
                                             table.table-bordered > thead > tr > th {
                                             /* border:1px solid black;*/
                                             text-align: center;
                                             }
                                             .table > tbody > tr > td, 
                                             .table > tbody > tr > th, 
                                             .table > tfoot > tr > td, 
                                             .table > tfoot > tr > th, 
                                             .table > thead > tr > td, 
                                             .table > thead > tr > th 
                                             {
                                             padding-left: 2px;
                                             padding-right: 2px;  

                                             }
                                          </style>
                                          <table class="table table-hover table-bordered col-md-10 col-md-offset-1" style="width:83%; margin-bottom: 20px;" id="sales_table">
                                              <thead class="custom_thead">
                                                 <tr class="bg-primary" style="background: linear-gradient(90deg, #0899a4 0%, #0dbec7 100%); color: #fff;">
                                                    <th style="width:30%; text-align:center; vertical-align:middle;"><?= $this->lang->line('item_name'); ?></th>
                                                    <th style="width:18%; text-align:center; vertical-align:middle;">Regular Price (BDT)</th>
                                                    <th style="width:22%; text-align:center; vertical-align:middle;">Offer Price (Optional)</th>
                                                    <th style="width:18%; text-align:center; vertical-align:middle;"><?= $this->lang->line('quantity'); ?></th>
                                                    <th style="width:12%; text-align:center; vertical-align:middle;"><?= $this->lang->line('action'); ?></th>
                                                 </tr>
                                              </thead>
                                              <tbody>
                                                
                                              </tbody>
                                              
                                           </table>
                                          <div class="col-md-6">
                                              <div class="row">
                                                  <div class="col-md-12">
                                                     <div class="form-group">
                                                        <label for="" class="col-sm-4 control-label"><?= $this->lang->line('total_labels'); ?></label>    
                                                        <div class="col-sm-4">
                                                           <label class="control-label total_quantity text-success" style="">0</label>
                                                        </div>
                                                     </div>
                                                  </div>
                                               </div>
                                            </div>
                                       </div>
                                       <!-- /.box-body -->

                                       <!-- /.box-body -->
                                       <div class="box-footer col-sm-12">
                                          <center>
                                           
                                             <div class="col-md-3 col-md-offset-3">
                                                <button type="button" id="preview" class="btn btn-block btn-success payments_modal" title="Preview Labels">Preview</button>
                                             </div>
                                             <div class="col-sm-3"><a href="<?= base_url()?>dashboard">
                                                <button type="button" class="btn btn-block btn-warning" title="Go Dashboard">Close</button>
                                              </a>
                                            </div>
                                          </center>
                                       </div>
                                    </div>
                                 
                                 <!-- /.box -->
                              </div>

                           </div>
                           <div class="row">
                              <div class="col-xs-12">
                                    <div class="box box-info">
                                       <div class="box-header with-border" style="background: #fdfdfd; padding: 10px 15px;">
                                          <div class="row" style="align-items: center;">
                                             <div class="col-md-7 col-sm-7" style="display: flex; align-items: center; gap: 10px;">
                                                <label for="paper_size_select" style="margin-bottom: 0; font-size: 13px; font-weight: 600; white-space: nowrap;"><i class="fa fa-file-text-o"></i> Paper Size:</label>
                                                <select id="paper_size_select" class="form-control input-sm" style="max-width: 260px; font-weight: 600; color: #111;">
                                                   <option value="38x25" selected>38mm x 25mm (Standard Sticker)</option>
                                                   <option value="40x30">40mm x 30mm</option>
                                                   <option value="50x25">50mm x 25mm</option>
                                                   <option value="50x30">50mm x 30mm</option>
                                                   <option value="auto">Auto / Any Size (Printer Dialog)</option>
                                                </select>
                                             </div>
                                             <div class="col-md-5 col-sm-5 text-right">
                                                <button type="button" class="btn btn-primary btn-flat" id="print" style="padding: 6px 24px; font-weight: bold; background: #0899a4; border-color: #0899a4;">
                                                   <i class="fa fa-print"></i> Print Labels
                                                </button>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="box-body" style="padding: 15px;">
                                          <div id="preview_data">
                                             <p class="text-muted" style="margin: 35px 0; font-size: 13px;"><i class="fa fa-info-circle"></i> Add items and click "Preview" to view barcode labels here.</p>
                                          </div>
                                       </div>
                                    </div>
                                 <!-- /.box -->
                              </div>
                           </div>
                           <?= form_close(); ?>
                           <!-- OK END -->
                     
                  </div>
                  <!-- /.box-footer -->
                 
               </div>
               <!-- /.box -->
             </section>
            <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
 <?php include"footer.php"; ?>
<!-- SOUND CODE -->
<?php include"comman/code_js_sound.php"; ?>
<!-- GENERAL CODE -->
<?php include"comman/code_js.php"; ?>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

      <script src="<?php echo $theme_link; ?>js/labels.js"></script>  
      <script>
       
        var base_url=$("#base_url").val();
        $("#store_id").on("change",function(){
          var store_id=$(this).val();
          $.post(base_url+"sales/get_customers_select_list",{store_id:store_id},function(result){
              $("#sales_table > tbody").empty();
              final_total();
          });
        });

         /* ---------- Final Description of amount ------------*/
         function final_total(){
          var rowcount=$("#hidden_rowcount").val();
           var total_quantity=0;
         
           for(i=1;i<=rowcount;i++){
         
             if(document.getElementById("td_data_"+i+"_1")){
               //customer_id must exist
               if($("#td_data_"+i+"_1").val()!=null && $("#td_data_"+i+"_1").val()!=''){
                     
                    total_quantity +=parseInt($("#td_data_"+i+"_3").val());
                }
                   
             }//if end
           }//for end
          //Show total Sales Quantitys
           $(".total_quantity").html(total_quantity);
         }
         /* ---------- Final Description of amount end ------------*/
          
         function removerow(id){//id=Rowid
           
         $("#row_"+id).remove();
         final_total();
         failed.currentTime = 0;
        failed.play();
         }

         /*Print Div*/
         $(document).on("click", "#print", function(event) {
            event.preventDefault();
            var content_vlue = document.getElementById("preview_data").innerHTML;
            if (content_vlue && content_vlue.indexOf("label_item") !== -1) {
               PrintMe("preview_data");
            } else {
               // Auto trigger preview then print
               var rowcount = $("#hidden_rowcount").val();
               if(parseInt(rowcount) <= 1) {
                  toastr["warning"]("Please Select Items from Search List!!");
                  failed.currentTime = 0; 
                  failed.play();
                  return;
               }
               var data = new FormData($('#labels-form')[0]);
               if(!xss_validation(data)){ return false; }

               $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
               $("#print").attr('disabled', true);

               $.ajax({
                  type: 'POST',
                  url: $("#base_url").val() + 'items/preview_labels',
                  data: data,
                  cache: false,
                  contentType: false,
                  processData: false,
                  success: function(result){
                     $("#preview_data").html(result);
                     $("#print").attr('disabled', false);
                     $(".overlay").remove();
                     setTimeout(function() {
                        PrintMe("preview_data");
                     }, 200);
                  },
                  error: function() {
                     $("#print").attr('disabled', false);
                     $(".overlay").remove();
                     toastr["error"]("Failed to load labels preview!");
                  }
               });
            }
         });

         function PrintMe(DivID) {
            var content_vlue = document.getElementById(DivID).innerHTML;
            if (!content_vlue || content_vlue.indexOf("label_item") === -1) {
               toastr["warning"]("Please add items and click Preview before printing!");
               return;
            }

            var paperSize = $("#paper_size_select").val() || "38x25";
            var pageRule = "@page { size: 38mm 25mm; margin: 0mm !important; }";
            if (paperSize === "50x25") {
               pageRule = "@page { size: 50mm 25mm; margin: 0mm !important; }";
            } else if (paperSize === "50x30") {
               pageRule = "@page { size: 50mm 30mm; margin: 0mm !important; }";
            } else if (paperSize === "40x30") {
               pageRule = "@page { size: 40mm 30mm; margin: 0mm !important; }";
            } else if (paperSize === "auto") {
               pageRule = "@page { size: auto; margin: 0mm !important; }";
            }

            var printHtml = '<!DOCTYPE html>' +
               '<html><head><meta charset="utf-8"><title>Print Barcode Labels</title>' +
               '<style type="text/css">' +
               pageRule +
               '* { box-sizing: border-box !important; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; margin: 0; padding: 0; }' +
               'html, body { margin: 0 !important; padding: 0 !important; width: 100% !important; background: #fff !important; font-family: Arial, Helvetica, sans-serif !important; overflow: hidden !important; text-align: center !important; }' +
               '.labels_outer_wrap, .labels_container { width: 100% !important; margin: 0 !important; padding: 0 !important; display: flex !important; flex-direction: column !important; align-items: center !important; }' +
               '.label_item { width: 100% !important; margin: 0 auto !important; padding: 0 !important; display: flex !important; flex-direction: column !important; justify-content: center !important; align-items: center !important; text-align: center !important; page-break-inside: avoid !important; break-inside: avoid !important; box-sizing: border-box !important; overflow: hidden !important; }' +
               '.label_item:not(:last-child) { page-break-after: always !important; break-after: page !important; }' +
               '.label_item:last-child { page-break-after: auto !important; break-after: auto !important; }' +
               '.label_border { width: 38mm !important; max-width: 38mm !important; height: 24mm !important; max-height: 24mm !important; box-sizing: border-box !important; margin: 0.5mm auto !important; padding: 0.6mm 1.2mm !important; display: flex !important; flex-direction: column !important; justify-content: space-between !important; align-items: center !important; text-align: center !important; overflow: hidden !important; background: #fff !important; border: none !important; }' +
               '.label-header { width: 100% !important; max-width: 36mm !important; text-align: center !important; margin: 0 auto !important; line-height: 1 !important; }' +
               '.label-store-name { font-weight: 900 !important; font-size: 11px !important; text-transform: uppercase !important; color: #000 !important; line-height: 12.5px !important; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important; width: 100% !important; max-width: 36mm !important; text-align: center !important; margin: 0 !important; }' +
               '.label-item-name { font-size: 8px !important; font-weight: 600 !important; color: #000 !important; line-height: 9.5px !important; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important; width: 100% !important; max-width: 36mm !important; text-align: center !important; margin-top: 0.5px !important; margin-bottom: 0 !important; }' +
               '.label-barcode-block { width: 100% !important; max-width: 36mm !important; text-align: center !important; margin: 0 auto !important; line-height: 0 !important; }' +
               '.label-barcode-img { height: 29px !important; max-height: 30px !important; width: 95% !important; max-width: 36mm !important; display: block !important; margin: 0 auto !important; image-rendering: -webkit-optimize-contrast !important; }' +
               '.barcode-serial { font-family: "Courier New", Courier, monospace !important; font-weight: bold !important; color: #000 !important; line-height: 9.5px !important; margin-top: 1px !important; margin-bottom: 0px !important; white-space: nowrap !important; overflow: hidden !important; text-overflow: ellipsis !important; width: 100% !important; max-width: 36mm !important; text-align: center !important; }' +
               '.label-price { font-size: 8.5px !important; line-height: 10px !important; color: #000 !important; white-space: nowrap !important; text-align: center !important; margin: 0 !important; }' +
               'del { text-decoration: line-through !important; color: #444 !important; font-size: 7.5px !important; margin-right: 2px !important; }' +
               '</style></head>' +
               '<body>' + content_vlue + '</body></html>';

            // Hidden iframe approach (never blocked by browser popup blocker)
            var printFrame = document.getElementById("label_print_frame");
            if (printFrame) {
               try { printFrame.remove(); } catch(e){}
            }
            printFrame = document.createElement("iframe");
            printFrame.id = "label_print_frame";
            printFrame.style.position = "fixed";
            printFrame.style.right = "0";
            printFrame.style.bottom = "0";
            printFrame.style.width = "0";
            printFrame.style.height = "0";
            printFrame.style.border = "none";
            printFrame.style.zIndex = "-999";
            document.body.appendChild(printFrame);

            var frameDoc = printFrame.contentWindow || printFrame.contentDocument;
            if (frameDoc.document) frameDoc = frameDoc.document;

            try {
               frameDoc.open();
               frameDoc.write(printHtml);
               frameDoc.close();
               setTimeout(function() {
                  try {
                     printFrame.contentWindow.focus();
                     printFrame.contentWindow.print();
                  } catch (err) {
                     fallbackPopupPrint(printHtml);
                  }
               }, 350);
            } catch (err2) {
               fallbackPopupPrint(printHtml);
            }
         }

         function fallbackPopupPrint(html) {
            var disp_setting = "toolbar=yes,location=no,directories=yes,menubar=yes,scrollbars=yes,width=850,height=650,left=100,top=25";
            var docprint = window.open("", "", disp_setting);
            if (!docprint) {
               alert("Please allow popups in your browser to print labels!");
               return;
            }
            docprint.document.open();
            docprint.document.write(html);
            docprint.document.close();
            docprint.focus();
            setTimeout(function() {
               docprint.print();
            }, 350);
         }
         function OldPrintMe(DivID) {
            var disp_setting="toolbar=yes,location=no,";
            disp_setting+="directories=yes,menubar=yes,";
            disp_setting+="scrollbars=yes,width=800, height=600, left=100, top=25";
               var content_vlue = document.getElementById(DivID).innerHTML;
               var docprint=window.open("","",disp_setting);
               docprint.document.open();
               docprint.document.write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"');
               docprint.document.write('"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">');
               docprint.document.write('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">');
               docprint.document.write('<head><title>My Title</title>');
               docprint.document.write('<style type="text/css">body{ margin:0px;');
               docprint.document.write('font-family:verdana,Arial;color:#000;');
               docprint.document.write('font-family:Verdana, Geneva, sans-serif; font-size:12px;}');
               docprint.document.write('a{color:#000;text-decoration:none;} </style>');
               docprint.document.write('</head><body onLoad="self.print()">');
               docprint.document.write(content_vlue);
               docprint.document.write('</body></html>');
               docprint.document.close();
               docprint.focus();
            }
      </script>
      <!-- Purchase List Barcode -->
      <script type="text/javascript">
        jQuery(document).ready(function($) {
          <?php
          if(isset($purchase_id)){ ?>
               $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
              var base_url=$("#base_url").val();
              var rowcount=$("#hidden_rowcount").val();
              $.post(base_url+"items/show_labels/"+<?=$purchase_id;?>,{},function(result){
                    $('#sales_table tbody').append(result);
                    $("#hidden_rowcount").val($('#sales_table tbody tr').length+1);
                    $("#preview").trigger('click');
                    success.currentTime = 0;
                    success.play();
                    final_total();
                    $(".overlay").remove();
                });
          <?php }
          ?>  
        });
      </script>
      <!-- Purchase List Barcode end-->
      <!-- Make sidebar menu hughlighter/selector -->
      <script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
</body>
</html>
