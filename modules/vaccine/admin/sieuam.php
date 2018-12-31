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
$order = array("order by customer asc", "order by customer desc", "order by cometime", "order by calltime");
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
$xtpl->assign("nv", $module_name);
$xtpl->assign("op", "sieuam");

$today = date("Y-m-d", NV_CURRENTTIME);
$dusinh = $module_config[$module_name]["expert_time"];
if (empty($dusinh)) {
	$dusinh = 45 * 24 * 60 * 60;
}

if (empty($page)) {
	$page = 1;
}

$xtpl->assign("now", $today);
$xtpl->assign("dusinh", date("Y-m-d", strtotime($today) + $dusinh));

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

if ($action) {
	$ret = array("status" => 0, "data" => array());
	switch ($action) {
		case 'xoasieuam':
			$id = $nv_Request->get_string('id', 'post', "");
			if (!empty($id)) {
				$sql = "delete from " .  VAC_PREFIX . "_usg where id = $id";
				// echo json_encode($ret);
				// die();
				$result = $db->sql_query($sql);
			
				if ($result) {
					$check = true;
				}
				echo 1;
			}
		break;
		case 'usg_info':
			$id = $nv_Request->get_string('id', 'post', "");
			if (!empty($id)) {
				$sql = "select * from " .  VAC_PREFIX . "_usg where id = $id";
				$result = $db->sql_query($sql);

				if ($result) {
					$row = $db->sql_fetch_assoc($result);
					$sql = "select * from " .  VAC_PREFIX . "_pet where id = $row[petid]";
					$result = $db->sql_query($sql);
					$row2 = $db->sql_fetch_assoc($result);
					$ret["status"] = 1;
					$recall = 0;
					if ($row["recall"]) {
						$recall = date("Y-m-d", $row["recall"]);
					}
					$vaccine = "";
					foreach ($lang_module["confirm_value"] as $key => $value) {
						$select = "";
						if ($row["vaccine"] == $key) {
							$select = "selected";
						}
						$vaccine .= "<option value='$key' $select>$value</option>";
					}
					$ret["data"] = array("calltime" => date("Y-m-d", $row["calltime"]), "cometime" => date("Y-m-d", $row["cometime"]), "doctorid" => $row["doctorid"], "note" => $row["note"], "image" => $row["image"], "customerid" => $row2["customerid"], "petid" => $row["petid"], "birth" => $row["birth"], "exbirth" => $row["expectbirth"], "recall" => $recall, "vaccine" => $vaccine, "vacid" => $row["vaccine"]);
				}
				echo json_encode($ret);
			}
		break;
		case 'update_usg':
			$id = $nv_Request->get_string('id', 'post', "");
			$cometime = $nv_Request->get_string('cometime', 'post', "");
			$calltime = $nv_Request->get_string('calltime', 'post', "");
			$doctorid = $nv_Request->get_string('doctorid', 'post', "");
			$birth = $nv_Request->get_string('birth', 'post', "");
			$exbirth = $nv_Request->get_string('exbirth', 'post', "");
			$recall = $nv_Request->get_string('recall', 'post', "");
			$vaccine = $nv_Request->get_int('vaccine', 'post', 0);
			$note = $nv_Request->get_string('note', 'post', "");
			$image = $nv_Request->get_string('image', 'post', "");
			$customer = $nv_Request->get_string('customer', 'post', "");
			if (!(empty($id) || empty($cometime) || empty($calltime) || empty($doctorid))) {
				$cometime = strtotime($cometime);
				$calltime = strtotime($calltime);
				$sql = "select * from `" . VAC_PREFIX . "_usg` where id = $id";
				$query = $db->sql_query($sql);
				$usg = $db->sql_fetch_assoc($query);
				// var_dump($usg);
				if ($usg["childid"] == 0) {
					$birth = 0;
				} 
				if ($usg["vaccine"] < 4 && $vaccine == 0) {
					$exbirth = 0;
				}
				if ($usg["vaccine"] == 4) {
					$vaccine = 4;
				}
				if ($vaccine == 4) {
					if ($recall == 0) {
						$recall = strtotime(date("Y-m-d"));
					}
					else {
						$recall = strtotime($recall);
					}
					if ($usg["childid"] == 0 && $customer > 0) {
						$sql = "insert into " . VAC_PREFIX . "_pet (name, customerid) values('" . date("d/m/Y", $calltime) . "', $customer)";
						$pet_id = $db->sql_query_insert_id($sql);
	
						if ($pet_id > 0) {
							$sql = "update `" . VAC_PREFIX . "_usg` set childid = $pet_id where id = $id";
							$query = $db->sql_query($sql);
						}
							
						$sql = "insert into `" . VAC_PREFIX . "_vaccine` (petid, diseaseid, cometime, calltime, status, note, recall, doctorid) values ($pet_id, 0, $calltime, $recall, 0, '', 0, $doctorid);";
						$query = $db->sql_query($sql);
					}
				}
				if ($recall == 0) {
					$recall = 0;
				}
				$sql = "update " .  VAC_PREFIX . "_usg set cometime = $cometime, calltime = $calltime, doctorid = $doctorid, note = '$note', image = '$image', birth = $birth, expectbirth = $exbirth, recall = $recall, vaccine = $vaccine where id = $id";
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
$sql = "select * from " .  VAC_PREFIX . "_doctor";
$result = $db->sql_query($sql);

while ($row = $db->sql_fetch_assoc($result)) {
	$xtpl->assign("doctor_value", $row["id"]);
	$xtpl->assign("doctor_name", $row["name"]);
	$xtpl->parse("main.doctor");
	$xtpl->parse("main.doctor3");
}

// $sql = "select * from " .  VAC_PREFIX . "_usg a inner join " .  VAC_PREFIX . "_pet b on a.petid = b.id $order[$sort]";
$revert = true;
$tpage = $page;
while ($revert) {
	$tpage --;
	if ($tpage <= 0) $revert = false;
	$from = $tpage * $filter;
	$to = $from + $filter;
	$sql = "select a.id, a.cometime, a.calltime, a.birth, a.expectbirth, a.vaccine, a.recall, b.id as petid, b.name as petname, c.id as customerid, c.name as customer, c.phone, d.name as doctor from " .  VAC_PREFIX . "_usg a inner join " .  VAC_PREFIX . "_pet b on a.petid = b.id inner join " .  VAC_PREFIX . "_customer c on b.customerid = c.id inner join " .  VAC_PREFIX . "_doctor d on a.doctorid = d.id $where $order[$sort] limit $from, $to";
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
	global $link;
	$xtpl = new XTemplate("sieuam-hang.tpl", $path);
	$xtpl->assign("lang", $lang_module);	

	// echo $path; die();
	$stt = $index;
	foreach ($list as $key => $row) {
		// var_dump($row); die();
		$xtpl->assign("stt", $stt);
		$xtpl->assign("id", $row["id"]);
		$xtpl->assign("customer", $row["customer"]);
		$xtpl->assign("petname", $row["petname"]);
		$xtpl->assign("pet_link", $link . "patient&petid=" . $row["petid"]);
		$xtpl->assign("customer_link", $link . "customer&customerid=" . $row["customerid"]);
		$xtpl->assign("phone", $row["phone"]);
		$xtpl->assign("doctor", $row["doctor"]);
		$xtpl->assign("birth", $row["birth"]);
		$xtpl->assign("exbirth", $row["expectbirth"]);
		$xtpl->assign("cometime", date("d/m/Y", $row["cometime"]));
		$xtpl->assign("calltime", date("d/m/Y", $row["calltime"]));
		$recall = $row["recall"];
		if ($recall > 0 && $row["vaccine"] > 2) {
			$xtpl->assign("recall", date("d/m/Y", $recall));
			$xtpl->assign("vacname", "");
		}
		else {
			$xtpl->assign("recall", $lang_module["norecall"]);
			$xtpl->assign("vacname", " / " . $lang_module["confirm_value"][$row["vaccine"]]);
		}
		$xtpl->assign("nav_link", $nav);
		// $xtpl->assign("delete_link", "");

		$xtpl->parse("main.row");
		$stt ++;
	}

	$xtpl->parse("main");
	return $xtpl->text("main");
}
?>