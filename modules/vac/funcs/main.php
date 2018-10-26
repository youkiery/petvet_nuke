<?php
/**
* @Project NUKEVIET-MUSIC
* @Author Phan Tan Dung
* @Copyright (C) 2011
* @Createdate 26/01/2011 10:26 AM
*/

if ( ! defined( 'NV_IS_MOD_VAC' ) ) die( 'Stop!!!' );

$action = $nv_Request->get_string('action', 'post', '');
$ret = array("status" => 0, "data" => array());
if (!empty($action)) {
	switch ($action) {
		case 'getcustomer':
			$customer = $nv_Request->get_string('customer', 'post', '');
			$phone = $nv_Request->get_string('phone', 'post', '');

			if (!empty($customer)) {
				$sql = "select * from `" . $db_config['prefix'] . "_" . $module_data . "_customers` where customer like '%$customer%'";
			} else {
				$sql = "select * from `" . $db_config['prefix'] . "_" . $module_data . "_customers` where phone like '%$phone%'";
			}

			$result = $db->sql_query($sql);
			while ($row = $db->sql_fetch_assoc($result)) {
				$ret["data"][] = $row;
				$ret["status"] = 2;
			}
			echo json_encode($ret);
		break;
		case 'getpet':
			$customerid = $nv_Request->get_string('customerid', 'post', '');
			$sql = "select * from `" . $db_config['prefix'] . "_" . $module_data . "_pets` where customerid = $customerid";

			$result = $db->sql_query($sql);
			while ($row = $db->sql_fetch_assoc($result)) {
				$ret["data"][] = $row;
				$ret["status"] = 2;
			}
			echo json_encode($ret);
		break;
		case 'addcustomer':
			$customer = $nv_Request->get_string('customer', 'post', '');
			$phone = $nv_Request->get_string('phone', 'post', '');
			$address = $nv_Request->get_string('address', 'post', '');

			if (!(empty($customer) || empty($phone))) {
				$sql = "select * from `" . $db_config['prefix'] . "_" . $module_data . "_customers` where phone = '$phone'";
				$result = $db->sql_query($sql);
				if(!$db->sql_numrows($result)) {
					$sql = "select * from `" . $db_config['prefix'] . "_" . $module_data . "_customers` where customer = '$customer'";
					$result = $db->sql_query($sql);
					if(!$db->sql_numrows($result)) {
						$sql = "insert into `" . $db_config['prefix'] . "_" . $module_data . "_customers` (customer, phone, address) values ('$customer', $phone, '$address');";
						if ($id = $db->sql_query_insert_id($sql)) {
							$ret["status"] = 2;	
							$ret["data"][] = array("id" => $id);
						}
					}
					else {
						$ret["status"] = 3;
					}
				}
				else {
					$ret["status"] = 1;	
				}
			}
			
			echo json_encode($ret);
		break;
		case 'addpet':
			$customerid = $nv_Request->get_string('customerid', 'post', '');
			$petname = $nv_Request->get_string('petname', 'post', '');

			if (!(empty($customerid) || empty($petname))) {
				$sql = "select * from `" . $db_config['prefix'] . "_" . $module_data . "_pets` where petname = '$petname' and customerid = $customerid";
				$result = $db->sql_query($sql);
				if(!$db->sql_numrows($result)) {	
					$sql = "insert into `" . $db_config['prefix'] . "_" . $module_data . "_pets` (petname, customerid) values ('$petname', $customerid);";
					if ($id = $db->sql_query_insert_id($sql)) {
						$ret["status"] = 2;	
						$ret["data"][] = array("id" => $id);
					}
				} else {
					$ret["status"] = 1;	
				}
			}

			echo json_encode($ret);
		break;
		case 'insertvac':
			$petid = $nv_Request->get_string('petid', 'post', '');
			$diseaseid = $nv_Request->get_string('diseaseid', 'post', '');
			$cometime = $nv_Request->get_string('cometime', 'post', '');
			$calltime = $nv_Request->get_string('calltime', 'post', '');
			$note = $nv_Request->get_string('note', 'post', '');

			if (!(empty($petid) || empty($diseaseid) || empty($cometime) || empty($calltime))) {
				$sql = "select * from `" . $db_config['prefix'] . "_" . $module_data . "_customers` where petname = '$petname' and customerid = $customerid";
				$result = $db->sql_query($sql);
				if(!$db->sql_numrows($result)) {	
					$cometime = strtotime($cometime);
					$calltime = strtotime($calltime);
					$sql = "insert into `" . $db_config['prefix'] . "_" . $module_data . "_$diseaseid` (petid, cometime, calltime, note) values ($petid, $cometime, $calltime, '$note');";
					if ($id = $db->sql_query_insert_id($sql)) {
						$ret["status"] = 2;	
						$ret["data"][] = array("id" => $id);
					}
				}
			}

			echo json_encode($ret);
		break;
	}
	die();
}

$page_default = true;
if (!empty($array_op[0])) {
	$page = $array_op[0];
	$page_allowed = array(
		"list"
	);
	if(in_array($page, $page_allowed)) {
		$page_default = false;
		require_once ( NV_ROOTDIR . "/modules/" . $module_file . "/funcs/$page.php" );
	}
}
if ($page_default) {
	$page_title = $module_info['custom_title'];
	$key_words = $module_info['keywords'];

	$xtpl = new XTemplate("main.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
	$xtpl->assign("lang", $lang_module);
	$xtpl->assign("now", date("Y-m-d", NV_CURRENTTIME));
	// note: nexttime take from config
	$xtpl->assign("calltime", date("Y-m-d", NV_CURRENTTIME + 14 * 24 * 60 * 60));

	$diseases = getDiseaseList();
	foreach ($diseases as $key => $value) {
		$xtpl->assign("disease_id", $value["id"]);		
		$xtpl->assign("disease_name", $value["disease"]);	
		$xtpl->parse("main.option");	
	}
}

$xtpl->parse("main");
$contents = $xtpl->text("main");

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );
?>
