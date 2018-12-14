<?php
/**
* @Project NUKEVIET-MUSIC
* @Phan Tan Dung (phantandung92@gmail.com)
* @Copyright (C) 2011
* @Createdate 26-01-2011 14:43
*/

if (!defined('NV_IS_QUANLY_ADMIN')) die('Stop!!!');
$link = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=";
$status_option = array("Bình thường", "Hơi yếu", "Yếu", "Sắp chết", "Đã chết");
$export = array("Lưu bệnh", "Đã điều trị", "Đã chết");

$xtpl = new XTemplate("treat.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
$xtpl->assign("lang", $lang_module);

$sql = "select * from " .  VAC_PREFIX . "_doctor";
$result = $db->sql_query($sql);

while ($row = $db->sql_fetch_assoc($result)) {
  $xtpl->assign("doctorid", $row["id"]);
  $xtpl->assign("doctorname", $row["name"]);
  $xtpl->parse("main.doctor");
  $xtpl->parse("main.doctor2");
  $xtpl->parse("main.doctor3");
}

$sort_type = array("Tên A-Z", "Tên Z-A", "Mới trước", "Cũ trước");
$order = array("order by c.name asc", "order by c.name desc", "order by cometime asc", "order by cometime desc");
$filter_type = array("25", "50", "100", "200", "Tất cả");
$ret = array("status" => 0, "data" => "");
$check = false;

foreach ($status_option as $key => $value) {
	// echo $value;
	$xtpl->assign("status_value", $key);
	$xtpl->assign("status_name", $value);
	$xtpl->parse("main.status_option");
	$xtpl->parse("main.status2");
}
foreach ($status_option as $key => $value) {
	// echo $value;
	$xtpl->assign("status_value", $key);
	$xtpl->assign("status_name", $value);
	$xtpl->parse("main.status");
}

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

if (empty($page)) {
	$page = 1;
}

$xtpl->assign("now", $today);
$xtpl->assign("ngayluubenh", date("Y-m-d", strtotime($today)));

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
		$where = "where cometime between $from and $to";
		break;
	case 1:
		$where = "where cometime <= $to";
	break;
	case 2:
		$where = "where cometime >= $from";
		break;
}
if (empty($where)) {
	$where = "where c.name like '%$keyword%' or phone like '%$keyword%' or b.name like '%$keyword%'";
} else $where .= " and (c.name like '%$keyword%' or phone like '%$keyword%' or b.name like '%$keyword%')";
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

if ($action) {
	$ret = array("status" => 0, "data" => array());
	switch ($action) {
		case 'treat_info':
			$id = $nv_Request->get_string('id', 'post', "");
			if (!empty($id)) {
				$sql = "select * from " .  VAC_PREFIX . "_treat where id = $id";
				$result = $db->sql_query($sql);
				
				if ($result) {
					$row = $db->sql_fetch_assoc($result);
					$sql = "select * from " .  VAC_PREFIX . "_pet where id = $row[petid]";
					$result = $db->sql_query($sql);
					$row2 = $db->sql_fetch_assoc($result);
					$ret["status"] = 1;
					$ret["data"] = array("calltime" => date("Y-m-d", $row["calltime"]), "cometime" => date("Y-m-d", $row["cometime"]), "doctorid" => $row["doctorid"], "customerid" => $row2["customerid"], "petid" => $row["petid"]);
				}
				echo json_encode($ret);
			}
		break;
		case 'update_treat':
			$id = $nv_Request->get_string('id', 'post', "");
			$cometime = $nv_Request->get_string('cometime', 'post', "");
			$doctorid = $nv_Request->get_string('doctorid', 'post', "");
			if (!(empty($id) || empty($cometime) || empty($doctorid))) {
				$cometime = strtotime($cometime);
				$sql = "update " .  VAC_PREFIX . "_treat set cometime = $cometime, doctorid = $doctorid where id = $id";
				$result = $db->sql_query($sql);

				if ($result) {
					$ret["status"] = 1;
				}
				echo json_encode($ret);
			}
		break;
	}
	die();
}

// $sql = "select * from " .  VAC_PREFIX . "_usg a inner join " .  VAC_PREFIX . "_pet b on a.petid = b.id $order[$sort]";
$revert = true;
$tpage = $page;
while ($revert) {
	$tpage --;
	if ($tpage <= 0) $revert = false;
	$from = $tpage * $filter;
	$to = $from + $filter;
	$sql = "select a.id, a.cometime, a.insult, b.name as petname, c.name as customer, c.phone, d.name as doctor from " .  VAC_PREFIX . "_treat a inner join " .  VAC_PREFIX . "_pet b on a.petid = b.id inner join " .  VAC_PREFIX . "_customer c on b.customerid = c.id inner join " .  VAC_PREFIX . "_doctor d on a.doctorid =d.id $where $order[$sort] limit $from, $to";
	$result = $db->sql_query($sql);
	$display_list = array();
	while ($row = $db->sql_fetch_assoc($result)) {
		$sql = "select b.status from " .  VAC_PREFIX . "_treat a inner join " .  VAC_PREFIX . "_treating b on b.treatid = $row[id] and a.id = b.treatid order by b.time desc";
		$query = $db->sql_query($sql);
		$row2 = $db->sql_fetch_assoc($query);
		if (!$row2["status"]) {
			$row2["status"] = 0;
		}
		$row["status"] = $row2["status"];
		$display_list[] = $row;
		
		$revert = false;
	}
}

// echo $sql;
// var_dump($display_list);
// die();

$sql = "select count(a.id) as num from " .  VAC_PREFIX . "_treat a inner join " .  VAC_PREFIX . "_pet b on a.petid = b.id inner join " .  VAC_PREFIX . "_customer c on b.customerid = c.id inner join " .  VAC_PREFIX . "_doctor d on a.doctorid =d.id $where";
$result = $db->sql_query($sql);
$row = $db->sql_fetch_assoc($result);

// die($sql);
$num = $row["num"];
$url = $link . $op . "&sort=$sort&filter=$filter";
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
	global $export, $status_option;
	$xtpl = new XTemplate("treat-list.tpl", $path);
	$xtpl->assign("lang", $lang_module);	

	// echo $path; die();
	$stt = $index;
	foreach ($list as $key => $row) {
		$xtpl->assign("stt", $stt);
		$xtpl->assign("id", $row["id"]);
		$xtpl->assign("customer", $row["customer"]);
		$xtpl->assign("petname", $row["petname"]);
		$xtpl->assign("doctor", $row["doctor"]);
		$xtpl->assign("luubenh", date("d/m/Y", $row["cometime"]));
		$xtpl->assign("nav_link", $nav);
		$xtpl->assign("ketqua", $export[$row["insult"]]);
		$xtpl->assign("tinhtrang", $status_option[$row["status"]]);
    $xtpl->assign("bgcolor", mauluubenh($row["insult"], $row["status"]));
		// $xtpl->assign("delete_link", "");

		$xtpl->parse("main.row");
		$stt ++;
	}

	$xtpl->parse("main");
	return $xtpl->text("main");
}
?>