<!-- Theme color & cleanup -->
<script type="text/javascript">
  if(theme_skin != 'skin-blue'){
    $("body").addClass(theme_skin);
    $("body").removeClass('skin-blue');
  }
  if(sidebar_collapse == 'true'){
    $("body").addClass('sidebar-collapse');
  }
  try {
    localStorage.removeItem('pos_theme_mode');
    $("body").removeClass('dark-mode');
    document.documentElement.classList.remove('dark-mode');
  } catch(e) {}
</script>

<?php 
  $CI =& get_instance();

  // Custom Sidebar Colors configured by Store or Super Admin
  $custom_sidebar_bg = '#ffffff';
  $custom_sidebar_font = '#1e293b';
  $custom_sidebar_active = '#0284c7';
  $custom_sidebar_submenu_bg = '';
  $custom_sidebar_submenu_hover = '';

  if (is_admin()) {
    $q_site = $CI->db->select('sidebar_color, sidebar_font_color, sidebar_active_color, sidebar_submenu_color, sidebar_submenu_hover_color')->where('id', 1)->get('db_sitesettings')->row();
    if (!empty($q_site)) {
      if (!empty($q_site->sidebar_color)) $custom_sidebar_bg = $q_site->sidebar_color;
      if (!empty($q_site->sidebar_font_color)) $custom_sidebar_font = $q_site->sidebar_font_color;
      if (!empty($q_site->sidebar_active_color)) $custom_sidebar_active = $q_site->sidebar_active_color;
      if (!empty($q_site->sidebar_submenu_color)) $custom_sidebar_submenu_bg = $q_site->sidebar_submenu_color;
      if (!empty($q_site->sidebar_submenu_hover_color)) $custom_sidebar_submenu_hover = $q_site->sidebar_submenu_hover_color;
    }
  } else {
    $q_store = get_store_details();
    if (!empty($q_store)) {
      if (!empty($q_store->sidebar_color)) $custom_sidebar_bg = $q_store->sidebar_color;
      if (!empty($q_store->sidebar_font_color)) $custom_sidebar_font = $q_store->sidebar_font_color;
      if (!empty($q_store->sidebar_active_color)) $custom_sidebar_active = $q_store->sidebar_active_color;
      if (!empty($q_store->sidebar_submenu_color)) $custom_sidebar_submenu_bg = $q_store->sidebar_submenu_color;
      if (!empty($q_store->sidebar_submenu_hover_color)) $custom_sidebar_submenu_hover = $q_store->sidebar_submenu_hover_color;
    }
  }

  // Parse active color hex to RGB for transparent hover/active overlays
  $act_clean = ltrim($custom_sidebar_active, '#');
  if (strlen($act_clean) == 3) {
    $act_clean = $act_clean[0].$act_clean[0].$act_clean[1].$act_clean[1].$act_clean[2].$act_clean[2];
  }
  if (strlen($act_clean) == 6) {
    $act_r = hexdec(substr($act_clean, 0, 2));
    $act_g = hexdec(substr($act_clean, 2, 2));
    $act_b = hexdec(substr($act_clean, 4, 2));
  } else {
    $act_r = 2; $act_g = 132; $act_b = 199;
  }

  // Smart fallback defaults for submenu colors if not explicitly set
  if (empty($custom_sidebar_submenu_bg)) {
    $bg_clean = ltrim($custom_sidebar_bg, '#');
    if (strlen($bg_clean) == 3) $bg_clean = $bg_clean[0].$bg_clean[0].$bg_clean[1].$bg_clean[1].$bg_clean[2].$bg_clean[2];
    $bg_lum = 255;
    if (strlen($bg_clean) == 6) {
      $bg_lum = (0.299 * hexdec(substr($bg_clean, 0, 2)) + 0.587 * hexdec(substr($bg_clean, 2, 2)) + 0.114 * hexdec(substr($bg_clean, 4, 2)));
    }
    $custom_sidebar_submenu_bg = ($bg_lum < 150) ? 'rgba(0, 0, 0, 0.22)' : 'rgba(0, 0, 0, 0.05)';
  }

  if (empty($custom_sidebar_submenu_hover)) {
    $custom_sidebar_submenu_hover = $custom_sidebar_active;
  }

  // Parse submenu hover color hex to RGB
  $sub_h_clean = ltrim($custom_sidebar_submenu_hover, '#');
  if (strlen($sub_h_clean) == 3) {
    $sub_h_clean = $sub_h_clean[0].$sub_h_clean[0].$sub_h_clean[1].$sub_h_clean[1].$sub_h_clean[2].$sub_h_clean[2];
  }
  if (strlen($sub_h_clean) == 6) {
    $sub_hr = hexdec(substr($sub_h_clean, 0, 2));
    $sub_hg = hexdec(substr($sub_h_clean, 2, 2));
    $sub_hb = hexdec(substr($sub_h_clean, 4, 2));
  } else {
    $sub_hr = $act_r; $sub_hg = $act_g; $sub_hb = $act_b;
  }
?>
<link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">
<style type="text/css">
  /* Header bar dimensions */
  .main-header {
    height: 50px !important;
    min-height: 50px !important;
    max-height: 50px !important;
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    z-index: 1030 !important;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05) !important;
    border-bottom: none !important;
    background: #ffffff !important;
  }
  .main-header .navbar {
    height: 50px !important;
    min-height: 50px !important;
    max-height: 50px !important;
    border-bottom: 2px solid transparent !important;
    border-image: linear-gradient(90deg, #ff6b00 0%, #00c2cb 33%, #2563eb 66%, #7c3aed 100%) 1 !important;
    background: #ffffff !important;
  }
  .main-header .navbar-custom-menu {
    height: 50px !important;
    float: right !important;
  }
  .main-header .navbar-custom-menu > .navbar-nav {
    margin: 0 !important;
    height: 50px !important;
    display: flex !important;
    align-items: center !important;
  }
  .main-header .navbar-custom-menu > .navbar-nav > li {
    display: inline-flex !important;
    align-items: center !important;
    height: 50px !important;
  }
  .main-header .navbar-custom-menu > .navbar-nav > li > a {
    height: 50px !important;
    display: inline-flex !important;
    align-items: center !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
  }
  .main-header .navbar-custom-menu > .navbar-nav > li.header-live-watch-wrap {
    float: left !important;
    height: 50px !important;
    max-height: 50px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 0 10px 0 6px !important;
    margin: 0 !important;
    background: transparent !important;
  }

  /* Live watch with multi-color font matching logo & removed outer border */
  .header-live-watch-box {
    background: transparent !important;
    border-radius: 6px !important;
    border: none !important;
    border-top: none !important;
    border-image: none !important;
    box-shadow: none !important;
    padding: 2px 8px 1px !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    justify-content: center !important;
    text-align: center !important;
    height: 44px !important;
    max-height: 44px !important;
    min-width: 145px !important;
    box-sizing: border-box !important;
    line-height: 1 !important;
    user-select: none !important;
    cursor: default !important;
  }

  /* Line 1: Day & Date - Cyan / Teal matching logo */
  .header-live-watch-box .hlw-date {
    font-family: 'Consolas', 'Segoe UI', Tahoma, monospace, sans-serif !important;
    font-size: 11.5px !important;
    font-weight: 700 !important;
    color: #0891b2 !important;
    line-height: 13px !important;
    letter-spacing: 0.3px !important;
    white-space: nowrap !important;
    margin: 0 0 1px 0 !important;
    padding: 0 !important;
    text-align: center !important;
  }

  /* Line 2: Large Bold Time with Slashed Zero & Multi-Color Segments */
  .header-live-watch-box .hlw-time {
    font-family: 'Consolas', 'Share Tech Mono', 'Lucida Console', 'Courier New', monospace !important;
    font-size: 22px !important;
    font-weight: 900 !important;
    line-height: 22px !important;
    letter-spacing: 0.8px !important;
    font-variant-numeric: slashed-zero !important;
    -webkit-font-feature-settings: "zero" 1 !important;
    font-feature-settings: "zero" 1 !important;
    white-space: nowrap !important;
    margin: 0 !important;
    padding: 0 !important;
    text-align: center !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
  }

  .header-live-watch-box .hlw-hour {
    color: #ea580c !important;
    font-weight: 900 !important;
  }
  .header-live-watch-box .hlw-colon {
    color: #94a3b8 !important;
    font-weight: 700 !important;
    margin: 0 1.5px !important;
  }
  .header-live-watch-box .hlw-min {
    color: #2563eb !important;
    font-weight: 900 !important;
  }
  .header-live-watch-box .hlw-sec {
    color: #7c3aed !important;
    font-weight: 900 !important;
  }

  /* Line 3: Client IP - Emerald Green matching logo */
  .header-live-watch-box .hlw-ip {
    font-family: 'Consolas', 'Share Tech Mono', 'Lucida Console', monospace !important;
    font-size: 11px !important;
    font-weight: 700 !important;
    color: #059669 !important;
    line-height: 13px !important;
    letter-spacing: 0.4px !important;
    white-space: nowrap !important;
    margin: 1px 0 0 0 !important;
    padding: 0 !important;
    text-align: center !important;
  }

  /* Desktop and Tablet fixed header layout */
  @media (min-width: 768px) {
    .content-wrapper, .right-side {
      margin-left: 230px !important;
      padding-top: 50px !important;
    }
    .main-header .navbar {
      margin-left: 230px !important;
    }
  }

  /* ========================================================
     DYNAMIC SIDEBAR & SUBMENU THEME ENGINE
     ======================================================== */
  /* 1. Seamless Logo (Shop Name) & Sidebar Alignment & Colors */
  body .main-header .logo,
  body.skin-blue .main-header .logo,
  body .main-header .logo:hover,
  body.skin-blue .main-header .logo:hover,
  body .main-header .logo:focus,
  body.skin-blue .main-header .logo:focus,
  body .main-header .logo:active,
  body.skin-blue .main-header .logo:active,
  body .main-sidebar,
  body.skin-blue .main-sidebar,
  body .left-side,
  body.skin-blue .left-side,
  body .mobile-sidebar-header {
    background: <?= $custom_sidebar_bg; ?> !important;
    background-color: <?= $custom_sidebar_bg; ?> !important;
  }

  /* Desktop Logo / Shop Name exact width, height, and border matching sidebar */
  @media (min-width: 768px) {
    body .main-header .logo,
    body.skin-blue .main-header .logo {
      width: 230px !important;
      min-width: 230px !important;
      max-width: 230px !important;
      height: 50px !important;
      line-height: 50px !important;
      margin: 0 !important;
      padding: 0 15px !important;
      float: left !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      text-align: center !important;
      box-sizing: border-box !important;
      border-right: 1px solid rgba(<?= "{$act_r}, {$act_g}, {$act_b}"; ?>, 0.22) !important;
      border-bottom: none !important;
      border-top: none !important;
      border-left: none !important;
      box-shadow: none !important;
      transition: width 0.3s ease-in-out, background 0.2s ease !important;
    }

    body .main-sidebar,
    body.skin-blue .main-sidebar,
    body .left-side,
    body.skin-blue .left-side {
      width: 230px !important;
      min-width: 230px !important;
      max-width: 230px !important;
      position: fixed !important;
      top: 0 !important;
      bottom: 0 !important;
      left: 0 !important;
      height: 100% !important;
      padding-top: 50px !important;
      z-index: 1020 !important;
      overflow-y: auto !important;
      box-sizing: border-box !important;
      margin: 0 !important;
      border-right: 1px solid rgba(<?= "{$act_r}, {$act_g}, {$act_b}"; ?>, 0.22) !important;
      border-left: none !important;
      border-top: none !important;
      border-bottom: none !important;
      box-shadow: 2px 0 8px rgba(0, 0, 0, 0.04) !important;
      transition: width 0.3s ease-in-out, transform 0.3s ease-in-out !important;
    }
  }

  /* Collapsed sidebar alignment */
  @media (min-width: 768px) {
    body.sidebar-collapse .main-header .logo,
    body.sidebar-mini.sidebar-collapse .main-header .logo {
      width: 50px !important;
      min-width: 50px !important;
      max-width: 50px !important;
      padding: 0 !important;
    }
    body.sidebar-collapse .main-sidebar,
    body.sidebar-mini.sidebar-collapse .main-sidebar {
      width: 50px !important;
      min-width: 50px !important;
      max-width: 50px !important;
    }
    body.sidebar-collapse .content-wrapper,
    body.sidebar-collapse .main-footer,
    body.sidebar-mini.sidebar-collapse .content-wrapper,
    body.sidebar-mini.sidebar-collapse .main-footer {
      margin-left: 50px !important;
    }
    body.sidebar-collapse .main-header .navbar,
    body.sidebar-mini.sidebar-collapse .main-header .navbar {
      margin-left: 50px !important;
    }
  }

  /* Remove conflicting nested borders */
  body .sidebar,
  body .sidebar-menu,
  body.skin-blue .sidebar,
  body.skin-blue .sidebar-menu {
    border-right: none !important;
    box-shadow: none !important;
    background: transparent !important;
  }

  /* Shop Name Typography directly above sidebar */
  body .main-header .logo,
  body.skin-blue .main-header .logo,
  body.skin-blue .main-header .logo:hover,
  body.skin-blue .main-header .logo:focus,
  body.skin-blue .main-header .logo:active,
  body .main-header .logo .logo-mini,
  body .main-header .logo .logo-lg,
  body .main-header .logo span,
  body .main-header .logo b,
  body .main-header .logo strong,
  body.skin-blue .main-header .logo .logo-mini,
  body.skin-blue .main-header .logo .logo-lg,
  body.skin-blue .main-header .logo span,
  body.skin-blue .main-header .logo b,
  body.skin-blue .main-header .logo strong,
  body .mobile-sidebar-header,
  body .mobile-sidebar-header .mobile-sidebar-title,
  body .mobile-sidebar-header .sidebar-close-btn {
    color: <?= $custom_sidebar_font; ?> !important;
    font-weight: 700 !important;
    opacity: 1 !important;
    -webkit-font-smoothing: antialiased !important;
    -moz-osx-font-smoothing: grayscale !important;
  }

  /* 2. Sidebar Menu Font / Text Color - 100% Solid & Crisp */
  body .sidebar-menu > li > a,
  body .sidebar-menu > li > a > span,
  body .sidebar-menu li > a,
  body .sidebar-menu li > a > span,
  body .sidebar a,
  body.skin-blue .sidebar a,
  body.skin-blue .sidebar-menu > li > a,
  body.skin-blue .sidebar-menu > li > a > span {
    color: <?= $custom_sidebar_font; ?> !important;
    font-weight: 600 !important;
    text-shadow: none !important;
    opacity: 1 !important;
    -webkit-font-smoothing: antialiased !important;
    -moz-osx-font-smoothing: grayscale !important;
  }

  /* Menu Section Header Label */
  body .sidebar-menu > li.header,
  body.skin-blue .sidebar-menu > li.header {
    color: <?= $custom_sidebar_font; ?> !important;
    opacity: 0.72 !important;
    background: transparent !important;
    font-size: 11px !important;
    font-weight: 700 !important;
    letter-spacing: 0.08em !important;
    text-transform: uppercase !important;
  }

  /* Submenu Angle Arrow */
  body .sidebar-menu li > a > .pull-right-container > .fa,
  body.skin-blue .sidebar-menu li > a > .pull-right-container > .fa {
    color: <?= $custom_sidebar_font; ?> !important;
    opacity: 0.85 !important;
  }

  /* Main Menu Hover State */
  body .sidebar-menu > li:hover > a,
  body.skin-blue .sidebar-menu > li:hover > a {
    color: <?= $custom_sidebar_font; ?> !important;
    background: rgba(<?= "{$act_r}, {$act_g}, {$act_b}"; ?>, 0.12) !important;
  }

  /* 3. Selected / Active Main Menu Item */
  body .sidebar-menu > li.active > a,
  body .sidebar-menu > li.menu-open > a,
  body.skin-blue .sidebar-menu > li.active > a,
  body.skin-blue .sidebar-menu > li.menu-open > a {
    background: rgba(<?= "{$act_r}, {$act_g}, {$act_b}"; ?>, 0.18) !important;
    border-left: 4px solid <?= $custom_sidebar_active; ?> !important;
  }
  body .sidebar-menu > li.active > a > span,
  body .sidebar-menu > li.menu-open > a > span {
    color: <?= $custom_sidebar_font; ?> !important;
    font-weight: 700 !important;
  }
  body .sidebar-menu > li.active > a > .fa,
  body .sidebar-menu > li.active > a > i,
  body .sidebar-menu > li.menu-open > a > .fa,
  body .sidebar-menu > li.menu-open > a > i {
    color: <?= $custom_sidebar_active; ?> !important;
  }

  /* ========================================================
     4. SUBMENU STYLING & CUSTOM HOVER / POINTER COLORS
     ======================================================== */
  /* Submenu Box / Container Background */
  body .sidebar-menu > li > .treeview-menu,
  body .sidebar-menu .treeview-menu,
  body.skin-blue .sidebar-menu .treeview-menu,
  body.skin-blue .treeview-menu {
    background: <?= $custom_sidebar_submenu_bg; ?> !important;
    background-color: <?= $custom_sidebar_submenu_bg; ?> !important;
    border: 1px solid rgba(<?= "{$sub_hr}, {$sub_hg}, {$sub_hb}"; ?>, 0.18) !important;
    margin: 4px 6px 8px !important;
    padding: 6px 4px !important;
    border-radius: 8px !important;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05) !important;
  }

  /* Submenu Item Normal State */
  body .sidebar-menu .treeview-menu > li > a,
  body.skin-blue .treeview-menu > li > a {
    color: <?= $custom_sidebar_font; ?> !important;
    opacity: 0.9 !important;
    border-radius: 6px !important;
    margin: 1px 0 !important;
    padding: 7px 10px !important;
    display: flex !important;
    align-items: center !important;
    transition: all 0.15s ease !important;
    border-left: 3px solid transparent !important;
  }
  body .sidebar-menu .treeview-menu > li > a > span,
  body.skin-blue .treeview-menu > li > a > span {
    color: <?= $custom_sidebar_font; ?> !important;
  }
  body .sidebar-menu .treeview-menu > li > a > i,
  body .sidebar-menu .treeview-menu > li > a > .fa,
  body.skin-blue .treeview-menu > li > a > i,
  body.skin-blue .treeview-menu > li > a > .fa {
    color: <?= $custom_sidebar_submenu_hover; ?> !important;
    opacity: 0.85 !important;
  }

  /* Submenu HOVER / Pointer State */
  body .sidebar-menu .treeview-menu > li:hover > a,
  body .sidebar-menu .treeview-menu > li > a:hover,
  body.skin-blue .sidebar-menu .treeview-menu > li:hover > a,
  body.skin-blue .sidebar-menu .treeview-menu > li > a:hover,
  body.skin-blue .treeview-menu > li > a:hover {
    color: <?= $custom_sidebar_submenu_hover; ?> !important;
    background: rgba(<?= "{$sub_hr}, {$sub_hg}, {$sub_hb}"; ?>, 0.18) !important;
    border-left: 3px solid <?= $custom_sidebar_submenu_hover; ?> !important;
    font-weight: 700 !important;
    transform: translateX(3px) !important;
  }
  body .sidebar-menu .treeview-menu > li:hover > a > span,
  body .sidebar-menu .treeview-menu > li > a:hover > span,
  body.skin-blue .sidebar-menu .treeview-menu > li:hover > a > span,
  body.skin-blue .sidebar-menu .treeview-menu > li > a:hover > span {
    color: <?= $custom_sidebar_submenu_hover; ?> !important;
    font-weight: 700 !important;
  }
  body .sidebar-menu .treeview-menu > li:hover > a > i,
  body .sidebar-menu .treeview-menu > li > a:hover > i,
  body .sidebar-menu .treeview-menu > li > a:hover > .fa,
  body .sidebar-menu .treeview-menu > li:hover > a > .fa,
  body.skin-blue .sidebar-menu .treeview-menu > li > a:hover > i,
  body.skin-blue .sidebar-menu .treeview-menu > li > a:hover > .fa,
  body.skin-blue .treeview-menu > li > a:hover > i,
  body.skin-blue .treeview-menu > li > a:hover > .fa {
    color: <?= $custom_sidebar_submenu_hover; ?> !important;
    opacity: 1 !important;
  }

  /* Submenu ACTIVE / Selected State */
  body .sidebar-menu .treeview-menu > li.active > a,
  body .sidebar-menu .treeview-menu > li.active > a:hover,
  body.skin-blue .treeview-menu > li.active > a,
  body.skin-blue .treeview-menu > li.active > a:hover,
  body.skin-blue .sidebar-menu .treeview-menu > li.active > a {
    color: <?= $custom_sidebar_submenu_hover; ?> !important;
    background: rgba(<?= "{$sub_hr}, {$sub_hg}, {$sub_hb}"; ?>, 0.24) !important;
    border-left: 3px solid <?= $custom_sidebar_submenu_hover; ?> !important;
    font-weight: 700 !important;
  }
  body .sidebar-menu .treeview-menu > li.active > a > span,
  body.skin-blue .treeview-menu > li.active > a > span {
    color: <?= $custom_sidebar_submenu_hover; ?> !important;
    font-weight: 700 !important;
  }
  body .sidebar-menu .treeview-menu > li.active > a > i,
  body .sidebar-menu .treeview-menu > li.active > a > .fa,
  body.skin-blue .treeview-menu > li.active > a > i,
  body.skin-blue .treeview-menu > li.active > a > .fa {
    color: <?= $custom_sidebar_submenu_hover; ?> !important;
    opacity: 1 !important;
  }

  /* Multi-colored icons in sidebar menu matching logo palette */
  .sidebar-menu > li:nth-child(5n+1) > a > .fa,
  .sidebar-menu > li:nth-child(5n+1) > a > i {
    color: #00c2cb !important;
  }
  .sidebar-menu > li:nth-child(5n+2) > a > .fa,
  .sidebar-menu > li:nth-child(5n+2) > a > i {
    color: #ff6b00 !important;
  }
  .sidebar-menu > li:nth-child(5n+3) > a > .fa,
  .sidebar-menu > li:nth-child(5n+3) > a > i {
    color: #7c3aed !important;
  }
  .sidebar-menu > li:nth-child(5n+4) > a > .fa,
  .sidebar-menu > li:nth-child(5n+4) > a > i {
    color: #2563eb !important;
  }
  .sidebar-menu > li:nth-child(5n+5) > a > .fa,
  .sidebar-menu > li:nth-child(5n+5) > a > i {
    color: #10b981 !important;
  }

  /* Mini Sidebar Collapsed Flyout */
  .sidebar-mini.sidebar-collapse .sidebar-menu > li:hover > .treeview-menu {
    background: <?= $custom_sidebar_bg; ?> !important;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25) !important;
  }
  .sidebar-mini.sidebar-collapse .sidebar-menu > li:hover > a > span:not(.pull-right) {
    background: <?= $custom_sidebar_bg; ?> !important;
    color: <?= $custom_sidebar_font; ?> !important;
  }

  /* ========================================================
     MOBILE & NARROW BROWSER (Screen width < 768px)
     ======================================================== */
  @media (max-width: 767px) {
    .main-header {
      position: fixed !important;
      top: 0 !important;
      left: 0 !important;
      right: 0 !important;
      width: 100% !important;
      height: 50px !important;
      min-height: 50px !important;
      max-height: 50px !important;
      display: flex !important;
      align-items: center !important;
      justify-content: space-between !important;
      box-shadow: 0 1px 4px rgba(0,0,0,0.08) !important;
      padding: 0 4px !important;
      background: #ffffff !important;
    }
    .main-header .logo {
      display: none !important;
    }
    .main-header .navbar {
      width: 100% !important;
      margin: 0 !important;
      display: flex !important;
      align-items: center !important;
      justify-content: space-between !important;
      height: 50px !important;
      padding: 0 !important;
      background: transparent !important;
    }
    .main-header .navbar .sidebar-toggle {
      float: left !important;
      padding: 15px 12px !important;
      font-size: 18px !important;
      display: inline-flex !important;
      align-items: center !important;
      line-height: 20px !important;
      min-width: 44px !important;
      min-height: 50px !important;
      color: #1e293b !important;
    }
    .mobile-header-store-name {
      display: inline-block !important;
      font-weight: 800 !important;
      font-size: 14px !important;
      white-space: nowrap !important;
      overflow: hidden !important;
      text-overflow: ellipsis !important;
      max-width: calc(100vw - 220px) !important;
      vertical-align: middle !important;
      color: #1e293b !important;
    }
    .header-live-watch-wrap {
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      padding: 0 4px !important;
      margin: 0 !important;
    }
    .header-live-watch-box {
      min-width: 90px !important;
      padding: 1px 4px !important;
      height: 40px !important;
      max-height: 40px !important;
    }
    .header-live-watch-box .hlw-date {
      font-size: 10px !important;
      line-height: 11px !important;
    }
    .header-live-watch-box .hlw-ip {
      display: none !important;
    }
    .header-live-watch-box .hlw-time {
      font-size: 14.5px !important;
      line-height: 15px !important;
      letter-spacing: 0.2px !important;
    }

    /* Modern Off-canvas Sidebar for Mobile */
    .main-sidebar, .left-side {
      position: fixed !important;
      top: 0 !important;
      bottom: 0 !important;
      left: 0 !important;
      width: 270px !important;
      max-width: 84vw !important;
      height: 100vh !important;
      max-height: 100vh !important;
      padding-top: 0px !important;
      z-index: 1045 !important;
      overflow-y: auto !important;
      -webkit-overflow-scrolling: touch !important;
      background-color: <?= $custom_sidebar_bg; ?> !important;
      background: <?= $custom_sidebar_bg; ?> !important;
      border-right: 1px solid rgba(<?= "{$act_r}, {$act_g}, {$act_b}"; ?>, 0.18) !important;
      -webkit-transform: translate3d(-290px, 0, 0) !important;
      transform: translate3d(-290px, 0, 0) !important;
      transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1) !important;
      box-shadow: none !important;
    }
    body.sidebar-open .main-sidebar,
    body.sidebar-open .left-side {
      -webkit-transform: translate3d(0, 0, 0) !important;
      transform: translate3d(0, 0, 0) !important;
      box-shadow: 6px 0 35px rgba(0,0,0,0.3) !important;
    }

    body.sidebar-open .content-wrapper,
    body.sidebar-open .main-footer {
      -webkit-transform: none !important;
      transform: none !important;
      margin-left: 0 !important;
    }
    .content-wrapper {
      margin-left: 0 !important;
      padding-top: 50px !important;
      width: 100% !important;
      max-width: 100vw !important;
      overflow-x: hidden !important;
    }

    /* Mobile Sidebar Header */
    .mobile-sidebar-header {
      display: flex !important;
      align-items: center !important;
      justify-content: space-between !important;
      padding: 12px 16px !important;
      background: <?= $custom_sidebar_bg; ?> !important;
      border-bottom: 1px solid rgba(<?= "{$act_r}, {$act_g}, {$act_b}"; ?>, 0.2) !important;
      min-height: 50px !important;
    }
    .mobile-sidebar-title {
      font-weight: 800 !important;
      font-size: 15px !important;
      color: <?= $custom_sidebar_font; ?> !important;
      white-space: nowrap !important;
      overflow: hidden !important;
      text-overflow: ellipsis !important;
      max-width: 190px !important;
    }
    .sidebar-close-btn {
      background: rgba(<?= "{$act_r}, {$act_g}, {$act_b}"; ?>, 0.16) !important;
      border: none !important;
      color: <?= $custom_sidebar_font; ?> !important;
      width: 32px !important;
      height: 32px !important;
      border-radius: 6px !important;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      font-size: 16px !important;
      cursor: pointer !important;
    }

    /* Sidebar Dark Blur Backdrop */
    .sidebar-backdrop {
      position: fixed !important;
      top: 0 !important;
      left: 0 !important;
      right: 0 !important;
      bottom: 0 !important;
      background: rgba(15, 23, 42, 0.6) !important;
      backdrop-filter: blur(2px) !important;
      -webkit-backdrop-filter: blur(2px) !important;
      z-index: 1040 !important;
      display: none;
      opacity: 0;
      transition: opacity 0.25s ease !important;
    }
    body.sidebar-open .sidebar-backdrop {
      display: block !important;
      opacity: 1 !important;
    }
  }

  @media (min-width: 768px) {
    .mobile-header-store-name,
    .mobile-sidebar-header,
    .sidebar-backdrop {
      display: none !important;
    }
  }
</style>
<header class="main-header">

    <!-- Logo (Visible on desktop/tablet) -->
    <a href="<?php echo $base_url; ?>dashboard" class="logo">
      <span class="logo-mini"><b><?= (is_admin() && store_module()) ? 'JAAS' : 'POS'; ?></b></span>
      <span class="logo-lg"><b><?= str_ireplace('SAAS', 'JAAS', $this->session->userdata('store_name')); ?></b></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <div style="display:flex; align-items:center; float:left;">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button" title="Toggle Sidebar">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Mobile Store Title -->
        <span class="mobile-header-store-name hidden-lg hidden-md hidden-sm">
          <?= htmlspecialchars(str_ireplace('SAAS', 'JAAS', $this->session->userdata('store_name'))); ?>
        </span>
      </div>
      <?php if(!is_user()){?>
      <div class="btn-group hidden-xs">
            <a href="#" class="btn navbar-btn bg-green dropdown-toggle " data-toggle="dropdown" aria-expanded="false" style="">
                <i class="fa fa-plus"></i> 
            </a>
            <ul class="dropdown-menu" >
                  <?php if($CI->permissions('sales_add')) { ?>
                  <li class="border_bottom">
                    <a href="<?php echo $base_url; ?>sales/add" ><h4><i class="fa fa-plus text-green"></i> <?= $this->lang->line('sales'); ?></h4></a>
                  </li> 
                  <?php } ?>
                  <?php if($CI->permissions('quotation_add')) { ?>
                  <li class="border_bottom">
                    <a href="<?php echo $base_url; ?>quotation/add" ><h4><i class="fa fa-plus text-green"></i> <?= $this->lang->line('quotation'); ?></h4></a>
                  </li> 
                  <?php } ?>
                  <?php if($CI->permissions('purchase_add')) { ?>
                  <li class="border_bottom">
                    <a href="<?php echo $base_url; ?>purchase/add" ><h4><i class="fa fa-plus text-green"></i> <?= $this->lang->line('purchase'); ?></h4></a>
                  </li> 
                  <?php } ?>
                  <?php if($CI->permissions('customers_add')) { ?>
                  <li class="border_bottom">
                    <a href="<?php echo $base_url; ?>customers/add" ><h4><i class="fa fa-plus text-green"></i> <?= $this->lang->line('customer'); ?></h4></a>
                  </li> 
                  <?php } ?>
                  <?php if($CI->permissions('suppliers_add')) { ?>
                  <li class="border_bottom">
                    <a href="<?php echo $base_url; ?>suppliers/add" ><h4><i class="fa fa-plus text-green"></i> <?= $this->lang->line('supplier'); ?></h4></a>
                  </li>
                  <?php } ?>
                  <?php if($CI->permissions('items_add')) { ?>
                  <li class="border_bottom">
                    <a href="<?php echo $base_url; ?>items/add" ><h4><i class="fa fa-plus text-green"></i> <?= $this->lang->line('item'); ?></h4></a>
                  </li> 
                  <?php } ?>
                  <?php if($CI->permissions('expense_add')) { ?>
                  <li class="border_bottom">
                    <a href="<?php echo $base_url; ?>expense/add" ><h4><i class="fa fa-plus text-green"></i> <?= $this->lang->line('expense'); ?></h4></a>
                  </li>  
                  <?php } ?>
            </ul>
            
            <!-- <div class="searchbox">
                 <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                  <input type="text" name="q" class="form-control" placeholder="Search...">
                      <span class="input-group-btn">
                        <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                        </button>
                      </span>
                </div>
              </form>
            </div> -->
           
           
        </div>
      <?php }?>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
       
        <ul class="nav navbar-nav">
          
          <!-- User Account Menu -->
            
            <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle text-right" data-toggle="dropdown" title="App Language" data-toggle='tooltip'>
              <i class="fa fa-language "></i>
                    <span class="hidden-xs"><?= $this->session->userdata('language'); ?></span>
            </a>
            <ul class="dropdown-menu " style="width: auto;height: auto;">
              <li>
                <ul class="menu">
                  <?php 
                  $lang_query=$this->db->query('select * from db_languages where status=1  order by language asc');
                  foreach ($lang_query->result() as $res) { 
                    $selected='';
                    if($this->session->userdata('language')==$res->language){
                      $selected ='text-blue';
                    }
                    ?>
                    <li>
                    <a href="<?= $base_url;?>site/langauge/<?= $res->id;?>" ><h3 class='<?=$selected;?>'><?= $res->language;?></h3></a>
                  </li>  
                  <?php } ?>
                </ul>
              </li>
            </ul>
          </li>
          
          <?php if(!is_user() && $CI->permissions('pos')) { ?>
          <li class="text-center" id="">
            <a title="POS [Shift+P]" href="<?php echo $base_url; ?>pos"><i class="fa fa-plus-square " ></i> <span class="hidden-xs">POS</span></a>   
          </li>
          <?php } ?>

          

          
          <?php
            $header_uid = $this->session->userdata('inv_userid');
            $header_user = get_user_details($header_uid);
            $header_full_name = (!empty($header_user)) ? trim(($header_user->first_name ?? '') . ' ' . ($header_user->last_name ?? '')) : '';
            if(empty($header_full_name)){
              $header_full_name = $this->session->userdata('full_name') ?: $this->session->userdata('inv_username');
            }
            $header_username = (!empty($header_user) && !empty($header_user->username)) ? $header_user->username : $this->session->userdata('inv_username');
            $header_designation = ($header_uid == 1 || is_admin()) ? 'Super Admin' : (!empty($this->session->userdata('role_name')) ? $this->session->userdata('role_name') : 'Store Admin');
            $header_profile_pic = get_profile_picture();
          ?>
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="display:inline-flex; align-items:center; height:50px; padding:0 12px;">
              <img src="<?php echo $header_profile_pic; ?>" class="user-image" alt="User Image" style="float:none; margin:0 8px 0 0; width:30px; height:30px; border-radius:50%; object-fit:cover;">
              <span class="hidden-xs" style="font-weight:600; font-size:13.5px;"><?php echo htmlspecialchars($header_full_name); ?></span>
            </a>

            <ul class="dropdown-menu" style="width:280px; border-radius:12px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.18); border:1px solid #e2e8f0; padding:0;">
              <!-- User header -->
              <li class="user-header" style="height:auto; min-height:190px; padding:20px 16px 16px; background:linear-gradient(135deg, #1e293b 0%, #0f172a 100%); text-align:center; color:#ffffff;">
                <div style="position:relative; display:inline-block; margin-bottom:10px;">
                  <img src="<?php echo $header_profile_pic; ?>" class="img-circle" alt="User Image" style="width:72px; height:72px; object-fit:cover; border:3px solid rgba(255,255,255,0.9); box-shadow:0 4px 12px rgba(0,0,0,0.3);">
                  <span style="position:absolute; bottom:2px; right:2px; width:13px; height:13px; background:#22c55e; border:2px solid #0f172a; border-radius:50%;" title="Online"></span>
                </div>

                <h4 style="margin:0 0 3px 0; font-weight:800; font-size:16px; color:#ffffff;">
                  <?php echo htmlspecialchars($header_full_name); ?>
                </h4>

                <div style="font-size:12px; color:#94a3b8; margin-bottom:8px; font-weight:500;">
                  <i class="fa fa-user-o" style="font-size:11px;"></i> <?php echo htmlspecialchars($header_username); ?>
                </div>

                <div style="display:flex; justify-content:center; align-items:center; gap:6px; flex-wrap:wrap;">
                  <span style="background:rgba(14,165,233,0.22); color:#38bdf8; border:1px solid rgba(56,189,248,0.4); font-size:11px; font-weight:700; padding:3px 10px; border-radius:20px; display:inline-flex; align-items:center; gap:4px;">
                    <i class="fa fa-id-badge"></i> <?php echo htmlspecialchars($header_designation); ?>
                  </span>
                  <span style="background:rgba(255,255,255,0.1); color:#cbd5e1; font-size:11px; font-weight:600; padding:3px 8px; border-radius:20px;">
                    Year <?=date("Y");?>
                  </span>
                </div>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer" style="background:#f8fafc; border-top:1px solid #e2e8f0; padding:14px 18px;">
                <div style="display:flex; justify-content:space-between; align-items:center; width:100%;">
                  <a href="<?php echo $base_url; ?>users/edit/<?= $header_uid; ?>" class="btn" style="background:linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color:#ffffff !important; font-weight:700; font-size:13px; border-radius:6px; border:0; padding:7px 18px; box-shadow:0 2px 6px rgba(2,132,199,0.35); text-decoration:none;">
                    <i class="fa fa-user"></i> Profile
                  </a>
                  <a href="<?php echo $base_url; ?>logout" class="btn" style="background:linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color:#ffffff !important; font-weight:700; font-size:13px; border-radius:6px; border:0; padding:7px 18px; box-shadow:0 2px 6px rgba(239,68,68,0.35); text-decoration:none;">
                    <i class="fa fa-sign-out"></i> Sign out
                  </a>
                </div>
              </li>
            </ul>
          </li>

          <!-- LIVE WATCH NEXT TO SUPER ADMIN (100% IDENTICAL TO USER IMAGE) -->
          <?php
            $watch_client_ip = $CI->input->ip_address();
            if (empty($watch_client_ip) || $watch_client_ip == '::1' || $watch_client_ip == '127.0.0.1' || strpos($watch_client_ip, '192.168.') === 0) {
                $watch_client_ip = '202.4.104.234';
            }
          ?>
          <li class="header-live-watch-wrap" title="Live System Time & Client IP">
            <div class="header-live-watch-box">
              <div class="hlw-date" id="hlw_date"><?= date('D.  M j, Y'); ?></div>
              <div class="hlw-time" id="hlw_time"><span class="hlw-hour"><?= date('h'); ?></span><span class="hlw-colon">:</span><span class="hlw-min"><?= date('i'); ?></span><span class="hlw-colon">:</span><span class="hlw-sec"><?= date('s'); ?></span></div>
              <div class="hlw-ip" id="hlw_ip">IP: <?= htmlspecialchars($watch_client_ip); ?></div>
            </div>
          </li>
          
         <!-- <li class="hidden-xs">
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> -->
        </ul>
      </div>

    </nav>
  </header>

  <script type="text/javascript">
  (function () {
    function updateHeaderLiveWatch() {
      var now = new Date();
      var days = ['Sun.', 'Mon.', 'Tue.', 'Wed.', 'Thu.', 'Fri.', 'Sat.'];
      var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

      var dayStr = days[now.getDay()];
      var monthStr = months[now.getMonth()];
      var dateNum = now.getDate();
      var year = now.getFullYear();

      // Format matching uploaded picture: "Mon.  Sep 28, 2026"
      var dateFormatted = dayStr + '  ' + monthStr + ' ' + dateNum + ', ' + year;

      var hours = now.getHours();
      var minutes = now.getMinutes();
      var seconds = now.getSeconds();

      var h12 = hours % 12;
      h12 = h12 ? h12 : 12;
      var strHours = (h12 < 10 ? '0' : '') + h12;
      var strMinutes = (minutes < 10 ? '0' : '') + minutes;
      var strSeconds = (seconds < 10 ? '0' : '') + seconds;

      var timeHtml = '<span class="hlw-hour">' + strHours + '</span><span class="hlw-colon">:</span><span class="hlw-min">' + strMinutes + '</span><span class="hlw-colon">:</span><span class="hlw-sec">' + strSeconds + '</span>';

      var elDate = document.getElementById('hlw_date');
      var elTime = document.getElementById('hlw_time');

      if (elDate) elDate.textContent = dateFormatted;
      if (elTime) elTime.innerHTML = timeHtml;
    }

    updateHeaderLiveWatch();
    setInterval(updateHeaderLiveWatch, 1000);

    // Dynamic public IP update (non-blocking)
    try {
      if (window.fetch) {
        fetch('https://api.ipify.org?format=json', { cache: 'no-store' })
          .then(function(res) { return res.json(); })
          .then(function(data) {
            if (data && data.ip) {
              var elIp = document.getElementById('hlw_ip');
              if (elIp) elIp.textContent = 'IP: ' + data.ip;
            }
          })
          .catch(function() {});
      }
    } catch(e) {}
  })();
  </script>
 
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Mobile Close Header -->
      <div class="mobile-sidebar-header hidden-lg hidden-md hidden-sm">
        <span class="mobile-sidebar-title"><?= htmlspecialchars(str_ireplace('SAAS', 'JAAS', $this->session->userdata('store_name'))); ?></span>
        <button type="button" class="sidebar-close-btn" aria-label="Close Sidebar"><i class="fa fa-times"></i></button>
      </div>
      <!-- <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo get_profile_picture(); ?>" class="user-image" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php print ($this->session->userdata('inv_username')); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div> -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <!--<li class="header">MAIN NAVIGATION</li>-->
    <li class="dashboard-active-li "><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard text-aqua"></i> <span><?= $this->lang->line('dashboard'); ?></span></a></li>
    

    <!-- Users -->
     <?php if($CI->permissions('users_add') || $CI->permissions('users_view') || $CI->permissions('roles_view')) { ?>
     <li class="users-view-active-li users-active-li roles-list-active-li role-active-li treeview">
          <a href="#">
            <i class="fa fa-user-plus text-aqua"></i> <span><?= $this->lang->line('users'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            
            <?php if($CI->permissions('users_view')) { ?>
            <li class="users-view-active-li"><a href="<?php echo $base_url; ?>users/view"><i class="fa fa-list "></i> <span><?= $this->lang->line('users_list'); ?></span></a></li>
            <?php } ?>

            <?php if($CI->permissions('roles_view')) { ?>
            <li class="roles-list-active-li ">
              <a href="<?php echo $base_url; ?>roles/view">
                <i class="fa fa-list "></i> 
                <span><?= $this->lang->line('roles_list'); ?></span>
              </a>
            </li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>

    <!-- STORE MANAGEMENT -->
    <?php if($CI->permissions('store_view') && store_module() && is_admin()) { ?>

        <li class="store_list-active-li store-active-li subscribers-active-li subscribers_list-active-li treeview">
          <a href="#">
            <i class="fa fa-home text-aqua"></i> <span><?= $this->lang->line('stores'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
           
            <li class="store-active-li"><a href="<?php echo $base_url; ?>store/add"><i class="fa fa-plus-square-o "></i> <span><?= $this->lang->line('add_store'); ?></span>
              </a></li>
            
            <li class="store_list-active-li"><a href="<?php echo $base_url; ?>store/view"><i class="fa fa-list "></i> <span><?= $this->lang->line('store_list'); ?></span></a></li>

            
           
          </ul>
        </li>
        
        <?php } ?>

    <!-- HR / EMPLOYEE MANAGEMENT (Shop only) -->
    <?php if(!is_admin() && ($CI->permissions('employee_view') || $CI->permissions('employee_add'))) { ?>
    <li class="employee-active-li employee-list-active-li treeview">
      <a href="#">
        <i class="fa fa-id-badge text-aqua"></i> <span><?= $this->lang->line('hr'); ?></span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <?php if($CI->permissions('employee_add')) { ?>
        <li class="employee-active-li"><a href="<?php echo $base_url; ?>employee/add"><i class="fa fa-user-plus"></i> <span><?= $this->lang->line('add_employee'); ?></span></a></li>
        <?php } ?>
        <?php if($CI->permissions('employee_view')) { ?>
        <li class="employee-list-active-li"><a href="<?php echo $base_url; ?>employee"><i class="fa fa-list"></i> <span><?= $this->lang->line('employee_list'); ?></span></a></li>
        <?php } ?>
      </ul>
    </li>
    <?php } ?>

    <?php if(!is_user()){?>
    <?php if($CI->permissions('sales_add')  || $CI->permissions('sales_view') || $CI->permissions('sales_return_view') || $CI->permissions('sales_return_add')) { ?>
    <!-- <li class="header">SALES</li> -->
    <li class="pos-active-li sales-list-active-li sales-active-li sales-return-active-li sales-return-list-active-li sales-payments-list-active-li treeview">
          <a href="#">
            <i class=" fa fa-shopping-cart text-aqua"></i> <span><?= $this->lang->line('sales'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <?php if($CI->permissions('pos')) { ?>
        <li class="pos-active-li"><a href="<?php echo $base_url; ?>pos"><i class="fa fa-plus-square-o  "></i> <span>POS</span></a></li>
         <?php } ?>
        <?php if($CI->permissions('sales_add')) { ?>
       
        <li class="sales-active-li"><a href="<?php echo $base_url; ?>sales/add"><i class="fa fa-plus-square-o "></i> <span><?= $this->lang->line('add_sale'); ?></span></a></li>

        <?php } ?>
        
        <?php if($CI->permissions('sales_view')) { ?>
        <li class="sales-list-active-li"><a href="<?php echo $base_url; ?>sales"><i class="fa fa-list "></i> <span><?= $this->lang->line('sales_list'); ?></span></a></li>
        <?php } ?>

        <?php if($CI->permissions('sales_payment_view')) { ?>
        <li class="sales-payments-list-active-li"><a href="<?php echo $base_url; ?>sales_payments/"><i class="fa fa-list "></i> <span><?= $this->lang->line('sales_payments'); ?></span></a></li>
        <?php } ?>

        <?php if($CI->permissions('sales_return_view')) { ?>
        <li class="sales-return-list-active-li "><a href="<?php echo $base_url; ?>sales_return"><i class="fa fa-list "></i> <span><?= $this->lang->line('sales_returns_list'); ?></span>
              </a></li>
        <?php } ?>

    

          </ul>
        </li>
    <?php } ?>
    <?php } ?><!-- is_user() -->

    <!-- EMI MODULE -->
    <?php if(!is_user()){?>
    <?php if($CI->permissions('emi_add') || $CI->permissions('emi_view')) { ?>
    <li class="emi-active-li emi_list-active-li emi_add-active-li emi_details-active-li emi_collection-active-li treeview">
          <a href="#">
            <i class="fa fa-calculator text-aqua"></i> <span><?= $this->lang->line('emi_management'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if($CI->permissions('emi_add')) { ?>
            <li class="emi_add-active-li"><a href="<?php echo $base_url; ?>emi/add"><i class="fa fa-plus-square-o"></i> <span><?= $this->lang->line('new_emi_plan'); ?></span></a></li>
            <?php } ?>
            <?php if($CI->permissions('emi_view')) { ?>
            <li class="emi_collection-active-li"><a href="<?php echo $base_url; ?>emi/collection"><i class="fa fa-money"></i> <span><?= $this->lang->line('emi_collection'); ?></span></a></li>
            <li class="emi_list-active-li"><a href="<?php echo $base_url; ?>emi"><i class="fa fa-list"></i> <span><?= $this->lang->line('emi_list'); ?></span></a></li>
            <?php } ?>
          </ul>
    </li>
    <?php } ?>
    <?php } ?>


    
    <?php if(!is_user()){?>
    <!--<li class="header">CUSTOMERS</li>-->
    <?php if($CI->permissions('customers_add') || $CI->permissions('customers_view') || $CI->permissions('import_customers') || $CI->permissions('suppliers_add') || $CI->permissions('suppliers_view') || $CI->permissions('import_suppliers')) { ?>
    <li class="customers-view-active-li customers-active-li import_customers-active-li suppliers-list-active-li suppliers-active-li import_suppliers-active-li treeview">
          <a href="#">
            <i class="fa fa-group text-aqua"></i> <span><?= $this->lang->line('contacts'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
        <?php if($CI->permissions('customers_add')) { ?>
        <li class="customers-active-li"><a href="<?php echo $base_url; ?>customers/add"><i class="fa fa-plus-square-o "></i> <span><?= $this->lang->line('add_customer'); ?></span></a></li>
        <?php } ?>

        <?php if($CI->permissions('customers_view')) { ?>
         <li class="customers-view-active-li"><a href="<?php echo $base_url; ?>customers"><i class="fa fa-list "></i> <span><?= $this->lang->line('customers_list'); ?></span></a></li>
         <?php } ?>

         <?php if($CI->permissions('suppliers_add')) { ?>
        <li class="suppliers-active-li"><a href="<?php echo $base_url; ?>suppliers/add"><i class="fa fa-plus-square-o "></i> <span><?= $this->lang->line('add_supplier'); ?></span></a></li>
        <?php } ?>

         <?php if($CI->permissions('suppliers_view')) { ?>
              <li class="suppliers-list-active-li"><a href="<?php echo $base_url; ?>suppliers"><i class="fa fa-list "></i> <span><?= $this->lang->line('suppliers_list'); ?></span></a></li>
              <?php } ?>

         <?php if($CI->permissions('import_customers')) { ?>
         <li class="import_customers-active-li"><a href="<?php echo $base_url; ?>import/customers"><i class="fa fa-arrow-circle-o-left "></i> <span><?= $this->lang->line('import_customers'); ?></span>
              </a></li>
         <?php } ?>

          <?php if($CI->permissions('import_suppliers')) { ?>
               <li class="import_suppliers-active-li"><a href="<?php echo $base_url; ?>import/suppliers"><i class="fa fa-arrow-circle-o-left "></i> <span><?= $this->lang->line('import_suppliers'); ?></span>
              </a></li>
               <?php } ?>

          </ul>
        </li>    
    <?php } ?>
    <?php } ?><!-- is_user() -->

    <?php if(!is_user()){?>
    <?php if($CI->permissions('cust_adv_payments_add')  || $CI->permissions('cust_adv_payments_view')) { ?>
    <!-- <li class="header">QUOTATION</li> -->
    <li class="list-active-li create-active-li treeview">
          <a href="#">
            <i class=" fa fa-money  text-aqua"></i> <span><?= $this->lang->line('advance'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
        <?php if($CI->permissions('cust_adv_payments_add')) { ?>
        <li class="create-active-li"><a href="<?php echo $base_url; ?>customers_advance/add"><i class="fa fa-plus-square-o "></i> <span><?= $this->lang->line('add_advance'); ?></span></a></li>
        <?php } ?>
        
        <?php if($CI->permissions('cust_adv_payments_view')) { ?>
        <li class="list-active-li"><a href="<?php echo $base_url; ?>customers_advance"><i class="fa fa-list "></i> <span><?= $this->lang->line('advance_list'); ?></span></a></li>
        <?php } ?>


          </ul>
        </li>
    <?php } ?>
    <?php } ?><!-- is_user() -->
    


    <?php if(($CI->permissions('discountCouponView') || $CI->permissions('customerCouponView')) && !is_admin()) { ?>
    <!-- <li class="header">QUOTATION</li> -->
    <li class="coupon-active-li treeview">
          <a href="#">
            <i class=" fa fa-tags text-aqua"></i> <span><?= $this->lang->line('coupons'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
        <?php if($CI->permissions('customerCouponAdd')) { ?>
        <li class="createCoupon-active-li"><a href="<?php echo $base_url; ?>customer_coupon/generate"><i class="fa fa-plus-square-o "></i> <span><?= $this->lang->line('createCustomerCoupon'); ?></span></a></li>
        <?php } ?>
        
        <?php if($CI->permissions('customerCouponView')) { ?>
        <li class="customerCouponsList-active-li"><a href="<?php echo $base_url; ?>customer_coupon"><i class="fa fa-list "></i> <span><?= $this->lang->line('customerCouponsList'); ?></span></a></li>
        <?php } ?>

        <?php if($CI->permissions('discountCouponAdd')) { ?>
        <li class="createDiscountCoupon-active-li"><a href="<?php echo $base_url; ?>discount_coupon/add"><i class="fa fa-plus-square-o "></i> <span><?= $this->lang->line('createCoupon'); ?></span></a></li>
        <?php } ?>

        <?php if($CI->permissions('discountCouponView')) { ?>
        <li class="discountCoupon-active-li"><a href="<?php echo $base_url; ?>discount_coupon/view"><i class="fa fa-list "></i> <span><?= $this->lang->line('couponsMaster'); ?></span></a></li>
        <?php } ?>

          </ul>
        </li>
    <?php } ?>


    <?php if(!is_user()){?>
    <?php if($CI->permissions('quotation_add')  || $CI->permissions('quotation_view')) { ?>
    <!-- <li class="header">QUOTATION</li> -->
    <li class="pos-active-li quotation_list-active-li quotation-active-li quotation-return-active-li quotation-return-list-active-li treeview">
          <a href="#">
            <i class=" fa fa-calendar-plus-o text-aqua"></i> <span><?= $this->lang->line('quotation'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
        <?php if($CI->permissions('quotation_add')) { ?>
        <li class="quotation-active-li"><a href="<?php echo $base_url; ?>quotation/add"><i class="fa fa-plus-square-o "></i> <span><?= $this->lang->line('new_quotation'); ?></span></a></li>
        <?php } ?>
        
        <?php if($CI->permissions('quotation_view')) { ?>
        <li class="quotation_list-active-li"><a href="<?php echo $base_url; ?>quotation"><i class="fa fa-list "></i> <span><?= $this->lang->line('quotation_list'); ?></span></a></li>
        <?php } ?>


          </ul>
        </li>
    <?php } ?>
    <?php } ?><!-- is_user() -->

    

    <?php if(!is_user()){?>
    <?php if($CI->permissions('purchase_add') || $CI->permissions('purchase_view') || $CI->permissions('purchase_return_view')|| $CI->permissions('new_purchase_return')) { ?>
    <!-- <li class="header">PURCHASE</li> -->
    <li class="purchase-list-active-li purchase-active-li purchase-returns-active-li purchase-returns-list-active-li treeview treeview2 ">
          <a href="#">
            <i class="fa fa-cube text-aqua"></i> <span><?= $this->lang->line('purchase'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
           
            <?php if($CI->permissions('purchase_add')) { ?>
            <li class="purchase-active-li"><a href="<?php echo $base_url; ?>purchase/add"><i class="fa fa-plus-square-o "></i> <span><?= $this->lang->line('new_purchase'); ?></span></a></li>
            <?php } ?>

            <?php if($CI->permissions('purchase_view')) { ?>
            <li class="purchase-list-active-li"><a href="<?php echo $base_url; ?>purchase"><i class="fa fa-list "></i> <span><?= $this->lang->line('purchase_list'); ?></span></a></li>
            <?php } ?>
          

            <?php if($CI->permissions('purchase_return_view')) { ?>
            <li class="purchase-returns-list-active-li"><a href="<?php echo $base_url; ?>purchase_return"><i class="fa fa-list "></i> <span><?= $this->lang->line('purchase_returns_list'); ?></span>
              </a></li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>
        <?php } ?><!-- is_user() -->
       
       <?php if(!is_user()){?> 
      <?php if(($CI->permissions('accounts_add') || $CI->permissions('accounts_view') || $CI->permissions('journal_add') || $CI->permissions('journal_view')) && accounts_module() ) { ?>
    <!-- <li class="header">ACCOUNTING</li> -->
    <li class="accounts_list-active-li accounts-active-li account_heads-active-li journal-active-li journal_list-active-li money_transfer-active-li money_transfer_list-active-li money_deposit-active-li money_deposit_list-active-li cash_transactions-active-li cash_in_hand-active-li treeview">
          <a href="#">
            <i class="fa fa-th-large text-aqua"></i> <span><?= $this->lang->line('accounts'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            
            <?php if($CI->permissions('accounts_view')) { ?>
            <li class="account_heads-active-li"><a href="<?php echo $base_url; ?>accounts/account_heads"><i class="fa fa-folder-open text-yellow"></i> <span><?= $this->lang->line('account_heads') ? $this->lang->line('account_heads') : 'Account Heads'; ?></span></a></li>
            <?php } ?>

            <?php if($CI->permissions('accounts_add')) { ?>
            <li class="accounts-active-li"><a href="<?php echo $base_url; ?>accounts/add"><i class="fa fa-plus-square-o "></i> <span><?= $this->lang->line('add_account'); ?></span></a></li>
            <?php } ?>

            <?php if($CI->permissions('accounts_view')) { ?>
            <li class="accounts_list-active-li"><a href="<?php echo $base_url; ?>accounts"><i class="fa fa-list "></i> <span><?= $this->lang->line('accounts_list'); ?></span></a></li>
            <?php } ?>

           
            <?php if($CI->permissions('money_transfer_view')) { ?>
            <li class="money_transfer_list-active-li"><a href="<?php echo $base_url; ?>money_transfer"><i class="fa fa-list "></i> <span><?= $this->lang->line('money_transfer_list'); ?></span></a></li>
            <?php } ?>

            
            <?php if($CI->permissions('money_deposit_view')) { ?>
            <li class="money_deposit_list-active-li"><a href="<?php echo $base_url; ?>money_deposit"><i class="fa fa-list "></i> <span><?= $this->lang->line('deposit_list'); ?></span></a></li>
            <?php } ?>

            <?php if($CI->permissions('accounts_view')) { ?>
            <li class="cash_in_hand-active-li"><a href="<?php echo $base_url; ?>accounts/cash_in_hand"><i class="fa fa-money text-green"></i> <span>Cash in Hand</span></a></li>
            <?php } ?>

            <?php if($CI->permissions('cash_transactions')) { ?>
            <li class="cash_transactions-active-li"><a href="<?php echo $base_url; ?>accounts/cash_transactions"><i class="fa fa-exchange "></i> <span><?= $this->lang->line('cash_transactions'); ?></span></a></li>
            <?php } ?>

            

          </ul>
        </li>
        <?php } ?>
        <?php } ?><!-- is_user() -->

        <?php if(!is_user()){?>
        <?php if($CI->permissions('services_add') || $CI->permissions('services_view') || $CI->permissions('items_add') || $CI->permissions('items_view') || $CI->permissions('items_category_add') || $CI->permissions('items_category_view') || $CI->permissions('brand_add') || $CI->permissions('brand_view') || $CI->permissions('print_labels') || $CI->permissions('import_items') || $CI->permissions('import_services') || $CI->permissions('variant_view') || $CI->permissions('services_view') ) { ?>
          <!-- <li class="header">MAIN</li> -->
        <li class="items-list-active-li items-active-li  category-view-active-li category-active-li brand-active-li brand-view-active-li labels-active-li import_items-active-li services-active-li import_services-active-li variants-active-li variants_list-active-li services-active-li treeview">
          <a href="#">
            <i class="fa fa-cubes text-aqua"></i> <span><?= (service_module()) ? $this->lang->line('items') : $this->lang->line('items'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            
            <?php if($CI->permissions('items_add')) { ?>
            <li class="items-active-li"><a href="<?php echo $base_url; ?>items/add"><i class="fa fa-plus-square-o "></i> <span><?= $this->lang->line('add_item'); ?></span></a></li>
            <?php } ?>

            <?php if($CI->permissions('services_add')) { ?>
            <li class="services-active-li"><a href="<?php echo $base_url; ?>services/add"><i class="fa fa-plus-square-o "></i> <span><?= $this->lang->line('add_service'); ?></span></a></li>
            <?php } ?>

            <?php if($CI->permissions('items_view') ||$CI->permissions('services_view') || $CI->permissions('services_add')) { ?>
            <li class="items-list-active-li"><a href="<?php echo $base_url; ?>items"><i class="fa fa-list "></i> <span><?= $this->lang->line('items_list'); ?></span></a></li>
            <?php } ?>

            
            <?php if($CI->permissions('items_category_view')) { ?>
            <li class="category-view-active-li"><a href="<?php echo $base_url; ?>category/view"><i class="fa fa-list "></i> <span><?= $this->lang->line('categories_list'); ?></span></a></li>
            <?php } ?>

            
            <?php if($CI->permissions('brand_view')) { ?>
            <li class="brand-view-active-li"><a href="<?php echo $base_url; ?>brands/view"><i class="fa fa-list "></i> <span><?= $this->lang->line('brands_list'); ?></span></a></li>
            <?php } ?>

            
            <?php if($CI->permissions('variant_view')) { ?>
            <li class="variants_list-active-li"><a href="<?php echo $base_url; ?>variants/view"><i class="fa fa-list "></i> <span><?= $this->lang->line('variants_list'); ?></span></a></li>
            <?php } ?>

            <?php if($CI->permissions('print_labels')) { ?>
            <li class="labels-active-li"><a href="<?php echo $base_url; ?>items/labels"><i class="fa fa-barcode "></i> <span><?= $this->lang->line('print_labels'); ?></span></a></li>
            <?php } ?>
            <?php if($CI->permissions('import_items')) { ?>
               <li class="import_items-active-li"><a href="<?php echo $base_url; ?>import/items"><i class="fa fa-arrow-circle-o-left "></i> <span><?= $this->lang->line('import_items'); ?></span>
              </a></li>
               <?php } ?>
              <?php if($CI->permissions('import_services')) { ?>
               <li class="import_services-active-li"><a href="<?php echo $base_url; ?>import/services"><i class="fa fa-arrow-circle-o-left "></i> <span><?= $this->lang->line('import_services'); ?></span>
              </a></li>
               <?php } ?>

          </ul>
        </li>
        <?php } ?>
        <?php } ?><!-- is_user() -->

    <!-- WARRANTY MODULE -->
    <?php if(!is_user()){?>
    <?php if($CI->permissions('warranty_add') || $CI->permissions('warranty_view')) { ?>
    <li class="warranty-active-li warranty_list-active-li warranty_add-active-li warranty_check-active-li warranty_history-active-li treeview">
          <a href="#">
            <i class="fa fa-shield text-aqua"></i> <span><?= $this->lang->line('warranty_management'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if($CI->permissions('warranty_view')) { ?>
            <li class="warranty_check-active-li"><a href="<?php echo $base_url; ?>warranty/check"><i class="fa fa-search"></i> <span><?= $this->lang->line('check_warranty'); ?></span></a></li>
            <?php } ?>
            <?php if($CI->permissions('warranty_add')) { ?>
            <li class="warranty_add-active-li"><a href="<?php echo $base_url; ?>warranty/add"><i class="fa fa-plus-square-o"></i> <span><?= $this->lang->line('new_warranty_claim'); ?></span></a></li>
            <?php } ?>
            <?php if($CI->permissions('warranty_view')) { ?>
            <li class="warranty_list-active-li"><a href="<?php echo $base_url; ?>warranty"><i class="fa fa-list"></i> <span><?= $this->lang->line('warranty_list'); ?></span></a></li>
            <li class="warranty_history-active-li"><a href="<?php echo $base_url; ?>warranty/history"><i class="fa fa-history"></i> <span><?= $this->lang->line('service_history'); ?></span></a></li>
            <?php } ?>
          </ul>
    </li>
    <?php } ?>
    <?php } ?>



        <?php if(!is_user()){?>
        <?php if($CI->permissions('stock_adjustment_add')  || $CI->permissions('stock_adjustment_view') || $CI->permissions('stock_transfer_add') || $CI->permissions('stock_transfer_view')) { ?>
    <!-- <li class="header">STOCK ADJUSTMENT</li> -->
    <li class="pos-active-li stock_adjustment_list-active-li stock_adjustment-active-li stock_adjustment-return-active-li stock_adjustment-return-list-active-li stock_transfer-active-li stock_transfer_list-active-li treeview">
          <a href="#">
            <i class=" fa fa-hourglass text-aqua"></i> <span><?= $this->lang->line('stock'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
        
        <?php if($CI->permissions('stock_adjustment_view')) { ?>
        <li class="stock_adjustment_list-active-li stock_adjustment-active-li"><a href="<?php echo $base_url; ?>stock_adjustment"><i class="fa fa-list "></i> <span><?= $this->lang->line('adjustment_list'); ?></span></a></li>
        <?php } ?>

         <?php if($CI->permissions('stock_transfer_view') && warehouse_module()) { ?>
        <li class="stock_transfer_list-active-li stock_transfer-active-li"><a href="<?php echo $base_url; ?>stock_transfer/view"><i class="fa fa-list "></i> <span><?= $this->lang->line('transfer_list'); ?></span></a></li>
        <?php } ?>


          </ul>
        </li>
    <?php } ?>
    <?php } ?><!-- is_user() -->
        
    <?php if(!is_user()){?>
        <?php if($CI->permissions('expense_add') || $CI->permissions('expense_view') || $CI->permissions('expense_category_add') || $CI->permissions('expense_category_view')) { ?>
       <li class="expense-list-active-li expense-active-li expense-category-active-li expense-category-list-active-li treeview">
          <a href="#">
            <i class="fa fa-minus-circle text-aqua"></i> <span><?= $this->lang->line('expenses'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            
            <?php if($CI->permissions('expense_view')) { ?>
            <li class="expense-list-active-li"><a href="<?php echo $base_url; ?>expense"><i class="fa fa-list "></i> <span><?= $this->lang->line('expenses_list'); ?></span></a></li>
            <?php } ?>
            
            <?php if($CI->permissions('expense_category_view')) { ?>
            <li class="expense-category-list-active-li "><a href="<?php echo $base_url; ?>expense/category"><i class="fa fa-list "></i> <span><?= $this->lang->line('categories_list'); ?></span></a></li>
            <?php } ?>

          </ul>
        </li>
        <?php } ?>
    <?php } ?><!-- is_user() -->

        
    

    <?php if(special_access()) { ?>
    <li class="country-active-li city-list-active-li country-list-active-li state-active-li state-list-active-li city-active-li treeview">
          <a href="#">
            <i class="fa fa-paper-plane-o text-aqua"></i> <span><?= $this->lang->line('places'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            
            <li class="country-list-active-li "><a href="<?php echo $base_url; ?>country"><i class="fa fa-list "></i> <span><?= $this->lang->line('countries_list'); ?></span></a></li>
           
            <li class="state-list-active-li "><a href="<?php echo $base_url; ?>state"><i class="fa fa-list "></i> <span><?= $this->lang->line('states_list'); ?></span></a></li>
    </ul>
        </li>
    <?php } ?>

    <!-- SMS -->
     <?php if($CI->permissions('send_sms') || $CI->permissions('send_email') || $CI->permissions('email_template_view') || $CI->permissions('sms_template_view') || $CI->permissions('smtp_settings') || is_admin() || is_store_admin() ) { ?>
     <li class="sms-active-li sms-templates-list-active-li email-active-li email-templates-list-active-li smtp-active-li treeview">
          <a href="#">
            <i class="fa fa-envelope text-aqua"></i> <span><?= $this->lang->line('messaging'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if($CI->permissions('send_sms')) { ?>
            <li class="sms-active-li"><a href="<?php echo $base_url; ?>sms"><i class="fa fa-envelope-o "></i> <span><?= $this->lang->line('send_sms'); ?></span></a></li>
            <?php } ?>
            <?php if($CI->permissions('sms_template_view')) { ?>
            <li class="sms-templates-list-active-li "><a href="<?php echo $base_url; ?>templates/sms"><i class="fa fa-list "></i> <span><?= $this->lang->line('sms_templates'); ?></span></a></li>
            <?php } ?>

            <?php if($CI->permissions('send_email') || is_admin() || is_store_admin()) { ?>
            <li class="email-active-li"><a href="<?php echo $base_url; ?>email"><i class="fa fa-envelope-o "></i> <span><?= $this->lang->line('send_email'); ?></span></a></li>
            <?php } ?>
            <?php if($CI->permissions('email_template_view') || is_admin() || is_store_admin()) { ?>
            <li class="email-templates-list-active-li "><a href="<?php echo $base_url; ?>email_templates/email"><i class="fa fa-list "></i> <span><?= $this->lang->line('email_templates'); ?></span></a></li>
            <?php } ?>
            <?php if($CI->permissions('smtp_settings') || is_admin() || is_store_admin()) { ?>
            <li class="smtp-active-li"><a href="<?php echo $base_url; ?>smtp/"><i class="fa fa-cog "></i> <span><?= $this->lang->line('smtp_settings'); ?></span></a></li>
            <?php } ?>
            
          </ul>
        </li>
        <?php } ?>
   
    <!--<li class="header">REPORTS</li>-->
    <?php if($CI->permissions('supplier_items_report') || $CI->permissions('sales_report') || $CI->permissions('item_sales_report') || $CI->permissions('purchase_report') || $CI->permissions('purchase_return_report') || $CI->permissions('expense_report') || $CI->permissions('profit_report') || $CI->permissions('stock_report') || $CI->permissions('purchase_payments_report') || $CI->permissions('sales_payments_report') || $CI->permissions('expired_items_report') || $CI->permissions('seller_points_report') || $CI->permissions('customer_orders_report') || $CI->permissions('stock_transfer_report') || $CI->permissions('sales_summary_report') || $CI->permissions('sales_return_payments') ) { ?>
    <li class="report-sales-active-li report-sales-return-active-li report-purchase-active-li report-purchase-return-active-li report-expense-active-li report-stock-active-li report-purchase-payments-active-li report-sales-item-active-li report-sales-payments-active-li report-expired-items-active-li report-supplier_items-active-li report-seller-points-active-li report-sales-tax-active-li report-purchase-tax-active-li  report-delivery-sheet-active-li report-load-sheet-active-li report-return-item-active-li report-sales-active-li report-stock-transfer-active-li reports-menu report-sales-summary-active-li report-sales-return-payments-active-li treeview">
          <a href="#">
            <i class="fa fa-bar-chart text-aqua"></i> <span><?= $this->lang->line('reports'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <?php if($CI->permissions('profit_report')) { ?>
            <li class="report-profit-loss-active-li"><a href="<?php echo $base_url; ?>reports/profit_loss" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('profit_and_loss_report'); ?></span>
              </a></li>
            <?php } ?>
            
            <?php if($CI->permissions('sales_report')) { ?>
            <li class="report-sales-and-payments-active-li"><a href="<?php echo $base_url; ?>reports/sales_and_payments" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('sales_and_payments_report'); ?></span></a></li>
            <?php } ?>

            <?php if($CI->permissions('customer_orders_report')) { ?>
            <li class="report-customer-orders-active-li"><a href="<?php echo $base_url; ?>reports/customer_orders" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('customer_orders'); ?></span></a></li>
            <?php } ?>

            <?php if($CI->permissions('gstr_1_report')) { ?>
            <li class="report-gstr_1-active-li"><a href="<?php echo $base_url; ?>reports/gstr_1" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('gstr_1_report'); ?></span></a></li>
            <?php } ?>

            <?php if($CI->permissions('gstr_2_report')) { ?>
            <li class="report-gstr_2-active-li"><a href="<?php echo $base_url; ?>reports/gstr_2" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('gstr_2_report'); ?></span></a></li>
            <?php } ?>

            <?php if($CI->permissions('sales_gst_report')) { ?>
            <li class="sales_gst_report-active-li"><a href="<?php echo $base_url; ?>reports/sales_gst_report" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('sales_gst_report'); ?></span></a></li>
            <?php } ?>

            <?php if($CI->permissions('purchase_gst_report')) { ?>
            <li class="purchase_gst_report-active-li"><a href="<?php echo $base_url; ?>reports/purchase_gst_report" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('purchase_gst_report'); ?></span></a></li>
            <?php } ?>
            
            <?php if($CI->permissions('delivery_sheet_report') && false) { ?>
            <li class="report-delivery-sheet-active-li"><a href="<?php echo $base_url; ?>reports/delivery_sheet" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('delivery_sheet_report'); ?></span></a></li>
            <?php } ?>

            <?php if($CI->permissions('load_sheet_report') && false) { ?>
            <li class="report-load-sheet-active-li"><a href="<?php echo $base_url; ?>reports/load_sheet" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('load_sheet_report'); ?></span></a></li>
            <?php } ?>


            <?php if($CI->permissions('sales_tax_report')) { ?>
            <li class="report-sales-tax-active-li"><a href="<?php echo $base_url; ?>reports/sales_tax" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('sales_tax_report'); ?></span></a></li>
            <?php } ?>

            <?php if($CI->permissions('purchase_tax_report')) { ?>
            <li class="report-purchase-tax-active-li"><a href="<?php echo $base_url; ?>reports/purchase_tax" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('purchase_tax_report'); ?></span></a></li>
            <?php } ?>

            <?php if($CI->permissions('supplier_items_report')) { ?>
            <li class="report-supplier_items-active-li"><a href="<?php echo $base_url; ?>reports/supplier_items" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('supplier_items_report'); ?></span>
              </a></li>
            <?php } ?>
            
            <?php if($CI->permissions('sales_report')) { ?>
            <li class="report-sales-active-li"><a href="<?php echo $base_url; ?>reports/sales" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('sales_report'); ?></span></a></li>
            <?php } ?>
            <?php if($CI->permissions('sales_return_report')) { ?>
            <li class="report-sales-return-active-li"><a href="<?php echo $base_url; ?>reports/sales_return" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('sales_return_report'); ?></span>
              </a></li>
            <?php } ?>

            <?php if($CI->permissions('seller_points_report')) { ?>
            <li class="report-seller-points-active-li"><a href="<?php echo $base_url; ?>reports/seller_points" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('seller_points_report'); ?></span></a></li>
            <?php } ?>

            <?php if($CI->permissions('purchase_report')) { ?>
            <li class="report-purchase-active-li"><a href="<?php echo $base_url; ?>reports/purchase" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('purchase_report'); ?></span></a></li>
            <?php } ?>
            <?php if($CI->permissions('purchase_return_report')) { ?>
            <li class="report-purchase-return-active-li"><a href="<?php echo $base_url; ?>reports/purchase_return" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('purchase_return_report'); ?></span>
              </a></li>
            <?php } ?>
            <?php if($CI->permissions('expense_report')) { ?>
            <li class="report-expense-active-li"><a href="<?php echo $base_url; ?>reports/expense" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('expense_report'); ?></span></a></li>
            <?php } ?>
            
            <?php if($CI->permissions('stock_report')) { ?>
            <li class="report-stock-active-li"><a href="<?php echo $base_url; ?>reports/stock" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('stock_report'); ?></span>
              </a></li>
            <?php } ?>
            <?php if($CI->permissions('item_sales_report')) { ?>
            <li class="report-sales-item-active-li"><a href="<?php echo $base_url; ?>reports/item_sales" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('item_sales_report'); ?></span></a></li>
            <?php } ?>

            <?php if($CI->permissions('return_items_report')) { ?>
            <li class="report-return-item-active-li"><a href="<?php echo $base_url; ?>reports/return_item" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('return_items_report'); ?></span></a></li>
            <?php } ?>

            <?php if($CI->permissions('purchase_payments_report')) { ?>
            <li class="report-purchase-payments-active-li"><a href="<?php echo $base_url; ?>reports/purchase_payments" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('purchase_payments_report'); ?></span></a></li>
            <?php } ?>
            <?php if($CI->permissions('sales_payments_report')) { ?>
            <li class="report-sales-payments-active-li"><a href="<?php echo $base_url; ?>reports/sales_payments" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('sales_payments_report'); ?></span></a></li>  
            <?php } ?>

            <?php if($CI->permissions('sales_return_payments')) { ?>
            <li class="report-sales-return-payments-active-li"><a href="<?php echo $base_url; ?>reports/sales_return_payments" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('sales_return_payments'); ?></span></a></li> 
            <?php } ?>

            <?php if($CI->permissions('stock_transfer_report')) { ?>
            <li class="report-stock-transfer-active-li"><a href="<?php echo $base_url; ?>reports/stock_transfer" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('stock_transfer_report'); ?></span></a></li>
            <?php } ?>

            <?php if($CI->permissions('sales_summary_report')) { ?>
            <li class="report-sales-summary-active-li"><a href="<?php echo $base_url; ?>reports/sales_summary" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('sales_summary_report'); ?></span></a></li>
            <?php } ?>
            
            <?php if($CI->permissions('expired_items_report')) { ?>
            <!-- <li class="report-expired-items-active-li"><a href="<?php echo $base_url; ?>reports/expired_items" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('expired_items_report'); ?></span></a></li> -->  
            <?php } ?>
         </ul>
      </li>
      <?php } ?>

     
    
    

        <?php if(!is_user()){?>
    <!-- WAREHOUSE MANAGEMENT -->
    <?php if(($CI->permissions('warehouse_view') || $CI->permissions('warehouse_add')) && warehouse_module()) { ?>

        <li class="warehouse-active-li warehouse-list-active-li  treeview">
          <a href="#">
            <i class="fa fa-building-o text-aqua"></i> <span><?= $this->lang->line('warehouse'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
           <?php if($CI->permissions('warehouse_add')) { ?>
            <li class="warehouse-active-li"><a href="<?php echo $base_url; ?>warehouse/add"><i class="fa fa-plus-square-o "></i> <span><?= $this->lang->line('add_warehouse'); ?></span>
              </a></li>
             <?php } ?>
            <?php if($CI->permissions('warehouse_view')) { ?>
            <li class="warehouse-list-active-li"><a href="<?php echo $base_url; ?>warehouse"><i class="fa fa-list "></i> <span><?= $this->lang->line('warehouse_list'); ?></span></a></li>
           <?php } ?>
          </ul>
        </li>
        
        <?php } ?>
        <?php } ?><!-- is_user() -->

    <!--<li class="header">SETTINGS</li>-->
    <?php if($change_password=true) { ?>
    <li class=" site-settings-active-li  change-pass-active-li dbbackup-active-li  tax-active-li currency-view-active-li  store_profile-active-li currency-active-li  database_updater-active-li tax-list-active-li units-list-active-li unit-active-li payment_types_list-active-li payment_types-active-li gateways-active-li package-active-li subscription-active-li  subscription-list-active-li  package-list-active-li sms-api-active-li smtp-active-li treeview">
          <a href="#">
            <i class="fa fa-gears text-aqua"></i> <span><?= $this->lang->line('settings'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if(!is_user()){?>
            <?php if($CI->permissions('store_edit')) { ?>
            <li class="store_profile-active-li"><a href="<?php echo $base_url; ?>store_profile/update/<?= $this->session->userdata('store_id'); ?>"><i class="fa fa-suitcase "></i> <span><?= $this->lang->line('store'); ?></span></a></li>
            <?php } ?>
            <?php } ?><!-- is_user() -->
            <?php if(special_access()) { ?>
            <li class="site-settings-active-li"><a href="<?php echo $base_url; ?>site"><i class="fa fa-shield  "></i> <span><?= $this->lang->line('site_settings'); ?></span></a></li>
            <?php } ?>

            <?php if($CI->permissions('sms_api_view')) { ?>
            <li class="sms-api-active-li"><a href="<?php echo $base_url; ?>sms/api"><i class="fa fa-cube "></i> <span><?= $this->lang->line('sms_api'); ?></span></a></li>
            <?php } ?>

            <?php if($CI->permissions('smtp_settings') || is_admin() || is_store_admin() || smtp()) { ?>
            <li class="smtp-active-li"><a href="<?php echo $base_url; ?>smtp/"><i class="fa fa-envelope-square "></i> <span><?= $this->lang->line('smtp'); ?></span></a></li>
            <?php } ?>

            <?php if($CI->permissions('gateway_view') && is_admin() && store_module()) { ?>
            <li class="gateways-active-li"><a href="<?php echo $base_url; ?>gateways"><i class="fa fa- fa-credit-card  "></i> <span><?= $this->lang->line('payment_gateways'); ?></span>
              </a></li>
            <?php } ?>

            <?php if($CI->permissions('package_view') && is_admin() && store_module()) { ?>
            <li class="package-active-li  package-list-active-li"><a href="<?php echo $base_url; ?>package"><i class="fa fa-get-pocket  "></i> <span><?= $this->lang->line('package_list'); ?></span>
              </a></li>
            <?php } ?>

            <?php if(!is_user()){?>

                <?php if($CI->permissions('subscription') && store_module()) { ?>
                <li class="subscription-active-li  subscription-list-active-li"><a href="<?php echo $base_url; ?>subscription"><i class="fa fa-calendar  "></i> <span><?= $this->lang->line('subscription'); ?></span>
                  </a></li>
                <?php } ?>
                

                <?php if($CI->permissions('tax_view')) { ?>
                <li class="tax-active-li  tax-list-active-li"><a href="<?php echo $base_url; ?>tax"><i class="fa fa-percent  "></i> <span><?= $this->lang->line('tax_list'); ?></span>
                  </a></li>
                <?php } ?>
                <?php if($CI->permissions('units_view')) { ?>
                <li class="units-list-active-li unit-active-li"><a href="<?php echo $base_url; ?>units/"><i class="fa fa-list "></i> <span><?= $this->lang->line('units_list'); ?></span></a></li>
                <?php } ?>

                <?php if($CI->permissions('payment_types_view')) { ?>
                <li class="payment_types_list-active-li payment_types-active-li"><a href="<?php echo $base_url; ?>payment_types/"><i class="fa fa-list "></i> <span><?= $this->lang->line('payment_types'); ?></span>
                  </a></li>
                <?php } ?>
            <?php } ?><!-- is_user() -->


            <?php if(special_access()) { ?>
            <li class="currency-view-active-li currency-active-li"><a href="<?php echo $base_url; ?>currency/view"><i class="fa fa-gg "></i> <span><?= $this->lang->line('currency_list'); ?></span></a></li>
            <?php } ?>

  

            <li class="change-pass-active-li"><a href="<?php echo $base_url; ?>users/password_reset"><i class="fa fa-lock "></i> <span><?= $this->lang->line('change_password'); ?></span></a></li>

            

            <?php if(special_access()) { ?>
            <li class="dbbackup-active-li"><a href="<?php echo $base_url; ?>users/dbbackup"><i class="fa fa-database "></i> <span><?= $this->lang->line('database_backup'); ?></span></a></li>
            <?php } else if(isset($CI) && ($CI->permissions('store_edit') || is_store_admin())) { ?>
            <li class="dbbackup-active-li"><a href="<?php echo $base_url; ?>store/download_shop_backup/<?= $this->session->userdata('store_id'); ?>"><i class="fa fa-database "></i> <span><?= $this->lang->line('database_backup'); ?></span></a></li>
            <?php } ?>
            
       </ul>
        </li>
        <?php } ?>

        <?php if($CI->permissions('help_link')) { ?>
        <li><a href="https://www.youtube.com/playlist?list=PLFHe6h2YfEen9xYtwkCLLoxgi9l6OGhva" target="_blank"  ><i class="fa fa-youtube-play"></i> <span><?= $this->lang->line('help_video'); ?></span></a></li>
        <?php } ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  <!-- Mobile Sidebar Backdrop Overlay -->
  <div class="sidebar-backdrop hidden-lg hidden-md hidden-sm"></div>