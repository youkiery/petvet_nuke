<?php
/**
* @Project NUKEVIET-MUSIC
* @Phan Tan Dung (phantandung92@gmail.com)
* @Copyright (C) 2011
* @Createdate 26-01-2011 14:43
*/

if (!defined('NV_IS_QUANLY_ADMIN')) die('Stop!!!');

$diseases = getDiseaseList();

$array_value = $nv_Request -> get_typed_array('d_name', 'post', 'string');
if($array_value) {
	foreach ($diseases as $key => $value) {
		$diseases[$key]["action"] = 0;
	}

	$index = 0;
	foreach ($array_value as $s) {
		if(!empty($s)) {
			if(empty($diseases[$index])) {
				$diseases[$index]["action"] = 1;
			}
			else {
				$diseases[$index]["action"] = 2;
			}
			$diseases[$index]["disease"] = $s;
			$index ++;
		}
	}

	$check = true;
	foreach ($diseases as $sdi => $sd) {
		$sdi ++;
		switch ($sd["action"]) {
			case 1:
				checkNewDisease($sdi);
				$sql2 = "insert into `" . VAC_PREFIX . "_disease` (id, name) values(". $sdi . ", '" . $sd['disease'] . "');";
				break;
			case 2:
				$sql2 = "update `" . VAC_PREFIX . "_disease` set name = '". $sd["disease"] ."' where id = " . $sdi . ";";
				break;
			default:
				$sql2 = "delete from `" . VAC_PREFIX . "_disease` where id = " . $sdi . "; ";
		}
		if(empty($sql2) || !$db->sql_query($sql2)) {
			$check = false;
		}
	}
	if ($check) die("1");
	else die("0");
}

$page_title = $lang_module["disease_title"];

$xtpl = new XTemplate("disease.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
$xtpl->assign("lang", $lang_module);

$index = 1;
foreach ($diseases as $disease_index => $disease_data) {
	$xtpl->assign("index", $index);
	$xtpl->assign("name", $disease_data["name"]);
	$xtpl->parse("main.disease");
	$index ++;
}
$xtpl->parse("main");

$contents = $xtpl->text("main");

include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
?>
