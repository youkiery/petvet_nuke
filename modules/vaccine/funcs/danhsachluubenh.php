<?php

/**
 * @Project NUKEVIET-MUSIC
 * @Author Phan Tan Dung
 * @Copyright (C) 2011
 * @Createdate 26/01/2011 10:26 AM
 */
if (!defined('NV_IS_MOD_QUANLY')) {
  die('Stop!!!');
}

quagio();

$keyword = $nv_Request->get_string('key', 'get', '');
$page_title = $lang_module["tieude_treat"];
$xtpl = new XTemplate("luubenh-danhsach.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
$xtpl->assign("lang", $lang_module);
$status_option = array("Bình thường", "Hơi yếu", "Yếu", "Sắp chết");

$now = date("Y-m-d", NV_CURRENTTIME);
$xtpl->assign("now", $now);

$xtpl->assign("keyword", $keyword);
$now = strtotime($now);
$time = $module_config[$module_file]["filter_time"];

if (empty($time)) {
  $time = 7 * 24 * 60 * 60;
}
$from = $now - $time;
$end = $now + $time;

$sql = "select * from " .  VAC_PREFIX . "_doctor";
$result = $db->sql_query($sql);

while ($row = $db->sql_fetch_assoc($result)) {
  $xtpl->assign("doctorid", $row["id"]);
  $xtpl->assign("doctorname", $row["name"]);
  $xtpl->parse("main.doctor");
}


foreach ($status_option as $key => $value) {
  // var_dump($value); die();
  $xtpl->assign("status_value", $key);  
  $xtpl->assign("status_name", $value);
  $xtpl->parse("main.status_option");
}

// var_dump($_GET); die();

$sql = "SELECT a.id, a.cometime, a.insult, b.id as petid, b.name as petname, c.name as customer, d.name as doctor from `" . VAC_PREFIX . "_treat` a inner join `" . VAC_PREFIX . "_pet` b on a.petid = b.id inner join `" . VAC_PREFIX .  "_customer` c on c.id = b.customerid and (c.name like '%$keyword%' or c.phone like '%$keyword%' or b.name like '%$keyword%') inner join `" . VAC_PREFIX . "_doctor` d on a.doctorid = d.id order by cometime desc, a.id";
// die($sql);
$result = $db->sql_query($sql);

$display_list = array();
while ($row = $db->sql_fetch_assoc($result)) {
  // var_dump($row); die();
  $sql = "SELECT status from `" . VAC_PREFIX . "_treating` where treatid = $row[id] order by id desc limit 1";
  // echo $sql; die();
  $query2 = $db->sql_query($sql);
  $row2 = $db->sql_fetch_assoc($query2);
  // var_dump($row2);
  $row["status"] = $row2["status"] ? $row2["status"] : 0;
  $display_list[] = $row;
}

// var_dump($display_list);
// die();

$xtpl->assign("content", displaySSList($display_list, $time, NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file, $lang_module));

$xtpl->parse("main");
$contents = $xtpl->text("main");

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme($contents);
include ( NV_ROOTDIR . "/includes/footer.php" );

function displaySSList($list, $time, $path, $lang_module) {
  global $status_option;
  $xtpl = new XTemplate("luubenh-bang.tpl", $path);
  $xtpl->assign("lang", $lang_module);
  $export = array("Lưu bệnh", "Đã điều trị", "Đã chết");
  $index = 1;
  foreach ($list as $key => $list_data) {
    // var_dump($list_data); die();
    $xtpl->assign("index", $index);
    $xtpl->assign("lid", $list_data["id"]);
    $xtpl->assign("petname", $list_data["petname"]);
    $xtpl->assign("customer", $list_data["customer"]);
    $xtpl->assign("doctor", $list_data["doctor"]);
    $xtpl->assign("petid", $list_data["petid"]);
    $xtpl->assign("cometime", date("d/m/Y", $list_data["cometime"]));
    $xtpl->assign("insult", $export[$list_data["insult"]]);
    $xtpl->assign("status", $status_option[$list_data["status"]]);
    $xtpl->assign("bgcolor", mauluubenh($list_data["insult"], $list_data["status"]));

    // $xtpl->assign("thongbao", $list_data["ngaybao"]);
    $xtpl->parse("main.list");
    $index ++;
  }

  $xtpl->parse("main");
  return $xtpl->text("main");
}

?>
