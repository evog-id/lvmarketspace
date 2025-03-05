<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo gam_language_dir(); ?>" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
  <?php osc_current_web_theme_path('head.php'); ?>
  <link rel="stylesheet" media="print" href="<?php echo osc_current_web_theme_url('css/print.css?v=' . date('YmdHis')); ?>">
  <?php if(function_exists('osp_product_to_cart_link')) { echo osp_product_to_cart_link(); } ?>
  <?php
    $itemviewer = (Params::getParam('itemviewer') == 1 ? 1 : 0);
    $item_extra = gam_item_extra(osc_item_id());

    $location_array = array(osc_item_city(), osc_item_region(), osc_item_country_code());
    $location_array = array_filter($location_array);
    $location = implode(', ', $location_array);

    $location2_array = array(osc_item_city(), osc_item_region(), osc_item_country_code(), osc_item_address(), osc_item_zip());
    $location2_array = array_filter($location_array);
    $location2 = implode(', ', $location_array);

    if(osc_item_user_id() <> 0) {
      $item_user = User::newInstance()->findByPrimaryKey(osc_item_user_id());
      View::newInstance()->_exportVariableToView('user', $item_user);
    } else {
      $item_user = false;
    }

    $user_location_array = array(osc_user_city(), osc_user_region(), osc_user_country(), (osc_user_address() <> '' ? '<br/>' . osc_user_address() : ''));
    $user_location_array = array_filter($user_location_array);
    $user_location = implode(', ', $user_location_array);


    $mobile_found = true;
    $mobile = $item_extra['s_phone'];

    if($mobile == '' && function_exists('bo_mgr_show_mobile')) { $mobile = bo_mgr_show_mobile(); }
    if($mobile == '' && osc_item_user_id() <> 0) { $mobile = $item_user['s_phone_mobile']; }      
    if($mobile == '' && osc_item_user_id() <> 0) { $mobile = $item_user['s_phone_land']; } 
   
    $mobile_login_required = false;

    if(osc_item_show_phone() == 0) {
      $mobile = __('No phone number', 'gamma');
      $mobile_found = false;
    } else if(osc_get_preference('reg_user_can_see_phone', 'osclass') == 1 && !osc_is_web_user_logged_in() && strlen(trim($mobile)) >= 4) {
      $mobile = __('Login to see phone number', 'gamma');
      $mobile_found = true;
      $mobile_login_required = true;
    } else if(trim($mobile) == '' || strlen(trim($mobile)) < 4) { 
      $mobile = __('No phone number', 'gamma');
      $mobile_found = false;
    }  



    $has_cf = false;
    while(osc_has_item_meta()) {
      if(osc_item_meta_value() != '') {
        $has_cf = true;
        break;
      }
    }

    View::newInstance()->_reset('metafields');
  ?>


  <!-- FACEBOOK OPEN GRAPH TAGS -->
  <?php osc_reset_resources(); ?>
  <?php osc_get_item_resources(); ?>
  <?php $resource_url = osc_resource_url(); ?>

  <meta property="og:title" content="<?php echo osc_esc_html(osc_item_title()); ?>" />
  <?php if(osc_count_item_resources() > 0) { ?><meta property="og:image" content="<?php echo $resource_url; ?>" /><?php } ?>
  <meta property="og:site_name" content="<?php echo osc_esc_html(osc_page_title()); ?>"/>
  <meta property="og:url" content="<?php echo osc_item_url(); ?>" />
  <meta property="og:description" content="<?php echo osc_esc_html(osc_highlight(osc_item_description(), 500)); ?>" />
  <meta property="og:type" content="article" />
  <meta property="og:locale" content="<?php echo osc_current_user_locale(); ?>" />
  <meta property="product:retailer_item_id" content="<?php echo osc_item_id(); ?>" /> 
  <meta property="product:price:amount" content="<?php echo strip_tags(osc_item_formated_price()); ?>" />
  <?php if(osc_item_price() <> '' and osc_item_price() <> 0) { ?><meta property="product:price:currency" content="<?php echo osc_item_currency(); ?>" /><?php } ?>


  <!-- GOOGLE RICH SNIPPETS -->
  <span itemscope itemtype="http://schema.org/Product">
    <meta itemprop="name" content="<?php echo osc_esc_html(osc_item_title()); ?>" />
    <meta itemprop="description" content="<?php echo osc_esc_html(osc_highlight(osc_item_description(), 500)); ?>" />
    <?php if(osc_count_item_resources() > 0) { ?><meta itemprop="image" content="<?php echo $resource_url; ?>" /><?php } ?>
  </span>
</head>

<body id="body-item" class="page-body<?php if($itemviewer == 1) { ?> itemviewer<?php } ?><?php if(gam_device() <> '') { echo ' dvc-' . gam_device(); } ?>">
  <?php osc_current_web_theme_path('header.php') ; ?>

  <div id="listing" class="inside">
    <?php echo gam_banner('item_top'); ?>


    <!-- LISTING BODY - LEFT SIDE -->
    <div class="item">

      <?php if(osc_item_is_expired()) { ?>
        <div class="sold-reserved expired">
          <span><?php _e('This listing is expired!', 'gamma'); ?></span>
        </div>
      <?php } ?>

      <?php if($item_extra['i_sold'] > 0) { ?>
        <div class="sold-reserved<?php echo ($item_extra['i_sold'] == 1 ? ' sold' : ' reserved'); ?>">
          <span><?php echo ($item_extra['i_sold'] == 1 ? __('Seller has marked this listing as <strong>SOLD</strong>', 'gamma') : __('Seller has marked this listing as <strong>RESERVED</strong>', 'gamma')); ?></span>
        </div>
      <?php } ?>


      <!-- IMAGE BOX -->
      <div class="main-data">
        <?php if(osc_images_enabled_at_items()) { ?> 
          <div id="img" class="img">
            <?php osc_get_item_resources(); ?>
            <?php osc_reset_resources(); ?>

            <?php if(osc_count_item_resources() > 0 ) { ?>
              <div class="swiper-container">
                <div class="swiper-wrapper">
                  <?php for($i = 0;osc_has_item_resources(); $i++) { ?>
                    <li class="swiper-slide">
                      <a href="<?php echo osc_resource_url(); ?>">
                        <img class="<?php echo (gam_is_lazy() ? 'lazy' : ''); ?>" src="<?php echo (gam_is_lazy() ? gam_get_noimage('large') : osc_resource_url()); ?>" data-src="<?php echo osc_resource_url(); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?> - <?php echo $i+1;?>/<?php echo osc_count_item_resources(); ?>"/>
                      </a>
                    </li>
                  <?php } ?>
                </div>
                
                <div class="swiper-pg"></div>

                <div class="swiper-button swiper-next"><i class="fas fa-angle-right"></i></div>
                <div class="swiper-button swiper-prev"><i class="fas fa-angle-left"></i></div>
              </div>
                
                
              <ul class="list bx-slider">
                <?php for($i = 0;osc_has_item_resources(); $i++) { ?>
                  <li>
                    <a href="<?php echo osc_resource_url(); ?>" data-fancybox="gallery">
                      <img src="<?php echo osc_resource_url(); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?> - <?php echo $i+1;?>"/>
                    </a>
                  </li>
                <?php } ?>
              </ul>
            <?php } else { ?>

              <div class="image-empty"><?php _e('Seller has not uploaded any pictures', 'gamma'); ?></div>

            <?php } ?>
          </div>
        <?php } ?>
      </div>



      <!-- HEADER & BASIC DATA -->
      <div class="pre-basic">
        <?php if(function_exists('fi_save_favorite')) { echo fi_save_favorite(); } ?>

        <span class="date">
          <svg viewBox="0 0 32 32" color="#696766" height="15" width="15"><defs><path id="mbIconClock" d="M16 0c10.168 0 16 5.832 16 16s-5.832 16-16 16S0 26.168 0 16 5.832 0 16 0zm0 30c9.028 0 14-4.972 14-14 0-9.028-4.972-14-14-14C6.972 2 2 6.972 2 16c0 9.028 4.972 14 14 14zm-1-15V5h2v12H8.222v-2H15z"></path></defs><use fill="currentColor" xlink:href="#mbIconClock" fill-rule="evenodd"></use></svg>
          <span><?php echo sprintf(__('Posted: %s', 'gamma'), gam_smart_date(osc_item_pub_date())); ?></span>
        </span>

        <?php if($location2 <> '') { ?>
          <a target="_blank"  class="location" href="https://www.google.com/maps?daddr=<?php echo urlencode($location); ?>">
            <svg viewBox="0 0 32 32" color="#696766" height="15" width="15"><defs><path id="mbIconMarker" d="M13.457 0c7.918 0 12.457 4.541 12.457 12.457C25.915 19.928 17.53 32 13.457 32 9.168 32 1 20.317 1 12.457 1 4.541 5.541 0 13.457 0zm0 30c2.44 0 10.457-10.658 10.457-17.543C23.915 5.616 20.299 2 13.457 2 6.617 2 3 5.616 3 12.457 3 19.649 10.802 30 13.457 30zm0-13.309a4.38 4.38 0 01-4.375-4.375 4.38 4.38 0 014.375-4.376 4.38 4.38 0 014.375 4.376 4.38 4.38 0 01-4.375 4.375zm0-10.75a6.382 6.382 0 00-6.375 6.375 6.382 6.382 0 006.375 6.375 6.382 6.382 0 006.375-6.375 6.382 6.382 0 00-6.375-6.376"></path></defs><use fill="currentColor" xlink:href="#mbIconMarker" fill-rule="evenodd" transform="translate(3)"></use></svg>
            <span><?php echo $location2; ?></span>
          </a>
        <?php } else { ?>
          <span class="location">
            <svg viewBox="0 0 32 32" color="#696766" height="15" width="15"><defs><path id="mbIconMarker" d="M13.457 0c7.918 0 12.457 4.541 12.457 12.457C25.915 19.928 17.53 32 13.457 32 9.168 32 1 20.317 1 12.457 1 4.541 5.541 0 13.457 0zm0 30c2.44 0 10.457-10.658 10.457-17.543C23.915 5.616 20.299 2 13.457 2 6.617 2 3 5.616 3 12.457 3 19.649 10.802 30 13.457 30zm0-13.309a4.38 4.38 0 01-4.375-4.375 4.38 4.38 0 014.375-4.376 4.38 4.38 0 014.375 4.376 4.38 4.38 0 01-4.375 4.375zm0-10.75a6.382 6.382 0 00-6.375 6.375 6.382 6.382 0 006.375 6.375 6.382 6.382 0 006.375-6.375 6.382 6.382 0 00-6.375-6.376"></path></defs><use fill="currentColor" xlink:href="#mbIconMarker" fill-rule="evenodd" transform="translate(3)"></use></svg>
            <span><?php _e('Unkown location', 'gamma'); ?></span>
          </span>
        <?php } ?>
      </div>


      <div class="basic">
        <h1><?php echo osc_item_title(); ?></h1>

        <?php if(gam_check_category_price(osc_item_category_id())) { ?>
          <span class="price mbCl3 p-<?php echo osc_item_price(); ?>x"><?php echo osc_item_formated_price(); ?></span>
        <?php } ?>

        <?php if(function_exists('mo_ajax_url')) { ?>
          <?php
            $make_offer_enabled = false;
            $history = osc_get_preference('history', 'plugin-make_offer');
            $category = osc_get_preference('category', 'plugin-make_offer');
            $category_array = explode(',', $category);

            $root = Category::newInstance()->findRootCategory(osc_item_category_id());
            $root_id = $root['pk_i_id'];

            if((in_array($root_id, $category_array) || trim($category) == '') && (osc_item_price() > 0 || osc_item_price() !== 0)) {
              $setting = ModelMO::newInstance()->getOfferSettingByItemId(osc_item_id());

              if((isset($setting['i_enabled']) && $setting['i_enabled'] == 1) || ((!isset($setting['i_enabled']) || $setting['i_enabled'] == '') && $history == 1)) {
                $make_offer_enabled = true;
              }
            }
          ?>
          
          <?php if($make_offer_enabled) { ?>
            <a href="#" id="mk-offer" class="make-offer-link" data-item-id="<?php echo osc_item_id(); ?>" data-item-currency="<?php echo osc_item_currency(); ?>" data-ajax-url="<?php echo mo_ajax_url(); ?>&moAjaxOffer=1&itemId=<?php echo osc_item_id(); ?>"><?php _e('Submit your offer', 'gamma'); ?></a>
          <?php } ?>
        <?php } ?>
      </div>



      <!-- DESCRIPTION -->
      <div class="data">
        <div class="description">
          <h2>
            <?php _e('Description', 'gamma'); ?>
            <span class="item-views"><?php echo sprintf(__('%s views', 'gamma'), osc_item_views()); ?></span>  
          </h2>

          <div class="text">
            <?php if(function_exists('show_qrcode')) { ?>
              <div class="qr-code noselect">
                <?php show_qrcode(); ?>
              </div>
            <?php } ?>

            <?php echo osc_item_description(); ?>
          </div>

        </div>


        <!-- CUSTOM FIELDS -->
        <?php if($has_cf || $item_extra['i_transaction'] <> '' || $item_extra['i_condition'] <> '') { ?>
          <div class="custom-fields">
            <h2><?php _e('Attributes', 'gamma'); ?></h2>

            <div class="list">
              <?php if(!in_array(osc_item_category_id(), gam_extra_fields_hide())) { ?>
                <?php if(gam_get_simple_name($item_extra['i_condition'], 'condition') <> '') { ?>
                  <div class="field name item-condition value<?php echo $item_extra['i_transaction']; ?>">
                    <span class="name"><?php echo __('Condition', 'gamma'); ?>:</span> 
                    <span class="value"><?php echo gam_get_simple_name($item_extra['i_condition'], 'condition'); ?></span>
                  </div>
                <?php } ?>

                <?php if(gam_get_simple_name($item_extra['i_transaction'], 'transaction') <> '') { ?>
                  <div class="field name item-transaction value<?php echo $item_extra['i_transaction']; ?>">
                    <span class="name"><?php echo __('Transaction', 'gamma'); ?>:</span> 
                    <span class="value"><?php echo gam_get_simple_name($item_extra['i_transaction'], 'transaction'); ?></span>
                  </div>
                <?php } ?>
              <?php } ?>
              
              
              <?php while(osc_has_item_meta()) { ?>
                <?php if(osc_item_meta_value() != '') { ?>
                  <div class="field name<?php echo osc_item_meta_name(); ?> value<?php echo osc_esc_html(osc_item_meta_value()); ?>">
                    <span class="name"><?php echo osc_item_meta_name(); ?><?php if(substr(trim(osc_item_meta_name()), -1) != ':') { echo ':'; } ?></span> 
                    <span class="value"><?php echo osc_item_meta_value(); ?></span>
                  </div>
                <?php } ?>
              <?php } ?>
            </div>

          </div>
        <?php } ?>

   
        <!-- PLUGIN HOOK -->
        <div id="plugin-hook">
          <?php osc_run_hook('item_detail', osc_item()); ?>  
        </div>
      </div>


      <div class="sold-by">
        <div class="sleft">
          <span class="titl"><?php _e('Seller', 'gamma'); ?>: <strong class="name"><?php echo osc_item_contact_name(); ?></strong></span>

          <?php if(function_exists('ur_show_rating_link') && osc_item_user_id() > 0) { ?>
            <span class="ur-fdb">
              <span class="strs"><?php echo ur_show_rating_stars(); ?></span>
              <span class="lnk"><?php echo ur_add_rating_link(); ?></span>
            </span>
          <?php } ?>

          <div class="user-img">
            <img src="<?php echo gam_profile_picture(osc_item_user_id(), 'medium'); ?>" alt="<?php echo osc_item_contact_name(); ?>" />
          </div>

          <?php if(osc_item_user_id() > 0) { ?>
            <a href="<?php echo osc_user_public_profile_url(osc_item_user_id()); ?>">
              <svg viewBox="0 0 32 32" width="14" height="14"><defs><path id="mbIconHome" d="M26.05 27.328a.862.862 0 01-.86.861h-4.982V17.41h-9v10.78H6.227a.863.863 0 01-.862-.862V13.125L15.634 2.82 26.05 13.082v14.246zm-12.842.861h5V19.41h-5v8.78zM31.41 15.552L15.62 0 0 15.676l1.416 1.412 1.949-1.956v12.196a2.865 2.865 0 002.862 2.861H25.19a2.864 2.864 0 002.86-2.86V15.051l1.956 1.925 1.404-1.425z"></path></defs><use fill="currentColor" xlink:href="#mbIconHome" fill-rule="evenodd" transform="translate(0 1)"></use></svg>
              <span><?php _e('Public profile', 'gamma'); ?></span>
            </a>

            <a href="<?php echo osc_search_url(array('page' => 'search', 'userId' => osc_item_user_id())); ?>">
              <svg viewBox="0 0 32 32" width="14" height="14" class="mbCl"><defs><path id="mbIconSearch" d="M12.618 23.318c-6.9 0-10.7-3.8-10.7-10.7 0-6.9 3.8-10.7 10.7-10.7 6.9 0 10.7 3.8 10.7 10.7 0 3.458-.923 6.134-2.745 7.955-1.821 1.822-4.497 2.745-7.955 2.745zm17.491 5.726l-7.677-7.678c1.854-2.155 2.804-5.087 2.804-8.748C25.236 4.6 20.636 0 12.618 0S0 4.6 0 12.618c0 8.019 4.6 12.618 12.618 12.618 3.485 0 6.317-.85 8.44-2.531l7.696 7.695 1.355-1.356z"></path></defs><use fill="currentColor" xlink:href="#mbIconSearch" fill-rule="evenodd"></use></svg>
              <span><?php _e('All seller listings', 'gamma'); ?></span>
            </a>
          <?php } ?>

        </div>

        <div class="sright">
          <a href="<?php echo gam_fancy_url('contact'); ?>" class="open-form contact btn mbBg2" data-type="contact">
            <svg viewBox="0 0 32 32" color="#fff" width="24" height="24"><defs><path id="mbIconEmail" d="M26.324 0A5.682 5.682 0 0132 5.676v12.648A5.682 5.682 0 0126.324 24H5.676A5.682 5.682 0 010 18.324V5.676A5.682 5.682 0 015.676 0h20.648zM30 18.324V5.676A3.68 3.68 0 0026.324 2H5.676A3.68 3.68 0 002 5.676v12.648A3.68 3.68 0 005.676 22h20.648A3.68 3.68 0 0030 18.324zm-14-4.616l10.367-8.482 1.266 1.548L16 16.292 4.367 6.774l1.266-1.548L16 13.708z"></path></defs><use fill="currentColor" xlink:href="#mbIconEmail" fill-rule="evenodd" transform="translate(0 4)"></use></svg>
            <span><?php _e('Contact seller', 'gamma'); ?></span>
          </a>

          <?php if($mobile_found) { ?>
            <?php if($mobile_login_required) { ?>
              <a href="<?php echo osc_user_login_url(); ?>" class="mobile btn login-required" data-phone="" title="<?php echo osc_esc_html(__('Login to show number', 'gamma')); ?>">
                <svg viewBox="0 0 32 32" width="24" height="24"><defs><path id="mbIconCall" d="M15.466 21.406l5.32-1.401 5.64 8.054-.402.573a8.281 8.281 0 01-2.04 2.02c-1.422.995-2.976 1.494-4.61 1.494-1.428 0-2.916-.38-4.433-1.142-3.098-1.554-6.28-4.645-9.46-9.187C2.302 17.275.487 13.227.085 9.786-.34 6.17.845 3.273 3.506 1.409A8.287 8.287 0 016.103.183L6.78 0l5.64 8.055-3.136 4.52 6.184 8.83zm7.37 7.607a6.501 6.501 0 001.123-.991l-4.011-5.728-5.32 1.4L6.845 12.58l3.136-4.52L5.97 2.332a6.475 6.475 0 00-1.317.716c-2.05 1.436-2.92 3.625-2.584 6.506.363 3.108 2.062 6.849 5.05 11.116 2.987 4.267 5.92 7.143 8.718 8.547 2.594 1.302 4.947 1.232 6.999-.204zm-7.325-12.865a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm6 0a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm6-3a1.5 1.5 0 110 3 1.5 1.5 0 010-3z"></path></defs><use fill="currentColor" xlink:href="#mbIconCall" fill-rule="evenodd" transform="translate(1)"></use></svg>
                <span><?php echo osc_esc_html(__('Login to show number', 'gamma')); ?></span>
              </a>
            <?php } else { ?>
              <a href="#" class="mobile btn" data-phone="<?php echo $mobile; ?>" title="<?php echo osc_esc_html(__('Click to show number', 'gamma')); ?>">
                <svg viewBox="0 0 32 32" width="24" height="24"><defs><path id="mbIconCall" d="M15.466 21.406l5.32-1.401 5.64 8.054-.402.573a8.281 8.281 0 01-2.04 2.02c-1.422.995-2.976 1.494-4.61 1.494-1.428 0-2.916-.38-4.433-1.142-3.098-1.554-6.28-4.645-9.46-9.187C2.302 17.275.487 13.227.085 9.786-.34 6.17.845 3.273 3.506 1.409A8.287 8.287 0 016.103.183L6.78 0l5.64 8.055-3.136 4.52 6.184 8.83zm7.37 7.607a6.501 6.501 0 001.123-.991l-4.011-5.728-5.32 1.4L6.845 12.58l3.136-4.52L5.97 2.332a6.475 6.475 0 00-1.317.716c-2.05 1.436-2.92 3.625-2.584 6.506.363 3.108 2.062 6.849 5.05 11.116 2.987 4.267 5.92 7.143 8.718 8.547 2.594 1.302 4.947 1.232 6.999-.204zm-7.325-12.865a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm6 0a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm6-3a1.5 1.5 0 110 3 1.5 1.5 0 010-3z"></path></defs><use fill="currentColor" xlink:href="#mbIconCall" fill-rule="evenodd" transform="translate(1)"></use></svg>
                <span><?php echo substr($mobile, 0, strlen($mobile) - 4) . 'xxxx'; ?></span>
              </a>
            <?php } ?>
          <?php } ?>

          <?php if(osc_item_show_email()) { ?>
            <a href="#" class="email btn" data-email="<?php echo osc_item_contact_email(); ?>" title="<?php echo osc_esc_html(__('Click to show email', 'gamma')); ?>">
              <svg id="Capa_1"  height="24" width="24" viewBox="0 0 479.058 479.058" xmlns="http://www.w3.org/2000/svg"><path d="m239.529 0c-132.074 0-239.529 107.455-239.529 239.529s107.455 239.529 239.529 239.529c45.379 0 89.56-12.763 127.761-36.885l-15.994-25.321c-33.406 21.111-72.06 32.266-111.767 32.266-115.568 0-209.588-94.019-209.588-209.588s94.019-209.589 209.588-209.589 209.588 94.019 209.588 209.588v14.971c0 24.766-20.146 44.912-44.912 44.912s-44.912-20.146-44.912-44.912v-104.794h-29.941v11.449c-21.97-25.15-53.884-41.39-89.823-41.39-66.037 0-119.764 53.727-119.764 119.764s53.727 119.764 119.764 119.764c44.742 0 83.367-24.95 103.926-61.395 13.593 18.965 35.69 31.454 60.75 31.454 41.271 0 74.853-33.581 74.853-74.853v-14.971c0-132.073-107.455-239.528-239.529-239.528zm0 329.352c-49.532 0-89.823-40.292-89.823-89.823s40.292-89.823 89.823-89.823 89.823 40.292 89.823 89.823-40.292 89.823-89.823 89.823z"/></svg>
              <span><?php echo gam_mask_email(osc_item_contact_email()); ?></span>
            </a>
          <?php } ?>

          <?php if(gam_chat_button(osc_item_user_id())) { echo gam_chat_button(osc_item_user_id()); } ?>
        </div>
      </div>

      <div class="safe-block">
        <strong><?php _e('Always stay safe!', 'gamma'); ?></strong>
        <span class="txt"><?php _e('Never pay down a deposit in a bank account until you have met the seller, seen signed a purchase agreement. NO serious private advertisers ask for a down payment before you meet. Receiving an email with an in-scanned ID does not mean that you have identified the sender. You do this on the spot, when you sign a purchase agreement.', 'gamma'); ?></span>
        <svg xmlns="http://www.w3.org/2000/svg" height="48" version="1.1" viewBox="-38 0 512 512.00142" width="48"> <g id="surface1"> <path d="M 217.996094 158.457031 C 164.203125 158.457031 120.441406 202.21875 120.441406 256.007812 C 120.441406 309.800781 164.203125 353.5625 217.996094 353.5625 C 271.785156 353.5625 315.546875 309.800781 315.546875 256.007812 C 315.546875 202.21875 271.785156 158.457031 217.996094 158.457031 Z M 275.914062 237.636719 L 206.027344 307.523438 C 203.09375 310.457031 199.246094 311.925781 195.402344 311.925781 C 191.558594 311.925781 187.714844 310.460938 184.78125 307.523438 L 158.074219 280.816406 C 152.207031 274.953125 152.207031 265.441406 158.074219 259.574219 C 163.9375 253.707031 173.449219 253.707031 179.316406 259.574219 L 195.402344 275.660156 L 254.671875 216.394531 C 260.535156 210.527344 270.046875 210.527344 275.914062 216.394531 C 281.78125 222.257812 281.78125 231.769531 275.914062 237.636719 Z M 275.914062 237.636719 " style=" stroke:none;fill-rule:nonzero;fill:<?php echo gam_param('color'); ?>;fill-opacity:1;" /> <path d="M 435.488281 138.917969 L 435.472656 138.519531 C 435.25 133.601562 435.101562 128.398438 435.011719 122.609375 C 434.59375 94.378906 412.152344 71.027344 383.917969 69.449219 C 325.050781 66.164062 279.511719 46.96875 240.601562 9.042969 L 240.269531 8.726562 C 227.578125 -2.910156 208.433594 -2.910156 195.738281 8.726562 L 195.40625 9.042969 C 156.496094 46.96875 110.957031 66.164062 52.089844 69.453125 C 23.859375 71.027344 1.414062 94.378906 0.996094 122.613281 C 0.910156 128.363281 0.757812 133.566406 0.535156 138.519531 L 0.511719 139.445312 C -0.632812 199.472656 -2.054688 274.179688 22.9375 341.988281 C 36.679688 379.277344 57.492188 411.691406 84.792969 438.335938 C 115.886719 468.679688 156.613281 492.769531 205.839844 509.933594 C 207.441406 510.492188 209.105469 510.945312 210.800781 511.285156 C 213.191406 511.761719 215.597656 512 218.003906 512 C 220.410156 512 222.820312 511.761719 225.207031 511.285156 C 226.902344 510.945312 228.578125 510.488281 230.1875 509.925781 C 279.355469 492.730469 320.039062 468.628906 351.105469 438.289062 C 378.394531 411.636719 399.207031 379.214844 412.960938 341.917969 C 438.046875 273.90625 436.628906 199.058594 435.488281 138.917969 Z M 217.996094 383.605469 C 147.636719 383.605469 90.398438 326.367188 90.398438 256.007812 C 90.398438 185.648438 147.636719 128.410156 217.996094 128.410156 C 288.351562 128.410156 345.59375 185.648438 345.59375 256.007812 C 345.59375 326.367188 288.351562 383.605469 217.996094 383.605469 Z M 217.996094 383.605469 " style=" stroke:none;fill-rule:nonzero;fill:<?php echo gam_param('color'); ?>;fill-opacity:1;" /> </g> </svg>
      </div>

      <div class="itm-links">
        <a href="#" class="print"><?php _e('Print', 'gamma'); ?></a>
        <a class="friend open-form" href="<?php echo gam_fancy_url('friend'); ?>" data-type="friend"><?php _e('Recommend', 'gamma'); ?></a>

        <div class="item-share">
          <a class="facebook" title="<?php echo osc_esc_html(__('Share on Facebook', 'gamma')); ?>" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(osc_item_url()); ?>"><i class="fab fa-facebook"></i></a> 
          <a class="twitter" title="<?php echo osc_esc_html(__('Share on Twitter', 'gamma')); ?>" target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo urlencode(osc_item_title()); ?>&url=<?php echo urlencode(osc_item_url()); ?>"><i class="fab fa-twitter"></i></a> 
          <a class="pinterest" title="<?php echo osc_esc_html(__('Share on Pinterest', 'gamma')); ?>" target="_blank" href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode(osc_item_url()); ?>&media=<?php echo urlencode($resource_url); ?>&description=<?php echo htmlspecialchars(osc_item_title()); ?>"><i class="fab fa-pinterest"></i></a> 
        </div>
      </div>


      <?php echo gam_banner('item_description'); ?>


      <?php if($item_user !== false && @$item_user['b_company'] == 1) { ?>
        <div class="about-block mbBr2Top">
          <strong class="name"><?php echo osc_item_contact_name(); ?></strong>
          <span class="about"><?php echo osc_user_info(); ?></span>

          <?php
            // GET REGISTRATION DATE AND TYPE
            $reg_type = '';
            $reg_has_date = false;

            if($item_user && $item_user['dt_reg_date'] <> '') { 
              $reg_type = sprintf(__('Posting for %s', 'gamma'), gam_smart_date2($item_user['dt_reg_date']));
              $reg_has_date = true;
            } else if ($item_user) { 
              $reg_type = __('Registered user', 'gamma');
            } else {
              $reg_type = __('Unregistered user', 'gamma');
            }
          ?>

          <span class="posting"><?php echo $reg_type; ?></span>


          <div class="links">
            <a href="<?php echo osc_user_public_profile_url(osc_item_user_id()); ?>">
              <svg viewBox="0 0 32 32" width="14" height="14"><defs><path id="mbIconHome" d="M26.05 27.328a.862.862 0 01-.86.861h-4.982V17.41h-9v10.78H6.227a.863.863 0 01-.862-.862V13.125L15.634 2.82 26.05 13.082v14.246zm-12.842.861h5V19.41h-5v8.78zM31.41 15.552L15.62 0 0 15.676l1.416 1.412 1.949-1.956v12.196a2.865 2.865 0 002.862 2.861H25.19a2.864 2.864 0 002.86-2.86V15.051l1.956 1.925 1.404-1.425z"></path></defs><use fill="currentColor" xlink:href="#mbIconHome" fill-rule="evenodd" transform="translate(0 1)"></use></svg>
              <span><?php _e('Public profile', 'gamma'); ?></span>
            </a>

            <a href="<?php echo osc_search_url(array('page' => 'search', 'userId' => osc_item_user_id())); ?>">
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



      <div class="ftr-block">
        <?php if(osc_is_web_user_logged_in() && osc_item_user_id() == osc_logged_user_id()) { ?>
          <div class="manage">
            <a href="<?php echo osc_item_edit_url(); ?>"><span><?php _e('Edit', 'gamma'); ?></span></a>
            <a href="<?php echo osc_item_delete_url(); ?>"" onclick="return confirm('<?php _e('Are you sure you want to delete this listing? This action cannot be undone.', 'gamma'); ?>?')"><span><?php _e('Remove', 'gamma'); ?></span></a>

            <?php if(osc_item_is_inactive()) { ?>
              <?php if((function_exists('iv_add_item') && osc_get_preference('enable','plugin-item_validation') <> 1) || !function_exists('iv_add_item')) { ?>
                <a class="activate" target="_blank" href="<?php echo osc_item_activate_url(); ?>"><?php _e('Validate', 'gamma'); ?></a>
              <?php } ?>
            <?php } ?>
          </div>
        <?php } ?>

        <div id="report" class="noselect">
          <a href="#" onclick="return false;">
            <i class="fas fa-exclamation-triangle"></i>
            <?php _e('Report listing', 'gamma'); ?>
          </a>

          <div class="cont-wrap">
            <div class="cont">
              <a id="item_spam" class="reports" href="<?php echo osc_item_link_spam() ; ?>" rel="nofollow"><?php _e('Spam', 'gamma') ; ?></a>
              <a id="item_bad_category" class="reports" href="<?php echo osc_item_link_bad_category() ; ?>" rel="nofollow"><?php _e('Misclassified', 'gamma') ; ?></a>
              <a id="item_repeated" class="reports" href="<?php echo osc_item_link_repeated() ; ?>" rel="nofollow"><?php _e('Duplicated', 'gamma') ; ?></a>
              <a id="item_expired" class="reports" href="<?php echo osc_item_link_expired() ; ?>" rel="nofollow"><?php _e('Expired', 'gamma') ; ?></a>
              <a id="item_offensive" class="reports" href="<?php echo osc_item_link_offensive() ; ?>" rel="nofollow"><?php _e('Offensive', 'gamma') ; ?></a>
            </div>
          </div>
        </div>


      </div>
    </div>



    <!-- SIDEBAR - RIGHT -->
    <div class="side">

      <?php if(function_exists('sp_buttons')) { ?>
        <div class="sms-payments">
          <?php echo sp_buttons(osc_item_id());?>
        </div>
      <?php } ?>


      <div class="loc-hook">
        <?php osc_run_hook('location'); ?>
      </div>


      <?php echo gam_banner('item_sidebar'); ?>


      <!-- COMMENTS-->
      <?php if( osc_comments_enabled()) { ?>
        <div id="comment" class="mbBr3Top">
          <h2>
            <span><?php _e('Comments', 'gamma'); ?></span>
            <span class="count"><?php echo osc_item_total_comments(); ?></span>

          </h2>

          <div class="wrap">
            <?php if(osc_item_total_comments() > 0) { ?>
              <?php while(osc_has_item_comments()) { ?>
                <div class="comment">
                  <div class="image">
                    <img src="<?php echo gam_profile_picture(osc_comment_user_id(), 'medium'); ?>" />
                  </div>

                  <div class="info">
                    <h3>
                      <span class="title"><?php echo(osc_comment_title() == '' ? __('Comment', 'gamma') : osc_comment_title()); ?> <?php _e('by', 'gamma'); ?> <?php echo (osc_comment_author_name() == '' ? __('Anonymous', 'gamma') : osc_comment_author_name()); ?></span>
                    </h3>

                    <?php if(function_exists('osc_enable_comment_rating') && osc_enable_comment_rating()) { ?>
                      <div class="rating">
                        <?php for($i = 1; $i <= 5; $i++) { ?>
                          <?php
                            $class = '';
                            if(osc_comment_rating() >= $i) {
                              $class = ' fill';
                            }
                          ?>
                          <i class="fa fa-star<?php echo $class; ?>"></i>
                        <?php } ?>

                        <span>(<?php echo sprintf(__('%d of 5', 'gamma'), osc_comment_rating()); ?>)</span>
                      </div>
                    <?php } ?>
                    
                    <div class="body"><?php echo osc_comment_body(); ?></div>
                    <span class="date"><i class="far fa-clock"></i> <?php echo gam_smart_date(osc_comment_pub_date()); ?></span>

                     <?php if(osc_comment_user_id() && (osc_comment_user_id() == osc_logged_user_id())) { ?>
                      <a rel="nofollow" class="remove" href="<?php echo osc_delete_comment_url(); ?>" title="<?php echo osc_esc_html(__('Delete your comment', 'gamma')); ?>">
                        <i class="fas fa-trash"></i>
                      </a>
                    <?php } ?>
                  </div>
                </div>
                
                <?php if(function_exists('osc_enable_comment_reply') && osc_enable_comment_reply()) { ?>
                  <?php osc_get_comment_replies(); ?>
                  <?php if(osc_count_comment_replies() > 0) { ?>
                    <div id="comment-replies">
                      <?php while (osc_has_comment_replies()) { ?>
                        <div class="comment">
                          <div class="image">
                            <img src="<?php echo gam_profile_picture(osc_comment_reply_user_id(), 'medium'); ?>" />
                          </div>

                          <div class="info">
                            <h3>
                              <span class="title"><?php echo(osc_comment_reply_title() == '' ? __('Comment', 'gamma') : osc_comment_reply_title()); ?> <?php _e('by', 'gamma'); ?> <?php echo (osc_comment_reply_author_name() == '' ? __('Anonymous', 'gamma') : osc_comment_reply_author_name()); ?></span>
                            </h3>

                            <?php if(function_exists('osc_enable_comment_rating') && osc_enable_comment_rating()) { ?>
                              <div class="rating">
                                <?php for($i = 1; $i <= 5; $i++) { ?>
                                  <?php
                                    $class = '';
                                    if(osc_comment_reply_rating() >= $i) {
                                      $class = ' fill';
                                    }
                                  ?>
                                  <i class="fa fa-star<?php echo $class; ?>"></i>
                                <?php } ?>

                                <span>(<?php echo sprintf(__('%d of 5', 'gamma'), osc_comment_reply_rating()); ?>)</span>
                              </div>
                            <?php } ?>
                            
                            <div class="body"><?php echo osc_comment_reply_body(); ?></div>
                            <span class="date"><i class="far fa-clock"></i> <?php echo gam_smart_date(osc_comment_reply_pub_date()); ?></span>
         
                            <?php if(osc_comment_reply_user_id() && (osc_comment_reply_user_id() == osc_logged_user_id())) { ?>
                              <a rel="nofollow" class="remove" href="<?php echo osc_delete_comment_url(); ?>" title="<?php echo osc_esc_html(__('Delete your comment', 'gamma')); ?>">
                                <i class="fas fa-trash"></i>
                              </a>
                            <?php } ?>
                          </div>
                        </div>

                      <?php } ?>
                    </div>
                  <?php } ?>
                <?php } ?>
                
                
                <?php if(
                  function_exists('osc_enable_comment_reply')
                  && osc_enable_comment_reply() 
                  && (
                    osc_comment_reply_user_type() == ''
                    || osc_comment_reply_user_type() == 'LOGGED' && osc_is_web_user_logged_in()
                    || osc_comment_reply_user_type() == 'OWNER' && (osc_logged_user_id() == osc_item_user_id() && osc_item_user_id() > 0 || osc_logged_user_email() == osc_item_contact_email())
                    || osc_comment_reply_user_type() == 'ADMIN' && osc_is_admin_user_logged_in()
                  )
                ) { ?>
                  <p class="comment-reply-row">
                    <?php $reply_params = array('replyToCommentId' => osc_comment_id()); ?>
                    <a class="btn btn-secondary comment-reply open-form" href="<?php echo gam_fancy_url('comment', $reply_params); ?>"><?php _e('Reply', 'gamma'); ?></a>
                  </p>
                <?php } ?>
              <?php } ?>

              <span><div class="paginate comment-pagi"><?php echo osc_comments_pagination(); ?></div></span>

            <?php } else { ?>
              <div class="empty-comment"><?php _e('No comments has been added yet', 'gamma'); ?></div>
            <?php } ?>
          </div>

          <?php if((osc_reg_user_post_comments() && osc_is_web_user_logged_in() || !osc_reg_user_post_comments()) && osc_logged_user_id() <> osc_item_user_id()) { ?>
            <div class="button-wrap">
              <a class="open-form new-comment btn mbBg3" href="<?php echo gam_fancy_url('comment'); ?>" data-type="comment"><i class="fa fa-comment-o"></i> <?php _e('Add a new comment', 'gamma'); ?></a>
            </div>
          <?php } ?>
        </div>
      <?php } ?>

      <?php echo gam_banner('item_sidebar_bottom'); ?>

    </div>



    <?php echo gam_banner('item_bottom'); ?>

  </div>

  <?php gam_related_ads(); ?>



  <?php if($mobile_found) { ?>
    <a href="#" class="mbBg2 mobile-item item-phone isMobile <?php if($mobile_login_required) { ?>login-required<?php } ?>">
      <svg viewBox="0 0 32 32" width="24" height="24"><defs><path id="mbIconCall" d="M15.466 21.406l5.32-1.401 5.64 8.054-.402.573a8.281 8.281 0 01-2.04 2.02c-1.422.995-2.976 1.494-4.61 1.494-1.428 0-2.916-.38-4.433-1.142-3.098-1.554-6.28-4.645-9.46-9.187C2.302 17.275.487 13.227.085 9.786-.34 6.17.845 3.273 3.506 1.409A8.287 8.287 0 016.103.183L6.78 0l5.64 8.055-3.136 4.52 6.184 8.83zm7.37 7.607a6.501 6.501 0 001.123-.991l-4.011-5.728-5.32 1.4L6.845 12.58l3.136-4.52L5.97 2.332a6.475 6.475 0 00-1.317.716c-2.05 1.436-2.92 3.625-2.584 6.506.363 3.108 2.062 6.849 5.05 11.116 2.987 4.267 5.92 7.143 8.718 8.547 2.594 1.302 4.947 1.232 6.999-.204zm-7.325-12.865a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm6 0a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm6-3a1.5 1.5 0 110 3 1.5 1.5 0 010-3z"></path></defs><use fill="currentColor" xlink:href="#mbIconCall" fill-rule="evenodd" transform="translate(1)"></use></svg>
    </a>
  <?php } ?>

  <a href="<?php echo gam_fancy_url('contact'); ?>" class="mobile-item item-contact open-form contact isMobile" data-type="contact">
    <svg viewBox="0 0 32 32" width="24" height="24"><defs><path id="mbIconEmail" d="M26.324 0A5.682 5.682 0 0132 5.676v12.648A5.682 5.682 0 0126.324 24H5.676A5.682 5.682 0 010 18.324V5.676A5.682 5.682 0 015.676 0h20.648zM30 18.324V5.676A3.68 3.68 0 0026.324 2H5.676A3.68 3.68 0 002 5.676v12.648A3.68 3.68 0 005.676 22h20.648A3.68 3.68 0 0030 18.324zm-14-4.616l10.367-8.482 1.266 1.548L16 16.292 4.367 6.774l1.266-1.548L16 13.708z"></path></defs><use fill="currentColor" xlink:href="#mbIconEmail" fill-rule="evenodd" transform="translate(0 4)"></use></svg>
  </a>

  <?php if(osc_item_user_id() > 0) { ?>
    <a href="#" class="mobile-item item-user isMobile">
      <!--<div><img src="<?php echo gam_profile_picture(osc_item_user_id(), 'medium'); ?>" alt="<?php echo osc_item_contact_name(); ?>" /></div>-->
      <svg viewBox="0 0 32 32" width="24" height="24"><defs><path id="mbIconSignin" d="M16 30c-4.992 0-8.737-1.527-11.094-4.413 2.362-.829 6.498-1.35 10.946-1.35 5.194 0 9.137.674 11.169 1.433C24.66 28.5 20.942 30 16 30m0-28c9.028 0 14 4.972 14 14 0 3.181-.63 5.847-1.824 7.98-2.5-1.082-7.106-1.743-12.324-1.743-5.007 0-9.531.631-12.077 1.653C2.613 21.771 2 19.136 2 16 2 6.972 6.972 2 16 2m0-2C5.832 0 0 5.832 0 16s5.832 16 16 16 16-5.832 16-16S26.168 0 16 0m0 8.37a4.568 4.568 0 014.563 4.562A4.568 4.568 0 0116 17.495a4.568 4.568 0 01-4.563-4.563A4.568 4.568 0 0116 8.37m0 11.126a6.57 6.57 0 01-6.563-6.563A6.57 6.57 0 0116 6.37a6.57 6.57 0 016.563 6.563A6.57 6.57 0 0116 19.495zm-.027-4.008a3.17 3.17 0 003.057-2.343h-6.115a3.17 3.17 0 003.058 2.343z"></path></defs><use fill="currentColor" xlink:href="#mbIconSignin" fill-rule="evenodd"></use></svg>
    </a>
  <?php } ?>


  <?php if(!$mobile_login_required) { ?>
    <div class="mobile-item-data" style="display:none">
      <a href="tel:<?php echo $mobile; ?>"><?php echo sprintf(__('Call %s', 'gamma'), $mobile); ?></a>
      <a href="sms:<?php echo $mobile; ?>"><?php echo __('Send SMS', 'gamma'); ?></a>
      <a href="<?php echo $mobile; ?>" class="copy-number" data-done="<?php echo osc_esc_html(__('Copied to clipboard!', 'gamma')); ?>"><?php echo __('Copy number', 'gamma'); ?></a>
    </div>
  <?php } else { ?>
    <div class="mobile-item-data" style="display:none">
      <a href="<?php echo osc_user_login_url(); ?>"><?php _e('Login to show phone number', 'gamma'); ?></a>
    </div>
  <?php } ?>

  <div class="mobile-user-data" style="display:none">
    <a href="<?php echo osc_user_public_profile_url(osc_item_user_id()); ?>"><?php echo __('Public profile', 'gamma'); ?></a>
    <a href="<?php echo osc_search_url(array('page' => 'search', 'userId' => osc_item_user_id())); ?>"><?php echo __('All seller\'s items', 'gamma'); ?></a>
  </div>



  <script type="text/javascript">
    $(document).ready(function(){

      // SHOW PHONE NUMBER
      $('body').on('click', '.sold-by .sright .mobile', function(e) {
        if($(this).attr('href') == '#' && !$(this).hasClass('login-required')) {
          e.preventDefault()

          var phoneNumber = $(this).attr('data-phone');
          $(this).text(phoneNumber);
          $(this).attr('href', 'tel:' + phoneNumber);
          $(this).attr('title', '<?php echo osc_esc_js(__('Click to call', 'gamma')); ?>');
        }        
      });


      // SHOW EMAIL
      $('body').on('click', '.email', function(e) {
        if($(this).attr('href') == '#') {
          e.preventDefault()

          var email = $(this).attr('data-email');
          $(this).text(email);
          $(this).attr('href', 'mailto:' + email);
          $(this).attr('title', '<?php echo osc_esc_js(__('Click to send mail', 'gamma')); ?>');
        }        
      });


    });
  </script>

  <?php osc_current_web_theme_path('footer.php') ; ?>
</body>
</html>				
