<?php

/**
 * @Project NUKEVIET-MUSIC
 * @Author Phan Tan Dung
 * @Copyright (C) 2011
 * @Createdate 26/01/2011 10:26 AM
 */

if (!defined('NV_IS_MOD_VAC')) die('Stop!!!');
$idthu = $nv_Request->get_string('idthu', 'post/get', '');
$ngaysieuam = $nv_Request->get_string('ngaysieuam', 'post', '');
$ngaydusinh = $nv_Request->get_string('ngaydusinh', 'post', '');
$ngaythongbao = $nv_Request->get_string('ngaythongbao', 'post', '');
$hinhanh = $nv_Request->get_string('hinhanh', 'post', '');
$idbacsi = $nv_Request->get_string('idbacsi', 'post', '');
$ghichu = $nv_Request->get_string('ghichu', 'post', '');
$ret = array("status" => 0, "data" => array());
// var_dump($_POST);

if ( ! ( empty($idthu) || empty($idbacsi) || empty($ngaysieuam) || empty($ngaydusinh) || empty($hinhanh) ) ) {
	$sql = "select id from `" . $db_config['prefix'] . "_" . $module_data . "_pets` where id = $idthu";
	$result = $db->sql_query($sql);

	if ($db->sql_numrows($result)) {
		$sql = "INSERT INTO `" . $db_config['prefix'] . "_" . $module_data . "_sieuam` (`idthucung`, `idbacsi`, `ngaysieuam`, `ngaydusinh`, `ngaybao`, `hinhanh`, `trangthai`, `ghichu`) VALUES ($idthu, $idbacsi, ". strtotime($ngaysieuam) .", ". strtotime($ngaydusinh) .", ". strtotime($ngaythongbao) .", '$hinhanh', 0, '$ghichu')";
		$insert_id = $db->sql_query_insert_id($sql);

		// if ($sql) {
		if ($insert_id) {
			$ret["status"] = 1;
			$ret["data"] = $lang_module["themsatc"];
		}
	}
}

if (!$ret["status"]) {
	$ret["data"] = $lang_module["themsatb"];
}

echo json_encode($ret);
die();
?>