<?php
if(!defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

/*
 * Copyright 2014 Osclass
 * Copyright 2023 Osclass by OsclassPoint.com
 *
 * Osclass maintained & developed by OsclassPoint.com
 * You may not use this file except in compliance with the License.
 * You may download copy of Osclass at
 *
 *     https://osclass-classifieds.com/download
 *
 * Do not edit or add to this file if you wish to upgrade Osclass to newer
 * versions in the future. Software is distributed on an "AS IS" basis, without
 * warranties or conditions of any kind, either express or implied. Do not remove
 * this NOTICE section as it contains license information and copyrights.
 */


/**
 * EmailVariables class
 * 
 * @since 3.0
 * @package Osclass
 * @subpackage classes
 * @author Osclass
 */
class EmailVariables {
  private static $instance;
  private $variables;

  public function __construct() {
    $this->variables = array();
    $this->init();
  }

  /**
   * @return \EmailVariables
   */
  public static function newInstance() {
    if(!self::$instance instanceof self) {
      self::$instance = new self;
    }
    
    return self::$instance;
  }

  /**
   *  Initialize menu representation.
   */
  public function init() {
    $this->variables = array(
      '{USER_NAME}' => __('User name'),
      '{USER_EMAIL}' => __('User email'),
      '{VALIDATION_LINK}' => __('Link for account validation.'),
      '{VALIDATION_URL}' => __('Url for account validation.'),
      '{ADS}' => __('List of listings, used when send alerts'),
      '{UNSUB_LINK}' => __('Unsubscribe link.'),
      '{WEB_URL}' => __('Site home page url.'),
      '{WEB_LINK}' => __('Site home page link.'),
      '{WEB_TITLE}' => __('Title of your site'),
      '{CURRENT_DATE}' => __('Current date'),
      '{HOUR}' => __('Current time (hour)'),
      '{IP_ADDRESS}' => __('User ip address'),
      '{LOCALE_CODE}' => __('Current user locale code'),
      '{LOCALE_SHORT_CODE}' => __('Current user locale 2-letter code'),
      '{COMMENT_AUTHOR}' => __('Comment author name'),
      '{COMMENT_EMAIL}' => __('Comment author email'),
      '{COMMENT_TITLE}' => __('Comment title'),
      '{COMMENT_TEXT}' => __('Comment text content'),
      '{COMMENT_BODY}' => __('Comment body'),
      '{ITEM_URL}' => __('Listing url'),
      '{ITEM_EXPIRATION_DATE}' => __('Item expiration date'),
      '{ITEM_LINK}' => __('Listing link'),
      '{ITEM_TITLE}' => __('Listing title'),
      '{ITEM_IMAGE}' => __('Listing image URL'),
      '{ITEM_ID}' => __('Listing id'),
      '{ITEMS_COUNT}' => __('Listings count'),
      '{EDIT_LINK}' => __('Link for edit listing'),
      '{EDIT_URL}' => __('Url for edit listing'),
      '{DELETE_LINK}' => __('Delete listing link'),
      '{DELETE_URL}' => __('Delete listing url'),
      '{PASSWORD_LINK}' => __('Change user password link'),
      '{PASSWORD_URL}' => __('change user password url'),
      '{DATE_TIME}' => __('Date time'),
      '{FRIEND_NAME}' => __('Name of the friend who wants send'),
      '{FRIEND_EMAIL}' => __('Email of the friend who wants send'),
      '{COMMENT}' => __('Question about your listing'),
      '{CONTACT_NAME}' => __('Contact name'),
      '{USER_PHONE}' => __('User phone number'),
      '{ITEM_DESCRIPTION}'=> __('Listing description'),
      '{ITEM_DESCRIPTION_ALL_LANGUAGES}' => __('Listing description in all languages'),
      '{ITEM_PRICE}' => __('Listing price'), 
      '{ITEM_COUNTRY}' => __('Listing country'), 
      '{ITEM_REGION}' => __('Listing region'), 
      '{ITEM_CITY}' => __('Listing city'),
      '{SELLER_NAME}' => __('Seller name'),
      '{SELLER_EMAIL}' => __('Seller email'),
      '{CONTACT_EMAIL}' => __('Contact name'),
      '{ADMIN_NAME}' => __('Admin name'),
      '{USERNAME}' => __('Username'),
      '{PASSWORD}' => __('Password'),
      '{WEB_ADMIN_LINK}' => __('Oc-Admin URL')
    );
  }

  /**
   * Add new email variable and description
   *
   * @param $key
   * @param $description 
   */
  public function add($key, $description) {
    $this->variables[$key] = $description;
  }

  /**
   * Remove email variable from the array 
   * 
   * @param $key
   */
  public function remove($key) {
    unset( $this->variables[$key] );
  }

  /**
   *
   * @param $email
   *
   * @return bool|mixed
   */
  public function getVariables($email) {
    $array = array();
    $variables = array(
      'email_alert_validation' => array(
        '{USER_NAME}',
        '{USER_EMAIL}',
        '{VALIDATION_LINK}'
      ),
      'alert_email_hourly' => array(
        '{USER_NAME}',
        '{USER_EMAIL}',
        '{ADS}',
        '{UNSUB_LINK}',
        '{ITEMS_COUNT}'
      ),
      'alert_email_daily' => array(
        '{USER_NAME}',
        '{USER_EMAIL}',
        '{ADS}',
        '{UNSUB_LINK}',
        '{ITEMS_COUNT}'
      ),
      'alert_email_weekly' => array(
        '{USER_NAME}',
        '{USER_EMAIL}',
        '{ADS}',
        '{UNSUB_LINK}',
        '{ITEMS_COUNT}'
      ),
      'alert_email_instant' => array(
        '{USER_NAME}',
        '{USER_EMAIL}',
        '{ADS}',
        '{UNSUB_LINK}',
        '{ITEMS_COUNT}'
      ),
      'email_comment_validated' => array(
        '{COMMENT_AUTHOR}',
        '{COMMENT_EMAIL}',
        '{COMMENT_TITLE}',
        '{COMMENT_BODY}',
        '{ITEM_URL}',
        '{ITEM_LINK}',
        '{ITEM_TITLE}'
      ),
      'email_new_item_non_register_user' => array(
        '{ITEM_ID}',
        '{USER_NAME}',
        '{USER_EMAIL}',
        '{ITEM_TITLE}',
        '{ITEM_URL}',
        '{ITEM_LINK}',
        '{EDIT_LINK}',
        '{EDIT_URL}',
        '{DELETE_LINK}',
        '{DELETE_URL}'
      ),
      'email_user_forgot_password' => array(
        '{USER_NAME}',
        '{USER_EMAIL}',
        '{PASSWORD_LINK}',
        '{PASSWORD_URL}',
        '{DATE_TIME}'
      ),
      'email_user_registration' => array(
        '{USER_NAME}',
        '{USER_EMAIL}'
      ),
      'email_new_email' => array(
        '{USER_NAME}',
        '{USER_EMAIL}',
        '{VALIDATION_LINK}',
        '{VALIDATION_URL}'
      ),
      'email_user_validation' => array(
        '{USER_NAME}',
        '{USER_EMAIL}',
        '{VALIDATION_LINK}',
        '{VALIDATION_URL}'
      ),
      'email_send_friend' => array(
        '{FRIEND_NAME}',
        '{USER_NAME}',
        '{USER_EMAIL}',
        '{FRIEND_EMAIL}',
        '{ITEM_TITLE}',
        '{COMMENT}',
        '{ITEM_URL}',
        '{ITEM_LINK}'
      ),
      'email_item_inquiry' => array(
        '{CONTACT_NAME}',
        '{USER_NAME}',
        '{USER_EMAIL}',
        '{USER_PHONE}',
        '{ITEM_TITLE}',
        '{ITEM_URL}',
        '{ITEM_LINK}',
        '{COMMENT}'
      ),
      'email_new_comment_admin' => array(
        '{COMMENT_AUTHOR}',
        '{COMMENT_EMAIL}',
        '{COMMENT_TITLE}',
        '{COMMENT_TEXT}',
        '{ITEM_TITLE}',
        '{ITEM_ID}',
        '{ITEM_URL}',
        '{ITEM_LINK}'
      ),
      'email_item_validation' => array(
        '{ITEM_DESCRIPTION_ALL_LANGUAGES}',
        '{ITEM_DESCRIPTION}',
        '{ITEM_COUNTRY}',
        '{ITEM_PRICE}',
        '{ITEM_REGION}',
        '{ITEM_CITY}',
        '{ITEM_ID}',
        '{USER_NAME}',
        '{USER_EMAIL}',
        '{ITEM_TITLE}',
        '{ITEM_URL}',
        '{ITEM_LINK}',
        '{VALIDATION_LINK}',
        '{VALIDATION_URL}'
      ),
      'email_admin_new_item' => array(
        '{EDIT_LINK}',
        '{EDIT_URL}',
        '{ITEM_DESCRIPTION_ALL_LANGUAGES}',
        '{ITEM_DESCRIPTION}',
        '{ITEM_COUNTRY}',
        '{ITEM_PRICE}',
        '{ITEM_REGION}',
        '{ITEM_CITY}',
        '{ITEM_ID}',
        '{USER_NAME}',
        '{USER_EMAIL}',
        '{ITEM_TITLE}',
        '{ITEM_URL}',
        '{ITEM_LINK}',
        '{VALIDATION_LINK}',
        '{VALIDATION_URL}'
      ),
      'email_item_validation_non_register_user' => array(
        '{ITEM_DESCRIPTION_ALL_LANGUAGES}',
        '{ITEM_DESCRIPTION}',
        '{ITEM_COUNTRY}',
        '{ITEM_PRICE}',
        '{ITEM_REGION}',
        '{ITEM_CITY}',
        '{ITEM_ID}',
        '{USER_NAME}',
        '{USER_EMAIL}',
        '{ITEM_TITLE}',
        '{ITEM_URL}',
        '{ITEM_LINK}',
        '{VALIDATION_LINK}',
        '{VALIDATION_URL}',
        '{EDIT_LINK}',
        '{EDIT_URL}',
        '{DELETE_LINK}',
        '{DELETE_URL}'
      ),
      'email_admin_new_user' => array(
        '{USER_NAME}',
        '{USER_EMAIL}'
      ),
      'email_contact_user' => array(
        '{CONTACT_NAME}',
        '{USER_NAME}',
        '{USER_EMAIL}',
        '{USER_PHONE}',
        '{COMMENT}'
      ),
      'email_new_comment_user' => array(
        '{COMMENT_AUTHOR}',
        '{COMMENT_EMAIL}',
        '{COMMENT_TITLE}',
        '{COMMENT_TEXT}',
        '{ITEM_TITLE}',
        '{ITEM_ID}',
        '{ITEM_URL}',
        '{ITEM_LINK}',
        '{SELLER_NAME}',
        '{SELLER_EMAIL}'
      ),
      'email_new_admin' => array(
        '{ADMIN_NAME}',
        '{USERNAME}',
        '{PASSWORD}',
        '{WEB_ADMIN_LINK}'
      ),
      'email_warn_expiration' => array(
        '{USER_NAME}',
        '{ITEM_TITLE}',
        '{ITEM_ID}',
        '{ITEM_EXPIRATION_DATE}',
        '{ITEM_URL}',
        '{ITEM_LINK}',
        '{SELLER_NAME}',
        '{SELLER_EMAIL}',
        '{CONTACT_NAME}',
        '{CONTACT_EMAIL}'
      )
    );

    if(isset($email['s_internal_name']) && isset($variables[$email['s_internal_name']])) {
      foreach($variables[$email['s_internal_name']] as $word) {
        if(isset($this->variables[$word])) {
          $array[$word] = $this->variables[$word];
        } else {
          $array[$word] = $word;
        }
      }
    }
    
    
    // ADD GLOBAL VARIABLES INTO LIST OF KEYWORDS
    // These variables are added in osc_emailBeauty function
    $global_vars = array('{WEB_URL}', '{WEB_TITLE}', '{WEB_LINK}', '{CURRENT_DATE}', '{HOUR}', '{IP_ADDRESS}', '{LOCALE_CODE}', '{LOCALE_SHORT_CODE}');

    foreach($global_vars as $word) {
      if(!isset($array[$word])) {
        if(isset($this->variables[$word])) {
          $array[$word] = $this->variables[$word];
        } else {
          $array[$word] = $word;
        }
      }
    }

    return osc_apply_filter('email_legend_words', $array, @$email['s_internal_name']);
  }
  
  /*
   * Empty the variables array
   */
  public function clear_menu() {
    $this->variables = array();
  }
}