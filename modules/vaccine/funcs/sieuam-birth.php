<?php

/**
 * @Project NUKEVIET-MUSIC
 * @Author Phan Tan Dung
 * @Copyright (C) 2011
 * @Createdate 26/01/2011 10:26 AM
 */

if (!defined('NV_IS_MOD_QUANLY')) die('Stop!!!');
$action = $nv_Request->get_string('action', 'post', '');
quagio();
$keyword = $nv_Request->get_string('key', 'get', '');
$page = $nv_Request->get_string('page', 'get', '');
$limit = $nv_Request->get_string('limit', 'get', '');
$page_title = $lang_module["tieude_usg_danhsach"];
$xtpl = new XTemplate("sieuam-birth.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
$xtpl->assign("lang", $lang_module);
$today = date("Y-m-d", NV_CURRENTTIME);
$xtpl->assign("now", $today);


$xtpl->assign("lang", $lang_module);	
$xtpl->assign("keyword", $keyword);
$xtpl->assign("nv", $module_name);
$xtpl->assign("op", $op);
$link = "/index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=";
$limit_option = array(10, 20, 30, 40, 50, 75, 100); 

if (empty($page) || !($page > 0)) {
  $page = 1;
}
if (empty($limit) || !($limit > 0)) {
  if (!empty($_SESSION["limit"]) && $_SESSION["limit"] > 0) {
    $limit = $_SESSION["limit"];
  }
  else {
    $limit = 10;
  }
}
else {
  $_SESSION["limit"] = $limit;
}

foreach ($limit_option as $value) {
  $xtpl->assign("limitname", $value);
  $xtpl->assign("limitvalue", $value);
  if ($value == $limit) {
    $xtpl->assign("lcheck", "selected");
  }
  else {
    $xtpl->assign("lcheck", "");
  }
  $xtpl->parse("main.limit");
}

$url = $link . $op . "&key=$keyword&page=$page&limit=$limit";
$now = strtotime(date("Y-m-d", NV_CURRENTTIME));
$time = $module_config[$module_name]["filter_time"];
if (empty($time)) $time = 7 * 24 * 60 * 60;
$from = $now - $time;
$end = $now + $time;

$sql = "select count(a.id) as count from `" . VAC_PREFIX . "_usg` a inner join `" . VAC_PREFIX . "_pet` b on a.petid = b.id inner join `" . VAC_PREFIX . "_customer` c on b.customerid = c.id where (c.name like '%$keyword%' or c.phone like '%$keyword%') and birthday > 0 order by calltime";
$query = $db->sql_query($sql);
$result = $db->sql_fetch_assoc($query);
$count = $result["count"];

$limit_page = "limit " . $limit . " offset " . (($page - 1) * $limit);

$sql = "select * from " . VAC_PREFIX . "_doctor";
$query = $db->sql_query($sql);
$doctor = array();
while ($doctor_row = $db->sql_fetch_assoc($query)) {
  $doctor[$doctor_row["id"]] = $doctor_row["name"];
}

// $xtpl->assign("dusinh", date("Y-m-d", strtotime($today) + $dusinh));
$sql = "select a.id, a.birthday, a.birth, a.doctorid, b.id as petid, b.name as petname, c.name as customer, c.phone from `" . VAC_PREFIX . "_usg` a inner join `" . VAC_PREFIX . "_pet` b on a.petid = b.id inner join `" . VAC_PREFIX . "_customer` c on b.customerid = c.id where (c.name like '%$keyword%' or c.phone like '%$keyword%') and birthday > 0 order by birthday " . $limit_page;
$query = $db->sql_query($sql);
$list = fetchall($db, $query);
$i = ($page - 1) * $limit + 1;

foreach ($list as $usg_row) {
  if ($usg_row["doctorid"]) {
    $usg_row["doctor"] = $doctor[$usg_row["doctorid"]];
  }
  else {
    $usg_row["doctor"] = "";
  }
  // $sql = "select * from " . VAC_PREFIX . "_pet where id = " . $usg_row["petid"] . " and ";
  // $query = $db->sql_query($sql);
  // $pet_row = $db->sql_fetch_assoc($query);
  // $sql = "select * from " . VAC_PREFIX . "_customer where id = " . $pet_row["customerid"];
  // $query = $db->sql_query($sql);
  // $customer_row = $db->sql_fetch_assoc($query);
    $xtpl->assign("index", $i);
    $xtpl->assign("petname", $usg_row["petname"]);
    $xtpl->assign("customer", $usg_row["customer"]);
    $xtpl->assign("phone", $usg_row["phone"]);
    $xtpl->assign("doctor", $usg_row["doctor"]);
    $xtpl->assign("birth", $usg_row["birth"]);
    $xtpl->assign("birthday", date("d/m/Y", $usg_row["birthday"]));
    $xtpl->parse("main.list");
    $i ++;
}

$nav = nv_generate_page_shop($url, $count, $limit, $page);
$xtpl->assign("nav", $nav);

$xtpl->parse("main");
$contents = $xtpl->text("main");
include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme($contents);
include ( NV_ROOTDIR . "/includes/footer.php" );
?>
