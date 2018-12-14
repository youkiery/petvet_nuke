<?php

$key = $nv_Request->get_string('key', 'get', '');
$hex = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");
$fromtime = strtotime($fromtime);
$now = strtotime(date("Y-m-d", NV_CURRENTTIME));
$today = date("d", $now);
$dom = date("t");

$xtpl = new XTemplate("list-1.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
$xtpl->assign("lang", $lang_module);
$xtpl->assign("title", $lang_module["main_title"]);

$diseases = getDiseaseList();
$vaclist = array();
// echo $global_config["filter_time"]; die();
foreach ($diseases as $disease) {
  $vaclist_disease = getvaccustomer($key, strtotime(date("Y-m-d", NV_CURRENTTIME)), $module_config[$module_name]["filter_time"], $module_config[$module_name]["sort_type"], $disease["id"], $disease["disease"]);
  $vaclist = array_merge($vaclist, $vaclist_disease);
}
// echo json_encode($vaclist); die();

echo filter($vaclist, NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file, $lang_module, date("Y-m-d", NV_CURRENTTIME), $module_config[$module_name]["filter_time"], $module_config[$module_name]["sort_type"], 1);
die();
?>
