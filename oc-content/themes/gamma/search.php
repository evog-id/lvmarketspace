<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo gam_language_dir(); ?>" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
  <?php osc_current_web_theme_path('head.php') ; ?>
  <?php if( osc_count_items() == 0 || Params::getParam('iPage') > 0 || stripos($_SERVER['REQUEST_URI'], 'search') )  { ?>
    <meta name="robots" content="noindex, nofollow" />
    <meta name="googlebot" content="noindex, nofollow" />
  <?php } else { ?>
    <meta name="robots" content="index, follow" />
    <meta name="googlebot" content="index, follow" />
  <?php } ?>
</head>

<body id="body-search" class="<?php if(gam_device() <> '') { echo 'dvc-' . gam_device(); } ?>">
<?php osc_current_web_theme_path('header.php') ; ?>
<?php osc_current_web_theme_path('inc.search.php') ; ?>
<?php osc_current_web_theme_path('inc.category.php') ; ?>

<?php 
  $params_spec = gam_search_params();
  $params_all = gam_search_params_all();

  $search_cat_id = osc_search_category_id();
  $search_cat_id = isset($search_cat_id[0]) ? $search_cat_id[0] : '';

  $category = Category::newInstance()->findByPrimaryKey($search_cat_id);

  $def_cur = (gam_param('def_cur') <> '' ? gam_param('def_cur') : '$');

  $search_params_remove = gam_search_param_remove();

  $exclude_tr_con = explode(',', gam_param('post_extra_exclude'));

  $def_view = gam_param('def_view') == 0 ? 'grid' : 'list';
  $show = Params::getParam('sShowAs') == '' ? $def_view : Params::getParam('sShowAs');
  $show = ($show == 'gallery' ? 'grid' : $show);

  // Get search hooks
  GLOBAL $search_hooks;
  ob_start(); 

  if(osc_search_category_id()) { 
    osc_run_hook('search_form', osc_search_category_id());
  } else { 
    osc_run_hook('search_form');
  }

  //$search_hooks = trim(ob_get_clean());
  //ob_end_flush();

  $search_hooks = trim(ob_get_contents());
  ob_end_clean();

  $search_hooks = trim($search_hooks);
?>


<div class="content">
  <div class="inside search">

    <div id="filter" class="filter">
      <div class="wrap">

        <form action="<?php echo osc_base_url(true); ?>" method="get" class="search-side-form nocsrf" id="search-form">
          <input type="hidden" name="page" value="search" />
          <input type="hidden" name="ajaxRun" value="" />
          <input type="hidden" name="sOrder" value="<?php echo osc_search_order(); ?>" />
          <input type="hidden" name="iOrderType" value="<?php $allowedTypesForSorting = Search::getAllowedTypesForSorting(); echo isset($allowedTypesForSorting[osc_search_order_type()]) ? $allowedTypesForSorting[osc_search_order_type()] : ''; ?>" />
          <input type="hidden" name="sCompany" class="sCompany" id="sCompany" value="<?php echo Params::getParam('sCompany');?>" />
          <input type="hidden" name="sCountry" id="sCountry" value="<?php echo Params::getParam('sCountry'); ?>"/>
          <input type="hidden" name="sRegion" id="sRegion" value="<?php echo Params::getParam('sRegion'); ?>"/>
          <input type="hidden" name="sCity" id="sCity" value="<?php echo Params::getParam('sCity'); ?>"/>
          <input type="hidden" name="iPage" id="iPage" value=""/>
          <input type="hidden" name="sShowAs" id="sShowAs" value="<?php echo Params::getParam('sShowAs'); ?>"/>
          <input type="hidden" name="showMore" id="showMore" value="<?php echo Params::getParam('showMore'); ?>"/>
          <input type="hidden" name="locUpdate"/>
          <input type="hidden" name="sCategory" value="<?php echo Params::getParam('sCategory'); ?>"/>
          <input type="hidden" name="userId" value="<?php echo Params::getParam('userId'); ?>"/>

          <div class="block">
            <div class="search-wrap">
 
              <!-- PATTERN AND LOCATION -->
              <div class="box isMobile">
                <h2><?php _e('Search', 'gamma'); ?></h2>

                <div class="row">
                  <label class="isMobile"><?php _e('Keyword', 'gamma'); ?></label>

                  <div class="input-box">
                    <input type="text" name="sPattern" placeholder="<?php _e('What are you looking for?', 'gamma'); ?>" value="<?php echo Params::getParam('sPattern'); ?>" autocomplete="off"/>
                  </div>
                </div>


                <div class="row">
                  <label for="term2" class="isMobile"><span><?php _e('Location', 'gamma'); ?></span></label>

                  <div id="location-picker" class="loc-picker picker-v2 ctr-<?php echo (gam_count_countries() == 1 ? 'one' : 'more'); ?>">

                    <div class="mini-box">
                      <input type="text" id="term2" class="term2" placeholder="<?php _e('City/Region', 'gamma'); ?>" value="<?php echo gam_get_term('', Params::getParam('sCountry'), Params::getParam('sRegion'), Params::getParam('sCity')); ?>" autocomplete="off" readonly/>
                      <i class="fa fa-angle-down"></i>
                    </div>

                    <div class="shower-wrap">
                      <div class="shower" id="shower">
                        <?php echo gam_locbox_short(Params::getParam('sCountry'), Params::getParam('sRegion'), Params::getParam('sCity')); ?>
                        <a href="#" class="btn btn-primary mbBg loc-confirm isMobile"><i class="fa fa-check"></i></a>

                        <div class="button-wrap isTablet isDesktop">
                          <a href="#" class="btn btn-primary mbBg loc-confirm"><?php _e('Ok', 'gamma'); ?></a>
                        </div>
                      </div>
                    </div>

                    <div class="loader"></div>
                  </div>
                </div>


                <div class="row isMobile">
                  <label for="term3"><span><?php _e('Category', 'gamma'); ?></span></label>

                  <div id="category-picker" class="cat-picker picker-v2">
                    <div class="mini-box">
                      <input type="text" class="term3" id="term3" placeholder="<?php _e('Category', 'gamma'); ?>"  autocomplete="off" value="<?php echo @$category['s_name']; ?>" readonly/>
                      <i class="fa fa-angle-down"></i>
                    </div>

                    <div class="shower-wrap">
                      <div class="shower" id="shower">
                        <?php echo gam_catbox_short($search_cat_id); ?>
                        <a href="#" class="btn btn-primary mbBg cat-confirm isMobile"><i class="fa fa-check"></i></a>

                        <div class="button-wrap isTablet isDesktop">
                          <a href="#" class="btn btn-primary mbBg cat-confirm"><?php _e('Continue', 'gamma'); ?></a>
                        </div>
                      </div>
                    </div>

                    <div class="loader"></div>
                  </div>
                </div>
              </div>









              <!-- PRICE -->
              <?php if( gam_check_category_price($search_cat_id) ) { ?>
                <div class="box price-box">
                  <h2><?php _e('Price', 'gamma'); ?></h2>

                  <div class="row price">
                    <div class="input-box">
                      <input type="number" class="priceMin" name="sPriceMin" value="<?php echo osc_esc_html(Params::getParam('sPriceMin')); ?>" size="6" maxlength="6" placeholder="<?php echo osc_esc_js(__('Min', 'gamma')); ?>"/>
                      <span><?php echo $def_cur; ?></span>
                    </div>

                    <div class="input-box">
                      <input type="number" class="priceMax" name="sPriceMax" value="<?php echo osc_esc_html(Params::getParam('sPriceMax')); ?>" size="6" maxlength="6" placeholder="<?php echo osc_esc_js(__('Max', 'gamma')); ?>"/>
                      <span><?php echo $def_cur; ?></span>
                    </div>
                  </div>
                </div>
              <?php } ?>

 
              <!-- CONDITION --> 
              <?php if(@!in_array($search_cat_id, $exclude_tr_con)) { ?>
                <div class="box">
                  <h2><?php _e('Condition', 'gamma'); ?></h2>

                  <div class="row">
                    <?php echo gam_simple_condition_list(); ?>
                  </div>
                </div>
              <?php } ?>

 
              <!-- TRANSACTION --> 
              <?php if(@!in_array($search_cat_id, $exclude_tr_con)) { ?>
                <div class="box">
                  <h2><?php _e('Transaction', 'gamma'); ?></h2>

                  <div class="row">
                    <?php echo gam_simple_transaction_list(); ?>
                  </div>
                </div>
              <?php } ?>


              <!-- PERIOD--> 
              <div class="box">
                <h2><?php _e('Period', 'gamma'); ?></h2>

                <div class="row">
                  <?php echo gam_simple_period_list(); ?>
                </div>
              </div>



              <?php if( osc_images_enabled_at_items() ) { ?>
                <fieldset class="img-check">
                  <div class="row checkboxes">
                    <div class="input-box-check">
                      <input type="checkbox" name="bPic" id="bPic" value="1" <?php echo (osc_search_has_pic() ? 'checked="checked"' : ''); ?> />
                      <label for="bPic" class="with-pic-label"><?php _e('Only items with picture', 'gamma'); ?></label>
                    </div>
                  </div>
                </fieldset>
              <?php } ?>

              <fieldset class="prem-check">
                <div class="row checkboxes">
                  <div class="input-box-check">
                    <input type="checkbox" name="bPremium" id="bPremium" value="1" <?php echo (Params::getParam('bPremium') == 1 ? 'checked="checked"' : ''); ?> />
                    <label for="bPremium" class="only-prem-label"><?php _e('Only premium items', 'gamma'); ?></label>
                  </div>
                </div>
              </fieldset>


              <?php if($search_hooks <> '') { ?>
                <div class="box sidehook">
                  <h2><?php _e('Additional parameters', 'gamma'); ?></h2>

                  <div class="sidebar-hooks">
                    <?php echo $search_hooks; ?>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>

          <div class="button-wrap">
            <button type="submit" class="btn mbBg init-search" id="search-button"><?php _e('Search', 'gamma') ; ?></button>
          </div>
        </form>



        <!-- SUBSCRIBE TO SEARCH -->
        <?php osc_alert_form(); ?>
      </div>

      <?php echo gam_banner('search_sidebar'); ?>
    </div>


    <div id="main">
      <div class="relative2">
        <div class="titles-top">
          <h1>
            <?php 
              $loc = @array_filter(array(osc_search_city(), osc_search_region(), osc_search_city()))[0];
              $cat = @$category['s_name'];

              if(osc_search_total_items() <= 0) { 
                echo __('No listings found', 'gamma');

              } else if($cat <> '') {
                if($loc <> '') {
                  echo sprintf(__('%s in %s', 'gamma'), $cat, $loc);
                } else {
                  echo sprintf(__('%s results', 'gamma'), $cat);
                }
              } else {
                if($loc <> '') {
                  echo sprintf(__('%s results', 'gamma'), $loc);
                } else {
                  echo __('Results', 'gamma');
                }
              }
            ?>
          </h1>

          <?php if(osc_search_total_items() > 0) { ?>
            <span><?php echo sprintf(__('%s listings', 'gamma'), osc_search_total_items() ); ?></span>
          <?php } ?>
        </div>

        <?php
          $p1 = $params_all; $p1['sCompany'] = null;
          $p2 = $params_all; $p2['sCompany'] = 0;
          $p3 = $params_all; $p3['sCompany'] = 1;

          $us_type = Params::getParam('sCompany');
          
        ?>


        <!-- SEARCH FILTERS - SORT / COMPANY / VIEW -->
        <div id="search-sort" class="">
          <div class="user-type">
            <a class="all<?php if(Params::getParam('sCompany') === '' || Params::getParam('sCompany') === null) { ?> active<?php } ?>" href="<?php echo osc_search_url($p1); ?>"><?php _e('All listings', 'gamma'); ?></a>
            <a class="personal<?php if(Params::getParam('sCompany') === '0') { ?> active<?php } ?>" href="<?php echo osc_search_url($p2); ?>"><?php _e('Personal', 'gamma'); ?></a>
            <a class="company<?php if(Params::getParam('sCompany') === '1') { ?> active<?php } ?>" href="<?php echo osc_search_url($p3); ?>"><?php _e('Company', 'gamma'); ?></a>
          </div>

          <?php if(osc_count_items() > 0) { ?>
            <div class="list-grid">
              <?php $show = Params::getParam('sShowAs') == '' ? $def_view : Params::getParam('sShowAs'); ?>
              <a href="<?php echo osc_update_search_url(array('sShowAs' => 'list')); ?>" title="<?php echo osc_esc_html(__('List view', 'gamma')); ?>" class="lg<?php echo ($show == 'list' ? ' active' : ''); ?>" data-view="list"><i class="fa fa-bars"></i></a>
              <a href="<?php echo osc_update_search_url(array('sShowAs' => 'grid')); ?>" title="<?php echo osc_esc_html(__('Grid view', 'gamma')); ?>" class="lg<?php echo ($show == 'grid' ? ' active' : ''); ?>" data-view="grid"><i class="fa fa-th"></i></a>
            </div>

            <div class="sort-it">
              <div class="sort-title">
                <div class="title-keep noselect">
                  <?php $orders = osc_list_orders(); ?>
                  <?php $current_order = osc_search_order(); ?>
                  <?php foreach($orders as $label => $params) { ?>
                    <?php $orderType = ($params['iOrderType'] == 'asc') ? '0' : '1'; ?>
                    <?php if(osc_search_order() == $params['sOrder'] && osc_search_order_type() == $orderType) { ?>
                      <span>
                        <span class="lab" style="display:none;"><?php _e('Sort by', 'gamma'); ?></span>
                        <span class="kind"><?php echo $label; ?></span>
                        <svg style="display:none;" viewBox="0 0 32 32" color="#696766" width="14px" height="14px"><defs><path id="mbIconAngle" d="M12.147 25.2c-.462 0-.926-.185-1.285-.556L.57 14.024A2.05 2.05 0 010 12.586c0-.543.206-1.061.571-1.436L10.864.553a1.765 1.765 0 012.62.06c.71.795.683 2.057-.055 2.817l-8.9 9.16 8.902 9.183c.738.76.761 2.024.052 2.815a1.78 1.78 0 01-1.336.612"></path></defs><use fill="currentColor" transform="matrix(0 -1 -1 0 29 24)" xlink:href="#mbIconAngle" fill-rule="evenodd"></use></svg>
                      </span>
                    <?php } ?>
                  <?php } ?>
                </div>

                <div id="sort-wrap">
                  <div class="sort-content">
                    <?php $i = 0; ?>
                    <?php foreach($orders as $label => $params) { ?>
                      <?php $orderType = ($params['iOrderType'] == 'asc') ? '0' : '1'; ?>
                      <?php if(osc_search_order() == $params['sOrder'] && osc_search_order_type() == $orderType) { ?>
                        <a class="current" href="<?php echo osc_update_search_url($params) ; ?>"><span><?php echo $label; ?></span></a>
                      <?php } else { ?>
                        <a href="<?php echo osc_update_search_url($params) ; ?>"><span><?php echo $label; ?></span></a>
                      <?php } ?>
                      <?php $i++; ?>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
      

      <div id="search-items">     
        <!-- REMOVE FILTER SECTION -->
        <?php  
          // count usable params
          $filter_check = 0;
          if(count($search_params_remove) > 0) {
            foreach($search_params_remove as $n => $v) { 
              if($v['name'] <> '' && $v['title'] <> '') { 
                $filter_check++;
              }
            }
          }
        ?>

        <?php if($filter_check > 0) { ?>
          <div class="filter-remove">
            <?php foreach($search_params_remove as $n => $v) { ?>
              <?php if($v['name'] <> '' && $v['title'] <> '') { ?>
                <?php
                  $rem_param = $params_all;
                  unset($rem_param[$n]);
                ?>

                <a href="<?php echo osc_search_url($rem_param); ?>" data-param="<?php echo $v['param']; ?>"><?php echo $v['title'] . ': ' . $v['name']; ?></a>
              <?php } ?>
            <?php } ?>

            <a class="bold" href="<?php echo osc_search_url(array('page' => 'search')); ?>"><?php _e('Remove all', 'gamma'); ?></a>
          </div>
        <?php } ?>
  
             
        <?php if(osc_count_items() == 0) { ?>
          <div class="list-empty round3" >
            <span class="titles"><?php _e('We could not find any results for your search...', 'gamma'); ?></span>

            <div class="tips">
              <div class="row"><?php _e('Following tips might help you to get gamter results', 'gamma'); ?></div>
              <div class="row"><i class="fa fa-circle"></i><?php _e('Use more general keywords', 'gamma'); ?></div>
              <div class="row"><i class="fa fa-circle"></i><?php _e('Check spelling of position', 'gamma'); ?></div>
              <div class="row"><i class="fa fa-circle"></i><?php _e('Reduce filters, use less of them', 'gamma'); ?></div>
              <div class="row last"><a href="<?php echo osc_search_url(array('page' => 'search'));?>"><?php _e('Reset filter', 'gamma'); ?></a></div>
            </div>
          </div>

        <?php } else { ?>

          <?php require('search_gallery.php') ; ?>
        <?php } ?>

        <div class="paginate"><?php echo gam_fix_arrow(osc_search_pagination()); ?></div>

        <?php echo gam_banner('search_bottom'); ?>
      </div>
    </div>

  </div>


  <a href="#" class="mbBg2 filter-button mobile-filter isMobile">
    <svg viewBox="0 0 32 32"><defs><path id="mbIconFilters" d="M7 20c1.858 0 3.411 1.279 3.858 3H32v2H10.858c-.447 1.721-2 3-3.858 3s-3.411-1.279-3.858-3H0v-2h3.142c.447-1.721 2-3 3.858-3zm3.857-17H32v2H10.858c-.447 1.721-2 3-3.858 3S3.589 6.721 3.142 5H0V3h3.143C3.589 1.28 5.142 0 7 0s3.411 1.28 3.857 3zM25 10c1.858 0 3.411 1.279 3.858 3H32v2h-3.142c-.447 1.721-2 3-3.858 3s-3.411-1.279-3.858-3H0v-2h21.142c.447-1.721 2-3 3.858-3zM7 26c1.103 0 2-.897 2-2s-.897-2-2-2-2 .897-2 2 .897 2 2 2zM7 6c1.103 0 2-.897 2-2s-.897-2-2-2-2 .897-2 2 .897 2 2 2zm18 10c1.103 0 2-.897 2-2s-.897-2-2-2-2 .897-2 2 .897 2 2 2z"></path></defs><use fill="currentColor" xlink:href="#mbIconFilters" fill-rule="evenodd" transform="translate(0 2)"></use></svg>
  </a>


</div>

<?php osc_current_web_theme_path('footer.php') ; ?>

</body>
</html>