<?php
/**
* @Project NUKEVIET-MUSIC
* @Phan Tan Dung (phantandung92@gmail.com)
* @Copyright (C) 2011
* @Createdate 26-01-2011 14:43
*/

if (!defined('NV_IS_QUANLY_ADMIN')) die('Stop!!!');
$link = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=";

$action = $nv_Request->get_string('action', 'post', "");
if($action) {
	$ret = array("status" => 0, "data" => array());
	switch ($action) {
		case "save":
			$sort = $nv_Request->get_string('sort', 'post', '');
			$time = $nv_Request->get_string('time', 'post', '');
			$expert = $nv_Request->get_string('expert', 'post', '');
			if(!(empty($sort) || empty($time) || empty($expert))) {
				$sql = "update `" . $db_config['prefix'] . "_config` set config_value = '$time' where config_name = 'filter_time' and module = '" . $module_file . "'";
			    $time_query = $db->sql_query($sql);
				$sql = "update `" . $db_config['prefix'] . "_config` set config_value = '$sort' where config_name = 'sort_type' and module = '" . $module_file . "'";
				$sort_query = $db->sql_query($sql);
				$sql = "update `" . $db_config['prefix'] . "_config` set config_value = '$expert' where config_name = 'expert_time' and module = '" . $module_file . "'";
				$expert_query = $db->sql_query($sql);
				if($time_query && $sort_query && $expert_query) {
					$ret["status"] = 1;
				}
			}
		break;
	} 
	
	echo json_encode($ret);
	die();
}

$page_title = $lang_module["doctor_config"];
$xtpl = new XTemplate("config.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
$xtpl->assign("lang", $lang_module);

$day = 24 * 60 * 60;
$month = 30 * $day;
$date_option = array("1 tuần" => $day * 7, "2 tuần" => 14 * $day, "3 tuần" => 21 * $day, "1 tháng" => $month, "2 tháng" => 2 * $month, "3 tháng" => 3 * $month);
$sort_option = array("1" => "Thời gian tiêm phòng giảm dần", "2" => "Thời gian tiêm phòng tăng dần", "3" => "Thời gian tái chủng giảm dần", "4" => "Thời gian tái chủng tăng dần");

if(empty($module_config[$module_file]["sort_type"])) $sort = $sort_option["3"];
else $sort = $module_config[$module_file]["sort_type"];

if(empty($module_config[$module_file]["filter_time"])) $time_amount = $date_option["2 tuần"];
else $time_amount = $module_config[$module_file]["filter_time"];

if(empty($module_config[$module_file]["expert_time"])) $expert_time = $date_option["2 tuần"];
else $expert_time = $module_config[$module_file]["expert_time"];

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
	if($value == $time_amount) $xtpl->assign("fo_select", "selected");
	else $xtpl->assign("fo_select", "");
	$xtpl->parse("main.fo_time");
	if($value == $expert_time) $xtpl->assign("et_select", "selected");
	else $xtpl->assign("et_select", "");
	$xtpl->parse("main.et_time");
}
$xtpl->assign("fromtime", date("Y-m-d", NV_CURRENTTIME));
$xtpl->assign("totime", date("Y-m-d", NV_CURRENTTIME + NV_NEXTMONTH));	

$xtpl->parse("main");

$contents = $xtpl->text("main");

include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
?>
