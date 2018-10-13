<?php

/**
 * @Project Archives OF NUKEVIET 3.x
 * @Author PCD-GROUP (contact@dinhpc.com)
 * @Copyright (C) 2011 PCD-GROUP. All rights reserved
 * @Createdate July 27, 2011  11:24:58 AM
 */

if (!defined('NV_MAINFILE'))
	die('Stop!!!');

if (!nv_function_exists('nv_xembaomoi_ads')) {

	function nv_block_config_ads_blocks($module, $data_block, $lang_block) {
		global $db, $language_array, $site_mods;
		$html = "";
		$html .= "<tr>";
		$html .= "	<td>Số hàng hiển thị sản phẩm</td>";
		$html .= "	<td><input type=\"text\" name=\"config_numrow\" size=\"5\" value=\"" . $data_block['numrow'] . "\"/></td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "	<td>Sản phẩm trên 1 hàng</td>";
		$html .= "	<td><input type=\"text\" name=\"config_numcol\" size=\"5\" value=\"" . $data_block['numcol'] . "\"/></td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "	<td>Chiều dài</td>";
		$html .= "	<td><input type=\"text\" name=\"config_height\" size=\"5\" value=\"" . $data_block['height'] . "\"/>px</td>";
		$html .= "</tr>";
		return $html;
	}

	function nv_block_config_ads_blocks_submit($module, $lang_block) {
		global $nv_Request;
		$return = array();
		$return['error'] = array();
		$return['config'] = array();
		$return['config']['numrow'] = $nv_Request -> get_int('config_numrow', 'post', 0);
		$return['config']['numcol'] = $nv_Request -> get_int('config_numcol', 'post', 0);
		$return['config']['height'] = $nv_Request -> get_int('config_height', 'post', 0);
		return $return;
	}

	function nv_xembaomoi_ads($block_config) {
		global $global_config;
		if (file_exists(NV_ROOTDIR . "/themes/" . $global_config['site_theme'] . "/blocks/global.xembaomoi.tpl")) {
			$block_theme = $global_config['site_theme'];
		} else {
			$block_theme = "default";
		}
		$xtpl = new XTemplate("global.xembaomoi.tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/blocks");
		$xtpl -> assign('NROW', $block_config['numrow']);
		$xtpl -> assign('NCOL', $block_config['numcol']);
		$xtpl -> assign('HEIG', $block_config['height']);
		$xtpl -> parse('main');
		return $xtpl -> text('main');
	}

}

if (defined('NV_SYSTEM')) {
	$content = nv_xembaomoi_ads($block_config);
}
?>