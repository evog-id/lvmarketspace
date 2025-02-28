<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo gam_language_dir(); ?>" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
  <?php osc_current_web_theme_path('head.php') ; ?>
  <meta name="robots" content="noindex, nofollow" />
  <meta name="googlebot" content="noindex, nofollow" />
</head>
<body id="body-user-forgot-password">
  <?php osc_current_web_theme_path('header.php'); ?>

  <div class="logo-auth">
    <a href="<?php echo osc_base_url(); ?>" title="<?php echo osc_esc_html(__('Back to home page', 'gamma')); ?>"><?php echo gam_logo(); ?></a>
  </div>
  
  <div id="i-forms" class="content">

    <!-- RECOVER PASSWORD FORM -->
    <div id="recover" class="box">
      <div class="wrap">
        <h1><?php _e('Reset password', 'gamma'); ?></h1>

        <div class="user_forms login">
          <div class="inner">
            <form action="<?php echo osc_base_url(true) ; ?>" method="post" >
              <input type="hidden" name="page" value="login" />
              <input type="hidden" name="action" value="forgot_post" />
              <input type="hidden" name="userId" value="<?php echo osc_esc_html(Params::getParam('userId')); ?>" />
              <input type="hidden" name="code" value="<?php echo osc_esc_html(Params::getParam('code')); ?>" />
              
              <fieldset>
                <label for="new_email"><?php _e('New password', 'gamma') ; ?></label>
                <span class="input-box"><input type="password" name="new_password" value="" /></div>
                
                <label for="new_email"><?php _e('Repeat password', 'gamma') ; ?></label>
                <span class="input-box"><input type="password" name="new_password2" value="" /></div>

                <button type="submit" class="mbBg2"><?php _e('Submit', 'gamma') ; ?></button>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php osc_current_web_theme_path('footer.php') ; ?>
</body>
</html>