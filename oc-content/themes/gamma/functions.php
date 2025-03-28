<?php
define('GAMMA_THEME_VERSION', '1.6.0');

require_once osc_base_path() . 'oc-content/themes/gamma/model/ModelGAM.php';


function gam_theme_info() {
  return array(
    'name' => 'Gamma Osclass Theme',
    'version' => '1.6.0',
    'description' => 'Responsive fast and clean premium osclass theme',
    'author_name' => 'MB Themes',
    'author_url' => 'https://osclasspoint.com',
    'support_uri' => 'https://forums.osclasspoint.com/gamma-osclass-theme/',
    'locations' => array('header', 'footer')
  );
}

define('USER_MENU_ICONS', 1);


// RTL LANGUAGE SUPPORT
function gam_is_rtl() {
  $current_lang = strtolower(osc_current_user_locale());
  $locale = osc_get_current_user_locale();
  
  if(isset($locale['b_rtl']) && $locale['b_rtl'] == 1) {
    return true;
  } else if(in_array(osc_current_user_locale(), gam_rtl_languages())) {
    return true;
  } else {
    return false;
  }
}

// GET DIRECTION STRING
function gam_language_dir() {
  return gam_is_rtl() ? 'rtl' : 'ltr';
}

// LIST ALL RTL LANGUAGES/LOCALES FOR OLDER OSCLASS VERSIONS
function gam_rtl_languages() {
  $langs = array('ar_LB','ar_DZ','ar_BH','ar_EG','ar_IQ','ar_JO','ar_KW','ar_LY','ar_MA','ar_OM','ar_SA','ar_SY','fa_IR','ar_TN','ar_AE','ar_YE','ar_TD','ar_CO','ar_DJ','ar_ER','ar_MR','ar_SD');
  return $langs;
}

// AJAX REQUESTS MANAGEMENT
function gam_ajax_manage() {
  if(Params::getParam('ajaxRequest') == 1) {
    error_reporting(0);
    ob_clean();
    osc_current_web_theme_path('ajax.php');
    exit;
  }
}

osc_add_hook('init', 'gam_ajax_manage');

// REMOVE OLD FONT AWESOME (V4)
function gam_clean_old_fonts() {
  osc_remove_style('font-open-sans');
  osc_remove_style('open-sans');
  osc_remove_style('fi_font-awesome');
  osc_remove_style('font-awesome44');
  osc_remove_style('font-awesome45');
  osc_remove_style('font-awesome47');
  osc_remove_style('cookiecuttr-style');
  osc_remove_style('responsiveslides');
  osc_remove_style('font-awesome');
}

osc_add_hook('init', 'gam_clean_old_fonts');
osc_add_hook('header', 'gam_clean_old_fonts');


// OSCLASS 4.1 COMPATIBILITY
if(!function_exists('osc_can_deactivate_items')) {
  function osc_can_deactivate_items() {
    return false;
  }
}

if(!function_exists('osc_item_can_renew')) {
  function osc_item_can_renew() {
    return false;
  }
}


if(!function_exists('osc_item_show_phone')) {
  function osc_item_show_phone() {
    return true;
  }
}

if(!function_exists('osc_get_current_user_locations_native')) {
  function osc_get_current_user_locations_native() {
    return false;
  }
}

if(!function_exists('osc_location_native_name_selector')) {
  function osc_location_native_name_selector($array, $column = 's_name') {
    return @$array[$column];
  }
}

// ONLINE CHAT
function gam_chat_button($user_id = '') {
  if(function_exists('oc_chat_button')) {
    $html = '';
    $user_name = '';
    $text = '';
    $title = '';

    if((osc_is_ad_page() || osc_is_search_page()) && $user_id == '') {
      $user_id = osc_item_user_id();
      $user_name = osc_item_contact_name();
    }

    if($user_id <> '' && $user_id > 0) {
      $registered = 1;
      $last_active = ModelOC::newInstance()->getUserLastActive($user_id);
      $user = User::newInstance()->findByPrimaryKey($user_id);
      $user_name = @$user['s_name'];

      $active_limit = osc_get_preference('refresh_user', 'plugin-online_chat');
      $active_limit = ($active_limit > 0 ? $active_limit : 120);
      $active_limit = $active_limit + 10;

      $limit_datetime = date('Y-m-d H:i:s', strtotime(' -' . $active_limit . ' seconds', time()));
    } else {
      $registered = 0;
    }

    if($registered == 1 && $user_id <> osc_logged_user_id() && !oc_check_bans($user_id)) {
      $class = ' oc-active';
    } else {
      $class = ' oc-disabled';
    }

    if(isset($limit_datetime) && $limit_datetime <> '' && $last_active >= $limit_datetime) {
      $class .= ' oc-online';
      $title .= __('User is online', 'gamma');
    } else {
      $class .= ' oc-offline';
      $title .= __('User is offline', 'gamma');
    }


    //$html .= '<div class="row mob oc-chat-box' . $class . '" data-user-id="' . $user_id . '">';
    //$html .= '<i class="fa fa-comment"></i>';



    if($registered == 0) {
      $text .=  __('Chat unavailable', 'gamma');
      $title .= ', ' . __('User is not registered', 'gamma');
    } else {
      if($user_id == osc_logged_user_id()) {
        $text .= __('Chat unavailable', 'gamma');
        $title .= ', ' . __('It\'s your ad', 'gamma');
      } else if (oc_check_bans($user_id)) {
        $text .= __('Chat unavailable', 'gamma');
        $title .= ', ' . __('User has blocked you', 'gamma');
      } else {
        $text .= '<span class="oc-user-top oc-status-offline">' . __('Chat unavailable', 'gamma') . '</span>';
        $text .= '<span class="oc-user-top oc-status-online">' . __('Start chat', 'gamma') . '</span>';
      }
    }


    $html .= '<a href="#" class="btn oc-start-chat' . $class . '" data-to-user-id="' . $user_id . '" data-to-user-name="' . osc_esc_html($user_name) . '" data-to-user-image="' . oc_get_picture( $user_id ) . '" title="' . osc_esc_html($title) . '">';
    $html .= '<svg height="24" viewBox="0 0 512 512" width="24" xmlns="http://www.w3.org/2000/svg"><path d="m512 346.5c0-74.628906-50.285156-139.832031-121.195312-159.480469-4.457032-103.878906-90.347657-187.019531-195.304688-187.019531-107.800781 0-195.5 87.699219-195.5 195.5 0 35.132812 9.351562 69.339844 27.109375 99.371094l-26.390625 95.40625 95.410156-26.386719c27.605469 16.324219 58.746094 25.519531 90.886719 26.90625 19.644531 70.914063 84.851563 121.203125 159.484375 121.203125 29.789062 0 58.757812-7.933594 84.210938-23.007812l80.566406 22.285156-22.285156-80.566406c15.074218-25.453126 23.007812-54.421876 23.007812-84.210938zm-411.136719-15.046875-57.117187 15.800781 15.800781-57.117187-3.601563-5.632813c-16.972656-26.554687-25.945312-57.332031-25.945312-89.003906 0-91.257812 74.242188-165.5 165.5-165.5s165.5 74.242188 165.5 165.5-74.242188 165.5-165.5 165.5c-31.671875 0-62.445312-8.972656-89.003906-25.945312zm367.390625 136.800781-42.382812-11.726562-5.660156 3.683594c-21.941407 14.253906-47.433594 21.789062-73.710938 21.789062-58.65625 0-110.199219-37.925781-128.460938-92.308594 89.820313-10.355468 161.296876-81.832031 171.65625-171.65625 54.378907 18.265625 92.304688 69.808594 92.304688 128.464844 0 26.277344-7.535156 51.769531-21.789062 73.710938l-3.683594 5.660156zm0 0"/><path d="m180.5 271h30v30h-30zm0 0"/><path d="m225.5 150c0 8.519531-3.46875 16.382812-9.765625 22.144531l-35.234375 32.25v36.605469h30v-23.394531l25.488281-23.328125c12.398438-11.347656 19.511719-27.484375 19.511719-44.277344 0-33.085938-26.914062-60-60-60s-60 26.914062-60 60h30c0-16.542969 13.457031-30 30-30s30 13.457031 30 30zm0 0"/></svg>';
    $html .= '<span>' . $text . '</span>';
    $html .= '<em class="' . $class . '"></em>';
    $html .= '</a>';

    //$html .= '</div>';

    return $html;
  } else {
    return false;
  }
}


// IDENTIFY DEVICE TYPE
function gam_device() {
  if(!isset($_SERVER['HTTP_USER_AGENT'])) {
    return '';
  }
  
  $iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
  $iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
  $iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
  $Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
  $webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");

  //do something with this information
  if($iPod || $iPhone || $iPad) {
    return 'ios';
  } else if($Android) {
    return 'android';
  } else if($webOS) {
    return 'webos';
  }
}


// MASK EMAIL
function gam_mask_email($email) {
  $em = explode('@',$email);
  $name = implode('@', array_slice($em, 0, count($em)-1));
  $domain = end($em);

  $len_name = strlen($name)-2;
  $mask_name = substr($name,0, strlen($name) - $len_name) . str_repeat('*', $len_name);
 
  $len_domain = strlen($domain) - 4;
  $mask_domain = str_repeat('*', $len_domain) . substr($domain, $len_domain, strlen($domain));

  return  $mask_name . '@' . $mask_domain;   
}


// PUBLIC PROFILE ITEMS
function gam_public_profile_items() {
  $section = osc_get_osclass_section();  
  if(osc_get_osclass_location() == 'user' && ($section == 'items' || $section == 'pub_profile')) {
    Params::setParam('itemsPerPage', gam_param('public_items'));
  }
}

osc_add_hook('init', 'gam_public_profile_items');


// CHECK IF LAZY LOAD ENABLED
function gam_is_lazy($disabled = false) {
  if($disabled === true) {
    return false; 
  } else if(gam_param('lazy_load') == 1 && osc_get_preference('force_aspect_image', 'osclass') == 0) {
    return true;
  }

  return false;
}


// GET COUNTRY FLAG, IF EXISTS
function gam_country_flag_image($code) {
  if($code != '' && file_exists(osc_base_path() . 'oc-content/themes/gamma/images/country_flags/large/' . strtolower($code) . '.png')) {
    return osc_current_web_theme_url() . 'images/country_flags/large/' . strtolower($code) . '.png';
  } 
  
  return osc_current_web_theme_url() . 'images/country_flags/large/default.png';
}


// GET NO IMAGE LINK
function gam_get_noimage($type = 'thumb') {
  if($type == 'thumb') {
    $dim = osc_get_preference('dimThumbnail', 'osclass'); 
  } else if($type == 'large') {
    $dim = '700x525';
  }
  
  if(file_exists(WebThemes::newInstance()->getCurrentThemePath() . 'images/no-image-' . $dim . '.png')) {
    return osc_current_web_theme_url('images/no-image-' . $dim . '.png');
  }

  return osc_current_web_theme_url('images/no-image.png');
}


// RELATED ADS
function gam_related_ads() {
  if(gam_param('related') == 1) {
    $limit = (gam_param('related_count') > 0 ? gam_param('related_count') : 3);

    $mSearch = new Search();
    $mSearch->addCategory(osc_item_category_id());
    //$mSearch->withPicture(true); 
    $mSearch->limit(1, $limit);
    $mSearch->addItemConditions(sprintf("%st_item.pk_i_id <> %d", DB_TABLE_PREFIX, osc_item_id()));

    $aItems = $mSearch->doSearch(); 


    GLOBAL $global_items;
    $global_items = View::newInstance()->_get('items');
    View::newInstance()->_exportVariableToView('items', $aItems); 

    if(osc_count_items() > 0) {
      echo '<div id="rel-block" class="related products grid"><div class="inside">';
      echo '<h3>' . __('You may also like ...', 'gamma') . '</h3>';
      echo '<div class="block">';

      echo '<div class="nice-scroll-left"></div>';
      echo '<div class="nice-scroll-right"></div>';

      echo '<div class="wrap nice-scroll">';

      $c = 1;
      while(osc_has_items()) {
        gam_draw_item($c);
        $c++;
      }

      echo '</div></div></div></div>';
    }

    GLOBAL $stored_items;
    View::newInstance()->_exportVariableToView('items', $global_items);
  }
}


// GET LOCALE SELECT FOR PUBLISH PAGE
function gam_locale_post_links() {
  $c = osc_current_user_locale();

  $html = '';
  $locales = osc_get_locales();

  if(count($locales) > 0) {
    $html .= '<div class="locale-links">';

    foreach($locales as $l) {
      $html .= '<a href="#" data-locale="' . $l['pk_c_code'] . '" data-name="' . $l['s_name'] . '" class="mbBg3Active' . ($c == $l['pk_c_code'] ? ' active' : '') . '">' . $l['s_short_name'] . '</a>';
    }

    $html .= '</div>';
  }

  return $html;
}


// GET PROPER PROFILE IMAGE
function gam_profile_picture($user_id = NULL, $size = 'small') {
  $user_id = ($user_id > 0 ? $user_id : 0);
  
  if(View::newInstance()->_exists('gam_profile_picture_url_' . $user_id)) {
    return View::newInstance()->_get('gam_profile_picture_url_' . $user_id);
  }
 
  // if($user_id === NULL) {
    // $user_id = osc_item_user_id();
    // $user_id = ($user_id > 0 ? $user_id : osc_premium_user_id());
  // }

  if($size == 'small') {
    $dimension = 36;
  } else if($size == 'medium') {
    $dimension = 128;
  } else {
    $dimension = 256;
  }

  $img = '';


  // GET IMAGE FROM PROFILE PICTURE FIRST
  if($user_id > 0) {
    if(function_exists('profile_picture_show')) {
      $conn = getConnection();
      $result = $conn->osc_dbFetchResult("SELECT user_id, pic_ext FROM %st_profile_picture WHERE user_id = '%d' ", DB_TABLE_PREFIX, $user_id);

      if($result > 0) { 
        $path = osc_plugins_path().'profile_picture/images/';

        if(file_exists($path . 'profile' . $user_id . $result['pic_ext'])) { 
          $img = osc_base_url() . 'oc-content/plugins/profile_picture/images/' . 'profile' . $user_id . $result['pic_ext'];
        }
      }
    } else if(osc_profile_img_users_enabled()) {
      $img = gam_user_profile_img_url($user_id);
    }
  }

  if($img == '') {
    $img = osc_current_web_theme_url('images/default-user-image.png');
  }

  View::newInstance()->_exportVariableToView('gam_profile_picture_url_' . $user_id, $img);
  
  return $img;
}


// CUSTOMIZED USER PROFILE IMG URL FUNCTION
function gam_user_profile_img_url($id = null) {
  return (string) osc_apply_filter('user_profile_img_url', osc_base_url(). 'oc-content/uploads/user-images/' . gam_user_profile_img($id));
}


// CUSTOMIZED USER PROFILE IMG FUNCTION
function gam_user_profile_img($id = null) {
  if($id === 0) {
    $img = 'default-user-image.png';
  } else if($id !== null) {
    $user = gam_get_user($id);
    $img = isset($user['s_profile_img']) ? $user['s_profile_img'] : '';
  } else {
    $img = osc_user_field("s_profile_img");
  }

  if($img === NULL || trim($img) == '') {
    $img = 'default-user-image.png';
  }

  return (string) $img;
}


// CHECK IF USER HAS PROFILE PICTURE
function gam_has_profile_picture($user_id) {
  $img = gam_profile_picture($user_id);
  
  if(strpos($img, 'no-user') !== false || strpos($img, 'default-user-image') !== false || strpos($img, 'no-image') !== false) {
    return false;
  }
  
  return true;  
}

// GET USER DATA AND STORE INTO SESSION
function gam_get_user($id) {
  if($id > 0) {
    if(!View::newInstance()->_exists('gam_user_' . $id)) {
      View::newInstance()->_exportVariableToView('gam_user_' . $id, User::newInstance()->findByPrimaryKey($id));
    }
    
    return View::newInstance()->_get('gam_user_' . $id);
  }
  
  return false;
}



// GET SEARCH PARAMS FOR REMOVE
function gam_search_param_remove() {
  $params = Params::getParamsAsArray();
  $output = array();

  foreach($params as $n => $v) {
    if(!in_array($n, array('page')) && ($v > 0 || $v <> '')) {
      $output[$n] = array(
        'value' => $v, 
        'param' => $n,
        'title' => gam_param_name($n),
        'name' => gam_remove_value_name($v, $n)
      );
    }
  }

  return $output;
}


// GET NAME FOR REMOVE PARAMETER
function gam_remove_value_name($value, $type) {
  $def_cur = (gam_param('def_cur') <> '' ? gam_param('def_cur') : '$');

  if($type == 'sPeriod') {  
    return gam_get_simple_name($value, 'period');

  } else if($type == 'sTransaction') {  
    return gam_get_simple_name($value, 'transaction');

  } else if($type == 'sCondition') {  
    return gam_get_simple_name($value, 'condition');

  } else if ($type == 'sCategory' || $type == 'category') {
    if(@osc_search_category_id()[0] > 0) {
      $category = Category::newInstance()->findByPrimaryKey(osc_search_category_id()[0]);
      return $category['s_name'];
    }

  } else if ($type == 'sCountry' || $type == 'country') {
    return osc_search_country();

  } else if ($type == 'sRegion' || $type == 'region') {
    return osc_search_region();

  } else if ($type == 'sCity' || $type == 'city') {
    return osc_search_city();
  
  } else if ($type == 'sPriceMin' || $type == 'sPriceMax') {
    return $value . ' ' . $def_cur;

  } else if ($type == 'sPattern') {
    return $value;

  }  else if ($type == 'user' || $type == 'sUser' || $type == 'userId') {
    if(is_numeric($value)) {
      $usr = User::newInstance()->findByPrimaryKey($value);
      return (@$usr['s_name'] <> '' ? @$usr['s_name'] : $value);
    } else {
      return $value;
    }

  }  else if ($type == 'bPic') {
    return ($value == 1 ? __('Yes', 'gamma') : __('No', 'gamma'));

  }  else if ($type == 'bPremium') {
    return ($value == 1 ? __('Yes', 'gamma') : __('No', 'gamma'));

  }
}


// GET PARAMETER NICE NAME
function gam_param_name($param) {
  if($param == 'sTransaction') {
    return __('Transaction', 'gamma');

  } else if($param == 'sCondition') {
    return __('Condition', 'gamma');

  } else if($param == 'user' || $param == 'sUser' || $param == 'userId') {
    return __('User', 'gamma');

  } else if($param == 'sCategory' || $param == 'category') {
    return __('Category', 'gamma');

  } else if($param == 'sPeriod') {
    return __('Age', 'gamma');

  } else if($param == 'sCountry' || $param == 'country') {
    return __('Country', 'gamma');

  } else if($param == 'sRegion' || $param == 'region') {
    return __('Region', 'gamma');

  } else if($param == 'sCity' || $param == 'city') {
    return __('City', 'gamma');

  } else if($param == 'bPic') {
    return __('Picture', 'gamma');

  } else if($param == 'bPremium') {
    return __('Premium', 'gamma');

  } else if($param == 'sPriceMin') {
    return __('Min', 'gamma');

  } else if($param == 'sPriceMax') {
    return __('Max', 'gamma');

  } else if($param == 'sPattern') {
    return __('Keyword', 'gamma');

  } 

  return '';
}


// LIST AVAILABLE OPTIONS
function gam_list_options($type) {
  $opt = array();

  if($type == 'condition') {
    $opt[0] = __('All', 'gamma');
    $opt[1] = __('New', 'gamma');
    $opt[2] = __('Used', 'gamma');

  } else if($type == 'transaction') {
    $opt[0] = __('All', 'gamma');
    $opt[1] = __('Sell', 'gamma');
    $opt[2] = __('Buy', 'gamma');
    $opt[3] = __('Rent', 'gamma');
    $opt[4] = __('Exchange', 'gamma');

  } else if ($type == 'period') {
    $opt[0] = __('All', 'gamma');
    $opt[1] = __('Yesterday', 'gamma');
    $opt[7] = __('Last week', 'gamma');
    //$opt[14] = __('Last 2 weeks', 'gamma');
    $opt[31] = __('Last month', 'gamma');
    //$opt[365] = __('Last year', 'gamma');

  } else if ($type == 'seller_type') {
    $opt[0] = __('All', 'gamma');
    $opt[1] = __('Personal', 'gamma');
    $opt[2] = __('Company', 'gamma');
  }

  return $opt;
}


// GET SIMPLE OPTION NAME
function gam_get_simple_name($id, $type) {
  $options = gam_list_options($type);
  return @$options[$id];
}


// DEFAULT LOCATION PICKER CONTENT
function gam_def_location() {
  $html = '';

  $type = (gam_param('def_locations') == '' ? 'region' : gam_param('def_locations'));

  $countries = Country::newInstance()->listAll();
  $limit = 50;
  $city_not_empty = 0;   // set to 0 to include also cities with no listings

  if($type == 'region') {
    $regions_cities = Region::newInstance()->listAll();
  }

  $type_name = ($type == 'region' ? __('region', 'gamma') : __('city', 'gamma'));


  foreach($countries as $c) {
    //$html .= '<div class="option country init" data-country="' . $c['pk_c_code'] . '" data-region="" data-city="" data-code="country' . $c['pk_c_code'] . '" id="' . $c['pk_c_code'] . '"><strong>' . osc_esc_js($c['s_name']) . '</strong></div>';

    if($type == 'city') {
      $regions_cities = ModelGAM::newInstance()->getCities($c['pk_c_code'], $limit, $city_not_empty);
    }

    $counter = 0;
    foreach($regions_cities as $r) {
      if($counter < $limit) {
        if(strtoupper($r['fk_c_country_code']) == strtoupper($c['pk_c_code'])) {
          if($type == 'region') {
            $html .= '<div class="option region init" data-country="' . $r['fk_c_country_code'] . '" data-region="' . $r['pk_i_id'] . '" data-city="" data-code="region' . $r['pk_i_id'] . '" id="' . $r['pk_i_id'] . '" title="' . osc_esc_js(osc_location_native_name_selector($c, 's_name')) . '"><strong>' . osc_esc_js(osc_location_native_name_selector($r, 's_name')) . '</strong></div>';
          } else { 
            $html .= '<div class="option region init" data-country="' . $r['fk_c_country_code'] . '" data-region="' . $r['fk_i_region_id'] . '" data-city="' . $r['pk_i_id'] . '" data-code="city' . $r['pk_i_id'] . '" title="' . osc_esc_js(osc_location_native_name_selector($r, 's_region_name')) . '" id="' . $r['pk_i_id'] . '"><strong>' . osc_esc_js(osc_location_native_name_selector($r, 's_name')) . '</strong></div>';
          }
        }
      }

      $counter++;
    }

    if($counter == $limit*count($countries)) {
      $html .= '<div class="option service empty-pick default" data-country="" data-region="" data-city="" data-code="" id=""><em>' . osc_esc_js(sprintf(__('... and %d more %s, enter your %s name to refine results', 'gamma'), $limit, $type_name, $type_name)) . '</em></div>';
    }
  }

  echo $html;
}


// DEFAULT LOCATION PICKER CONTENT
function gam_locbox_short($country = '', $region = '', $city = '', $level = 'all') {
  $html = '';


  $countries = Country::newInstance()->listAll();
  $box_width = 140;

  // COUNTRIES
  if(count($countries) > 1 && ($level == 'all' || $level == 'country')) {
    //$html .= '<div class="loc-tab country-tab count' . count($countries) . (gam_param('loc_one_row') == 1 ? ' one-row' : '') . '">';

    $html .= '<div class="relative">';
    $html .= '<div class="nice-scroll-left ns-white"></div>';
    $html .= '<div class="nice-scroll-right ns-white"></div>';

    $html .= '<div class="loc-tab country-tab nice-scroll">';
    //$html .= '<div class="loc-in" style="' . (gam_param('loc_one_row') == 1 ? 'width:' . count($countries)*$box_width . 'px;' : '') . '">';

    foreach($countries as $c) {
      $html .= '<div class="elem country ' . (strtoupper($c['pk_c_code']) == strtoupper($country) ? 'active' : '') . '" data-country="' . $c['pk_c_code'] . '" data-region="" data-city="" style="' . (gam_param('loc_one_row') == 1 ? 'width:' . ($box_width + 1) . 'px;'  : '') . '"><img src="' . gam_country_flag_image(strtolower($c['pk_c_code'])) . '"/><strong>' . osc_location_native_name_selector($c, 's_name') . '</strong></div>';
    }

    //$html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
  } 

  
  // REGIONS
  if($level == 'all' || $level == 'region') {
    $html .= '<div class="loc-tab region-tab">';
    
    if(count($countries) <= 1 || $country <> '') {
      if($country <> '') {
        $regions = Region::newInstance()->findByCountry($country);
      } else {
        $regions = Region::newInstance()->listAll();
      }

      if(count($regions) > 0) {
        foreach($regions as $r) {
          $html .= '<div class="elem region ' . ($r['pk_i_id'] == $region ? 'active' : '') . '" data-country="' . $r['fk_c_country_code'] . '" data-region="' . $r['pk_i_id'] . '" data-city="">' . osc_location_native_name_selector($r, 's_name') . ' <i class="fa fa-angle-right"></i></div>';
        }
      }
    }

    $html .= '</div>';
  }


  // CITIES
  if($level == 'all' || $level == 'city') {
    $html .= '<div class="loc-tab city-tab">';
    
    if($region <> '') {
      $cities = City::newInstance()->findByRegion($region);

      if(count($cities) > 0) {
        foreach($cities as $ct) {
          $html .= '<div class="elem city ' . ($ct['pk_i_id'] == $city ? 'active' : '') . '" data-country="' . $ct['fk_c_country_code'] . '" data-region="' . $ct['fk_i_region_id'] . '" data-city="' . $ct['pk_i_id'] . '">' . osc_location_native_name_selector($ct, 's_name') . ' <i class="fa fa-angle-right"></i></div>';
        }
      }
    }

    $html .= '</div>';
  }


  echo $html;
}


// DEFAULT LOCATION PICKER CONTENT
function gam_catbox_short($cat_id = '') {
  $html = '';
  $level = 1;

  $hierarchy = Category::newInstance()->hierarchy($cat_id);
  $hierarchy = array_column($hierarchy, 'pk_i_id');

  $hierarchy_last_subs = Category::newInstance()->findSubcategoriesEnabled(isset($hierarchy[0]) ? $hierarchy[0] : null);

  if(count($hierarchy_last_subs) > 0) {
    $hierarchy[] = -1;   // add one fake id to increase number of columns shown
  }

  $categories = Category::newInstance()->toTree();

  gam_catbox_loop($categories, $hierarchy, $level);


  echo $html;
}


function gam_catbox_loop($categories, $hierarchy, $level) {
  $html = '';

  if(count($categories) > 0) {
    $one_row = false;

    if($categories[0]['fk_i_parent_id'] <= 0 && gam_param('cat_one_row') == 1) {
      $one_row = true;
    }

    $box_width = 140;


    $html .= '<div class="cat-tab ' . ($categories[0]['fk_i_parent_id'] <= 0 ? 'root ' . (empty($hierarchy) ? 'active' : '') : 'sub') . ' ' . (in_array($categories[0]['fk_i_parent_id'], $hierarchy) ? 'active' : '') . ($one_row === true ? 'one-row' : '') . '" data-parent="' . $categories[0]['fk_i_parent_id'] . '" data-level="' . $level . '">';
    $html .= '<div class="cat-in" style="' . ($one_row === true ? 'width:' . count($categories)*$box_width . 'px;' : '') . '">';

    foreach($categories as $c) {
      $html .= '<div class="elem category ' . (in_array($c['pk_i_id'], $hierarchy) ? 'active' : '') . ' ' . (count($c['categories']) > 0 ? 'has' : 'blank') . '" data-category="' . $c['pk_i_id'] . '" style="' . ($one_row === true ? 'width:' . ($box_width + 1) . 'px;'  : '') . '">';

      if($c['fk_i_parent_id'] <= 0) {
        $html .= '<div class="img">' . gam_get_cat_icon( $c['pk_i_id'] ) . '</div> <strong><span>' . $c['s_name'] . '</span></strong>';
      } else {
        $html .= $c['s_name'] . '<i class="fa fa-angle-right"></i>';
      }


      $html .= '</div>';
    }

    $html .= '</div>';
    $html .= '</div>';

    echo $html;

    if($level == 1) {
      echo '<div class="wrapper" data-columns="' . max(count($hierarchy) - 1, 0) . '">';
    }

    // loop for children separately
    foreach($categories as $c) {
      if(count($c['categories']) > 0) {                // && $level + 1 <= 4
        gam_catbox_loop($c['categories'], $hierarchy, $level + 1);
      }
    }

    if($level == 1) {
      echo '</div>';  // end wrapper
    }
  }



}



// COUNT COUNTRIES
function gam_count_countries() {
  $countries = Country::newInstance()->listAll();
  return count($countries);
}


// GET CORRECT FANCYBOX URL
function gam_fancy_url($type, $params = array()) {
  if(osc_rewrite_enabled()) {
    $url = '?type=' . $type;
  } else {
    $url = '&type=' . $type;
  }

  $extra = '';

  if(!empty($params) && is_array($params)) {
    foreach($params as $n => $v) {
      $extra .= '&' . $n . '=' . $v;
    }
  }

  return gam_item_send_friend_url() . $url . $extra;
}


// CUSTOM SEND FRIEND URL
function gam_item_send_friend_url($item_id = '') {
  if($item_id <= 0) {
    $item_id = (osc_item_id() > 0 ? osc_item_id() : osc_premium_id());
  }

  if(osc_rewrite_enabled()) {
    return osc_base_url() . osc_get_preference('rewrite_item_send_friend') . '/' . $item_id;
  } else {
    return osc_base_url(true)."?page=item&action=send_friend&id=" . $item_id;
  }
}


// GET CORRECT BLOCK ON REGISTER PAGE
function gam_reg_url($type) {
  if(osc_rewrite_enabled()) {
    $reg_url = '?move=' . $type;
  } else {
    $reg_url = '&move=' . $type;
  }

 return osc_register_account_url() . $reg_url;
}


// UPDATE PAGINATION ARROWS
function gam_fix_arrow($data) {
  $data = str_replace('&lt;', '<i class="fa fa-angle-left"></i>', $data);
  $data = str_replace('&gt;', '<i class="fa fa-angle-right"></i>', $data);
  $data = str_replace('&laquo;', '<i class="fa fa-angle-double-left"></i>', $data);
  $data = str_replace('&raquo;', '<i class="fa fa-angle-double-right"></i>', $data);

  return $data;
}


// GET THEME PARAM
function gam_param($name) {
  return osc_get_preference($name, 'theme-gamma');
}


// CHECK IF PRICE ENABLED ON CATEGORY
function gam_check_category_price($id) {
  if(!osc_price_enabled_at_items()) {
    return false;
  } else if(!isset($id) || $id == '' || $id <= 0) {
    return true;
  } else {
    $category = Category::newInstance()->findByPrimaryKey($id);
    if(isset($category['b_price_enabled'])) {
      return ($category['b_price_enabled'] == 0 ? false : true);
    }
    
    return true;
  }
}



// FLAT CATEGORIES CONTENT (Publish)
function gam_flat_categories() {
  return '<div id="flat-cat-fancy" style="display:none;overflow:hidden;">' . gam_category_loop() . '</div>';
}


// SMART DATE
function gam_smart_date( $time ) {
  $time_diff = round(abs(time() - strtotime( $time )) / 60);
  $time_diff_h = floor($time_diff/60);
  $time_diff_d = floor($time_diff/1440);
  $time_diff_w = floor($time_diff/10080);
  $time_diff_m = floor($time_diff/43200);
  $time_diff_y = floor($time_diff/518400);


  if($time_diff < 2) {
    $time_diff_name = __('minute ago', 'gamma');
  } else if ($time_diff < 60) {
    $time_diff_name = sprintf(__('%d minutes ago', 'gamma'), $time_diff);
  } else if ($time_diff < 120) {
    $time_diff_name = sprintf(__('%d hour ago', 'gamma'), $time_diff_h);
  } else if ($time_diff < 1440) {
    $time_diff_name = sprintf(__('%d hours ago', 'gamma'), $time_diff_h);
  } else if ($time_diff < 2880) {
    $time_diff_name = sprintf(__('%d day ago', 'gamma'), $time_diff_d);
  } else if ($time_diff < 10080) {
    $time_diff_name = sprintf(__('%d days ago', 'gamma'), $time_diff_d);
  } else if ($time_diff < 20160) {
    $time_diff_name = sprintf(__('%d week ago', 'gamma'), $time_diff_w);
  } else if ($time_diff < 43200) {
    $time_diff_name = sprintf(__('%d weeks ago', 'gamma'), $time_diff_w);
  } else if ($time_diff < 86400) {
    $time_diff_name = sprintf(__('%d month ago', 'gamma'), $time_diff_m);
  } else if ($time_diff < 518400) {
    $time_diff_name = sprintf(__('%d months ago', 'gamma'), $time_diff_m);
  } else if ($time_diff < 1036800) {
    $time_diff_name = sprintf(__('%d year ago', 'gamma'), $time_diff_y);
  } else {
    $time_diff_name = sprintf(__('%d years ago', 'gamma'), $time_diff_y);
  }

  return $time_diff_name;
}


// SMART DATE2
function gam_smart_date2( $time ) {
  $time_diff = round(abs(time() - strtotime( $time )) / 60);
  $time_diff_h = floor($time_diff/60);
  $time_diff_d = floor($time_diff/1440);
  $time_diff_w = floor($time_diff/10080);
  $time_diff_m = floor($time_diff/43200);
  $time_diff_y = floor($time_diff/518400);


  if ($time_diff < 10080) {
    $time_diff_name = sprintf(__('%d+ days', 'gamma'), $time_diff_d);
  } else if ($time_diff < 20160) {
    $time_diff_name = sprintf(__('%d+ week', 'gamma'), $time_diff_w);
  } else if ($time_diff < 43200) {
    $time_diff_name = sprintf(__('%d+ weeks', 'gamma'), $time_diff_w);
  } else if ($time_diff < 86400) {
    $time_diff_name = sprintf(__('%d+ month', 'gamma'), $time_diff_m);
  } else if ($time_diff < 518400) {
    $time_diff_name = sprintf(__('%d+ months', 'gamma'), $time_diff_m);
  } else if ($time_diff < 1036800) {
    $time_diff_name = sprintf(__('%d+ year', 'gamma'), $time_diff_y);
  } else {
    $time_diff_name = sprintf(__('%d+ years', 'gamma'), $time_diff_y);
  }

  return $time_diff_name;
}




// CHECK IF ITEM MARKED AS SOLD-UNSOLD
function gam_check_sold(){
  $conn = DBConnectionClass::newInstance();
  $data = $conn->getOsclassDb();
  $comm = new DBCommandClass($data);

  $status = Params::getParam('markSold');
  $id = Params::getParam('itemId');
  $secret = Params::getParam('secret');
  $item_type = Params::getParam('itemType');

  if($status <> '' && $id <> '' && $id > 0) {
    $item = Item::newInstance()->findByPrimaryKey($id);

    if( $secret == $item['s_secret'] ) {
      //Item::newInstance()->dao->update(DB_TABLE_PREFIX.'t_item_gamma', array('i_sold' => $status), array('fk_i_item_id' => $item['pk_i_id']));
      $comm->update(DB_TABLE_PREFIX.'t_item_gamma', array('i_sold' => $status), array('fk_i_item_id' => $item['pk_i_id']));
 
      if (osc_rewrite_enabled()) {
        $item_type_url = '?itemType=' . $item_type;
      } else {
        $item_type_url = '&itemType=' . $item_type;
      }

      header('Location: ' . osc_user_list_items_url() . $item_type_url);
    }
  }
}

osc_add_hook('header', 'gam_check_sold');



// HELP FUNCTION TO GET CATEGORIES
function gam_category_loop( $parent_id = NULL, $parent_color = NULL ) {
  $parent_color = isset($parent_color) ? $parent_color : NULL;

  if(Params::getParam('sCategory') <> '') {
    $id = Params::getParam('sCategory');
  } else if (gam_get_session('sCategory') <> '' && (osc_is_publish_page() || osc_is_edit_page())) {
    $id = gam_get_session('sCategory');
  } else if (osc_item_category_id() <> '') {
    $id = osc_item_category_id();
  } else {
    $id = '';
  }


  if($parent_id <> '' && $parent_id > 0) {
    $categories = Category::newInstance()->findSubcategoriesEnabled( $parent_id );
  } else {
    $parent_id = 0;
    $categories = Category::newInstance()->findRootCategoriesEnabled();
  }

  $html = '<div class="flat-wrap' . ($parent_id == 0 ? ' root' : '') . '" data-parent-id="' . $parent_id . '">';
  $html .= '<div class="single info">' . __('Select category', 'gamma') . ' ' . ($parent_id <> 0 ? '<span class="back tr1 round2"><i class="fa fa-angle-left"></i> ' . __('Back', 'gamma') . '</span>' : '') . '</div>';

  foreach( $categories as $c ) {
    if( $parent_id == 0) {
      $parent_color = gam_get_cat_color( $c['pk_i_id'] );
      $icon = '<div class="parent-icon" style="background:' . gam_get_cat_color( $c['pk_i_id'] ) . ';">' . gam_get_cat_icon( $c['pk_i_id'] ) . '</div>';
    } else {
      $icon = '<div class="parent-icon children" style="background: ' . $parent_color . '">' . gam_get_cat_icon( $c['pk_i_id'] ) . '</div>';
    }
    
    $html .= '<div class="single tr1' . ($c['pk_i_id'] == $id ? ' selected' : '') . '" data-id="' . $c['pk_i_id'] . '"><span>' . $icon . $c['s_name'] . '</span></div>';

    $subcategories = Category::newInstance()->findSubcategoriesEnabled( $c['pk_i_id'] );
    if(isset($subcategories[0])) {
      $html .= gam_category_loop( $c['pk_i_id'], $parent_color );
    }
  }
  
  $html .= '</div>';
  return $html;
}



// FLAT CATEGORIES SELECT (Publish)
function gam_flat_category_select(){  
  $root = Category::newInstance()->findRootCategoriesEnabled();

  $html = '<div class="category-box tr1">';
  foreach( $root as $c ) {
    $html .= '<div class="option tr1" style="background:' . gam_get_cat_color( $c['pk_i_id'] ) . ';">' . gam_get_cat_icon( $c['pk_i_id'] ) . '</div>';
  }
 
  $html .= '</div>';
  return $html;
}



// GET CITY, REGION, COUNTRY FOR AJAX LOADER
function gam_ajax_city() {
  $user = osc_user();
  $item = osc_item();

  if(Params::getParam('sCity') <> '') {
    return Params::getParam('sCity');
  } else if (isset($item['fk_i_city_id']) && $item['fk_i_city_id'] <> '') {
    return $item['fk_i_city_id'];
  } else if (isset($user['fk_i_city_id']) && $user['fk_i_city_id'] <> '') {
    return $user['fk_i_city_id'];
  }
}


function gam_ajax_region() {
  $user = osc_user();
  $item = osc_item();

  if(Params::getParam('sRegion') <> '') {
    return Params::getParam('sRegion');
  } else if (isset($item['fk_i_region_id']) && $item['fk_i_region_id'] <> '') {
    return $item['fk_i_region_id'];
  } else if (isset($user['fk_i_region_id']) && $user['fk_i_region_id'] <> '') {
    return $user['fk_i_region_id'];
  }
}


function gam_ajax_country() {
  $user = osc_user();
  $item = osc_item();

  if(Params::getParam('sCountry') <> '') {
    return Params::getParam('sCountry');
  } else if (isset($item['fk_c_country_code']) && $item['fk_c_country_code'] <> '') {
    return $item['fk_c_country_code'];
  } else if (isset($user['fk_c_country_code']) && $user['fk_c_country_code'] <> '') {
    return $user['fk_c_country_code'];
  }
}



// USER ACCOUNT - TOP MENU
function gam_user_menu_top() {

  if(isset($_SERVER['HTTPS'])) {
    $protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
  } else {
    $protocol = 'http';
  }

  $current_url =  $protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];


  $options = array();
  $options[] = array('name' => __('My listings', 'gamma'), 'url' => osc_user_list_items_url(), 'class' => 'opt_items', 'icon' => 'fa-folder-o', 'section' => 1, 'count' => 0);
  //$options[] = array('name' => __('Active', 'gamma'), 'url' => osc_user_list_items_url() . $s_active, 'class' => 'opt_active_items', 'icon' => 'fa-check-square-o', 'section' => 1, 'count' => $c_active, 'is_active' => $yes_active);
  //$options[] = array('name' => __('Not Validated', 'gamma'), 'url' => osc_user_list_items_url() . $s_pending, 'class' => 'opt_not_validated_items', 'icon' => 'fa-stack-overflow', 'section' => 1, 'count' => $c_pending, 'is_active' => $yes_pending);
  //$options[] = array('name' => __('Expired', 'gamma'), 'url' => osc_user_list_items_url() . $s_expired, 'class' => 'opt_expired_items', 'icon' => 'fa-times-circle', 'section' => 1, 'count' => $c_expired, 'is_active' => $yes_expired);
  //$options[] = array('name' => __('Dashboard', 'gamma'), 'url' => osc_user_dashboard_url(), 'class' => 'opt_dashboard', 'icon' => 'fa-dashboard', 'section' => 2);
  $options[] = array('name' => __('Alerts', 'gamma'), 'url' => osc_user_alerts_url(), 'class' => 'opt_alerts', 'icon' => 'fa-bullhorn', 'section' => 2);
  $options[] = array('name' => __('My profile', 'gamma'), 'url' => osc_user_profile_url(), 'class' => 'opt_account', 'icon' => 'fa-file-text-o', 'section' => 2);
  $options[] = array('name' => __('Public profile', 'gamma'), 'url' => osc_user_public_profile_url(), 'class' => 'opt_publicprofile', 'icon' => 'fa-picture-o', 'section' => 2);
  $options[] = array('name' => __('Logout', 'gamma'), 'url' => osc_user_logout_url(), 'class' => 'opt_logout', 'icon' => 'fa-sign-out', 'section' => 3);

  $options = osc_apply_filter('user_menu_filter', $options);


  echo '<div class="user-top-menu">';
  echo '<ul class="umenu nice-scroll">';

  foreach($options as $o) {
    if($o['section'] == 1) {
      $o['icon'] = isset($o['icon']) ? ($o['icon'] <> '' ? $o['icon'] : 'fa-dot-circle-o') : 'fa-dot-circle-o';

      if( isset($o['is_active']) && $o['is_active'] == 1 || $current_url == $o['url'] || strpos($current_url, osc_user_list_items_url()) !== false ) {
        $active_class =  ' active';
      } else {
        $active_class = '';
      }

      echo '<li class="' . $o['class'] . $active_class . '" ><a href="' . $o['url'] . '" >' . $o['name'] . '</a></li>';
    }
  }

  osc_run_hook('user_menu_items');



  foreach($options as $o) {
    if($o['section'] == 2) {
      $active_class = ($current_url == $o['url'] ? ' active' : '');
      echo '<li class="' . $o['class'] . $active_class . '" ><a href="' . $o['url'] . '" >' . $o['name'] . '</a></li>';
    }
  }

  osc_run_hook('user_menu');

  echo '</ul>';
  echo '</div>';
}



// USER ACCOUNT - MENU ELEMENTS
function gam_user_menu() {
  $sections = array('items', 'profile', 'logout');

  if(isset($_SERVER['HTTPS'])) {
    $protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
  } else {
    $protocol = 'http';
  }

  $current_url =  $protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];



  $options = array();
  $options[] = array('name' => __('My listings', 'gamma'), 'url' => osc_user_list_items_url(), 'class' => 'opt_items', 'icon' => 'far fa-folder', 'section' => 1, 'count' => 0);
  //$options[] = array('name' => __('Active', 'gamma'), 'url' => osc_user_list_items_url() . $s_active, 'class' => 'opt_active_items', 'icon' => 'far fa-check-square', 'section' => 1, 'count' => $c_active, 'is_active' => $yes_active);
  //$options[] = array('name' => __('Not Validated', 'gamma'), 'url' => osc_user_list_items_url() . $s_pending, 'class' => 'opt_not_validated_items', 'icon' => 'fab fa-stack-overflow', 'section' => 1, 'count' => $c_pending, 'is_active' => $yes_pending);
  //$options[] = array('name' => __('Expired', 'gamma'), 'url' => osc_user_list_items_url() . $s_expired, 'class' => 'opt_expired_items', 'icon' => 'fas fa-times-circle', 'section' => 1, 'count' => $c_expired, 'is_active' => $yes_expired);
  //$options[] = array('name' => __('Dashboard', 'gamma'), 'url' => osc_user_dashboard_url(), 'class' => 'opt_dashboard', 'icon' => 'fas fa-dashboard', 'section' => 2);
  $options[] = array('name' => __('Alerts', 'gamma'), 'url' => osc_user_alerts_url(), 'class' => 'opt_alerts', 'icon' => 'far fa-bell', 'section' => 2);
  $options[] = array('name' => __('My profile', 'gamma'), 'url' => osc_user_profile_url(), 'class' => 'opt_account', 'icon' => 'far fa-edit', 'section' => 2);
  $options[] = array('name' => __('Public profile', 'gamma'), 'url' => osc_user_public_profile_url(), 'class' => 'opt_publicprofile', 'icon' => 'far fa-address-card', 'section' => 2);
  $options[] = array('name' => __('Logout', 'gamma'), 'url' => osc_user_logout_url(), 'class' => 'opt_logout', 'icon' => 'fas fa-sign-out', 'section' => 3);

  $options = osc_apply_filter('user_menu_filter', $options);


  // SECTION 1 - LISTINGS

  foreach($options as $o) {
    if($o['section'] == 1) {
      $o['icon'] = isset($o['icon']) ? ($o['icon'] <> '' ? $o['icon'] : 'far fa-dot-circle') : 'far fa-dot-circle';

      if( isset($o['is_active']) && $o['is_active'] == 1 || $current_url == $o['url'] ) {
        $active_class =  ' active';
      } else {
        $active_class = '';
      }

      echo '<a href="' . $o['url'] . '" class="' . $o['class'] . ' ' . $active_class . '" ><i class="' . $o['icon'] . '"></i>' . $o['name'] . '</a>';
    }
  }

  osc_run_hook('user_menu_items');



  // SECTION 2 - PROFILE & USER

  foreach($options as $o) {
    if($o['section'] == 2) {
      $active_class = ($current_url == $o['url'] ? ' active' : '');
      $o['icon'] = isset($o['icon']) ? ($o['icon'] <> '' ? $o['icon'] : 'far fa-dot-circle') : 'far fa-dot-circle';
      echo '<a href="' . $o['url'] . '" class="' . $o['class'] . ' ' . $active_class . '" ><i class="' . $o['icon'] . '"></i>' . $o['name'] . '</a>';
    }
  }


  echo '<div class="hook-options">';
    osc_run_hook('user_menu');
  echo '</div>';


  

  // SECTION 3 - LOGOUT
  foreach($options as $o) {
    if($o['section'] == 3) {
      $o['icon'] = isset($o['icon']) ? ($o['icon'] <> '' ? $o['icon'] : 'far fa-dot-circle') : 'far fa-dot-circle';
      echo '<a href="' . $o['url'] . '" class="' . $o['class'] . ' ' . $active_class . '" ><i class="' . $o['icon'] . '"></i>' . $o['name'] . '</a>';
    }
  }
}



// GET TERM NAME BASED ON COUNTRY, REGION & CITY
function gam_get_term($term = '', $country = '', $region = '', $city = ''){
  if( $term == '') {
    if( $city <> '' && is_numeric($city) ) {
      $city_info = City::newInstance()->findByPrimaryKey( $city );
      return (osc_location_native_name_selector($city_info, 's_name') <> '' ? osc_location_native_name_selector($city_info, 's_name') : $city);
    }
 
    if( $region <> '' && is_numeric($region) ) {
      $region_info = Region::newInstance()->findByPrimaryKey( $region );
      return (osc_location_native_name_selector($region_info, 's_name') <> '' ? osc_location_native_name_selector($region_info, 's_name') : $region);
    }

    if( $country <> '' && strlen($country) == 2 ) {
      $country_info = Country::newInstance()->findByCode( $country );
      return (osc_location_native_name_selector($country_info, 's_name') <> '' ? osc_location_native_name_selector($country_info, 's_name') : $country);
    }

    $array = array_filter(array($city, $region, $country));
    return @$array[0]; // if all fail, return first non-empty

  } else {
    return $term;
  }
}


// GET LOCATION FULL NAME BASED ON COUNTRY, REGION & CITY
function gam_get_full_loc($country = '', $region = '', $city = ''){
  if( $city <> '' && is_numeric($city) ) {
    $city_info = City::newInstance()->findByPrimaryKey( $city );
    $region_info = Region::newInstance()->findByPrimaryKey( $city_info['fk_i_region_id'] );
    $country_info = Country::newInstance()->findByCode( $city_info['fk_c_country_code'] );
    return osc_location_native_name_selector($city_info, 's_name') . ', ' . osc_location_native_name_selector($region_info, 's_name') . ', ' . osc_location_native_name_selector($country_info, 's_name');
  }

  if( $region <> '' && is_numeric($region) ) {
    $region_info = Region::newInstance()->findByPrimaryKey( $region );
    $country_info = Country::newInstance()->findByCode( $region_info['fk_c_country_code'] );

    return osc_location_native_name_selector($region_info, 's_name') . ', ' . osc_location_native_name_selector($country_info, 's_name');
  }

  if( $country <> '' && strlen($country) == 2 ) {
    $country_info = Country::newInstance()->findByCode( $country );
    return osc_location_native_name_selector($country_info, 's_name');
  }

  return '';
}



// ADD TRANSACTION AND CONDITION TO OC-ADMIN EDIT ITEM
function gam_extra_add_admin( $catId = null, $item_id = null ){
  if(defined('OC_ADMIN') && OC_ADMIN === true) {
    if($item_id > 0) {
      $item = Item::newInstance()->findByPrimaryKey( $item_id );
      $item_extra = gam_item_extra( $item_id );

      echo '<div class="control-group">';
      echo '<label class="control-label" for="sTransaction">' . __('Transaction', 'gamma') . '</label>';
      echo '<div class="controls">' . gam_simple_transaction(true, $item_id <> '' ? $item_id : false) . '</div>';
      echo '</div>';

      echo '<div class="control-group">';
      echo '<label class="control-label" for="sCondition">' . __('Condition', 'gamma') . '</label>';
      echo '<div class="controls">' . gam_simple_condition(true, $item_id <> '' ? $item_id : false) . '</div>';
      echo '</div>';

      echo '<div class="control-group">';
      echo '<label class="control-label" for="sPhone">' . __('Phone', 'gamma') . '</label>';
      echo '<div class="controls"><input type="text" name="sPhone" id="sPhone" value="' . $item_extra['s_phone'] . '" /></div>';
      echo '</div>';

      echo '<div class="control-group">';
      echo '<label class="control-label" for="sSold">' . __('Item Sold', 'gamma') . '</label>';
      echo '<div class="controls"><input type="checkbox" name="sSold" id="sSold" ' . ($item_extra['i_sold'] == 1 ? 'checked' : '') . ' /></div>';
      echo '</div>';
    }
  }
}

osc_add_hook('item_form', 'gam_extra_add_admin');
osc_add_hook('item_edit', 'gam_extra_add_admin');



function gam_extra_edit( $item ) {
  $item['pk_i_id'] = isset($item['pk_i_id']) ? $item['pk_i_id'] : 0;
  $detail = ModelAisItem::newInstance()->findByItemId( $item['pk_i_id'] );

  if( isset($detail['fk_i_item_id']) ) {
    ModelAisItem::newInstance()->updateItemMeta( $item['pk_i_id'], Params::getParam('ais_meta_title'), Params::getParam('ais_meta_description') );
  } else {
    ModelAisItem::newInstance()->insertItemMeta( $item['pk_i_id'], Params::getParam('ais_meta_title'), Params::getParam('ais_meta_description') );
  } 
}


// SIMPLE SEARCH SORT
function gam_simple_sort() {
  $type = Params::getParam('sOrder');           // date - price
  $order = Params::getParam('iOrderType');      // asc - desc

  $orders = osc_list_orders();


  //$html  = '<input type="hidden" name="sOrder" id="sOrder" val="' . $type . '"/>';
  //$html  = '<input type="hidden" name="iOrderType" id="iOrderType" val="' . $order . '"/>';

  $html  = '<select class="orderSelect" id="orderSelect" name="orderSelect">';
  
  foreach($orders as $label => $spec) {

    $selected = '';
    if( $spec['sOrder'] == $type && $spec['iOrderType'] == $order ) {
      $selected = ' selected="selected"';
    }
 
    $html .= '<option' . $selected . ' data-type="' . $spec['sOrder'] . '" data-order="' . $spec['iOrderType'] . '">' . $label . '</option>';
  }

  $html .= '</select>';

  return $html;
}


// SIMPLE CATEGORY SELECT
function gam_simple_category($select = false, $level = 3, $id = 'sCategory') {
  $categories = Category::newInstance()->toTree();
  $current = @osc_search_category_id()[0];
  $allow_parent = ($id == 'catId' ? osc_get_preference('selectable_parent_categories', 'osclass') : 1);

  if($id == 'catId') {   // publish-edit listing page
    $current = osc_item_category_id();
  }

  $c_category = Category::newInstance()->findByPrimaryKey($current);
  $root = Category::newInstance()->toRootTree($current);
  $root = isset($root[0]) ? $root[0] : array('pk_i_id' => $current, 's_name' => (isset($c_category['s_name']) ? $c_category['s_name'] : ''));


  if(!$select) {

    $html  = '<div class="simple-cat simple-select level' . $level . '">';
    $html .= '<input type="hidden" id="' . $id . '" name="' . $id . '" class="input-hidden ' . $id . '" value="' . $current . '"/>';
    $html .= '<span class="text round3 tr1"><span>' . ($c_category['s_name'] <> '' ? $c_category['s_name'] : __('Category', 'gamma')) . '</span> <i class="fa fa-angle-down"></i></span>';
    $html .= '<div class="list">';
    $html .= '<div class="option info">' . __('Choose one category', 'gamma') . '</div>';

    if($id <> 'catId') {
      $html .= '<div class="option bold' . ($root['pk_i_id'] == "" ? ' selected' : '') . '" data-id="">' . __('All', 'gamma') . '</div>';
    }

    // Root cat
    foreach($categories as $c) {
      $disable = false;
      if($allow_parent == 0 && count(@$c['categories']) > 0) { $disable = true; }

      $html .= '<div class="option ' . ($disable ? 'nonclickable' : '') . ' root' . ($root['pk_i_id'] == $c['pk_i_id'] ? ' selected' : '') . '" data-id="' . $c['pk_i_id'] . '">' . $c['s_name'] . '</span></div>';

      // Sub cat level 1
      if(count(@$c['categories']) > 0 && $level >= 1) { 
        foreach($c['categories'] as $s1) {
          $disable = false;
          if($allow_parent == 0 && count($s1['categories']) > 0) { $disable = true; }

          $html .= '<div class="option ' . ($disable ? 'nonclickable' : '') . ' sub1' . ($current == $s1['pk_i_id'] ? ' selected' : '') . '" data-id="' . $s1['pk_i_id'] . '">' . $s1['s_name'] . '</span></div>';

          // Sub cat level 2
          if(count($s1['categories']) > 0 && $level >= 2) { 
            foreach($s1['categories'] as $s2) {
              $disable = false;
              if($allow_parent == 0 && count($s2['categories']) > 0) { $disable = true; }

              $html .= '<div class="option ' . ($disable ? 'nonclickable' : '') . ' sub2' . ($current == $s2['pk_i_id'] ? ' selected' : '') . '" data-id="' . $s2['pk_i_id'] . '">' . $s2['s_name'] . '</span></div>';

              // Sub cat level 3
              if(count($s2['categories']) > 0 && $level >= 3) { 
                foreach($s2['categories'] as $s3) {
                  $html .= '<div class="option sub3' . ($current == $s3['pk_i_id'] ? ' selected' : '') . '" data-id="' . $s3['pk_i_id'] . '">' . $s3['s_name'] . '</span></div>';
                }
              }

            }
          }
        }
      }
    }

    $html .= '</div>';
    $html .= '</div>';

    return $html;

  } else {
    $html  = '<select class="' . $id . '" id="' . $id . '" name="' . $id . '">';
    $html .= '<option value="" ' . ($root['pk_i_id'] == "" ? ' selected="selected"' : '') . '>' . __('All categories', 'gamma') . '</option>';

    foreach($categories as $c) {
      $html .= '<option ' . ($root['pk_i_id'] == $c['pk_i_id'] ? ' selected="selected"' : '') . ' value="' . $c['pk_i_id'] . '">' . $c['s_name'] . '</option>';

      // Sub cat level 1
      if(count(@$c['categories']) > 0 && $level >= 1) { 
        foreach($c['categories'] as $s1) {
          $html .= '<option ' . ($current == $s1['pk_i_id'] ? ' selected="selected"' : '') . ' value="' . $s1['pk_i_id'] . '">- ' . $s1['s_name'] . '</option>';

          // Sub cat level 2
          if(count($s1['categories']) > 0 && $level >= 2) { 
            foreach($s1['categories'] as $s2) {
              $html .= '<option ' . ($current == $s2['pk_i_id'] ? ' selected="selected"' : '') . ' value="' . $s2['pk_i_id'] . '">-- ' . $s2['s_name'] . '</option>';

              // Sub cat level 3
              if(count($s2['categories']) > 0 && $level >= 3) { 
                foreach($s2['categories'] as $s3) {
                  $html .= '<option ' . ($current == $s3['pk_i_id'] ? ' selected="selected"' : '') . ' value="' . $s3['pk_i_id'] . '">--- ' . $s3['s_name'] . '</option>';
                }
              }

            }
          }
        }
      }
    }

    $html .= '</select>';

    return $html;

  }
}



// SIMPLE SELLER TYPE SELECT
function gam_simple_seller( $select = false ) {
  $id = Params::getParam('sCompany');

  if($id !== '' && $id !== null) {
    $id_mod = $id + 1;
  } else {
    $id_mod = 0;
  }

  $name = gam_get_simple_name($id_mod, 'seller_type');
  $name = ($name == '' ? __('Seller type', 'gamma') : $name);


  if( !$select ) {
    $html  = '<div class="simple-seller simple-select">';
    $html .= '<input type="hidden" name="sCompany" class="input-hidden" value="' . Params::getParam('sCompany') . '"/>';
    $html .= '<span class="text round3 tr1"><span>' . $name . '</span> <i class="fa fa-angle-down"></i></span>';
    $html .= '<div class="list">';
    $html .= '<div class="option info">' . __('Choose seller type', 'gamma') . '</div>';
    $html .= '<div class="option bold' . ($id_mod == 0 ? ' selected' : '') . '" data-id="">' . __('All', 'gamma') . '</div>';

    $html .= '<div class="option' . ($id_mod == "1" ? ' selected' : '') . '" data-id="0">' . __('Personal', 'gamma') . '</span></div>';
    $html .= '<div class="option' . ($id_mod == "2" ? ' selected' : '') . '" data-id="1">' . __('Company', 'gamma') . '</span></div>';

    $html .= '</div>';
    $html .= '</div>';

    return $html;

  } else {

    $html  = '<select class="sCompany" id="sCompany" name="sCompany">';
    $html .= '<option value="" ' . ($id_mod == "0" ? ' selected="selected"' : '') . '>' . __('All sellers', 'gamma') . '</option>';
    $html .= '<option value="0" ' . ($id_mod == "1" ? ' selected="selected"' : '') . '>' . __('Personal', 'gamma') . '</option>';
    $html .= '<option value="1" ' . ($id_mod == "2" ? ' selected="selected"' : '') . '>' . __('Company', 'gamma') . '</option>';
    $html .= '</select>';

    return $html;

  }
}



// SIMPLE TRANSACTION TYPE SELECT
function gam_simple_transaction( $select = false, $item_id = false ) {
  if((osc_is_publish_page() || osc_is_edit_page()) && gam_get_session('sTransaction') <> '') {
    $id = gam_get_session('sTransaction');
  } else {
    $id = Params::getParam('sTransaction');
  }

  if( $item_id == '' ) {
    $item_id = osc_item_id();
  }

  if( $item_id > 0 ) {
    $id = gam_item_extra( $item_id );
    $id = $id['i_transaction'];
  }

  $name = gam_get_simple_name($id, 'transaction');
  $name = ($name == '' ? __('Transaction', 'gamma') : $name);

  $options =  gam_list_options('transaction');


  if( !$select ) {
    $html  = '<div class="simple-transaction simple-select">';
    $html .= '<input type="hidden" name="sTransaction" class="input-hidden" value="' . $id . '"/>';
    $html .= '<span class="text round3 tr1"><span>' . $name . '</span> <i class="fa fa-angle-down"></i></span>';
    $html .= '<div class="list">';
    $html .= '<div class="option info">' . __('Choose transaction type', 'gamma') . '</div>';

    foreach($options as $n => $v) {
      $html .= '<div class="option ' . ($n == 0 ? 'bold' : '') . ($id == $n ? ' selected' : '') . '" data-id="' . $n . '">' . $v . '</span></div>';
    }

    $html .= '</div>';
    $html .= '</div>';

    return $html;

  } else {

    $html  = '<select class="sTransaction" id="sTransaction" name="sTransaction">';

    foreach($options as $n => $v) {
      $html .= '<option value="' . $n . '" ' . ($id == $n ? ' selected="selected"' : '') . '>' . $v . '</option>';
    }

    $html .= '</select>';

    return $html;

  }
}



// SIMPLE OFFER TYPE SELECT
function gam_simple_condition( $select = false, $item_id = false ) {
  if((osc_is_publish_page() || osc_is_edit_page()) && gam_get_session('sCondition') <> '') {
    $id = gam_get_session('sCondition');
  } else {
    $id = Params::getParam('sCondition');
  }

  if( $item_id == '' ) {
    $item_id = osc_item_id();
  }

  if( $item_id > 0 ) {
    $id = gam_item_extra( $item_id );
    $id = $id['i_condition'];
  }

  $name = gam_get_simple_name($id, 'condition');
  $name = ($name == '' ? __('Condition', 'gamma') : $name);

  $options =  gam_list_options('condition');


  if( !$select ) {
    $html  = '<div class="simple-condition simple-select">';
    $html .= '<input type="hidden" name="sCondition" class="input-hidden" value="' . $id . '"/>';
    $html .= '<span class="text round3 tr1"><span>' . $name . '</span> <i class="fa fa-angle-down"></i></span>';
    $html .= '<div class="list">';
    $html .= '<div class="option info">' . __('Choose condition of item', 'gamma') . '</div>';

    foreach($options as $n => $v) {
      $html .= '<div class="option ' . ($n == 0 ? 'bold' : '') . ($id == $n ? ' selected' : '') . '" data-id="' . $n . '">' . $v . '</span></div>';
    }

    $html .= '</div>';
    $html .= '</div>';

    return $html;

  } else {

    $html  = '<select class="sCondition" id="sCondition" name="sCondition">';

    foreach($options as $n => $v) {
      $html .= '<option value="' . $n . '" ' . ($id == $n ? ' selected="selected"' : '') . '>' . $v . '</option>';
    }

    $html .= '</select>';

    return $html;

  }
}



// SIMPLE CURRENCY SELECT (publish)
function gam_simple_currency() {
  $currencies = osc_get_currencies();
  $item = osc_item(); 

  if((osc_is_publish_page() || osc_is_edit_page()) && gam_get_session('currency') <> '') {
    $id = gam_get_session('currency');
  } else {
    $id = Params::getParam('currency');
  }

  $currency = $id <> '' ? $id : osc_get_preference('currency', 'osclass');

  if( isset($item['fk_c_currency_code']) ) {
    $default_key = $item['fk_c_currency_code'];
  } elseif( isset( $currency ) && $currency <> '' ) {
    $default_key = $currency;
  } else {
    $default_key = $currencies[0]['pk_c_code'];
  }

  if($default_key <> '') {
    $default_currency = Currency::newInstance()->findByPrimaryKey($default_key);
  } else {
    $default_currency = array('pk_c_code' => '', 's_description' => '');
  }

  $html  = '<div class="simple-currency simple-select">';
  $html .= '<input type="hidden" name="currency" id="currency" class="input-hidden" value="' . $default_currency['pk_c_code'] . '"/>';
  $html .= '<span class="text round3 tr1"><span>' . $default_currency['pk_c_code'] . ' (' . $default_currency['s_description'] . ')</span> <i class="fa fa-angle-down"></i></span>';
  $html .= '<div class="list">';
  $html .= '<div class="option info">' . __('Currency', 'gamma') . '</div>';

  foreach($currencies as $c) {
    $html .= '<div class="option' . ($c['pk_c_code'] == $default_key ? ' selected' : '') . '" data-id="' . $c['pk_c_code'] . '">' . $c['pk_c_code'] . ' (' . $c['s_description'] . ')</span></div>';
  }

  $html .= '</div>';
  $html .= '</div>';

  return $html;
}



// SIMPLE PRICE TYPE SELECT (publish)
function gam_simple_price_type() {
  $item = osc_item(); 

  // Item edit
  if( isset($item['i_price']) ) {
    if( $item['i_price'] > 0 ) {
      $default_key = 0;
      $default_name = '<i class="fa fa-pencil help"></i> ' . __('Enter price', 'gamma');
    } else if( $item['i_price'] == 0 ) {
      $default_key = 1;
      $default_name = '<i class="fa fa-cut help"></i> ' . __('Free', 'gamma');
    } else if( $item['i_price'] == '' ) {
      $default_key = 2;
      $default_name = '<i class="fa fa-phone help"></i> ' . __('Check with seller', 'gamma');
    } 
  
  // Item publish
  } else {
    $default_key = 0;
    $default_name = '<i class="fa fa-pencil help"></i> ' . __('Enter price', 'gamma');
  }


  $html  = '<div class="simple-price-type simple-select">';
  $html .= '<span class="text round3 tr1"><span>' . $default_name . '</span> <i class="fa fa-angle-down"></i></span>';
  $html .= '<div class="list">';
  $html .= '<div class="option info">' . __('Choose price type', 'gamma') . '</div>';

  $html .= '<div class="option' . ($default_key == 0 ? ' selected' : '') . '" data-id="0"><i class="fa fa-pencil help"></i> ' . __('Enter price', 'gamma') . '</span></div>';
  $html .= '<div class="option' . ($default_key == 1 ? ' selected' : '') . '" data-id="1"><i class="fa fa-cut help"></i> ' . __('Free', 'gamma') . '</span></div>';
  $html .= '<div class="option' . ($default_key == 2 ? ' selected' : '') . '" data-id="2"><i class="fa fa-phone help"></i> ' . __('Check with seller', 'gamma') . '</span></div>';

  $html .= '</div>';
  $html .= '</div>';

  return $html;
}


// SIMPLE PERIOD SELECT (search only)
function gam_simple_period( $select = false ) {
  $id = Params::getParam('sPeriod');

  $name = gam_get_simple_name($id, 'period');
  $name = ($name == '' ? __('Age', 'gamma') : $name);

  $options =  gam_list_options('period');


  if( !$select ) {
    $html  = '<div class="simple-period simple-select">';
    $html .= '<input type="hidden" name="sPeriod" class="input-hidden" value="' . $id . '"/>';
    $html .= '<span class="text round3 tr1"><span>' . $name . '</span> <i class="fa fa-angle-down"></i></span>';
    $html .= '<div class="list">';
    $html .= '<div class="option info">' . __('Choose period', 'gamma') . '</div>';

    foreach($options as $n => $v) {
      $html .= '<div class="option ' . ($n == 0 ? 'bold' : '') . ($id == $n ? ' selected' : '') . '" data-id="' . $n . '">' . $v . '</span></div>';
    }

    $html .= '</div>';
    $html .= '</div>';

    return $html;

  } else {

    $html  = '<select class="sPeriod" id="sPeriod" name="sPeriod">';

    foreach($options as $n => $v) {
      $html .= '<option value="" ' . ($id == $n ? ' selected="selected"' : '') . '>' . $v . '</option>';
    }

    $html .= '</select>';

    return $html;

  }
}


// SIMPLE PERIOD LIST
function gam_simple_period_list() {
  $id = Params::getParam('sPeriod');

  $name = gam_get_simple_name($id, 'period');
  $name = ($name == '' ? __('Age', 'gamma') : $name);

  $options =  gam_list_options('period');
  $params = gam_search_params_all();


  $html  = '<div class="simple-period simple-list">';
  $html .= '<input type="hidden" name="sPeriod" class="input-hidden" value="' . $id . '"/>';

  $html .= '<div class="list link-check-box">';

  foreach($options as $n => $v) {
    $params['sPeriod'] = $n;
    $html .= '<a href="' . osc_search_url($params) . '" ' . ($id == $n ? 'class="active"' : '') . ' data-name="sPeriod" data-val="' . $n . '">' . $v . '</a>';
  }

  $html .= '</div>';
  $html .= '</div>';

  return $html;
}


// SIMPLE TRANSACTION LIST
function gam_simple_transaction_list() {
  $id = Params::getParam('sTransaction');

  $name = gam_get_simple_name($id, 'transaction');
  $name = ($name == '' ? __('Transaction', 'gamma') : $name);

  $options =  gam_list_options('transaction');
  $params = gam_search_params_all();


  $html  = '<div class="simple-transaction simple-list">';
  $html .= '<input type="hidden" name="sTransaction" class="input-hidden" value="' . $id . '"/>';

  $html .= '<div class="list link-check-box">';

  foreach($options as $n => $v) {
    $params['sTransaction'] = $n;
    $html .= '<a href="' . osc_search_url($params) . '" ' . ($id == $n ? 'class="active"' : '') . ' data-name="sTransaction" data-val="' . $n . '">' . $v . '</a>';
  }

  $html .= '</div>';
  $html .= '</div>';

  return $html;
}


// SIMPLE CONDITION LIST
function gam_simple_condition_list() {
  $id = Params::getParam('sCondition');

  $name = gam_get_simple_name($id, 'condition');
  $name = ($name == '' ? __('Condition', 'gamma') : $name);

  $options =  gam_list_options('condition');
  $params = gam_search_params_all();


  $html  = '<div class="simple-condition simple-list">';
  $html .= '<input type="hidden" name="sCondition" class="input-hidden" value="' . $id . '"/>';

  $html .= '<div class="list link-check-box">';

  foreach($options as $n => $v) {
    $params['sCondition'] = $n;
    $html .= '<a href="' . osc_search_url($params) . '" ' . ($id == $n ? 'class="active"' : '') . ' data-name="sCondition" data-val="' . $n . '">' . $v . '</a>';
  }

  $html .= '</div>';
  $html .= '</div>';

  return $html;
}




// Cookies work
if(!function_exists('mb_set_cookie')) {
  function mb_set_cookie($name, $val) {
    Cookie::newInstance()->set_expires( 86400 * 30 );
    Cookie::newInstance()->push($name, $val);
    Cookie::newInstance()->set();
  }
}

if(!function_exists('mb_get_cookie')) {
  function mb_get_cookie($name) {
    return Cookie::newInstance()->get_value($name);
  }
}

if(!function_exists('mb_drop_cookie')) {
  function mb_drop_cookie($name) {
    Cookie::newInstance()->pop($name);
  }
}


// FIND ROOT CATEGORY OF SELECTED
function gam_category_root( $category_id ) {
  $category = Category::newInstance()->findRootCategory( $category_id );
  return $category;
}


// CHECK IF THEME IS DEMO
function gam_is_demo() {
  if(isset($_SERVER['HTTP_HOST']) && (strpos($_SERVER['HTTP_HOST'],'mb-themes') !== false || strpos($_SERVER['HTTP_HOST'],'abprofitrade') !== false)) {
    return true;
  } else {
    return false;
  }
}

// CREATE ITEM (in loop)
function gam_draw_item($c = NULL, $premium = false, $class = false) {
  if($premium){
    $filename ='loop-single-premium';
  } else {
    $filename = 'loop-single';
  }

  require WebThemes::newInstance()->getCurrentThemePath() . $filename . '.php';
}



// RANDOM LATEST ITEMS ON HOME PAGE
function gam_random_items($numItems = 10, $category = array(), $withPicture = false) {
  $max_items = osc_get_preference('maxLatestItems@home', 'osclass');

  if($max_items == '' or $max_items == 0) {
    $max_items = 24;
  }

  $numItems = $max_items;

  $withPicture = gam_param('latest_picture');
  $randomOrder = gam_param('latest_random');
  $premiums = gam_param('latest_premium');
  $category = gam_param('latest_category');



  $randSearch = Search::newInstance();
  $randSearch->dao->select(DB_TABLE_PREFIX.'t_item.* ');
  $randSearch->dao->from( DB_TABLE_PREFIX.'t_item use index (PRIMARY)' );

  // where
  $whe  = DB_TABLE_PREFIX.'t_item.b_active = 1 AND ';
  $whe .= DB_TABLE_PREFIX.'t_item.b_enabled = 1 AND ';
  $whe .= DB_TABLE_PREFIX.'t_item.b_spam = 0 AND ';

  if($premiums == 1) {
    $whe .= DB_TABLE_PREFIX.'t_item.b_premium = 1 AND ';
  }

  $whe .= '('.DB_TABLE_PREFIX.'t_item.b_premium = 1 || '.DB_TABLE_PREFIX.'t_item.dt_expiration >= \''. date('Y-m-d H:i:s').'\') ';

  if( $category <> '' and $category > 0 ) {
    $subcat_list = Category::newInstance()->findSubcategories( $category );
    $subcat_id = array();
    $subcat_id[] = $category;

    foreach( $subcat_list as $s) {
      $subcat_id[] = $s['pk_i_id'];
    }

    $listCategories = implode(', ', $subcat_id);

    $whe .= ' AND '.DB_TABLE_PREFIX.'t_item.fk_i_category_id IN ('.$listCategories.') ';
  }



  if($withPicture) {
    $prem_where = ' AND ' . $whe;

    $randSearch->dao->from( '(' . sprintf("select %st_item.pk_i_id FROM %st_item, %st_item_resource WHERE %st_item_resource.s_content_type LIKE '%%image%%' AND %st_item.pk_i_id = %st_item_resource.fk_i_item_id %s GROUP BY %st_item.pk_i_id ORDER BY %st_item.dt_pub_date DESC LIMIT %s", DB_TABLE_PREFIX, DB_TABLE_PREFIX, DB_TABLE_PREFIX, DB_TABLE_PREFIX, DB_TABLE_PREFIX, DB_TABLE_PREFIX, $prem_where, DB_TABLE_PREFIX, DB_TABLE_PREFIX, $numItems) . ') AS LIM' );
  } else {
    $prem_where = ' WHERE ' . $whe;

    $randSearch->dao->from( '(' . sprintf("select %st_item.pk_i_id FROM %st_item %s ORDER BY %st_item.dt_pub_date DESC LIMIT %s", DB_TABLE_PREFIX, DB_TABLE_PREFIX, $prem_where, DB_TABLE_PREFIX, $numItems) . ') AS LIM' );
  }

  $randSearch->dao->where(DB_TABLE_PREFIX.'t_item.pk_i_id = LIM.pk_i_id');
  

  // group by & order & limit
  $randSearch->dao->groupBy(DB_TABLE_PREFIX.'t_item.pk_i_id');

  if(!$randomOrder) {
    $randSearch->dao->orderBy(DB_TABLE_PREFIX.'t_item.dt_pub_date DESC');
  } else {
    $randSearch->dao->orderBy('RAND()');
  }

  $randSearch->dao->limit($numItems);

  $rs = $randSearch->dao->get();

  if($rs === false){
    return array();
  }
  if( $rs->numRows() == 0 ) {
    return array();
  }

  $items = $rs->result();
  return Item::newInstance()->extendData($items);
}



// ITEM LOOP FORMAT LOCATION
function gam_item_location($premium = false) {
  if(!$premium) {
    $loc = array_filter(array(osc_item_city(), (osc_item_city() == '' ? osc_item_region() : ''), osc_item_country_code()));
  } else {
    $loc = array_filter(array(osc_premium_city(), (osc_premium_city() == '' ? osc_premium_region() : ''), osc_premium_country_code()));
  }

  return implode(', ', $loc);
}


// LOCATION FORMATER - USED ON SEARCH LIST
function gam_location_format($country = null, $region = null, $city = null) { 
  if($country <> '') {
    if(strlen($country) == 2) {
      $country_full = Country::newInstance()->findByCode($country);
    } else {
      $country_full = Country::newInstance()->findByName($country);
    }

    if($region <> '') {
      if($city <> '') {
        return $city . ' ' . __('in', 'gamma') . ' ' . $region . (osc_location_native_name_selector($country_full, 's_name') <> '' ? ' (' . osc_location_native_name_selector($country_full, 's_name') . ')' : '');
      } else {
        return $region . ' (' . osc_location_native_name_selector($country_full, 's_name') . ')';
      }
    } else { 
      if($city <> '') {
        return $city . ' ' . __('in', 'gamma') . ' ' . osc_location_native_name_selector($country_full, 's_name');
      } else {
        return osc_location_native_name_selector($country_full, 's_name');
      }
    }
  } else {
    if($region <> '') {
      if($city <> '') {
        return $city . ' ' . __('in', 'gamma') . ' ' . $region;
      } else {
        return $region;
      }
    } else { 
      if($city <> '') {
        return $city;
      } else {
        return __('Location not entered', 'gamma');
      }
    }
  }
}



function mb_filter_extend() {
  // SEARCH - ALL - INDIVIDUAL - COMPANY TYPE
  Search::newInstance()->addJoinTable( DB_TABLE_PREFIX.'t_item_gamma.fk_i_item_id', DB_TABLE_PREFIX.'t_item_gamma', DB_TABLE_PREFIX.'t_item.pk_i_id = '.DB_TABLE_PREFIX.'t_item_gamma.fk_i_item_id', 'LEFT OUTER' ) ; // Mod


  // SEARCH - TRANSACTION
  if(Params::getParam('sTransaction') > 0) {
    Search::newInstance()->addConditions(sprintf("%st_item_gamma.i_transaction = %d", DB_TABLE_PREFIX, Params::getParam('sTransaction')));
  }


  // SEARCH - CONDITION
  if(Params::getParam('sCondition') > 0) {
    Search::newInstance()->addConditions(sprintf("%st_item_gamma.i_condition = %d", DB_TABLE_PREFIX, Params::getParam('sCondition')));
  }


  // SEARCH - PERIOD
  if(Params::getParam('sPeriod') > 0) {
    $date_from = date('Y-m-d', strtotime(' -' . Params::getParam('sPeriod') . ' day', time()));
    Search::newInstance()->addConditions(sprintf('cast(%st_item.dt_pub_date as date) > "%s"', DB_TABLE_PREFIX, $date_from));
  }

  // SEARCH - USER ID
  if(Params::getParam('userId') > 0) {
    Search::newInstance()->addConditions(sprintf("%st_item.fk_i_user_id = %d", DB_TABLE_PREFIX, Params::getParam('userId')));
  }


  // SEARCH - COMPANY
  if(Params::getParam('sCompany') <> '' and Params::getParam('sCompany') <> null) {
    Search::newInstance()->addJoinTable( DB_TABLE_PREFIX.'t_user.pk_i_id', DB_TABLE_PREFIX.'t_user', DB_TABLE_PREFIX.'t_item.fk_i_user_id = '.DB_TABLE_PREFIX.'t_user.pk_i_id', 'LEFT OUTER' ) ; // Mod

    if(Params::getParam('sCompany') == 1) {
      Search::newInstance()->addConditions(sprintf("%st_user.b_company = 1", DB_TABLE_PREFIX));
    } else {
      Search::newInstance()->addConditions(sprintf("coalesce(%st_user.b_company, 0) <> 1", DB_TABLE_PREFIX));
    }
  }
}

osc_add_hook('search_conditions', 'mb_filter_extend');



// GET SELECTED SEARCH PARAMETERS
function gam_search_params() {
 return array(
   'sCategory' => Params::getParam('sCategory'),
   'sCountry' => Params::getParam('sCountry'),
   'sRegion' => Params::getParam('sRegion'),
   'sCity' => Params::getParam('sCity'),
   //'sPriceMin' => Params::getParam('sPriceMin'),
   //'sPriceMin' => Params::getParam('sPriceMax'),
   'sCompany' => Params::getParam('sCompany'),
   'sShowAs' => Params::getParam('sShowAs'),
   'sOrder' => Params::getParam('sOrder'),
   'iOrderType' => Params::getParam('iOrderType')
  );
}


// GET ALL PARAMS
function gam_search_params_all() {
  $params = Params::getParamsAsArray();
  unset($params['iPage']);
  return $params;
}


// FIND MAXIMUM PRICE
function gam_max_price($cat_id = null, $country_code = null, $region_id = null, $city_id = null) {
  // Search by all parameters
  $allSearch = new Search();
  $allSearch->addCategory($cat_id);
  $allSearch->addCountry($country_code);
  $allSearch->addRegion($region_id);
  $allSearch->addCity($city_id);
  $allSearch->order('i_price', 'DESC');
  $allSearch->limit(0, 1);

  $result = $allSearch->doSearch();
  $result = $result[0];

  $max_price = isset($result['i_price']) ? $result['i_price'] : 0;


  // FOLLOWING BLOCK LOOKS FOR MAX-PRICE IF IT IS 0
  // City is set, find max price by Region
  if($max_price <= 0 && isset($city_id) && $city_id <> '') {
    $regSearch = new Search();
    $regSearch->addCategory($cat_id);
    $regSearch->addCountry($country_code);
    $regSearch->addRegion($region_id);
    $regSearch->order('i_price', 'DESC');
    $regSearch->limit(0, 1);

    $result = $regSearch->doSearch();
    $result = $result[0];

    $max_price = isset($result['i_price']) ? $result['i_price'] : 0;
  }


  // Region is set, find max price by Country
  if($max_price <= 0 && isset($region_id) && $region_id <> '') {
    $regSearch = new Search();
    $regSearch->addCategory($cat_id);
    $regSearch->addCountry($country_code);
    $regSearch->order('i_price', 'DESC');
    $regSearch->limit(0, 1);

    $result = $regSearch->doSearch();
    $result = $result[0];

    $max_price = isset($result['i_price']) ? $result['i_price'] : 0;
  }


  // Country is set, find max price WorldWide
  if($max_price <= 0 && isset($country_code) && $country_code <> '') {
    $regSearch = new Search();
    $regSearch->addCategory($cat_id);
    $regSearch->order('i_price', 'DESC');
    $regSearch->limit(0, 1);

    $result = $regSearch->doSearch();
    $result = $result[0];

    $max_price = isset($result['i_price']) ? $result['i_price'] : 0;
  }


  // Category is set, find max price in all Categories
  if($max_price <= 0 && isset($region_id) && $region_id <> '') {
    $regSearch = new Search();
    $regSearch->addCategory($cat_id);
    $regSearch->order('i_price', 'DESC');
    $regSearch->limit(0, 1);

    $result = $regSearch->doSearch();
    $result = $result[0];

    $max_price = isset($result['i_price']) ? $result['i_price'] : 0;
  }


  // If max_price is still 0, set it to 1 to avoid slider defect
  if($max_price <= 0) {
    $max_price = 1000000;
  }


  return array(
    'max_price' => $max_price/1000000,
    'max_currency' => gam_param('def_cur')
  );
}


// CHECK IF AJAX IMAGE UPLOAD ON PUBLISH-EDIT PAGE CAN BE USED (from osclass 3.3)
function gam_ajax_image_upload() {
  if(class_exists('Scripts')) {
    return Scripts::newInstance()->registered['jquery-fineuploader'] && method_exists('ItemForm', 'ajax_photos');
  }
}


// CLOSE BUTTON RETRO-COMPATIBILITY
if( !OC_ADMIN ) {
  if( !function_exists('add_close_button_action') ) {
    function add_close_button_action(){
      echo '<script type="text/javascript">';
      echo '$(".flashmessage .ico-close").click(function(){';
      echo '$(this).parent().hide();';
      echo '});';
      echo '</script>';
    }
    osc_add_hook('footer', 'add_close_button_action') ;
  }
}


if(!function_exists('message_ok')) {
  function message_ok( $text ) {
    $final  = '<div style="padding: 1%;width: 98%;margin-bottom: 15px;" class="flashmessage flashmessage-ok flashmessage-inline">';
    $final .= $text;
    $final .= '</div>';
    echo $final;
  }
}


if(!function_exists('message_error')) {
  function message_error( $text ) {
    $final  = '<div style="padding: 1%;width: 98%;margin-bottom: 15px;" class="flashmessage flashmessage-error flashmessage-inline">';
    $final .= $text;
    $final .= '</div>';
    echo $final;
  }
}


// RETRO COMPATIBILITY IF FUNCTION DOES NOT EXIST
if(!function_exists('osc_count_countries')) {
  function osc_count_countries() {
    if ( !View::newInstance()->_exists('contries') ) {
      View::newInstance()->_exportVariableToView('countries', Search::newInstance()->listCountries( ">=", "country_name ASC" ) );
    }
    return View::newInstance()->_count('countries');
  }
}


// GET CURRENT LANGUAGE OF USER
function mb_get_current_user_locale() {
  return OSCLocale::newInstance()->findByPrimaryKey(osc_current_user_locale());
}



// FIX PRICE FORMAT OF PREMIUM ITEMS
function gam_premium_formated_price($price = null) {
  if($price == '') {
    $price = osc_premium_price();
  }

  return (string) gam_premium_format_price($price);
}

function gam_premium_format_price($price, $symbol = null) {
  if ($price === null) return osc_apply_filter ('item_price_null', __('Check with seller', 'gamma') );
  if ($price == 0) return osc_apply_filter ('item_price_zero', __('Free', 'gamma') );

  if($symbol==null) { $symbol = osc_premium_currency_symbol(); }

  $price = $price/1000000;

  $currencyFormat = osc_locale_currency_format();
  $currencyFormat = str_replace('{NUMBER}', number_format($price, osc_locale_num_dec(), osc_locale_dec_point(), osc_locale_thousands_sep()), $currencyFormat);
  $currencyFormat = str_replace('{CURRENCY}', $symbol, $currencyFormat);
  return osc_apply_filter('premium_price', $currencyFormat );
}


function gam_ajax_item_format_price($price, $symbol_code) {
  if ($price === null) return __('Check with seller', 'gamma');
  if ($price == 0) return __('Free', 'gamma');
  return round($price/1000000, 2) . ' ' . $symbol_code;
}



AdminMenu::newInstance()->add_menu(__('Theme Setting', 'gamma'), osc_admin_render_theme_url('oc-content/themes/gamma/admin/header.php'), 'gamma_menu');
AdminMenu::newInstance()->add_submenu_divider('gamma_menu', __('Theme Settings', 'gamma'), 'gamma_submenu');
AdminMenu::newInstance()->add_submenu('gamma_menu', __('Configure', 'gamma'), osc_admin_render_theme_url('oc-content/themes/gamma/admin/configure.php'), 'settings_gamma1');
AdminMenu::newInstance()->add_submenu('gamma_menu', __('Advertisement', 'gamma'), osc_admin_render_theme_url('oc-content/themes/gamma/admin/banner.php'), 'settings_gamma2');
AdminMenu::newInstance()->add_submenu('gamma_menu', __('Category Icons', 'gamma'), osc_admin_render_theme_url('oc-content/themes/gamma/admin/category.php'), 'settings_gamma3');
AdminMenu::newInstance()->add_submenu('gamma_menu', __('Logo', 'gamma'), osc_admin_render_theme_url('oc-content/themes/gamma/admin/header.php'), 'settings_gamma4');
AdminMenu::newInstance()->add_submenu('gamma_menu', __('Plugins', 'gamma'), osc_admin_render_theme_url('oc-content/themes/gamma/admin/plugins.php'), 'settings_gamma5');


// GET SITE LOGO
function gam_logo() {
  if(gam_param('default_logo') == 1 && file_exists(WebThemes::newInstance()->getCurrentThemePath() . 'images/default-logo.jpg')) {
    return '<img src="' . osc_current_web_theme_url('images/default-logo.jpg') . '" alt="' . osc_esc_html(osc_page_title()) . '"/>';
  } else if(file_exists(WebThemes::newInstance()->getCurrentThemePath() . 'images/logo.jpg')) {
    return '<img src="' . osc_current_web_theme_url('images/logo.jpg') . '" alt="' . osc_esc_html(osc_page_title()) . '"/>';
  } else if(file_exists(WebThemes::newInstance()->getCurrentThemePath() . 'images/logo.png')) {
    return '<img src="' . osc_current_web_theme_url('images/logo.png') . '" alt="' . osc_esc_html(osc_page_title()) . '"/>';
  } else {
    return osc_page_title();
  }
}


// INSTALL & UPDATE OPTIONS
if(!function_exists('gam_theme_install')) {
  $themeInfo = gam_theme_info();

  function gam_theme_install() {
    osc_set_preference('version', GAMMA_THEME_VERSION, 'theme-gamma');
    osc_set_preference('color', '#4182c3', 'theme-gamma');
    osc_set_preference('color2', '#49b975', 'theme-gamma');
    osc_set_preference('color3', '#ef404f', 'theme-gamma');
    osc_set_preference('site_phone', '+1 (800) 228-5651', 'theme-gamma');
    osc_set_preference('date_format', 'mm/dd', 'theme-gamma');
    osc_set_preference('cat_icons', '0', 'theme-gamma');
    osc_set_preference('footer_link', '1', 'theme-gamma');
    osc_set_preference('default_logo', '1', 'theme-gamma');
    osc_set_preference('def_cur', '$', 'theme-gamma');
    osc_set_preference('def_view', '0', 'theme-gamma');
    osc_set_preference('website_name', 'GammaTheme', 'theme-gamma');
    osc_set_preference('latest_picture', '0', 'theme-gamma');
    osc_set_preference('latest_random', '1', 'theme-gamma');
    osc_set_preference('latest_premium', '0', 'theme-gamma');
    osc_set_preference('latest_category', '', 'theme-gamma');
    osc_set_preference('publish_category', '4', 'theme-gamma');
    osc_set_preference('premium_home', '1', 'theme-gamma');
    osc_set_preference('premium_search', '1', 'theme-gamma');
    osc_set_preference('premium_home_count', '12', 'theme-gamma');
    osc_set_preference('premium_search_count', '3', 'theme-gamma');
    osc_set_preference('search_ajax', '1', 'theme-gamma');
    osc_set_preference('forms_ajax', '1', 'theme-gamma');
    osc_set_preference('post_required', '', 'theme-gamma');
    osc_set_preference('post_extra_exclude', '', 'theme-gamma');
    osc_set_preference('home_layout', 't', 'theme-gamma');
    osc_set_preference('favorite_home', '1', 'theme-gamma');
    osc_set_preference('blog_home', '1', 'theme-gamma');
    osc_set_preference('blog_home_count', '3', 'theme-gamma');
    osc_set_preference('company_home', '1', 'theme-gamma');
    osc_set_preference('company_home_count', '8', 'theme-gamma');
    osc_set_preference('banners', '0', 'theme-gamma');
    osc_set_preference('lazy_load', '0', 'theme-gamma');
    osc_set_preference('public_items', '24', 'theme-gamma');
    osc_set_preference('preview', '1', 'theme-gamma');
    osc_set_preference('related', '1', 'theme-gamma');
    osc_set_preference('related_count', '6', 'theme-gamma');
    osc_set_preference('def_locations', 'region', 'theme-gamma');
    osc_set_preference('promote_home', 1, 'theme-gamma');
    osc_set_preference('stats_home', 1, 'theme-gamma');


    /* Banners */
    if(function_exists('gamma_banner_list')) {
      foreach(gam_banner_list() as $b) {
        osc_set_preference($b['id'], '', 'theme-gamma');
      }
    }

    osc_reset_preferences();

    gam_add_item_fields();  // add extra item fiels into database
  }
}


if(!function_exists('check_install_gam_theme')) {
  function check_install_gam_theme() {
    $current_version = gam_param('version');

    if( !$current_version ) {
      gam_theme_install();
    }
  }
}

check_install_gam_theme();


// WHEN NEW LISTING IS CREATED, ADD IT TO GAMMA EXTRA TABLE
function gam_new_item_extra($item) {
  $conn = DBConnectionClass::newInstance();
  $data = $conn->getOsclassDb();
  $comm = new DBCommandClass($data);
  $db_prefix = DB_TABLE_PREFIX;

  $query = "INSERT INTO {$db_prefix}t_item_gamma (fk_i_item_id) VALUES ({$item['pk_i_id']})";
  $result = $comm->query($query);
}

osc_add_hook('posted_item', 'gam_new_item_extra', 1);


// WHEN NEW CATEGORY IS CREATED, ADD IT TO GAMMA EXTRA TABLE
function gam_new_category_extra() {
  $conn = DBConnectionClass::newInstance();
  $data = $conn->getOsclassDb();
  $comm = new DBCommandClass($data);
  $db_prefix = DB_TABLE_PREFIX;

  $query = "INSERT INTO {$db_prefix}t_category_gamma (fk_i_category_id) 
            SELECT c.pk_i_id FROM {$db_prefix}t_category c WHERE c.pk_i_id NOT IN (SELECT d.fk_i_category_id FROM {$db_prefix}t_category_gamma d)";
  $result = $comm->query($query);
}

osc_add_hook('footer', 'gam_new_category_extra');


function gam_new_category_extra_one($cat_id) {
  $conn = DBConnectionClass::newInstance();
  $data = $conn->getOsclassDb();
  $comm = new DBCommandClass($data);
  $db_prefix = DB_TABLE_PREFIX;

  $query = "INSERT INTO {$db_prefix}t_category_gamma (fk_i_category_id) VALUES ({$cat_id})";
  $result = $comm->query($query);
}

osc_add_hook('add_category', 'gam_new_category_extra_one');




// USER MENU FIX
function gam_user_menu_fix() {
  $user = User::newInstance()->findByPrimaryKey(osc_logged_user_id());
  View::newInstance()->_exportVariableToView('user', $user);
}

osc_add_hook('header', 'gam_user_menu_fix');



// ADD THEME COLUMNS INTO ITEM TABLE
function gam_add_item_fields() {
  ModelGAM::newInstance()->install();
}



// UPDATE THEME COLS ON ITEM POST-EDIT
function gam_update_fields($item) {
  if(Params::existParam('sSold')) {
    $fields = array(
      's_phone' => Params::getParam('sPhone'),
      'i_condition' => Params::getParam('sCondition'),
      'i_transaction' => Params::getParam('sTransaction'),
      'i_sold' => (Params::getParam('sSold') == 'on' ? 1 : Params::getParam('sSold'))
    );
  } else {
    $fields = array(
      's_phone' => Params::getParam('sPhone'),
      'i_condition' => Params::getParam('sCondition'),
      'i_transaction' => Params::getParam('sTransaction')
    );
  }

  Item::newInstance()->dao->update(DB_TABLE_PREFIX.'t_item_gamma', $fields, array('fk_i_item_id' => $item['pk_i_id']));
}

osc_add_hook('posted_item', 'gam_update_fields', 1);
osc_add_hook('edited_item', 'gam_update_fields', 1);


// GET GAMMA ITEM EXTRA VALUES
function gam_item_extra($item_id) {
  if($item_id > 0) {
    $db_prefix = DB_TABLE_PREFIX;
    $query = "SELECT * FROM {$db_prefix}t_item_gamma s WHERE fk_i_item_id = " . $item_id . ";";
    $result = Item::newInstance()->dao->query($query);
    
    if($result) { 
      $prepare = $result->row();
      
      if(isset($prepare['fk_i_item_id']) && $prepare['fk_i_item_id'] > 0) {
        return $prepare;
      }
    }
  }
  
  return array(
    'fk_i_item_id' => $item_id,
    's_phone' => '',
    'i_condition' => null,
    'i_transaction' => null,
    'i_sold' => null
  );    
}


// GET GAMMA CATEGORY EXTRA VALUES
function gem_count_favorite($user_id = '') {

  if($user_id > 0) { 
    // nothing
  } else if(osc_is_web_user_logged_in()) {
    $user_id = osc_logged_user_id();
  } else {
    $user_id = mb_get_cookie('fi_user_id');
  }


  if($user_id > 0) {
    $db_prefix = DB_TABLE_PREFIX;

    $query = "SELECT count(*) as count FROM {$db_prefix}t_favorite_items i, {$db_prefix}t_favorite_list l WHERE l.list_id = i.list_id AND l.user_id = " . $user_id . ";";
    $result = Item::newInstance()->dao->query($query);
    if( !$result ) { 
      $prepare = array();
      return 0;
    } else {
      $prepare = @$result->row()['count'];
      return $prepare;
    }
  }

  return 0;
}


// GET GAMMA CATEGORY EXTRA VALUES
function gam_category_extra($category_id) {
  if($category_id > 0) {
    $db_prefix = DB_TABLE_PREFIX;

    $query = "SELECT * FROM {$db_prefix}t_category_gamma s WHERE fk_i_category_id = " . $category_id . ";";
    $result = Category::newInstance()->dao->query($query);
    if( !$result ) { 
      $prepare = array();
      return false;
    } else {
      $prepare = $result->row();
      return $prepare;
    }
  }
}






// KEEP VALUES OF INPUTS ON RELOAD
function gam_post_preserve() {
  Session::newInstance()->_setForm('sPhone', Params::getParam('sPhone'));
  Session::newInstance()->_setForm('term', Params::getParam('term'));
  Session::newInstance()->_setForm('zip', Params::getParam('zip'));
  Session::newInstance()->_setForm('sCondition', Params::getParam('sCondition'));
  Session::newInstance()->_setForm('sTransaction', Params::getParam('sTransaction'));

  Session::newInstance()->_keepForm('sPhone');
  Session::newInstance()->_keepForm('term');
  Session::newInstance()->_keepForm('zip');
  Session::newInstance()->_keepForm('sCondition');
  Session::newInstance()->_keepForm('sTransaction');
}

osc_add_hook('pre_item_post', 'gam_post_preserve');


// DROP VALUES OF INPUTS ON SUCCESSFUL PUBLISH
function gam_post_drop() {
  Session::newInstance()->_dropKeepForm('sPhone');
  Session::newInstance()->_dropKeepForm('term');
  Session::newInstance()->_dropKeepForm('zip');
  Session::newInstance()->_dropKeepForm('sCondition');
  Session::newInstance()->_dropKeepForm('sTransaction');

  Session::newInstance()->_clearVariables();
}

osc_add_hook('posted_item', 'gam_post_drop');



// GET VALUES FROM SESSION ON PUBLISH PAGE
function gam_get_session( $param ) {
  return Session::newInstance()->_getForm($param);
}


// COMPATIBILITY FUNCTIONS
if(!function_exists('osc_is_register_page')) {
  function osc_is_register_page() {
    return osc_is_current_page("register", "register");
  }
}

if(!function_exists('osc_is_edit_page')) {
  function osc_is_edit_page() {
    return osc_is_current_page('item', 'item_edit');
  }
}


// DEFAULT ICONS ARRAY
function gam_default_icons() {
  $icons = array(
    1 => 'fa-newspaper', 2 => 'fa-motorcycle', 3 => 'fa-graduation-cap', 4 => 'fa-home', 5 => 'fa-wrench', 6 => 'fa-users', 7 => 'fa-venus-mars', 8 => 'fa-briefcase', 9 => 'fa-paw', 
    10 => 'fa-paint-brush', 11 => 'fa-exchange', 12 => 'fa-newspaper', 13 => 'fa-camera', 14 => 'fa-tablet', 15 => 'fa-mobile', 16 => 'fa-shopping-bag', 
    17 => 'fa-laptop', 18 => 'fa-mobile', 19 => 'fa-lightbulb-o', 20 => 'fa-soccer-ball-o', 21 => 'fa-s15', 22 => 'fa-medkit', 23 => 'fa-home', 24 => 'fa-clock-o', 
    25 => 'fa-microphone', 26 => 'fa-bicycle', 27 => 'fa-ticket', 28 => 'fa-plane', 29 => 'fa-television', 30 => 'fa-ellipsis-h', 31 => 'fa-car', 32 => 'fa-gears', 
    33 => 'fa-motorcycle', 34 => 'fa-ship', 35 => 'fa-bus', 36 => 'fa-truck', 37 => 'fa-ellipsis-h', 38 => 'fa-laptop', 39 => 'fa-language', 40 => 'fa-microphone', 
    41 => 'fa-graduation-cap', 42 => 'fa-ellipsis-h', 43 => 'fa-building-o', 44 => 'fa-building', 45 => 'fa-refresh', 46 => 'fa-exchange', 47 => 'fa-plane', 48 => 'fa-car', 
    49 => 'fa-window-minimize', 50 => 'fa-suitcase', 51 => 'fa-shopping-basket', 52 => 'fa-child', 53 => 'fa-microphone', 54 => 'fa-laptop', 55 => 'fa-music', 
    56 => 'fa-stethoscope', 57 => 'fa-star', 58 => 'fa-home', 59 => 'fa-truck', 60 => 'fa-wrench', 61 => 'fa-pencil', 62 => 'fa-ellipsis-h', 63 => 'fa-refresh', 
    64 => 'fa-sun-o', 65 => 'fa-star', 66 => 'fa-music', 67 => 'fa-wheelchair', 68 => 'fa-key', 69 => 'fa-venus', 70 => 'fa-mars', 71 => 'fa-mars-double', 
    72 => 'fa-venus-double', 73 => 'fa-genderless', 74 => 'fa-phone', 75 => 'fa-money', 76 => 'fa-television', 77 => 'fa-paint-brush', 78 => 'fa-book', 79 => 'fa-headphones', 
    80 => 'fa-graduation-cap', 81 => 'fa-paper-plane-o', 82 => 'fa-medkit', 83 => 'fa-users', 84 => 'fa-internet-explorer', 85 => 'fa-gavel', 86 => 'fa-wrench', 
    87 => 'fa-industry', 88 => 'fa-newspaper', 89 => 'fa-wheelchair', 90 => 'fa-home', 91 => 'fa-spoon', 92 => 'fa-exchange', 93 => 'fa-gavel', 94 => 'fa-microchip', 
    95 => 'fa-ellipsis-h', 999 => 'fa-newspaper'
  );

  return $icons;
}


function gam_default_colors() {
  $colors = array(1 => '#F44336', 2 => '#00BCD4', 3 => '#009688', 4 => '#FDE74C', 5 => '#8BC34A', 6 => '#D32F2F', 7 => '#2196F3', 8 => '#777', 999 => '#F44336');
  return $colors;
}


function gam_get_cat_icon( $id, $string = false ) {
  $category = Category::newInstance()->findByPrimaryKey( $id );
  $category_extra = gam_category_extra($id);
  $default_icons = gam_default_icons();

  if(gam_param('cat_icons') == 1) { 
    if($category_extra['s_icon'] <> '') {
      $icon_code = $category_extra['s_icon'];
    } else {
      if(isset($default_icons[$category['pk_i_id']]) && $default_icons[$category['pk_i_id']] <> '') {
        $icon_code = $default_icons[$category['pk_i_id']];
      } else {
         $icon_code = $default_icons[999];
      }
    }

    if($string) {
      return $icon_code;
    } else {
      return '<i class="fa ' . $icon_code . '"></i>';
    }
  } else {
    if($string) {
      return osc_current_web_theme_url() . 'images/small_cat/' . $category['pk_i_id'] . '.png';
    } else {
      if(file_exists(osc_base_path() . 'oc-content/themes/gamma/images/small_cat/' . $category['pk_i_id'] . '.png')) {
        return '<img src="' . osc_current_web_theme_url() . 'images/small_cat/' . $category['pk_i_id'] . '.png" />';
      } else {
        return '<img src="' . osc_current_web_theme_url() . 'images/small_cat/default.png" />';
      }
    }
  }

  if($string) {
    
  } else {
    return $icon;
  }
}


function gam_get_cat_color( $id ) {
  $category = Category::newInstance()->findByPrimaryKey( $id );
  $category_extra = gam_category_extra($id);
  $default_colors = gam_default_colors();

  if($category_extra['s_color'] <> '') {
    $color_code = $category_extra['s_color'];                        
  } else {
    if(isset($default_colors[$category['pk_i_id']]) && $default_colors[$category['pk_i_id']] <> '') {
      $color_code = $default_colors[$category['pk_i_id']];
    } else {
      $color_code = $default_colors[999];
    }
  }

  return $color_code;
}


// GET PROPER CATEGORY IMAGE (ICON)
function gam_get_cat_image($category_id) {
  if(file_exists(WebThemes::newInstance()->getCurrentThemePath() . 'images/small_cat/' . $category_id . '.png')) {
    return osc_current_web_theme_url() . 'images/small_cat/' . $category_id . '.png';
  } else {
    return osc_current_web_theme_url() . 'images/small_cat/default.png';
  }
}


// INCREASE PHONE CLICK VIEWS
function gam_increase_clicks($itemId, $itemUserId = NULL) {
  if($itemId > 0) {
    if($itemUserId == '' || $itemUserId == 0 || ($itemUserId <> '' && $itemUserId > 0 && $itemUserId <> osc_logged_user_id())) {
      $db_prefix = DB_TABLE_PREFIX;
      $query = 'INSERT INTO ' . $db_prefix . 't_item_stats_gamma (fk_i_item_id, dt_date, i_num_phone_clicks) VALUES (' . $itemId . ', "' . date('Y-m-d') . '", 1) ON DUPLICATE KEY UPDATE  i_num_phone_clicks = i_num_phone_clicks + 1';
      return ItemStats::newInstance()->dao->query($query);
    }
  }
}


// FIX ADMIN MENU LIST WITH THEME OPTIONS
function gam_admin_menu_fix(){
  echo '<style>' . PHP_EOL;
  echo 'body.compact #gamma_menu .ico-gamma_menu {bottom:-6px!important;width:50px!important;height:50px!important;margin:0!important;background:#fff url(' . osc_base_url() . 'oc-content/themes/gamma/images/favicons/favicon-32x32.png) no-repeat center center !important;}' . PHP_EOL;
  echo 'body.compact #gamma_menu .ico-gamma_menu:hover {background-color:rgba(255,255,255,0.95)!important;}' . PHP_EOL;
  echo 'body.compact #menu_gamma_menu > h3 {bottom:0!important;}' . PHP_EOL;
  echo 'body.compact #menu_gamma_menu > ul {border-top-left-radius:0px!important;margin-top:1px!important;}' . PHP_EOL;
  echo 'body.compact #menu_gamma_menu.current:after {content:"";display:block;width:6px;height:6px;border-radius:10px;box-shadow:1px 1px 3px rgba(0,0,0,0.1);position:absolute;left:3px;bottom:3px;background:#03a9f4}' . PHP_EOL;
  echo 'body:not(.compact) #gamma_menu .ico-gamma_menu {background:transparent url(' . osc_base_url() . 'oc-content/themes/gamma/images/favicons/favicon-32x32.png) no-repeat center center !important;}' . PHP_EOL;
  echo '</style>' . PHP_EOL;
}

osc_add_hook('admin_header', 'gam_admin_menu_fix');



// BACKWARD COMPATIBILITY FUNCTIONS
if(!function_exists('osc_is_current_page')){
  function osc_is_current_page($location, $section) {
    if( osc_get_osclass_location() === $location && osc_get_osclass_section() === $section ) {
      return true;
    }

    return false;
  }
}


// CREATE URL FOR THEME AJAX REQUESTS
function gam_ajax_url() {
  return osc_base_url() . '?ajaxRequest=1';

  // $url = osc_contact_url();

  // if (osc_rewrite_enabled()) {
    // $url .= '?ajaxRequest=1';
  // } else {
    // $url .= '&ajaxRequest=1';
  // }

  // return $url;
}


// COUNT PHONE CLICKS ON ITEM
function gam_phone_clicks( $item_id ) {
  if( $item_id <> '' ) {
    $db_prefix = DB_TABLE_PREFIX;

    $query = "SELECT sum(coalesce(i_num_phone_clicks, 0)) as phone_clicks FROM {$db_prefix}t_item_stats_gamma s WHERE fk_i_item_id = " . $item_id . ";";
    $result = ItemStats::newInstance()->dao->query( $query );
    if( !$result ) { 
      $prepare = array();
      return '0';
    } else {
      $prepare = $result->row();

      if($prepare['phone_clicks'] <> '') {
        return $prepare['phone_clicks'];
      } else {
        return '0';
      }
    }
  }
}


// NO CAPTCHA RECAPTCHA CHECK
function gam_show_recaptcha( $section = '' ){
  if(function_exists('anr_get_option')) {
    if(anr_get_option('site_key') <> '') {
      if($section <> 'login') {
        osc_run_hook("anr_captcha_form_field");
      } else {
        // plugin sections are: login, registration, new, contact, contact_listing, send_friend, comment
        if($section == 'login' && anr_get_option('login') == "1") {
          osc_run_hook("anr_captcha_form_field");
        }
      }
    }
  } else {
    if(osc_recaptcha_public_key() <> '') {
      if(((osc_is_publish_page() || osc_is_edit_page()) && osc_recaptcha_items_enabled()) || (!osc_is_publish_page() && !osc_is_edit_page()) ) {
        osc_show_recaptcha($section);
      }
    }
  }
}


// SHOW BANNER
function gam_banner( $location ) {
  $html = '';

  if(gam_param('banners') == 1) {
    if( gam_is_demo() ) {
      $class = ' is-demo';
    } else {
      $class = '';
    }

    if(gam_param('banner_' . $location) == '') {
      $blank = ' blank';
    } else {
      $blank = '';
    }

    if( gam_is_demo() && gam_param('banner_' . $location) == '' ) {
      $title = ' title="' . __('You can define your own banner code from theme settings', 'gamma') . '"';
    } else {
      $title = '';
    }

    $html .= '<div id="banner-theme" class="banner-theme banner-' . $location . ' not767' . $class . $blank . '"' . $title . '><div>';


    // BANNER ADS PLUGIN SUPPORT
    if (function_exists('ba_show_banner') && strpos(strtoupper(gam_param('banner_' . $location)), 'BANNER-ADS-PLUGIN') !== false) {
      $xdata = strtoupper(trim(gam_param('banner_' . $location)));

      if(strpos(gam_param('banner_' . $location), 'BANNER-ADS-PLUGIN-HOOK')) {
        $hook = trim(str_replace(array(' ', '  ', '{', '{{', '{{{', '}', '}}', '}}}', 'BANNER-ADS-PLUGIN-HOOK', ':'), '', $xdata));

        if(trim($hook) <> '') {
          $html .= ba_hook($hook, false);
        }
      } else if(strpos(gam_param('banner_' . $location), 'BANNER-ADS-PLUGIN-BANNER')) {
        $banner_id = trim(str_replace(array(' ', '  ', '{', '{{', '{{{', '}', '}}', '}}}', 'BANNER-ADS-PLUGIN-BANNER', ':'), '', $xdata));

        if(is_numeric($banner_id) && $banner_id > 0) {
          $html .= ba_show_banner($banner_id, false);
        }
      } else if(strpos(gam_param('banner_' . $location), 'BANNER-ADS-PLUGIN-ADVERT')) {
        $advert_id = trim(str_replace(array(' ', '  ', '{', '{{', '{{{', '}', '}}', '}}}', 'BANNER-ADS-PLUGIN-ADVERT', ':'), '', $xdata));

        if(is_numeric($advert_id) && $advert_id > 0) {
          $html .= ba_show_advert($advert_id);
        }
      }
    } else {
      $html .= gam_param('banner_' . $location);
    }
    

    if( gam_is_demo() && gam_param('banner_' . $location) == '' ) {
      $html .= '<div>' . __('Banner', 'gamma') . ': ' . $location . '</div>';
    }

    $html .= '</div></div>';

    if(!gam_is_demo() && trim(gam_param('banner_' . $location)) == '') {
      return '';
    } else {
      return $html;
    }
  } else {
    return false;
  }
}


function gam_banner_list() {
  $list = array(
    array('id' => 'banner_home_top', 'position' => __('Top of home page', 'gamma')),
    array('id' => 'banner_home_bottom', 'position' => __('Bottom of home page', 'gamma')),
    array('id' => 'banner_search_sidebar', 'position' => __('Bottom of search sidebar', 'gamma')),
    array('id' => 'banner_search_top', 'position' => __('Top of search page', 'gamma')),
    array('id' => 'banner_search_bottom', 'position' => __('Bottom of search page', 'gamma')),
    array('id' => 'banner_search_middle', 'position' => __('Between listings', 'gamma')),
    array('id' => 'banner_item_top', 'position' => __('Top of item page', 'gamma')),
    array('id' => 'banner_item_bottom', 'position' => __('Bottom of item page', 'gamma')),
    array('id' => 'banner_item_sidebar', 'position' => __('Middle of item sidebar', 'gamma')),
    array('id' => 'banner_item_sidebar_bottom', 'position' => __('Bottom of item sidebar', 'gamma')),
    array('id' => 'banner_item_description', 'position' => __('Under item description', 'gamma')),
    array('id' => 'public_profile_sidebar', 'position' => __('Public profile sidebar', 'gamma')),
    array('id' => 'public_profile_bottom', 'position' => __('Public profile under items', 'gamma'))


  );

  return $list;
}


function gam_extra_fields_hide() {
  $list = trim(gam_param('post_extra_exclude'));
  $array = explode(',', $list);
  $array = array_map('trim', $array);
  $array = array_filter($array);

  if(!empty($array) && count($array) > 0) {
    return $array;
  } else {
    return array();
  }
}


// DISABLE ERROR404 ON SEARCH PAGE WHEN NO ITEMS FOUND
function gam_disable_404() {
  if(osc_is_search_page() && osc_count_items() <= 0) {
    if(http_response_code() == 404) {
      http_response_code(200);
    }
  }
}

osc_add_hook('header', 'gam_disable_404');


// THEME PARAMS UPDATE
if(!function_exists('gam_param_update')) {
  function gam_param_update( $param_name, $update_param_name, $type = NULL, $plugin_var_name = null ) {
  
    $val = '';
    if( $type == 'check') {

      // Checkbox input
      if( Params::getParam( $param_name ) == 'on' ) {
        $val = 1;
      } else {
        if( Params::getParam( $update_param_name ) == 'done' ) {
          $val = 0;
        } else {
          $val = ( osc_get_preference( $param_name, $plugin_var_name ) != '' ) ? osc_get_preference( $param_name, $plugin_var_name ) : '';
        }
      }

    } else if ($type == 'code') {

      if( Params::getParam( $update_param_name ) == 'done' && Params::existParam($param_name)) {
        $val = stripslashes(Params::getParam( $param_name, false, false ));
      } else {
        $val = ( osc_get_preference( $param_name, $plugin_var_name) != '' ) ? stripslashes(osc_get_preference( $param_name, $plugin_var_name )) : '';
      }

    } else {

      // Other inputs (text, password, ...)
      if( Params::getParam( $update_param_name ) == 'done' && Params::existParam($param_name)) {
        $val = Params::getParam( $param_name );
      } else {
        $val = ( osc_get_preference( $param_name, $plugin_var_name) != '' ) ? osc_get_preference( $param_name, $plugin_var_name ) : '';
      }
    }


    // If save button was pressed, update param
    if( Params::getParam( $update_param_name ) == 'done' ) {

      if(osc_get_preference( $param_name, $plugin_var_name ) == '') {
        osc_set_preference( $param_name, $val, $plugin_var_name, 'STRING');  
      } else {
        $dao_preference = new Preference();
        $dao_preference->update( array( "s_value" => $val ), array( "s_section" => $plugin_var_name, "s_name" => $param_name ));
        osc_reset_preferences();
        unset($dao_preference);
      }
    }

    return $val;
  }
}



// MULTI-LEVEL CATEGORIES SELECT
function gam_cat_tree() {
  $array = array();
  $root = Category::newInstance()->findRootCategoriesEnabled();

  $i = 0;
  foreach($root as $c) {
    $array[$i] = array('pk_i_id' => $c['pk_i_id'], 's_name' => $c['s_name']);
    $array[$i]['sub'] = gam_cat_sub($c['pk_i_id']);
    $i++;
  }

  return $array;
}


function gam_cat_sub($id) {
  $array = array();
  $cats = Category::newInstance()->findSubcategories($id);

  if($cats && count($cats) > 0) {
    $i = 0;
    foreach($cats as $c) {
      $array[$i] = array('pk_i_id' => $c['pk_i_id'], 's_name' => $c['s_name']);
      $array[$i]['sub'] = gam_cat_sub($c['pk_i_id']);
      $i++;
    }
  }
      
  return $array;
}


function gam_cat_list($selected = array(), $categories = '', $level = 0) {
  if($categories == '') {
    $categories = gam_cat_tree();
  }

  foreach($categories as $c) {
    echo '<option value="' . $c['pk_i_id'] . '" ' . (in_array($c['pk_i_id'], $selected) ? 'selected="selected"' : '') . '>' . str_repeat('-', $level) . ($level > 0 ? ' ' : '') . $c['s_name'] . '</option>';

    if(isset($c['sub']) && count($c['sub']) > 0) {
      gam_cat_list($selected, $c['sub'], $level + 1);
    }
  }
}


if (!function_exists('array_column')) {
  function array_column(array $input, $columnKey, $indexKey = null) {
    $array = array();
    foreach ($input as $value) {
      if ( !array_key_exists($columnKey, $value)) {
        trigger_error("Key \"$columnKey\" does not exist in array");
        return false;
      }
      if (is_null($indexKey)) {
        $array[] = $value[$columnKey];
      }
      else {
        if ( !array_key_exists($indexKey, $value)) {
          trigger_error("Key \"$indexKey\" does not exist in array");
          return false;
        }
        if ( ! is_scalar($value[$indexKey])) {
          trigger_error("Key \"$indexKey\" does not contain scalar value");
          return false;
        }
        $array[$value[$indexKey]] = $value[$columnKey];
      }
    }
    return $array;
  }
}


if (!function_exists('osc_count_cities')) {
  function osc_count_cities($region = '%%%%') {
    if ( !View::newInstance()->_exists('cities') ) {
      View::newInstance()->_exportVariableToView('cities', Search::newInstance()->listCities($region, ">=", "city_name ASC" ) ) ;
    }

    return View::newInstance()->_count('cities') ;
  }
}

?>