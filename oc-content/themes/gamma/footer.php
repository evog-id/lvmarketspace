</section>

<?php if(osc_is_home_page()) { ?>
  <div class="mobile-post-wrap">
    <a class="mobile-post isMobile mbBg2" href="<?php echo osc_item_post_url(); ?>">
      <svg viewBox="0 0 32 32" color="#ffffff" width="16" height="16"><defs><path id="mbIconAdd" d="M17.125 14.875h6.749c.622 0 1.126.5 1.126 1.125 0 .621-.5 1.125-1.126 1.125h-6.749v6.749c0 .622-.5 1.126-1.125 1.126-.621 0-1.125-.5-1.125-1.126v-6.749H8.126C7.504 17.125 7 16.625 7 16c0-.621.5-1.125 1.126-1.125h6.749V8.126c0-.622.5-1.126 1.125-1.126.621 0 1.125.5 1.125 1.126v6.749zM29.779 25.28l-.125.185c-.079.13-.169.249-.252.375l-.061.09-.025.032c-.316.467-.662.907-1.032 1.322l-.073.082c-1.171 1.29-2.598 2.327-4.274 3.087l-.009.005a15.64 15.64 0 01-1.622.618c-.113.037-.228.069-.341.103-.463.138-.94.259-1.432.362-.162.035-.324.069-.49.1a20.74 20.74 0 01-1.462.207c-.175.019-.343.045-.52.06-.667.057-1.351.092-2.061.092-.715 0-1.403-.036-2.074-.093-.186-.016-.364-.043-.545-.063a20.722 20.722 0 01-1.447-.208c-.178-.032-.352-.07-.527-.107a17.577 17.577 0 01-1.409-.361c-.126-.038-.253-.073-.376-.114-1.789-.585-3.347-1.44-4.657-2.549-.04-.033-.077-.069-.117-.104a12.57 12.57 0 01-1.116-1.098l-.144-.162a12.867 12.867 0 01-1.004-1.322c-.008-.011-.018-.021-.025-.033l-.027-.04c-.067-.104-.138-.205-.204-.312l-.263-.402.031-.024C.729 22.575 0 19.561 0 16 0 5.832 5.832 0 16 0s16 5.832 16 16c0 3.684-.775 6.79-2.235 9.264l.014.016zm-1.722-1.16l-.013-.014C29.322 21.941 30 19.223 30 16c0-8.897-5.103-14-14-14S2 7.103 2 16c0 3.116.638 5.753 1.834 7.882l-.027.021.23.352c.058.093.12.182.178.273l.024.035c.006.01.015.019.022.029.27.408.564.792.878 1.156l.127.142c.306.34.63.662.976.96.035.031.067.063.102.092 1.147.97 2.51 1.718 4.075 2.23.108.036.219.067.33.1.397.12.809.226 1.232.316.153.032.306.066.461.093.41.076.834.134 1.266.182.159.018.315.042.477.056.587.05 1.19.081 1.815.081.621 0 1.22-.03 1.803-.08.155-.014.302-.036.455-.053a18.17 18.17 0 001.28-.181c.145-.027.287-.057.428-.088.43-.09.848-.196 1.253-.316.1-.03.2-.058.299-.09a13.84 13.84 0 001.419-.541l.008-.005a11.294 11.294 0 003.74-2.7l.064-.073c.323-.363.626-.748.902-1.156l.022-.028.054-.079c.072-.11.151-.214.22-.328l.11-.162z"></path></defs><use fill="currentColor" xlink:href="#mbIconAdd" fill-rule="evenodd"></use></svg>
      <span><?php _e('Post an ad', 'gamma'); ?></span>
    </a>
  </div>
<?php } ?>

<footer>
  <div class="inside">

    <div class="cl cl1">
      <div class="hd"><?php _e('Navigation', 'gamma'); ?></div>

      <a class="lnk" href="<?php echo osc_base_url(); ?>"><?php _e('Home', 'gamma'); ?></a>
      <a class="lnk" href="<?php echo osc_search_url(array('page' => 'search')); ?>"><?php _e('Search', 'gamma'); ?></a>
      <a class="lnk" href="<?php echo osc_contact_url(); ?>"><?php _e('Contact', 'gamma'); ?></a>
      <a class="lnk" href="<?php echo osc_user_dashboard_url(); ?>"><?php _e('My Account', 'gamma'); ?></a>
      <a class="lnk" href="<?php echo osc_item_post_url(); ?>"><?php _e('Add a new listing', 'gamma'); ?></a>

      <?php if(osc_get_preference('footer_link', 'theme-gamma')) { ?>
        <a class="lnk" href="https://osclasspoint.com/">Osclass Themes</a>
        <a class="lnk" href="https://osclass-classifieds.com/">Classifieds script Osclass</a>
      <?php } ?>
    </div>

    <div class="cl cl2">
      <div class="hd"><?php _e('Categories', 'gamma'); ?></div>

      <?php osc_goto_first_category(); ?>
      <?php $i = 1; ?>
      <?php while(osc_has_categories()) { ?>
        <?php if($i <= 10) { ?>
          <a class="lnk <?php if($i >= 5) { ?>go-hide<?php } ?>" href="<?php echo osc_search_url(array('page' => 'search', 'sCategory' => osc_category_id())); ?>"><?php echo osc_category_name();?></a>
        <?php } ?>

        <?php $i++; ?>
      <?php } ?>

      <?php if($i >= 5) { ?>
        <a class="lnk show-hidden" href="#">
          <span class="more"><?php _e('Show more', 'gamma'); ?></span>
          <span class="less"><?php _e('Show less', 'gamma'); ?></span>
          <svg viewBox="0 0 32 32" width="16px" height="16px"><defs><path id="mbIconAngle" d="M12.147 25.2c-.462 0-.926-.185-1.285-.556L.57 14.024A2.05 2.05 0 010 12.586c0-.543.206-1.061.571-1.436L10.864.553a1.765 1.765 0 012.62.06c.71.795.683 2.057-.055 2.817l-8.9 9.16 8.902 9.183c.738.76.761 2.024.052 2.815a1.78 1.78 0 01-1.336.612"></path></defs><use fill="currentColor" transform="matrix(0 -1 -1 0 29 24)" xlink:href="#mbIconAngle" fill-rule="evenodd"></use></svg>
        </a>
      <?php } ?>
    </div>



    <div class="cl cl3">
      <div class="hd"><?php _e('Information', 'gamma'); ?></div>

      <?php $pages = Page::newInstance()->listAll($indelible = 0, $b_link = 1, $locale = null, $start = null, $limit = 10); ?>

      <?php $i = 1; ?>
      <?php foreach($pages as $p) { ?>
        <?php View::newInstance()->_exportVariableToView('page', $p); ?>
        <a class="lnk <?php if($i >= 5) { ?>go-hide<?php } ?>" href="<?php echo osc_static_page_url(); ?>"><?php echo osc_static_page_title();?></a>

        <?php $i++; ?>
      <?php } ?>

      <?php if($i >= 5) { ?>
        <a class="lnk show-hidden" href="#">
          <span class="more"><?php _e('Show more', 'gamma'); ?></span>
          <span class="less"><?php _e('Show less', 'gamma'); ?></span>
          <svg viewBox="0 0 32 32" width="16px" height="16px"><defs><path id="mbIconAngle" d="M12.147 25.2c-.462 0-.926-.185-1.285-.556L.57 14.024A2.05 2.05 0 010 12.586c0-.543.206-1.061.571-1.436L10.864.553a1.765 1.765 0 012.62.06c.71.795.683 2.057-.055 2.817l-8.9 9.16 8.902 9.183c.738.76.761 2.024.052 2.815a1.78 1.78 0 01-1.336.612"></path></defs><use fill="currentColor" transform="matrix(0 -1 -1 0 29 24)" xlink:href="#mbIconAngle" fill-rule="evenodd"></use></svg>
        </a>
      <?php } ?>
    </div>


    <?php if ( osc_count_web_enabled_locales() > 1) { ?>
      <div class="cl cl4">
        <div class="hd"><?php _e('Language', 'gamma'); ?></div>

        <div class="langs">
          <?php $current_locale = mb_get_current_user_locale(); ?>

          <?php osc_goto_first_locale(); ?>
          <?php $i = 1; ?>

          <?php while ( osc_has_web_enabled_locales() ) { ?>
            <a class="lnk lang <?php if (osc_locale_code() == $current_locale['pk_c_code']) { ?>active<?php } ?> <?php if($i >= 5) { ?>go-hide<?php } ?>" href="<?php echo osc_change_language_url(osc_locale_code()); ?>"><img src="<?php echo gam_country_flag_image(strtolower(substr(osc_locale_code(), 3))); ?>" alt="<?php _e('Country flag', 'gamma');?>" /><span><?php echo osc_locale_name(); ?>&#x200E;</span></a>
            <?php $i++; ?>
          <?php } ?>

          <?php if($i >= 5) { ?>
            <a class="lnk show-hidden" href="#">
              <span class="more"><?php _e('Show more', 'gamma'); ?></span>
              <span class="less"><?php _e('Show less', 'gamma'); ?></span>
              <svg viewBox="0 0 32 32" width="16px" height="16px"><defs><path id="mbIconAngle" d="M12.147 25.2c-.462 0-.926-.185-1.285-.556L.57 14.024A2.05 2.05 0 010 12.586c0-.543.206-1.061.571-1.436L10.864.553a1.765 1.765 0 012.62.06c.71.795.683 2.057-.055 2.817l-8.9 9.16 8.902 9.183c.738.76.761 2.024.052 2.815a1.78 1.78 0 01-1.336.612"></path></defs><use fill="currentColor" transform="matrix(0 -1 -1 0 29 24)" xlink:href="#mbIconAngle" fill-rule="evenodd"></use></svg>
            </a>
          <?php } ?>
        </div>
      </div>
    <?php } ?>

    <div class="footer-hook"><?php osc_run_hook('footer'); ?></div>

    <div class="footer-widgets"><?php osc_show_widgets('footer'); ?></div>
  </div>
</footer>


<?php if(gam_param('scrolltop') == 1) { ?>
  <a id="scroll-to-top"><img src="<?php echo osc_current_web_theme_url('images/scroll-to-top.png'); ?>"/></a>
<?php } ?>


<?php if ( OSC_DEBUG || OSC_DEBUG_DB ) { ?>
  <div id="debug-mode" class="noselect"><?php _e('You have enabled DEBUG MODE, autocomplete for locations and items will not work! Disable it in your config.php.', 'gamma'); ?></div>
<?php } ?>


<!-- MOBILE BLOCKS -->
<div id="menu-cover" class="mobile-box"></div>


<div id="menu-options" class="mobile-box">
  <div class="body">
    <a href="<?php echo osc_base_url(); ?>"><i class="fa fa-home"></i> <?php _e('Home', 'gamma'); ?></a>
    <a href="<?php echo osc_search_url(array('page' => 'search')); ?>"><i class="fa fa-search"></i> <?php _e('Search', 'gamma'); ?></a>

    <a class="publish" href="<?php echo osc_item_post_url(); ?>"><i class="fa fa-plus-circle"></i> <?php _e('Add a new listing', 'gamma'); ?></a>

    <?php if(!osc_is_web_user_logged_in()) { ?>
      <a href="<?php echo gam_reg_url('login'); ?>"><i class="fa fa-sign-in"></i> <?php _e('Log in', 'gamma'); ?></a>
      <a href="<?php echo gam_reg_url('register'); ?>"><i class="fa fa-pencil-square-o"></i> <?php _e('Register a new account', 'gamma'); ?></a>

    <?php } else { ?>
      <a href="<?php echo osc_user_list_items_url(); ?>"><i class="fa fa-folder-o"></i> <?php _e('My listings', 'gamma'); ?></a>
      <a href="<?php echo osc_user_profile_url(); ?>"><i class="far fa-edit"></i> <?php _e('My profile', 'gamma'); ?></a>
      <a href="<?php echo osc_user_alerts_url(); ?>"><i class="fa fa-bullhorn"></i> <?php _e('My alerts', 'gamma'); ?></a>

    <?php } ?>

    <a href="<?php echo osc_contact_url(); ?>"><i class="fa fa-envelope-o"></i> <?php _e('Contact', 'gamma'); ?></a>

    <?php if(osc_is_web_user_logged_in()) { ?>
      <a href="<?php echo osc_user_logout_url(); ?>"><i class="fa fa-sign-out"></i> <?php _e('Log out', 'gamma'); ?></a>
    <?php } ?>

  </div>
</div>

<div id="menu-user" class="mobile-box">
  <div class="body">
    <?php echo gam_user_menu(); ?>
  </div>
</div>

<div id="overlay" class="white"></div>
<div id="overlay" class="black"></div>



<style>
.loc-picker .region-tab:empty:after {content:"<?php echo osc_esc_html(__('Select country first to get list of regions', 'gamma')); ?>";}
.loc-picker .city-tab:empty:after {content:"<?php echo osc_esc_html(__('Select region first to get list of regions', 'gamma')); ?>";}
.cat-picker .wrapper:after {content:"<?php echo osc_esc_html(__('Select main category first to get list of subcategories', 'gamma')); ?>";}
a.fi_img-link.fi-no-image > img {content:url("<?php echo osc_base_url(); ?>/oc-content/themes/gamma/images/no-image.png");}
</style>


<?php if(Params::getParam('type') != 'itemviewer') { ?>
<script>
  $(document).ready(function(){

    // JAVASCRIPT AJAX LOADER FOR LOCATIONS 
    var termClicked = false;
    var currentCountry = "<?php echo gam_ajax_country(); ?>";
    var currentRegion = "<?php echo gam_ajax_region(); ?>";
    var currentCity = "<?php echo gam_ajax_city(); ?>";
  

    // Create delay
    var delay = (function(){
      var timer = 0;
      return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
      };
    })();


    $(document).ajaxSend(function(evt, request, settings) {
      var url = settings.url;

      if (url.indexOf("ajaxLoc") >= 0) {
        $(".loc-picker, .location-picker").addClass('searching');
      }
    });

    $(document).ajaxStop(function() {
      $(".loc-picker, .location-picker").removeClass('searching');
    });



    $('body').on('keyup', '.loc-picker .term', function(e) {

      delay(function(){
        var min_length = 1;
        var elem = $(e.target);
        var term = encodeURIComponent(elem.val());

        // If comma entered, remove characters after comma including
        if(term.indexOf(',') > 1) {
          term = term.substr(0, term.indexOf(','));
        }

        // If comma entered, remove characters after - including (because city is shown in format City - Region)
        if(term.indexOf(' - ') > 1) {
          term = term.substr(0, term.indexOf(' - '));
        }

        var block = elem.closest('.loc-picker');
        var shower = elem.closest('.loc-picker').find('.shower');

        shower.html('');

        if(term != '' && term.length >= min_length) {
          // Combined ajax for country, region & city
          $.ajax({
            type: "POST",
            url: baseAjaxUrl + "&ajaxLoc=1&term=" + term,
            dataType: 'json',
            success: function(data) {
              var length = data.length;
              var result = '';
              var result_first = '';
              var countCountry = 0;
              var countRegion = 0;
              var countCity = 0;


              if(shower.find('.service.min-char').length <= 0) {
                for(key in data) {

                  // Prepare location IDs
                  var id = '';
                  var country_code = '';
                  if( data[key].country_code ) {
                    country_code = data[key].country_code;
                    id = country_code;
                  }

                  var region_id = '';
                  if( data[key].region_id ) {
                    region_id = data[key].region_id;
                    id = region_id;
                  }

                  var city_id = '';
                  if( data[key].city_id ) {
                    city_id = data[key].city_id;
                    id = city_id;
                  }
                    

                  // Count cities, regions & countries
                  if (data[key].type == 'city') {
                    countCity = countCity + 1;
                  } else if (data[key].type == 'region') {
                    countRegion = countRegion + 1;
                  } else if (data[key].type == 'country') {
                    countCountry = countCountry + 1;
                  }


                  // Find currently selected element
                  var selectedClass = '';
                  if( 
                    data[key].type == 'country' && parseInt(currentCountry) == parseInt(data[key].country_code) 
                    || data[key].type == 'region' && parseInt(currentRegion) == parseInt(data[key].region_id) 
                    || data[key].type == 'city' && parseInt(currentCity) == parseInt(data[key].city_id) 
                  ) { 
                    selectedClass = ' selected'; 
                  }


                  // For cities, get region name
                  var nameTop = data[key].name_top;

                  if(nameTop != '' && nameTop != 'null' && nameTop !== null && nameTop !== undefined) {
                    nameTop = nameTop.replace(/'/g, '');
                  } else {
                    nameTop = '';
                  }

                  if(data[key].type != 'city_more') {

                    // When classic city, region or country in loop and same does not already exists
                    if(shower.find('div[data-code="' + data[key].type + data[key].id + '"]').length <= 0) {
                      result += '<div class="option ' + data[key].type + selectedClass + '" data-country="' + country_code + '" data-region="' + region_id + '" data-city="' + city_id + '" data-code="' + data[key].type + id + '" id="' + id + '" title="' + nameTop + '"><strong>' + data[key].name + '</strong></div>';
                    }
                  }
                }


                // No city, region or country found
                if( countCity == 0 && countRegion == 0 && countCountry == 0 && shower.find('.empty-loc').length <= 0 && shower.find('.service.min-char').length <= 0) {
                  shower.find('.option').remove();
                  result_first += '<div class="option service empty-pick empty-loc"><?php echo osc_esc_js(__('No location match to your criteria', 'gamma')); ?></div>';
                }
              }

              shower.html(result_first + result);
            }
          });

        } else {
          // Term is not length enough, show default content
          //shower.html('<div class="option service min-char"><?php echo osc_esc_js(__('Enter at least', 'gamma')); ?> ' + (min_length - term.length) + ' <?php echo osc_esc_js(__('more letter(s)', 'gamma')); ?></div>');

          shower.html('<?php echo osc_esc_js(gam_def_location()); ?>');
        }
      }, 500 );
    });
  });
</script>
<?php } ?>