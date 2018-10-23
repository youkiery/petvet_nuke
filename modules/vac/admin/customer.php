<?php
/**
* @Project NUKEVIET-MUSIC
* @Phan Tan Dung (phantandung92@gmail.com)
* @Copyright (C) 2011
* @Createdate 26-01-2011 14:43
*/

if (!defined('NV_IS_VAC_ADMIN')) die('Stop!!!');
$link = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=";
$customers = getCustomerList();

$action = $nv_Request->get_string('action', 'post', "");
if($action) {
	switch ($action) {
		case "add":
			$name = $nv_Request -> get_string('customer', 'post', '');
			$phone = $nv_Request -> get_string('phone', 'post', '');
			$note = $nv_Request -> get_string('note', 'post', '');
			if(!(empty($name) || empty($phone))) {
				$sql2 .= "insert into `" . $db_config['prefix'] . "_" . $module_data . "_customers` (name, phone, note) values('$name', '$phone', '$note');";
				
				$id = $db->sql_query_insert_id($sql2);
				if($id){
					$row = array("id" => $id, "name" => $name, "phone" => $phone, "note" => $note);
					echo json_encode($row);
				}
			}
		break;
		case "remove":
			$id = $nv_Request->get_string('id', 'post', '');
			if(!empty($id)) {
				$sql = "delete from `" . $db_config['prefix'] . "_" . $module_data . "_customers` where id = $id";
				if($db->sql_query($sql)) echo 1;
			}
		break;
		case "update":
			$id = $nv_Request->get_string('id', 'post', '');
			$name = $nv_Request -> get_string('customer', 'post', '');
			$phone = $nv_Request -> get_string('phone', 'post', '');
			$note = $nv_Request -> get_string('note', 'post', '');
			if(!(empty($id) || empty($name) || empty($phone))) {
				$sql = "update `" . $db_config['prefix'] . "_" . $module_data . "_customers` set name = '$name', phone = '$phone', note = '$note' where id = $id";
				if($db->sql_query($sql)) {
					$row = array("id" => $id, "name" => $name, "phone" => $phone, "note" => $note);
					echo json_encode($row);
				}
			}
		break;
		case "addpet":
			$petname = $nv_Request -> get_string('petname', 'post', '');
			$customerid = $nv_Request -> get_string('id', 'post', '');
			if(!(empty($petname) || empty($customerid))) {
				$sql2 .= "insert into `" . $db_config['prefix'] . "_" . $module_data . "_pets` (customerid, name) values('$customerid', '$petname');";
				
				$id = $db->sql_query_insert_id($sql2);
				if($id){
					$row = array("id" => $id, "petname" => $petname);
					echo json_encode($row);
				}
			}
		break;
		case "removepet":
			$id = $nv_Request->get_string('id', 'post', '');
			if(!empty($id)) {
				$sql = "delete from `" . $db_config['prefix'] . "_" . $module_data . "_pets` where id = $id";
				if($db->sql_query($sql)) echo 1;
			}
		break;
		case "updatepet":
			$id = $nv_Request->get_string('id', 'post', '');
			$petname = $nv_Request -> get_string('petname', 'post', '');
			if(!(empty($id) || empty($petname))) {
				$sql = "update `" . $db_config['prefix'] . "_" . $module_data . "_pets` set name = '$petname' where id = $id";
				if($db->sql_query($sql)) {
					$row = array("id" => $id, "name" => $petname);
					echo json_encode($row);
				}
			}
		break;
	} 

	die();
}


$customerid = $nv_Request->get_string('customerid', 'get', "");
if (!empty($customerid)) {
	$page_title = $lang_module["patient_title2"];
	$patients = getPatientsList2($customerid);
	$xtpl = new XTemplate("customer2.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
	$xtpl->assign("lang", $lang_module);
	$xtpl->assign("name", $patients["name"]);
	$xtpl->assign("customerid", $customerid);
	$xtpl->assign("phone", $patients["phone"]);
	$xtpl->assign("note", $patients["note"]);
	
	foreach ($patients["data"] as $key => $patient_data) {
		if(!empty($patient_data["lasttime"])) $lasttime = date("d/m/Y H:i", $patient_data["lasttime"]);
		else $lasttime = "";
		$xtpl->assign("id", $patient_data["petid"]);
		$xtpl->assign("detail_link", $link . "patient&petid=" . $patient_data["petid"]);
		$xtpl->assign("petname", $patient_data["petname"]);
		$xtpl->assign("lasttime", $lasttime);
		$xtpl->assign("lastname", $patient_data["lastname"]);
		$xtpl->parse("main.vac");
	}
}
else {
	$page_title = $lang_module["customer_title"];
	$xtpl = new XTemplate("customer.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
	$xtpl->assign("lang", $lang_module);
	
	foreach ($customers as $customer_index => $customer_data) {
		$xtpl->assign("index", $customer_data["id"]);
		$xtpl->assign("name", $customer_data["name"]);
		$xtpl->assign("detail_link", $link . "customer&customerid=" . $customer_data["id"]);
		$xtpl->assign("phone", $customer_data["phone"]);
		$xtpl->assign("note", $customer_data["note"]);
		$xtpl->parse("main.customer");
	}
}

$xtpl->parse("main");

$contents = $xtpl->text("main");

include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
?>
