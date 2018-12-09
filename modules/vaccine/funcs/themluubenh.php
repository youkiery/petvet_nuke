<?php

/**
 * @Project NUKEVIET-MUSIC
 * @Author Phan Tan Dung
 * @Copyright (C) 2011
 * @Createdate 26/01/2011 10:26 AM
 */

if (!defined('NV_IS_MOD_QUANLY')) die('Stop!!!');
$petid = $nv_Request->get_string('petid', 'post/get', '');
$ngayluubenh = $nv_Request->get_string('ngayluubenh', 'post', '');
$tinhtrang = $nv_Request->get_string('tinhtrang', 'post', '');
$doctorid = $nv_Request->get_string('doctorid', 'post', '');
$note = $nv_Request->get_string('note', 'post', '');
$customer = $nv_Request->get_string('customer', 'post', '');
$phone = $nv_Request->get_string('phone', 'post', '');
$address = $nv_Request->get_string('address', 'post', '');
$ret = array("status" => 0, "data" => "");
// var_dump(strlen($tinhtrang) > 0);
$ret["step"] = 1;
if ( ! ( empty($petid) || empty($doctorid) || empty($ngayluubenh) || strlen($tinhtrang) == 0) ) {
	$ret["step"] = 2;
  $sql = "select id from `" . VAC_PREFIX . "_pet` where id = $petid";
	$result = $db->sql_query($sql);
  // $ret["data"] .= $sql;

	if ($db->sql_numrows($result)) {
		$ret["step"] = 3;
		$sql = "INSERT INTO `" . VAC_PREFIX . "_treat` (`petid`, `doctorid`, `ngayluubenh`, `ketqua`) VALUES ($petid, $doctorid, ". strtotime($ngayluubenh) . ", 0)";
    // $ret["data"] .= $sql;
		$insert_id = $db->sql_query_insert_id($sql);
		$sql = "INSERT INTO `" . VAC_PREFIX . "_treating` (`idluubenh`, `nhietdo`, `niemmac`, `khac`, `dieutri`, `xetnghiem`, `image`, `ngay`, `tinhtrang`, `doctorx`) VALUES ($insert_id, '', '', '', '', 0, '', " . strtotime(date("Y-m-d")) . ", $tinhtrang, $doctorid)";
		$query = $db->sql_query($sql);
		$ret["sql"] = $sql;

		// if ($sql) {
		if ($query) {
			$ret["step"] = 4;
      if (!empty($phone)) {
        $sql = "update `" . VAC_PREFIX . "_customer` set name = '$customer', address = '$address' where phone = '$phone'";
        $db->sql_query($sql);
      }
      $ret["status"] = 1;
			$ret["data"] .= $lang_module["themsatc"];
		}
	}
}

// if (!$ret["status"]) {
// 	$ret["data"] .= $lang_module["themsatb"];
// }

echo json_encode($ret);
die();
?>