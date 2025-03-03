<?php
  require_once 'functions.php';


  // Create menu
  $title = __('Advertisement', 'gamma');
  gam_menu($title);


  // GET & UPDATE PARAMETERS
  // $variable = gam_param_update( 'param_name', 'form_name', 'input_type', 'plugin_var_name' );
  // input_type: check, value or code

  $banners = gam_param_update('banners', 'theme_action', 'check', 'theme-gamma');
 
  foreach(gam_banner_list() as $b) {
    gam_param_update($b['id'], 'theme_action', 'code', 'theme-gamma');
  }


  if(Params::getParam('theme_action') == 'done') {
    message_ok( __('Settings were successfully saved', 'gamma') );
  }
?>


<div class="mb-body">
  <div class="mb-notes">
    <div class="mb-line"><?php _e('If you use Banner Ads Plugin, you can use banner or advert directly in theme banner space by defining its ID in bellow form.', 'gamma'); ?></div>
    <div class="mb-line"><?php _e('Usage examples: {{BANNER-ADS-PLUGIN-HOOK: my_custom_hook}}, {{BANNER-ADS-PLUGIN-BANNER: 123}}, {{BANNER-ADS-PLUGIN-ADVERT: 987}}, {{BANNER-ADS-PLUGIN-ADVERTISE-BUTTON: 987}}', 'gamma'); ?></div>
  </div>
 
  <!-- BANNER SECTION -->
  <div class="mb-box">
    <div class="mb-head"><i class="fa fa-clone"></i> <?php _e('Advertisement', 'gamma'); ?></div>

    <div class="mb-inside mb-minify">
      <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/gamma/admin/banner.php'); ?>" method="POST">
        <input type="hidden" name="theme_action" value="done" />

        <div class="mb-row">
          <label for="banners" class="h1"><span><?php _e('Enable Theme Banners', 'gamma'); ?></span></label> 
          <input name="banners" id="banners" class="element-slide" type="checkbox" <?php echo (gam_param('banners') == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('When enabled, bellow banners will be shown in front page.', 'gamma'); ?></div>
        </div>
        
        <?php foreach(gam_banner_list() as $b) { ?>
          <div class="mb-row">
            <label for="<?php echo $b['id']; ?>" class="h29"><span><?php echo ucwords(str_replace('_', ' ', $b['id'])); ?></span></label> 
            <textarea class="mb-textarea mb-textarea-large" name="<?php echo $b['id']; ?>" placeholder="<?php echo osc_esc_html(__('Will be shown', 'gamma')); ?>: <?php echo $b['position']; ?>"><?php echo stripslashes(gam_param($b['id']) ); ?></textarea>
          </div>
        <?php } ?>



        <div class="mb-row">&nbsp;</div>

        <div class="mb-foot">
          <button type="submit" class="mb-button"><?php _e('Save', 'gamma');?></button>
        </div>
      </form>
    </div>
  </div>

</div>


<?php echo gam_footer(); ?>