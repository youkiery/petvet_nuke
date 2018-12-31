<?php
/**
* @Project NUKEVIET-MUSIC
* @Phan Tan Dung (phantandung92@gmail.com)
* @Copyright (C) 2011
* @Createdate 26-01-2011 14:43
*/
if (!defined('NV_IS_QUANLY_ADMIN')) die('Stop!!!');
$link = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=";
$action = $nv_Request->get_string('action', 'post', "");
if ($action) {
	switch ($action) {
		case 'editvac':
			$id = $nv_Request->get_string('id', 'post', "");
			$diseaseid = $nv_Request->get_string('diseaseid', 'post', "");
			$cometime = $nv_Request->get_string('cometime', 'post', "");
			$doctorid = $nv_Request->get_string('doctorid', 'post', "");
			$calltime = $nv_Request->get_string('calltime', 'post', "");
			$note = $nv_Request->get_string('note', 'post', "");
			if (!(empty($id) || empty($diseaseid) || empty($cometime) || empty($calltime))) {
				$cometime = strtotime($cometime);
				$calltime = strtotime($calltime);
				$sql = "update " . VAC_PREFIX . "_vaccine set diseaseid = $diseaseid, cometime = $cometime, calltime = $calltime, note = '$note', doctorid = $doctorid	 where id = $id";
				$result = $db->sql_query($sql);
				if ($result) {
					echo 1;
				}
			}
			break;
		case 'remove_vaccine':
			$id = $nv_Request->get_string('id', 'post', "");
			if (!empty($id)) {
				$sql = "delete from " .  VAC_PREFIX . "_vaccine where id = $id";
				$result = $db->sql_query($sql);
				if ($result) {
					$check = true;
				}
				echo 1;
			}
			break;
		case 'getvac':
			$id = $nv_Request->get_string('id', 'post', "");	
			if (!empty($id)) {
				$sql = "select * from " .  VAC_PREFIX . "_vaccine where id = $id";
				$result = $db->sql_query($sql);
				$row = $db->sql_fetch_assoc($result);
				$sql = "select * from " .  VAC_PREFIX . "_pet where id = $row[petid]";
				$result = $db->sql_query($sql);
				$pet = $db->sql_fetch_assoc($result);
				$row["cometime"] = date("Y-m-d", $row["cometime"]);
				$row["calltime"] = date("Y-m-d", $row["calltime"]);
				$row["customerid"] = $pet["customerid"];
				$row["petname"] = $pet["name"];
				if ($row) {
					echo json_encode($row);
				}
			}
			break;
	}
	die();
}

$xtpl = new XTemplate("vaccine.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
$xtpl->assign("lang", $lang_module);
$sort_type = array("Ngày tái chủng giảm", "Ngày tái chủng tăng", "Ngày tiêm phòng giảm", "Ngày tiêm phòng tăng", "Tên A-Z", "Tên Z-A");
$order = array("order by calltime desc", "order by calltime asc", "order by cometime desc", "order by cometime asc", "order by customer asc", "order by customer desc");
$filter_type = array("25", "50", "100", "200", "Tất cả");
$ret = array("status" => 0, "data" => "");
$check = false;

if (!empty($module_config[$module_name]["filter_time"])) {
	$filter_time = $module_config[$module_name]["filter_time"];
}
else {
	$filter_time = 24 * 60 * 60 * 7;
}



$sort = $nv_Request -> get_string('sort', 'get', '');
$filter = $nv_Request -> get_string('filter', 'get', '');
$from = $nv_Request -> get_string('from', 'get', '');
$to = $nv_Request -> get_string('to', 'get', '');
$keyword = $nv_Request -> get_string('keyword', 'get', '');
$page = $nv_Request->get_string('page', 'get', "");
$id = $nv_Request->get_string('id', 'post', "");
$xtpl->assign("keyword", $keyword);
$xtpl->assign("nv", $module_name);
$xtpl->assign("op", $op);

$today = date("Y-m-d", NV_CURRENTTIME);
$sql = "select * from " . VAC_PREFIX . "_doctor";
$query = $db->sql_query($sql);
while ($row = $db->sql_fetch_assoc($query)) {
	$xtpl->assign("doctorid", $row["id"]);
	$xtpl->assign("doctorname", $row["name"]);
	$xtpl->parse("main.doctor");
	$xtpl->parse("main.doctor2");
}
$diseases = getDiseaseList();
foreach ($diseases as $key => $value) {
	$xtpl->assign("disease_id", $value["id"]);
	$xtpl->assign("disease_name", $value["name"]);
	$xtpl->parse("main.option");
	$xtpl->parse("main.option2");
}

if (empty($page)) {
	$page = 1;
}

$xtpl->assign("now", $today);
$xtpl->assign("calltime", date("Y-m-d", strtotime(date("Y-m-d")) + $filter_time));

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
		$where = "where calltime between $from and $to";
		break;
	case 1:
		$where = "where calltime <= $to";
	break;
	case 2:
		$where = "where calltime >= $from";
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
// 	$sql = "select a.id, a.cometime, a.calltime, b.id as petid, b.name as petname, c.id as customerid, c.name as customer, c.phone, d.name as doctor, a.diseaseid, dd.name as disease from " .  VAC_PREFIX . "_vaccine a inner join " .  VAC_PREFIX . "_pet b on a.petid = b.id inner join " .  VAC_PREFIX . "_customer c on b.customerid = c.id inner join " .  VAC_PREFIX . "_doctor d on a.doctorid = d.id inner join (select * from " . VAC_PREFIX . "_disease union (select 0 as id, 'Siêu Âm' as name from DUAL)) dd on a.diseaseid = dd.id $where $order[$sort] limit $from, $to";
	$sql = "select a.id, a.cometime, a.calltime, b.id as petid, b.name as petname, c.id as customerid, c.name as customer, c.phone, d.name as doctor, a.diseaseid, dd.name as disease from " .  VAC_PREFIX . "_vaccine a inner join " .  VAC_PREFIX . "_pet b on a.petid = b.id inner join " .  VAC_PREFIX . "_customer c on b.customerid = c.id inner join " .  VAC_PREFIX . "_doctor d on a.doctorid = d.id inner join " . VAC_PREFIX . "_disease dd on a.diseaseid = dd.id $where $order[$sort] limit $filter offset $from";
	$result = $db->sql_query($sql);
	$sql = "select a.id, a.cometime, a.calltime, b.id as petid, b.name as petname, c.id as customerid, c.name as customer, c.phone, d.name as doctor, a.diseaseid, dd.name as disease from " .  VAC_PREFIX . "_vaccine a inner join " .  VAC_PREFIX . "_pet b on a.petid = b.id inner join " .  VAC_PREFIX . "_customer c on b.customerid = c.id inner join " .  VAC_PREFIX . "_doctor d on a.doctorid = d.id inner join (select 0 as id, 'Siêu Âm' as name from DUAL) dd on a.diseaseid = dd.id $where $order[$sort] limit $filter offset $from";
	$result2 = $db->sql_query($sql);
	$display_list = array();
	while ($row = $db->sql_fetch_assoc($result)) {
		$display_list[] = $row;
	}
	while ($row = $db->sql_fetch_assoc($result2)) {
		$display_list[] = $row;
	}
	if (count($display_list)) {
		$revert = false;
	}
}
// var_dump($display_list);
// die();

$sql = "select count(a.id) as num from " .  VAC_PREFIX . "_vaccine a inner join " .  VAC_PREFIX . "_pet b on a.petid = b.id inner join " .  VAC_PREFIX . "_customer c on b.customerid = c.id inner join " .  VAC_PREFIX . "_doctor d on a.doctorid = d.id inner join(select * from " . VAC_PREFIX . "_disease union (select 0 as id, 'Siêu Âm' as name from DUAL)) dd on a.diseaseid = dd.id $where";
$result = $db->sql_query($sql);
$row = $db->sql_fetch_assoc($result);

$num = $row["num"];
$url = $link . $op . "&sort=$sort&filter=$filter";
if(!empty($keyword)) {
	$url .= "&key=$keyword";
}

// echo "$url, $num, $filter, $page";die();

$nav = nv_generate_page_shop($url, $num, $filter, $page);
// var_dump($nav);
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
	global $link;
	$xtpl = new XTemplate("vaccine-list.tpl", $path);
	$xtpl->assign("lang", $lang_module);	

	// echo $path; die();
	$stt = $index;
	foreach ($list as $key => $row) {
		// echo $row["calltime"]. ", ";
		// var_dump($row); die();
		$xtpl->assign("stt", $stt);
		$xtpl->assign("id", $row["id"]);
		$xtpl->assign("customer", $row["customer"]);
		$xtpl->assign("petname", $row["petname"]);
		$xtpl->assign("pet_link", $link . "patient&petid=" . $row["petid"]);
		$xtpl->assign("customer_link", $link . "customer&customerid=" . $row["customerid"]);
		$xtpl->assign("phone", $row["phone"]);
		$xtpl->assign("doctor", $row["doctor"]);
		$xtpl->assign("disease", $row["disease"]);
		$xtpl->assign("cometime", date("d/m/Y", $row["cometime"]));
		$xtpl->assign("calltime", date("d/m/Y", $row["calltime"]));
		// $xtpl->assign("calltime2", $row["calltime"]);
		$xtpl->assign("nav_link", $nav);
		// $xtpl->assign("delete_link", "");

		$xtpl->parse("main.row");
		$stt ++;
	}

	$xtpl->parse("main");
	return $xtpl->text("main");
}
?>