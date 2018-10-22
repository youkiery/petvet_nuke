<?php

/**
* @Project NUKEVIET-MUSIC
* @Author Phan Tan Dung (phantandung92@gmail.com)
* @Copyright 2011
* @createdate 26/01/2011 10:08 AM
*/

if (!defined( 'NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN')) die('Stop!!!'); 
require_once NV_ROOTDIR . "/modules/" . $module_name . '/global.functions.php';

$submenu['customer'] = $lang_module["customer_title"];
$submenu['patient'] = $lang_module["patient_title3"];
$submenu['disease'] = $lang_module["disease_title"];

$allow_func = array('main', "disease", "patient", "customer"); 
define('NV_IS_VAC_ADMIN', true);
?>