<?php osc_goto_first_locale(); ?>

<header>
  <div class="inside">
    <div class="relative2">
      <div class="left">
        <div class="logo">
          <a href="<?php echo osc_base_url(); ?>"><?php echo gam_logo(); ?></a>
        </div>

        <a href="#" class="categories isDesktop isTablet">
          <span><?php _e('Categories', 'gamma'); ?></span>
          <span class="svg"><svg viewBox="0 0 32 32" color="#363433" width="16" height="16"><defs><path id="mbIconAngle" d="M12.147 25.2c-.462 0-.926-.185-1.285-.556L.57 14.024A2.05 2.05 0 010 12.586c0-.543.206-1.061.571-1.436L10.864.553a1.765 1.765 0 012.62.06c.71.795.683 2.057-.055 2.817l-8.9 9.16 8.902 9.183c.738.76.761 2.024.052 2.815a1.78 1.78 0 01-1.336.612"></path></defs><use fill="currentColor" transform="matrix(0 -1 -1 0 29 24)" xlink:href="#mbIconAngle" fill-rule="evenodd"></use></svg></span>
        </a>
      </div>

      <?php if(osc_is_web_user_logged_in()) { ?>
        <div class="user-menu">
          <div class="ins">
            <strong><?php echo osc_logged_user_name(); ?></strong>

            <div class="line"></div>

            <a href="<?php echo osc_user_list_items_url(); ?>"><?php _e('My listings', 'gamma'); ?></a>
            <a href="<?php echo osc_user_profile_url(); ?>"><?php _e('Profile', 'gamma'); ?></a>
            <a href="<?php echo osc_user_alerts_url(); ?>"><?php _e('Alerts', 'gamma'); ?></a>

            <?php if(function_exists('fi_make_favorite')) { ?>
              <a href="<?php echo osc_route_url('favorite-lists'); ?>"><?php _e('Favorite items', 'gamma'); ?></a>
            <?php } ?>

            <?php if(function_exists('im_messages')) { ?>
              <a href="<?php echo osc_route_url('im-threads'); ?>"><?php _e('Messages', 'gamma'); ?></a>
            <?php } ?>


            <div class="line"></div>

            <a class="logout" href="<?php echo osc_user_logout_url(); ?>"><?php _e('Log out', 'gamma'); ?></a>
          </div>
        </div> 
      <?php } ?>

      <div class="right isDesktop isTablet">
         
        <?php if(!osc_is_web_user_logged_in()) { ?>
          <a class="login" href="<?php echo osc_user_login_url(); ?>">
            <span class="svg"><svg viewBox="0 0 32 32" color="#696766" width="20" height="20"><defs><path id="mbIconSignin" d="M16 30c-4.992 0-8.737-1.527-11.094-4.413 2.362-.829 6.498-1.35 10.946-1.35 5.194 0 9.137.674 11.169 1.433C24.66 28.5 20.942 30 16 30m0-28c9.028 0 14 4.972 14 14 0 3.181-.63 5.847-1.824 7.98-2.5-1.082-7.106-1.743-12.324-1.743-5.007 0-9.531.631-12.077 1.653C2.613 21.771 2 19.136 2 16 2 6.972 6.972 2 16 2m0-2C5.832 0 0 5.832 0 16s5.832 16 16 16 16-5.832 16-16S26.168 0 16 0m0 8.37a4.568 4.568 0 014.563 4.562A4.568 4.568 0 0116 17.495a4.568 4.568 0 01-4.563-4.563A4.568 4.568 0 0116 8.37m0 11.126a6.57 6.57 0 01-6.563-6.563A6.57 6.57 0 0116 6.37a6.57 6.57 0 016.563 6.563A6.57 6.57 0 0116 19.495zm-.027-4.008a3.17 3.17 0 003.057-2.343h-6.115a3.17 3.17 0 003.058 2.343z"></path></defs><use fill="currentColor" xlink:href="#mbIconSignin" fill-rule="evenodd"></use></svg></span>
            <span class="txt"><?php _e('Sign up', 'gamma'); ?></span>
          </a>
        <?php } else { ?>
          <a class="my-account" href="<?php echo osc_user_dashboard_url(); ?>">
            <span class="svg"><svg viewBox="0 0 32 32" color="#696766" width="20" height="20"><defs><path id="mbIconSignin" d="M16 30c-4.992 0-8.737-1.527-11.094-4.413 2.362-.829 6.498-1.35 10.946-1.35 5.194 0 9.137.674 11.169 1.433C24.66 28.5 20.942 30 16 30m0-28c9.028 0 14 4.972 14 14 0 3.181-.63 5.847-1.824 7.98-2.5-1.082-7.106-1.743-12.324-1.743-5.007 0-9.531.631-12.077 1.653C2.613 21.771 2 19.136 2 16 2 6.972 6.972 2 16 2m0-2C5.832 0 0 5.832 0 16s5.832 16 16 16 16-5.832 16-16S26.168 0 16 0m0 8.37a4.568 4.568 0 014.563 4.562A4.568 4.568 0 0116 17.495a4.568 4.568 0 01-4.563-4.563A4.568 4.568 0 0116 8.37m0 11.126a6.57 6.57 0 01-6.563-6.563A6.57 6.57 0 0116 6.37a6.57 6.57 0 016.563 6.563A6.57 6.57 0 0116 19.495zm-.027-4.008a3.17 3.17 0 003.057-2.343h-6.115a3.17 3.17 0 003.058 2.343z"></path></defs><use fill="currentColor" xlink:href="#mbIconSignin" fill-rule="evenodd"></use></svg></span>
            <span class="txt"><?php _e('My account', 'gamma'); ?></span>
          </a>
        <?php } ?>

        <a class="search <?php if(osc_is_search_page()) { ?>actv<?php } ?>" href="<?php echo osc_search_url(array('page' => 'search')); ?>">
          <span class="svg"><svg viewBox="0 0 32 32" color="#696766" width="20" height="20"><defs><path id="mbIconSearch" d="M12.618 23.318c-6.9 0-10.7-3.8-10.7-10.7 0-6.9 3.8-10.7 10.7-10.7 6.9 0 10.7 3.8 10.7 10.7 0 3.458-.923 6.134-2.745 7.955-1.821 1.822-4.497 2.745-7.955 2.745zm17.491 5.726l-7.677-7.678c1.854-2.155 2.804-5.087 2.804-8.748C25.236 4.6 20.636 0 12.618 0S0 4.6 0 12.618c0 8.019 4.6 12.618 12.618 12.618 3.485 0 6.317-.85 8.44-2.531l7.696 7.695 1.355-1.356z"></path></defs><use fill="currentColor" xlink:href="#mbIconSearch" fill-rule="evenodd"></use></svg></span>
          <span class="txt"><?php _e('Search', 'gamma'); ?></span>
        </a>

        <a class="publish2 isMobile <?php if(osc_is_publish_page() || osc_is_edit_page()) { ?>actv<?php } ?>" href="<?php echo osc_item_post_url(); ?>">
          <span class="svg"><svg viewBox="0 0 32 32" color="#696766" width="20" height="20"><defs><path id="mbIconAdd" d="M17.125 14.875h6.749c.622 0 1.126.5 1.126 1.125 0 .621-.5 1.125-1.126 1.125h-6.749v6.749c0 .622-.5 1.126-1.125 1.126-.621 0-1.125-.5-1.125-1.126v-6.749H8.126C7.504 17.125 7 16.625 7 16c0-.621.5-1.125 1.126-1.125h6.749V8.126c0-.622.5-1.126 1.125-1.126.621 0 1.125.5 1.125 1.126v6.749zM29.779 25.28l-.125.185c-.079.13-.169.249-.252.375l-.061.09-.025.032c-.316.467-.662.907-1.032 1.322l-.073.082c-1.171 1.29-2.598 2.327-4.274 3.087l-.009.005a15.64 15.64 0 01-1.622.618c-.113.037-.228.069-.341.103-.463.138-.94.259-1.432.362-.162.035-.324.069-.49.1a20.74 20.74 0 01-1.462.207c-.175.019-.343.045-.52.06-.667.057-1.351.092-2.061.092-.715 0-1.403-.036-2.074-.093-.186-.016-.364-.043-.545-.063a20.722 20.722 0 01-1.447-.208c-.178-.032-.352-.07-.527-.107a17.577 17.577 0 01-1.409-.361c-.126-.038-.253-.073-.376-.114-1.789-.585-3.347-1.44-4.657-2.549-.04-.033-.077-.069-.117-.104a12.57 12.57 0 01-1.116-1.098l-.144-.162a12.867 12.867 0 01-1.004-1.322c-.008-.011-.018-.021-.025-.033l-.027-.04c-.067-.104-.138-.205-.204-.312l-.263-.402.031-.024C.729 22.575 0 19.561 0 16 0 5.832 5.832 0 16 0s16 5.832 16 16c0 3.684-.775 6.79-2.235 9.264l.014.016zm-1.722-1.16l-.013-.014C29.322 21.941 30 19.223 30 16c0-8.897-5.103-14-14-14S2 7.103 2 16c0 3.116.638 5.753 1.834 7.882l-.027.021.23.352c.058.093.12.182.178.273l.024.035c.006.01.015.019.022.029.27.408.564.792.878 1.156l.127.142c.306.34.63.662.976.96.035.031.067.063.102.092 1.147.97 2.51 1.718 4.075 2.23.108.036.219.067.33.1.397.12.809.226 1.232.316.153.032.306.066.461.093.41.076.834.134 1.266.182.159.018.315.042.477.056.587.05 1.19.081 1.815.081.621 0 1.22-.03 1.803-.08.155-.014.302-.036.455-.053a18.17 18.17 0 001.28-.181c.145-.027.287-.057.428-.088.43-.09.848-.196 1.253-.316.1-.03.2-.058.299-.09a13.84 13.84 0 001.419-.541l.008-.005a11.294 11.294 0 003.74-2.7l.064-.073c.323-.363.626-.748.902-1.156l.022-.028.054-.079c.072-.11.151-.214.22-.328l.11-.162z"></path></defs><use fill="currentColor" xlink:href="#mbIconAdd" fill-rule="evenodd"></use></svg></span>
          <span class="txt"><?php _e('Post an ad', 'gamma'); ?></span>
        </a>


        <?php if(function_exists('blg_home_link')) { ?>
          <a class="blog" href="<?php echo blg_home_link(); ?>">
            <span class="svg"><svg viewBox="0 0 1024 1024" color="#696766" width="20" height="20"><defs><path id="mbIconBlog" d="M978.101 45.898c-28.77-28.768-67.018-44.611-107.701-44.611-40.685 0-78.933 15.843-107.701 44.611l-652.8 652.8c-2.645 2.645-4.678 5.837-5.957 9.354l-102.4 281.6c-3.4 9.347-1.077 19.818 5.957 26.85 4.885 4.888 11.43 7.499 18.104 7.499 2.933 0 5.891-0.502 8.744-1.541l281.6-102.4c3.515-1.28 6.709-3.312 9.354-5.958l652.8-652.8c28.768-28.768 44.613-67.018 44.613-107.702s-15.843-78.933-44.613-107.701zM293.114 873.883l-224.709 81.71 81.712-224.707 566.683-566.683 142.997 142.997-566.683 566.683zM941.899 225.098l-45.899 45.899-142.997-142.997 45.899-45.899c19.098-19.098 44.49-29.614 71.498-29.614s52.4 10.518 71.499 29.616c19.098 19.098 29.616 44.49 29.616 71.498s-10.52 52.4-29.616 71.498z"></path></defs><use fill="currentColor" xlink:href="#mbIconBlog" fill-rule="evenodd" transform="translate(0 4)"></use></svg></span>
            <span class="txt"><?php _e('Blog', 'gamma'); ?></span>
          </a>
        <?php } ?>

        <?php if(function_exists('bpr_companies_url')) { ?>
          <a class="company" href="<?php echo bpr_companies_url(); ?>">
            <span class="svg"><svg viewBox="0 0 1024 1024" color="#696766" width="20" height="20"><defs><path id="mbIconCompanies" d="M947.2 256h-230.4v-76.8c0-42.347-34.453-76.8-76.8-76.8h-256c-42.347 0-76.8 34.453-76.8 76.8v76.8h-230.4c-42.347 0-76.8 34.453-76.8 76.8v563.2c0 42.349 34.453 76.8 76.8 76.8h870.4c42.349 0 76.8-34.451 76.8-76.8v-563.2c0-42.347-34.451-76.8-76.8-76.8zM358.4 179.2c0-14.115 11.485-25.6 25.6-25.6h256c14.115 0 25.6 11.485 25.6 25.6v76.8h-307.2v-76.8zM76.8 307.2h870.4c14.115 0 25.6 11.485 25.6 25.6v384h-102.4v-25.6c0-14.139-11.461-25.6-25.6-25.6h-102.4c-14.139 0-25.6 11.461-25.6 25.6v25.6h-409.6v-25.6c0-14.139-11.462-25.6-25.6-25.6h-102.4c-14.138 0-25.6 11.461-25.6 25.6v25.6h-102.4v-384c0-14.115 11.485-25.6 25.6-25.6zM819.2 716.8v51.2h-51.2v-51.2h51.2zM256 716.8v51.2h-51.2v-51.2h51.2zM947.2 921.6h-870.4c-14.115 0-25.6-11.485-25.6-25.6v-128h102.4v25.6c0 14.139 11.462 25.6 25.6 25.6h102.4c14.138 0 25.6-11.461 25.6-25.6v-25.6h409.6v25.6c0 14.139 11.461 25.6 25.6 25.6h102.4c14.139 0 25.6-11.461 25.6-25.6v-25.6h102.4v128c0 14.115-11.485 25.6-25.6 25.6z"></path></defs><use fill="currentColor" xlink:href="#mbIconCompanies" fill-rule="evenodd" transform="translate(0 4)"></use></svg></span>
            <span class="txt"><?php _e('Companies', 'gamma'); ?></span>
          </a>
        <?php } ?>

        <?php if(function_exists('frm_home')) { ?>
          <a class="forum" href="<?php echo frm_home(); ?>">
            <span class="svg"><svg viewBox="0 0 1024 1024" color="#696766" width="20" height="20"><defs><path id="mbIconForums" d="M25.6 972.8c-11.507 0-21.6-7.677-24.67-18.766s1.634-22.864 11.501-28.784c86.57-51.942 122.485-127.414 135.218-162.755-94.088-72.048-147.648-171.746-147.648-276.094 0-52.704 13.23-103.755 39.323-151.736 24.902-45.794 60.406-86.806 105.526-121.899 91.504-71.17 212.802-110.365 341.55-110.365s250.046 39.195 341.552 110.366c45.118 35.093 80.624 76.104 105.526 121.899 26.091 47.979 39.322 99.030 39.322 151.734 0 52.702-13.23 103.755-39.322 151.736-24.902 45.794-60.408 86.806-105.526 121.899-91.506 71.17-212.803 110.365-341.552 110.365-52.907 0-104.8-6.627-154.437-19.707-21.974 14.637-63.040 40.605-112.086 65.005-76.163 37.89-141.528 57.102-194.277 57.102zM486.4 153.6c-239.97 0-435.2 149.294-435.2 332.8 0 92.946 51.432 182.379 141.107 245.368 8.797 6.178 12.795 17.194 10.013 27.576-5.984 22.325-26.363 83.597-80.878 142.734 66.659-23.341 138.424-63.832 191.434-100.286 6.296-4.328 14.197-5.621 21.544-3.52 48.558 13.888 99.691 20.928 151.981 20.928 239.97 0 435.2-149.294 435.2-332.8s-195.23-332.8-435.2-332.8z"></path></defs><use fill="currentColor" xlink:href="#mbIconForums" fill-rule="evenodd" transform="translate(0 4)"></use></svg></span>
            <span class="txt"><?php _e('Forums', 'gamma'); ?></span>
          </a>
        <?php } ?>


        <?php if(function_exists('fi_make_favorite')) { ?>
          <a class="favorite" href="<?php echo osc_route_url('favorite-lists'); ?>">
            <span class="svg"><svg viewBox="0 0 32 32" color="#696766" width="20" height="20"><defs><path id="mbIconFavorite" d="M6.997 1.998c-1.346 0-2.548.436-3.493 1.339-2.73 2.608-1.676 7.529 2.562 11.965 2.743 2.87 8.259 6.21 9.934 7.192 1.675-.982 7.193-4.323 9.933-7.192 4.24-4.436 5.292-9.357 2.563-11.965C25.784.746 20.94 1.997 16.72 6.382L16 7.13l-.72-.748c-2.75-2.857-5.766-4.384-8.283-4.384zM16 24.8l-.492-.28c-.303-.171-7.445-4.234-10.887-7.837-5.052-5.287-6.08-11.37-2.499-14.792C5.516-1.348 11.124-.343 16 4.281c4.875-4.624 10.485-5.63 13.878-2.39 3.58 3.421 2.553 9.505-2.499 14.792-3.442 3.603-10.584 7.666-10.887 7.838L16 24.8z"></path></defs><use fill="currentColor" xlink:href="#mbIconFavorite" fill-rule="evenodd" transform="translate(0 4)"></use></svg></span>
            <span class="txt"><?php _e('Favorite', 'gamma'); ?></span>

            <?php $fav_counter = gem_count_favorite(); ?>
            <?php if($fav_counter > 0) { ?>
              <span class="counter mbBg3"><?php echo $fav_counter; ?></span>
            <?php } ?>
          </a>
        <?php } ?>


        <?php if(function_exists('im_messages') && osc_is_web_user_logged_in()) { ?>
          <a class="messages" href="<?php echo osc_route_url('im-threads'); ?>">
            <span class="svg"><svg viewBox="0 0 32 32" color="#696766" width="20" height="20"><defs><path id="mbIconMessage" d="M16 0c10.168 0 16 4.647 16 12.75 0 5.301-2.483 9.167-7.183 11.186l-10.38 7.408 1.34-5.847C5.748 25.43.002 20.792.002 12.75 0 4.647 5.83 0 16 0zm7.938 22.137C27.959 20.444 30 17.285 30 12.75 30 5.817 25.029 2 16 2 6.973 2 2 5.817 2 12.75c0 6.931 4.973 10.748 14 10.748.34 0 .674-.007 1.003-.018l1.297-.043-.736 3.22 6.373-4.52zM11 16v-2h10v2H11zm0-5V9h10v2H11z"></path></defs><use fill="currentColor" xlink:href="#mbIconMessage" fill-rule="evenodd"></use></svg></span>
            <span class="txt"><?php _e('Messages', 'gamma'); ?></span>

            <?php 
              if(osc_is_web_user_logged_in()) {
                $message_count = ModelIM::newInstance()->countMessagesByUserId( osc_logged_user_id() );
                $message_count = $message_count['i_count'];
              } else {
                $message_count = 0;
              }
            ?>

            <?php if($message_count > 0) { ?>
              <span class="counter mbBg3"><?php echo $message_count; ?></span>
            <?php } ?>
          </a>
        <?php } ?>


        <a class="publish btn mbBg2 isDesktop isTablet" href="<?php echo osc_item_post_url(); ?>">
          <svg viewBox="0 0 32 32" color="#ffffff" width="16" height="16"><defs><path id="mbIconAdd" d="M17.125 14.875h6.749c.622 0 1.126.5 1.126 1.125 0 .621-.5 1.125-1.126 1.125h-6.749v6.749c0 .622-.5 1.126-1.125 1.126-.621 0-1.125-.5-1.125-1.126v-6.749H8.126C7.504 17.125 7 16.625 7 16c0-.621.5-1.125 1.126-1.125h6.749V8.126c0-.622.5-1.126 1.125-1.126.621 0 1.125.5 1.125 1.126v6.749zM29.779 25.28l-.125.185c-.079.13-.169.249-.252.375l-.061.09-.025.032c-.316.467-.662.907-1.032 1.322l-.073.082c-1.171 1.29-2.598 2.327-4.274 3.087l-.009.005a15.64 15.64 0 01-1.622.618c-.113.037-.228.069-.341.103-.463.138-.94.259-1.432.362-.162.035-.324.069-.49.1a20.74 20.74 0 01-1.462.207c-.175.019-.343.045-.52.06-.667.057-1.351.092-2.061.092-.715 0-1.403-.036-2.074-.093-.186-.016-.364-.043-.545-.063a20.722 20.722 0 01-1.447-.208c-.178-.032-.352-.07-.527-.107a17.577 17.577 0 01-1.409-.361c-.126-.038-.253-.073-.376-.114-1.789-.585-3.347-1.44-4.657-2.549-.04-.033-.077-.069-.117-.104a12.57 12.57 0 01-1.116-1.098l-.144-.162a12.867 12.867 0 01-1.004-1.322c-.008-.011-.018-.021-.025-.033l-.027-.04c-.067-.104-.138-.205-.204-.312l-.263-.402.031-.024C.729 22.575 0 19.561 0 16 0 5.832 5.832 0 16 0s16 5.832 16 16c0 3.684-.775 6.79-2.235 9.264l.014.016zm-1.722-1.16l-.013-.014C29.322 21.941 30 19.223 30 16c0-8.897-5.103-14-14-14S2 7.103 2 16c0 3.116.638 5.753 1.834 7.882l-.027.021.23.352c.058.093.12.182.178.273l.024.035c.006.01.015.019.022.029.27.408.564.792.878 1.156l.127.142c.306.34.63.662.976.96.035.031.067.063.102.092 1.147.97 2.51 1.718 4.075 2.23.108.036.219.067.33.1.397.12.809.226 1.232.316.153.032.306.066.461.093.41.076.834.134 1.266.182.159.018.315.042.477.056.587.05 1.19.081 1.815.081.621 0 1.22-.03 1.803-.08.155-.014.302-.036.455-.053a18.17 18.17 0 001.28-.181c.145-.027.287-.057.428-.088.43-.09.848-.196 1.253-.316.1-.03.2-.058.299-.09a13.84 13.84 0 001.419-.541l.008-.005a11.294 11.294 0 003.74-2.7l.064-.073c.323-.363.626-.748.902-1.156l.022-.028.054-.079c.072-.11.151-.214.22-.328l.11-.162z"></path></defs><use fill="currentColor" xlink:href="#mbIconAdd" fill-rule="evenodd"></use></svg>
          <span><?php _e('Post an ad', 'gamma'); ?></span>
        </a>
      </div>   

      <div class="mobile-block isMobile">
        <a href="#" id="m-options" class="mobile-menu" data-menu-id="#menu-options">
          <div class="inr">
            <span class="ln ln1"></span>
            <span class="ln ln2"></span>
            <span class="ln ln3"></span>
          </div>
        </a>

        <a href="#" id="m-search" class="mobile-menu" data-menu-id="#menu-search">
          <div class="inr">
            <span class="ln ln1"></span>
            <span class="ln ln3"></span>
            <span class="rd"></span>
            <span class="cd"></span>
          </div>
        </a>
      </div>
    </div>
  </div>


  <!-- CATEGORIES BOX -->
  <?php $search_params = gam_search_params_all(); ?>

  <div id="cat-box">
    <div class="inside">

      <div class="box">
        <?php osc_goto_first_category(); ?>
        <?php while(osc_has_categories()) { ?>
          <?php 
            $search_params['sCategory'] = osc_category_id(); 
            $color = gam_get_cat_color(osc_category_id());
          ?>
   
          <a href="<?php echo osc_search_url($search_params); ?>" class="cat1">
            <div>
              <?php if(gam_param('cat_icons') == 1) { ?>
                <i class="fas <?php echo gam_get_cat_icon(osc_category_id(), true); ?>" <?php if($color <> '') { ?>style="color:<?php echo $color; ?>;"<?php } ?>></i>
              <?php } else { ?>
                <img src="<?php echo osc_current_web_theme_url();?>images/small_cat/<?php echo osc_category_id();?>.png" />
              <?php } ?>
            </div>

            <h3><?php echo osc_category_name(); ?></h3>
          </a>
          
          <div class="sub-box">
            <?php while(osc_has_subcategories()) { ?>
              <?php $search_params['sCategory'] = osc_category_id(); ?>
              <div class="link"><a href="<?php echo osc_search_url($search_params); ?>" class="cat2"><?php echo osc_category_name(); ?></a></div>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>

</header>

<div class="header-search-mobile" id="menu-search" style="display:none;">
  <form action="<?php echo osc_base_url(true); ?>" method="get" class="nocsrf" >
    <input type="hidden" name="page" value="search" />

    <input type="text" name="sPattern" value="<?php echo osc_esc_html(osc_search_pattern()); ?>" placeholder="<?php echo osc_esc_html(__('What are you looking for?', 'gamma')); ?>" autocomplete="off" />
    <button type="submit" class="mbBg"><?php _e('Search', 'gamma'); ?></button>
  </form>
</div>

<?php 
  $loc = (osc_get_osclass_location() == '' ? 'home' : osc_get_osclass_location());
  $sec = (osc_get_osclass_section() == '' ? 'default' : osc_get_osclass_section());
?>

<section class="content loc-<?php echo $loc; ?> sec-<?php echo $sec; ?>">

<?php
  if(osc_is_home_page()) { 
    osc_current_web_theme_path('inc.search.php'); 
    osc_current_web_theme_path('inc.category.php');
  }
?>



<div class="flash-box">
  <div class="flash-wrap">
    <?php osc_show_flash_message(); ?>
  </div>
</div>


<?php
  osc_show_widgets('header');
  $breadcrumb = osc_breadcrumb('>', false);
  $breadcrumb = str_replace('<span itemprop="title">' . osc_page_title() . '</span>', '<span itemprop="title">' . __('Home', 'gamma') . '</span>', $breadcrumb);
?>

<?php if($breadcrumb != '') { ?>
  <div id="bread">
    <?php echo $breadcrumb; ?>
  </div>
<?php } ?>