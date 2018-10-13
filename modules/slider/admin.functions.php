<?php

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN'))
	die('Stop!!!');

$submenu['config'] = $lang_module['config_slider'];

$allow_func = array('listitem', 'list', 'content', 'del_group', 'main', 'group_content', 'alias', 'change_status', 'change_weight', 'list_group', 'del', 'config', 'config_content', 'del_config');

function nv_fix_weight_group($gid = 0) {

	global $db, $db_config, $module_data;

	$sqlg = "SELECT `id` FROM `" . NV_PREFIXLANG . "_" . $module_data . "_group` ORDER BY `weight` ASC";

	$resultg = $db -> sql_query($sqlg);

	$array_weight_g = array();

	while ($rowg = $db -> sql_fetchrow($resultg)) {

		$array_weight_g[] = $rowg['id'];

	}

	$db -> sql_freeresult();

	$weight = 0;

	foreach ($array_weight_g as $groupid) {

		$gid++;

		$weight++;

		$sql = "UPDATE `" . NV_PREFIXLANG . "_" . $module_data . "_group` SET `weight` = " . $weight . " WHERE `id` = " . $groupid . "";

		$db -> sql_query($sql);

	}

	return $gid;

}

define('NV_IS_FILE_ADMIN', true);
?>