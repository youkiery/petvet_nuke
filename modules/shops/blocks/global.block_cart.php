<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES., JSC. All rights reserved
 * @Createdate 3/25/2010 18:6
 */
if (!defined('NV_MAINFILE'))
	die('Stop!!!');

if (!function_exists('nv_cart_info')) {
	function nv_cart_info($block_config) {
		$module = $block_config['module'];
		$bid = $block_config['bid'];
		$content = '
			<div id="cart_' . $module . '"></div>
		    <script language="javascript" type="text/javascript">
			$("#cart_' . $module . '").load(\'' . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module . "&" . NV_OP_VARIABLE . "=loadcart" . '\');
			</script>
        ';
		return $content;
	}

}
if (defined('NV_SYSTEM')) {
	$content = nv_cart_info($block_config);
}
?>