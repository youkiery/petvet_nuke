<?php
/**
* @Project NUKEVIET-MUSIC
* @Phan Tan Dung (phantandung92@gmail.com)
* @Copyright (C) 2011
* @Createdate 26-01-2011 14:43
*/

if (!defined('NV_IS_VAC_ADMIN')) die('Stop!!!');
$link = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=";

$xtpl = new XTemplate("sieuam.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
$xtpl->assign("lang", $lang_module);
$sort_type = array("Tên A-Z", "Tên Z-A", "Ngày siêu âm", "Ngày báo");
$order = array("order by customer asc", "order by customer desc", "order by ngaysieuam", "order by ngaybao");
$filter_type = array("25", "50", "100", "200", "Tất cả");

$sort = $nv_Request -> get_string('sort', 'get', '');
$filter = $nv_Request -> get_string('filter', 'get', '');
$from = $nv_Request -> get_string('from', 'get', '');
$to = $nv_Request -> get_string('to', 'get', '');
$keyword = $nv_Request -> get_string('keyword', 'get', '');
$page = $nv_Request->get_string('page', 'get', "");
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

// $sql = "select * from vng_vac_sieuam a inner join vng_vac_pets b on a.idthucung = b.id $order[$sort]";
$from = ($page - 1) * $filter;
$to = $from + $filter;
$sql = "select * from vng_vac_sieuam a inner join vng_vac_pets b on a.idthucung = b.id inner join vng_vac_customers c on b.customerid = c.id $where $order[$sort] limit $from, $to";
$result = $db->sql_query($sql);
$display_list = array();
while ($row = $db->sql_fetch_assoc($result)) {
	$display_list[] = $row;
}

$sql = "select count(a.id) as num from vng_vac_sieuam a inner join vng_vac_pets b on a.idthucung = b.id inner join vng_vac_customers c on b.customerid = c.id $where";
$result = $db->sql_query($sql);
$row = $db->sql_fetch_assoc($result);
// die($sql);
$num = $row["num"];
$url = $link . "sieuam&sort=$sort&filter=$filter";
if(!empty($keyword)) {
	$url .= "&key=$keyword";
}

// echo "$url, $num, $filter, $page";die();

$xtpl->assign("nav_link", nv_generate_page_shop($url, $num, $filter, $page));
// var_dump($display_list);
// die();

$xtpl->assign("content", displayRed($display_list, NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file, $lang_module, $from + 1));

$xtpl->parse("main");
$contents = $xtpl->text("main");

include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");

function displayRed($list, $path, $lang_module, $index) {
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
		$xtpl->assign("sieuam", date("d/m/Y", $row["ngaysieuam"]));
		$xtpl->assign("dusinh", date("d/m/Y", $row["ngaydusinh"]));
		$xtpl->assign("ngaybao", date("d/m/Y", $row["ngaybao"]));
		$xtpl->parse("main.row");

		$stt ++;
	}

	$xtpl->parse("main");
	return $xtpl->text("main");
}
?>