<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo zet_language_dir(); ?>" mode="<?php echo zet_light_dark_mode(); ?>" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
  <?php osc_current_web_theme_path('head.php'); ?>
  <meta name="robots" content="index, follow" />
  <meta name="googlebot" content="index, follow" />
  <script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('jquery.validate.min.js'); ?>"></script>
</head>

<body id="user-login" class="pre-account login <?php osc_run_hook('body_class'); ?>">
  <?php UserForm::js_validation(); ?>
  <?php osc_current_web_theme_path('header.php'); ?>

  <section class="container">
    <div class="box">
      <h1><?php _e('Sign-in to your account', 'zeta'); ?></h1>
      <h2><?php _e('Welcome back, please enter your login credentials', 'zeta'); ?></h2>

      <?php if(function_exists('fl_call_after_install') || function_exists('gc_login_button') || function_exists('fjl_login_button')) { ?>
        <div class="social">
          <?php if(function_exists('fl_call_after_install') && facebook_login_link() !== false) { ?>
            <a class="facebook" href="<?php echo facebook_login_link(); ?>" title="<?php echo osc_esc_html(__('Login with Facebook', 'zeta')); ?>">
              <i class="fab fa-facebook"></i>
              <span><?php _e('Login with Facebook', 'zeta'); ?></span>
            </a>
          <?php } ?>

          <?php if(function_exists('ggl_login_link') && ggl_login_link() !== false) { ?>
            <a class="google" href="<?php echo ggl_login_link(); ?>" title="<?php echo osc_esc_html(__('Sign in with Google', 'zeta')); ?>">
              <i class="fab fa-google"></i>
              <span><?php _e('Sign in with Google', 'zeta'); ?></span>
            </a>
          <?php } ?>
          
          <?php if(function_exists('fjl_login_button')) { ?>
            <a target="_top" href="javascript:void(0);" class="facebook fl-button fjl-button" onclick="fjlCheckLoginState();" title="<?php echo osc_esc_html(__('Connect with Facebook', 'zeta')); ?>">
              <i class="fab fa-facebook-square"></i>
              <span><?php _e('Continue with Facebook', 'zeta'); ?></span>
            </a>
          <?php } ?>
        </div>
      <?php } ?>

      <form action="<?php echo osc_base_url(true); ?>" method="post" >
        <input type="hidden" name="page" value="login" />
        <input type="hidden" name="action" value="login_post" />
        
        <?php osc_run_hook('user_pre_login_form'); ?>

        <div class="row">
          <label for="email"><?php _e('E-mail', 'zeta'); ?></label>
          <span class="input-box"><?php UserForm::email_login_text(); ?></span>
        </div>

        <div class="row">
          <label for="password"><?php _e('Password', 'zeta'); ?></label>
          <span class="input-box">
            <?php UserForm::password_login_text(); ?>
            <a href="#" class="toggle-pass" title="<?php echo osc_esc_html(__('Show/hide password', 'zeta')); ?>"><i class="fa fa-eye-slash"></i></a>
          </span>
        </div>

        <div class="input-box-two">
          <div class="input-box-check">
            <?php UserForm::rememberme_login_checkbox();?>
            <label for="remember"><?php _e('Remember me', 'zeta'); ?></label>
          </div>
          
          <a class="alt-action2" href="<?php echo osc_recover_user_password_url(); ?>"><?php _e('Forgot password', 'zeta'); ?></a>
        </div>
        
        <div class="user-reg-hook"><?php osc_run_hook('user_login_form'); ?></div>

        <div class="row fr">
        </div>
        
        <?php zet_show_recaptcha('login'); ?>

        <button type="submit" class="btn"><?php _e('Log in', 'zeta');?></button>
      </form>
      
      <a class="alt-action" href="<?php echo osc_register_account_url(); ?>"><?php _e('No account yet? Register a new account', 'zeta'); ?> &#8594;</a>

    </div>
  </section>

  <?php osc_current_web_theme_path('footer.php'); ?>
  
  <script type="text/javascript">
    $(document).ready(function(){
      $('input[name="email"]').attr('placeholder', '<?php echo osc_esc_js(__('your.email@dot.com', 'zeta')); ?>').attr('required', true);
      $('input[name="password"]').attr('placeholder', '<?php echo osc_esc_js(__('YourPass123!', 'zeta')); ?>').attr('required', true);
    });
  </script>
</body>
</html>