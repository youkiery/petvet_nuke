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
		if (!empty($lang_module["confirm_value"][$confirmid])) {
			$sql = "update " . VAC_PREFIX . "_$diseaseid set status = $confirmid where id = $vacid";
			$result = $db->sql_query($sql);
			if ($result) {
		    $sql = "select * from " . VAC_PREFIX . "_$diseaseid where id = $vacid";
		    $result = $db->sql_query($sql);
				$row = $db->sql_fetch_assoc($result);
		    if (empty($row["recall"]) || $row["recall"] == "0") $ret["data"]["recall"] = 0;
				else $ret["data"]["recall"] = 1;
				// $ret["data"]["recall"] = $row["recall"];
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
