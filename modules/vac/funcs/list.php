<?php
/**
* @Project NUKEVIET-MUSIC
* @Phan Tan Dung (phantandung92@gmail.com)
* @Copyright (C) 2011
* @Createdate 26-01-2011 14:43
*/

$page_title = $lang_module["main_title"];
	$xtpl = new XTemplate("list.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
	$day = 24 * 60 * 60;
	$month = 30 * $day;
	$date_option = array("1 week" => $day * 7, "2 week" => 14 * $day, "3 week" => 21 * $day, "4 week" => 28 * $day, "1 month" => $month, "2 month" => 2 * $month, "3 month" => 3 * $month);
	$xtpl->assign("lang", $lang_module);
	$xtpl->assign("fromtime", date("Y-m-d", NV_CURRENTTIME));
	$xtpl->assign("totime", date("Y-m-d", NV_CURRENTTIME + NV_NEXTMONTH));	

	foreach ($date_option as $name => $value) {
		$xtpl->assign("time_amount", $value);
		$xtpl->assign("time_name", $name);
		$xtpl->parse("main.fo_time");
	}

	$diseases = getDiseaseList();
	foreach ($diseases as $disease_index => $disease_data) {
		$xtpl->assign("title", $disease_data["disease"]);
		$vac_row = getVaccineTable($disease_data["id"], NV_CURRENTTIME);
		$i = 1;
		foreach ($vac_row as $vac_index => $vac_data) {
			$xtpl->assign("index", $i);
			$xtpl->assign("petname", $vac_data["petname"]);
			$xtpl->assign("customer", $vac_data["customer"]);
			$xtpl->assign("phone", $vac_data["phone"]);
			$xtpl->assign("cometime", date("d/m/Y", $vac_data["cometime"]));
			$xtpl->assign("calltime", date("d/m/Y", $vac_data["calltime"]));
			$i++;
			$xtpl->parse("main.disease.vac_body");
		}
	
		$xtpl->parse("main.disease");
	}	

?>
