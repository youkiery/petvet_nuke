<?php

/**
* @Project NUKEVIET-MUSIC
* @Author Youkiery
* @copyright 2018
* @createdate 29/10/2018 09:17
*/

if (!defined( 'NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN')) die('Stop!!!'); 
require_once NV_ROOTDIR . "/modules/" . $module_name . '/global.functions.php';

// $submenu['customer'] = $lang_module["customer_title"];

$allow_func = array('main'); 
define('NV_IS_SCHDULE_ADMIN', true);
?>
