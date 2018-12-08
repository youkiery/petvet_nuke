<?php

/**
 * @Project TXManager
 * @Author Youkiery (youkiery@gmail.com)
 * @copyright 2018
 * @createdate 01/11/2018 08:00 AM
 */


if (!defined('NV_IS_VAC_ADMIN')) die('Stop!!!');

$diseases = get_disease_list();

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
				$sql2 = "insert into `" . VAC_PREFIX . "_diseases` (id, disease) values(". $sdi . ", '" . $sd['disease'] . "');";
				break;
			case 2:
				$sql2 = "update `" . VAC_PREFIX . "_diseases` set disease = '". $sd["disease"] ."' where id = " . $sdi . ";";
				break;
			default:
				$sql2 = "delete from `" . VAC_PREFIX . "_diseases` where id = " . $sdi . "; ";
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

$index = 0;
foreach ($diseases as $disease_index => $disease_data) {
	$xtpl->assign("index", $index);
	$xtpl->assign("name", $disease_data["disease"]);
	$xtpl->parse("main.disease");
	$index ++;
}
$xtpl->parse("main");

$contents = $xtpl->text("main");

include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
?>