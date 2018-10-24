<?php
/**
* @Project NUKEVIET-MUSIC
* @Author Phan Tan Dung
* @Copyright (C) 2011
* @Createdate 26/01/2011 10:26 AM
*/

if ( ! defined( 'NV_IS_MOD_VAC' ) ) die( 'Stop!!!' );

$page_default = true;
if (!empty($array_op[0])) {
	$page = $array_op[0];
	$page_allowed = array(
		"list"
	);
	if(in_array($page, $page_allowed)) {
		$page_default = false;
		require_once ( NV_ROOTDIR . "/modules/" . $module_file . "/funcs/$page.php" );
	}
}
if ($page_default) {
	$page_title = $module_info['custom_title'];
	$key_words = $module_info['keywords'];

	$xtpl = new XTemplate("main.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file);
	$xtpl->assign("lang", $lang_module);
	$xtpl->assign("now", date("Y-m-d", NV_CURRENTTIME));
	// note: nexttime take from config
	$xtpl->assign("calltime", date("Y-m-d", NV_CURRENTTIME + 14 * 24 * 60 * 60));

	$diseases = getDiseaseList();
	foreach ($diseases as $key => $value) {
		$xtpl->assign("disease_id", $value["id"]);		
		$xtpl->assign("disease_name", $value["name"]);	
		$xtpl->parse("main.option");	
	}
}

$xtpl->parse("main");
$contents = $xtpl->text("main");

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );
?>
