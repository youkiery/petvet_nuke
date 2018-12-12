<?php
/**
 * @Project NUKEVIET-MUSIC
 * @Author Phan Tan Dung
 * @Copyright (C) 2011
 * @Createdate 26/01/2011 10:26 AM
 */
if (!defined('NV_IS_MOD_QUANLY')) die('Stop!!!');
quagio();
	$key = $nv_Request->get_string('key', 'get', '');
	$page_title = $lang_module["tieude_usg_danhsach"];
	$xtpl = new XTemplate("sieuam-danhsach.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
	$xtpl->assign("lang", $lang_module);
	
	$xtpl->assign("keyword", $key);
	$now = strtotime(date("Y-m-d", NV_CURRENTTIME));
	$time = $module_config[$module_file]["filter_time"];

	if (empty($time)) $time = 7 * 24 * 60 * 60;
	$from = $now - $time;
	$end = $now + $time;

	$sql = "select a.id, a.cometime, a.calltime, a.status, a.image, a.note, b.id as petid, b.name as petname, c.name as customer, c.phone, d.name as doctor from `" . VAC_PREFIX . "_usg` a inner join `" . VAC_PREFIX . "_pet` b on a.calltime between $from and $end and a.petid = b.id inner join `" . VAC_PREFIX . "_customer` c on b.customerid = c.id inner join `" . VAC_PREFIX . "_doctor` d on a.doctorid = d.id where c.name like '%$key%' or c.phone like '%$key%' order by calltime";
	// echo date("Y-m-d", 1545238800);
	// die($sql);
	$result = $db->sql_query($sql);

	$display_list = array();
	while ($row = $db->sql_fetch_assoc($result)) {
		$display_list[] = $row;
	}

	// var_dump($display_list);
	// die();
	$xtpl->assign("content", displaySSList($display_list, $time, NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file, $lang_module));

	$xtpl->parse("main");
	$contents = $xtpl->text("main");

	include ( NV_ROOTDIR . "/includes/header.php" );
	echo nv_site_theme( $contents );
	include ( NV_ROOTDIR . "/includes/footer.php" );


function displaySSList($list, $time, $path, $lang_module) {
	$xtpl = new XTemplate("sieuam-hang.tpl", $path);
	$xtpl->assign("lang", $lang_module);

	$hex = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");
	$status_color = array("red", "orange", "green");
	$now = strtotime(date("Y-m-d", time()));
	$today = date("d", $now);
	$dom = date("t");
	$time = ceil($time / 60 / 60 / 24 / 14) + 1;
	
	$sort_order_left = array();
	$sort_order_right = array();
	$array_left = array();
	$array_right = array();

	foreach ($list as $key => $row) {
		if ($row["calltime"] < $now) {
			$sort_order_right[] = $key;
		} else
			$sort_order_left[] = $key;
	}
	asort($sort_order_left);
	arsort($sort_order_right);

  foreach ($sort_order_left as $key => $value) {
    $d = date("d", $list[$value]["calltime"]);
    if ($d - $today < 0) {
      $c = $dom - $today + $d;
    } else {
      $c = $d - $today;
    }
		$c = 15 - round($c / 3);
		$list[$value]["bgcolor"] = "#4" . $hex[$c] . "4";
		$array_left[] = $list[$value];
	}
  foreach ($sort_order_right as $key => $value) {
    $d = date("d", $list[$value]["ngaybao"]);
    if ($today - $d < 0) {
      $c = $today + $dom - $d;
    } else {
      $c = $today - $d;
    }
    $c = 14 - round($c / 3);
		$list[$value]["bgcolor"] = "#$hex[$c]$hex[$c]$hex[$c]";
		$array_right[] = $list[$value];
	}

	$list = array_merge($array_left, $array_right);
	$index = 1;
	foreach ($list as $key => $list_data) {
		// var_dump($list_data); die();
    $xtpl->assign("index", $index);
    // var_dump($list_data); die();
		$xtpl->assign("image", $list_data["image"]);
		$xtpl->assign("petname", $list_data["petname"]);
		$xtpl->assign("customer", $list_data["customer"]);
		$xtpl->assign("phone", $list_data["phone"]);
		$xtpl->assign("vacid", $list_data["id"]);
		$xtpl->assign("petid", $list_data["petid"]);
		$xtpl->assign("note", $list_data["note"]);
		$xtpl->assign("sieuam", date("d/m/Y", $list_data["cometime"]));
		$xtpl->assign("dusinh", date("d/m/Y", $list_data["calltime"]));
		// $xtpl->assign("thongbao", $list_data["ngaybao"]);
		$xtpl->assign("color", $status_color[$list_data["status"]]);
		$xtpl->assign("bgcolor", $list_data["bgcolor"]);
		// var_dump($lang_module); die();
		switch ($list_data["status"]) {
			case '1':
				$color = "orange";
				break;
			case '2':
				$color = "green";
				break;
			default:
				$color = "red";
		}
		$xtpl->assign("status", $lang_module["confirm_value2"][$list_data["status"]]);
		$xtpl->assign("color", $color);
		$xtpl->parse("main.list");
		$index ++;
	}

	$xtpl->parse("main");
	return $xtpl->text("main");
}

?>
