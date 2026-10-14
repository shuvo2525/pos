<div class="ap-flash">
      <!-- ********** ALERT MESSAGE START******* -->
          <?php if(demo_app()){ ?>
            <div class="alert alert-info text-left">
                 <a href="javascript:void()" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>
                  <p>The Shopkeeper POS and Inventory Management Software has been upgraded with advanced enterprise features.</p><p>For inquiries, call: +8801775457008, +8801954578089. Visit website: <a href="http://www.creativedesign.com.bd">www.creativedesign.com.bd</a></p>
                </strong>
              </div>
          <?php } ?>

          <?php if(!get_current_subcription_id() && !is_admin()){ ?>
            <div class="alert alert-success  text-left">
                 <a href="javascript:void()" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>
                  <?= $this->lang->line('subscription_msg_1'); ?> Please click <a href='<?=base_url('subscription')?>'>here</a> to Activate!
                </strong>
              </div>
          <?php } ?>
          <?php if(!is_admin() && store_module() && !empty(get_current_subcription_id())){ 
            //validate subscription
            $message = '';
            $alert_class = 'alert-danger';
            $subscription_id = get_current_subcription_id();
            if(empty($subscription_id)){
              $message = "This store doesn't have any subscription!!";
            } else {
              $sub_rec = get_subscription_rec($subscription_id);
              if(!empty($sub_rec)){
                $is_unsub = ((isset($sub_rec->package_status) && strtolower($sub_rec->package_status) == 'unsubscribed') || (isset($sub_rec->payment_status) && strtolower($sub_rec->payment_status) == 'unsubscribed'));
                if($is_unsub){
                  $message = "Store Subscription is Unsubscribed & Locked by Administrator!!";
                } else if(!empty($sub_rec->expire_date) && $sub_rec->expire_date != '1970-01-01' && $sub_rec->expire_date < date('Y-m-d')){
                  $message = "Store Subscription expired!!";
                }
              }
            }

            if(!empty($message)){ ?>
              <div class="alert <?= $alert_class; ?> text-left" style="font-size:14px;">
                 <a href="javascript:void()" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>
                  <i class="fa fa-exclamation-triangle"></i> <?=$message?>, Click <a href='<?=base_url('subscription')?>' style="text-decoration:underline; font-weight:bold; color:#fff;">here</a> to Activate!
                </strong>
              </div>
            <?php }
           } ?>

          <?php
            if($this->session->flashdata('success')!=''):
              ?>
                <div class="alert alert-success alert-dismissable text-center">
                 <a href="javascript:void()" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong><?= $this->session->flashdata('success') ?></strong>
              </div> 
               <?php 
            endif;
            if($this->session->flashdata('error')!=''):
              ?>
                <div class="alert alert-danger alert-dismissable text-center">
                 <a href="javascript:void()" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong><?= $this->session->flashdata('error') ?></strong>
              </div> 
               <?php
            endif;
            if($this->session->flashdata('warning')!=''):
              ?>
                <div class="alert alert-warning alert-dismissable text-center">
                 <a href="javascript:void()" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong><?= $this->session->flashdata('warning') ?></strong>
              </div> 
               <?php
            endif;
            ?>
            <!-- ********** ALERT MESSAGE END******* -->
     </div>