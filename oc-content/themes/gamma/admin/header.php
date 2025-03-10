<?php
  require_once 'functions.php';


  // Create menu
  $title = __('Category', 'gamma');
  gam_menu($title);


  // GET & UPDATE PARAMETERS
  // $variable = gam_param_update( 'param_name', 'form_name', 'input_type', 'plugin_var_name' );
  // input_type: check, value or code



  switch( Params::getParam('theme_action') ) {
    case('upload_logo'):
      $package = Params::getFiles('logo');
      if( $package['error'] == UPLOAD_ERR_OK ) {
        if( move_uploaded_file($package['tmp_name'], WebThemes::newInstance()->getCurrentThemePath() . "images/logo.jpg" ) ) {
          osc_add_flash_ok_message(__('The logo image has been uploaded correctly', 'gamma'), 'admin');
        } else {
          osc_add_flash_error_message(__("An error has occurred, please try again", 'gamma'), 'admin');
        }
      } else {
        osc_add_flash_error_message(__("An error has occurred, please try again", 'gamma'), 'admin');
      }
      header('Location: ' . osc_admin_render_theme_url('oc-content/themes/' . osc_current_web_theme() . '/admin/header.php')); exit;
      break;

    case('remove'):
      if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/logo.jpg" ) ) {
        @unlink( WebThemes::newInstance()->getCurrentThemePath() . "images/logo.jpg" );
        osc_add_flash_ok_message(__('The logo image has been removed', 'gamma'), 'admin');
      } else {
        osc_add_flash_error_message(__("Image not found", 'gamma'), 'admin');
      }
      header('Location: ' . osc_admin_render_theme_url('oc-content/themes/' . osc_current_web_theme() . '/admin/header.php')); exit;
      break;
  } 



  if(Params::getParam('theme_action') == 'done') {
    message_ok( __('Settings were successfully saved', 'gamma') );
  }
?>


<div class="mb-body">
  <?php if( is_writable( WebThemes::newInstance()->getCurrentThemePath() . "images/") ) { ?>

    <!-- LOGO PREVIEW -->
    <div class="mb-box">
      <div class="mb-head"><i class="fa fa-display"></i> <?php _e('Logo preview', 'gamma'); ?></div>

      <?php if(file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/logo.jpg" ) ) { ?>
        <div class="mb-inside">
          <img class="mb-image-preview" border="0" alt="<?php echo osc_esc_html( osc_page_title() ); ?>" src="<?php echo osc_current_web_theme_url('images/logo.jpg');?>" />
        </div>

        <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/gamma/admin/header.php');?>" method="post" enctype="multipart/form-data">
          <input type="hidden" name="theme_action" value="remove" />

          <div class="mb-foot">
            <button type="submit" class="mb-button"><?php _e('Remove', 'gamma');?></button>
          </div>
        </form>

      <?php } else { ?>
        <div class="mb-inside">
          <div class="mb-warning">
            <?php _e('No logo has been uploaded yet', 'gamma'); ?>
          </div>
        </div>
      <?php } ?>
    </div>



    <!-- LOGO UPLOAD -->
    <div class="mb-box">
      <div class="mb-head"><i class="fa fa-upload"></i> <?php _e('Logo upload', 'gamma'); ?></div>

      <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/gamma/admin/header.php'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="theme_action" value="upload_logo" />

        <div class="mb-inside">
          <div class="mb-points">
            <div class="mb-row">- <strong><?php _e('When new logo is uploaded, do not forget to clean your browser cache (CTRL + R or CTRL + F5)', 'gamma'); ?></strong></div>
            <div class="mb-row">- <?php _e('The preferred size of the logo is 200x50px.', 'gamma'); ?></div>
            <div class="mb-row">- <?php _e('Following formats are allowed: png, gif, jpg','gamma'); ?></div>

            <?php if( file_exists( WebThemes::newInstance()->getCurrentThemePath() . "images/logo.jpg" ) ) { ?>
              <div class="mb-row">- <?php _e('Uploading another logo will overwrite the current logo.', 'gamma'); ?></div>
            <?php } ?>
          </div>

          <input type="file" name="logo" id="package" />
        </div>
 
        <div class="mb-foot">
          <button type="submit" class="mb-button"><?php _e('Upload', 'gamma');?></button>
        </div>
      </form>
    <?php } else { ?>
      <div class="mb-warning">
        <div class="mb-row">
          <?php
            $msg  = sprintf(__('The images folder <strong>%s</strong> is not writable on your server', 'gamma'), WebThemes::newInstance()->getCurrentThemePath() ."images/" ) .", ";
            $msg .= __("OSClass can't upload the logo image from the administration panel.", 'gamma') . ' ';
            $msg .= __('Please make the aforementioned image folder writable.', 'gamma') . ' ';
            echo $msg;
          ?>
        </div>

        <div class="mb-row">
          <?php _e('To make a directory writable under UNIX execute this command from the shell:','gamma'); ?>
        </div>

        <div class="mb-row">
          chmod a+w <?php echo WebThemes::newInstance()->getCurrentThemePath() ."images/" ; ?>
        </div>
      </div>
    <?php } ?>
  </div>
</div>


<?php echo gam_footer(); ?>