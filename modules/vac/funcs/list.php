<?php
/**
* @Project NUKEVIET-MUSIC
* @Phan Tan Dung (phantandung92@gmail.com)
* @Copyright (C) 2011
* @Createdate 26-01-2011 14:43
*/

$page_title = $lang_module["main_title"];

$xtpl = new XTemplate("list.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
$xtpl->assign("lang", $lang_module);

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