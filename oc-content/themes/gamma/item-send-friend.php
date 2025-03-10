<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo gam_language_dir(); ?>" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
  <?php osc_current_web_theme_path('head.php') ; ?>
  <meta name="robots" content="noindex, nofollow" />
  <meta name="googlebot" content="noindex, nofollow" />
  <script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('jquery.validate.min.js') ; ?>"></script>
</head>

<?php 
  $type = (Params::getParam('type') == '' ? 'send_friend' : Params::getParam('type')); 
  $user_id = Params::getParam('userId');
?>

<?php 
  if($type == 'itemviewer') {
    ob_clean();
    ob_start(); 
    Params::setParam('itemviewer', 1);
    require_once osc_base_path().'oc-content/themes/gamma/item.php'; 
    
    $viewer_content = ob_get_contents();
    ob_end_clean();

    echo $viewer_content;
    exit;
  }
?>  


<body id="body-item-forms" class="fw-supporting">
  <?php osc_current_web_theme_path('header.php'); ?></div>


  <?php if($type == 'friend') { ?>

    <!-- SEND TO FRIEND FORM -->
    <div id="send-friend-form" class="fw-box" style="display:block;">
      <div class="head">
        <h1><?php _e('Send to friend', 'gamma'); ?></h1>
      </div>

      <div class="middle">
        <ul id="error_list"></ul>

        <form target="_top" id="sendfriend" name="sendfriend" action="<?php echo osc_base_url(true); ?>" method="post">
          <fieldset>
            <input type="hidden" name="action" value="send_friend_post" />
            <input type="hidden" name="page" value="item" />
            <input type="hidden" name="id" value="<?php echo osc_item_id(); ?>" />

            <?php if(osc_is_web_user_logged_in()) { ?>
              <input type="hidden" name="yourName" value="<?php echo osc_esc_html( osc_logged_user_name() ); ?>" />
              <input type="hidden" name="yourEmail" value="<?php echo osc_logged_user_email();?>" />
            <?php } else { ?>
              <div class="row">
                <label for="yourName"><span><?php _e('Your name', 'gamma'); ?></span><span class="req">*</span></label> 
                <div class="input-box"><?php SendFriendForm::your_name(); ?></div>

                <label for="yourEmail"><span><?php _e('Your e-mail address', 'gamma'); ?></span><span class="req">*</span></label>
                <div class="input-box"><?php SendFriendForm::your_email(); ?></div>
              </div>
            <?php } ?>

            <div class="row">
              <label for="friendName"><span><?php _e("Your friend's name", 'gamma'); ?></span><span class="req">*</span></label>
              <div class="input-box"><?php SendFriendForm::friend_name(); ?></div>

              <label for="friendEmail"><span><?php _e("Your friend's e-mail address", 'gamma'); ?></span><span class="req">*</span></label>
              <div class="input-box last"><?php SendFriendForm::friend_email(); ?></div>
            </div>
                  
            <div class="row last">
              <label for="message"><span><?php _e('Message', 'gamma'); ?></span><span class="req">*</span></label>
              <?php SendFriendForm::your_message(); ?>
            </div>

            <?php gam_show_recaptcha(); ?>

            <button type="<?php echo (gam_param('forms_ajax') == 1 ? 'button' : 'submit'); ?>" id="send-message" class="mbBg item-form-submit" data-type="friend"><?php _e('Send message', 'gamma'); ?></button>
          </fieldset>
        </form>

        <?php SendFriendForm::js_validation(); ?>
      </div>
    </div>
  <?php } ?>

 

  <?php if($type == 'comment') { ?>

    <!-- NEW COMMENT FORM -->
    <?php if( osc_comments_enabled() && (osc_reg_user_post_comments () && osc_is_web_user_logged_in() || !osc_reg_user_post_comments()) ) { ?>
      <form target="_top" action="<?php echo osc_base_url(true) ; ?>" method="post" name="comment_form" id="comment_form" class="fw-box" style="display:block;">
        <input type="hidden" name="action" value="add_comment" />
        <input type="hidden" name="page" value="item" />
        <input type="hidden" name="id" value="<?php echo osc_item_id() ; ?>" />
        <?php if(function_exists('osc_enable_comment_reply') && osc_enable_comment_reply()) { ?><input type="hidden" name="replyId" value="<?php echo osc_esc_html(Params::getParam('replyToCommentId')); ?>" /><?php } ?>

        <fieldset>
          <?php if(function_exists('osc_enable_comment_reply') && osc_enable_comment_reply() && Params::getParam('replyToCommentId') > 0) { ?>
            <?php $original_comment = ItemComment::newInstance()->findByPrimaryKey(Params::getParam('replyToCommentId')); ?>

            <?php if(isset($original_comment['pk_i_id']) && $original_comment['fk_i_item_id'] == osc_item_id()) { ?>
              <div class="head"><h1><?php _e('Reply to comment', 'gamma'); ?></h1></div>
            <?php } else { ?>
              <div class="head"><h1><?php _e('Invalid comment', 'gamma'); ?></h1></div>
              <?php exit; ?>
            <?php } ?>
          <?php } else { ?>
            <div class="head"><h1><?php _e('Add a new comment', 'gamma'); ?></h1></div>
          <?php } ?>
        

          <div class="middle">
            <?php CommentForm::js_validation(); ?>
            <ul id="comment_error_list"></ul>

            <?php if(function_exists('osc_enable_comment_reply') && osc_enable_comment_reply() && Params::getParam('replyToCommentId') > 0) { ?>
              <?php if(isset($original_comment['pk_i_id']) && $original_comment['fk_i_item_id'] == osc_item_id()) { ?>
                <div class="row" style="margin-bottom:20px;"><?php echo sprintf(__('Original comment: "%s"', 'gamma'), '<i>' . osc_highlight($original_comment['s_title'] . ' ' . $original_comment['s_body'], 300) . '</i>'); ?></div>
              <?php } ?>
            <?php } ?>
            
            <?php if(osc_is_web_user_logged_in()) { ?>
              <input type="hidden" name="authorName" value="<?php echo osc_esc_html( osc_logged_user_name() ); ?>" />
              <input type="hidden" name="authorEmail" value="<?php echo osc_logged_user_email();?>" />
            <?php } else { ?>
              <div class="row">
                <label for="authorName"><?php _e('Name', 'gamma') ; ?></label> 
                <div class="input-box"><?php CommentForm::author_input_text(); ?></div>
              </div>

              <div class="row">
                <label for="authorEmail"><span><?php _e('E-mail', 'gamma') ; ?></span><span class="req">*</span></label> 
                <div class="input-box"><?php CommentForm::email_input_text(); ?></div>
              </div>                  
            <?php } ?>

            <?php if(osc_enable_comment_rating()) { ?>
              <?php if(Params::getParam('replyToCommentId') > 0 && osc_enable_comment_reply_rating() || Params::getParam('replyToCommentId') <= 0) { ?>
                <div class="row" style="padding-bottom:8px;">
                  <label for=""><?php _e('Rating', 'gamma'); ?></label>
                  <div class="comment-stars">
                    <?php //CommentForm::rating_input_text(); ?>
                    <input type="hidden" name="rating" value="" />

                    <div class="comment-leave-rating">
                      <i class="fa fa-star is-rating-item" data-value="1"></i> 
                      <i class="fa fa-star is-rating-item" data-value="2"></i> 
                      <i class="fa fa-star is-rating-item" data-value="3"></i> 
                      <i class="fa fa-star is-rating-item" data-value="4"></i> 
                      <i class="fa fa-star is-rating-item" data-value="5"></i> 
                    </div>
                    
                    <span class="comment-rating-selected"></span>
                  </div>
                </div>
              <?php } ?>
            <?php } ?>
          
            <div class="row" id="last">
              <label for="title"><?php _e('Title', 'gamma') ; ?></label>
              <div class="input-box"><?php CommentForm::title_input_text(); ?></div>
            </div>
        
            <div class="row">
              <label for="body"><span><?php _e('Message', 'gamma'); ?></span><span class="req">*</span></label>
              <?php CommentForm::body_input_textarea(); ?>
            </div>

            <?php gam_show_recaptcha(); ?>

            <button type="<?php echo (gam_param('forms_ajax') == 1 ? 'button' : 'submit'); ?>" id="send-comment" class="mbBg item-form-submit" data-type="comment"><?php _e('Submit comment', 'gamma') ; ?></button>
          </div>
        </fieldset>
      </form>
    <?php } ?>
  <?php } ?>


  <?php if($type == 'contact') { ?>

    <!-- ITEM CONTACT FORM -->
    <form target="_top" action="<?php echo osc_base_url(true) ; ?>" method="post" name="contact_form" id="contact_form" class="fw-box" style="display:block;" <?php if(osc_item_attachment()) { ?>enctype="multipart/form-data"<?php } ?>>
      <input type="hidden" name="action" value="contact_post" />
      <input type="hidden" name="page" value="item" />
      <input type="hidden" name="id" value="<?php echo osc_item_id() ; ?>" />

      <?php osc_prepare_user_info() ; ?>

      <fieldset>
        <div class="head">
          <h1><?php _e('Contact seller', 'gamma'); ?></h1>
        </div>

        <div class="middle">
          <?php ContactForm::js_validation(); ?>
          <ul id="error_list"></ul>

          <?php if( osc_item_is_expired () ) { ?>
            <div class="problem">
              <?php _e('This listing expired, you cannot contact seller.', 'gamma') ; ?>
            </div>
          <?php } else if( (osc_logged_user_id() == osc_item_user_id()) && osc_logged_user_id() != 0 ) { ?>
            <div class="problem">
              <?php _e('It is your own listing, you cannot contact yourself.', 'gamma') ; ?>
            </div>
          <?php } else if( osc_reg_user_can_contact() && !osc_is_web_user_logged_in() ) { ?>
            <div class="problem">
              <?php _e('You must log in or register a new account in order to contact the advertiser.', 'gamma') ; ?>
            </div>
          <?php } else { ?> 

            <?php if(osc_is_web_user_logged_in()) { ?>
              <input type="hidden" name="yourName" value="<?php echo osc_esc_html( osc_logged_user_name() ); ?>" />
              <input type="hidden" name="yourEmail" value="<?php echo osc_logged_user_email();?>" />
            <?php } else { ?>
              <div class="row">
                <label for="yourName"><?php _e('Name', 'gamma') ; ?><span class="req">*</span></label> 
                <div class="input-box"><?php ContactForm::your_name(); ?></div>
              </div>

              <div class="row">
                <label for="yourEmail"><span><?php _e('E-mail', 'gamma') ; ?></span><span class="req">*</span></label> 
                <div class="input-box"><?php ContactForm::your_email(); ?></div>
              </div>       
            <?php } ?>
       

            <div class="row">
              <label for="phoneNumber"><span><?php _e('Phone', 'gamma') ; ?></span></label> 
              <div class="input-box"><?php ContactForm::your_phone_number(); ?></div>
            </div>          
      
            <div class="row">
              <label for="message"><span><?php _e('Message', 'gamma'); ?></span><span class="req">*</span></label>
              <?php ContactForm::your_message(); ?>
            </div>
            
            <?php if(osc_item_attachment()) { ?>
              <div class="row has-file">
                <label for="attachment"><?php _e('Attachment', 'gamma'); ?>:</label>
                <div class="input-box"><?php ContactForm::your_attachment(); ?></div>
              </div>
            <?php } ?>

            <?php gam_show_recaptcha(); ?>

            <button type="<?php echo (gam_param('forms_ajax') == 1 ? 'button' : 'submit'); ?>" id="send-message" class="mbBg item-form-submit" data-type="contact"><?php _e('Send message', 'gamma') ; ?></button>
          <?php } ?>
        </div>
      </fieldset>
    </form>
  <?php } ?>



  <?php if($type == 'contact_public') { ?>

    <!-- PUBLIC PROFILE CONTACT SELLER -->
    <?php if(osc_reg_user_can_contact() && osc_is_web_user_logged_in() || !osc_reg_user_can_contact() ) { ?>
      <form target="_top" action="<?php echo osc_base_url(true) ; ?>" method="post" name="contact_form" id="contact_form_public" class="fw-box" style="display:block;">
        <input type="hidden" name="action" value="contact_post" class="nocsrf" />
        <input type="hidden" name="page" value="user" />
        <input type="hidden" name="id" value="<?php echo $user_id; ?>" />
        <?php if(osc_is_web_user_logged_in()) { ?>
        <input type="hidden" id="yourName" name="yourName" value="<?php echo osc_logged_user_name(); ?>">
        <input type="hidden" id="yourEmail" name="yourEmail" value="<?php echo osc_logged_user_email(); ?>">
        <?php } ?>

        <div class="head">
          <h1><?php _e('Contact seller', 'gamma'); ?></h1>
        </div>

        <div class="middle">
          <fieldset>
            <?php ContactForm::js_validation(); ?>
            <ul id="error_list"></ul>

            <?php if($user_id == osc_logged_user_id() && osc_is_web_user_logged_in()) { ?>
              <div class="problem"><?php _e('This is your own profile!', 'gamma'); ?></div>
            <?php } else { ?>
              <?php if(!osc_is_web_user_logged_in()) { ?>
                <div class="row">
                  <label for="yourName"><?php _e('Name', 'gamma'); ?></label> 
                  <div class="input-box"><?php ContactForm::your_name(); ?></div>
                </div>

                <div class="row">
                  <label for="yourEmail"><span><?php _e('E-mail', 'gamma') ; ?></span><span class="req">*</span></label> 
                  <div class="input-box"><?php ContactForm::your_email(); ?></div>
                </div>
              <?php } ?>              

              <div class="row last">
                <label for="phoneNumber"><span><?php _e('Phone number', 'gamma') ; ?></span></label>
                <div class="input-box"><?php ContactForm::your_phone_number(); ?></div>
              </div>

              <div class="row">
                <label for="message"><span><?php _e('Message', 'gamma'); ?></span><span class="req">*</span></label>
                <?php ContactForm::your_message(); ?>
              </div>

              <?php gam_show_recaptcha(); ?>

              <button type="<?php echo (gam_param('forms_ajax') == 1 ? 'button' : 'submit'); ?>" id="send-public-message" class="mbBg item-form-submit" data-type="contact_public"><?php _e('Send message', 'gamma') ; ?></button>
            <?php } ?>
          </fieldset>
        </div>
      </form>
    <?php } ?>
  <?php } ?>

  <script>
    $('#sendfriend #yourName, #sendfriend #yourEmail, #sendfriend #friendName, #sendfriend #friendEmail, #sendfriend #yourName, #sendfriend #message').prop('required', true);
    $('#comment_form #body, #comment_form #yourName').prop('required', true);
    $('#contact_form #yourName, #contact_form #yourEmail, #contact_form #message').prop('required', true);
  </script>

  <?php osc_current_web_theme_path('footer.php') ; ?>
</body>
</html>