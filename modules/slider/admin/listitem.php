<?php

if (!defined('NV_IS_FILE_ADMIN'))
	die('Stop!!!');

$page_title = $lang_module['slider0'];
$idgroup = $nv_Request -> get_int('idgroup', 'get', 0);
global $db, $db_config, $lang_module, $lang_global, $module_name, $module_data;
$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `idgroup` = " . $idgroup . " ORDER BY `weight` ASC";
$result = $db -> sql_query($sql);
$num = $db -> sql_numrows($result);
$arr_table = array();
$i = 0;
while ($row = $db -> sql_fetchrow($result)) {
	$sqls = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `id` = " . $row['id'];
	$results = $db -> sql_query($sqls);
	$rows = $db -> sql_fetchrow($results);
	$row['bodytext'] = nv_clean60($row['bodytext'], 90);
	$linkedit = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=content&amp;id=" . $row['id'];
	$arr_table[$row['id']] = array('weight' => $row['weight'], 'idgroup' => $row['idgroup'], 'title' => $row['title'], 'links' => $row['links'], 'images' => $row['images'], 'id' => $row['id'], 'bodytext' => $row['bodytext'], 'linkedit' => $linkedit);
}
$xtpl = new XTemplate("listitem.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_name);
$xtpl -> assign('LANG', $lang_module);
$xtpl -> assign('LANG2', $lang_global);
$xtpl -> assign('LINK_ADD', NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=content&idgroup=".$idgroup);

if (!empty($arr_table)) {
	$a = 0;
	foreach ($arr_table as $rows) {
		$rows['class'] = (++$a % 2 == 0) ? ' class="second"' : '';
		for ($i = 1; $i <= $num; ++$i) {
			if ($i == $rows['weight']) {
				$xtpl -> assign('select', 'selected="selected"');
			} else {
				$xtpl -> assign('select', '');
			}
			$xtpl -> assign('stt', $i);
			$xtpl -> parse('main.table.loop1.weight');
		}
		$xtpl -> assign('ROW', $rows);
		$xtpl -> parse('main.table.loop1');
	}
	$xtpl -> parse('main.table');
} else {
	Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=content&idgroup=".$idgroup);
	die();
}
$link_menu = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name;
$xtpl -> assign('link_menu', $link_menu);
$xtpl -> parse('main');
$contents = $xtpl -> text('main');

include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
?>