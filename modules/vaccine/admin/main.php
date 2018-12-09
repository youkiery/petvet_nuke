<?php
/**
* @Project NUKEVIET-MUSIC
* @Phan Tan Dung (phantandung92@gmail.com)
* @Copyright (C) 2011
* @Createdate 26-01-2011 14:43
*/

if ( ! defined( 'NV_IS_QUANLY_ADMIN' ) ) die( 'Stop!!!' );
$page_title = "Trang chính";

$contents = "Xin chào các bạn";

include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
?>