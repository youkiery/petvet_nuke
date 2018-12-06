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
if ( ! ( empty($idthu) || empty($idbacsi) || empty($ngayluubenh) || strlen($tinhtrang) == 0) ) {
  $sql = "select id from `" . VAC_PREFIX . "_pets` where id = $idthu";
	$result = $db->sql_query($sql);
  // $ret["data"] .= $sql;

	if ($db->sql_numrows($result)) {
		$sql = "INSERT INTO `" . VAC_PREFIX . "_luubenh` (`idthucung`, `idbacsi`, `ngayluubenh`, `ketqua`) VALUES ($idthu, $idbacsi, ". strtotime($ngayluubenh) . ", 1)";
    // $ret["data"] .= $sql;
		$insert_id = $db->sql_query_insert_id($sql);

		// if ($sql) {
		if ($insert_id) {
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