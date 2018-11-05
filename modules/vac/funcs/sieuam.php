<?php

/**
 * @Project NUKEVIET-MUSIC
 * @Author Phan Tan Dung
 * @Copyright (C) 2011
 * @Createdate 26/01/2011 10:26 AM
 */

if (!defined('NV_IS_MOD_VAC')) die('Stop!!!');
$action = $nv_Request->get_string('action', 'post', '');

if (!empty($action)) {

	die();
}

$xtpl = new XTemplate("sieuam.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
$xtpl->assign("lang", $lang_module);

$today = date("Y-m-d", NV_CURRENTTIME);
$dusinh = $global_config["dusinh"];
if (empty($dusinh)) {
	$dusinh = 45 * 24 * 60 * 60;
}
$thongbao = $global_config["thongbao"];
if (empty($thongbao)) {
	$thongbao = 45 * 24 * 60 * 60;
}
// echo $thongbao; die();

$xtpl->assign("now", $today);
$xtpl->assign("dusinh", date("Y-m-d", strtotime($today) + $dusinh));
$xtpl->assign("thongbao", date("Y-m-d", strtotime($today) + $thongbao));

$xtpl->parse("main");

$contents = $xtpl->text("main");
include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme($contents);
include ( NV_ROOTDIR . "/includes/footer.php" );

?>