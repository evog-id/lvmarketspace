<?php
  $location_array = array(osc_user_city(), osc_user_region(), osc_user_country(), osc_user_address(), osc_user_zip());
  $location_array = array_filter($location_array);
  $location = implode(', ', $location_array);


  $user = osc_user();

  $mobile_found = true;

  $mobile = $user['s_phone_mobile'];
  if($mobile == '') { $mobile = $user['s_phone_land']; } 
 
  if(trim($mobile) == '' || strlen(trim($mobile)) < 4) { 
    $mobile = __('No phone number', 'gamma');
    $mobile_found = false;
  }


  $reg_type = '';
  $reg_has_date = false;

  if($user && $user['dt_reg_date'] <> '') { 
    $reg_type = sprintf(__('Posting for %s', 'gamma'), gam_smart_date2($user['dt_reg_date']));
    $reg_has_date = true;
  } else if ($user) { 
    $reg_type = __('Registered user', 'gamma');
  } else {
    $reg_type = __('Unregistered user', 'gamma');
  }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo gam_language_dir(); ?>" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
  <?php osc_current_web_theme_path('head.php') ; ?>
  <meta name="robots" content="noindex, nofollow" />
  <meta name="googlebot" content="noindex, nofollow" />
  <script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('jquery.validate.min.js') ; ?>"></script>
</head>

<body id="body-user-public-profile">
  <?php View::newInstance()->_exportVariableToView('user', $user); ?>
  <?php osc_current_web_theme_path('header.php') ; ?>

  <div class="inside user_public_profile" id="listing">

    <!-- LEFT BLOCK -->

    <div class="side">


      <div class="sold-by">
        <div class="sleft">
          <div class="user-img">
            <img src="<?php echo gam_profile_picture(osc_user_id(), 'medium'); ?>" alt="<?php echo osc_user_name(); ?>" />
          </div>

          <span class="titl"><?php _e('Seller', 'gamma'); ?>: <strong class="name"><?php echo osc_user_name(); ?></strong></span>

          <?php if(function_exists('ur_show_rating_link') && osc_user_id() > 0) { ?>
            <span class="ur-fdb">
              <span class="strs"><?php echo ur_show_rating_stars(); ?></span>
              <span class="lnk"><?php echo ur_add_rating_link(); ?></span>
            </span>
          <?php } ?>


          <?php if(osc_user_id() > 0) { ?>
            <a href="<?php echo osc_user_public_profile_url(osc_user_id()); ?>">
              <svg viewBox="0 0 32 32" width="14" height="14"><defs><path id="mbIconHome" d="M26.05 27.328a.862.862 0 01-.86.861h-4.982V17.41h-9v10.78H6.227a.863.863 0 01-.862-.862V13.125L15.634 2.82 26.05 13.082v14.246zm-12.842.861h5V19.41h-5v8.78zM31.41 15.552L15.62 0 0 15.676l1.416 1.412 1.949-1.956v12.196a2.865 2.865 0 002.862 2.861H25.19a2.864 2.864 0 002.86-2.86V15.051l1.956 1.925 1.404-1.425z"></path></defs><use fill="currentColor" xlink:href="#mbIconHome" fill-rule="evenodd" transform="translate(0 1)"></use></svg>
              <span><?php _e('Public profile', 'gamma'); ?></span>
            </a>

            <a href="<?php echo osc_search_url(array('page' => 'search', 'userId' => osc_user_id())); ?>">
              <svg viewBox="0 0 32 32" width="14" height="14" class="mbCl"><defs><path id="mbIconSearch" d="M12.618 23.318c-6.9 0-10.7-3.8-10.7-10.7 0-6.9 3.8-10.7 10.7-10.7 6.9 0 10.7 3.8 10.7 10.7 0 3.458-.923 6.134-2.745 7.955-1.821 1.822-4.497 2.745-7.955 2.745zm17.491 5.726l-7.677-7.678c1.854-2.155 2.804-5.087 2.804-8.748C25.236 4.6 20.636 0 12.618 0S0 4.6 0 12.618c0 8.019 4.6 12.618 12.618 12.618 3.485 0 6.317-.85 8.44-2.531l7.696 7.695 1.355-1.356z"></path></defs><use fill="currentColor" xlink:href="#mbIconSearch" fill-rule="evenodd"></use></svg>
              <span><?php _e('All seller listings', 'gamma'); ?></span>
            </a>
          <?php } ?>

        </div>

        <div class="sright">
          <a href="<?php echo gam_fancy_url('contact_public', array('userId' => osc_user_id())); ?>" class="open-form contact_public btn mbBg2" data-type="contact_public" data-user-id="<?php echo osc_user_id(); ?>">
            <svg viewBox="0 0 32 32" color="#fff" width="24" height="24"><defs><path id="mbIconEmail" d="M26.324 0A5.682 5.682 0 0132 5.676v12.648A5.682 5.682 0 0126.324 24H5.676A5.682 5.682 0 010 18.324V5.676A5.682 5.682 0 015.676 0h20.648zM30 18.324V5.676A3.68 3.68 0 0026.324 2H5.676A3.68 3.68 0 002 5.676v12.648A3.68 3.68 0 005.676 22h20.648A3.68 3.68 0 0030 18.324zm-14-4.616l10.367-8.482 1.266 1.548L16 16.292 4.367 6.774l1.266-1.548L16 13.708z"></path></defs><use fill="currentColor" xlink:href="#mbIconEmail" fill-rule="evenodd" transform="translate(0 4)"></use></svg>
            <span><?php _e('Contact seller', 'gamma'); ?></span>
          </a>

          <?php if($mobile_found) { ?>
            <a href="#" class="mobile btn" data-phone="<?php echo $mobile; ?>" title="<?php echo osc_esc_html(__('Click to show number', 'gamma')); ?>">
              <svg viewBox="0 0 32 32" width="24" height="24"><defs><path id="mbIconCall" d="M15.466 21.406l5.32-1.401 5.64 8.054-.402.573a8.281 8.281 0 01-2.04 2.02c-1.422.995-2.976 1.494-4.61 1.494-1.428 0-2.916-.38-4.433-1.142-3.098-1.554-6.28-4.645-9.46-9.187C2.302 17.275.487 13.227.085 9.786-.34 6.17.845 3.273 3.506 1.409A8.287 8.287 0 016.103.183L6.78 0l5.64 8.055-3.136 4.52 6.184 8.83zm7.37 7.607a6.501 6.501 0 001.123-.991l-4.011-5.728-5.32 1.4L6.845 12.58l3.136-4.52L5.97 2.332a6.475 6.475 0 00-1.317.716c-2.05 1.436-2.92 3.625-2.584 6.506.363 3.108 2.062 6.849 5.05 11.116 2.987 4.267 5.92 7.143 8.718 8.547 2.594 1.302 4.947 1.232 6.999-.204zm-7.325-12.865a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm6 0a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm6-3a1.5 1.5 0 110 3 1.5 1.5 0 010-3z"></path></defs><use fill="currentColor" xlink:href="#mbIconCall" fill-rule="evenodd" transform="translate(1)"></use></svg>
              <span><?php echo substr($mobile, 0, strlen($mobile) - 4) . 'xxxx'; ?></span>
            </a>
          <?php } ?>

          <?php if(gam_chat_button(osc_user_id())) { echo gam_chat_button(osc_user_id()); } ?>
        </div>
      </div>




      <?php if($user['b_company'] == 1) { ?>
        <div class="about-block mbBr2Top">
          <strong class="name"><?php echo sprintf(__('%s profile', 'gamma'), osc_user_name()); ?></strong>
          <span class="about"><?php echo osc_user_info(); ?></span>

          <?php
            // GET REGISTRATION DATE AND TYPE
            $reg_type = '';
            $reg_has_date = false;

            if($user['dt_reg_date'] <> '') { 
              $reg_type = sprintf(__('Posting for %s', 'gamma'), gam_smart_date2($user['dt_reg_date']));
              $reg_has_date = true;
            } else { 
              $reg_type = __('Registered user', 'gamma');
            }
          ?>

          <span class="posting"><?php echo $reg_type; ?></span>


          <div class="links">
            <a href="<?php echo osc_user_public_profile_url(osc_user_id()); ?>">
              <svg viewBox="0 0 32 32" width="14" height="14" class="Store__StyledIconHome-sc-1u82z0t-0 cSgFnw"><defs><path id="mbIconHome" d="M26.05 27.328a.862.862 0 01-.86.861h-4.982V17.41h-9v10.78H6.227a.863.863 0 01-.862-.862V13.125L15.634 2.82 26.05 13.082v14.246zm-12.842.861h5V19.41h-5v8.78zM31.41 15.552L15.62 0 0 15.676l1.416 1.412 1.949-1.956v12.196a2.865 2.865 0 002.862 2.861H25.19a2.864 2.864 0 002.86-2.86V15.051l1.956 1.925 1.404-1.425z"></path></defs><use fill="currentColor" xlink:href="#mbIconHome" fill-rule="evenodd" transform="translate(0 1)"></use></svg>
              <span><?php _e('Public profile', 'gamma'); ?></span>
            </a>

            <a href="<?php echo osc_search_url(array('page' => 'search', 'userId' => osc_user_id())); ?>">
              <svg viewBox="0 0 32 32" width="14" height="14"><defs><path id="mbIconSearch" d="M12.618 23.318c-6.9 0-10.7-3.8-10.7-10.7 0-6.9 3.8-10.7 10.7-10.7 6.9 0 10.7 3.8 10.7 10.7 0 3.458-.923 6.134-2.745 7.955-1.821 1.822-4.497 2.745-7.955 2.745zm17.491 5.726l-7.677-7.678c1.854-2.155 2.804-5.087 2.804-8.748C25.236 4.6 20.636 0 12.618 0S0 4.6 0 12.618c0 8.019 4.6 12.618 12.618 12.618 3.485 0 6.317-.85 8.44-2.531l7.696 7.695 1.355-1.356z"></path></defs><use fill="currentColor" xlink:href="#mbIconSearch" fill-rule="evenodd"></use></svg>
              <span><?php _e('All seller listings', 'gamma'); ?></span>
            </a>

            <?php if (trim(osc_user_website()) != '') { ?>
              <a href="<?php echo osc_user_website(); ?>">
                <svg viewBox="0 0 32 32" width="14" height="14"><defs><path id="mbIconExternal" d="M21.77 4.424l5.277-1.414-1.414 5.278-3.863-3.864zM29.874.18l-3.207 11.97-3.703-3.705-9.76 9.761-1.414-1.414 9.76-9.761-3.644-3.644L29.874.18zM22 24.323V14h2v10.324A5.682 5.682 0 0118.324 30H5.676A5.682 5.682 0 010 24.323V11.675A5.682 5.682 0 015.676 6H16v2H5.676A3.68 3.68 0 002 11.675v12.648A3.68 3.68 0 005.676 28h12.648A3.68 3.68 0 0022 24.323z"></path></defs><use fill="currentColor" xlink:href="#mbIconExternal" fill-rule="evenodd" transform="translate(1 1)"></use></svg>
                <span><?php echo osc_user_website(); ?></span>
              </a>
            <?php } ?>
          </div>
        </div>
      <?php } ?>



      <div class="data">
        <div class="item-share">
          <?php osc_reset_resources(); ?>
          <a class="facebook" title="<?php echo osc_esc_html(__('Share on Facebook', 'gamma')); ?>" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo osc_user_public_profile_url(osc_user_id()); ?>"><i class="fa fa-facebook"></i></a> 
          <a class="twitter" title="<?php echo osc_esc_html(__('Share on Twitter', 'gamma')); ?>" target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo urlencode(meta_title()); ?>&url=<?php echo urlencode(osc_user_public_profile_url(osc_user_id())); ?>"><i class="fa fa-twitter"></i></a> 
          <a class="pinterest" title="<?php echo osc_esc_html(__('Share on Pinterest', 'gamma')); ?>" target="_blank" href="https://pinterest.com/pin/create/button/?url=<?php echo osc_user_public_profile_url(osc_user_id()); ?>&media=<?php echo osc_resource_url(); ?>&description=<?php echo htmlspecialchars(meta_title()); ?>"><i class="fa fa-pinterest"></i></a> 
        </div>
      </div>

      <?php echo gam_banner('public_profile_sidebar'); ?>
    </div>



    <!-- LISTINGS OF SELLER -->
    <div id="public-items" class="products grid">
      <h1><?php _e('Latest items of seller', 'gamma'); ?></h1>

      <?php if(osc_count_items() > 0) { ?>
        <div class="block">
          <div class="wrap">
            <?php $c = 1; ?>
            <?php while( osc_has_items() ) { ?>
              <?php gam_draw_item($c); ?>
        
              <?php $c++; ?>
            <?php } ?>
          </div>
        </div>
      <?php } else { ?>
        <div class="ua-items-empty"><img src="<?php echo osc_current_web_theme_url('images/ua-empty.jpg'); ?>"/> <span><?php _e('This seller has no active listings', 'gamma'); ?></span></div>
      <?php } ?>

      <?php echo gam_banner('public_profile_bottom'); ?>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function(){

      // SHOW PHONE NUMBER
      $('body').on('click', '.mobile', function(e) {
        if($(this).attr('href') == '#') {
          e.preventDefault()

          var phoneNumber = $(this).attr('data-phone');
          $(this).text(phoneNumber);
          $(this).attr('href', 'tel:' + phoneNumber);
          $(this).attr('title', '<?php echo osc_esc_js(__('Click to call', 'gamma')); ?>');
        }        
      });


    });
  </script>


  <?php osc_current_web_theme_path('footer.php') ; ?>
</body>
</html>