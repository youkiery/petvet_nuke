<?php

/**

 * @Author VINAGON CO.,LTD (info@vinagon.com)

 * @Copyright (C) 2012 VINAGON CO.,LTD. All rights reserved

 * @Createdate 29/04/2012 23:25

 */

if (!defined('NV_MAINFILE'))
	die('Stop!!!');

if (!nv_function_exists('nv_global_slider_product')) {
	function nv_global_slider_product($block_config) {
		global $global_config, $db;
		$xtpl = new XTemplate("gloabl_slider_product.tpl", NV_ROOTDIR . "/themes/" . $global_config['site_theme'] . "/modules/shops");
		$xtpl -> assign('TEMPLATE', $global_config['site_theme']);
		$xtpl -> parse('main');
		return $xtpl -> text('main');

	}

}

if (defined('NV_SYSTEM')) {
	$content = nv_global_slider_product($block_config);
}
?>