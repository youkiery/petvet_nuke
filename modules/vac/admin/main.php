<?php
/**
* @Project NUKEVIET-MUSIC
* @Phan Tan Dung (phantandung92@gmail.com)
* @Copyright (C) 2011
* @Createdate 26-01-2011 14:43
*/

if (!defined('NV_IS_VAC_ADMIN')) die('Stop!!!');
$page_title = $lang_module["main_title"];
$link = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=";

$xtpl = new XTemplate("main.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
$xtpl->assign("lang", $lang_module);

$diseases = getDiseaseList();
foreach ($diseases as $disease_index => $disease_data) {
	$xtpl->assign("title", $disease_data["disease"]);
	// var_dump($disease_data["id"]); die();
	$vac_row = getVaccineTable($disease_data["id"], NV_CURRENTTIME);
	$i = 1;
	foreach ($vac_row as $vac_index => $vac_data) {
		$xtpl->assign("index", $i);
		$xtpl->assign("petname", $vac_data["petname"]);
		$xtpl->assign("customer", $vac_data["customer"]);
		$xtpl->assign("pet_link", $link . "patient&petid=" . $vac_data["petid"]);
		$xtpl->assign("customer_link", $link . "customer&customerid=" . $vac_data["customerid"]);
		$xtpl->assign("phone", $vac_data["phone"]);
		$xtpl->assign("cometime", date("d/m/Y", $vac_data["cometime"]));
		$xtpl->assign("calltime", date("d/m/Y", $vac_data["calltime"]));
		$i++;
		$xtpl->parse("main.vac_body");
	}

	$xtpl->parse("main");
}

$contents = $xtpl->text("main");

include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
?>