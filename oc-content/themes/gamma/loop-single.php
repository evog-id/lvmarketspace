<?php $item_extra = gam_item_extra(osc_item_id()); ?>

<div class="simple-prod o<?php echo $c; ?><?php if(osc_item_is_premium()) { ?> is-premium<?php } ?><?php if($class <> '') { echo ' ' . $class; } ?><?php if(@$item_extra['i_sold'] == 1) { echo ' st-sold'; } else if(@$item_extra['i_sold'] == 2) { echo ' st-reserved'; } ?> <?php osc_run_hook("highlight_class"); ?>">
  <div class="simple-wrap">
    <?php if(@$item_extra['i_sold'] == 1) { ?>
      <a class="label lab-sold" href="<?php echo osc_item_url(); ?>" title="<?php echo osc_esc_html(__('Sold', 'gamma')); ?>">
        <i class="fas fa-gavel"></i>
        <span class="rectangle"></span>
      </a>
    <?php } else if(@$item_extra['i_sold'] == 2) { ?>
      <a class="label lab-res" href="<?php echo osc_item_url(); ?>" title="<?php echo osc_esc_html(__('Reserved', 'gamma')); ?>">
        <i class="fas fa-calendar-alt"></i>
        <span class="rectangle"></span>
      </a>
    <?php } else if(osc_item_is_premium()) { ?>
      <a class="label lab-prem mbBg3" href="<?php echo osc_item_url(); ?>" title="<?php echo osc_esc_html(__('Premium', 'gamma')); ?>">
        <i class="fas fa-star"></i>
        <span class="rectangle mbBg3"></span>
      </a>
    <?php } ?>       

    <div class="img-wrap<?php if(osc_count_item_resources() == 0) { ?> no-image<?php } ?>">
      <?php if(osc_count_item_resources() > 0) { ?>
        <a class="img" href="<?php echo osc_item_url(); ?>"><img class="<?php echo (gam_is_lazy() ? 'lazy' : ''); ?>" src="<?php echo (gam_is_lazy() ? gam_get_noimage() : osc_resource_thumbnail_url()); ?>" data-src="<?php echo osc_resource_thumbnail_url(); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>" /></a>
      <?php } else { ?>
        <a class="img" href="<?php echo osc_item_url(); ?>"><img class="<?php echo (gam_is_lazy() ? 'lazy' : ''); ?>" src="<?php echo gam_get_noimage(); ?>" data-src="<?php echo gam_get_noimage(); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>" /></a>
      <?php } ?>

      <div class="publish isGrid"><?php echo gam_smart_date(osc_item_pub_date()); ?></div>

      <div class="favorite"><?php if(function_exists('fi_save_favorite')) { echo fi_save_favorite(); } ?></div>
    </div>

    <div class="data">
      <?php if(gam_param('preview') == 1) { ?>
        <a class="preview" href="<?php echo gam_fancy_url('itemviewer'); ?>" title="<?php echo osc_esc_html(__('Preview', 'gamma')); ?>"><i class="fas fa-expand-arrows-alt"></i></a>
      <?php } ?>

      <a class="title" href="<?php echo osc_item_url(); ?>"><?php echo osc_highlight(osc_item_title(), 100); ?></a>

      <?php if(gam_check_category_price(osc_item_category_id())) { ?>
        <div class="price isList"><span><?php echo osc_item_formated_price(); ?></span></div>
      <?php } ?>

      <div class="one-row isGrid <?php if(intval(osc_item_price()) <= 0) { ?>fix<?php } ?>">
        <?php if(gam_check_category_price(osc_item_category_id())) { ?>
          <div class="price"><span><?php echo osc_item_formated_price(); ?></span></div>
        <?php } ?>

        <div class="date"><i class="far fa-clock"></i> <?php echo gam_smart_date(osc_item_pub_date()); ?></div> 
      </div>

      <div class="description isList"><?php echo osc_highlight(strip_tags(osc_item_description()), 320); ?></div>

      <div class="extra isList">
        <?php if(gam_item_location() <> '') { ?>
          <span class="location"><i class="fas fa-map-marker-alt"></i> <?php echo gam_item_location(); ?></span>
        <?php } ?>

        <span class="time"><i class="fas fa-clock"></i> <?php echo gam_smart_date(osc_item_pub_date()); ?></span>
      </div>

    </div>

  </div>
</div>