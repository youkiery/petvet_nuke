<?php

/**
 * @Project NUKEVIET-MUSIC
 * @Author Phan Tan Dung
 * @Copyright (C) 2011
 * @Createdate 26/01/2011 10:26 AM
 */
if (!defined('NV_IS_MOD_VAC'))
  die('Stop!!!');

quagio();

$key = $nv_Request->get_string('key', 'get', '');
$page_title = $lang_module["tieude_luubenh"];
$xtpl = new XTemplate("luubenh-danhsach.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
$xtpl->assign("lang", $lang_module);


$now = date("Y-m-d", NV_CURRENTTIME);
$xtpl->assign("now", $now);

$xtpl->assign("keyword", $key);
$now = strtotime($now);
$time = $global_config["filter_time"];

if (empty($time))
  $time = 7 * 24 * 60 * 60;
$from = $now - $time;
$end = $now + $time;

$sql = "SELECT a.id, a.ngayluubenh, a.tinhtrang, a.ketqua, b.id as petid, b.petname, d.doctor from `" . VAC_PREFIX . "_luubenh` a inner join `" . VAC_PREFIX . "_pets` b on ketqua = 0 and a.idthucung = b.id inner join `" . VAC_PREFIX .  "_customers` c on c.id = b.customerid and (c.customer like '%$key%' or c.phone like '%$key%' or b.petname like '%$key%') inner join `" . VAC_PREFIX . "_doctor` d on a.idbacsi = d.id order by ngayluubenh";
// die($sql);
$result = $db->sql_query($sql);

$display_list = array();
while ($row = $db->sql_fetch_assoc($result)) {
  $display_list[] = $row;
}

$xtpl->assign("content", displaySSList($display_list, $time, NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file, $lang_module));

$xtpl->parse("main");
$contents = $xtpl->text("main");

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme($contents);
include ( NV_ROOTDIR . "/includes/footer.php" );

function displaySSList($list, $time, $path, $lang_module) {
  $xtpl = new XTemplate("luubenh-bang.tpl", $path);
  $xtpl->assign("lang", $lang_module);
  $status_option = array("Bình thường", "Hơi yếu", "Yếu", "Sắp chết");
  $export = array("Lưu bệnh", "Đã điều trị", "Đã chết");
  $index = 1;
  foreach ($list as $key => $list_data) {
    // var_dump($list_data); die();
    $xtpl->assign("index", $index);
    $xtpl->assign("lid", $list_data["id"]);
    $xtpl->assign("petname", $list_data["petname"]);
    $xtpl->assign("doctor", $list_data["doctor"]);
    $xtpl->assign("petid", $list_data["petid"]);
    $xtpl->assign("luubenh", date("d/m/Y", $list_data["ngayluubenh"]));
    $xtpl->assign("ketqua", $export[$list_data["ketqua"]]);
    $xtpl->assign("tinhtrang", $status_option[$list_data["tinhtrang"]]);
    $color = "#ccc";
    if (!$list_data["ketqua"]) {
      switch ($list_data["tinhtrang"]) {
        case 0:
          $color = "#2d2";
          break;
        case 1:
          $color = "#4a2";
          break;
        case 2:
          $color = "#aa2";
          break;
        case 3:
          $color = "#f62";
          break;
      }
    }
    $xtpl->assign("bgcolor", $color);

    // $xtpl->assign("thongbao", $list_data["ngaybao"]);
    $xtpl->parse("main.list");
    $index ++;
  }

  $xtpl->parse("main");
  return $xtpl->text("main");
}

?>
