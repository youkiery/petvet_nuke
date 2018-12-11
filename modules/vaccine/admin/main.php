<?php

/**
* @Project NUKEVIET-MUSIC
* @Phan Tan Dung (phantandung92@gmail.com)
* @Copyright (C) 2011
* @Createdate 26-01-2011 14:43
*/

if (!defined('NV_IS_QUANLY_ADMIN')) die('Stop!!!');
$page_title = $lang_module["main_title"];
$link = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=";

$action = $nv_Request->get_string('action', 'post', "");
if (!empty($action)) {

	if ($action == "set_filter") {
		$filter_time = $nv_Request->get_string('filter_time', 'post', "");
		if(!empty($filter_time)) {
			$sql = "update `" . $db_config['prefix'] . "_config` set config_value = $filter_time where config_name = 'filter_time'";
			if($db->sql_query($sql)) echo 1;
		}
	}
	die();
}

$xtpl = new XTemplate("main.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
$xtpl->assign("lang", $lang_module);
$xtpl->assign("nv", $module_file);
$xtpl->assign("op", $op);
$day = 24 * 60 * 60;
$month = 30 * $day;
$date_option = array("1 tuần" => $day * 7, "2 tuần" => 14 * $day, "3 tuần" => 21 * $day, "1 tháng" => $month, "2 tháng" => 2 * $month, "3 tháng" => 3 * $month);
$sort_option = array("1" => "Thời gian tái chủng tăng dần","2" => "Thời gian tái chủng giảm dần", "3" => "Thời gian tiêm phòng tăng dần", "4" => "Thời gian tiêm phòng giảm dần");

$key = $nv_Request->get_string('key', 'get', "");
$sort = $nv_Request->get_string('sort', 'get', "");
$time = $nv_Request->get_string('time', 'get', "");


if (empty($time)) $time = $date_option["1 tuần"];
if (empty($sort)) $sort = 1;

foreach ($sort_option as $value => $name) {
	$xtpl->assign("sort_value", $value);
	$xtpl->assign("sort_name", $name);
	if($value == $sort) $xtpl->assign("fs_select", "selected");
	else $xtpl->assign("fs_select", "");
	$xtpl->parse("main.fs_time");
}
foreach ($date_option as $name => $value) {
	$xtpl->assign("time_amount", $value);
	$xtpl->assign("time_name", $name);
	if($value == $time) $xtpl->assign("fo_select", "selected");
	else $xtpl->assign("fo_select", "");
	$xtpl->parse("main.fo_time");
}

$xtpl->assign("keyword", $key);
$xtpl->assign("table", getVaccineTable(NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file, $lang_module, $key, $sort, $time));

$xtpl->parse("main");
$contents = $xtpl->text("main");

include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
?>