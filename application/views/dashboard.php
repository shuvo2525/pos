<!DOCTYPE html>
<html>
<head>
<!-- FORM CSS CODE -->
<?php include"comman/code_css.php"; ?>
<!-- </copy> -->
<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $theme_link; ?>dist/css/dashboard-pro.css?v=<?php echo @filemtime(FCPATH.'theme/dist/css/dashboard-pro.css'); ?>">
</head>
<body class="hold-transition skin-blue sidebar-mini dash-pro<?php echo (is_admin() && store_module()) ? ' sa-dash' : ''; ?>">
<?php $CI =& get_instance(); ?>

<div class="wrapper">
  
  
  <?php include"sidebar.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header">
      <h1><?=$page_title;?></h1>
    </section>

    <section class="content">
      <?php include"comman/code_flashdata.php"; ?>

      <?= form_open('dashboard', array('class' => '', 'id' => 'dashboard_form', 'method' => 'post')); ?>
        <input type="hidden" name="store_id" id="store_id" value="<?= get_current_store_id(); ?>">
      <?= form_close(); ?>

      <div class="dp-hero">
        <div class="dp-hero-text">
          <?php if(is_admin() && store_module()){ ?>
          <span class="dp-kicker">JAAS BD</span>
          <h1><?=$page_title;?></h1>
          <p>Central control panel for stores, packages, and subscriptions</p>
          <?php } else { ?>
          <h1><?=$page_title;?></h1>
          <p>Live overview of store sales, purchases, and stock</p>
          <?php } ?>
        </div>

        <div class="dp-hero-right" style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
          <?php if(!is_user() && $CI->permissions('dashboard_info_box_1')){ ?>
          <div class="dp-periods">
            <button type="button" title="Today" class="get_tab_records active">Today</button>
            <button type="button" title="Current Week" class="get_tab_records">Weekly</button>
            <button type="button" title="Current Month" class="get_tab_records">Monthly</button>
            <button type="button" title="Current Year" class="get_tab_records">Yearly</button>
            <button type="button" title="All Years" class="get_tab_records">All</button>
          </div>
          <?php } ?>
        </div>
      </div>

      <?php 
        $curr_store_id = get_current_store_id();
        $curr_store = $this->db->where('id', $curr_store_id)->get('db_store')->row();
        $curr_sub_id = get_current_subcription_id();
        $curr_sub = ($curr_sub_id) ? get_subscription_rec($curr_sub_id) : null;
        $pay_pkg_id = (!empty($curr_sub) && !empty($curr_sub->package_id)) ? $curr_sub->package_id : 3;
        $direct_gateway_url = base_url('subscription/plan/' . $pay_pkg_id);
        $site_phone = get_site_details()->mobile ?? '';

        $is_locked = (!is_admin() && is_store_locked_or_expired());

        if($is_locked){
      ?>
      <div class="alert" style="background:#fef2f2; border:1.5px solid #fecaca; color:#991b1b; border-radius:16px; padding:18px 24px; margin-bottom:22px; box-shadow:0 4px 16px rgba(239,68,68,0.12);">
        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px;">
          <div style="display:flex; align-items:center; gap:14px;">
            <div style="width:48px; height:48px; border-radius:14px; background:#dc2626; color:#fff; display:flex; align-items:center; justify-content:center; font-size:22px; flex-shrink:0;">
              <i class="fa fa-lock"></i>
            </div>
            <div>
              <h4 style="margin:0 0 4px; font-weight:800; font-size:16px; color:#991b1b;">Store Access Locked</h4>
              <p style="margin:0; font-size:13.5px; color:#7f1d1d; font-weight:500;">
                To unlock your store, please <a href="<?= $direct_gateway_url; ?>" style="color:#dc2626; font-weight:800; text-decoration:underline;">Click Here</a> or Contact Admin. You can view all records and menus, but creating or updating records is disabled until unlocked.
              </p>
            </div>
          </div>
          <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
            <a href="<?= $direct_gateway_url; ?>" class="btn btn-danger btn-sm" style="font-weight:800; border-radius:8px; padding:10px 22px; box-shadow:0 4px 12px rgba(220,38,38,0.35); text-transform:uppercase; letter-spacing:0.5px; background:#dc2626; border-color:#b91c1c;">
              <i class="fa fa-unlock"></i> Unlock: Click Here
            </a>
            <?php if(!empty($site_phone)){ ?>
            <a href="tel:<?= htmlspecialchars($site_phone); ?>" class="btn btn-default btn-sm" style="font-weight:700; border-radius:8px; padding:10px 16px; border-color:#cbd5e1; color:#334155;">
              <i class="fa fa-phone"></i> Contact Admin
            </a>
            <?php } else { ?>
            <span class="btn btn-default btn-sm" style="font-weight:700; border-radius:8px; padding:10px 16px; border-color:#cbd5e1; color:#334155; cursor:default;">
              <i class="fa fa-phone"></i> Contact Admin
            </span>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php } ?>

      <?php if(!is_user() && $CI->permissions('dashboard_info_box_1')){ ?>
      <div class="dp-kpis">
        <article class="dp-kpi">
          <div class="dp-kpi-icon ico-a"><i class="fa fa-cube"></i></div>
          <div class="dp-kpi-body">
            <p class="dp-kpi-label"><?= $this->lang->line('purchase_due'); ?></p>
            <h3 class="purchase_due"><?= $CI->currency(0); ?></h3>
          </div>
        </article>
        <article class="dp-kpi">
          <div class="dp-kpi-icon ico-b"><i class="fa fa-calendar-minus-o"></i></div>
          <div class="dp-kpi-body">
            <p class="dp-kpi-label"><?= $this->lang->line('sales_due'); ?></p>
            <h3 class="sales_due"><?= $CI->currency(0); ?></h3>
          </div>
        </article>
        <article class="dp-kpi">
          <div class="dp-kpi-icon ico-c"><i class="fa fa-file-text-o"></i></div>
          <div class="dp-kpi-body">
            <p class="dp-kpi-label"><?= $this->lang->line('sales'); ?></p>
            <h3 class="tot_sal_grand_total"><?= $CI->currency(0); ?></h3>
          </div>
        </article>
        <article class="dp-kpi">
          <div class="dp-kpi-icon ico-d"><i class="fa fa-minus-square-o"></i></div>
          <div class="dp-kpi-body">
            <p class="dp-kpi-label"><?= $this->lang->line('expense'); ?></p>
            <h3 class="tot_exp"><?= $CI->currency(0); ?></h3>
          </div>
        </article>
      </div>
      <?php } ?>

      <?php if(!is_user() && $CI->permissions('dashboard_info_box_2')){ ?>
      <div class="dp-stats">
        <div class="dp-stat">
          <div class="dp-stat-icon"><i class="fa fa-users"></i></div>
          <div>
            <p class="dp-stat-label"><?= $this->lang->line('customers'); ?></p>
            <div class="dp-stat-value tot_cust"><?= $CI->currency(0); ?></div>
          </div>
        </div>
        <div class="dp-stat">
          <div class="dp-stat-icon"><i class="fa fa-truck"></i></div>
          <div>
            <p class="dp-stat-label"><?= $this->lang->line('suppliers'); ?></p>
            <div class="dp-stat-value tot_sup"><?= $CI->currency(0); ?></div>
          </div>
        </div>
        <div class="dp-stat">
          <div class="dp-stat-icon"><i class="fa fa-suitcase"></i></div>
          <div>
            <p class="dp-stat-label"><?= $this->lang->line('purchases'); ?></p>
            <div class="dp-stat-value tot_pur"><?= $CI->currency(0); ?></div>
          </div>
        </div>
        <div class="dp-stat">
          <div class="dp-stat-icon"><i class="fa fa-shopping-cart"></i></div>
          <div>
            <p class="dp-stat-label"><?= $this->lang->line('invoices'); ?></p>
            <div class="dp-stat-value tot_sal"><?= $CI->currency(0); ?></div>
          </div>
        </div>
      </div>
      <?php } ?>

      <?php if(!is_user() && isset($stock_metrics)){ ?>
      <!-- TOTAL STOCK & INVENTORY VALUATION CARDS -->
      <div class="dp-stats" style="margin-top: 15px;">
        <div class="dp-stat" style="border-left: 4px solid #0284c7;">
          <div class="dp-stat-icon" style="background:#e0f2fe; color:#0284c7;"><i class="fa fa-cubes"></i></div>
          <div>
            <p class="dp-stat-label">Total Stock Value (Purchase)</p>
            <div class="dp-stat-value" style="color:#0369a1; font-weight:800;"><?= $CI->currency($stock_metrics['total_purchase_val'], true); ?></div>
            <small class="text-muted"><i class="fa fa-info-circle"></i> Total inventory at purchase price</small>
          </div>
        </div>
        <div class="dp-stat" style="border-left: 4px solid #059669;">
          <div class="dp-stat-icon" style="background:#ecfdf5; color:#059669;"><i class="fa fa-tags"></i></div>
          <div>
            <p class="dp-stat-label">Total Stock Value (Sales)</p>
            <div class="dp-stat-value" style="color:#047857; font-weight:800;"><?= $CI->currency($stock_metrics['total_sales_val'], true); ?></div>
            <small class="text-muted"><i class="fa fa-info-circle"></i> Total inventory at sales price</small>
          </div>
        </div>
        <div class="dp-stat" style="border-left: 4px solid #7c3aed;">
          <div class="dp-stat-icon" style="background:#f3e8ff; color:#7c3aed;"><i class="fa fa-archive"></i></div>
          <div>
            <p class="dp-stat-label">Total In-Stock Items</p>
            <div class="dp-stat-value" style="color:#6d28d9; font-weight:800;"><?= number_format($stock_metrics['total_products']); ?> Products</div>
            <small class="text-muted"><?= number_format($stock_metrics['total_stock_qty']); ?> total units in stock</small>
          </div>
        </div>
        <div class="dp-stat" style="border-left: 4px solid #d97706;">
          <div class="dp-stat-icon" style="background:#fef3c7; color:#d97706;"><i class="fa fa-line-chart"></i></div>
          <div>
            <p class="dp-stat-label">Potential Gross Margin</p>
            <div class="dp-stat-value" style="color:#b45309; font-weight:800;"><?= $CI->currency($stock_metrics['potential_profit'], true); ?></div>
            <small class="text-muted"><a href="<?= base_url('reports/stock'); ?>" style="color:#b45309; text-decoration:underline;">Stock Report &rarr;</a></small>
          </div>
        </div>
      </div>
      <?php } ?>

      <?php if(!is_admin() && isset($store_health)){ ?>
      <!-- SHOP OVERALL HEALTH & PERFORMANCE DASHBOARD -->
      <div class="row" style="margin-top: 15px; margin-bottom: 22px;">
        <div class="col-md-12">
          <div style="background: #ffffff; border-radius: 18px; border: 1.5px solid #e1edf0; box-shadow: 0 4px 20px rgba(8, 153, 164, 0.06); padding: 22px; position: relative; overflow: hidden;">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 14px;">
              <div style="display:flex; align-items:center; gap:12px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, #0899a4, #0ed2be); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                  <i class="fa fa-heartbeat"></i>
                </div>
                <div>
                  <h3 style="margin: 0; font-weight: 800; font-size: 18px; color: #07252a;">Overall Store Health & Performance</h3>
                  <small style="color: #64748b;">Automated algorithmic score based on sales, profitability, debt collection, and stock health</small>
                </div>
              </div>
              <span class="label" style="background: <?= $store_health['health_bg']; ?>; color: <?= $store_health['health_color']; ?>; border: 1.5px solid <?= $store_health['health_color']; ?>; font-size: 13px; font-weight: 700; padding: 6px 16px; border-radius: 20px;">
                <i class="fa fa-circle" style="font-size: 9px; vertical-align: middle;"></i> Status: <?= $store_health['health_status']; ?>
              </span>
            </div>

            <div class="row" style="display:flex; align-items:center; flex-wrap:wrap;">
              <!-- Health % Gauge -->
              <div class="col-md-3 col-sm-4 text-center" style="border-right: 1px dashed #e2e8f0; padding: 10px 15px;">
                <div style="position: relative; width: 140px; height: 140px; margin: 0 auto;">
                  <svg viewBox="0 0 36 36" style="width: 140px; height: 140px; transform: rotate(-90deg);">
                    <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#f1f5f9" stroke-width="3.5" />
                    <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="<?= $store_health['health_color']; ?>" stroke-width="3.5" stroke-dasharray="<?= $store_health['overall_health']; ?>, 100" stroke-linecap="round" />
                  </svg>
                  <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                    <span style="font-size: 32px; font-weight: 900; color: #07252a; line-height: 1;"><?= $store_health['overall_health']; ?>%</span>
                    <span style="display: block; font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-top: 4px;">Health Score</span>
                  </div>
                </div>
              </div>

              <!-- Financial Indicators -->
              <div class="col-md-5 col-sm-8" style="padding: 10px 20px; border-right: 1px dashed #e2e8f0;">
                <div class="row">
                  <div class="col-xs-6" style="margin-bottom: 14px;">
                    <small style="color: #64748b; font-weight: 600; text-transform: uppercase; font-size: 11px;"><i class="fa fa-line-chart text-green"></i> Total Sales</small>
                    <h4 style="margin: 4px 0 0; font-weight: 800; color: #059669;"><?= $CI->currency($store_health['tot_sales'], true); ?></h4>
                  </div>
                  <div class="col-xs-6" style="margin-bottom: 14px;">
                    <small style="color: #64748b; font-weight: 600; text-transform: uppercase; font-size: 11px;"><i class="fa fa-minus-circle text-purple"></i> Total Expense</small>
                    <h4 style="margin: 4px 0 0; font-weight: 800; color: #811ba0;"><?= $CI->currency($store_health['tot_exp'], true); ?></h4>
                  </div>
                  <div class="col-xs-6">
                    <small style="color: #64748b; font-weight: 600; text-transform: uppercase; font-size: 11px;"><i class="fa fa-shopping-basket text-aqua"></i> Total Purchases</small>
                    <h4 style="margin: 4px 0 0; font-weight: 800; color: #0899a4;"><?= $CI->currency($store_health['tot_pur'], true); ?></h4>
                  </div>
                  <div class="col-xs-6">
                    <small style="color: #64748b; font-weight: 600; text-transform: uppercase; font-size: 11px;"><i class="fa fa-exclamation-triangle text-orange"></i> Sales Due</small>
                    <h4 style="margin: 4px 0 0; font-weight: 800; color: #ea7916;"><?= $CI->currency($store_health['sales_due'], true); ?></h4>
                  </div>
                  <?php if(isset($stock_metrics)){ ?>
                  <div class="col-xs-12" style="margin-top: 12px; padding-top: 10px; border-top: 1px dashed #e2e8f0;">
                    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:6px;">
                      <small style="color: #64748b; font-weight: 700; text-transform: uppercase; font-size: 11px;"><i class="fa fa-cubes text-blue"></i> Stock Value (Purchase / Sales):</small>
                      <span style="font-weight: 800; font-size: 13px;">
                        <span style="color:#0284c7;"><?= $CI->currency($stock_metrics['total_purchase_val'], true); ?></span> / 
                        <span style="color:#059669;"><?= $CI->currency($stock_metrics['total_sales_val'], true); ?></span>
                      </span>
                    </div>
                  </div>
                  <?php } ?>
                </div>
              </div>

              <!-- Health Pillars Breakdown Bars -->
              <div class="col-md-4 col-sm-12" style="padding: 10px 20px;">
                <div style="margin-bottom: 12px;">
                  <div style="display:flex; justify-content:space-between; font-size: 12px; font-weight: 700; margin-bottom: 4px;">
                    <span style="color: #07252a;">Operating Margin Efficiency</span>
                    <span style="color: #0899a4;"><?= $store_health['net_margin']; ?>%</span>
                  </div>
                  <div class="progress" style="height: 7px; margin-bottom: 0; background: #e2e8f0; border-radius: 10px; box-shadow: none;">
                    <div class="progress-bar" style="width: <?= min(100, max(5, $store_health['net_margin'])); ?>%; background: #0899a4; border-radius: 10px;"></div>
                  </div>
                </div>

                <div style="margin-bottom: 12px;">
                  <div style="display:flex; justify-content:space-between; font-size: 12px; font-weight: 700; margin-bottom: 4px;">
                    <span style="color: #07252a;">Debt Recovery & Collection</span>
                    <span style="color: #059669;"><?= $store_health['collection_rate']; ?>%</span>
                  </div>
                  <div class="progress" style="height: 7px; margin-bottom: 0; background: #e2e8f0; border-radius: 10px; box-shadow: none;">
                    <div class="progress-bar" style="width: <?= min(100, max(5, $store_health['collection_rate'])); ?>%; background: #059669; border-radius: 10px;"></div>
                  </div>
                </div>

                <div>
                  <div style="display:flex; justify-content:space-between; font-size: 12px; font-weight: 700; margin-bottom: 4px;">
                    <span style="color: #07252a;">Inventory Availability Rate</span>
                    <span style="color: #ea7916;"><?= $store_health['stock_ratio']; ?>%</span>
                  </div>
                  <div class="progress" style="height: 7px; margin-bottom: 0; background: #e2e8f0; border-radius: 10px; box-shadow: none;">
                    <div class="progress-bar" style="width: <?= min(100, max(5, $store_health['stock_ratio'])); ?>%; background: #ea7916; border-radius: 10px;"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
       
      <?php if(is_admin() && store_module()){
        $sa_stores = (int) $this->db->where('id !=', 1)->count_all_results('db_store');
        $sa_active_stores = (int) $this->db->where('id !=', 1)->where('status', 1)->count_all_results('db_store');
        $sa_packages = (int) $this->db->count_all_results('db_package');
        $sa_users = (int) $this->db->where('id !=', 1)->count_all_results('db_users');
        $sa_subs = (int) $this->db->count_all_results('db_subscription');
      ?>
      <div class="dp-kpis sa-kpis">
        <article class="dp-kpi">
          <div class="dp-kpi-icon ico-a"><i class="fa fa-building"></i></div>
          <div class="dp-kpi-body">
            <p class="dp-kpi-label"><?= $this->lang->line('store_list'); ?></p>
            <h3><?= $sa_stores ?></h3>
            <span class="dp-kpi-meta"><?= $sa_active_stores ?> active</span>
          </div>
        </article>
        <article class="dp-kpi">
          <div class="dp-kpi-icon ico-b"><i class="fa fa-get-pocket"></i></div>
          <div class="dp-kpi-body">
            <p class="dp-kpi-label"><?= $this->lang->line('package_list'); ?></p>
            <h3><?= $sa_packages ?></h3>
            <span class="dp-kpi-meta">subscription plans</span>
          </div>
        </article>
        <article class="dp-kpi">
          <div class="dp-kpi-icon ico-c"><i class="fa fa-users"></i></div>
          <div class="dp-kpi-body">
            <p class="dp-kpi-label"><?= $this->lang->line('users_list'); ?></p>
            <h3><?= $sa_users ?></h3>
            <span class="dp-kpi-meta">store operators</span>
          </div>
        </article>
        <article class="dp-kpi">
          <div class="dp-kpi-icon ico-d"><i class="fa fa-calendar-check-o"></i></div>
          <div class="dp-kpi-body">
            <p class="dp-kpi-label"><?= $this->lang->line('subscription'); ?></p>
            <h3><?= $sa_subs ?></h3>
            <span class="dp-kpi-meta">total records</span>
          </div>
        </article>
      </div>

      <div class="sa-actions">
        <a class="sa-action" href="<?php echo $base_url; ?>store/view">
          <span class="sa-action-icon"><i class="fa fa-building"></i></span>
          <span>
            <strong><?= $this->lang->line('store_list'); ?></strong>
            <em>View all stores</em>
          </span>
        </a>
        <a class="sa-action" href="<?php echo $base_url; ?>package">
          <span class="sa-action-icon"><i class="fa fa-get-pocket"></i></span>
          <span>
            <strong><?= $this->lang->line('package_list'); ?></strong>
            <em>Create & edit plans</em>
          </span>
        </a>
        <a class="sa-action" href="<?php echo $base_url; ?>gateways">
          <span class="sa-action-icon"><i class="fa fa-credit-card"></i></span>
          <span>
            <strong><?= $this->lang->line('payment_gateways'); ?></strong>
            <em>PayPal / Instamojo</em>
          </span>
        </a>
        <a class="sa-action" href="<?php echo $base_url; ?>users/view">
          <span class="sa-action-icon"><i class="fa fa-user"></i></span>
          <span>
            <strong><?= $this->lang->line('users_list'); ?></strong>
            <em>Manage users</em>
          </span>
        </a>
      </div>
      <?php } ?>

      <?php if(is_admin() && store_module()){ ?>
      <div class="dp-split-eq">
        <div class="dp-panel">
          <div class="dp-panel-head">
            <h3><?= $this->lang->line('stores_details'); ?></h3>
            <a class="dp-head-link" href="<?php echo $base_url; ?>store/view"><?= $this->lang->line('view_all'); ?></a>
            <div class="btn-group hide">
              <button type="button" title="Today" class="btn btn-default btn-info get_storewise_details">Today</button>
              <button type="button" title="Current Week" class="btn btn-default btn-info get_storewise_details">Weekly</button>
              <button type="button" title="Current Month" class="btn btn-default btn-info get_storewise_details">Monthly</button>
              <button type="button" title="Current Year" class="btn btn-default btn-info get_storewise_details">Yearly</button>
              <button type="button" title="All Years" class="btn btn-default btn-info get_storewise_details active">All</button>
            </div>
          </div>
          <div class="dp-panel-body tight table-responsive">
            <table id="stores_details" class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th><?= $this->lang->line('store_name'); ?></th>
                  <th><?= $this->lang->line('total_sales'); ?></th>
                  <th><?= $this->lang->line('total_expense'); ?></th>
                  <th><?= $this->lang->line('sales_due'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?= $CI->get_storewise_details(); ?>
              </tbody>
            </table>
          </div>
        </div>

        <div class="dp-panel">
          <div class="dp-panel-head">
            <h3><?= $this->lang->line('subcriptions'); ?></h3>
          </div>
          <div class="dp-panel-body">
            <div class="dp-chart sa-sub-chart">
              <div class="subscription_chart"></div>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>

      <?php if(!is_user() && $CI->permissions('dashboard_pur_sal_chart')){ ?>
      <div class="dp-split">
        <div class="dp-panel">
          <div class="dp-panel-head">
            <h3><?= $this->lang->line('purchase_sales_and_expense_bar_chart'); ?></h3>
          </div>
          <div class="dp-panel-body">
            <div class="dp-chart">
              <canvas class="bar-chartcanvas"></canvas>
            </div>
          </div>
        </div>
        <div class="dp-panel dp-recent-items-panel">
          <div class="dp-panel-head" style="display:flex; justify-content:space-between; align-items:center;">
            <h3><?= $this->lang->line('recently_added_items'); ?></h3>
            <span class="dp-recent-count-badge">Recent 10</span>
          </div>
          <div class="dp-panel-body tight dp-recent-items-body">
            <table class="table dp-recent-items-tbl">
              <thead>
                <tr>
                  <th style="width: 36px; text-align: center;">#</th>
                  <th><?= $this->lang->line('item_name'); ?></th>
                  <th class="dp-recent-price-th" style="width: 130px; text-align: right;"><?= $this->lang->line('sales_price'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php
                    $i=1;
                    $this->db->select("id,item_name,sales_price")
                             ->where("store_id",get_current_store_id())
                             ->where("status",1)
                             ->from("db_items")
                             ->order_by('id','desc')
                             ->limit(10);
                    $q5 = $this->db->get();
                    if($q5->num_rows() >0){
                      foreach($q5->result() as $res5){
                ?>
                <tr>
                  <td class="dp-recent-sl"><?php echo $i++; ?></td>
                  <td class="dp-recent-name-td">
                    <div class="dp-recent-name-text" title="<?php echo htmlspecialchars($res5->item_name); ?>">
                      <?php echo htmlspecialchars($res5->item_name); ?>
                    </div>
                  </td>
                  <td class="dp-recent-price-td">
                    <span class="dp-recent-price-tag">
                      <?php echo $CI->currency($res5->sales_price,$with_comma=true); ?>
                    </span>
                  </td>
                </tr>
                <?php
                      }
                    } else {
                ?>
                <tr>
                  <td colspan="3" style="text-align:center; padding: 24px 10px; color:#94a3b8;">
                    No items found
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <?php if($CI->session->userdata('inv_userid')==1 || $CI->permissions('items_view')){ ?>
          <div class="dp-panel-foot">
            <a href="<?php echo $base_url; ?>items"><?= $this->lang->line('view_all'); ?></a>
          </div>
          <?php } ?>
        </div>
      </div>
      <?php } ?>

      <?php if($CI->permissions('dashboard_stock_alert') && !is_user()) { ?>
      <div class="dp-panel">
        <div class="dp-panel-head">
          <h3><?= $this->lang->line('stock_alert'); ?></h3>
        </div>
        <div class="dp-panel-body table-responsive">
          <table id="example2" class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th><?= $this->lang->line('item_name'); ?></th>
                <th><?= $this->lang->line('category_name'); ?></th>
                <th><?= $this->lang->line('brand_name'); ?></th>
                <th><?= $this->lang->line('stock'); ?></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <?php } ?>

      <?php if(!is_user()){ ?>
      <div class="dp-split-eq">
        <?php if($CI->permissions('dashboard_trending_items_chart')){ ?>
        <div class="dp-panel">
          <div class="dp-panel-head">
            <h3><?= $this->lang->line('top_10_trending_items'); ?></h3>
          </div>
          <div class="dp-panel-body">
            <div class="dp-donut">
              <canvas id="doughnut-chart"></canvas>
            </div>
          </div>
        </div>
        <?php } ?>

        <?php if($CI->permissions('recent_sales_invoice_list')){ ?>
        <div class="dp-panel">
          <div class="dp-panel-head">
            <h3><?= $this->lang->line('recentl_sales_invoices'); ?></h3>
          </div>
          <div class="dp-panel-body tight table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th><?= $this->lang->line('date'); ?></th>
                  <th><?= $this->lang->line('invoice_id'); ?></th>
                  <th><?= $this->lang->line('customer'); ?></th>
                  <th><?= $this->lang->line('total'); ?></th>
                  <th><?= $this->lang->line('status'); ?></th>
                  <th><?= $this->lang->line('created_by'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php
                    $i=1;
                    if(!is_admin() && !is_store_admin()){
                      $this->db->where("created_by",$this->session->userdata('inv_username'));
                    }
                    $this->db->select("*")
                                      ->where("store_id",get_current_store_id())
                                      ->from("db_sales")
                                      ->order_by('id','desc')
                                      ->limit(10);
                    $q5=$this->db->get();
                    if($q5->num_rows() >0){
                      foreach($q5->result() as $res5){
                        $ps = strtolower(trim($res5->payment_status));
                        $badge = 'dp-badge';
                        if ($ps === 'paid') $badge .= ' is-paid';
                        elseif ($ps === 'unpaid') $badge .= ' is-unpaid';
                        elseif ($ps === 'partial') $badge .= ' is-partial';
                ?>
                <tr>
                  <td><?php echo $i++; ?></td>
                  <td><?php echo show_date($res5->sales_date); ?></td>
                  <td><?php echo $res5->sales_code; ?></td>
                  <td><?php echo get_customer_details($res5->customer_id)->customer_name; ?></td>
                  <td><?php echo $CI->currency($res5->grand_total,$with_comma=true); ?></td>
                  <td><span class="<?php echo $badge; ?>"><?php echo $res5->payment_status; ?></span></td>
                  <td><?php echo htmlspecialchars(get_user_fullname($res5->created_by)); ?></td>
                </tr>
                <?php
                      }
                    }
                ?>
              </tbody>
            </table>
          </div>
          <?php if($CI->session->userdata('inv_userid')==1){ ?>
          <div class="dp-panel-foot">
            <a href="<?php echo $base_url; ?>sales"><?= $this->lang->line('view_all'); ?></a>
          </div>
          <?php } ?>
        </div>
        <?php } ?>
      </div>
      <?php } ?>

    </section>
  </div>
  <!-- /.content-wrapper -->

  <?php $this->load->view('footer'); ?>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

<!-- SOUND CODE -->
<?php include"comman/code_js_sound.php"; ?>
<!-- TABLES CODE -->
<?php include"comman/code_js.php"; ?>
<!-- bootstrap datepicker -->

<!-- ChartJS 1.0.1 -->
<script src="<?php echo $theme_link; ?>plugins/chartjs/Chart.min.js"></script>
<script src="<?php echo $theme_link; ?>plugins/chartjs/chartjs-plugin-colorschemes.min.js"></script>
<script>

  'use strict';

window.chartColors = {
  red: 'rgb(138, 75, 47)',
  orange: 'rgb(196, 140, 54)',
  yellow: 'rgb(201, 162, 39)',
  green: 'rgb(46, 125, 90)',
  blue: 'rgb(29, 78, 137)',
  purple: 'rgb(90, 70, 140)',
  grey: 'rgb(138, 150, 168)'
};

(function(global) {
  var MONTHS = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
  ];

  var COLORS = [
    '#4dc9f6',
    '#f67019',
    '#f53794',
    '#537bc4',
    '#acc236',
    '#166a8f',
    '#00a950',
    '#58595b',
    '#8549ba'
  ];

  var Samples = global.Samples || (global.Samples = {});
  var Color = global.Color;

  Samples.utils = {
    // Adapted from http://indiegamr.com/generate-repeatable-random-numbers-in-js/
    srand: function(seed) {
      this._seed = seed;
    },

    rand: function(min, max) {
      var seed = this._seed;
      min = min === undefined ? 0 : min;
      max = max === undefined ? 1 : max;
      this._seed = (seed * 9301 + 49297) % 233280;
      return min + (this._seed / 233280) * (max - min);
    },

    numbers: function(config) {
      var cfg = config || {};
      var min = cfg.min || 0;
      var max = cfg.max || 1;
      var from = cfg.from || [];
      var count = cfg.count || 8;
      var decimals = cfg.decimals || 8;
      var continuity = cfg.continuity || 1;
      var dfactor = Math.pow(10, decimals) || 0;
      var data = [];
      var i, value;

      for (i = 0; i < count; ++i) {
        value = (from[i] || 0) + this.rand(min, max);
        if (this.rand() <= continuity) {
          data.push(Math.round(dfactor * value) / dfactor);
        } else {
          data.push(null);
        }
      }

      return data;
    },

    labels: function(config) {
      var cfg = config || {};
      var min = cfg.min || 0;
      var max = cfg.max || 100;
      var count = cfg.count || 8;
      var step = (max - min) / count;
      var decimals = cfg.decimals || 8;
      var dfactor = Math.pow(10, decimals) || 0;
      var prefix = cfg.prefix || '';
      var values = [];
      var i;

      for (i = min; i < max; i += step) {
        values.push(prefix + Math.round(dfactor * i) / dfactor);
      }

      return values;
    },

    months: function(config) {
      var cfg = config || {};
      var count = cfg.count || 12;
      var section = cfg.section;
      var values = [];
      var i, value;

      for (i = 0; i < count; ++i) {
        value = MONTHS[Math.ceil(i) % 12];
        values.push(value.substring(0, section));
      }

      return values;
    },

    color: function(index) {
      return COLORS[index % COLORS.length];
    },

    transparentize: function(color, opacity) {
      var alpha = opacity === undefined ? 0.5 : 1 - opacity;
      return Color(color).alpha(alpha).rgbString();
    }
  };

  // DEPRECATED
  window.randomScalingFactor = function() {
    return Math.round(Samples.utils.rand(-100, 100));
  };

  // INITIALIZATION

  Samples.utils.srand(Date.now());



}(this));

  

<?php if(is_user()){ ?>
  function createConfig(position) {
      return {
        type: 'line',
        data: {
          labels: [
                "<?=$sub_month[6].'-'.$sub_year[6]?>", 
                "<?=$sub_month[5].'-'.$sub_year[5]?>", 
                "<?=$sub_month[4].'-'.$sub_year[4]?>", 
                "<?=$sub_month[3].'-'.$sub_year[3]?>", 
                "<?=$sub_month[2].'-'.$sub_year[2]?>", 
                "<?=$sub_month[1].'-'.$sub_year[1]?>", 
                "<?=$sub_month[0].'-'.$sub_year[0]?>", 
            ],
          datasets: [{
            label: 'Total Subscriptions',
            borderColor: '#0899a4',
            backgroundColor: 'rgba(8, 153, 164, 0.14)',
            pointBackgroundColor: '#0899a4',
            pointBorderColor: '#fff',
            pointRadius: 4,
            lineTension: 0.35,
            data: [   
                  "<?=$tot_subscribes[6]?>", 
                  "<?=$tot_subscribes[5]?>", 
                  "<?=$tot_subscribes[4]?>", 
                  "<?=$tot_subscribes[3]?>", 
                  "<?=$tot_subscribes[2]?>", 
                  "<?=$tot_subscribes[1]?>", 
                  "<?=$tot_subscribes[0]?>", 
              ],
            fill: true,
          }, /*{
            label: 'My Second dataset',
            borderColor: window.chartColors.blue,
            backgroundColor: window.chartColors.blue,
            data: [7, 49, 46, 13, 25, 30, 22],
            fill: false,
          },*/
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          title: {
            display: false
          },
          legend: {
            display: false
          },
          tooltips: {
            position: position,
            mode: 'index',
            intersect: false,
          },
          scales: {
            yAxes: [{
              ticks: { min: 0, beginAtZero: true, precision: 0, fontColor: '#64748b' },
              gridLines: { color: '#eef1f5' }
            }],
            xAxes: [{
              ticks: { fontColor: '#64748b' },
              gridLines: { display: false }
            }]
          }
        }
      };
    }
    
    window.onload = function() {
      var container = document.querySelector('.subscription_chart');
      if (!container) return;

      ['average'].forEach(function(position) {
        var div = document.createElement('div');
        div.classList.add('chart-container');

        var canvas = document.createElement('canvas');
        div.appendChild(canvas);
        container.appendChild(div);

        var ctx = canvas.getContext('2d');
        var config = createConfig(position);
        new Chart(ctx, config);
      });
    };
<?php } ?>

    //BAR CHART
<?php if(!is_user()){ ?>
    $(function(){

  //get the bar chart canvas
  var ctx = $(".bar-chartcanvas");
  if (!ctx.length) return;

  //bar chart data
  var data = {
    labels: [
                "<?=$month[6]?>", 
                "<?=$month[5]?>", 
                "<?=$month[4]?>", 
                "<?=$month[3]?>", 
                "<?=$month[2]?>", 
                "<?=$month[1]?>", 
                "<?=$month[0]?>", 
            ],
    datasets: [
      {
        label: "<?= $this->lang->line('purchase'); ?>",
        data: [   
                  "<?=$purchase[6]?>", 
                  "<?=$purchase[5]?>", 
                  "<?=$purchase[4]?>", 
                  "<?=$purchase[3]?>", 
                  "<?=$purchase[2]?>", 
                  "<?=$purchase[1]?>", 
                  "<?=$purchase[0]?>", 
              ],
        borderColor: '#0899a4',
        backgroundColor: '#0899a4',
        borderWidth: 0
      },
      {
       label: "<?= $this->lang->line('sales'); ?>",
        data: [   
                  "<?=$sales[6]?>", 
                  "<?=$sales[5]?>", 
                  "<?=$sales[4]?>", 
                  "<?=$sales[3]?>", 
                  "<?=$sales[2]?>", 
                  "<?=$sales[1]?>", 
                  "<?=$sales[0]?>", 
              ],
        borderColor: '#ea7916',
        backgroundColor: '#ea7916',
        borderWidth: 0
      },
      {
        label: "<?= $this->lang->line('expense'); ?>",
        data: [   
                  "<?=$expense[6]?>", 
                  "<?=$expense[5]?>", 
                  "<?=$expense[4]?>", 
                  "<?=$expense[3]?>", 
                  "<?=$expense[2]?>", 
                  "<?=$expense[1]?>", 
                  "<?=$expense[0]?>", 
              ],
        borderColor: '#811ba0',
        backgroundColor: '#811ba0',
        borderWidth: 0
      }
    ]
  };

  //options
  var options = {
    responsive: true,
    maintainAspectRatio: false,
    title: { display: false },
    legend: {
      display: true,
      position: "top",
      labels: {
        fontColor: "#3a4656",
        fontSize: 12
      }
    },
    scales: {
      yAxes: [{
        ticks: { min: 0, fontColor: '#66758a' },
        gridLines: { color: '#eef1f5' }
      }],
      xAxes: [{
        ticks: { fontColor: '#66758a' },
        gridLines: { display: false }
      }]
    }
  };
  //create Chart class object
  var chart = new Chart(ctx, {
    type: "bar",
    data: data,
    options: options
  });
});


  //PIE CHART
  
  var donutEl = document.getElementById("doughnut-chart");
  if (donutEl) {
  new Chart(donutEl, {
    type: 'doughnut',
    data: {
      labels: 
              [
                <?php if($tranding_item['tot_rec'] > 0){?>
                    <?php for($i=$tranding_item['tot_rec']; $i>0; $i--){ ?>
                        '<?= $tranding_item[$i]['name'] ?>',
                    <?php } ?>
                <?php } ?>
              ],
      datasets: [
        {
          label: "Top Items",
          backgroundColor: ["#0899a4", "#0dbec7", "#ea7916", "#f97316", "#811ba0", "#9333ea", "#2563eb", "#3b82f6", "#059669", "#10b981"],
          data: [
                <?php if($tranding_item['tot_rec'] > 0){?>
                    <?php for($i=$tranding_item['tot_rec']; $i>0; $i--){ ?>
                        '<?= $tranding_item[$i]['sales_qty'] ?>',
                    <?php } ?>
                <?php } ?>
              ],
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      legend: {
        position: 'bottom',
        labels: { fontColor: '#3a4656', fontSize: 11, boxWidth: 12 }
      },
      title: { display: false }
    }
});
  }
<?php } ?>

  </script>




<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
<script type="text/javascript">
    var base_url='<?= base_url(); ?>';
    function get_dashboard_values(dates=''){
      var store_id =<?= (isset($store_id)) ? $store_id : get_current_store_id();?>;
      $.post(base_url+"dashboard/dashboard_values",{store_id:store_id,dates:dates},function(result){
          var data = jQuery.parseJSON(result);
          $.each(data, function(index, element) {
                  $("."+index).html(element);
          });
      });
    }

    $("#store_id").on("change",function(){
      //get_dashboard_values();
      $("#dashboard_form").submit();
    });
    jQuery(document).ready(function($) {
      get_dashboard_values('Today');
    });

      $(".get_tab_records").on("click",function(event) {
        $(".get_tab_records").removeClass('active');
        $(this).addClass('active');
        get_dashboard_values($(this).html());
      });


    <?php if(is_admin() && store_module()){ ?>
      $("#stores_details").DataTable();
    <?php } ?>
</script>
<script>
 /* $(function () {
    $('#example3').DataTable({
      "pageLength" : 5,
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });*/


 $(document).ready(function() {
    if (!$('#example2').length) return;
   var table = $('#example2').DataTable({ 

      /* FOR EXPORT BUTTONS START*/
  dom:'<"row margin-bottom-12"<"col-sm-12"<"pull-left"l><"pull-right"fr><"pull-right margin-left-10 "B>>>tip',
 /* dom:'<"row"<"col-sm-12"<"pull-left"B><"pull-right">>> <"row margin-bottom-12"<"col-sm-12"<"pull-left"l><"pull-right"fr>>>tip',*/
      buttons: {
        buttons: [
            {
                className: 'btn bg-red color-palette btn-flat hidden delete_btn pull-left',
                text: 'Delete',
                action: function ( e, dt, node, config ) {
                    multi_delete();
                }
            },
            { extend: 'copy', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [0,1,2,3,4]} },
            { extend: 'excel', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [0,1,2,3,4]} },
            { extend: 'pdf', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [0,1,2,3,4]} },
            { extend: 'print', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [0,1,2,3,4]} },
            { extend: 'csv', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [0,1,2,3,4]} },
            { extend: 'colvis', className: 'btn bg-teal color-palette btn-flat',text:'Columns' },  

            ]
        },
        /* FOR EXPORT BUTTONS END */

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "responsive": true,
        language: {
            processing: '<div class="text-primary bg-primary" style="position: relative;z-index:100;overflow: visible;">Processing...</div>'
        },
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('dashboard/ajax_list')?>",
            "type": "POST",
            
            complete: function (data) {
             },

        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            //"targets": [ 0,4 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        {
            //"targets" :[0],
            //"className": "text-center",
        },
        
        ],
    });
    new $.fn.dataTable.FixedHeader( table );
});
</script>

</body>
</html>
