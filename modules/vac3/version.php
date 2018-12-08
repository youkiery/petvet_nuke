<?php

/**
 * @Project TXManager
 * @Author Youkiery (youkiery@gmail.com)
 * @copyright 2018
 * @createdate 01/11/2018 08:00 AM
 */

if ( ! defined( 'NV_ADMIN' ) or ! defined( 'NV_MAINFILE' )) die( 'Stop!!!' );

$module_version = array( 
	"name" => "vac", // Tieu de module
	"modfuncs" => "process, main, main-process, main-list, usg, usg-process, usg-list, treat, treat-process, treat-list, sieuam, danhsachsieuam, themsieuam, xacnhansieuam, luubenh, danhsachluubenh, themluubenh, xuatbang",
	"is_sysmod" => 0,
	"virtual" => 1,
	"version" => "3.0.01",
	"date" => "Wed, 26 Jan 2011 12:47:15 GMT",
	"author" => "PHAN TAN DUNG (email: phantandung1912@gmail.com)",
	"note"=>"",
	"uploads_dir" => array(
		$module_name
	)
);
?>