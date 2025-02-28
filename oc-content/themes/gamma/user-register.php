<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo gam_language_dir(); ?>" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
  <?php osc_current_web_theme_path('head.php'); ?>
  <meta name="robots" content="noindex, nofollow" />
  <meta name="googlebot" content="noindex, nofollow" />
  <script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('jquery.validate.min.js'); ?>"></script>
</head>

<?php
  $type = (Params::getParam('move') == '' ? 'register' : Params::getParam('move'));
?>

<body id="body-user-register">
  <?php UserForm::js_validation(); ?>
  <?php osc_current_web_theme_path('header.php'); ?>

  <div class="logo-auth">
    <a href="<?php echo osc_base_url(); ?>" title="<?php echo osc_esc_html(__('Back to home page', 'gamma')); ?>"><?php echo gam_logo(); ?></a>
  </div>

  <div id="i-forms" class="content">

    <!-- LOGIN FORM -->
    <div id="login" class="box" <?php if($type <> 'login') { ?>style="display:none;"<?php } ?> data-type="login">
      <div class="wrap">
        <h1><?php _e('Login', 'gamma'); ?></h1>

        <div class="user_forms login">
          <div class="inner">

            <?php if(function_exists('fl_call_after_install') || function_exists('gc_login_button')) { ?>
              <div class="social">
                <?php if(function_exists('fl_call_after_install')) { ?>
                  <a class="facebook" href="<?php echo facebook_login_link(); ?>" title="<?php echo osc_esc_html(__('Connect with Facebook', 'gamma')); ?>">
                    <i class="fab fa-facebook-square"></i>
                    <span><?php _e('Continue with Facebook', 'gamma'); ?></span>
                  </a>
                <?php } ?>

                <?php if(function_exists('ggl_login_link')) { ?>
                  <a class="google" href="<?php echo ggl_login_link(); ?>" title="<?php echo osc_esc_html(__('Connect with Google', 'gamma')); ?>">
                    <i class="fab fa-google"></i>
                    <span><?php _e('Continue with Google', 'gamma'); ?></span>
                  </a>
                <?php } ?>
              </div>
            <?php } ?>


            <form action="<?php echo osc_base_url(true); ?>" method="post" >
              <input type="hidden" name="page" value="login" />
              <input type="hidden" name="action" value="login_post" />
              
              <?php osc_run_hook('user_pre_login_form'); ?>

              <fieldset>
                <label for="email"><span><?php _e('E-mail', 'gamma'); ?></span></label> <span class="input-box"><?php UserForm::email_login_text(); ?></span>
                <label for="password"><span><?php _e('Password', 'gamma'); ?></span></label> <span class="input-box"><?php UserForm::password_login_text(); ?></span>

                <div class="login-line">
                  <div class="input-box-check">
                    <?php UserForm::rememberme_login_checkbox();?>
                    <label for="remember"><?php _e('Remember me', 'gamma'); ?></label>
                  </div>
                </div>

                <div class="user-reg-hook"><?php osc_run_hook('user_login_form'); ?></div>

                <?php gam_show_recaptcha('login'); ?>

                <button type="submit" class="mbBg2"><?php _e('Log in', 'gamma');?></button>
              </fieldset>
            </form>
          </div>
        </div>

        <div class="swap">
          <a href="#" class="signup" data-type="register"><?php _e('Sign up', 'gamma'); ?></a>
          <a href="#" class="recover" data-type="recover"><?php _e('Forgot password', 'gamma'); ?></a>
        </div>
      </div>
    </div>


    <!-- REGISTER FORM -->
    <div id="register" class="box" <?php if($type <> 'register') { ?>style="display:none;"<?php } ?> data-type="register">
      <div class="wrap">

        <h1><?php _e('Sign up', 'gamma'); ?></h1>

        <div class="user_forms register">
          <div class="inner"> 

            <?php if(function_exists('fl_call_after_install') || function_exists('gc_login_button')) { ?>
              <div class="social">
                <?php if(function_exists('fl_call_after_install')) { ?>
                  <a class="facebook" href="<?php echo facebook_login_link(); ?>" title="<?php echo osc_esc_html(__('Connect with Facebook', 'gamma')); ?>">
                    <i class="fab fa-facebook-square"></i>
                    <span><?php _e('Continue with Facebook', 'gamma'); ?></span>
                  </a>
                <?php } ?>

                <?php if(function_exists('ggl_login_link')) { ?>
                  <a class="google" href="<?php echo ggl_login_link(); ?>" title="<?php echo osc_esc_html(__('Connect with Google', 'gamma')); ?>">
                    <i class="fab fa-google"></i>
                    <span><?php _e('Continue with Google', 'gamma'); ?></span>
                  </a>
                <?php } ?>
              </div>
            <?php } ?>
         
            <form name="register" id="register" action="<?php echo osc_base_url(true); ?>" method="post" >
              <input type="hidden" name="page" value="register" />
              <input type="hidden" name="action" value="register_post" />
              
              <?php osc_run_hook('user_pre_register_form'); ?>
              
              <fieldset>
                <ul id="error_list"></ul>

                <label for="name"><span><?php _e('Name', 'gamma'); ?></span><span class="req">*</span></label> <span class="input-box"><?php UserForm::name_text(); ?></span>
                <label for="password"><span><?php _e('Password', 'gamma'); ?></span><span class="req">*</span></label> <span class="input-box"><?php UserForm::password_text(); ?></span>
                <label for="password"><span><?php _e('Re-type password', 'gamma'); ?></span><span class="req">*</span></label> <span class="input-box"><?php UserForm::check_password_text(); ?></span>
                <label for="email"><span><?php _e('E-mail', 'gamma'); ?></span><span class="req">*</span></label> <span class="input-box"><?php UserForm::email_text(); ?></span>
                <label for="phone"><?php _e('Mobile Phone', 'gamma'); ?></label> <span class="input-box last"><?php UserForm::mobile_text(osc_user()); ?></span>


                <div class="user-reg-hook"><?php osc_run_hook('user_register_form'); ?></div>

                <?php gam_show_recaptcha('register'); ?>

                <button type="submit" class="mbBg2"><?php _e('Create account', 'gamma'); ?></button>

              </fieldset>
            </form>
          </div>
        </div>

        <div class="swap">
          <a href="#" class="login" data-type="login"><?php _e('Login', 'gamma'); ?></a>
          <a href="#" class="recover" data-type="recover"><?php _e('Forgot password', 'gamma'); ?></a>
        </div>
      </div>
    </div>


    <!-- FORGOT PASSWORD FORM -->
    <div id="forgot" class="box" <?php if($type <> 'recover') { ?>style="display:none;"<?php } ?> data-type="recover">
      <div class="wrap">

        <h1><?php _e('Forgot password', 'gamma'); ?></h1>

        <div class="user_forms recover">
          <div class="inner">          
            <form action="<?php echo osc_base_url(true) ; ?>" method="post" >
              <input type="hidden" name="page" value="login" />
              <input type="hidden" name="action" value="recover_post" />

              <fieldset>
                <label for="email"><?php _e('E-mail', 'gamma') ; ?></label> 
                <span class="input-box"><?php UserForm::email_text(); ?></span>

                <?php gam_show_recaptcha('recover_password'); ?>

                <button type="submit" class="mbBg2"><?php _e('Send a new password', 'gamma') ; ?></button>
              </fieldset>
            </form>
          </div>
        </div>

        <div class="swap">
          <a href="#" class="login" data-type="login"><?php _e('Login', 'gamma'); ?></a>
          <a href="#" class="signup" data-type="register"><?php _e('Sign up', 'gamma'); ?></a>
        </div>
      </div>
    </div>


  </div>


  <?php osc_current_web_theme_path('footer.php'); ?>
</body>
</html>