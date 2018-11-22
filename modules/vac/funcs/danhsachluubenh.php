<?php
/**
 * @Project NUKEVIET-MUSIC
 * @Author Phan Tan Dung
 * @Copyright (C) 2011
 * @Createdate 26/01/2011 10:26 AM
 */
if (!defined('NV_IS_MOD_VAC')) die('Stop!!!');

quagio();

$key = $nv_Request->get_string('key', 'get', '');
	$page_title = $lang_module["tieude_luubenh"];
	$xtpl = new XTemplate("luubenh-danhsach.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
	$xtpl->assign("lang", $lang_module);
	
	$xtpl->assign("keyword", $key);
	$now = strtotime(date("Y-m-d", NV_CURRENTTIME));
	$time = $global_config["filter_time"];

	if (empty($time)) $time = 7 * 24 * 60 * 60;
	$from = $now - $time;
	$end = $now + $time;

  $sql = "select a.id, a.ngayluubenh, a.lieutrinh, a.ketqua, b.id as petid, b.petname, c.customer, c.phone, d.doctor from `" . $db_config['prefix'] . "_" . $module_data . "_luubenh` a inner join `" . $db_config['prefix'] . "_" . $module_data . "_pets` b on ketqua = 0 and a.idthucung = b.id inner join `" . $db_config['prefix'] . "_" . $module_data . "_customers` c on b.customerid = c.id inner join `" . $db_config['prefix'] . "_" . $module_data . "_doctor` d on a.idbacsi = d.id where c.customer like '%$key%' or c.phone like '%$key%' order by ngayluubenh";
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
	echo nv_site_theme( $contents );
	include ( NV_ROOTDIR . "/includes/footer.php" );

function displaySSList($list, $time, $path, $lang_module) {
  $xtpl = new XTemplate("luubenh-bang.tpl", $path);
	$xtpl->assign("lang", $lang_module);
  
  $status_option = array("Bình thường", "Hơi yếu", "Yếu", "Sắp chết", "Đã chết");
  $export = array("Lưu bệnh", "Đã điều trị", "Đã chết");
  $index = 1;
	foreach ($list as $key => $list_data) {
		// var_dump($list_data); die();
    $xtpl->assign("index", $index);
		$xtpl->assign("lid", $list_data["id"]);
		$xtpl->assign("petname", $list_data["petname"]);
		$xtpl->assign("customer", $list_data["customer"]);
		$xtpl->assign("phone", $list_data["phone"]);
		$xtpl->assign("petid", $list_data["petid"]);
    $xtpl->assign("luubenh", date("d/m/Y", $list_data["ngayluubenh"]));
    $suckhoe = 0;
    $lieutrinh = explode("|", $list_data["lieutrinh"]);
    $arrlieutrinh = array();
    $ngaybatdau = strtotime(date("Y-m-d", $list_data["ngayluubenh"]));
    $khoangcach = floor(1 + (strtotime(date("Y-m-d")) - $ngaybatdau) / (24 * 60 * 60));
    // var_dump($khoangcach); die();

    for ($i = 0; $i < $khoangcach; $i ++) { 
      $ngay = date("d/m/Y", ($ngaybatdau + $i * 24 * 60 * 60));
      $cumlieutrinh = $lieutrinh[$i] ? $lieutrinh[$i] : "";
      if ($cumlieutrinh !== "") {
        $x = explode(":", $cumlieutrinh);
        $tinhtrang = $x[0];
        $ghichu = $x[1];
        $suckhoe = $x[0];
      }
      else {
        $tinhtrang = "";
      }
      // echo $ngay; die();
      $arrlieutrinh[] = array("ngay" => $ngay, "ghichu" => $ghichu, "tinhtrang" => $tinhtrang);
    }
    $xtpl->assign("suckhoe", $status_option[$suckhoe]);
    // var_dump($list_data["ketqua"]);
    // die();
    $xtpl->assign("tinhtrang", $export[$list_data["ketqua"]]);
    $xtpl->assign("lieutrinh", json_encode($arrlieutrinh));

		// $xtpl->assign("thongbao", $list_data["ngaybao"]);
		$xtpl->parse("main.list");
		$index ++;
	}

	$xtpl->parse("main");
	return $xtpl->text("main");
}
?>
