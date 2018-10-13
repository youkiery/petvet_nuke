<?php

if (!defined('NV_IS_FILE_ADMIN'))
	die('Stop!!!');

$id = $nv_Request -> get_int('id', 'post,get', 0);

if ($id) {

	$query = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_group` WHERE `id`=" . $id;

	$result = $db -> sql_query($query);

	$numrows = $db -> sql_numrows($result);

	if (empty($numrows)) {

		Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name);

		die();

	}

	$row = $db -> sql_fetchrow($result);

	define('IS_EDIT', true);

	$page_title = $lang_module['group_slider05'];

	$action = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&amp;id=" . $id;

} else {

	$page_title = $lang_module['group_slider04'];

	$action = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op;

}

$error = "";

if (defined('NV_EDITOR')) {

	require_once (NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php');

}

if ($nv_Request -> get_int('save', 'post') == '1') {

	$title = filter_text_input('title', 'post', '', 1);
	$description = filter_text_input('description', 'post', '', 1);

	if (empty($title)) {

		$error = $lang_module['group_slider07'];

	} else {

		if (defined('IS_EDIT')) {

			$query = "UPDATE`" . NV_PREFIXLANG . "_" . $module_data . "_group` SET 

            `title` =  " . $db -> dbescape($title) . ",
            `description` =  " . $db -> dbescape($description) . " 
			WHERE `id` =" . $id;

		} else {

			list($weight) = $db -> sql_fetchrow($db -> sql_query("SELECT MAX(`weight`) FROM `" . NV_PREFIXLANG . "_" . $module_data . "_group`"));

			$weight = intval($weight) + 1;

			$query = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "_group` VALUES (NULL, " . $db -> dbescape($title) . "," . $db -> dbescape($description) . "," . $weight . ");";

		}

		$db -> sql_query($query);

		nv_del_moduleCache($module_name);

		if ($db -> sql_affectedrows() > 0) {

			if (defined('IS_EDIT')) {

				nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['log_edit_nsupport'], "nsupportid " . $id, $admin_info['userid']);

			} else {

				nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['log_add_nsupport'], " ", $admin_info['userid']);

			}

			Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=main");

			die();

		} else {

			$error = $lang_module['group_slider08'];

		}

	}

} else {

	if (defined('IS_EDIT')) {

		$title = $row['title'];
		$description = $row['description'];

	} else {

		$title = "";
		$description = "";

	}

}
$xtpl = new XTemplate("group_content.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_name);
$xtpl -> assign('LANG', $lang_module);
$xtpl -> assign('ROW', $row);
$xtpl -> assign('ACTION', $action);
if (!empty($error)) {
	$xtpl -> assign('ERR', $error);
	$xtpl -> parse('main.error');

}

$xtpl -> parse('main');
$contents = $xtpl -> text('main');

include (NV_ROOTDIR . "/includes/header.php");

echo nv_admin_theme($contents);

include (NV_ROOTDIR . "/includes/footer.php");
?>