<?php
/**
* @Project NUKEVIET-MUSIC
* @Phan Tan Dung (phantandung92@gmail.com)
* @Copyright (C) 2011
* @Createdate 26-01-2011 14:43
*/

if (!defined('NV_IS_VAC_ADMIN')) die('Stop!!!');
$page_title = $lang_module["doctor_title"];
$action = $nv_Request->get_string('action', 'post', "");

if (!empty($action)) {
	$ret = array("status" => 0, "data" => array());
	switch ($action) {
		case 'doctoradd':
			$doctor = $nv_Request->get_string('doctor', 'post', "");
			if (!empty($doctor)) {
				$sql = "select * from " . $db_config['prefix'] . "_" . $module_name . "_doctor where doctor = '$doctor'";
				$result = $db->sql_query($sql);
				if (!$db->sql_numrows($result)) {
					$sql = "insert into " . $db_config['prefix'] . "_" . $module_name . "_doctor (doctor) values('$doctor')";
					if ($db->sql_query($sql)) {
						$ret["status"] = 1;
						$ret["data"] = doctorlist(NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file, $lang_module);
					}
					else {
						$ret["status"] = 2;
					}
				} else $ret["status"] = 3;
			}
		break;
		case 'doctoredit':
			$doctor = $nv_Request->get_string('doctor', 'post', "");
			$id = $nv_Request->get_string('id', 'post', "");
			if (!empty($doctor) && !empty($id)) {
				$sql = "select * from " . $db_config['prefix'] . "_" . $module_name . "_doctor where doctor = '$doctor'";
				$result = $db->sql_query($sql);
				if (!$db->sql_numrows($result)) {
					$sql = "update " . $db_config['prefix'] . "_" . $module_name . "_doctor set doctor = '$doctor' where id = $id";
					if ($db->sql_query($sql)) {
						$ret["status"] = 1;
						$ret["data"] = doctorlist(NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file, $lang_module);
					}
					else {
						$ret["status"] = 2;
					}
				} else $ret["status"] = 3;
			}
		break;
		case 'doctordel':
			$id = $nv_Request->get_string('id', 'post', "");
			if (!empty($id)) {
				$sql = "select * from " . $db_config['prefix'] . "_" . $module_name . "_doctor where id = $id";
				$result = $db->sql_query($sql);
				if ($db->sql_numrows($result)) {
					$sql = "delete from " . $db_config['prefix'] . "_" . $module_name . "_doctor where id = '$id'";
					if ($db->sql_query($sql)) {
						$ret["status"] = 1;
						$ret["data"] = doctorlist(NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file, $lang_module);
					}
					else {
						$ret["status"] = 2;
					}
				}
			}
		break;
	}

	echo json_encode($ret);
	die();
}

$xtpl = new XTemplate("doctor.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
$xtpl->assign("lang", $lang_module);

$xtpl->assign("list", doctorlist(NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file, $lang_module));


$xtpl->parse("main");
$contents = $xtpl->text("main");

include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");

