<?php
/**
 ** @Project: NUKEVIET SUPPORT ONLINE
 ** @Author: Viet Group (vietgroup.biz@gmail.com)
 ** @Copyright: VIET GROUP
 ** @Craetdate: 19.08.2011
 ** @Website: http://vietgroup.biz
 */

if (!defined('NV_MAINFILE'))
	die('Stop!!!');

if (!nv_function_exists('nv_global_support')) {
	function nv_global_support($block_config) {
		global $global_config, $db;
		if (file_exists(NV_ROOTDIR . "/themes/" . $global_config['site_theme'] . "/modules/support/global_support.tpl")) {
			$block_theme = $global_config['site_theme'];
		} else {
			$block_theme = "default";
		}
		$module = $block_config['module'];
		$xtpl = new XTemplate("global_support.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/support");
		$xtpl -> assign('TEMPLATE', $block_theme);
		$base_url_site = NV_BASE_SITEURL . "?";
		$res_tr = "SELECT * FROM `" . NV_PREFIXLANG . "_support_group` ORDER BY `weight`";
		$list = nv_db_cache( $res_tr, '_support_group', $module );
		foreach ( $list as $rows )
		{
			$xtpl -> assign('ROWS', $rows);
			$id = $rows['id'];
			$str_res = "SELECT * FROM `" . NV_PREFIXLANG . "_support` where idgroup='$id' ORDER BY `weight` ASC";
			$list_res = nv_db_cache( $str_res , '_support_group2', $module );
			foreach ( $list_res as $row )
		    {
				$skype_item_sub = trim($row['skype_item']);
				$skype_type_sub = trim($row['skype_type']);
				$yahoo_item_sub = trim($row['yahoo_item']);
				$yahoo_type_sub = intval($row['yahoo_type']);
				$xtpl -> assign('TITLE', $row['title']);
				$xtpl -> assign('PHONE', $row['phone']);
				$xtpl -> assign('EMAIL', $row['email']);
				$xtpl -> assign('SKITEM', $skype_item_sub);
				$xtpl -> assign('SKTYPE', $skype_type_sub);
				$xtpl -> assign('YHITEM', $yahoo_item_sub);
				$xtpl -> assign('YHTYPE', $yahoo_type_sub);
				if (!empty($skype_item_sub)) {
					$xtpl -> parse('main.loop2.icon.iconskype');
					$xtpl -> parse('main.loop.icon.iconskype');
				}
				if (!empty($yahoo_item_sub)) {
					$xtpl -> parse('main.loop2.icon.iconyahoo');
					$xtpl -> parse('main.loop.icon.iconyahoo');
				}
				$xtpl -> parse('main.loop2.icon');
				$xtpl -> parse('main.loop.icon');
			}
			$xtpl -> parse('main.loop2');
			$xtpl -> parse('main.loop');
		}
		$xtpl -> parse('main');
		return $xtpl -> text('main');
	}

}

if (defined('NV_SYSTEM')) {
	$content = nv_global_support( $block_config );
}
?>