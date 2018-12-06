<?php
/**
 * @Project NUKEVIET-MUSIC
 * @Author Phan Tan Dung
 * @Copyright (C) 2011
 * @Createdate 26/01/2011 10:26 AM
 */
if (!defined('NV_IS_MOD_VAC')) die('Stop!!!');
$id = $nv_Request->get_string('id', 'post', '');
$value = $nv_Request->get_string('value', 'post', '');
$act = $nv_Request->get_string('act', 'post', '');
$ret = array("status" => 0, "data" => "");

if(!(empty($act) || empty($value) || empty($id))) {
	$mod = 0;
	if ($act == "up") {
		$mod = 1;
	} else {
		$mod = -1;
	}
	if (in_array($value, $lang_module["confirm_value"])) {
		$confirmid = array_search($value, $lang_module["confirm_value"]);
		$confirmid += $mod;
		if (!empty($lang_module["confirm_value"][$confirmid])) {
			$sql = "update `" . VAC_PREFIX . "_sieuam` set trangthai = $confirmid where id = $id";
			$result = $db->sql_query($sql);
			if ($result) {
				$ret["status"] = 1;
				$ret["data"]["value"] = $lang_module["confirm_value"][$confirmid];
				switch ($confirmid) {
					case '1':
						$color = "orange";
						break;
					case '2':
						$color = "green";
						break;
					default:
						$color = "red";
				}
				$ret["data"]["color"] = $color;
			}
		}
	}
}

echo json_encode($ret);
die();
?>
