<?php

/**
 * @Project TXManager
 * @Author Youkiery (youkiery@gmail.com)
 * @copyright 2018
 * @createdate 01/11/2018 08:00 AM
 */

if (!defined('NV_SYSTEM')) {
  die('Stop!!!'); 
}
define('NV_IS_MOD_VAC', true); 
define('VAC_PREFIX', $db_config['prefix'] . "_" . $module_name);
define("MINUTE", 60);
define("HOUR", 60 * MINUTE);
define("DAY", 24 * HOUR);
define("WEEK", 7 * DAY);
define("MONTH", 30 * DAY);
define("SEASON", 3 * MONTH);
define("YEAR", 4 * SEASON);
require_once ( NV_ROOTDIR . "/modules/" . $module_file . "/global.functions.php" );

function vaccine_list($page = 1, $limit = 0, $keyword = "", $filter_from = 0, $filter_end = 0) {
  global $module_config, $module_name;
  // die($module_name);
  $today = strtotime(date("Y-m-d"));
  $filter = array("page" => $page, "limit" => $limit, "time_type" => 1, "from" => $filter_from, "end" => $filter_end, "sort" => 3);
  $vaccine = get_vaccine_list($filter);
  $disease = get_disease_list();
  $doctor = get_doctor_list();
  foreach ($vaccine as $v_key => $vaccine_row) {
    $vaccine[$v_key] = parse_vaccine($vaccine_row, $disease, $doctor);
  }
  return $vaccine;
}

function recent_vaccine_list($page = 1, $limit = 0) {
  global $module_config, $module_name;
  // die($module_name);
  $today = strtotime(date("Y-m-d"));
  $filter_time = $module_config[$module_name]["filter_time"];
  if (!$filter_time) $filter_time = WEEK;
  $filter_from = $today - $filter_time;
  $filter_end = $today + $filter_time;
  $filter = array("page" => $page, "limit" => $limit, "time_type" => 1, "from" => $filter_from, "end" => $filter_end, "sort" => 3);
  $vaccine = get_vaccine_list($filter);
  $disease = get_disease_list();
  $doctor = get_doctor_list();
  foreach ($vaccine as $v_key => $vaccine_row) {
    $vaccine[$v_key] = parse_vaccine($vaccine_row, $disease, $doctor);
  }
  return $vaccine;
}

