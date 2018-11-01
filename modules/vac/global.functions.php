<?php

/**
* @Project NUKEVIET-MUSIC
* @Author Phan Tan Dung (phantandung92@gmail.com)
* @copyright 2011
* @createdate 26/01/2011 09:17 AM
*/

if (!defined('NV_MAINFILE')) die('Stop!!!');
define('NV_NEXTMONTH', 30 * 24 * 60 * 60);
define('NV_NEXTWEEK', 7 * 24 * 60 * 60);

function checkNewDisease($id) {
	global $db, $db_config, $module_name;

	$sql = array();
	$sql[] = "CREATE TABLE IF NOT EXISTS " . $db_config['prefix'] . "_" . $module_name . "_$id ( `id` int(11) NOT NULL, `petid` int(11) NOT NULL, `cometime` int(11) NOT NULL, `calltime` int(11) NOT NULL, `status` tinyint(4) NOT NULL, `note` text NOT NULL ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$sql[] = "ALTER TABLE `" . $db_config['prefix'] . "_" . $module_name . "_$id` ADD PRIMARY KEY (`id`);";
	$sql[] = "ALTER TABLE `" . $db_config['prefix'] . "_" . $module_name . "_$id` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";
	$check = true;
	foreach ($sql as $value) {
		if(!$db->sql_query($value)) $check = false;
	}
	return $check;
}

function getDiseaseList() {
	global $db, $db_config, $module_name;
	$sql = "select * from " . $db_config['prefix'] . "_" . $module_name . "_diseases";
	$result = $db->sql_query($sql);
	$diseases = array();
	while($row = $db->sql_fetch_assoc($result)) {
		$diseases[] = $row;
	}
	return $diseases;
}

function getCustomerList() {
	global $db, $db_config, $module_name;
	$sql = "select * from " . $db_config['prefix'] . "_" . $module_name . "_customers";
	$result = $db->sql_query($sql);
	$customers = array();
	while($row = $db->sql_fetch_assoc($result)) {
		$customers[] = $row;
	}
	return $customers;
}

function getVaccineTable($id, $time) {
	// next a week
	global $db, $db_config, $module_name, $global_config;
	$next_time = $time + $global_config["filter_time"];

	$sql = "select a.id, b.id as petid, b.petname, c.id as customerid, c.customer, c.phone as phone, cometime, calltime, status from " . $db_config['prefix'] . "_" . $module_name . "_" . $id . " a inner join " . $db_config['prefix'] . "_" . $module_name . "_pets b on calltime between " . $time . " and " . $next_time . " and a.petid = b.id inner join " . $db_config['prefix'] . "_" . $module_name . "_customers c on b.customerid = c.id";
	$result = $db->sql_query($sql);
	$vaccines = array();
	while($row = $db->sql_fetch_assoc($result)) {
		$vaccines[] = $row;
	}
	return $vaccines;
}

function filter($path, $lang, $fromtime, $amount_time, $sort) {
	$xtpl = new XTemplate("list-1.tpl", $path);
	$xtpl->assign("lang", $lang);
	
	$fromtime = strtotime($fromtime);

	$diseases = getDiseaseList();
	foreach ($diseases as $disease) {
		$xtpl->assign("title", $disease["disease"]);
		$vaclist = filterVac($fromtime, $amount_time, $sort, $disease["id"]);
		$i = 1;
		$xtpl->assign("diseaseid", $disease["id"]);
		foreach ($vaclist as $row) {
			$xtpl->assign("index", $i);
			$xtpl->assign("petname", $row["petname"]);
			$xtpl->assign("petid", $row["petid"]);
			$xtpl->assign("vacid", $row["id"]);
			$xtpl->assign("customer", $row["customer"]);
			$xtpl->assign("phone", $row["phone"]);
			$xtpl->assign("confirm", $lang["confirm_" . $row["status"]]);
			if($row["status"] == 2 && !$row["recall"]) $xtpl->parse("disease.vac_body.recall_link");
			switch ($row["status"]) {
				case '1':
					$xtpl->assign("color", "orange");
					break;
				case '2':
					$xtpl->assign("color", "green");
					break;
				default:
					$xtpl->assign("color", "red");
					break;
			}
			$xtpl->assign("cometime", date("d/m/Y", $row["cometime"]));
			$xtpl->assign("calltime", date("d/m/Y", $row["calltime"]));
			$i++;
			$xtpl->parse("disease.vac_body");
		}
		$xtpl->parse("disease");
	}
	return $xtpl->text("disease");
}

function filterVac($fromtime, $amount_time, $sort, $diseaseid) {
	global $db, $db_config, $module_name;
	$endtime = $fromtime + $amount_time;
	$fromtime -= $amount_time;

	$order = '';
	switch ($sort) {
		case '1':
		$order = 'order by cometime desc';
		break;
		case '2':
		$order = 'order by cometime asc';
		break;
		case '3':
		$order = 'order by calltime desc';
		break;
		case '4':
		$order = 'order by calltime asc';
		break;
	}
	
	$sql = "select a.id, b.id as petid, b.petname, c.id as customerid, c.customer, c.phone as phone, cometime, calltime, status, doctorid, recall from " . $db_config['prefix'] . "_" . $module_name . "_" . $diseaseid . " a inner join " . $db_config['prefix'] . "_" . $module_name . "_pets b on calltime between " . $fromtime . " and " . $endtime . " and a.petid = b.id inner join " . $db_config['prefix'] . "_" . $module_name . "_customers c on b.customerid = c.id " . $order;
	// var_dump($vaclist); die();
	$result = $db->sql_query($sql);
	$ret = array();
	while ($row = $db->sql_fetch_assoc($result)) {
		$ret[] = $row;
	}
	return $ret;
}

function getvaccustomer($customer, $fromtime, $amount_time, $sort, $diseaseid) {
	global $db, $db_config, $module_name;
	$fromtime = strtotime($fromtime);
	$endtime = $fromtime + $amount_time;

	$order = '';
	switch ($sort) {
		case '1':
			$order = 'order by cometime asc';
		break;
		case '2':
			$order = 'order by cometime desc';
		break;
		case '3':
			$order = 'order by calltime asc';
		break;
		case '4':
			$order = 'order by calltime desc';
		break;
	}

	$sql = "select a.id, b.id as petid, b.petname, c.id as customerid, c.customer, c.phone as phone, cometime, calltime, status from " . $db_config['prefix'] . "_" . $module_name . "_" . $diseaseid . " a inner join " . $db_config['prefix'] . "_" . $module_name . "_pets b on calltime between " . $fromtime . " and " . $endtime . " and a.petid = b.id inner join " . $db_config['prefix'] . "_" . $module_name . "_customers c on b.customerid = c.id where c.customer like '%$customer%' or c.phone like '%$customer%' " . $order;
	$result = $db->sql_query($sql);
	$ret = array();
	while ($row = $db->sql_fetch_assoc($result)) {
		$ret[] = $row;
	}
	return $ret;
}

function getcustomer($customer, $phone) {
	global $db, $db_config, $module_name;
	if (!empty($customer)) {
		$sql = "select * from `" . $db_config['prefix'] . "_" . $module_name . "_customers` where customer like '%$customer%'";
	} else {
		$sql = "select * from `" . $db_config['prefix'] . "_" . $module_name . "_customers` where phone like '%$phone%'";
	}

	$result = $db->sql_query($sql);
	$ret = array();
	while ($row = $db->sql_fetch_assoc($result)) {
		$ret[] = $row;
	}
	return $ret;
}

function getPatientsList() {
	global $db, $db_config, $module_name;
	$sql = "select b.id, b.petname, c.id as customerid, c.customer, c.phone as phone from " . $db_config['prefix'] . "_" . $module_name . "_pets b inner join " . $db_config['prefix'] . "_" . $module_name . "_customers c on b.customerid = c.id";
	$result = $db->sql_query($sql);
	$patients = array();
	while($row = $db->sql_fetch_assoc($result)) {
		$patients[] = $row;
	}
	return $patients;
}

function getPatientsList2($customerid) {
	global $db, $db_config, $module_name;
	$sql = "select * from " . $db_config['prefix'] . "_" . $module_name . "_customers where id = $customerid";
	$result = $db->sql_query($sql);
	$patients = $db->sql_fetch_assoc($result);
	$patients["data"] = array();
	$sql = "select petname, id from " . $db_config['prefix'] . "_" . $module_name . "_pets where customerid = $customerid";
	$result = $db->sql_query($sql);
	$diseases = getDiseaseList();
	while($row = $db->sql_fetch_assoc($result)) {
		$petid = $row["id"];
		$union = array();
		foreach ($diseases as $key => $value) {
			$key ++;
			$union[] = "(select *, $key as disease from vng_vac_$key where petid = $petid order by calltime desc LIMIT 1)";
		}
		// $sql = "SELECT * from	( (select *, 1 as disease from vng_vac_1 LIMIT 1) UNION  (select *, 2 as disease  from vng_vac_2 LIMIT 1) UNION  (select *, 3 as disease from vng_vac_3 LIMIT 1) ) as a limit 1";
		$sql = "SELECT * from	( " . implode(" union ", $union) . ") as a limit 1";
		// die($sql);
		$result2 = $db->sql_query($sql);
		$row2 = $db->sql_fetch_assoc($result2);
		if(!empty($row2)) {
			$patients["data"][] = array("petid" => $row["id"], "petname" => $row["petname"], "lastcome" => $row2["cometime"], "lastname" => $diseases[$row2["disease"] - 1]);
		}
		else {
			$patients["data"][] = array("petid" => $row["id"], "petname" => $row["petname"], "lastcome" => "", "lastname" => "");
		}
	}
	return $patients;
}

function getPatientDetail($petid) {
	global $db, $db_config, $module_name;
	$sql = "select b.petname, c.customer, c.phone as phone from " . $db_config['prefix'] . "_" . $module_name . "_pets b inner join " . $db_config['prefix'] . "_" . $module_name . "_customers c on b.id = $petid and b.customerid = c.id";
	$result = $db->sql_query($sql);
	$patients = $db->sql_fetch_assoc($result);
	$patients["data"] = array();
	
	$diseases = getDiseaseList();
	$union = array();
	foreach ($diseases as $key => $value) {
		$key ++;
		$union[] = "(select *, $key as disease from vng_vac_$key where petid = $petid)";
	}
	$sql = "SELECT * from	( " . implode(" union ", $union) . ") as a";
	$result = $db->sql_query($sql);
	while($row = $db->sql_fetch_assoc($result)) {
		$patients["data"][] = $row;
	}
	return $patients;
}

?>
