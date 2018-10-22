<?php
/**
* @Project NUKEVIET-MUSIC
* @Author Phan Tan Dung
* @Copyright (C) 2011
* @Createdate 26/01/2011 10:26 AM
*/

if ( ! defined( 'NV_IS_MOD_QUANLY' ) ) die( 'Stop!!!' );
$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];

$contents = "Xin chào các bạn";

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );
?>