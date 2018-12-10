<?php

/**
* @Project NUKEVIET-MUSIC
* @Author Phan Tan Dung (phantandung92@gmail.com)
* @Copyright 2011
* @createdate 26/01/2011 10:08 AM
*/

if ( ! defined( 'NV_ADMIN' ) or ! defined( 'NV_MAINFILE' ) or ! defined( 'NV_IS_MODADMIN' ) ) die( 'Stop!!!' ); 

$submenu['customer'] = $lang_module["customer_title"];
$submenu['patient'] = $lang_module["patient_title3"];
$submenu['disease'] = $lang_module["disease_title"];
$submenu['doctor'] = $lang_module["doctor_title"];
$submenu['sieuam'] = $lang_module["tieude_usg"];
$submenu['treat'] = $lang_module["treat_title"];
$submenu['config'] = $lang_module["doctor_config"];

$allow_func = array('main', "disease", "patient", "customer", "doctor", "sieuam", "treat", "config"); 
define( 'NV_IS_QUANLY_ADMIN', true );
require_once ( NV_ROOTDIR . "/modules/" . $module_file . "/global.functions.php" );
?>