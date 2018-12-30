<?php
/**
 * @Project NUKEVIET-MUSIC
 * @Author Phan Tan Dung
 * @Copyright (C) 2011
 * @Createdate 26/01/2011 10:26 AM
 */
if (!defined('NV_IS_MOD_QUANLY')) die('Stop!!!');
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
	if (in_array($value, $lang_module["confirm_value2"])) {
		$confirmid = array_search($value, $lang_module["confirm_value2"]);
		$confirmid += $mod;
		if (!empty($lang_module["confirm_value2"][$confirmid])) {
			$sql = "update `" . VAC_PREFIX . "_usg` set status = $confirmid where id = $id";
			$result = $db->sql_query($sql);
			if ($result) {
				$ret["status"] = 1;
				$ret["data"]["value"] = $lang_module["confirm_value2"][$confirmid];
				$birth = 0;
				switch ($confirmid) {
					case '1':
						$color = "darkorange";
						break;
					case '2':
						$color = "dodgerblue";
						$ret["data"]["birth"] = $row["expectbirth"];
					case '3':
						if (empty($color)) {
							$color = "green";
							$ret["data"]["birth"] = $row["birth"];
						}
						$sql = "select * from " . VAC_PREFIX . "_usg where id = $id";
						$query = $db->sql_query($sql);
						$row = $db->sql_fetch_assoc($query);
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
