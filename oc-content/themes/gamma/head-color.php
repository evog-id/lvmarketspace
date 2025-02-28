<?php
  $color = '.mbCl,footer .cl .lnk:hover,header .right a:hover, header .right a.publish:hover, body a, body a:hover';
  $color2 = '.mbCl2';
  $color3 = '.mbCl3,header .right a.actv,header .right a.actv svg';
  $background = '.mbBg,.pace .pace-progress,body #show-loan i, .im-body #uniform-undefined.frm-category,.frm-answer .frm-area .frm-buttons button,#search-sort .user-type a.active,#search-sort .list-grid a.active,.paginate ul li span,#listing .data .connect-after a:hover,.paginate ul li a:hover,.blg-btn.blg-btn-primary,.bpr-prof .bpr-btn, .post-edit .price-wrap .selection a.active';
  $background2 = '.mbBg2, .im-button-green';
  $background3 = '.mbBg3,.mobile-box a i,#photos .qq-upload-button, .tabbernav li.tabberactive a,.frm-title-right a.frm-new-topic,.im-user-account-count';
  $background_after = '.mbBgAf:after';
  $background_active = '.mbBgActive.active';
  $background2_active = '.mbBg2Active.active';
  $background3_active = '.mbBg3Active.active';
  $background_color = '';
  $border_color = '.mbBr,header .right a.publish:hover';
  $border2_color = '.mbBr2';
  $border3_color = '.mbBr3,.user-top-menu > .umenu li.active a';
  $border_background = '#atr-search .atr-input-box input[type="checkbox"]:checked + label:before, #atr-search .atr-input-box input[type="radio"]:checked + label:before,#atr-form .atr-input-box input[type="checkbox"]:checked + label:before, #atr-form .atr-input-box input[type="radio"]:checked + label:before,.bpr-box-check input[type="checkbox"]:checked + label:before, #gdpr-check.styled .input-box-check input[type="checkbox"]:checked + label:before, .pol-input-box input[type="checkbox"]:checked + label:before, .pol-values:not(.pol-nm-star) .pol-input-box input[type="radio"]:checked + label:before';
  $border_bottom = '';
  $border2_top = '.mbBr2Top';
  $border3_top = '.mbBr3Top, body #fi_user_new_list';
?>

<style>
  <?php echo $color; ?> {color:<?php echo gam_param('color'); ?>;}
  <?php echo $color2; ?> {color:<?php echo gam_param('color2'); ?>;}
  <?php echo $color3; ?> {color:<?php echo gam_param('color3'); ?>;}
  <?php echo $background; ?> {background:<?php echo gam_param('color'); ?>!important;color:#fff!important;}
  <?php echo $background2; ?> {background:<?php echo gam_param('color2'); ?>!important;color:#fff!important;}
  <?php echo $background3; ?> {background:<?php echo gam_param('color3'); ?>!important;color:#fff!important;}
  <?php echo $background_after; ?> {background:<?php echo gam_param('color'); ?>!important;}
  <?php echo $background_active; ?> {background:<?php echo gam_param('color'); ?>!important;}
  <?php echo $background2_active; ?> {background:<?php echo gam_param('color2'); ?>!important;}
  <?php echo $background3_active; ?> {background:<?php echo gam_param('color3'); ?>!important;}
  <?php echo $background_color; ?> {background-color:<?php echo gam_param('color'); ?>!important;}
  <?php echo $border_color; ?> {border-color:<?php echo gam_param('color'); ?>!important;}
  <?php echo $border2_color; ?> {border-color:<?php echo gam_param('color2'); ?>!important;}
  <?php echo $border3_color; ?> {border-color:<?php echo gam_param('color3'); ?>!important;}
  <?php echo $border_background; ?> {border-color:<?php echo gam_param('color'); ?>!important;background-color:<?php echo gam_param('color'); ?>!important;}
  <?php echo $border_bottom; ?> {border-bottom-color:<?php echo gam_param('color'); ?>!important;}
  <?php echo $border2_top; ?> {border-top-color:<?php echo gam_param('color2'); ?>!important;}
  <?php echo $border3_top; ?> {border-top-color:<?php echo gam_param('color3'); ?>!important;}
</style>

<script>
  var mbCl = '<?php echo $color; ?>';
  var mbCl2 = '<?php echo $color2; ?>';
  var mbCl3 = '<?php echo $color3; ?>';
  var mbBg = '<?php echo $background; ?>';
  var mbBg2 = '<?php echo $background2; ?>';
  var mbBg3 = '<?php echo $background3; ?>';
  var mbBgAf= '<?php echo $background_after; ?>';
  var mbBgAc= '<?php echo $background_active; ?>';
  var mbBg2Ac= '<?php echo $background2_active; ?>';
  var mbBg3Ac= '<?php echo $background3_active; ?>';
  var mbBr= '<?php echo $border_color; ?>';
  var mbBr2= '<?php echo @$border_color2; ?>';
  var mbBr3= '<?php echo @$border_color3; ?>';
  var mbBrBg= '<?php echo $border_background; ?>';
  var mbBrBt= '<?php echo $border_bottom; ?>';
  var mbBr2Top= '<?php echo $border2_top; ?>';
  var mbBr3Top= '<?php echo $border3_top; ?>';
</script>
