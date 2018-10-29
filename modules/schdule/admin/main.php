<?php
/**
* @Project NUKEVIET-MUSIC
* @Author Youkiery
* @copyright 2018
* @createdate 29/10/2018 09:17
*/

if (!defined('NV_IS_SCHDULE_ADMIN')) die('Stop!!!');
$page_title = $lang_module["main_title"];

include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");
?>