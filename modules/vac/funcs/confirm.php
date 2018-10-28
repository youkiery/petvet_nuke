<?php
$value = $nv_Request->get_string('value', 'get', '');
$vacid = $nv_Request->get_string('vacid', 'get', '');
$diseaseid = $nv_Request->get_string('diseaseid', 'get', '');
$act = $nv_Request->get_string('act', 'get', '');
$ret = array("status" => 0, "data" => "");

if(!(empty($act) || empty($value) || empty($vacid) || empty($diseaseid))) {
	$mod = 0;
	if ($act == "up") {
		$mod = 1;
	} else {
		$mod = -1;
	}
	if (in_array($value, $lang_module["confirm_value"])) {
		$confirmid = array_search($value, $lang_module["confirm_value"]);
		$confirmid += $mod;
		if(!($confirmid > count($lang_module["confirm_value"]) || $confirmid < 0)) {
			$sql = "update vng_vac_$diseaseid set status = $confirmid where id = $vacid";
			$result = $db->sql_query($sql);
			if($result) {
				$ret["status"] = 1;
				$ret["data"] = $lang_module["confirm_value"][$confirmid];
			}
			else {
				$ret["status"] = 2;
			}
		}
	} else {
		$ret["status"] = 0;
	}
}

echo json_encode($ret);
die();
?>
