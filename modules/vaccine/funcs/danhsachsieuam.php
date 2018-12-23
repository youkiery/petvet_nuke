<?php
/**
 * @Project NUKEVIET-MUSIC
 * @Author Phan Tan Dung
 * @Copyright (C) 2011
 * @Createdate 26/01/2011 10:26 AM
 */
if (!defined('NV_IS_MOD_QUANLY')) die('Stop!!!');
quagio();
	$keyword = $nv_Request->get_string('key', 'get', '');
	$page = $nv_Request->get_string('page', 'get', '');
	$limit = $nv_Request->get_string('limit', 'get', '');
	$page_title = $lang_module["tieude_usg_danhsach"];

	$xtpl = new XTemplate("sieuam-danhsach.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
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

	$sql = "select count(a.id) as count from `" . VAC_PREFIX . "_usg` a inner join `" . VAC_PREFIX . "_pet` b on a.calltime between $from and $end and a.petid = b.id inner join `" . VAC_PREFIX . "_customer` c on b.customerid = c.id where c.name like '%$keyword%' or c.phone like '%$keyword%' order by calltime";
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

	$sql = "select a.id, a.cometime, a.calltime, a.status, a.image, a.note, a.birthday, a.birth, a.doctorid, b.id as petid, b.name as petname, c.name as customer, c.phone from `" . VAC_PREFIX . "_usg` a inner join `" . VAC_PREFIX . "_pet` b on a.calltime between $from and $end and a.petid = b.id inner join `" . VAC_PREFIX . "_customer` c on b.customerid = c.id where c.name like '%$keyword%' or c.phone like '%$keyword%' order by calltime " . $limit_page;
	// $sql = "select * from " . VAC_PREFIX . "_usg where calltime between " . $from . " and " . $end . " order by calltime limit";
	$query = $db->sql_query($sql);
	$list = array();
	while ($usg_row = $db->sql_fetch_assoc($query)) {
		if ($usg_row["doctorid"]) {
			$usg_row["doctor"] = $doctor[$usg_row["doctorid"]];
		}
		else {
			$usg_row["doctor"] = "";
		}
		$list[] = $usg_row;
		// $sql = "select * from " . VAC_PREFIX . "_pet where id = " . $usg_row["petid"] . " and name like '%" . $keyword . "%'";
		// $query = $db->sql_query($sql);
		// $pet_row = $db->sql_fetch_assoc($query);

		// $sql = "select * from " . VAC_PREFIX . "_customer where id = " . $pet_row["customerid"] . " and (name like '%" . $keyword . "%' or phone like '%" . $keyword . "%')";
		// $query = $db->sql_query($sql);
		// $customer_row = $db->sql_fetch_assoc($query);

		// if ($customer_row) {
		// 	$usg_row["petname"] = $pet_row["name"];
		// 	$usg_row["customer"] = $customer_row["name"];
		// 	$usg_row["phone"] = $customer_row["phone"];
		// 	$usg_row["doctor"] = $doctor[$usg_row["doctorid"]];
		// 	$list[] = $usg_row;
		// }
	}

	// var_dump($display_list);
	// die();
	$xtpl->assign("content", displaySSList($list, $time, NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file, $lang_module));

	$xtpl->parse("main");
	$contents = $xtpl->text("main");

	include ( NV_ROOTDIR . "/includes/header.php" );
	echo nv_site_theme( $contents );
	include ( NV_ROOTDIR . "/includes/footer.php" );


function displaySSList($list, $time, $path, $lang_module) {
	global $url, $count, $limit, $page;
	$xtpl = new XTemplate("sieuam-hang.tpl", $path);
	$xtpl->assign("lang", $lang_module);

	$hex = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");
	$status_color = array("red", "orange", "yellow", "green");

	// $now = strtotime(date("Y-m-d", time()));
	// $today = date("d", $now);
	// $dom = date("t");
	// $time = ceil($time / 60 / 60 / 24 / 14) + 1;
	
	// $sort_order_left = array();
	// $sort_order_right = array();
	// $array_left = array();
	// $array_right = array();

	// foreach ($list as $key => $row) {
	// 	if ($row["calltime"] < $now) {
	// 		$sort_order_right[] = $key;
	// 	} else
	// 		$sort_order_left[] = $key;
	// }
	// asort($sort_order_left);
	// arsort($sort_order_right);
	// if (count($sort_order_left) > 1) {
	// 	$hack = ($list[$sort_order_left[count($sort_order_left) - 1]]["calltime"] - $list[$sort_order_left[0]]["calltime"]) + 1;
	// }
	// else {
	// 	$hack = 60 * 60 * 24 * 7;
	// }
  // foreach ($sort_order_left as $key => $value) {
	// 	$d = $list[$value]["calltime"];
  //   $c = 15 - round(($d - $now) * 2 / $hack);
	// 	$list[$value]["bgcolor"] = "#4" . $hex[$c] . "4";
	// 	$array_left[] = $list[$value];
	// }
  // foreach ($sort_order_right as $key => $value) {
	// 	$d = $list[$value]["calltime"];
  //   $c = 14 - round(($now - $d) * 2 / $hack);
	// 	$list[$value]["bgcolor"] = "#$hex[$c]$hex[$c]$hex[$c]";
	// 	$array_right[] = $list[$value];
	// }

	// $list = array_merge($array_left, $array_right);
	$index = ($page - 1) * $limit + 1;
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
		$xtpl->assign("birth", $list_data["birth"]);
		$xtpl->assign("sieuam", date("d/m/Y", $list_data["cometime"]));
		$xtpl->assign("dusinh", date("d/m/Y", $list_data["calltime"]));
		$xtpl->assign("color", $status_color[$list_data["status"]]);

		// $xtpl->assign("bgcolor", $list_data["bgcolor"]);
		if (!empty($status_color[$list_data["status"]])) {
			$color = $status_color[$list_data["status"]];
		}
		else {
			$color = $status_color[0];
		}
		if ($list_data["status"] == 3) {
			if ($list_data["birthday"] > 0) {
				$xtpl->assign("checked", "disabled");
			}
			else {
				$xtpl->assign("checked", "");
			}
			$xtpl->parse("main.list.birth");
		}
		$xtpl->assign("status", $lang_module["confirm_value2"][$list_data["status"]]);
		$xtpl->assign("color", $color);
		$xtpl->parse("main.list");
		$index ++;
	}
	$nav = nv_generate_page_shop($url, $count, $limit, $page);
	$xtpl->assign("nav", $nav);
	$xtpl->parse("main");
	return $xtpl->text("main");
}

?>
