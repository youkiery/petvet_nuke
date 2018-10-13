<?php

if (!defined('NV_IS_FILE_ADMIN'))
	die('Stop!!!');

$id = $nv_Request -> get_int('id', 'post,get', 0);
$idgroup = $nv_Request -> get_int('idgroup', 'post,get', 0);
if ($id) {
	$query = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `id`=" . $id;
	$result = $db -> sql_query($query);
	$numrows = $db -> sql_numrows($result);
	if (empty($numrows)) {
		Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name);
		die();
	}
	$row = $db -> sql_fetchrow($result);
	define('IS_EDIT', true);
	$page_title = $lang_module['slider12'];
	$action = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op . "&amp;id=" . $id;
} else {
	$page_title = $lang_module['slider1'];
	$action = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op;
}

$error = "";

if (defined('NV_EDITOR')) {
	require_once (NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php');
}

if ($nv_Request -> get_int('save', 'post') == '1') {
	$title = filter_text_input('title', 'post', '', 1);
	$idgroup = $nv_Request -> get_int('idgroup', 'post', 0);
	$alias = filter_text_input('alias', 'post', '', 1);
	$images = filter_text_input('images', 'post', '', 1);
	$links = filter_text_input('links', 'post', '', 1);
	$bodytext = nv_editor_filter_textarea('bodytext', '', NV_ALLOWED_HTML_TAGS);

	if (empty($title)) {
		$error = $lang_module['slider9'];
	} elseif (strip_tags($images) == "") {
		$error = $lang_module['slider13'];
	} elseif (strip_tags($links) == "") {
		$error = $lang_module['slider17'];
	} elseif (strip_tags($bodytext) == "") {
		$error = $lang_module['slider10'];
	} else {

		$bodytext = nv_editor_nl2br($bodytext);
		$alias = empty($alias) ? change_alias($title) : change_alias($alias);

		if (defined('IS_EDIT')) {
			$query = "UPDATE`" . NV_PREFIXLANG . "_" . $module_data . "` SET 
            `idgroup` = " . $db -> dbescape($idgroup) . ", 
			`title`=" . $db -> dbescape($title) . ", 
			`alias` =  " . $db -> dbescape($alias) . ", 
			`images`=" . $db -> dbescape($images) . ", 
			`links`=" . $db -> dbescape($links) . ", 
            `bodytext`=" . $db -> dbescape($bodytext) . ", `keywords`='', `edit_time`=" . NV_CURRENTTIME . " WHERE `id` =" . $id;
		} else {
			list($weight) = $db -> sql_fetchrow($db -> sql_query("SELECT MAX(`weight`) FROM `" . NV_PREFIXLANG . "_" . $module_data . "` WHERE `idgroup`=" . $db -> dbescape($idgroup)));
			$weight = intval($weight) + 1;

			$query = "INSERT INTO `" . NV_PREFIXLANG . "_" . $module_data . "` VALUES (
            NULL, 
			" . $db -> dbescape($idgroup) . ",
			" . $db -> dbescape($title) . ", 
			" . $db -> dbescape($alias) . ", 
			" . $db -> dbescape($images) . ", 
			" . $db -> dbescape($links) . ", 
			" . $db -> dbescape($bodytext) . ", 
			'', 
            " . $weight . ", " . $admin_info['admin_id'] . ", " . NV_CURRENTTIME . ", " . NV_CURRENTTIME . ", 1);";
		}
		$db -> sql_query($query);
		nv_del_moduleCache($module_name);
		if ($db -> sql_affectedrows() > 0) {
			if (defined('IS_EDIT')) {
				nv_insert_logs(NV_LANG_DATA, $module_name, 'log_edit_about', "aboutid " . $id, $admin_info['userid']);
			} else {
				nv_insert_logs(NV_LANG_DATA, $module_name, 'log_add_about', " ", $admin_info['userid']);
			}
			Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=listitem&idgroup=" . $idgroup);
			die();
		} else {
			$error = $lang_module['errorsave'];
		}
	}
} else {
	if (defined('IS_EDIT')) {
		$title = $row['title'];
		$idgroup = $row['idgroup'];
		$alias = $row['alias'];
		$images = $row['images'];
		$links = $row['links'];
		$bodytext = nv_editor_br2nl($row['bodytext']);
	} else {
		$title = $alias = $images = $links = $bodytext = "";
	}
}

if (!empty($bodytext))
	$bodytext = nv_htmlspecialchars($bodytext);

$xtpl = new XTemplate("content.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_name);
$xtpl -> assign('LANG', $lang_module);
$xtpl -> assign('ROW', $row);
$xtpl -> assign('MODULE_NAME', $module_name);
if (!empty($error)) {
	$xtpl -> assign('ERR', $error);
	$xtpl -> parse('main.error');
}
$sqls = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $module_data . "_group`";
$results = $db -> sql_query($sqls);
if ($db -> sql_numrows($results) == 0) {Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=group_content");
	die();
}
while ($rows = mysql_fetch_array($results)) {
	if ($rows['id'] == $idgroup) {
		$xtpl -> assign('select', 'selected="selected"');
	} else {
		$xtpl -> assign('select', '');
	}
	$xtpl -> assign('ROWS', $rows);
	$xtpl -> parse('main.group');
}

if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
	$edits = nv_aleditor("bodytext", '100%', '300px', $bodytext);
} else {
	$edits = "<textarea style=\"width:100%;height:300px\" name=\"bodytext\" id=\"bodytext\">" . $bodytext . "</textarea>";
}
$xtpl -> assign('edit_bodytext', $edits);
$xtpl -> parse('main');
$contents = $xtpl -> text('main');

include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
?>