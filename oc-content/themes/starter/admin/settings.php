<?php
  require_once 'functions.php';
  starter_backoffice_menu(__('Settings', 'starter'));
?>


<?php
// MANAGE IMAGES
if(Params::getParam('starter_images') == 'done') { 
  $upload_dir_small = osc_themes_path() . osc_current_web_theme() . '/images/small_cat/';
  $upload_dir_large = osc_themes_path() . osc_current_web_theme() . '/images/large_cat/';

  if (!file_exists($upload_dir_small)) { mkdir($upload_dir_small, 0777, true); }
  if (!file_exists($upload_dir_large)) { mkdir($upload_dir_large, 0777, true); }

  $count_real = 0;
  $conn = DBConnectionClass::newInstance();
  $data = $conn->getOsclassDb();
  $comm = new DBCommandClass($data);

  for ($i=1; $i<=2000; $i++) {
    if(isset($_POST['fa-icon' .$i])) {
      $fields = array('s_icon' => Params::getParam('fa-icon' .$i));
      $comm->update(DB_TABLE_PREFIX.'t_category_starter', $fields, array('fk_i_category_id' => $i));

      message_ok(__('Font Awesome icon successfully saved for category' . ' <strong>#' . $i . '</strong>' ,'starter'));
    }

    if(isset($_POST['color' .$i])) {
      $fields = array('s_color' => Params::getParam('color' .$i));
      $comm->update(DB_TABLE_PREFIX.'t_category_starter', $fields, array('fk_i_category_id' => $i));

      message_ok(__('Color successfully saved for category' . ' <strong>#' . $i . '</strong>' ,'starter'));
    }

    if(isset($_FILES['small' .$i]) and $_FILES['small' .$i]['name'] <> ''){

      $file_ext   = strtolower(end(explode('.', $_FILES['small' .$i]['name'])));
      $file_name  = $i . '.' . $file_ext;
      $file_tmp   = $_FILES['small' .$i]['tmp_name'];
      $file_type  = $_FILES['small' .$i]['type'];   
      $extensions = array("png");

      if(in_array($file_ext,$extensions )=== false) {
        $errors = __('extension not allowed, only allowed extension is .png!','starter');
      } 
				
      if(empty($errors)==true){
        move_uploaded_file($file_tmp, $upload_dir_small.$file_name);
        message_ok(__('Small image #','starter') . $i . __(' uploaded successfully.','starter'));
        $count_real++;
      } else {
        message_error(__('There was error when uploading small image #','starter') . $i . ': ' .$errors);
      }
    }
  }

  $count_real = 0;
  for ($i=1; $i<=2000; $i++) {
    if(isset($_FILES['large' .$i]) and $_FILES['large' .$i]['name'] <> ''){
      $file_ext   = strtolower(end(explode('.', $_FILES['large' .$i]['name'])));
      $file_name  = $i . '.' . $file_ext;
      $file_tmp   = $_FILES['large' .$i]['tmp_name'];
      $file_type  = $_FILES['large' .$i]['type'];   
      $extensions = array("jpg");

      if(in_array($file_ext,$extensions )=== false) {
        $errors = __('extension not allowed, only allowed extension for large images is .jpg!','starter');
      }
				
      if(empty($errors)==true){
        move_uploaded_file($file_tmp, $upload_dir_large.$file_name);
        message_ok(__('Large image #','starter') . $i . __(' uploaded successfully.','starter'));
        $count_real++;
      } else {
        message_error(__('There was error when uploading large image #','starter') . $i . ': ' .$errors);
      }
    }
  }
}
?>




<div class="mb-body">
  <div class="mb-info-box" style="margin:5px 0 30px 0;">
    <div class="mb-line"><strong><?php _e('Plugins for this theme', 'starter'); ?></strong></div>
    <div class="mb-line"><?php _e('We have modified for you many plugins to fit theme design that will work without need of any modifications', 'starter'); ?>.</div>
    <div class="mb-line"><?php _e('Plugins are not delivered in theme package, must be downloaded separately', 'starter'); ?>.</div>
    <div class="mb-line" style="margin:10px 0;"><a href="https://osclasspoint.com/theme-plugins/starter_plugins_20180406_aa82fd.zip" target="_blank" class="mb-button-white"><i class="fa fa-download"></i> <?php _e('Download plugins', 'starter'); ?></a></div>
    <div class="mb-line" style="margin-top:15px;">- <?php _e('upload and extract downloaded file <strong>starter-plugins.zip</strong> into folder <strong>oc-content/plugins/</strong> on your hosting', 'starter'); ?>.</div>
    <div class="mb-line">- <?php _e('go to <strong>oc-admin > Plugins</strong> and install plugins you like', 'starter'); ?>.</div>
  </div>


  <!-- GENERAL -->
  <div class="mb-box">
    <div class="mb-head"><i class="fa fa-cog"></i> <?php _e('General settings', 'starter'); ?></div>

    <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/' . osc_current_web_theme() . '/admin/settings.php'); ?>" method="post">
      <input type="hidden" name="starter_general" value="done" />

      <div class="mb-inside">

        <div class="mb-info-box" style="margin:0 0 20px 0;">
          <div class="mb-line"><?php _e('Plugin generates backlink link added to footer.', 'starter'); ?></div>
          <div class="mb-line"><?php echo sprintf(__('You can use plugin for free with link in footer, or purchase "%s" for this product and disable link.', 'starter'), '<a target="_blank" href="https://osclasspoint.com/services/customer-services/remove-free-product-footer-link-i221">Link remover service</a>'); ?></div>
          <div class="mb-line" style="font-weight:bold;"><?php _e('Removal of link without link remover service purchased violates product license!', 'starter'); ?></div>
        </div>
        
        <?php
          $link_remover_order_id = osc_esc_html(osc_get_preference('link_remover_order_id', 'starter_theme'));
          $remove_footer_link = osc_get_preference('remove_footer_link', 'starter_theme');
        ?>

        <div class="mb-row">
          <label for="link_remover_order_id" class=""><span><?php _e('OsclassPoint Order Id', 'starter'); ?></span></label> 
          <input name="link_remover_order_id" size="20" type="text" value="<?php echo $link_remover_order_id; ?>" />

          <div class="mb-explain"><?php _e('Enter valid OsclassPoint order ID that contains "Link removal service" product.', 'starter'); ?></div>
        </div>
        
        
        <div class="mb-row <?php if($link_remover_order_id < 8000 || $link_remover_order_id > 500000) { ?>mb-disabled<?php } ?>">
          <label for="remove_footer_link" class=""><span><?php _e('Remove Backlink from Footer', 'starter'); ?></span></label> 
          <input name="remove_footer_link" type="checkbox" class="element-slide" <?php if($link_remover_order_id < 8000 || $link_remover_order_id > 100000) { ?>disabled<?php } ?> <?php echo ($remove_footer_link == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain">
            <div class="mb-link"><?php _e('When checked, footer backlink will be removed from footer. It require valid OsclassPoint order ID.', 'starter'); ?></div>
            <div class="mb-link"><?php _e('This plugin license allows to remove link just in case "Link remover service" was purchased for it.', 'starter'); ?></div>
            <div class="mb-link"><?php _e('By selecting this option to remove the link, you confirm that you have purchased the license removal service and that your saved order includes this service.', 'starter'); ?></div>
          </div>
        </div>
        
        
        <hr/>
        
        
        <div class="mb-row">
          <label for="publish_category" class="h21"><span><?php _e('Category Selection on Publish', 'starter'); ?></span></label> 
          <select name="publish_category" id="publish_category">
            <option value="1" <?php echo (osc_get_preference('publish_category', 'starter_theme') == "1" ? 'selected="selected"' : ''); ?>><?php _e('Flat selection (icons)', 'starter'); ?></option>
            <option value="2" <?php echo (osc_get_preference('publish_category', 'starter_theme') == "2" ? 'selected="selected"' : ''); ?>><?php _e('Cascading drop-downs', 'starter'); ?></option>
            <option value="3" <?php echo (osc_get_preference('publish_category', 'starter_theme') == "3" ? 'selected="selected"' : ''); ?>><?php _e('One select box', 'starter'); ?></option>
          </select>

          <div class="mb-explain"><?php _e('Select what type of category selection will be on publish page.', 'starter'); ?></div>
        </div>
       
        <div class="mb-row">
          <label for="search_cookies" class="h4"><span><?php _e('Save search parameters', 'starter'); ?></span></label> 
          <input name="search_cookies" id="search_cookies" class="element-slide" type="checkbox" <?php echo (osc_get_preference('search_cookies', 'starter_theme') == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('Enable to store search parameters in cookies.', 'starter'); ?></div>
        </div>
        
        <div class="mb-row">
          <label for="def_view" class="h5"><span><?php _e('Default View on Search Page', 'starter'); ?></span></label> 
          <select name="def_view" id="def_view">
            <option value="0" <?php echo (osc_get_preference('def_view', 'starter_theme') == 0 ? 'selected="selected"' : ''); ?>><?php _e('Gallery view', 'starter'); ?></option>
            <option value="1" <?php echo (osc_get_preference('def_view', 'starter_theme') == 1 ? 'selected="selected"' : ''); ?>><?php _e('List view', 'starter'); ?></option>
          </select>
        </div>


        <div class="mb-row">
          <label for="premium_home" class="h22"><span><?php _e('Show Premiums Block on Home', 'starter'); ?></span></label> 
          <input name="premium_home" id="premium_home" class="element-slide" type="checkbox" <?php echo (osc_get_preference('premium_home', 'starter_theme') == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('Show Premium Listings block on Home Page.', 'starter'); ?></div>
        </div>

        <div class="mb-row">
          <label for="premium_home_count" class="h23"><span><?php _e('Number of Premiums on Home', 'starter'); ?></span></label> 
          <input size="8" name="premium_home_count" id="premium_home_count" type="number" value="<?php echo osc_esc_html( osc_get_preference('premium_home_count', 'starter_theme') ); ?>" />

          <div class="mb-explain"><?php _e('How many premium listings will be shown on Home page.', 'starter'); ?></div>
        </div>

        <div class="mb-row">
          <label for="premium_search_list" class="h22"><span><?php _e('Show Premiums Block on Search - List', 'starter'); ?></span></label> 
          <input name="premium_search_list" id="premium_search_list" class="element-slide" type="checkbox" <?php echo (osc_get_preference('premium_search_list', 'starter_theme') == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('Show Premium Listings block on Search Page - List view.', 'starter'); ?></div>
        </div>

        <div class="mb-row">
          <label for="premium_search_list_count" class="h23"><span><?php _e('Number of Premiums on Search - List', 'starter'); ?></span></label> 
          <input size="8" name="premium_search_list_count" id="premium_search_list_count" type="number" value="<?php echo osc_esc_html( osc_get_preference('premium_search_list_count', 'starter_theme') ); ?>" />

          <div class="mb-explain"><?php _e('How many premium listings will be shown on Search page - List type.', 'starter'); ?></div>
        </div>

        <div class="mb-row">
          <label for="premium_search_gallery" class="h22"><span><?php _e('Show Premiums Block on Search - Gallery', 'starter'); ?></span></label> 
          <input name="premium_search_gallery" id="premium_search_gallery" class="element-slide" type="checkbox" <?php echo (osc_get_preference('premium_search_gallery', 'starter_theme') == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('Show Premium Listings block on Search Page - Gallery view.', 'starter'); ?></div>
        </div>

        <div class="mb-row">
          <label for="premium_search_gallery_count" class="h23"><span><?php _e('Number of Premiums on Search - Gallery', 'starter'); ?></span></label> 
          <input size="8" name="premium_search_gallery_count" id="premium_search_gallery_count" type="number" value="<?php echo osc_esc_html( osc_get_preference('premium_search_gallery_count', 'starter_theme') ); ?>" />

          <div class="mb-explain"><?php _e('How many premium listings will be shown on Search page - Gallery view.', 'starter'); ?></div>
        </div>

        
        <div class="mb-row">
          <label for="default_logo" class="h7"><span><?php _e('Use Default Logo', 'starter'); ?></span></label> 
          <input name="default_logo" id="default_logo" class="element-slide" type="checkbox" <?php echo (osc_get_preference('default_logo', 'starter_theme') == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('If you did not upload any logo yet, osclass default logo will be used.', 'starter'); ?></div>
        </div>
        
       
        <div class="mb-row">
          <label for="cat_icons" class="h9"><span><?php _e('Category Icons Type', 'starter'); ?></span></label> 
          <input name="cat_icons" id="cat_icons" class="element-slide" type="checkbox" <?php echo (osc_get_preference('cat_icons', 'starter_theme') == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('Check to ON if you want to use Font-Awesome icons instead of Small images for categories.', 'starter'); ?></div>
        </div>
        
        <div class="mb-row">
          <label for="item_images" class="h25"><span><?php _e('Number of Images Shown at Once', 'starter'); ?></span></label> 
          <input size="40" name="item_images" id="item_images" type="number" value="<?php echo osc_esc_html( osc_get_preference('item_images', 'starter_theme') ); ?>" />

          <div class="mb-explain"><?php _e('How many pictures will be shown at same time next to each other on Item page.', 'starter'); ?></div>
        </div>


        <div class="mb-row">
          <label for="format_cur" class="h13"><span><?php _e('Price Slider - Currency Position', 'starter'); ?></span></label> 
          <select name="format_cur" id="format_cur">
            <option value="0" <?php echo (osc_get_preference('format_cur', 'starter_theme') == 0 ? 'selected="selected"' : ''); ?>><?php _e('Before price', 'starter'); ?></option>
            <option value="1" <?php echo (osc_get_preference('format_cur', 'starter_theme') == 1 ? 'selected="selected"' : ''); ?>><?php _e('After price', 'starter'); ?></option>
            <option value="2" <?php echo (osc_get_preference('format_cur', 'starter_theme') == 2 ? 'selected="selected"' : ''); ?>><?php _e('Do not show', 'starter'); ?></option>
          </select>
        </div>

        <div class="mb-row">
          <label for="format_sep" class="h14"><span><?php _e('Price Slider - Thousands Separator', 'starter'); ?></span></label> 
          <select name="format_sep" id="format_sep">
            <option value="" <?php echo (osc_get_preference('format_sep', 'starter_theme') == '' ? 'selected="selected"' : ''); ?>><?php _e('None', 'starter'); ?></option>
            <option value="." <?php echo (osc_get_preference('format_sep', 'starter_theme') == '.' ? 'selected="selected"' : ''); ?>>.</option>
            <option value="," <?php echo (osc_get_preference('format_sep', 'starter_theme') == ',' ? 'selected="selected"' : ''); ?>>,</option>
            <option value=" " <?php echo (osc_get_preference('format_sep', 'starter_theme') == ' ' ? 'selected="selected"' : ''); ?>><?php _e('(blank)', 'starter'); ?></option>
          </select>
        </div>


        <div class="mb-row">
          <label for="latest_random" class="h16"><span><?php _e('Show Latest Items in Random Order', 'starter'); ?></span></label> 
          <input name="latest_random" id="latest_random" class="element-slide" type="checkbox" <?php echo (osc_get_preference('latest_random', 'starter_theme') == 1 ? 'checked' : ''); ?> />
        </div>

        <div class="mb-row">
          <label for="latest_picture" class="h17"><span><?php _e('Latest Items Picture Only', 'starter'); ?></span></label> 
          <input name="latest_picture" id="latest_picture" class="element-slide" type="checkbox" <?php echo (osc_get_preference('latest_picture', 'starter_theme') == 1 ? 'checked' : ''); ?> />
        </div>

        <div class="mb-row">
          <label for="latest_premium" class="h18"><span><?php _e('Latest Premium Items', 'starter'); ?></span></label> 
          <input name="latest_premium" id="latest_premium" class="element-slide" type="checkbox" <?php echo (osc_get_preference('latest_premium', 'starter_theme') == 1 ? 'checked' : ''); ?> />
        </div>

        <div class="mb-row">
          <label for="latest_category" class="h19"><span><?php _e('Category for Latest Items', 'starter'); ?></span></label> 
          <select name="latest_category" id="latest_category">
            <option value="" <?php echo (osc_get_preference('latest_category', 'starter_theme') == '' ? 'selected="selected"' : ''); ?>><?php _e('All categories', 'starter'); ?></option>

            <?php while(osc_has_categories()) { ?>
              <option value="<?php echo osc_category_id(); ?>" <?php echo (osc_get_preference('latest_category', 'starter_theme') == osc_category_id() ? 'selected="selected"' : ''); ?>><?php echo osc_category_name(); ?></option>
            <?php } ?>
          </select>
        </div>


        <div class="mb-row">
          <label for="search_ajax" class="h30"><span><?php _e('Live Search using Ajax', 'starter'); ?></span></label> 
          <input name="search_ajax" id="search_ajax" class="element-slide" type="checkbox" <?php echo (osc_get_preference('search_ajax', 'starter_theme') == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('Enable live realtime search without reloading of search page.', 'starter'); ?></div>
        </div>

        <div class="mb-row">
          <label for="forms_ajax" class="h31"><span><?php _e('Form submit without reload (Ajax)', 'starter'); ?></span></label> 
          <input name="forms_ajax" id="forms_ajax" class="element-slide" type="checkbox" <?php echo (osc_get_preference('forms_ajax', 'starter_theme') == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('Contact seller, Add new comment & Send to friend forms will be submitted without page reload.', 'starter'); ?></div>
        </div>

        <div class="mb-row">
          <label for="post_required" class="h32"><span><?php _e('Required Fields on Publish', 'starter'); ?></span></label> 
          <input size="40" name="post_required" id="post_required" type="text" value="<?php echo osc_esc_html( osc_get_preference('post_required', 'starter_theme') ); ?>" placeholder="<?php echo osc_esc_html(__('Enter required fields delimited by comma', 'starter')); ?>" />

          <div class="mb-explain"><?php _e('Allowed fields: location, country, region, city, name, phone. Example: Enter into input: location,name - to get location and user name required', 'starter'); ?></div>
        </div>

        <div class="mb-row">
          <label for="post_extra_exclude" class="h33"><span><?php _e('Extra Fields exclude Categories', 'starter'); ?></span></label> 
          <input size="40" name="post_extra_exclude" id="post_extra_exclude" type="text" value="<?php echo osc_esc_html( osc_get_preference('post_extra_exclude', 'starter_theme') ); ?>" placeholder="<?php echo osc_esc_html(__('Enter category IDs delimited by comma', 'starter')); ?>" />
  
          <div class="mb-explain"><?php _e('Enter ID of categories where you do not want to show Transaction, Condition and Status on Item Publish/Edit page', 'starter'); ?></div>
        </div>

      </div>

      <div class="mb-foot">
        <button type="submit" class="mb-button"><?php _e('Save', 'starter');?></button>
      </div>
    </form>
  </div>



  <!-- BANNERS -->
  <div class="mb-box">
    <div class="mb-head"><i class="fa fa-clone"></i> <?php _e('Banner settings', 'starter'); ?></div>

    <form action="<?php echo osc_admin_render_theme_url('oc-content/themes/' . osc_current_web_theme() . '/admin/settings.php'); ?>" method="post">
      <input type="hidden" name="starter_banner" value="done" />

      <div class="mb-inside">
        <div class="mb-row">
          <label for="theme_adsense" class="h28"><span><?php _e('Enable Google Adsense Banners', 'starter'); ?></span></label> 
          <input name="theme_adsense" id="theme_adsense" class="element-slide" type="checkbox" <?php echo (osc_get_preference('theme_adsense', 'starter_theme') == 1 ? 'checked' : ''); ?> />

          <div class="mb-explain"><?php _e('When enabled, bellow banners will be shown in front page.', 'starter'); ?></div>
        </div>
        
        <?php foreach(starter_banner_list() as $b) { ?>
          <div class="mb-row">
            <label for="<?php echo $b['id']; ?>" class="h29"><span><?php echo ucwords(str_replace('_', ' ', $b['id'])); ?></span></label> 
            <textarea class="mb-textarea mb-textarea-large" name="<?php echo $b['id']; ?>" placeholder="<?php echo osc_esc_html(__('Will be shown', 'starter')); ?>: <?php echo $b['position']; ?>"><?php echo stripslashes( osc_get_preference($b['id'], 'starter_theme') ); ?></textarea>
          </div>
        <?php } ?>
      </div>

      <div class="mb-foot">
        <button type="submit" class="mb-button"><?php _e('Save', 'starter');?></button>
      </div>
    </form>
  </div>



  <!-- CATEGORY ICONS -->
  <div class="mb-box">
    <div class="mb-head"><i class="fa fa-photo"></i> <?php _e('Category icons settings', 'starter'); ?></div>

    <form name="promo_form" id="load_image" action="<?php echo osc_admin_render_theme_url('oc-content/themes/' . osc_current_web_theme() . '/admin/settings.php'); ?>" method="POST" enctype="multipart/form-data" >
      <input type="hidden" name="starter_images" value="done" />

      <div class="mb-inside">
        <div class="mb-table">
          <div class="mb-table-head">
            <div class="mb-col-1_2 id"><?php _e('ID', 'starter'); ?></div>
            <div class="mb-col-2_1_2 mb-align-left name"><?php _e('Name', 'starter'); ?></div>
            <div class="mb-col-1_1_2 icon"><?php _e('Has small image', 'starter'); ?></div>
            <div class="mb-col-1_1_2"><?php _e('Small image (50x30px - png)', 'starter'); ?></div>
            <div class="mb-col-1_1_2 icon"><?php _e('Has large image', 'starter'); ?></div>
            <div class="mb-col-1_1_2"><?php _e('Large image (150x250px - jpg)', 'starter'); ?></div>
            <div class="mb-col-1_1_2 mb-align-left fa-icon"><a href="//fortawesome.github.io/Font-Awesome/icons/" target="_blank"><?php _e('Font-Awesome icon', 'starter'); ?></a></div>
            <div class="mb-col-1_1_2 mb-align-left color"><?php _e('Color', 'starter'); ?></div>
          </div>

          <?php starter_has_subcategories_special(Category::newInstance()->toTree(),  0); ?> 
        </div>
      </div>

      <div class="mb-foot">
        <button type="submit" class="mb-button"><?php _e('Save', 'starter');?></button>
      </div>
    </form>
  </div>



  <!-- HELP TOPICS -->
  <div class="mb-box" id="mb-help">
    <div class="mb-head"><i class="fa fa-question-circle"></i> <?php _e('Help', 'starter'); ?></div>

    <div class="mb-inside">
      <div class="mb-row mb-help"><span class="sup">(1)</span> <div class="h1"><?php _e('Leave blank to disable contact number. This number will be shown in theme header.', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(2)</span> <div class="h2"><?php _e('Website name can be used in user menu and footer of website.', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(3)</span> <div class="h3"><?php _e('Choose which currency you want to show in search menu on category/search page.', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(4)</span> <div class="h4"><?php _e('When enabled, search parameters are stored in browser cookies so when user go back to search page, lately used parameters are restored. Following parameters are stored: Category, Country, Region, City, Gallery/List view.', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(5)</span> <div class="h5"><?php _e('Select default view type for users. Listings can be shown in grid or as list. User can change view to prefered one. Note that this setting is valid for search page only.', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(6)</span> <div class="h6"><?php _e('I want to help OSClass & MB themes by linking to <a href="https://osclasspoint.com" target="_blank">OsclassPoint.com</a> from my site', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(7)</span> <div class="h7"><?php _e('Show default logo in case you didn\'t upload one previously.', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(9)</span> <div class="h9"><?php _e('Use FontAwesome icons instead of small image icons for categories on homepage', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(10)</span> <div class="h10"><?php _e('Email that will be shown in footer', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(12)</span> <div class="h12"><?php _e('Show photo thumbnails on listing page under image slide show (pager).', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(13)</span> <div class="h13"><?php _e('Choose position of currency symbol in price slider on search page.', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(14)</span> <div class="h14"><?php _e('Choose if you want to use thousand separator in price slider on search page.', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(16)</span> <div class="h16"><?php _e('Check if you want to show latest items on homepage in random order. Everytime you refresh your homepage, listings will be shuffled in random order.', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(17)</span> <div class="h17"><?php _e('Check if you want to show in latest items section on homepage only listings with picture.', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(18)</span> <div class="h18"><?php _e('Check if you want to show in latest items section on homepage only premium listings. When enabled, it helps to promote premium listings on your site and get more value for them.', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(19)</span> <div class="h19"><?php _e('Choose category from which latest items on homepage will be selected. You can choose All categories if you want to show all listings no matter in what category it is.', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(19)</span> <div class="h19"><?php _e('Write description of your classifieds that will be shown in footer.', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(20)</span> <div class="h20"><?php _e('On mobile devices, logo is not shown. Instead logo text is shown, you can set it as your site name or anything else. Max length is 12 characters.', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(21)</span> <div class="h21"><?php _e('It is recommended to use default Flat category selection type for best user experience.', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(22)</span> <div class="h22"><?php _e('Enable premium listings block on Home/Search page (List / Gallery view). For search page it is recommended to show this block only in case you have more than 1000 listings. Otherwise it may look that premium listings are duplicated. If there are no premiums, this block will be hidden.', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(23)</span> <div class="h23"><?php _e('Enter how many premium listings should be shown in Premiums block.', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(24)</span> <div class="h24"><?php _e('Show or hide large "welcome" search block on homepage..', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(25)</span> <div class="h25"><?php _e('Set how many pictures is shown next to each other on item page. Note that on mobile & tablet devices will be shown juts 1 picture no matter of this setting. Note that if listing contain less then entered amount of pictures, this number will be used.', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(26)</span> <div class="h26"><?php _e('When scrolling up and down, sidebar will be on fixed position - visible in each situation.', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(27)</span> <div class="h27"><?php _e('Enable item ajax search for listings that match entered keyword. Available on homepage only. Search works via wildcard in title & description (in current language) of item.', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(28)</span> <div class="h28"><?php _e('Check if you want to enable Google Adsense banners on your site. You can define code for banner in bellow boxes.', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(29)</span> <div class="h29"><?php _e('Will be shown at specified position. Use responsive banners.', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(30)</span> <div class="h30"><?php _e('Enable item ajax search for listings that match entered keyword. Available on homepage only. Search works via wildcard in title & description (in current language) of item.', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(31)</span> <div class="h31"><?php _e('When enabled, Contact seller form (item / public profile), Add new comment form and Send to friend form will be submitted without page reload using Ajax.', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(32)</span> <div class="h32"><?php _e('Enter which fields should be required on item publish/edit. Note that these are extra fields, original cannot be changed (title, category, email, ...). Enter them separated by comma. Possible values: location - it is required to enter location of item; name - name of seller is required; phone - seller is required to enter phone number;', 'starter'); ?></div></div>
      <div class="mb-row mb-help"><span class="sup">(33)</span> <div class="h33"><?php _e('Enter ID of categories where you want to disable using Transaction, Condition and Status fields. Note that you need to enter IDs of each category. If you enter ID just for parent category, in subcategories these fields will be still visible. List all categories & subcategories where it should be hidden. Delimit with comma, example: 1,2,5,7', 'starter'); ?></div></div>

      <div class="mb-row mb-help"><div><?php _e('To change favicon, remove and upload yours into folder oc-content/themes/starter/images/favicons/. If you do not have specific size of favicon, just remove image. Keep naming of files!', 'starter'); ?></div></div>

    </div>
  </div>
</div>

<?php echo starter_footer(); ?>	