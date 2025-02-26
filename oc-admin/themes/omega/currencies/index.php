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


function addHelp() {
  echo '<p>' . __("Add new currencies or edit existing currencies so users can publish listings in their country's currency.") . '</p>';
}

osc_add_hook('help_box','addHelp');


function customPageHeader(){ 
  ?>
  <h1><?php _e('Currencies'); ?>
    <a href="#" class="btn ico ico-32 ico-help float-right"></a>
    <a href="<?php echo osc_admin_base_url(true).'?page=currencies&action=add'; ?>" class="btn btn-green ico ico-add-white float-right"><?php _e('Add'); ?></a>
  </h1>
  <?php
}
osc_add_hook('admin_page_header','customPageHeader');


function customPageTitle($string) {
  return sprintf(__('Currencies - %s'), $string);
}

osc_add_filter('admin_title', 'customPageTitle');


//customize Head
function customHead() { 
  ?>
  <script type="text/javascript">
  $(document).ready(function(){
    // check_all bulkactions
    $("#check_all").change(function(){
      var isChecked = $(this).prop("checked");
      $('.col-bulkactions input').each(function() {
        if(isChecked == 1) {
          this.checked = true;
        } else {
          this.checked = false;
        }
      });
    });

    // dialog delete
    $("#dialog-currency-delete").dialog({
      autoOpen: false,
      modal: true,
    });

    // dialog bulk actions
    $("#dialog-bulk-actions").dialog({
      autoOpen: false,
      modal: true
    });
    $("#bulk-actions-submit").click(function() {
      $("#datatablesForm").submit();
    });
    $("#bulk-actions-cancel").click(function() {
      $("#datatablesForm").attr('data-dialog-open', 'false');
      $('#dialog-bulk-actions').dialog('close');
    });
    // dialog bulk actions function
    $("#datatablesForm").submit(function() {
      if($("#bulk_actions option:selected").val() == "") {
        return false;
      }

      if($("#datatablesForm").attr('data-dialog-open') == "true") {
        return true;
      }

      $("#dialog-bulk-actions .form-row").html($("#bulk_actions option:selected").attr('data-dialog-content'));
      $("#bulk-actions-submit").html($("#bulk_actions option:selected").text());
      $("#datatablesForm").attr('data-dialog-open', 'true');
      $("#dialog-bulk-actions").dialog('open');
      return false;
    });
    // /dialog bulk actions
  });

  // dialog delete function
  function delete_dialog(item_id) {
    $("#dialog-currency-delete input[name='code']").attr('value', item_id);
    $("#dialog-currency-delete").dialog('open');
    return false;
  }
  </script>
  <?php
}
osc_add_hook('admin_header','customHead', 10);

$aCurrencies = __get('aCurrencies');

$aData = array();
foreach($aCurrencies as $currency) {
  $row = array();
  $row[] = '<input type="checkbox" name="code[]" value="' . osc_esc_html($currency['pk_c_code']) . '" />';

  $options = array();
  $options[] = '<a onclick="return delete_dialog(\'' . $currency['pk_c_code'] . '\');" href="' . osc_admin_base_url(true) . '?page=currencies&amp;action=delete&amp;code=' . $currency['pk_c_code'] . '">' . __('Delete') . '</a>';
  $options[] = '<a href="' . osc_admin_base_url(true) . '?page=currencies&amp;action=edit&amp;code=' . $currency['pk_c_code'] . '">' . __('Edit') . '</a>';

  $row[] = $currency['pk_c_code'] . ' (' . implode(' &middot; ', $options) . ')';
  $row[] = $currency['s_name'];
  $row[] = $currency['s_description'];
  $aData[] = $row;
}

osc_current_admin_theme_path('parts/header.php'); 
?>

<h2 class="render-title"><?php _e('Currencies'); ?> <a href="<?php echo osc_admin_base_url(true); ?>?page=currencies&action=add" class="btn btn-mini"><?php _e('Add new'); ?></a></h2>
<div class="relative">
  <div id="currencies-toolbar" class="table-toolbar">
  </div>
  <form class="" id="datatablesForm" action="<?php echo osc_admin_base_url(true); ?>" method="post">
    <input type="hidden" name="page" value="currencies" />
    <input type="hidden" name="action" value="delete" />
    <div id="bulk-actions">
      <label>
        <select id="bulk_actions" name="bulk_actions" class="select-box-extra">
          <option value=""><?php _e('Bulk actions'); ?></option>
          <option value="delete_all" data-dialog-content="<?php printf(__('Are you sure you want to %s the selected currencies?'), strtolower(__('Delete'))); ?>"><?php _e('Delete'); ?></option>
        </select> <input type="submit" id="bulk_apply" class="btn" value="<?php echo osc_esc_html(__('Apply')); ?>" />
      </label>
    </div>
    
    <div class="table-contains-actions">
      <table class="table currencies" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th class="col-bulkactions"><input id="check_all" type="checkbox" /></th>
            <th><?php _e('Code'); ?></th>
            <th><?php _e('Name'); ?></th>
            <th><?php _e('Symbol'); ?></th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($aData as $array) { ?>
          <tr>
          <?php foreach($array as $key => $value) { ?>
            <?php if($key == 0) { ?>
            <td class="col-bulkactions">
            <?php } else { ?>
            <td>
            <?php } ?>
            <?php echo $value; ?>
            </td>
          <?php } ?>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </form>
</div>
<form id="dialog-currency-delete" method="get" action="<?php echo osc_admin_base_url(true); ?>" class="has-form-actions hide" title="<?php echo osc_esc_html(__('Delete currency')); ?>">
  <input type="hidden" name="page" value="currencies" />
  <!--<input type="hidden" name="action" value="currencies" />-->
  <input type="hidden" name="action" value="delete" />
  <input type="hidden" name="code" value="" />
  <div class="form-horizontal">
    <div class="form-row">
      <?php _e('Are you sure you want to delete this currency?'); ?>
    </div>
    <div class="form-actions">
      <div class="wrapper">
        <input id="currency-delete-submit" type="submit" value="<?php echo osc_esc_html(__('Delete')); ?>" class="btn btn-red" />
        <a class="btn" href="javascript:void(0);" onclick="$('#dialog-currency-delete').dialog('close');"><?php _e('Cancel'); ?></a>
      </div>
    </div>
  </div>
</form>
<div id="dialog-bulk-actions" title="<?php _e('Bulk actions'); ?>" class="has-form-actions hide">
  <div class="form-horizontal">
    <div class="form-row"></div>
    <div class="form-actions">
      <div class="wrapper">
        <a id="bulk-actions-submit" href="javascript:void(0);" class="btn btn-red" ><?php echo osc_esc_html(__('Delete')); ?></a>
        <a id="bulk-actions-cancel" class="btn" href="javascript:void(0);"><?php _e('Cancel'); ?></a>
        <div class="clear"></div>
      </div>
    </div>
  </div>
</div>
<?php osc_current_admin_theme_path('parts/footer.php'); ?>