<?php
/**
* @Project NUKEVIET-MUSIC
* @Phan Tan Dung (phantandung92@gmail.com)
* @Copyright (C) 2011
* @Createdate 26-01-2011 14:43
*/
if (!defined('NV_IS_VAC_ADMIN')) die('Stop!!!');
$link = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=";

$petid = $nv_Request->get_string('petid', 'get', "");
$action = $nv_Request->get_string('action', 'post', "");
if($action) {
	switch ($action) {
		case "addvac":
			$petid = $nv_Request->get_string('petid', 'post', '');
			$diseaseid = $nv_Request->get_string('diseaseid', 'post', '');
			$cometime = $nv_Request->get_string('cometime', 'post', '');
			$calltime = $nv_Request->get_string('calltime', 'post', '');
			if(!(empty($petid) || empty($diseaseid) || empty($cometime) || empty($calltime))) {
				$cometime = strtotime($cometime);
				$calltime = strtotime($calltime);
				$sql2 = "insert into `" . $db_config['prefix'] . "_" . $module_data . "_$diseaseid` (petid, cometime, calltime, confirm) values('$petid', $cometime, $calltime, false);";
				$id = $db->sql_query_insert_id($sql2);

				if($id){
					$row = array("id" => $id, "cometime" => date("d/m/Y", $cometime), "calltime" => date("d/m/Y", $calltime), "confirm" => $lang_module["no"]);
					echo json_encode($row);
				}
			}
		break;
	// 	case "remove":
	// 		$id = $nv_Request->get_string('id', 'post', '');
	// 		if(!empty($id)) {
	// 			$sql = "delete from `" . $db_config['prefix'] . "_" . $module_data . "_customers` where id = $id";
	// 			if($db->sql_query($sql)) echo 1;
	// 		}
	// 	break;
	// 	case "update":
	// 		$id = $nv_Request->get_string('id', 'post', '');
	// 		$name = $nv_Request -> get_string('customer', 'post', '');
	// 		$phone = $nv_Request -> get_string('phone', 'post', '');
	// 		$note = $nv_Request -> get_string('note', 'post', '');
	// 		if(!(empty($id) || empty($name) || empty($phone))) {
	// 			$sql = "update `" . $db_config['prefix'] . "_" . $module_data . "_customers` set name = '$name', phone = '$phone', note = '$note' where id = $id";
	// 			if($db->sql_query($sql)) {
	// 				$row = array("id" => $id, "name" => $name, "phone" => $phone, "note" => $note);
	// 				echo json_encode($row);
	// 			}
	// 		}
	// 	break;
	} 

	die();
}

if (!empty($petid)) {
	$page_title = $lang_module["patient_title1"];
	$patient = getPatientDetail($petid);
	$xtpl = new XTemplate("patient1.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
	$xtpl->assign("lang", $lang_module);
	$xtpl->assign("id", $petid);
	$xtpl->assign("name", $patient["petname"]);
	$xtpl->assign("customer", $patient["customer"]);
	$xtpl->assign("phone", $patient["phone"]);
	$xtpl->assign("time", date("Y-m-j"));
	$xtpl->assign("time2", date("Y-m-j", (NV_CURRENTTIME + 30 * 24 * 60 * 60)));
	$diseases = getDiseaseList();

	foreach ($diseases as $key => $value) {
		$xtpl->assign("diseaseid", $value["id"]);
		$xtpl->assign("diseasename", $value["disease"]);
		$xtpl->parse("main.option");
	}

	foreach ($patient["data"] as $key => $patient_data) {
		$cometime = date("d/m/Y", $patient_data["cometime"]);
		$calltime = date("d/m/Y", $patient_data["calltime"]);
		if ($patient_data["confirm"]) $confirm = $lang_module["yes"];
		else $confirm = $lang_module["no"];
		$xtpl->assign("index", $patient_data["id"]);
		$xtpl->assign("disease", $diseases[$patient_data["disease"] - 1]["disease"]);
		$xtpl->assign("cometime", $cometime);
		$xtpl->assign("calltime", $calltime);
		$xtpl->assign("confirm", $confirm);
		$xtpl->parse("main.vac");
	}
}
else {
	$page_title = $lang_module["patient_title3"];
	$patients = getPatientsList();
	$xtpl = new XTemplate("patient3.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
	$xtpl->assign("lang", $lang_module);
	$index = 1;
	foreach ($patients as $key => $patient_data) {
		$xtpl->assign("index", $index);
		$xtpl->assign("id", $patient_data["id"]);
		$xtpl->assign("petname", $patient_data["petname"]);
		$xtpl->assign("detail_link", $link  . "patient&petid=" . $patient_data["id"]);
		$xtpl->assign("detail_link2", $link  . "customer&customerid=" . $patient_data["customerid"]);
		$xtpl->assign("customer", $patient_data["customer"]);
		$xtpl->assign("phone", $patient_data["phone"]);
		$xtpl->parse("main.patient");
		$index ++;
	}
}

$xtpl->parse("main");

$contents = $xtpl->text("main");

include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
?>
