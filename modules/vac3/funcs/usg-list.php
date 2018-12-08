<?php

/**
 * @Project TXManager
 * @Author Youkiery (youkiery@gmail.com)
 * @copyright 2018
 * @createdate 01/11/2018 08:00 AM
 */

if (!defined('NV_IS_MOD_VAC')) die('Stop!!!');
quagio();

$page_title = $lang_module["usg_title"];
$page = $nv_Request->get_string('page', 'get', '');
$keyword = $nv_Request->get_string('keyword', 'get', '');

if ($page) {
  $data_content["list"] = parse_list(get_usg_recent_list($keyword), 0);
  // get recently list
}
else {
  $data_content["list"] = parse_list(get_usg_list($keyword), 1);
  // get list
}
$data_content["page"] = $page;
$data_content["keyword"] = $keyword;

$contents = call_user_func("usg_vaccine_list", $data_content);
include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

// $key = $nv_Request->get_string('key', 'get', '');
// $page_title = $lang_module["tieude_sieuam_danhsach"];
// $xtpl = new XTemplate("sieuam-danhsach.tpl", VAC_PATH);
// $xtpl->assign("lang", $lang_module);
	
// 	$xtpl->assign("keyword", $key);
// 	$now = strtotime(date("Y-m-d", NV_CURRENTTIME));
// 	$time = $global_config["filter_time"];

// 	if (empty($time)) $time = 7 * 24 * 60 * 60;
// 	$from = $now - $time;
// 	$end = $now + $time;

// 	$sql = "select a.id, a.ngaysieuam, a.ngaydusinh, a.ngaybao, a.trangthai, a.hinhanh, b.id as petid, b.petname, c.customer, c.phone, d.doctor from `" . VAC_PREFIX . "_sieuam` a inner join `" . VAC_PREFIX . "_pets` b on ngaybao between $from and $end and a.idthucung = b.id inner join `" . VAC_PREFIX . "_customers` c on b.customerid = c.id inner join `" . VAC_PREFIX . "_doctor` d on a.idbacsi = d.id where c.customer like '%$key%' or c.phone like '%$key%' order by ngaybao";
// 	// die($sql);
// 	// echo date("Y-m-d", 1545238800);
// 	// die($sql);
// 	$result = $db->sql_query($sql);

// 	$display_list = array();
// 	while ($row = $db->sql_fetch_assoc($result)) {
// 		$display_list[] = $row;
// 	}

// 	// var_dump($display_list);
// 	// die();
// 	$xtpl->assign("content", displaySSList($display_list, $time, VAC_PATH, $lang_module));

// 	$xtpl->parse("main");
// 	$contents = $xtpl->text("main");
	
	
// $contents = call_user_func("usg_vaccine_page", $data_content);
// include ( NV_ROOTDIR . "/includes/header.php" );
// echo nv_site_theme( $contents );
// include ( NV_ROOTDIR . "/includes/footer.php" );
	
// 	function displaySSList($list, $time, $path, $lang_module) {
// 	$xtpl = new XTemplate("sieuam-hang.tpl", $path);
// 	$xtpl->assign("lang", $lang_module);

// 	$hex = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");
// 	$status_color = array("red", "orange", "green");
// 	$fromtime = strtotime($fromtime);
// 	$now = strtotime(date("Y-m-d", time()));
// 	$today = date("d", $now);
// 	$dom = date("t");
// 	$time = ceil($time / 60 / 60 / 24 / 7) + 1;
	
// 	$sort_order_left = array();
// 	$sort_order_right = array();
// 	$array_left = array();
// 	$array_right = array();

// 	foreach ($list as $key => $row) {
// 		if ($row["ngaybao"] < $now) {
// 			$sort_order_right[] = $key;
// 		} else
// 			$sort_order_left[] = $key;
// 	}
// 	asort($sort_order_left);
// 	arsort($sort_order_right);

//   foreach ($sort_order_left as $key => $value) {
//     $d = date("d", $list[$value]["ngaybao"]);
//     if ($d - $today < 0) {
//       $c = $dom - $today + $d;
//     } else {
//       $c = $d - $today;
//     }
// 		$c = 15 - round($c / $time);
// 		$list[$value]["bgcolor"] = "#4" . $hex[$c] . "4";
// 		$array_left[] = $list[$value];
// 	}
//   foreach ($sort_order_right as $key => $value) {
//     $d = date("d", $list[$value]["ngaybao"]);
//     if ($today - $d < 0) {
//       $c = $today + $dom - $d;
//     } else {
//       $c = $today - $d;
//     }
//     $c = 14 - round($c / $time);
// 		$list[$value]["bgcolor"] = "#$hex[$c]$hex[$c]$hex[$c]";
// 		$array_right[] = $list[$value];
// 	}

// 	$list = array_merge($array_left, $array_right);
// 	$index = 1;
// 	foreach ($list as $key => $list_data) {
// 		// var_dump($list_data); die();
//     $xtpl->assign("index", $index);
//     // var_dump($list_data); die();
// 		$xtpl->assign("image", $list_data["hinhanh"]);
// 		$xtpl->assign("petname", $list_data["petname"]);
// 		$xtpl->assign("customer", $list_data["customer"]);
// 		$xtpl->assign("phone", $list_data["phone"]);
// 		$xtpl->assign("vacid", $list_data["id"]);
// 		$xtpl->assign("petid", $list_data["petid"]);
// 		$xtpl->assign("sieuam", date("d/m/Y", $list_data["ngaysieuam"]));
// 		$xtpl->assign("dusinh", date("d/m/Y", $list_data["ngaydusinh"]));
// 		$xtpl->assign("thongbao", date("d/m/Y", $list_data["ngaybao"]));
// 		// $xtpl->assign("thongbao", $list_data["ngaybao"]);
// 		$xtpl->assign("color", $status_color[$list_data["status"]]);
// 		$xtpl->assign("bgcolor", $list_data["bgcolor"]);
// 		// var_dump($lang_module); die();
// 		switch ($list_data["trangthai"]) {
// 			case '1':
// 				$color = "orange";
// 				break;
// 			case '2':
// 				$color = "green";
// 				break;
// 			default:
// 				$color = "red";
// 		}
// 		$xtpl->assign("trangthai", $lang_module["confirm_" . $list_data["trangthai"]]);
// 		$xtpl->assign("color", $color);
// 		$xtpl->parse("main.list");
// 		$index ++;
// 	}

// 	$xtpl->parse("main");
// 	return $xtpl->text("main");
// }

?>
