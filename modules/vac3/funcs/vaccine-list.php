<?php

/**
 * @Project TXManager
 * @Author Youkiery (youkiery@gmail.com)
 * @copyright 2018
 * @createdate 01/11/2018 08:00 AM
 */

if (!defined('NV_IS_MOD_VAC')) {
  die('Stop!!!'); 
}

$filter_from = $nv_Request->get_int("filter_from", 0);
$filter_end = $nv_Request->get_int("filter_end", 0);
$keyword = $nv_Request->get_string("keyword", "");

if ((empty($filter_from) && empty($filter_end))) {
  $filter_time = $module_config[$module_name]["filter_time"];
  if (!$filter_time) $filter_time = WEEK;
  $filter_from = $today - $filter_time;
  $filter_end = $today + $filter_time;
}

// $xtpl = new XTemplate("vaccine.tpl", NV_ROOTDIR . '/theme/' . $module_info["theme"] . '/module/');

// $contents = call_user_func("vaccine", $data_content);
include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme($contents);
include ( NV_ROOTDIR . "/includes/footer.php" );
