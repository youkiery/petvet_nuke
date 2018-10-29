<?php
/**
* @Project NUKEVIET-MUSIC
* @Phan Tan Dung (phantandung92@gmail.com)
* @Copyright (C) 2011
* @Createdate 26-01-2011 14:43
*/

$page_title = $lang_module["main_title"];
	$xtpl = new XTemplate("list.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
	$day = 24 * 60 * 60 * 100;
	$month = 30 * $day;
	$season = 4 * $month;
	$year = 4 * $season;
	$date_option = array("1 tuần" => $day * 7, "2 tuần" => 14 * $day, "3 tuần" => 21 * $day, "1 tháng" => $month, "2 tháng" => 2 * $month, "3 tháng" => 3 * $month, "1 quý" => $season, "2 quý" => 2 * $season, "3 quý" => 3 * $season, "1 năm" => $year);
	$sort_option = array("1" => "Thời gian tiêm phòng giảm dần", "2" => "Thời gian tiêm phòng tăng dần", "3" => "Thời gian tái chủng giảm dần", "4" => "Thời gian tái chủng tăng dần");

	$xtpl->assign("lang", $lang_module);
	$xtpl->assign("fromtime", date("Y-m-d", NV_CURRENTTIME));
	$xtpl->assign("totime", date("Y-m-d", NV_CURRENTTIME + NV_NEXTMONTH));	
	$sort = $_SESSION["vac_filter"]["sort"];
	$time_amount = $_SESSION["vac_filter"]["time_amount"];

	foreach ($sort_option as $value => $name) {
		$xtpl->assign("sort_value", $value);
		$xtpl->assign("sort_name", $name);
		if($name == $sort) $xtpl->assign("fs_select", "selected");
		else $xtpl->assign("fs_select", "");
		$xtpl->parse("main.fs_time");
	}
	foreach ($date_option as $name => $value) {
		$xtpl->assign("time_amount", $value);
		$xtpl->assign("time_name", $name);
		if($value == $time_amount) $xtpl->assign("fo_select", "selected");
		else $xtpl->assign("fo_select", "");
		$xtpl->parse("main.fo_time");
	}

	$xtpl->assign("content", filter(NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file, $lang_module, date("Y-m-d", NV_CURRENTTIME), $time_amount, $sort));

?>
