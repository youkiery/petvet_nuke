<?php

/**
* @Project NUKEVIET-MUSIC
* @Author Phan Tan Dung (phantandung92@gmail.com)
* @copyright 2011
* @createdate 26/01/2011 09:17 AM
*/

if (!defined('NV_MAINFILE')) die('Stop!!!');
define('NV_NEXTWEEK', 7 * 24 * 60 * 60);

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
	global $db, $db_config, $module_name;
	$next_week = $time + NV_NEXTWEEK;
	
	$sql = "select b.name as petname, c.name as customer, c.phone as phone from " . $db_config['prefix'] . "_" . $module_name . "_" . $id . " a inner join " . $db_config['prefix'] . "_" . $module_name . "_pets b on calltime between " . $time . " and " . $next_week . " and a.petid = b.id inner join " . $db_config['prefix'] . "_" . $module_name . "_customers c on a.customerid = c.id";
	$result = $db->sql_query($sql);
	$vaccines = array();
	while($row = $db->sql_fetch_assoc($result)) {
		$vaccines[] = $row;
	}
	return $vaccines;
}
function getPatientsList() {
	global $db, $db_config, $module_name;
	$sql = "select b.name as petname, c.name as customer, c.phone as phone from " . $db_config['prefix'] . "_" . $module_name . "_pets b inner join " . $db_config['prefix'] . "_" . $module_name . "_customers c on b.customerid = c.id";
	$result = $db->sql_query($sql);
	$patients = array();
	while($row = $db->sql_fetch_assoc($result)) {
		$patients[] = $row;
	}
	return $patients;
}
?>
