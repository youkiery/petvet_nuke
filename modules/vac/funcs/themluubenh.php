<?php

/**
 * @Project NUKEVIET-MUSIC
 * @Author Phan Tan Dung
 * @Copyright (C) 2011
 * @Createdate 26/01/2011 10:26 AM
 */

if (!defined('NV_IS_MOD_VAC')) die('Stop!!!');
$idthu = $nv_Request->get_string('idthu', 'post/get', '');
$ngayluubenh = $nv_Request->get_string('ngayluubenh', 'post', '');
$tinhtrang = $nv_Request->get_string('tinhtrang', 'post', '');
$idbacsi = $nv_Request->get_string('idbacsi', 'post', '');
$ghichu = $nv_Request->get_string('ghichu', 'post', '');
$customer = $nv_Request->get_string('customer', 'post', '');
$phone = $nv_Request->get_string('phone', 'post', '');
$address = $nv_Request->get_string('address', 'post', '');
$ret = array("status" => 0, "data" => "");
// var_dump(strlen($tinhtrang) > 0);
$ret["step"] = 1;
if ( ! ( empty($idthu) || empty($idbacsi) || empty($ngayluubenh) || strlen($tinhtrang) == 0) ) {
	$ret["step"] = 2;
  $sql = "select id from `" . $db_config['prefix'] . "_" . $module_data . "_pets` where id = $idthu";
	$result = $db->sql_query($sql);
  // $ret["data"] .= $sql;

	if ($db->sql_numrows($result)) {
		$ret["step"] = 3;
		$sql = "INSERT INTO `" . $db_config['prefix'] . "_" . $module_data . "_luubenh` (`idthucung`, `idbacsi`, `ngayluubenh`, `ketqua`) VALUES ($idthu, $idbacsi, ". strtotime($ngayluubenh) . ", 0)";
    // $ret["data"] .= $sql;
		$insert_id = $db->sql_query_insert_id($sql);
		$sql = "INSERT INTO `" . $db_config['prefix'] . "_" . $module_data . "_lieutrinh` (`idluubenh`, `nhietdo`, `niemmac`, `khac`, `dieutri`, `xetnghiem`, `hinhanh`, `ngay`, `tinhtrang`, `doctorx`) VALUES ($insert_id, '', '', '', '', 0, '', " . strtotime(date("Y-m-d")) . ", $tinhtrang, $idbacsi)";
		$query = $db->sql_query($sql);
		$ret["sql"] = $sql;

		// if ($sql) {
		if ($query) {
			$ret["step"] = 4;
      if (!empty($phone)) {
        $sql = "update `" . VAC_PREFIX . "_customers` set customer = '$customer', address = '$address' where phone = '$phone'";
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