<?php
/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES., JSC. All rights reserved
 * @Createdate 3/9/2010 23:25
 */

if (!defined('NV_MAINFILE'))
	die('Stop!!!');

if (!function_exists('nv_pro_catalogs1')) {
	function nv_block_config_product_catalogs1_blocks($module, $data_block, $lang_block) {
		global $db, $language_array, $db_config;
		$sh = $sv = "";
		if ($data_block['type'] == 'v') { $sv = "selected=\"selected\"";
			$sh = "";
		}
		if ($data_block['type'] == 'h') { $sh = "selected=\"selected\"";
			$sv = "";
		}
		$html = "";
		$html .= "<tr>";
		$html .= "	<td>" . $lang_block['cut_num'] . "</td>";
		$html .= "	<td><input type=\"text\" name=\"config_cut_num\" size=\"5\" value=\"" . $data_block['cut_num'] . "\"/></td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "	<td>" . $lang_block['type'] . "</td>";
		$html .= "	<td>
						<select name=\"config_type\">
							<option value=\"h\" " . $sh . ">Horizontal</option>
							<option value=\"v\" " . $sv . ">Vertical</option>
						</select>
					</td>";
		$html .= "</tr>";
		return $html;
	}

	function nv_block_config_product_catalogs1_blocks_submit($module, $lang_block) {
		global $nv_Request;
		$return = array();
		$return['error'] = array();
		$return['config'] = array();
		$return['config']['cut_num'] = $nv_Request -> get_int('config_cut_num', 'post', 0);
		$return['config']['type'] = $nv_Request -> get_string('config_type', 'post', 0);
		return $return;
	}

	function nv_pro_catalogs1($block_config) {
		global $home, $site_mods, $global_config, $module_config, $module_name, $module_info, $global_array_cat, $db, $db_config, $my_head, $array_cat_shops;
		$module = $block_config['module'];
		$mod_data = $site_mods[$module]['module_data'];
		$mod_file = $site_mods[$module]['module_file'];
		$block_tpl_name = "";
		if ($block_config['type'] == 'v')
			$block_tpl_name = "block.catalogsv.tpl";
		elseif ($block_config['type'] == 'h')
			$block_tpl_name = "block.catalogsh.tpl";
		$pro_config = $module_config[$module];
		$array_cat_shops = array();

		if (file_exists(NV_ROOTDIR . "/themes/" . $global_config['site_theme'] . "/modules/" . $mod_file . "/" . $block_tpl_name)) {
			$block_theme = $global_config['site_theme'];
		} else {
			$block_theme = "default";
		}
		if ($module != $module_name) 
		{
			$sql = "SELECT catid, image, icon, parentid, lev," . NV_LANG_DATA . "_title as title," . NV_LANG_DATA . "_alias as alias, viewcat, numsubcat, subcatid, numlinks, del_cache_time, " . NV_LANG_DATA . "_description, inhome, " . NV_LANG_DATA . "_keywords, who_view, groups_view FROM `" . $db_config['prefix'] . "_" . $mod_data . "_catalogs` ORDER BY `order` ASC";
			$list = nv_db_cache( $sql, 'catid', $module );
			foreach ( $list as $l )
			{
				$l['link'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module . "&amp;" . NV_OP_VARIABLE . "=" . $l['alias'] . "";
				$array_cat_shops[$l['catid']] = $l;
			}
		} 
		else 
		{
			$array_cat_shops = $global_array_cat;
		}
		if ($home != 1) {
			$style = '';
		} else {
			$style = 'style="display: block;"';
		}
		$xtpl = new XTemplate($block_tpl_name, NV_ROOTDIR . "/themes/" . $block_theme . "/modules/" . $mod_file);
		$xtpl -> assign('TEMPLATE', $block_theme);
		$xtpl -> assign('style', $style);
		$xtpl -> assign('ID', $block_config['bid']);
		$cut_num = $block_config['cut_num'];
		$html = "";
		$id = 1;
		foreach ($array_cat_shops as $cat) {
			if ($cat['parentid'] == 0) {
				if ($cat['inhome'] == '1') {
			    if($id%3==0)
				{$b = "nomar_r";}
				else{$b = ""; }
					$html .= "<li class=\"".$b."\">
          	<a href=\"" . $cat['link'] . "\" class=\"img_pro\"><img src=\"" . $cat['image'] . "\"/></a>
            <a href=\"" . $cat['link'] . "\" class=\"name_cat_home\">" . $cat['title'] . "</a>\n";
					if (!empty($cat['subcatid'])){
					   $html .= "<div class=\"sub_cat_home\">";
						$html .= html_viewsub1($cat['subcatid'], $block_config);
						$html .= "</div>";
						}
				$html .= " </li>\n";
				}
			$id++;
			}

		}
		$xtpl -> assign('CONTENT', $html);
		$xtpl -> parse('main');
		return $xtpl -> text('main');
	}

function html_viewsub1($list_sub, $block_config) {
		global $array_cat_shops;
		$cut_num = $block_config['cut_num'];
		if (empty($list_sub))
			return "";
		else {
			$html = " ";
			$list = explode(",", $list_sub);
			foreach ($list as $catid) {
				if ($array_cat_shops[$catid]['inhome'] == '1') {
				
					$html .= "<a href=\"" . $array_cat_shops[$catid]['link'] . "\">" . nv_clean60($array_cat_shops[$catid]['title'], $cut_num) . "</a>\n";
				//	if (!empty($array_cat_shops[$catid]['subcatid']))
					//	$html .= html_viewsub($array_cat_shops[$catid]['subcatid'], $block_config);
					
				}
			}
			$html .= " ";
			return $html;
		}
}
}
if (defined('NV_SYSTEM')) {
	global $site_mods;
	$module = $block_config['module'];
	$content = nv_pro_catalogs1($block_config);
}
?>