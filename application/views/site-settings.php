<!DOCTYPE html>
<html>
   
   <head>
  <!-- TABLES CSS CODE -->
  <?php include"comman/code_css.php"; ?>
  <!-- </copy> -->  
  </head>

   <body class="hold-transition skin-blue sidebar-mini">
      <div class="wrapper">
         <?php include"sidebar.php"; ?>
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <h1>
                  <?= $this->lang->line('site_settings'); ?>
                  <small><?= $this->lang->line('add_or_update'); ?> <?= $this->lang->line('site_settings'); ?></small>
               </h1>
               <ol class="breadcrumb">
                  <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                  <li class="active">Site Settings</li>
               </ol>
            </section>
            
            <!-- Main content -->
  <?= form_open('#', array('class' => 'form-horizontal', 'id' => 'site-form', 'enctype'=>'multipart/form-data', 'method'=>'POST'));?>
            <section class="content">
               <div class="row">
                  <!-- ********** ALERT MESSAGE START******* -->
                <?php include"comman/code_flashdata.php"; ?>
                  <!-- ********** ALERT MESSAGE END******* -->

                  <div class="col-md-12">
                     <!-- Custom Tabs -->
                     <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                           <li class="active"><a href="#tab_1" data-toggle="tab"><?= $this->lang->line('site'); ?></a></li>
                           
                        </ul>
                        <div class="tab-content">
                           <div class="tab-pane active" id="tab_1">
                              <div class="row">
                                 <!-- right column -->
                                 <div class="col-md-12">
                                    <!-- form start -->
                                       <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                                       <div class="box-body">
                                          <div class="row">
                                             <div class="col-md-5">
                                                <div class="form-group">
                                                   <label for="site_name" class="col-sm-4 control-label"><?= $this->lang->line('site_name'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="site_name" name="site_name" placeholder="" onkeyup="shift_cursor(event,'mobile')" value="<?php print $site_name; ?>" >
                                                      <span id="site_name_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                                
                                             </div>
                                             <div class="col-md-5">
                                                <div class="form-group">
                                                   <label for="address" class="col-sm-4 control-label"><?= $this->lang->line('site_logo'); ?></label>
                                                   <div class="col-sm-8">
                                                      <input type="file" id="logo" name="logo">
                                                      <span id="logo_msg" style="display:block;" class="text-danger">Max Width/Height: 300px * 300px & Size: 300px </span>
                                                   </div>
                                                </div>
                                                <?php 
                                                if(empty($logo)){
                                                  $logo = base_url('uploads/no_logo/nologo.png');
                                                }
                                                else{
                                                  $logo = base_url($logo);
                                                }
                                                ?>
                                                <div class="form-group">
                                                   <div class="col-sm-8 col-sm-offset-4">
                                                      <img class='img-responsive' style='border:3px solid #d2d6de;' src="<?php echo $logo;?>">
                                                   </div>
                                                </div>
                                             </div>
                                             
<!-- START: SIDEBAR & SUBMENU THEME CUSTOMIZER -->
<div class="col-md-12" style="margin-top: 15px; margin-bottom: 20px;">
   <div style="border: 1px solid #cbd5e1; border-radius: 10px; background: #ffffff; box-shadow: 0 2px 8px rgba(0,0,0,0.04); overflow: hidden;">
      <div style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: #ffffff; padding: 12px 18px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
         <div style="display:flex; align-items:center; gap:10px;">
            <i class="fa fa-paint-brush text-cyan" style="font-size:17px; color:#38bdf8;"></i>
            <h4 style="margin:0; font-size:15px; font-weight:700; letter-spacing:0.3px; color:#ffffff;">Sidebar & Submenu Appearance</h4>
         </div>
         <span style="font-size:11.5px; color:#94a3b8; font-weight:500;">Header, Sidebar, Submenu & Hover Controls</span>
      </div>

      <div style="padding: 18px 20px;">
         <div class="row">
            <!-- 1. Background Color -->
            <div class="col-md-4" style="border-right: 1px solid #f1f5f9; padding-right: 15px; margin-bottom: 15px;">
               <div class="form-group" style="margin-bottom: 10px;">
                  <label style="font-weight:700; font-size:13px; color:#1e293b; display:block; margin-bottom:6px;">
                     1. Sidebar Background Color <span style="font-size:11px; font-weight:normal; color:#64748b;">(Navigation background)</span>
                  </label>
                  <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                     <input type="color" id="sidebar_color_picker" value="<?php echo !empty($sidebar_color) ? $sidebar_color : '#ffffff'; ?>" style="width:44px; height:38px; padding:2px; border:1px solid #cbd5e1; border-radius:6px; cursor:pointer;" oninput="updateSidebarBg(this.value);">
                     <input type="text" class="form-control" id="sidebar_color" name="sidebar_color" value="<?php echo !empty($sidebar_color) ? $sidebar_color : '#ffffff'; ?>" style="width:125px; font-weight:700; text-transform:uppercase; font-size:13px;" oninput="updateSidebarBg(this.value);" placeholder="#ffffff">
                  </div>
                  <div style="font-size:11px; color:#64748b; margin-bottom:6px; font-weight:600;">Quick Presets:</div>
                  <div style="display:flex; gap:5px; flex-wrap:wrap;">
                     <button type="button" class="btn btn-xs" style="background:#ffffff; color:#111; border:1px solid #cbd5e1; font-weight:700;" onclick="updateSidebarBg('#ffffff')">White</button>
                     <button type="button" class="btn btn-xs" style="background:#0f172a; color:#fff;" onclick="updateSidebarBg('#0f172a')">Navy</button>
                     <button type="button" class="btn btn-xs" style="background:#1e293b; color:#fff;" onclick="updateSidebarBg('#1e293b')">Slate</button>
                     <button type="button" class="btn btn-xs" style="background:#1e3a8a; color:#fff;" onclick="updateSidebarBg('#1e3a8a')">Blue</button>
                     <button type="button" class="btn btn-xs" style="background:#064e3b; color:#fff;" onclick="updateSidebarBg('#064e3b')">Green</button>
                     <button type="button" class="btn btn-xs" style="background:#4c1d95; color:#fff;" onclick="updateSidebarBg('#4c1d95')">Purple</button>
                     <button type="button" class="btn btn-xs" style="background:#831843; color:#fff;" onclick="updateSidebarBg('#831843')">Wine</button>
                     <button type="button" class="btn btn-xs" style="background:#0a0a0a; color:#fff;" onclick="updateSidebarBg('#0a0a0a')">Black</button>
                  </div>
               </div>
            </div>

            <!-- 2. Font / Text Color -->
            <div class="col-md-4" style="border-right: 1px solid #f1f5f9; padding-right: 15px; margin-bottom: 15px;">
               <div class="form-group" style="margin-bottom: 10px;">
                  <label style="font-weight:700; font-size:13px; color:#1e293b; display:block; margin-bottom:6px;">
                     2. Menu Font Color <span style="font-size:11px; font-weight:normal; color:#64748b;">(Navigation text color)</span>
                  </label>
                  <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                     <input type="color" id="sidebar_font_color_picker" value="<?php echo !empty($sidebar_font_color) ? $sidebar_font_color : '#1e293b'; ?>" style="width:44px; height:38px; padding:2px; border:1px solid #cbd5e1; border-radius:6px; cursor:pointer;" oninput="updateSidebarFont(this.value);">
                     <input type="text" class="form-control" id="sidebar_font_color" name="sidebar_font_color" value="<?php echo !empty($sidebar_font_color) ? $sidebar_font_color : '#1e293b'; ?>" style="width:125px; font-weight:700; text-transform:uppercase; font-size:13px;" oninput="updateSidebarFont(this.value);" placeholder="#1e293b">
                  </div>
                  <div style="font-size:11px; color:#64748b; margin-bottom:6px; font-weight:600;">Quick Presets:</div>
                  <div style="display:flex; gap:5px; flex-wrap:wrap;">
                     <button type="button" class="btn btn-xs" style="background:#ffffff; color:#111; border:1px solid #cbd5e1; font-weight:700;" onclick="updateSidebarFont('#ffffff')">Pure White</button>
                     <button type="button" class="btn btn-xs" style="background:#f8fafc; color:#111; border:1px solid #cbd5e1; font-weight:700;" onclick="updateSidebarFont('#f8fafc')">Off White</button>
                     <button type="button" class="btn btn-xs" style="background:#1e293b; color:#fff;" onclick="updateSidebarFont('#1e293b')">Dark Slate</button>
                     <button type="button" class="btn btn-xs" style="background:#334155; color:#fff;" onclick="updateSidebarFont('#334155')">Charcoal</button>
                     <button type="button" class="btn btn-xs" style="background:#facc15; color:#111; font-weight:700;" onclick="updateSidebarFont('#facc15')">Amber</button>
                     <button type="button" class="btn btn-xs" style="background:#38bdf8; color:#111; font-weight:700;" onclick="updateSidebarFont('#38bdf8')">Cyan</button>
                     <button type="button" class="btn btn-xs" style="background:#4ade80; color:#111; font-weight:700;" onclick="updateSidebarFont('#4ade80')">Green</button>
                  </div>
               </div>
            </div>

            <!-- 3. Selector / Active Highlight Color -->
            <div class="col-md-4" style="margin-bottom: 15px;">
               <div class="form-group" style="margin-bottom: 10px;">
                  <label style="font-weight:700; font-size:13px; color:#1e293b; display:block; margin-bottom:6px;">
                     3. Main Active Color <span style="font-size:11px; font-weight:normal; color:#64748b;">(Active menu item highlight)</span>
                  </label>
                  <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                     <input type="color" id="sidebar_active_color_picker" value="<?php echo !empty($sidebar_active_color) ? $sidebar_active_color : '#0284c7'; ?>" style="width:44px; height:38px; padding:2px; border:1px solid #cbd5e1; border-radius:6px; cursor:pointer;" oninput="updateSidebarActive(this.value);">
                     <input type="text" class="form-control" id="sidebar_active_color" name="sidebar_active_color" value="<?php echo !empty($sidebar_active_color) ? $sidebar_active_color : '#0284c7'; ?>" style="width:125px; font-weight:700; text-transform:uppercase; font-size:13px;" oninput="updateSidebarActive(this.value);" placeholder="#0284c7">
                  </div>
                  <div style="font-size:11px; color:#64748b; margin-bottom:6px; font-weight:600;">Quick Presets:</div>
                  <div style="display:flex; gap:5px; flex-wrap:wrap;">
                     <button type="button" class="btn btn-xs" style="background:#0284c7; color:#fff;" onclick="updateSidebarActive('#0284c7')">Sky Blue</button>
                     <button type="button" class="btn btn-xs" style="background:#00c2cb; color:#fff;" onclick="updateSidebarActive('#00c2cb')">Cyan</button>
                     <button type="button" class="btn btn-xs" style="background:#ff6b00; color:#fff;" onclick="updateSidebarActive('#ff6b00')">Orange</button>
                     <button type="button" class="btn btn-xs" style="background:#10b981; color:#fff;" onclick="updateSidebarActive('#10b981')">Emerald</button>
                     <button type="button" class="btn btn-xs" style="background:#8b5cf6; color:#fff;" onclick="updateSidebarActive('#8b5cf6')">Purple</button>
                     <button type="button" class="btn btn-xs" style="background:#ec4899; color:#fff;" onclick="updateSidebarActive('#ec4899')">Pink</button>
                     <button type="button" class="btn btn-xs" style="background:#ef4444; color:#fff;" onclick="updateSidebarActive('#ef4444')">Red</button>
                  </div>
               </div>
            </div>
         </div>

         <!-- Row 2: Submenu Background & Submenu Hover / Pointer Color -->
         <div class="row" style="border-top: 1px dashed #e2e8f0; padding-top: 15px; margin-top: 5px;">
            <!-- 4. Submenu Background Color -->
            <div class="col-md-6" style="border-right: 1px solid #f1f5f9; padding-right: 15px; margin-bottom: 10px;">
               <div class="form-group" style="margin-bottom: 10px;">
                  <label style="font-weight:700; font-size:13px; color:#1e293b; display:block; margin-bottom:6px;">
                     4. Submenu Background Color <span style="font-size:11px; font-weight:normal; color:#64748b;">(Submenu dropdown background)</span>
                  </label>
                  <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                     <input type="color" id="sidebar_submenu_color_picker" value="<?php echo !empty($sidebar_submenu_color) ? $sidebar_submenu_color : '#0f172a'; ?>" style="width:44px; height:38px; padding:2px; border:1px solid #cbd5e1; border-radius:6px; cursor:pointer;" oninput="updateSidebarSubmenu(this.value);">
                     <input type="text" class="form-control" id="sidebar_submenu_color" name="sidebar_submenu_color" value="<?php echo !empty($sidebar_submenu_color) ? $sidebar_submenu_color : ''; ?>" style="width:140px; font-weight:700; text-transform:uppercase; font-size:13px;" oninput="updateSidebarSubmenu(this.value);" placeholder="e.g. #0F172A">
                  </div>
                  <div style="font-size:11px; color:#64748b; margin-bottom:6px; font-weight:600;">Quick Presets:</div>
                  <div style="display:flex; gap:5px; flex-wrap:wrap;">
                     <button type="button" class="btn btn-xs" style="background:#0f172a; color:#fff;" onclick="updateSidebarSubmenu('#0f172a')">Deep Navy</button>
                     <button type="button" class="btn btn-xs" style="background:#1e293b; color:#fff;" onclick="updateSidebarSubmenu('#1e293b')">Dark Slate</button>
                     <button type="button" class="btn btn-xs" style="background:#022c22; color:#fff;" onclick="updateSidebarSubmenu('#022c22')">Dark Pine</button>
                     <button type="button" class="btn btn-xs" style="background:#172554; color:#fff;" onclick="updateSidebarSubmenu('#172554')">Midnight Blue</button>
                     <button type="button" class="btn btn-xs" style="background:#2e1065; color:#fff;" onclick="updateSidebarSubmenu('#2e1065')">Dark Violet</button>
                     <button type="button" class="btn btn-xs" style="background:#f1f5f9; color:#111; border:1px solid #cbd5e1;" onclick="updateSidebarSubmenu('#f1f5f9')">Light Grey</button>
                     <button type="button" class="btn btn-xs" style="background:#ffffff; color:#111; border:1px solid #cbd5e1;" onclick="updateSidebarSubmenu('#ffffff')">Pure White</button>
                  </div>
               </div>
            </div>

            <!-- 5. Submenu Hover / Pointer Color -->
            <div class="col-md-6" style="margin-bottom: 10px;">
               <div class="form-group" style="margin-bottom: 10px;">
                  <label style="font-weight:700; font-size:13px; color:#1e293b; display:block; margin-bottom:6px;">
                     5. Submenu Hover / Pointer Color <span style="font-size:11px; font-weight:normal; color:#64748b;">(Submenu hover / active pointer color)</span>
                  </label>
                  <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                     <input type="color" id="sidebar_submenu_hover_color_picker" value="<?php echo !empty($sidebar_submenu_hover_color) ? $sidebar_submenu_hover_color : '#0284c7'; ?>" style="width:44px; height:38px; padding:2px; border:1px solid #cbd5e1; border-radius:6px; cursor:pointer;" oninput="updateSidebarSubmenuHover(this.value);">
                     <input type="text" class="form-control" id="sidebar_submenu_hover_color" name="sidebar_submenu_hover_color" value="<?php echo !empty($sidebar_submenu_hover_color) ? $sidebar_submenu_hover_color : ''; ?>" style="width:140px; font-weight:700; text-transform:uppercase; font-size:13px;" oninput="updateSidebarSubmenuHover(this.value);" placeholder="e.g. #0284C7">
                  </div>
                  <div style="font-size:11px; color:#64748b; margin-bottom:6px; font-weight:600;">Quick Presets:</div>
                  <div style="display:flex; gap:5px; flex-wrap:wrap;">
                     <button type="button" class="btn btn-xs" style="background:#38bdf8; color:#111; font-weight:700;" onclick="updateSidebarSubmenuHover('#38bdf8')">Sky Cyan</button>
                     <button type="button" class="btn btn-xs" style="background:#4ade80; color:#111; font-weight:700;" onclick="updateSidebarSubmenuHover('#4ade80')">Mint Green</button>
                     <button type="button" class="btn btn-xs" style="background:#fbbf24; color:#111; font-weight:700;" onclick="updateSidebarSubmenuHover('#fbbf24')">Bright Amber</button>
                     <button type="button" class="btn btn-xs" style="background:#0284c7; color:#fff;" onclick="updateSidebarSubmenuHover('#0284c7')">Sky Blue</button>
                     <button type="button" class="btn btn-xs" style="background:#ff6b00; color:#fff;" onclick="updateSidebarSubmenuHover('#ff6b00')">Orange</button>
                     <button type="button" class="btn btn-xs" style="background:#a855f7; color:#fff;" onclick="updateSidebarSubmenuHover('#a855f7')">Purple</button>
                     <button type="button" class="btn btn-xs" style="background:#f43f5e; color:#fff;" onclick="updateSidebarSubmenuHover('#f43f5e')">Rose</button>
                  </div>
               </div>
            </div>
         </div>

         <!-- Live Preview Box -->
         <div style="margin-top: 15px; padding: 14px 18px; border-radius: 8px; border: 1px solid #cbd5e1; transition: all 0.2s ease;" id="sb_live_preview_box">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px; border-bottom:1px dashed rgba(128,128,128,0.25); padding-bottom:8px;">
               <div style="display:flex; align-items:center; gap:8px;">
                  <i class="fa fa-eye" style="font-size:15px;" id="sb_preview_eye"></i>
                  <span style="font-weight:700; font-size:12px; text-transform:uppercase; letter-spacing:0.6px;" id="sb_preview_heading">Live Interactive Preview:</span>
               </div>
               <span style="font-size:11px; color:#94a3b8;">Move your mouse over the submenu to preview hover</span>
            </div>

            <div style="display:flex; align-items:flex-start; gap:16px; flex-wrap:wrap;">
               <!-- Shop Name preview (Top seamless header) -->
               <div style="padding: 9px 18px; border-radius: 6px; font-weight: 700; font-size: 13.5px; display: inline-flex; align-items: center; gap: 8px; border-right: 2px solid rgba(2, 132, 199, 0.4);" id="sb_preview_shop">
                  <i class="fa fa-shopping-bag"></i> <span>Shop Name (Top Bar Seamless)</span>
               </div>

               <!-- Normal item preview -->
               <div style="padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 13px; display: inline-flex; align-items: center; gap: 8px;" id="sb_preview_normal">
                  <i class="fa fa-dashboard" style="color:#00c2cb;"></i> <span>Dashboard (Normal)</span>
               </div>

               <!-- Active Main Item preview -->
               <div style="padding: 8px 16px; border-radius: 6px; font-weight: 700; font-size: 13px; display: inline-flex; align-items: center; gap: 8px;" id="sb_preview_active">
                  <i class="fa fa-user-plus" id="sb_preview_active_icon"></i> <span>Users (Active Menu)</span>
               </div>

               <!-- Submenu preview box -->
               <div style="padding: 8px 10px; border-radius: 8px; min-width: 250px; border: 1px solid rgba(0,0,0,0.12); display: flex; flex-direction: column; gap: 4px;" id="sb_preview_sub_box">
                  <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.7; margin-bottom: 2px;" id="sb_preview_sub_lbl">Submenu Items:</div>
                  <div style="padding: 6px 10px; border-radius: 5px; font-size: 12.5px; font-weight: 500; display: flex; align-items: center; gap: 8px; cursor: default; transition: all 0.15s ease;" id="sb_preview_sub_item1">
                     <i class="fa fa-list" id="sb_preview_sub_i1"></i> <span>Users List (Normal)</span>
                  </div>
                  <div style="padding: 6px 10px; border-radius: 5px; font-size: 12.5px; font-weight: 700; display: flex; align-items: center; gap: 8px; cursor: pointer; transition: all 0.15s ease;" id="sb_preview_sub_item2">
                     <i class="fa fa-plus-square" id="sb_preview_sub_i2"></i> <span>Roles List (Mouse Hover / Pointer)</span>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script type="text/javascript">
function sbHexToRgb(hex) {
   var c = (hex || '').replace('#', '');
   if (c.length === 3) c = c[0] + c[0] + c[1] + c[1] + c[2] + c[2];
   if (c.length === 6) {
      return {
         r: parseInt(c.substring(0, 2), 16),
         g: parseInt(c.substring(2, 4), 16),
         b: parseInt(c.substring(4, 6), 16)
      };
   }
   return { r: 2, g: 132, b: 199 };
}

function refreshSidebarLivePreview() {
   var bg = $('#sidebar_color').val() || '#ffffff';
   var font = $('#sidebar_font_color').val() || '#1e293b';
   var act = $('#sidebar_active_color').val() || '#0284c7';
   var subBg = $('#sidebar_submenu_color').val() || '';
   var subHover = $('#sidebar_submenu_hover_color').val() || act;

   var actRgb = sbHexToRgb(act);

   if (!subBg) {
      var bgClean = bg.replace('#', '');
      var lum = 255;
      if (bgClean.length === 6) {
         lum = 0.299 * parseInt(bgClean.substring(0,2),16) + 0.587 * parseInt(bgClean.substring(2,4),16) + 0.114 * parseInt(bgClean.substring(4,6),16);
      }
      subBg = (lum < 150) ? 'rgba(0, 0, 0, 0.22)' : 'rgba(0, 0, 0, 0.05)';
   }
   var subHoverRgb = sbHexToRgb(subHover);

   $('#sb_live_preview_box').css('background-color', bg);
   $('#sb_preview_eye').css('color', font);
   $('#sb_preview_heading').css('color', font);

   // Shop Name Preview
   $('#sb_preview_shop').css({
      'background-color': bg,
      'color': font,
      'border-right': '2px solid ' + act
   });
   $('#sb_preview_shop span, #sb_preview_shop i').css('color', font);

   // Normal Menu Item
   $('#sb_preview_normal').css('color', font);
   $('#sb_preview_normal span').css('color', font);

   // Active Main Menu Item
   $('#sb_preview_active').css({
      'background-color': 'rgba(' + actRgb.r + ',' + actRgb.g + ',' + actRgb.b + ', 0.22)',
      'color': font,
      'border-left': '4px solid ' + act
   });
   $('#sb_preview_active span').css('color', font);
   $('#sb_preview_active_icon').css('color', act);

   // Submenu Container
   $('#sb_preview_sub_box').css({
      'background-color': subBg,
      'border-color': 'rgba(' + subHoverRgb.r + ',' + subHoverRgb.g + ',' + subHoverRgb.b + ', 0.25)'
   });
   $('#sb_preview_sub_lbl').css('color', font);

   // Submenu Item 1 (Normal)
   $('#sb_preview_sub_item1').css({
      'background-color': 'transparent',
      'color': font,
      'border-left': '3px solid transparent'
   });
   $('#sb_preview_sub_item1 span').css('color', font);
   $('#sb_preview_sub_i1').css('color', subHover);

   // Submenu Item 2 (Hover / Pointer)
   $('#sb_preview_sub_item2').css({
      'background-color': 'rgba(' + subHoverRgb.r + ',' + subHoverRgb.g + ',' + subHoverRgb.b + ', 0.22)',
      'color': subHover,
      'border-left': '3px solid ' + subHover
   });
   $('#sb_preview_sub_item2 span').css('color', subHover);
   $('#sb_preview_sub_i2').css('color', subHover);
}

function updateSidebarBg(val) {
   $('#sidebar_color').val(val);
   $('#sidebar_color_picker').val(val);
   refreshSidebarLivePreview();
}

function updateSidebarFont(val) {
   $('#sidebar_font_color').val(val);
   $('#sidebar_font_color_picker').val(val);
   refreshSidebarLivePreview();
}

function updateSidebarActive(val) {
   $('#sidebar_active_color').val(val);
   $('#sidebar_active_color_picker').val(val);
   refreshSidebarLivePreview();
}

function updateSidebarSubmenu(val) {
   $('#sidebar_submenu_color').val(val);
   $('#sidebar_submenu_color_picker').val(val);
   refreshSidebarLivePreview();
}

function updateSidebarSubmenuHover(val) {
   $('#sidebar_submenu_hover_color').val(val);
   $('#sidebar_submenu_hover_color_picker').val(val);
   refreshSidebarLivePreview();
}

$(document).ready(function() {
   refreshSidebarLivePreview();
});
</script>
<!-- END: SIDEBAR & SUBMENU THEME CUSTOMIZER -->
<!-- ########### -->
                                          </div>
                                       </div>
                                       <!-- /.box-body -->
                                       <!-- /.box-footer -->
                                    
                                 </div>
                                 <!--/.col (right) -->
                              </div>
                              <!-- /.row -->
                           </div>
                           <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                     </div>
                     <!-- nav-tabs-custom -->
                     <div>
                        <div class="col-sm-8 col-sm-offset-2 text-center">
                           <center>
                              <?php
                                 if($site_name!=""){
                                      $btn_name="Update";
                                      $btn_id="update";
                                      ?>
                              <input type="hidden" name="q_id" id="q_id" value="<?php echo $q_id;?>"/>
                              <?php
                                 }
                                 else{
                                     $btn_name="Save";
                                     $btn_id="save";
                                 }
                                 
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
                     </div>
                  </div>
                  <!-- /.col -->
               </div>
               <!-- /.row -->
            </section>
            <!-- /.content -->
            <?= form_close(); ?>
         </div>
         <!-- /.content-wrapper -->
         <?php include"footer.php"; ?>
         <!-- Add the sidebar's background. This div must be placed
            immediately after the control sidebar -->
         <div class="control-sidebar-bg"></div>
      </div>
      <!-- ./wrapper -->
      
      <?php include'comman/code_js_language.php'; ?>

      <!-- SOUND CODE -->
      <?php include"comman/code_js_sound.php"; ?>
      <!-- TABLES CODE -->
      <?php include"comman/code_js.php"; ?>

      <script type="text/javascript">
         $(document).submit(function(event) {
           event.preventDefault();
           if($("#update").length){
             $("#update").trigger('click');
           }
         });
      </script>
      <script src="<?php echo $theme_link; ?>js/site-settings.js"></script>
     
 
      <!-- Make sidebar menu hughlighter/selector -->
      <script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
   </body>
</html>
