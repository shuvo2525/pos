<!DOCTYPE html>
<html>
   <head>
      <!-- FORM CSS CODE -->
      <?php include"comman/code_css.php"; ?>
      <!-- </copy> -->  
   </head>
   <body class="hold-transition skin-blue sidebar-mini">
      <div class="wrapper">
         <?php include"sidebar.php"; ?>
         <?php 
            $store_rec = get_store_details();
            ?>
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <h1>
                  <?= $this->lang->line('sms_api'); ?>
                  <small>Add/Update SMS API</small>
               </h1>
               <ol class="breadcrumb">
                  <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i>Home</a></li>
                  <li class="active"> <?= $this->lang->line('sms_api'); ?></li>
               </ol>
            </section>
            <!-- Main content -->
            <section class="content">
               <div class="row">
                  <!-- right column -->
                  <!-- ********** ALERT MESSAGE START******* -->
                  <?php include"comman/code_flashdata.php"; ?>
                  <!-- ********** ALERT MESSAGE END******* -->
                  <div class="col-md-12">
                     <!-- Horizontal Form -->
                     
                        <?= form_open('#', array('class' => 'form-horizontal', 'id' => 'api-form', 'enctype'=>'multipart/form-data', 'method'=>'POST'));?>


                     <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                           <li class="active"><a href="#tab_1" data-toggle="tab">HTTP/URL SMS API</a></li>
                           <li><a href="#tab_4" data-toggle="tab">WhatsApp API</a></li>
                           <li><a href="#tab_3" data-toggle="tab">Action</a></li>
                          
                        </ul>
                        <div class="tab-content">
                           <div class="tab-pane active" id="tab_1">
                              
                           <input type="hidden" name="hidden_rowcount" id="hidden_rowcount" value="">
                          
                           <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                           <!-- <div class="box-body"> -->
                              <div class="form-group " >

                                 <div class="col-sm-12">
                                  <div class="callout callout-info">
                                    <h4>HTTP/URL SMS API (Manual Setup)</h4>
                                      <p>
                                        <u>Example</u> : <br>https://www.example.com/api/mt/SendSMS?APIKey=QWERTYUIOP123456&senderid=ABCDEF&channel=2&DCS=0&flashsms=0&<b class='bg-yellow'>mobiles</b>=017xxxxxxxx&<b class='bg-yellow'>message</b>=test message
                                        <br>
                                        Note: Enter your SMS Gateway URL, Mobile Key (e.g. <code>number</code> or <code>mobiles</code>), Message Key (e.g. <code>message</code>), and click <b>+</b> to add extra API parameters (e.g. <code>api_key</code>, <code>senderid</code>, etc.).
                                      </p>
                                  </div>
                                 </div>
                                 <div class="col-sm-12  table-responsive">
                                  
                                    <table class="table" id='api_table'>
                                       <thead>
                                          <th width="15%"></th>
                                          <th width="20%" class="text-center">Key</th>
                                          <th width="40%" class="text-center">Key Value</th>
                                          <th><input type="button" class="btn btn-success" name="new_row" onclick="addrow();" value="+" title="New Line"  ></th>
                                       </thead>
                                       <tbody>
                                          <?php 
                                             $q2=$this->db->select("*")->where("store_id",get_current_store_id())->get("db_smsapi");
                                             $i=0; 
                                             foreach($q2->result() as $res2){
                                               $i++;
                                               if($res2->info == 'url'){
                                             ?>
                                          <tr id="row_<?= $i; ?>" data-row='<?= $i; ?>'>
                                             <td  class="text-right"><label class="control-label">URL<label class="text-danger">*</label></label>
                                                <input type="hidden" id="info_<?= $i; ?>" name="info_<?= $i; ?>" value="<?php echo  $res2->info; ?>">
                                             </td>
                                             <td >
                                                <input id="key_<?= $i; ?>" name="key_<?= $i; ?>"  type="text" class="form-control " placeholder="" value='<?= $res2->key; ?>' readonly="true" />
                                             </td>
                                             <td><input id="key_val_<?= $i; ?>" name="key_val_<?= $i; ?>"  type="text" class="form-control " placeholder=""  value='<?= $res2->key_value; ?>' /></td>
                                             <td><input type="button" class="btn btn-danger" name="btn_<?= $i; ?>" id="btn_<?= $i; ?>" value="-" title="Cant' Remove" disabled='true' ></td">
                                          </tr>
                                          <?php 
                                             }//url end
                                             else if($res2->info == 'mobile'){
                                               ?>
                                          <tr id="row_<?= $i; ?>" data-row='<?= $i; ?>'>
                                             <td  class="text-right"><label class="control-label">Mobile Key<label class="text-danger">*</label></label>
                                                <input type="hidden" id="info_<?= $i; ?>" name="info_<?= $i; ?>" value="<?php echo  $res2->info; ?>">
                                             </td>
                                             <td >
                                                <input id="key_<?= $i; ?>" name="key_<?= $i; ?>"  type="text" class="form-control " placeholder="" value='<?= $res2->key; ?>' />
                                             </td>
                                             <td><input id="key_val_<?= $i; ?>" name="key_val_<?= $i; ?>"  type="text" class="form-control " placeholder="" readonly="true" value='<?= $res2->key_value; ?>' /></td>
                                             <td><input type="button" class="btn btn-danger" name="btn_<?= $i; ?>" id="btn_<?= $i; ?>" value="-" title="Cant' Remove" disabled='true' ></td">
                                          </tr>
                                          <?php 
                                             }//mobile end
                                             else if($res2->info == 'message'){
                                               ?>
                                          <tr id="row_<?= $i; ?>" data-row='<?= $i; ?>'>
                                             <td  class="text-right"><label class="control-label">Message Key<label class="text-danger">*</label></label>
                                                <input type="hidden" id="info_<?= $i; ?>" name="info_<?= $i; ?>" value="<?php echo  $res2->info; ?>">
                                             </td>
                                             <td >
                                                <input id="key_<?= $i; ?>" name="key_<?= $i; ?>"  type="text" class="form-control " placeholder="" value='<?= $res2->key; ?>' />
                                             </td>
                                             <td><input id="key_val_<?= $i; ?>" name="key_val_<?= $i; ?>"  type="text" class="form-control " placeholder="" readonly="true" value='<?= $res2->key_value; ?>' /></td>
                                             <td><input type="button" class="btn btn-danger" name="btn_<?= $i; ?>" id="btn_<?= $i; ?>" value="-" title="Cant' Remove" disabled='true' ></td">
                                          </tr>
                                          <?php 
                                             }//mobile end
                                             else{
                                               ?>
                                          <tr id="row_<?= $i; ?>" data-row='<?= $i; ?>'>
                                             <td>
                                                <input type="hidden" id="info_<?= $i; ?>" name="info_<?= $i; ?>" value="<?php echo  $res2->info; ?>">
                                             </td>
                                             <td >
                                                <input id="key_<?= $i; ?>" name="key_<?= $i; ?>"  type="text" class="form-control " placeholder="" value='<?= $res2->key; ?>' />
                                             </td>
                                             <td><input id="key_val_<?= $i; ?>" name="key_val_<?= $i; ?>"  type="text" class="form-control " placeholder="" value='<?= $res2->key_value; ?>' /></td>
                                             <td><input type="button" class="btn btn-danger" name="btn_<?= $i; ?>" id="btn_<?= $i; ?>" value="-" title="Remove ?" onclick="removerow('<?= $i; ?>')"  ></td">
                                          </tr>
                                          <?php 
                                             }//mobile end
                                             }//foreach end
                                             ?>
                                       </tbody>
                                    </table>
                                 </div>
                                 

                                 <?php
                              $btn_name="Update";
                                  $btn_id="update";
                              ?>
                        

                              </div>
                              <!-- server code -->
                           <!-- </div> -->
                           <!-- /.box-body -->
                           
                           <!-- /.box-footer -->
                        
                           </div>
                           <!-- /.tab-pane -->

                           <div class="tab-pane" id="tab_4">
                            <?php
                            $whatsAppUrl  = 'https://app.fivemojo.com/api/send.php';
                            $whatsAppInstanceId = $whatsAppToken =''; 
                            $q1=$this->db->select("*")->where("store_id",get_current_store_id())->get("db_fivemojo");
                            if($q1->num_rows()>0){
                              $whatsAppInstanceId = $q1->row()->instance_id;
                              $whatsAppToken = $q1->row()->token;
                              if(!empty($q1->row()->url)){
                                $whatsAppUrl = $q1->row()->url;
                              }
                            } 
                            ?>
                              <div class="row">
                                 <!-- right column -->
                                 <div class="col-md-12">
                                       <div class="box-body">
                                          <div class="row">
                                            <div class="callout callout-info">
                                    <h4>WhatsApp API (FiveMojo / UltraMsg / Custom Gateway)</h4>
                                      <p>Connect your WhatsApp messaging gateway. Supports FiveMojo, UltraMsg, Wasender, and custom webhook APIs.</p>
                                      <p><b>Note:</b> Numbers are automatically formatted for Bangladesh (e.g. 017... will be sent as 88017...).</p>
                                      <div style="margin-top: 8px;">
                                         <button type="button" class="btn btn-xs btn-default" onclick="$('#whatsAppUrl').val('https://app.fivemojo.com/api/send.php');"><i class="fa fa-link"></i> Use FiveMojo Default URL</button>
                                         <button type="button" class="btn btn-xs btn-default" onclick="$('#whatsAppUrl').val('https://api.ultramsg.com/INSTANCE_ID/messages/chat');"><i class="fa fa-link"></i> Use UltraMsg Template URL</button>
                                      </div>
                                    </div>
                                             <div class="col-md-8">
                                                <div class="form-group">
                                                   <label for="whatsAppUrl" class="col-sm-4 control-label">API URL</label>
                                                   <div class="col-sm-6">
                                                      <input type="text" class="form-control" id="whatsAppUrl" name="whatsAppUrl" placeholder="https://app.fivemojo.com/api/send.php" value="<?php print $whatsAppUrl; ?>" >
                                                      <span id="whatsAppUrl_msg" style="display:none" class="text-danger"></span>
                                                      <small class="text-muted">FiveMojo: <code>https://app.fivemojo.com/api/send.php</code> | UltraMsg: <code>https://api.ultramsg.com/instanceXXXX/messages/chat</code></small>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-8">
                                                <div class="form-group">
                                                   <label for="whatsAppInstanceId" class="col-sm-4 control-label">Instance ID</label>
                                                   <div class="col-sm-6">
                                                      <input type="text" class="form-control" id="whatsAppInstanceId" name="whatsAppInstanceId" placeholder="Instance ID / Device ID" value="<?php print $whatsAppInstanceId; ?>" >
                                                      <span id="whatsAppInstanceId_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-8">
                                                <div class="form-group">
                                                   <label for="whatsAppToken" class="col-sm-4 control-label">API Token / Access Token</label>
                                                   <div class="col-sm-6">
                                                      <input type="text" class="form-control" id="whatsAppToken" name="whatsAppToken" placeholder="API Token" value="<?php print $whatsAppToken; ?>" >
                                                      <span id="whatsAppToken_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             
                                             


                                          </div>
                                       </div>
                                 </div>
                                 <!--/.col (right) -->
                              </div>
                           </div>

                           <!-- /.tab-pane -->
                           <div class="tab-pane" id="tab_3">
                           
                              <div class="row">
                                 <!-- right column -->
                                 <div class="col-md-12">
                                       <div class="box-body">
                                          <div class="row">
                                             <div class="callout callout-info">
                                    <h4>Enable or Disable the SMS / WhatsApp Sending Feature.</h4>
                                    <p>
                                      <ul>
                                        <li><b>Disable:</b> If you don't want to send SMS or WhatsApp messages</li>
                                        <li><b>HTTP/URL SMS API:</b> Send SMS using your configured HTTP/URL SMS gateway (Manual Setup)</li>
                                        <li><b>WhatsApp API:</b> Send messages directly to customer WhatsApp via WhatsApp gateway</li>
                                      </ul>
                                    </p>
                                  </div>
                                             <div class="col-md-8">
                                                <div class="form-group">
                                                   <label for="sms_status" class="col-sm-4 control-label">Message Gateway</label>
                                                   <div class="col-sm-6">
                                                      <select class="form-control select2" id="sms_status" name="sms_status"  style="width: 100%;" >
                                                      <option value="0">Disable</option>
                                                      <option value="1">HTTP/URL SMS API (Manual Setup)</option>
                                                      <option value="3">WhatsApp API</option>
                                                   </select>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                 </div>
                                 <!--/.col (right) -->
                              </div>
                           </div>
                           <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->

                     </div>
                    <div class="col-sm-8 col-sm-offset-2 text-center">
                           <center>
                            <?php
                              $btn_name="Update";
                                  $btn_id="update";
                              ?>
                             <div class="col-md-3 col-md-offset-3">
                              <button type="button" id="<?php echo $btn_id;?>" class=" btn btn-block btn-success" title="Save Data"><?php echo $btn_name;?></button>
                           </div>
                            <div class="col-sm-3">
                              <a href="<?=base_url('dashboard');?>">
                                <button type="button" class="col-sm-3 btn btn-block btn-warning close_btn" title="Go Dashboard">Close</button>
                              </a>
                             </div>
                           </center>
                        </div>
                     <!-- /.box -->
                   <?= form_close(); ?>
                  </div>
                  <!--/.col (right) -->
               </div>
               <!-- /.row -->
            </section>
            <!-- /.content -->
         </div>
         <!-- /.content-wrapper -->
         <?php include"footer.php"; ?>
         <!-- Add the sidebar's background. This div must be placed
            immediately after the control sidebar -->
         <div class="control-sidebar-bg"></div>
      </div>
      <!-- SOUND CODE -->
      <?php include"comman/code_js_sound.php"; ?>
      <!-- TABLES CODE -->
      <?php include"comman/code_js.php"; ?>
      <script src="<?php echo $theme_link; ?>js/sms.js"></script>
      
      <!-- Make sidebar menu hughlighter/selector -->
      <script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
      <script>
         //UPDATE ROW COUNT
         $("#hidden_rowcount").val("<?= $i;?>");
         
         //UPDATE current sms_status
           $("#sms_status").val(<?= $store_rec->sms_status;?>).select2();  
        
      </script>
      <script type="text/javascript">
         function removerow(id){//id=Rowid
         
             $("#row_"+id).remove();
            // final_total();
             }
           function addrow(id){
             
               var rowcount=$("#hidden_rowcount").val();
               rowcount=parseInt(rowcount)+1;
                 $("#hidden_rowcount").val(rowcount);
         
                 var str='<tr id="row_'+rowcount+'" data-row="'+rowcount+'">';
                 
                 
                 str+='<td><input type="hidden" id="info_'+rowcount+'" name="info_'+rowcount+'" value=""></td>';
               str+='<td><input id="key_'+rowcount+'" name="key_'+rowcount+'"  type="text" class="form-control" /></td>';
               str+='<td><input id="key_val_'+rowcount+'" name="key_val_'+rowcount+'"  type="text" class="form-control" /></td>';
               str+='<td><input type="button" class="btn btn-danger" name="btn_'+rowcount+'" id="btn_'+rowcount+'" value="-" title="Remove Record" onclick="removerow('+rowcount+')"></td>';
                 str+='</tr>';
                  //console.log(str);
                       $('#api_table tbody').append(str);
            
             //return;
           }
      </script>
   </body>
</html>
