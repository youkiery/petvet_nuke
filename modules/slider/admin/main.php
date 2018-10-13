<?php
/**
 ** @Project: NUKEVIET SUPPORT ONLINE
 ** @Author: Viet Group (vietgroup.biz@gmail.com)
 ** @Copyright: VIET GROUP
 ** @Craetdate: 19.08.2011
 ** @Website: http://vietgroup.biz
 */

if (!defined('NV_IS_FILE_ADMIN'))
	die('Stop!!!');

$page_title = $lang_module['group_slider06'];
global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data;
$xtpl = new XTemplate("main.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_name);
$xtpl -> assign('LANG', $lang_module);
$xtpl -> assign('LANG2', $lang_global);
$xtpl -> assign('LINK_ADD', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=group_content");
$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_group` ORDER BY `weight` ASC";
$result = $db -> sql_query($sql);
$num = $db -> sql_numrows($result);
if ($num > 0) {
	$a = 0;
	while ($row = $db -> sql_fetchrow($result)) {
		$class = ($a % 2) ? " class=\"second\"" : "";
		$xtpl -> assign('LINK_EDIT', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=group_content&amp;id=" . $row['id']);
		$xtpl -> assign('LINK_VIEW', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=listitem&amp;idgroup=" . $row['id']);
		$xtpl -> assign('CLASS', $class);
		$xtpl -> assign('ROW', $row);
		$xtpl -> parse('main.row');
		$a++;
	}

} else {
	Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=group_content");
	die();
}

$xtpl -> parse('main');
$contents = $xtpl -> text('main');

include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
?>