<?php

if (!defined('NV_MAINFILE'))
	die('Stop!!!');

if (!nv_function_exists('nv_message_slider1')) {

	function nv_block_config_message_slider1_blocks($module, $data_block, $lang_block) {
		global $db, $language_array, $site_mods;
		$html = "";
		$html .= "<tr>";
		$html .= "	<td>" . $lang_block['blockid'] . "</td>";
		$html .= "	<td><select name=\"config_blockid\">\n";
		$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $site_mods[$module]['module_data'] . "_group` ORDER BY `weight` ASC";
		$list = nv_db_cache($sql, 'id', $module);
		foreach ($list as $l) {
			$sel = ($data_block['blockid'] == $l['id']) ? ' selected' : '';
			$html .= "<option value=\"" . $l['id'] . "\" " . $sel . ">" . $l['title'] . "</option>\n";
		}
		$html .= "	</select></td>\n";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "	<td>" . $lang_block['numrow'] . "</td>";
		$html .= "	<td><input type=\"text\" name=\"config_numrow\" size=\"5\" value=\"" . $data_block['numrow'] . "\"/></td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "	<td>" . $lang_block['widthimg'] . "</td>";
		$html .= "	<td><input type=\"text\" name=\"config_widthimg\" size=\"30\" value=\"" . $data_block['widthimg'] . "\"/></td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "	<td>" . $lang_block['heightimg'] . "</td>";
		$html .= "	<td><input type=\"text\" name=\"config_heightimg\" size=\"5\" value=\"" . $data_block['heightimg'] . "\"/></td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "	<td>" . $lang_block['temblock'] . "</td>";
		$html .= "	<td><select name=\"config_temblock\">\n";
		$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $site_mods[$module]['module_data'] . "_config` ORDER BY `weight` ASC";
		$list = nv_db_cache($sql, 'title', $module);
		foreach ($list as $l) {
			$sel = ($data_block['temblock'] == $l['title']) ? ' selected' : '';
			$html .= "<option value=\"" . $l['title'] . "\" " . $sel . ">" . $l['title'] . "</option>\n";
		}
		$html .= "	</select></td>\n";
		$html .= "</tr>";
		return $html;
	}

	function nv_block_config_message_slider1_blocks_submit($module, $lang_block) {
		global $nv_Request;
		$return = array();
		$return['error'] = array();
		$return['config'] = array();
		$return['config']['blockid'] = $nv_Request -> get_int('config_blockid', 'post', 0);
		$return['config']['numrow'] = $nv_Request -> get_int('config_numrow', 'post', 0);
		$return['config']['widthimg'] = $nv_Request -> get_int('config_widthimg', 'post', 0);
		$return['config']['heightimg'] = $nv_Request -> get_int('config_heightimg', 'post', 0);
		$return['config']['temblock'] = filter_text_input('config_temblock', 'post', 0);
		return $return;
	}

	function nv_message_slider1($block_config) {

		global $global_config, $site_mods, $db, $module_name;
		$module = $block_config['module'];
		$array_th = array();

		$sql = "SELECT * FROM `" . NV_PREFIXLANG . "_" . $site_mods['slider']['module_data'] . "` WHERE `idgroup`=" . $block_config['blockid'] . " ORDER BY `weight` ASC LIMIT 0 , " . $block_config['numrow'];
		
		$array_th = nv_db_cache($sql, 'slider_title', $module);

		if (file_exists(NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/slider/block." . $block_config['temblock'] . ".tpl")) {
			$block_theme = $global_config['module_theme'];
		} elseif (file_exists(NV_ROOTDIR . "/themes/" . $global_config['site_theme'] . "/modules/slider/block." . $block_config['temblock'] . ".tpl")) {
			$block_theme = $global_config['site_theme'];
		} else {
			$block_theme = "default";
		}

		$xtpl = new XTemplate("block." . $block_config['temblock'] . ".tpl", NV_ROOTDIR . "/themes/" . $block_theme . "/modules/slider");

		$xtpl -> assign('TEMPLATE', $block_theme);
    $i=1;
		$base_url_site = NV_BASE_SITEURL . "?";
		foreach ($array_th as $row) {
			$row['bodytext'] = nv_clean60($row['bodytext'], 500);
			$row['width'] = $block_config['widthimg'];
			$row['height'] = $block_config['heightimg'];
			if($i==1){
			$xtpl -> assign('active', "active");
			
			}
			else{$xtpl -> assign('active', "");
			}
			$xtpl -> assign('ROW', $row);
			//print_r($row);
			//die('r');
			$xtpl -> parse('main.loop');
			$i++;
		}
		$xtpl -> parse('main');
		return $xtpl -> text('main');
	}

}

if (defined('NV_SYSTEM')) {
	$content = nv_message_slider1($block_config);
}
?>