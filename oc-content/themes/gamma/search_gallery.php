<?php
  $def_view = gam_param('def_view') == 0 ? 'grid' : 'list';
  $show = Params::getParam('sShowAs') == '' ? $def_view : Params::getParam('sShowAs');
  $show = ($show == 'gallery' ? 'grid' : $show);
?>

<div class="search-items-wrap">
  <div class="block">
    <div class="wrap">
      <?php osc_get_premiums(gam_param('premium_search_count')); ?>

      <?php if(osc_count_premiums() > 0 && gam_param('premium_search') == 1) { ?>

        <div class="premiums-block <?php echo (osc_count_premiums() % 2 == 1 ? 'odd' : 'even'); ?> products grid">
          <h3 class="premium-blck"><?php echo __('Premium listings', 'gamma'); ?></h3>

          <div class="relative">
            <div class="nice-scroll-left"></div>
            <div class="nice-scroll-right"></div>

            <div class="ins nice-scroll">
              <?php 
                // PREMIUM ITEMS
                $c = 1;
    
                while(osc_has_premiums()) {
                  gam_draw_item($c, true, 'premium-loop');
                  $c++;
                }
              ?>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php echo gam_banner('search_top'); ?>

      <div class="products standard <?php echo $show; ?>">
        <?php 
          $c = 1; 
          while( osc_has_items() ) {
            gam_draw_item($c);

            if($c == 3 && osc_count_items() > 3) {
              echo gam_banner('search_middle');
            }

            $c++;
          } 
        ?>
      </div>

    </div>
  </div>
 
  <?php View::newInstance()->_erase('items') ; ?>
</div>