<?php

if ( ! defined( 'NV_ADMIN' ) or ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

$module_version = array( 
    "name" => "Slider", // Tieu de module
	"modfuncs" => "main", // Cac function co block
	"is_sysmod" => 0, // 1:0 => Co phai la module he thong hay khong
	"virtual" => 1, // 1:0 => Co cho phep ao hao module hay khong
	"version" => "3.4.01", // Phien ban cua modle
	"date" => "Sun, 05 Feb 2012 00:00:00 GMT", // Ngay phat hanh phien ban
	"author" => "VinaGon (info@vinagon.com)", // Tac gia
	"note"=>"", "uploads_dir"=>array($module_name, $module_name . "/", $module_name . "/thumb", $module_name . "/tmp"));

?>