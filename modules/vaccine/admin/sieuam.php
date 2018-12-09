<?php
/**
* @Project NUKEVIET-MUSIC
* @Phan Tan Dung (phantandung92@gmail.com)
* @Copyright (C) 2011
* @Createdate 26-01-2011 14:43
*/

if (!defined('NV_IS_QUANLY_ADMIN')) die('Stop!!!');
$link = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=";

$xtpl = new XTemplate("sieuam.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
$xtpl->assign("lang", $lang_module);
$sort_type = array("Tên A-Z", "Tên Z-A", "Ngày siêu âm", "Ngày báo");
$order = array("order by customer asc", "order by customer desc", "order by cometime", "order by ngaybao");
$filter_type = array("25", "50", "100", "200", "Tất cả");
$ret = array("status" => 0, "data" => "");
$check = false;

$sort = $nv_Request -> get_string('sort', 'get', '');
$filter = $nv_Request -> get_string('filter', 'get', '');
$from = $nv_Request -> get_string('from', 'get', '');
$to = $nv_Request -> get_string('to', 'get', '');
$keyword = $nv_Request -> get_string('keyword', 'get', '');
$page = $nv_Request->get_string('page', 'get', "");
$action = $nv_Request->get_string('action', 'post', "");
$id = $nv_Request->get_string('id', 'post', "");
$xtpl->assign("keyword", $keyword);

$today = date("Y-m-d", NV_CURRENTTIME);
$dusinh = $global_config["dusinh"];
if (empty($dusinh)) {
	$dusinh = 45 * 24 * 60 * 60;
}
$thongbao = $global_config["thongbao"];
if (empty($thongbao)) {
	$thongbao = 45 * 24 * 60 * 60;
}

if (empty($page)) {
	$page = 1;
}

$xtpl->assign("now", $today);
$xtpl->assign("dusinh", date("Y-m-d", strtotime($today) + $dusinh));
$xtpl->assign("thongbao", date("Y-m-d", strtotime($today) + $thongbao));

if (empty($sort)) $sort = 0;
if (empty($filter)) $filter = 25;
$where = "";
$tick = 0;
if (empty($from)) $tick += 1;
else {
	$xtpl->assign("from", $from);
	$from = strtotime($from);
}
if (empty($to)) $tick += 2;
else {
	$xtpl->assign("to", $to);
	$to = strtotime($to);
}

switch ($tick) {
	case 0:
		if ($from > $to) {
			$t = $from;
			$from = $to;
			$to = $t;
		}
		$where = "where ngaybao between $from and $to";
		break;
	case 1:
		$where = "where ngaybao <= $to";
	break;
	case 2:
		$where = "where ngaybao >= $from";
		break;
}
if (empty($where)) {
	$where = "where customer like '%$keyword%' or phone like '%$keyword%' or petname like '%$keyword%'";
} else $where .= " and (customer like '%$keyword%' or phone like '%$keyword%' or petname like '%$keyword%')";
// die($where);

foreach ($sort_type as $key => $sort_name) {
	$xtpl->assign("sort_name", $sort_name);
	$xtpl->assign("sort_value", $key);
	if ($key == $sort) $xtpl->assign("sort_check", "selected");
	else $xtpl->assign("sort_check", "");
	$xtpl->parse("main.sort");
}

foreach ($filter_type as $filter_value) {
	$xtpl->assign("time_value", $filter_value);
	$xtpl->assign("time_name", $filter_value);
	if ($filter_value == $filter) $xtpl->assign("time_check", "selected");
	else $xtpl->assign("time_check", "");
	$xtpl->parse("main.time");
}

if ($action == "xoasieuam" && !empty($id)) {
	$sql = "delete from " .  VAC_PREFIX . "_usg where id = $id";
	$ret["data"] = $sql;
	// echo json_encode($ret);
	// die();
	$result = $db->sql_query($sql);

	if ($result) {
		$check = true;
	}
}
$sql = "select * from " .  VAC_PREFIX . "_doctor";
$result = $db->sql_query($sql);

while ($row = $db->sql_fetch_assoc($result)) {
	$xtpl->assign("doctor_value", $row["id"]);
	$xtpl->assign("doctor_name", $row["name"]);
	$xtpl->parse("main.doctor");
}

// $sql = "select * from " .  VAC_PREFIX . "_usg a inner join " .  VAC_PREFIX . "_pet b on a.petid = b.id $order[$sort]";
$revert = true;
$tpage = $page;
while ($revert) {
	$tpage --;
	if ($tpage <= 0) $revert = false;
	$from = $tpage * $filter;
	$to = $from + $filter;
	$sql = "select a.id, a.cometime, a.calltime, b.name as petname, c.name as customer, c.phone, d.name as doctor from " .  VAC_PREFIX . "_usg a inner join " .  VAC_PREFIX . "_pet b on a.petid = b.id inner join " .  VAC_PREFIX . "_customer c on b.customerid = c.id inner join " .  VAC_PREFIX . "_doctor d on a.doctorid = d.id $where $order[$sort] limit $from, $to";
	// die($sql);
	$result = $db->sql_query($sql);
	$display_list = array();
	while ($row = $db->sql_fetch_assoc($result)) {
		$display_list[] = $row;
		$revert = false;
	}
}

$sql = "select count(a.id) as num from " .  VAC_PREFIX . "_usg a inner join " .  VAC_PREFIX . "_pet b on a.petid = b.id inner join " .  VAC_PREFIX . "_customer c on b.customerid = c.id inner join " .  VAC_PREFIX . "_doctor d on a.doctorid = d.id $where";
$result = $db->sql_query($sql);
$row = $db->sql_fetch_assoc($result);

// die($sql);
$num = $row["num"];
$url = $link . "sieuam&sort=$sort&filter=$filter";
if(!empty($keyword)) {
	$url .= "&key=$keyword";
}

// echo "$url, $num, $filter, $page";die();

$nav = nv_generate_page_shop($url, $num, $filter, $page);
// var_dump($display_list);
// die();
if ($action == "xoasieuam") {
	if ($check) {
		$ret["status"] = 1;
		$ret["data"] = displayRed($display_list, NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file, $lang_module, $from + 1, $nav);
	}

	echo json_encode($ret);
	die();
} else {
	$xtpl->assign("content", displayRed($display_list, NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file, $lang_module, $from + 1, $nav));
}

$xtpl->parse("main");
$contents = $xtpl->text("main");

include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");

function displayRed($list, $path, $lang_module, $index, $nav) {
	$xtpl = new XTemplate("sieuam-hang.tpl", $path);
	$xtpl->assign("lang", $lang_module);	

	// echo $path; die();
	$stt = $index;
	foreach ($list as $key => $row) {
		$xtpl->assign("stt", $stt);
		$xtpl->assign("id", $row["id"]);
		$xtpl->assign("customer", $row["customer"]);
		$xtpl->assign("petname", $row["petname"]);
		$xtpl->assign("phone", $row["phone"]);
		$xtpl->assign("doctor", $row["doctor"]);
		$xtpl->assign("sieuam", date("d/m/Y", $row["cometime"]));
		$xtpl->assign("dusinh", date("d/m/Y", $row["calltime"]));
		$xtpl->assign("ngaybao", date("d/m/Y", $row["ngaybao"]));
		$xtpl->assign("nav_link", $nav);
		// $xtpl->assign("delete_link", "");

		$xtpl->parse("main.row");
		$stt ++;
	}

	$xtpl->parse("main");
	return $xtpl->text("main");
}
?>