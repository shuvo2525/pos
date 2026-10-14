<script>
  var base_url = '<?=base_url()?>';
</script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo $theme_link; ?>bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="<?php echo $theme_link; ?>plugins/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $theme_link; ?>plugins/DataTables-1.10.18/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo $theme_link; ?>plugins/DataTables-1.10.18/extensions/FixedHeader-3.1.4/js/dataTables.fixedHeader.min.js"></script>
<script src="<?php echo $theme_link; ?>plugins/DataTables-1.10.18/extensions/Responsive-2.2.2/js/dataTables.responsive.min.js"></script>
<script src="<?php echo $theme_link; ?>plugins/DataTables-1.10.18/extensions/Responsive-2.2.2/js/responsive.bootstrap.min.js"></script>
<!-- end -->
<!--  FOR EXPORT BUTTONS START -->
<script src="<?php echo $theme_link; ?>plugins/DataTables-1.10.18/extensions/JSZip-2.5.0/jszip.min.js"></script>
<script src="<?php echo $theme_link; ?>plugins/DataTables-1.10.18/extensions/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="<?php echo $theme_link; ?>plugins/DataTables-1.10.18/extensions/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="<?php echo $theme_link; ?>plugins/DataTables-1.10.18/extensions/Buttons-1.5.4/js/dataTables.buttons.min.js"></script>
<script src="<?php echo $theme_link; ?>plugins/DataTables-1.10.18/extensions/Buttons-1.5.4/js/buttons.flash.min.js"></script>
<script src="<?php echo $theme_link; ?>plugins/DataTables-1.10.18/extensions/Buttons-1.5.4/js/buttons.html5.min.js"></script>
<script src="<?php echo $theme_link; ?>plugins/DataTables-1.10.18/extensions/Buttons-1.5.4/js/buttons.print.min.js"></script>
<script src="<?php echo $theme_link; ?>plugins/DataTables-1.10.18/extensions/Buttons-1.5.4/js/buttons.colVis.min.js"></script>
<script src="<?php echo $theme_link; ?>plugins/DataTables-1.10.18/extensions/Buttons-1.5.4/js/buttons.bootstrap.min.js"></script>
<!--  FOR EXPORT BUTTONS END -->

<!-- SlimScroll -->
<script src="<?php echo $theme_link; ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $theme_link; ?>plugins/fastclick/fastclick.js"></script>
<!-- Shortcut Keys -->
<script src="<?php echo $theme_link; ?>plugins/shortcuts/shortcuts.js"></script>
<!-- Select2 -->
<script src="<?php echo $theme_link; ?>plugins/select2/select2.full.min.js"></script>
<!-- AdminLTE App -->
<script>
  var AdminLTEOptions = {
    /*https://adminlte.io/themes/AdminLTE/documentation/index.html*/
    sidebarExpandOnHover: true,
    navbarMenuHeight: "200px", //The height of the inner menu
    animationSpeed: 250,
  };
</script>
<script src="<?php echo $theme_link; ?>dist/js/app.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php echo $theme_link; ?>dist/js/demo.js"></script> -->
<!-- page script -->
<!--Toastr notification -->
<script src="<?php echo $theme_link; ?>toastr/toastr.js"></script>
<script src="<?php echo $theme_link; ?>toastr/toastr_custom.js"></script>
<!--Toastr notification end-->
<!-- bootstrap datepicker -->
<script src="<?php echo $theme_link; ?>plugins/daterangepicker/moment.min.js"></script>
<script src="<?php echo $theme_link; ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="<?php echo $theme_link; ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Autocomplete -->      
<script src="<?php echo $theme_link; ?>plugins/autocomplete/autocomplete.js"></script>
<!-- Custom JS -->
<script src="<?php echo $theme_link; ?>js/special_char_check.js"></script>
<script src="<?php echo $theme_link; ?>js/custom.js"></script>

<!-- Pace Loader -->
<script src="<?php echo $theme_link; ?>plugins/pace/pace.min.js"></script>
<script type="text/javascript">
$(document).ajaxStart(function() { Pace.restart(); }); 
</script>  
<!-- Sweet alert -->
<script src="<?php echo $theme_link; ?>js/sweetalert.min.js"></script>


<!-- iCheck -->
<script src="<?php echo $theme_link; ?>plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-orange',
      /*uncheckedClass: 'bg-white',*/
      radioClass: 'iradio_square-orange',
      increaseArea: '10%' // optional
    });
  });
</script>
<!-- Initialize Select2 Elements -->
<script type="text/javascript"> $(".select2").select2(); </script>
<!-- Initialize toggler -->
<script type="text/javascript">
  $(document).ready(function(){
      $('[data-toggle="popover"]').popover();   
  });
</script>
<!-- Initialize date with its Format -->
<script type="text/javascript">
  //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
    format: '<?php echo $VIEW_DATE;?>',
     todayHighlight: true
    });
</script>
<script>
  $(function () {
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('<?php echo strtoupper($VIEW_DATE) ;?>') + ' - ' + end.format('<?php echo strtoupper($VIEW_DATE);?>'))
      }
    );


  });

    function get_start_date(){
        return $('#daterange-btn').data('daterangepicker').startDate.format('<?php echo strtoupper($VIEW_DATE) ;?>');
    }
    function get_end_date(){
        return $('#daterange-btn').data('daterangepicker').endDate.format('<?php echo strtoupper($VIEW_DATE) ;?>');
    }
</script>
<script type="text/javascript" >
$(function($) { // this script needs to be loaded on every page where an ajax POST may happen
  //var csrf = $('input[name="csrf_token"]').val();  // <- get token value from hidden form input
    $.ajaxSetup({ data: {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }  }); });
</script>
<script type="text/javascript">
	function show_delete_btn() {
  var group_check_count = $(".group_check").prop("checked") ? 1: 0;
  var check_count = $('#example2').find('input[type=checkbox]:checked').length-parseInt(group_check_count);

  //console.log($('#example2 > tbody').find('.checkbox').length);
  if(parseInt(check_count)>0){
    $(".delete_btn").removeClass('hidden').show();
  }    
  else{
    $(".delete_btn").addClass('hidden').hide();
  }

  if($('#example2 > tbody').find('.checkbox').length == check_count){
    $(".group_check").prop("checked",true).iCheck('update');
  }
  else{
    $(".group_check").prop("checked",false).iCheck('update');
  }

}
$('.group_check').on('ifChanged', function(event) {
    if(event.target.checked){
      $(".column_checkbox").prop("checked",true).iCheck('update');
    }
    else{
      $(".column_checkbox").prop("checked",false).iCheck('update');
    }
    //$(".undelete").prop("checked",false).iCheck('update');
    show_delete_btn();
});


function call_code(){
  $('.column_checkbox').on('ifChanged', function(event) {
      show_delete_btn();
  });
}
</script>
<script type="text/javascript">
$(document).ready(function () { setTimeout(function() {$( ".alert-dismissable" ).fadeOut( 1000, function() {});}, 10000); });
</script>
<script type="text/javascript">
  function round_off(input=0){
    <?php if(is_enabled_round_off()){ ?>
      return to_Fixed(Math.round(input));
    <?php }else{?>
      return to_Fixed(input);
    <?php }?>
  }
</script>

<script type="text/javascript">
  function to_Fixed(res=0){
      var decimals = <?=decimals()?>;
        return (isNaN(parseFloat(res))) ? parseFloat(0).toFixed(decimals) : parseFloat(res).toFixed(decimals); 
      }
</script>
<script type="text/javascript">
  function format_qty(res=0){
      var decimals = <?=qty_decimal()?>;
        return (isNaN(parseFloat(res))) ? parseFloat(0).toFixed(decimals) : parseFloat(res).toFixed(decimals); 
      }
</script>
<script type="text/javascript">
  $("#item_search").on("focusout", function(){
  $("#item_search").val('').removeClass('ui-autocomplete-loading');
});
</script>
<script type="text/javascript">
// Smart auto-flip & full visibility for DataTable action dropdowns
function adjustTableDropdownPosition($btnGroup) {
    var $menu = $btnGroup.find('.dropdown-menu');
    var $btn = $btnGroup.find('.dropdown-toggle');
    if (!$menu.length || !$btn.length) return;

    var $boxBody = $btnGroup.closest('.box-body');
    var $box = $btnGroup.closest('.box');
    var $responsive = $btnGroup.closest('.table-responsive');
    var $wrapper = $btnGroup.closest('.dataTables_wrapper');
    var $tr = $btnGroup.closest('tr');

    $boxBody.addClass('dropdown-opened').css('overflow', 'visible');
    $box.addClass('dropdown-opened').css('overflow', 'visible');
    $responsive.addClass('dropdown-opened').css('overflow', 'visible');
    if ($wrapper.length) {
        $wrapper.css('overflow', 'visible');
    }

    var isChildRow = $btnGroup.closest('tr.child, .dtr-details, .dtr-data').length > 0;
    var sidebarWidth = $('.main-sidebar').outerWidth() || 230;
    if ($('body').hasClass('sidebar-collapse')) {
        sidebarWidth = 50;
    }
    if ($(window).width() <= 767) {
        sidebarWidth = 0;
    }

    var btnOffset = $btn.offset();
    var windowWidth = $(window).width();
    var windowHeight = $(window).height();
    var scrollTop = $(window).scrollTop();
    var btnHeight = $btn.outerHeight() || 32;
    var spaceBelow = windowHeight - (btnOffset.top - scrollTop) - btnHeight;
    var mainHeader = $('.main-header');
    var headerBottom = mainHeader.length ? (mainHeader.offset().top + mainHeader.outerHeight()) : 50;
    var spaceAbove = (btnOffset.top - scrollTop) - headerBottom;

    var maxAllowedHeight = 240;

    // Dropup (vertical) adjustment:
    // If space below is tight (< 220px) and space above has room, flip to dropup!
    if (spaceBelow < 220 && spaceAbove > 160) {
        $btnGroup.addClass('dropup');
        var allowedHeight = Math.min(maxAllowedHeight, Math.max(150, spaceAbove - 15));
        $menu.css({
            'max-height': allowedHeight + 'px',
            'overflow-y': 'auto',
            'top': 'auto',
            'bottom': '100%',
            'margin-bottom': '4px',
            'margin-top': '0'
        });
    } else {
        $btnGroup.removeClass('dropup');
        var allowedHeight = Math.min(maxAllowedHeight, Math.max(150, spaceBelow - 15));
        $menu.css({
            'max-height': allowedHeight + 'px',
            'overflow-y': 'auto',
            'top': '100%',
            'bottom': 'auto',
            'margin-top': '4px',
            'margin-bottom': '0'
        });
    }

    // High z-index on tr and btn-group so it floats cleanly above all rows and pagination
    if ($tr.length) {
        $tr.css({ 'position': 'relative', 'z-index': '1060' });
    }
    $btnGroup.css({ 'position': 'relative', 'z-index': '1065' });

    var menuWidth = $menu.outerWidth() || 220;
    var btnLeft = btnOffset.left;
    var btnRight = btnLeft + ($btn.outerWidth() || 70);

    // If inside a responsive child row, the button is on the left, so MUST open to the right
    if (isChildRow) {
        $btnGroup.addClass('open-right').removeClass('open-left');
        $menu.removeClass('pull-right dropdown-menu-right').css({
            'left': '0',
            'right': 'auto'
        });
        return;
    }

    // Check if opening to the left (pull-right) would put the menu behind the sidebar or off-screen:
    if ((btnRight - menuWidth) < (sidebarWidth + 10)) {
        // Must open to the right!
        $btnGroup.addClass('open-right').removeClass('open-left');
        $menu.removeClass('pull-right dropdown-menu-right').css({
            'left': '0',
            'right': 'auto'
        });
    } else if (btnLeft + menuWidth > windowWidth - 15) {
        // Must open to the left!
        $btnGroup.addClass('open-left').removeClass('open-right');
        $menu.addClass('pull-right dropdown-menu-right').css({
            'right': '0',
            'left': 'auto'
        });
    } else {
        if (btnLeft > (windowWidth / 2)) {
            $btnGroup.addClass('open-left').removeClass('open-right');
            $menu.addClass('pull-right dropdown-menu-right').css({
                'right': '0',
                'left': 'auto'
            });
        } else {
            $btnGroup.addClass('open-right').removeClass('open-left');
            $menu.removeClass('pull-right dropdown-menu-right').css({
                'left': '0',
                'right': 'auto'
            });
        }
    }
}

$(document).on('show.bs.dropdown shown.bs.dropdown', '.table-responsive .btn-group, .table-responsive .dropdown, .table .btn-group, .dtr-data .btn-group, .box-body .btn-group', function () {
    adjustTableDropdownPosition($(this));
});

$(document).on('hidden.bs.dropdown', '.table-responsive .btn-group, .table-responsive .dropdown, .table .btn-group, .dtr-data .btn-group, .box-body .btn-group', function () {
    var $btnGroup = $(this);
    $btnGroup.removeClass('dropup open-right open-left').css('z-index', '');
    $btnGroup.find('.dropdown-menu').css({
        'left': '',
        'right': '',
        'max-height': '',
        'overflow-y': '',
        'top': '',
        'bottom': '',
        'margin-top': '',
        'margin-bottom': ''
    });
    $btnGroup.closest('tr').css({ 'position': '', 'z-index': '' });
    $btnGroup.closest('.table-responsive').removeClass('dropdown-opened').css('overflow', '');
    $btnGroup.closest('.box-body').removeClass('dropdown-opened').css('overflow', '');
    $btnGroup.closest('.box').removeClass('dropdown-opened').css('overflow', '');
});
</script>
